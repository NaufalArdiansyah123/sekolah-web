<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Role, Permission, Setting};
use Illuminate\Support\Facades\Hash;

// SettingController.php
class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|max:255',
            'site_description' => 'nullable',
            'site_email' => 'required|email',
            'site_phone' => 'nullable|max:20',
            'site_address' => 'nullable',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'site_favicon' => 'nullable|image|mimes:ico,png|max:512',
        ]);

        foreach ($request->except(['_token', '_method', 'site_logo', 'site_favicon']) as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => $logoPath]
            );
        }

        if ($request->hasFile('site_favicon')) {
            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            Setting::updateOrCreate(
                ['key' => 'site_favicon'],
                ['value' => $faviconPath]
            );
        }

        return redirect()->route('admin.settings')
                        ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}