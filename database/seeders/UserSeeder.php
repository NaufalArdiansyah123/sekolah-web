<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Role};
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $superAdmin->roles()->attach($superAdminRole);

        // Create Sample Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin2@admin.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        
        $adminRole = Role::where('name', 'Admin')->first();
        $admin->roles()->attach($adminRole);

        // Create Sample Editor User
        $editor = User::create([
            'name' => 'Content Editor',
            'email' => 'editor@admin.com',
            'password' => Hash::make('password'),
            'phone' => '081234567892',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        
        $editorRole = Role::where('name', 'Editor')->first();
        $editor->roles()->attach($editorRole);
    }
}
