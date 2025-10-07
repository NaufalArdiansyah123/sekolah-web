<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        
        $this->command->info('Roles created/verified successfully!');

        // Create admin user if not exists
        if (!User::where('email', 'admin@sman99.sch.id')->exists()) {
            $adminUser = User::create([
                'name' => 'Administrator',
                'email' => 'admin@sman99.sch.id',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            $adminUser->assignRole('admin');
            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }

        // Create teacher user if not exists
        if (!User::where('email', 'teacher@sman99.sch.id')->exists()) {
            $teacherUser = User::create([
                'name' => 'Teacher Demo',
                'email' => 'teacher@sman99.sch.id',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            $teacherUser->assignRole('teacher');
            $this->command->info('Teacher user created successfully!');
        } else {
            $this->command->info('Teacher user already exists.');
        }

        // Create student user if not exists
        if (!User::where('email', 'student@sman99.sch.id')->exists()) {
            $studentUser = User::create([
                'name' => 'Student Demo',
                'email' => 'student@sman99.sch.id',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            $studentUser->assignRole('student');
            $this->command->info('Student user created successfully!');
        } else {
            $this->command->info('Student user already exists.');
        }
    }
}