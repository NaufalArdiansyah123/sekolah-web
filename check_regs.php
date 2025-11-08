<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$regs = \App\Models\PklRegistration::whereNotNull('surat_pengantar')->limit(5)->get();
foreach ($regs as $reg) {
    echo "ID: " . $reg->id . ", Surat: " . $reg->surat_pengantar . "\n";
}
