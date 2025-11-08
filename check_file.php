<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$reg = \App\Models\PklRegistration::find(1);
if ($reg) {
    echo 'Surat: ' . $reg->surat_pengantar . "\n";
    $path = storage_path('app/public/surat-pengantar/' . basename($reg->surat_pengantar));
    echo 'Path: ' . $path . "\n";
    echo 'Exists: ' . (file_exists($path) ? 'YES' : 'NO') . "\n";
    echo 'Readable: ' . (is_readable($path) ? 'YES' : 'NO') . "\n";
    if (file_exists($path)) {
        echo 'Size: ' . filesize($path) . ' bytes' . "\n";
    }
} else {
    echo "No registration found\n";
}
