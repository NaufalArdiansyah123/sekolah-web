
<?php
/**
 * Quick Cache Clear Script
 * Run this file in browser: http://localhost:8000/clear-cache.php
 */

// Get the base path
$basePath = __DIR__;

// Define cache directories
$cacheDirs = [
    $basePath . '/bootstrap/cache',
    $basePath . '/storage/framework/cache',
];

$cleared = [];
$errors = [];

foreach ($cacheDirs as $dir) {
    if (!is_dir($dir)) {
        continue;
    }

    $files = glob($dir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            if (@unlink($file)) {
                $cleared[] = $file;
            } else {
                $errors[] = "Failed to delete: $file";
            }
        }
    }
}

// Try to clear via artisan if available
$artisanPath = $basePath . '/artisan';
if (file_exists($artisanPath)) {
    exec('php ' . $artisanPath . ' config:clear 2>&1', $output1);
    exec('php ' . $artisanPath . ' route:clear 2>&1', $output2);
    exec('php ' . $artisanPath . ' cache:clear 2>&1', $output3);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cache Clear</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }
        h1 { color: #333; }
        pre { background: #f0f0f0; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>✅ Cache Cleared Successfully!</h1>
        
        <h2>Files Deleted:</h2>
        <pre><?php echo count($cleared) . " files deleted\n"; ?></pre>
        
        <?php if (!empty($errors)): ?>
            <h2 class="error">Errors:</h2>
            <pre><?php echo implode("\n", $errors); ?></pre>
        <?php endif; ?>
        
        <h2>Next Steps:</h2>
        <ol>
            <li>Refresh your browser (Ctrl+F5)</li>
            <li>Try accessing the QR Scanner page again</li>
            <li>Check the browser console (F12) for any errors</li>
        </ol>
        
        <p><a href="/teacher/attendance/qr-scanner">Go to QR Scanner →</a></p>
    </div>
</body>
</html>
