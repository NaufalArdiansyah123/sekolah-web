<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testSuccess()
    {
        \Log::info('Test success route called');
        
        // Test multiple ways to set session message
        session()->flash('success', 'Test success message - modal should appear!');
        session()->put('test_success', 'Test success via put');
        
        // Force session save
        session()->save();
        
        \Log::info('Session messages set:', [
            'has_success' => session()->has('success'),
            'success_value' => session('success'),
            'has_test_success' => session()->has('test_success'),
            'test_success_value' => session('test_success'),
            'session_id' => session()->getId(),
            'all_session' => session()->all()
        ]);
        
        return redirect()->route('admin.settings.index')
                        ->with('success', 'Test success message - modal should appear!')
                        ->with('test_flag', 'success_test');
    }
    
    public function testError()
    {
        \Log::info('Test error route called');
        
        session()->flash('error', 'Test error message - modal should appear!');
        session()->save();
        
        \Log::info('Error session set:', [
            'has_error' => session()->has('error'),
            'error_value' => session('error'),
            'session_id' => session()->getId()
        ]);
        
        return redirect()->route('admin.settings.index')
                        ->with('error', 'Test error message - modal should appear!')
                        ->with('test_flag', 'error_test');
    }
    
    public function testValidation()
    {
        \Log::info('Test validation route called');
        
        return redirect()->route('admin.settings.index')
                        ->withErrors(['test_field' => 'This is a test validation error'])
                        ->withInput(['test_field' => 'test_value'])
                        ->with('test_flag', 'validation_test');
    }
}