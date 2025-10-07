<?php

echo "🚨 EMERGENCY FIX - Facilities Error\n";
echo "===================================\n\n";

// Langsung eksekusi SQL untuk membuat tabel
$commands = [
    'php artisan cache:clear',
    'php artisan config:clear',
    'php artisan view:clear'
];

echo "1. Membersihkan cache...\n";
foreach ($commands as $cmd) {
    echo "   Menjalankan: $cmd\n";
    $output = shell_exec("$cmd 2>&1");
    echo "   " . trim($output) . "\n";
}

echo "\n2. Menjalankan force fix...\n";
$output = shell_exec('php force_fix_facilities.php 2>&1');
echo $output;

echo "\n✅ Emergency fix selesai!\n";
echo "Refresh halaman /facilities sekarang.\n";