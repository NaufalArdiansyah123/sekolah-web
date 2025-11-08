<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$reg = \App\Models\PklRegistration::whereNotNull('surat_pengantar')->first();
if ($reg) {
    echo "Path stored in DB: " . $reg->surat_pengantar . "\n";
} else {
    echo "No registration found with surat_pengantar\n";
}
