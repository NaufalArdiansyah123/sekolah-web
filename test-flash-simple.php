<?php

// Simple test untuk flash message Laravel
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a simple request
$request = Illuminate\Http\Request::create('/test-flash', 'GET');
$response = $kernel->handle($request);

// Test flash message
echo "<h2>🧪 Laravel Flash Message Test</h2>";

// Start session manually
session_start();

// Test 1: Set flash message using Laravel method
if (isset($_GET['set'])) {
    // Use Laravel's session
    $session = app('session');
    $session->flash('test_message', 'This is a Laravel flash message!');
    $session->flash('test_time', date('Y-m-d H:i:s'));
    $session->save();
    
    echo "<p>✅ Laravel flash message set!</p>";
    echo "<p><a href='test-flash-simple.php'>Check Flash Message</a></p>";
    exit;
}

// Test 2: Check flash message
echo "<h3>Laravel Session Status:</h3>";
$session = app('session');

echo "<ul>";
echo "<li>Session ID: " . $session->getId() . "</li>";
echo "<li>Session Driver: " . config('session.driver') . "</li>";
echo "<li>Has test_message: " . ($session->has('test_message') ? 'YES' : 'NO') . "</li>";
echo "<li>Test message: " . ($session->get('test_message') ?? 'NULL') . "</li>";
echo "<li>Has test_time: " . ($session->has('test_time') ? 'YES' : 'NO') . "</li>";
echo "<li>Test time: " . ($session->get('test_time') ?? 'NULL') . "</li>";
echo "</ul>";

echo "<h3>All Session Data:</h3>";
echo "<pre>";
print_r($session->all());
echo "</pre>";

echo "<h3>Flash Data:</h3>";
$flashData = $session->get('_flash', []);
echo "<pre>";
print_r($flashData);
echo "</pre>";

echo "<h3>Actions:</h3>";
echo "<p><a href='test-flash-simple.php?set=1'>Set Laravel Flash Message</a></p>";
echo "<p><a href='test-flash-simple.php'>Refresh Page</a></p>";

$kernel->terminate($request, $response);

?>