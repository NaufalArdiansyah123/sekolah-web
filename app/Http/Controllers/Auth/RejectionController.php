<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RejectionController extends Controller
{
    /**
     * Show the rejection explanation page.
     */
    public function show(Request $request)
    {
        // Get user ID from session or request
        $userId = $request->session()->get('rejected_user_id');
        
        if (!$userId) {
            // If no user ID in session, redirect to login
            return redirect()->route('login')
                ->with('error', 'Sesi telah berakhir. Silakan login kembali.');
        }
        
        // Get user data
        $user = User::find($userId);
        
        if (!$user || $user->status !== 'rejected') {
            // If user not found or not rejected, redirect to login
            return redirect()->route('login')
                ->with('error', 'Data tidak valid. Silakan login kembali.');
        }
        
        // Clear the session data
        $request->session()->forget('rejected_user_id');
        
        return view('auth.rejection-explanation', compact('user'));
    }
    
    /**
     * Handle contact form submission from rejection page.
     */
    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);
        
        // Here you can implement email sending logic
        // For now, we'll just redirect with success message
        
        return redirect()->route('login')
            ->with('success', 'Pesan Anda telah dikirim. Tim kami akan menghubungi Anda segera.');
    }
    

}