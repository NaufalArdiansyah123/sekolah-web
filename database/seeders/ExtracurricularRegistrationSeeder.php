<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Extracurricular;
use App\Models\ExtracurricularRegistration;
use Faker\Factory as Faker;

class ExtracurricularRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Get all extracurriculars
        $extracurriculars = Extracurricular::all();
        
        if ($extracurriculars->isEmpty()) {
            $this->command->info('No extracurriculars found. Please seed extracurriculars first.');
            return;
        }
        
        $classes = ['X', 'XI', 'XII'];
        $majors = ['IPA', 'IPS', 'Bahasa'];
        $statuses = ['pending', 'approved', 'rejected'];
        
        // Create 50 sample registrations
        for ($i = 1; $i <= 50; $i++) {
            $extracurricular = $extracurriculars->random();
            $class = $faker->randomElement($classes);
            $major = $faker->randomElement($majors);
            $status = $faker->randomElement($statuses);
            
            $registeredAt = $faker->dateTimeBetween('-3 months', 'now');
            $approvedAt = null;
            $approvedBy = null;
            
            // If status is approved or rejected, set approval data
            if (in_array($status, ['approved', 'rejected'])) {
                $approvedAt = $faker->dateTimeBetween($registeredAt, 'now');
                $approvedBy = 1; // Assuming admin user ID is 1
            }
            
            ExtracurricularRegistration::create([
                'extracurricular_id' => $extracurricular->id,
                'student_name' => $faker->name,
                'student_class' => $class,
                'student_major' => $major,
                'student_nis' => $faker->unique()->numerify('##########'),
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'parent_name' => $faker->name,
                'parent_phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'reason' => $faker->paragraph(2),
                'experience' => $faker->optional(0.7)->paragraph(1),
                'status' => $status,
                'registered_at' => $registeredAt,
                'approved_at' => $approvedAt,
                'approved_by' => $approvedBy,
                'notes' => $status === 'rejected' ? $faker->optional(0.8)->sentence : null,
            ]);
        }
        
        $this->command->info('Created 50 sample extracurricular registrations.');
        
        // Show statistics
        $pending = ExtracurricularRegistration::where('status', 'pending')->count();
        $approved = ExtracurricularRegistration::where('status', 'approved')->count();
        $rejected = ExtracurricularRegistration::where('status', 'rejected')->count();
        
        $this->command->info("Statistics:");
        $this->command->info("- Pending: {$pending}");
        $this->command->info("- Approved: {$approved}");
        $this->command->info("- Rejected: {$rejected}");
    }
}