<?php
// Test script to debug modal API endpoints
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

// Test if PklAttendanceLog exists
$pklLogs = \App\Models\PklAttendanceLog::with('student')->limit(1)->get();

if ($pklLogs->count() > 0) {
    $log = $pklLogs->first();
    echo "Found log with ID: " . $log->id . "\n";
    echo "Student: " . $log->student->name . "\n";
    echo "Status: " . $log->status . "\n";
    echo "Log Activity: " . ($log->log_activity ?? 'Not set') . "\n";
} else {
    echo "No PKL attendance logs found\n";
}
?>