<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting Database Seeding...');
        Log::info('Starting Database Seeding');
        
        try {
            // Seed roles first
            $this->command->info('\n🎭 Seeding Roles...');
            $this->call(RoleSeeder::class);
            
            // Seed original users (admin, teacher, student accounts)
            $this->command->info('\n👤 Seeding Original Users...');
            $this->call(OriginalUserSeeder::class);
            
            // Seed students (50 students with accounts)
            $this->command->info('\n🎓 Seeding Students...');
            $this->call(StudentSeeder::class);
            
            // Seed blog posts
            $this->command->info('\n📰 Seeding Blog Posts...');
            $this->call(BlogPostSeeder::class);
            
            // Seed announcements
            $this->command->info('\n📢 Seeding Announcements...');
            $this->call(AnnouncementSeeder::class);
            
            // Seed teachers
            $this->command->info('\n👩‍🏫 Seeding Teachers...');
            $this->call(TeacherSeeder::class);
            
            $this->command->info('\n🎉 Database seeding completed successfully!');
            $this->command->info('\n📋 Summary:');
            $this->command->info('   ✅ Roles created/verified');
            $this->command->info('   ✅ Original users created/updated');
            $this->command->info('   ✅ 50 students created with accounts');
            $this->command->info('   ✅ 5 blog posts created');
            $this->command->info('   ✅ 5 announcements created');
            $this->command->info('   ✅ 50 teachers created with accounts');
            $this->command->info('\n🔑 Default Password: "password"');
            $this->command->info('\n📧 Original Login Credentials:');
            $this->command->info('   - admin@sman99.sch.id / password (Administrator)');
            $this->command->info('   - teacher@sman99.sch.id / password (Teacher Demo)');
            $this->command->info('   - student@sman99.sch.id / password (Student Demo)');
            $this->command->info('   - superadmin@sman99.sch.id / password (Super Administrator)');
            $this->command->info('\n👨‍🎓 Student Login Format:');
            $this->command->info('   - firstname.lastname@student.smk.sch.id / password');
            $this->command->info('   - Example: ahmad.rizki.pratama@student.smk.sch.id / password');
            $this->command->info('\n👩‍🏫 Teacher Login Format:');
            $this->command->info('   - firstname.lastname@teacher.sman1balong.sch.id / password');
            $this->command->info('   - Example: ahmad.suryanto@teacher.sman1balong.sch.id / password');
            $this->command->info('\n🔄 Original System Restored:');
            $this->command->info('   - Original admin/teacher accounts restored');
            $this->command->info('   - Domain: @sman99.sch.id (original)');
            $this->command->info('   - Compatible with existing system');
            
            Log::info('Database seeding completed successfully');
            
        } catch (\Exception $e) {
            $this->command->error('❌ Database seeding failed: ' . $e->getMessage());
            Log::error('Database seeding failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
}