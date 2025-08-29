<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'pageTitle' => 'Dashboard Admin',
            'breadcrumb' => []
        ]);
    }

    public function profile()
    {
        return view('admin.profile', [
            'pageTitle' => 'Profile',
            'breadcrumb' => [
                ['title' => 'Profile']
            ]
        ]);
    }

    public function settings()
    {
        return view('admin.settings', [
            'pageTitle' => 'Settings',
            'breadcrumb' => [
                ['title' => 'Settings']
            ]
        ]);
    }
}