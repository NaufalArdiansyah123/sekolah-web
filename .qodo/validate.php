<?php
/**
 * Qodo Initialization Validation Script
 * 
 * This script validates that Qodo has been properly initialized
 * for the sekolah-web Laravel project.
 */

echo "🔍 Validating Qodo initialization...\n\n";

$errors = [];
$warnings = [];

// Check required files
$requiredFiles = [
    '.qodo.json' => 'Main Qodo configuration file',
    '.qodoignore' => 'Qodo ignore patterns file',
    '.qodo/workflows.yml' => 'Qodo workflows configuration',
    '.qodo/README.md' => 'Qodo documentation'
];

foreach ($requiredFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✅ {$description}: {$file}\n";
    } else {
        $errors[] = "❌ Missing {$description}: {$file}";
    }
}

// Check configuration validity
if (file_exists('.qodo.json')) {
    $config = json_decode(file_get_contents('.qodo.json'), true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "✅ Configuration file is valid JSON\n";
        
        // Check required configuration sections
        $requiredSections = ['project', 'analysis', 'code_review', 'testing'];
        foreach ($requiredSections as $section) {
            if (isset($config[$section])) {
                echo "✅ Configuration section '{$section}' found\n";
            } else {
                $warnings[] = "⚠️  Configuration section '{$section}' missing";
            }
        }
    } else {
        $errors[] = "❌ Configuration file contains invalid JSON";
    }
}

// Check package.json scripts
if (file_exists('package.json')) {
    $package = json_decode(file_get_contents('package.json'), true);
    if (isset($package['scripts'])) {
        $qodoScripts = array_filter(array_keys($package['scripts']), function($script) {
            return strpos($script, 'qodo:') === 0;
        });
        
        if (!empty($qodoScripts)) {
            echo "✅ Qodo scripts added to package.json: " . implode(', ', $qodoScripts) . "\n";
        } else {
            $warnings[] = "⚠️  No Qodo scripts found in package.json";
        }
    }
}

// Check Laravel project structure
$laravelDirs = ['app', 'config', 'database', 'routes', 'resources'];
$laravelFiles = ['artisan', 'composer.json'];

$isLaravel = true;
foreach ($laravelDirs as $dir) {
    if (!is_dir($dir)) {
        $isLaravel = false;
        break;
    }
}

foreach ($laravelFiles as $file) {
    if (!file_exists($file)) {
        $isLaravel = false;
        break;
    }
}

if ($isLaravel) {
    echo "✅ Laravel project structure detected\n";
} else {
    $warnings[] = "⚠️  Laravel project structure not fully detected";
}

echo "\n";

// Display results
if (empty($errors) && empty($warnings)) {
    echo "🎉 Qodo initialization completed successfully!\n";
    echo "\nNext steps:\n";
    echo "1. Run 'npm run qodo:analyze' to perform initial analysis\n";
    echo "2. Review the generated reports\n";
    echo "3. Customize .qodo.json based on your project needs\n";
    echo "4. Consider enabling git hooks with 'qodo hooks install'\n";
} else {
    if (!empty($errors)) {
        echo "❌ Errors found:\n";
        foreach ($errors as $error) {
            echo "   {$error}\n";
        }
        echo "\n";
    }
    
    if (!empty($warnings)) {
        echo "⚠️  Warnings:\n";
        foreach ($warnings as $warning) {
            echo "   {$warning}\n";
        }
        echo "\n";
    }
    
    if (!empty($errors)) {
        echo "Please fix the errors above before proceeding.\n";
        exit(1);
    } else {
        echo "Qodo initialization completed with warnings. You may proceed.\n";
    }
}

echo "\n📚 For more information, see .qodo/README.md\n";
?>