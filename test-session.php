<?php

// Simple session test script
session_start();

echo "<h2>🧪 Session Test</h2>";

// Test 1: Set session
if (isset($_GET['set'])) {
    $_SESSION['test_message'] = 'Session is working!';
    $_SESSION['timestamp'] = date('Y-m-d H:i:s');
    echo "<p>✅ Session set successfully!</p>";
    echo "<p><a href='test-session.php'>Check Session</a></p>";
    exit;
}

// Test 2: Check session
echo "<h3>Session Status:</h3>";
echo "<ul>";
echo "<li>Session ID: " . session_id() . "</li>";
echo "<li>Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? 'ACTIVE' : 'INACTIVE') . "</li>";
echo "<li>Session Save Path: " . session_save_path() . "</li>";
echo "<li>Session Cookie Name: " . session_name() . "</li>";
echo "</ul>";

echo "<h3>Session Data:</h3>";
if (empty($_SESSION)) {
    echo "<p>❌ No session data found</p>";
} else {
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
}

echo "<h3>Actions:</h3>";
echo "<p><a href='test-session.php?set=1'>Set Test Session</a></p>";
echo "<p><a href='test-session.php'>Refresh Page</a></p>";

// Test 3: Laravel session path
$laravelSessionPath = __DIR__ . '/storage/framework/sessions';
echo "<h3>Laravel Session Directory:</h3>";
echo "<ul>";
echo "<li>Path: $laravelSessionPath</li>";
echo "<li>Exists: " . (is_dir($laravelSessionPath) ? 'YES' : 'NO') . "</li>";
echo "<li>Writable: " . (is_writable($laravelSessionPath) ? 'YES' : 'NO') . "</li>";
echo "<li>Files: " . count(glob($laravelSessionPath . '/*')) . "</li>";
echo "</ul>";

?>