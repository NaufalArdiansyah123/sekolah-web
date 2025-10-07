<?php
// Test route for clean approval testing
Route::get('/admin/test-clean-approval', function() {
    return view('admin.extracurriculars.test-clean-approval');
})->middleware('auth')->name('admin.test-clean-approval');
