<?php

use Illuminate\Support\Facades\Route;

// Simple session debug routes
Route::middleware(['web'])->group(function () {
    
    // Test 1: Simple session set
    Route::get('/debug/session/set', function() {
        \Log::info('🧪 Debug session set route called');
        
        // Set session data
        session(['debug_test' => 'Session is working!']);
        session(['debug_time' => now()->toDateTimeString()]);
        
        // Force save
        session()->save();
        
        \Log::info('🧪 Session data set:', [
            'session_id' => session()->getId(),
            'debug_test' => session('debug_test'),
            'debug_time' => session('debug_time'),
            'all_session' => session()->all()
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Session data set',
            'session_id' => session()->getId(),
            'data' => [
                'debug_test' => session('debug_test'),
                'debug_time' => session('debug_time')
            ]
        ]);
    });
    
    // Test 2: Simple session get
    Route::get('/debug/session/get', function() {
        \Log::info('🧪 Debug session get route called');
        
        $sessionData = [
            'session_id' => session()->getId(),
            'debug_test' => session('debug_test'),
            'debug_time' => session('debug_time'),
            'all_session' => session()->all()
        ];
        
        \Log::info('🧪 Session data retrieved:', $sessionData);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Session data retrieved',
            'data' => $sessionData
        ]);
    });
    
    // Test 3: Flash message test
    Route::get('/debug/session/flash', function() {
        \Log::info('🧪 Debug flash message route called');
        
        // Set flash message
        session()->flash('debug_flash', 'This is a flash message!');
        session()->save();
        
        \Log::info('🧪 Flash message set:', [
            'session_id' => session()->getId(),
            'has_debug_flash' => session()->has('debug_flash'),
            'debug_flash' => session('debug_flash'),
            'all_session' => session()->all()
        ]);
        
        return redirect('/debug/session/check-flash');
    });
    
    // Test 4: Check flash message
    Route::get('/debug/session/check-flash', function() {
        \Log::info('🧪 Debug check flash route called');
        
        $flashData = [
            'session_id' => session()->getId(),
            'has_debug_flash' => session()->has('debug_flash'),
            'debug_flash' => session('debug_flash'),
            'all_session' => session()->all()
        ];
        
        \Log::info('🧪 Flash message checked:', $flashData);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Flash message checked',
            'data' => $flashData
        ]);
    });
    
    // Test 5: Session info
    Route::get('/debug/session/info', function() {
        $info = [
            'session_id' => session()->getId(),
            'session_name' => session()->getName(),
            'session_driver' => config('session.driver'),
            'session_lifetime' => config('session.lifetime'),
            'session_path' => config('session.files'),
            'session_cookie' => config('session.cookie'),
            'session_domain' => config('session.domain'),
            'session_secure' => config('session.secure'),
            'session_http_only' => config('session.http_only'),
            'session_same_site' => config('session.same_site'),
            'storage_path_exists' => is_dir(storage_path('framework/sessions')),
            'storage_path_writable' => is_writable(storage_path('framework/sessions')),
            'session_files_count' => count(glob(storage_path('framework/sessions/*'))),
            'current_session_data' => session()->all()
        ];
        
        \Log::info('🧪 Session info:', $info);
        
        return response()->json($info);
    });
    
});