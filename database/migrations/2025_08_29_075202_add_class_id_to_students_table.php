<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Classes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, add the class_id column
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('class_id')->nullable()->after('address')->constrained('classes')->onDelete('set null');
        });

        // Migrate existing data from 'class' string to 'class_id' foreign key
        $this->migrateClassData();

        // Remove the old 'class' column
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the 'class' column
        Schema::table('students', function (Blueprint $table) {
            $table->string('class')->after('address');
        });

        // Migrate data back from class_id to class string
        $this->migrateClassDataBack();

        // Drop the class_id column
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
        });
    }

    /**
     * Migrate existing class string data to class_id foreign key
     */
    private function migrateClassData()
    {
        // Get all students with class data
        $students = DB::table('students')->whereNotNull('class')->get();

        foreach ($students as $student) {
            // Try to find matching class by name
            $class = DB::table('classes')->where('name', $student->class)->first();
            
            if ($class) {
                // Update student with class_id
                DB::table('students')
                    ->where('id', $student->id)
                    ->update(['class_id' => $class->id]);
            } else {
                // Parse class name to extract level and program
                $className = $student->class;
                $level = '10'; // default
                $program = null;
                $code = strtoupper(str_replace(' ', '', $className));
                
                // Extract level from class name (10, 11, 12)
                if (preg_match('/^(\d{1,2})/', $className, $matches)) {
                    $level = $matches[1];
                }
                
                // Extract program if exists
                if (strpos($className, 'IPA') !== false) {
                    $program = 'IPA';
                } elseif (strpos($className, 'IPS') !== false) {
                    $program = 'IPS';
                } elseif (strpos($className, 'Bahasa') !== false) {
                    $program = 'Bahasa';
                }
                
                // Get or create academic year (use current year)
                $academicYear = DB::table('academic_years')->first();
                if (!$academicYear) {
                    $academicYearId = DB::table('academic_years')->insertGetId([
                        'name' => date('Y') . '/' . (date('Y') + 1),
                        'start_date' => date('Y') . '-07-01',
                        'end_date' => (date('Y') + 1) . '-06-30',
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $academicYearId = $academicYear->id;
                }
                
                // Create new class if it doesn't exist
                $classId = DB::table('classes')->insertGetId([
                    'name' => $className,
                    'code' => $code,
                    'level' => $level,
                    'program' => $program,
                    'capacity' => 30,
                    'academic_year_id' => $academicYearId,
                    'description' => 'Auto-created from student data',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Update student with new class_id
                DB::table('students')
                    ->where('id', $student->id)
                    ->update(['class_id' => $classId]);
            }
        }
    }

    /**
     * Migrate class_id back to class string for rollback
     */
    private function migrateClassDataBack()
    {
        // Get all students with class_id
        $students = DB::table('students')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->select('students.id', 'classes.name as class_name')
            ->get();

        foreach ($students as $student) {
            DB::table('students')
                ->where('id', $student->id)
                ->update(['class' => $student->class_name]);
        }
    }
};