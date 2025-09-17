<?php
/**
 * Qodo Setup Validation Script
 * Validates that Qodo is properly configured for the Laravel project
 */

echo "🔍 Validating Qodo Setup for sekolah-web...\n\n";

$errors = [];
$warnings = [];
$success = [];

// Check if we're in the right directory
if (!file_exists('artisan')) {
    $errors[] = "❌ Not in Laravel project root (artisan command not found)";
} else {
    $success[] = "✅ Laravel project detected";
}

// Check main configuration file
if (!file_exists('qodo.json')) {
    $errors[] = "❌ qodo.json configuration file missing";
} else {
    $config = json_decode(file_get_contents('qodo.json'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $errors[] = "❌ qodo.json is not valid JSON";
    } else {
        $success[] = "✅ qodo.json configuration file found and valid";
        
        // Validate configuration structure
        $requiredKeys = ['project', 'analysis', 'testing', 'workflows', 'reporting'];
        foreach ($requiredKeys as $key) {
            if (!isset($config[$key])) {
                $warnings[] = "⚠️  Missing configuration section: {$key}";
            }
        }
    }
}

// Check ignore file
if (!file_exists('.qodoignore')) {
    $warnings[] = "⚠️  .qodoignore file missing (recommended)";
} else {
    $success[] = "✅ .qodoignore file found";
}

// Check reports directory
if (!is_dir('qodo-reports')) {
    $warnings[] = "⚠️  qodo-reports directory missing";
} else {
    $success[] = "✅ qodo-reports directory exists";
}

// Check Laravel-specific files
$laravelFiles = [
    'app/Models' => 'Models directory',
    'app/Http/Controllers' => 'Controllers directory',
    'routes/web.php' => 'Web routes file',
    'resources/views' => 'Views directory',
    'database/migrations' => 'Migrations directory'
];

foreach ($laravelFiles as $path => $description) {
    if (!file_exists($path)) {
        $warnings[] = "⚠️  {$description} not found at {$path}";
    } else {
        $success[] = "✅ {$description} found";
    }
}

// Check package.json for Qodo scripts
if (!file_exists('package.json')) {
    $warnings[] = "⚠️  package.json not found";
} else {
    $packageJson = json_decode(file_get_contents('package.json'), true);
    if (isset($packageJson['scripts'])) {
        $qodoScripts = ['qodo:analyze', 'qodo:review', 'qodo:test'];
        $foundScripts = 0;
        foreach ($qodoScripts as $script) {
            if (isset($packageJson['scripts'][$script])) {
                $foundScripts++;
            }
        }
        
        if ($foundScripts === count($qodoScripts)) {
            $success[] = "✅ All Qodo npm scripts found";
        } else {
            $warnings[] = "⚠️  Some Qodo npm scripts missing ({$foundScripts}/" . count($qodoScripts) . " found)";
        }
    }
}

// Check PHP version
$phpVersion = PHP_VERSION;
if (version_compare($phpVersion, '8.1.0', '>=')) {
    $success[] = "✅ PHP version {$phpVersion} is compatible";
} else {
    $warnings[] = "⚠️  PHP version {$phpVersion} may not be optimal (8.1+ recommended)";
}

// Check if Composer is available
$composerCheck = shell_exec('composer --version 2>&1');
if ($composerCheck && strpos($composerCheck, 'Composer') !== false) {
    $success[] = "✅ Composer is available";
} else {
    $warnings[] = "⚠️  Composer not found in PATH";
}

// Check if Node.js is available
$nodeCheck = shell_exec('node --version 2>&1');
if ($nodeCheck && strpos($nodeCheck, 'v') === 0) {
    $success[] = "✅ Node.js is available (" . trim($nodeCheck) . ")";
} else {
    $warnings[] = "⚠️  Node.js not found in PATH";
}

// Display results
echo "📊 VALIDATION RESULTS\n";
echo str_repeat("=", 50) . "\n\n";

if (!empty($success)) {
    echo "✅ SUCCESS:\n";
    foreach ($success as $item) {
        echo "   {$item}\n";
    }
    echo "\n";
}

if (!empty($warnings)) {
    echo "⚠️  WARNINGS:\n";
    foreach ($warnings as $item) {
        echo "   {$item}\n";
    }
    echo "\n";
}

if (!empty($errors)) {
    echo "❌ ERRORS:\n";
    foreach ($errors as $item) {
        echo "   {$item}\n";
    }
    echo "\n";
}

// Summary
$totalChecks = count($success) + count($warnings) + count($errors);
$successRate = round((count($success) / $totalChecks) * 100);

echo "📈 SUMMARY:\n";
echo "   Total Checks: {$totalChecks}\n";
echo "   Success: " . count($success) . "\n";
echo "   Warnings: " . count($warnings) . "\n";
echo "   Errors: " . count($errors) . "\n";
echo "   Success Rate: {$successRate}%\n\n";

if (empty($errors)) {
    echo "🎉 QODO SETUP VALIDATION PASSED!\n\n";
    echo "🚀 Next Steps:\n";
    echo "   1. Run: npm run qodo:analyze\n";
    echo "   2. Check reports in: qodo-reports/\n";
    echo "   3. Review and address findings\n";
    echo "   4. Optional: qodo hooks install\n\n";
} else {
    echo "🔧 SETUP NEEDS ATTENTION\n\n";
    echo "Please fix the errors above before proceeding.\n\n";
}

echo "📚 Documentation: .qodo/README.md\n";
echo "⚙️  Configuration: qodo.json\n";
echo "🔍 Run this validation anytime: php .qodo/validate.php\n\n";
?>