<?php

/**
 * Script untuk menambahkan default navbar color settings
 * Jalankan script ini sekali untuk menambahkan pengaturan warna navbar default
 * 
 * Cara menjalankan:
 * php add_navbar_colors.php
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Setting;

echo "🎨 Menambahkan default navbar color settings...\n\n";

$defaultNavbarColors = [
    'navbar_bg_color' => '#1a202c',
    'navbar_text_color' => '#ffffff', 
    'navbar_hover_color' => '#3182ce',
    'navbar_active_color' => '#4299e1'
];

$added = 0;
$existing = 0;

foreach ($defaultNavbarColors as $key => $defaultValue) {
    try {
        $setting = Setting::firstOrCreate(
            ['key' => $key],
            [
                'value' => $defaultValue,
                'type' => 'color',
                'group' => 'school'
            ]
        );

        if ($setting->wasRecentlyCreated) {
            $added++;
            echo "✅ Ditambahkan: {$key} = {$defaultValue}\n";
        } else {
            $existing++;
            echo "ℹ️  Sudah ada: {$key} = {$setting->value}\n";
        }
    } catch (Exception $e) {
        echo "❌ Error untuk {$key}: " . $e->getMessage() . "\n";
    }
}

echo "\n🎉 Selesai! Ditambahkan {$added} pengaturan baru, {$existing} sudah ada sebelumnya.\n";

if ($added > 0) {
    echo "\n✨ Pengaturan warna navbar berhasil ditambahkan!\n";
    echo "📝 Anda sekarang bisa mengkustomisasi warna navbar di:\n";
    echo "   Admin Settings > Tab Appearance\n\n";
    echo "🎨 Fitur yang tersedia:\n";
    echo "   - Background Color (Warna latar navbar)\n";
    echo "   - Text Color (Warna teks navbar)\n";
    echo "   - Hover Color (Warna saat hover)\n";
    echo "   - Active Color (Warna link aktif)\n";
    echo "   - Live Preview (Preview real-time)\n";
    echo "   - Preset Themes (Tema siap pakai)\n\n";
}

echo "🚀 Silakan buka halaman Admin Settings untuk menggunakan fitur navbar customization!\n";