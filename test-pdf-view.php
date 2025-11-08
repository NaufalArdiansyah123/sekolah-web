<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test file path
$filePath = storage_path('app/public/surat-pengantar/qslizyz6hlekCR4D9AurI3kcNCytkQ0rYUrrY0SX.pdf');

echo "Testing PDF File Access\n";
echo "======================\n\n";
echo "File path: $filePath\n";
echo "File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . "\n";

if (file_exists($filePath)) {
    echo "File size: " . filesize($filePath) . " bytes\n";
    echo "Is readable: " . (is_readable($filePath) ? 'YES' : 'NO') . "\n";
    echo "MIME type: " . mime_content_type($filePath) . "\n";

    // Test Storage facade
    $storageRelativePath = 'public/surat-pengantar/qslizyz6hlekCR4D9AurI3kcNCytkQ0rYUrrY0SX.pdf';
    echo "\nStorage facade test:\n";
    echo "Storage path: $storageRelativePath\n";
    echo "Storage exists: " . (\Illuminate\Support\Facades\Storage::exists($storageRelativePath) ? 'YES' : 'NO') . "\n";

    if (\Illuminate\Support\Facades\Storage::exists($storageRelativePath)) {
        $content = \Illuminate\Support\Facades\Storage::get($storageRelativePath);
        echo "Content loaded: " . strlen($content) . " bytes\n";
        echo "First 10 bytes: " . bin2hex(substr($content, 0, 10)) . "\n";
        echo "PDF signature: " . (str_starts_with($content, '%PDF') ? 'Valid PDF' : 'Invalid PDF') . "\n";
    }
} else {
    echo "\nFILE NOT FOUND!\n";
}
