<?php

echo "⚡ Quick Fix untuk Facilities\n";
echo "============================\n\n";

// Jalankan migration
echo "🔄 Menjalankan migration...\n";
system('php artisan migrate --force');

echo "\n📦 Menjalankan seeder...\n";
system('php artisan db:seed --class=FacilitySeeder');

echo "\n🔗 Membuat storage link...\n";
system('php artisan storage:link');

echo "\n✅ Selesai! Silakan refresh halaman /facilities\n";