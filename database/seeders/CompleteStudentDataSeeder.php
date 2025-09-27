<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompleteStudentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder ensures ALL users with student role have complete data
     * for class, parent information, and other required fields.
     */
    public function run(): void
    {
        $this->command->info('🔍 Checking and completing student data...');
        
        try {
            DB::beginTransaction();
            
            // Find all users with student role
            $studentUsers = User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->get();
            
            $this->command->info("📊 Found {$studentUsers->count()} users with student role");
            
            // Sample data arrays
            $classes = [
                'X TKJ 1', 'X TKJ 2', 'X TKJ 3',
                'X RPL 1', 'X RPL 2', 'X RPL 3', 
                'X DKV 1', 'X DKV 2',
                'XI TKJ 1', 'XI TKJ 2', 'XI TKJ 3',
                'XI RPL 1', 'XI RPL 2', 'XI RPL 3',
                'XI DKV 1', 'XI DKV 2',
                'XII TKJ 1', 'XII TKJ 2', 'XII TKJ 3',
                'XII RPL 1', 'XII RPL 2', 'XII RPL 3',
                'XII DKV 1', 'XII DKV 2'
            ];
            
            $parentNames = [
                'Ahmad Suryanto', 'Budi Santoso', 'Candra Wijaya', 'Dedi Kurniawan', 'Eko Prasetyo',
                'Fajar Rahman', 'Gunawan Saputra', 'Hendra Kusuma', 'Indra Permana', 'Joko Susilo',
                'Kurnia Sari', 'Lestari Dewi', 'Maya Indah', 'Nurul Hidayah', 'Olivia Sari',
                'Putri Maharani', 'Qori Amelia', 'Ratna Sari', 'Siti Aminah', 'Tuti Handayani',
                'Umi Kalsum', 'Vina Panduwinata', 'Wulan Guritno', 'Yuni Shara', 'Zaskia Gotik',
                'Bambang Hermanto', 'Cahyo Utomo', 'Dwi Anggoro', 'Edi Susanto', 'Firman Hidayat',
                'Galih Prakoso', 'Hadi Wijaya', 'Imam Santoso', 'Jaka Tingkir', 'Krisna Murti'
            ];
            
            $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];
            $birthPlaces = [
                'Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 
                'Medan', 'Makassar', 'Palembang', 'Denpasar', 'Balikpapan',
                'Pontianak', 'Manado', 'Ambon', 'Jayapura', 'Mataram'
            ];
            
            $updated = 0;
            $skipped = 0;
            
            foreach ($studentUsers as $user) {
                $updateData = [];
                $needsUpdate = false;
                
                // Check and add class if missing
                if (empty($user->class)) {
                    $updateData['class'] = $classes[array_rand($classes)];
                    $needsUpdate = true;
                }
                
                // Check and add parent data if missing
                if (empty($user->parent_name)) {
                    $parentName = $parentNames[array_rand($parentNames)];
                    $updateData['parent_name'] = $parentName;
                    $updateData['parent_phone'] = '08' . rand(1000000000, 9999999999);
                    $updateData['parent_email'] = strtolower(str_replace(' ', '.', $parentName)) . '@gmail.com';
                    $needsUpdate = true;
                }
                
                // Check and add NIS if missing
                if (empty($user->nis)) {
                    $currentYear = date('Y');
                    $randomClass = rand(10, 12);
                    
                    // Generate unique NIS with better algorithm
                    $attempts = 0;
                    do {
                        $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                        $nis = $currentYear . $randomClass . $randomNumber;
                        $attempts++;
                        
                        // Prevent infinite loop by using timestamp if too many attempts
                        if ($attempts > 100) {
                            $timestamp = substr(time(), -4);
                            $nis = $currentYear . $randomClass . $timestamp;
                            break;
                        }
                    } while (User::where('nis', $nis)->where('id', '!=', $user->id)->exists());
                    
                    $updateData['nis'] = $nis;
                    $needsUpdate = true;
                }
                
                // Check and add birth place if missing
                if (empty($user->birth_place)) {
                    $updateData['birth_place'] = $birthPlaces[array_rand($birthPlaces)];
                    $needsUpdate = true;
                }
                
                // Check and add religion if missing
                if (empty($user->religion)) {
                    $updateData['religion'] = $religions[array_rand($religions)];
                    $needsUpdate = true;
                }
                
                // Check and add birth date if missing
                if (empty($user->birth_date)) {
                    $age = rand(15, 18);
                    $birthYear = date('Y') - $age;
                    $updateData['birth_date'] = $birthYear . '-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
                    $needsUpdate = true;
                }
                
                // Check and add phone if missing
                if (empty($user->phone)) {
                    $updateData['phone'] = '08' . rand(1000000000, 9999999999);
                    $needsUpdate = true;
                }
                
                // Check and add address if missing
                if (empty($user->address)) {
                    $streets = ['Jl. Merdeka', 'Jl. Sudirman', 'Jl. Diponegoro', 'Jl. Ahmad Yani', 'Jl. Gatot Subroto', 'Jl. Pahlawan', 'Jl. Veteran'];
                    $updateData['address'] = $streets[array_rand($streets)] . ' No. ' . rand(1, 200) . ', ' . $birthPlaces[array_rand($birthPlaces)];
                    $needsUpdate = true;
                }
                
                // Check and add gender if missing
                if (empty($user->gender)) {
                    $updateData['gender'] = rand(0, 1) ? 'male' : 'female';
                    $needsUpdate = true;
                }
                
                // Update if needed
                if ($needsUpdate) {
                    $user->update($updateData);
                    
                    $this->command->info("   ✅ Updated: {$user->name} ({$user->email})");
                    $this->command->info("      Class: " . ($updateData['class'] ?? $user->class ?? 'N/A'));
                    $this->command->info("      Parent: " . ($updateData['parent_name'] ?? $user->parent_name ?? 'N/A'));
                    $this->command->info("      NIS: " . ($updateData['nis'] ?? $user->nis ?? 'N/A'));
                    
                    $updated++;
                } else {
                    $skipped++;
                }
            }
            
            DB::commit();
            
            $this->command->info('');
            $this->command->info("📊 SUMMARY:");
            $this->command->info("   ✅ Updated: {$updated} student users");
            $this->command->info("   ⏭️  Skipped: {$skipped} users (already complete)");
            $this->command->info("   📚 Total student users: {$studentUsers->count()}");
            
            // Verify the updates
            $this->command->info('');
            $this->command->info('🔍 Verifying updates...');
            
            $studentsAfterUpdate = User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->get();
            
            $stillMissingClass = $studentsAfterUpdate->filter(function($user) {
                return empty($user->class);
            })->count();
            
            $stillMissingParent = $studentsAfterUpdate->filter(function($user) {
                return empty($user->parent_name);
            })->count();
            
            $stillMissingNis = $studentsAfterUpdate->filter(function($user) {
                return empty($user->nis);
            })->count();
            
            $this->command->info("   📚 Users still missing class: {$stillMissingClass}");
            $this->command->info("   👨‍👩‍👧‍👦 Users still missing parent: {$stillMissingParent}");
            $this->command->info("   🆔 Users still missing NIS: {$stillMissingNis}");
            
            if ($stillMissingClass === 0 && $stillMissingParent === 0 && $stillMissingNis === 0) {
                $this->command->info('');
                $this->command->info('🎉 All student users now have complete data!');
                $this->command->info('✅ Student registration page should now show all data correctly.');
            } else {
                $this->command->warn('');
                $this->command->warn('⚠️  Some users still have missing data.');
            }
            
            Log::info('CompleteStudentDataSeeder completed', [
                'updated' => $updated,
                'skipped' => $skipped,
                'total' => $studentUsers->count()
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $this->command->error('❌ Error completing student data: ' . $e->getMessage());
            Log::error('CompleteStudentDataSeeder failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
}