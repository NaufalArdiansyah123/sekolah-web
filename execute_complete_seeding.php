<?php

// Execute the complete seeding script
echo "🚀 Executing Complete Seeding Process...\n";
echo "========================================\n\n";

// Change to the correct directory
chdir(__DIR__);

// Execute the complete seeding script
$command = 'php complete_seeding.php';
echo "Running command: $command\n\n";

// Execute and capture output
$output = [];
$returnCode = 0;

exec($command . ' 2>&1', $output, $returnCode);

// Display output
foreach ($output as $line) {
    echo $line . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "Execution completed with return code: $returnCode\n";

if ($returnCode === 0) {
    echo "✅ SUCCESS: Complete seeding process finished successfully!\n";
} else {
    echo "❌ ERROR: Complete seeding process failed with code $returnCode\n";
}

echo "\n✨ Done!\n";