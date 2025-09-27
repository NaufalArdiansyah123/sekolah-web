<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing assignments that don't have class_id
        // Set them to the first available class or create a default class
        
        // Check if there are assignments without class_id
        $assignmentsWithoutClass = DB::table('assignments')
            ->whereNull('class_id')
            ->count();
            
        if ($assignmentsWithoutClass > 0) {
            // Get the first available class
            $firstClass = DB::table('classes')->first();
            
            if ($firstClass) {
                // Update assignments without class_id to use the first class
                DB::table('assignments')
                    ->whereNull('class_id')
                    ->update(['class_id' => $firstClass->id]);
            } else {
                // Create a default class if no classes exist
                $defaultClassId = DB::table('classes')->insertGetId([
                    'name' => 'Umum',
                    'level' => '10',
                    'description' => 'Kelas default untuk assignment lama',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Update assignments to use the default class
                DB::table('assignments')
                    ->whereNull('class_id')
                    ->update(['class_id' => $defaultClassId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set class_id back to null for assignments that were updated
        DB::table('assignments')
            ->where('class_id', function($query) {
                $query->select('id')
                      ->from('classes')
                      ->where('name', 'Umum')
                      ->where('description', 'Kelas default untuk assignment lama')
                      ->limit(1);
            })
            ->update(['class_id' => null]);
            
        // Optionally delete the default class if it was created
        DB::table('classes')
            ->where('name', 'Umum')
            ->where('description', 'Kelas default untuk assignment lama')
            ->delete();
    }
};