<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Check if table exists
            if (!\Schema::hasTable('contacts')) {
                Log::error('Contacts table does not exist');
                return redirect()->route('admin.dashboard')
                               ->with('error', 'Tabel kontak belum dibuat. Silakan jalankan migration terlebih dahulu.');
            }
            
            $contacts = Contact::ordered()->get();
            
            Log::info('Contacts page loaded successfully', [
                'contacts_count' => $contacts->count()
            ]);
            
            return view('admin.contacts.index', compact('contacts'));
        } catch (\Exception $e) {
            Log::error('Error loading contacts page:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Terjadi kesalahan saat memuat halaman kontak: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'address' => 'nullable|string|max:500',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'website' => 'nullable|url|max:255',
                'map_embed' => 'nullable|string',
                'office_hours' => 'nullable|string|max:255',
                'is_active' => 'boolean',
                'sort_order' => 'nullable|integer|min:0',
                // Social media fields
                'facebook' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'youtube' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'whatsapp' => 'nullable|string|max:255',
                'telegram' => 'nullable|string|max:255',
                // Quick cards fields (dynamic up to 10)
                'quick_card_*_icon' => 'nullable|string|max:100',
                'quick_card_*_title' => 'nullable|string|max:255',
                'quick_card_*_description' => 'nullable|string|max:500',
                // Hero image field
                'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // Prepare social media data
            $socialMedia = [];
            $socialPlatforms = ['facebook', 'instagram', 'twitter', 'youtube', 'linkedin', 'whatsapp', 'telegram'];
            
            foreach ($socialPlatforms as $platform) {
                if (!empty($validated[$platform])) {
                    $socialMedia[$platform] = $validated[$platform];
                }
                unset($validated[$platform]);
            }

            $validated['social_media'] = !empty($socialMedia) ? $socialMedia : null;
            $validated['is_active'] = $request->has('is_active');
            
            // Prepare quick cards data (dynamic up to 10)
            $quickCards = [];
            for ($i = 1; $i <= 10; $i++) {
                if (!empty($request->input("quick_card_{$i}_title"))) {
                    $quickCards[] = [
                        'icon' => $request->input("quick_card_{$i}_icon") ?: 'fas fa-info-circle',
                        'title' => $request->input("quick_card_{$i}_title"),
                        'description' => $request->input("quick_card_{$i}_description") ?: ''
                    ];
                }
            }
            // Only set quick_cards if the column exists
            if (\Schema::hasColumn('contacts', 'quick_cards')) {
                $validated['quick_cards'] = !empty($quickCards) ? $quickCards : null;
            }
            
            // Handle hero image upload
            if ($request->hasFile('hero_image') && \Schema::hasColumn('contacts', 'hero_image')) {
                $heroImage = $request->file('hero_image');
                $filename = time() . '_hero_' . $heroImage->getClientOriginalName();
                $path = $heroImage->storeAs('contacts/hero', $filename, 'public');
                $validated['hero_image'] = $path;
            }
            
            // Set sort order if not provided
            if (!isset($validated['sort_order'])) {
                $validated['sort_order'] = Contact::max('sort_order') + 1;
            }

            Contact::create($validated);

            return redirect()->route('admin.contacts.index')
                           ->with('success', 'Kontak berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput()
                           ->with('error', 'Terdapat kesalahan validasi. Silakan periksa kembali.');
        } catch (\Exception $e) {
            Log::error('Error creating contact:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            // Check if it's a database column error
            if (strpos($e->getMessage(), 'quick_cards') !== false) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Database belum diupdate. Silakan jalankan: php artisan migrate');
            }

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat menyimpan kontak: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'address' => 'nullable|string|max:500',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'website' => 'nullable|url|max:255',
                'map_embed' => 'nullable|string',
                'office_hours' => 'nullable|string|max:255',
                'is_active' => 'boolean',
                'sort_order' => 'nullable|integer|min:0',
                // Social media fields
                'facebook' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'youtube' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'whatsapp' => 'nullable|string|max:255',
                'telegram' => 'nullable|string|max:255',
                // Quick cards fields (dynamic up to 10)
                'quick_card_*_icon' => 'nullable|string|max:100',
                'quick_card_*_title' => 'nullable|string|max:255',
                'quick_card_*_description' => 'nullable|string|max:500',
                // Hero image field
                'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // Prepare social media data
            $socialMedia = [];
            $socialPlatforms = ['facebook', 'instagram', 'twitter', 'youtube', 'linkedin', 'whatsapp', 'telegram'];
            
            foreach ($socialPlatforms as $platform) {
                if (!empty($validated[$platform])) {
                    $socialMedia[$platform] = $validated[$platform];
                }
                unset($validated[$platform]);
            }

            $validated['social_media'] = !empty($socialMedia) ? $socialMedia : null;
            $validated['is_active'] = $request->has('is_active');
            
            // Prepare quick cards data (dynamic up to 10)
            $quickCards = [];
            for ($i = 1; $i <= 10; $i++) {
                if (!empty($request->input("quick_card_{$i}_title"))) {
                    $quickCards[] = [
                        'icon' => $request->input("quick_card_{$i}_icon") ?: 'fas fa-info-circle',
                        'title' => $request->input("quick_card_{$i}_title"),
                        'description' => $request->input("quick_card_{$i}_description") ?: ''
                    ];
                }
            }
            // Only set quick_cards if the column exists
            if (\Schema::hasColumn('contacts', 'quick_cards')) {
                $validated['quick_cards'] = !empty($quickCards) ? $quickCards : null;
            }
            
            // Handle hero image upload
            if ($request->hasFile('hero_image') && \Schema::hasColumn('contacts', 'hero_image')) {
                // Delete old hero image if exists
                if ($contact->hero_image && file_exists(public_path('storage/' . $contact->hero_image))) {
                    unlink(public_path('storage/' . $contact->hero_image));
                }
                
                $heroImage = $request->file('hero_image');
                $filename = time() . '_hero_' . $heroImage->getClientOriginalName();
                $path = $heroImage->storeAs('contacts/hero', $filename, 'public');
                $validated['hero_image'] = $path;
            }

            $contact->update($validated);

            return redirect()->route('admin.contacts.index')
                           ->with('success', 'Kontak berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput()
                           ->with('error', 'Terdapat kesalahan validasi. Silakan periksa kembali.');
        } catch (\Exception $e) {
            Log::error('Error updating contact:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'contact_id' => $contact->id,
                'request' => $request->all()
            ]);

            // Check if it's a database column error
            if (strpos($e->getMessage(), 'quick_cards') !== false) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Database belum diupdate. Silakan jalankan: php artisan migrate');
            }

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat memperbarui kontak: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();

            return redirect()->route('admin.contacts.index')
                           ->with('success', 'Kontak berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Error deleting contact:', [
                'error' => $e->getMessage(),
                'contact_id' => $contact->id
            ]);

            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menghapus kontak.');
        }
    }

    /**
     * Activate contact
     */
    public function activate(Contact $contact)
    {
        try {
            $contact->update(['is_active' => true]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Contact activated successfully!'
                ]);
            }

            return redirect()->back()
                           ->with('success', 'Kontak berhasil diaktifkan!');

        } catch (\Exception $e) {
            Log::error('Error activating contact:', [
                'error' => $e->getMessage(),
                'contact_id' => $contact->id
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to activate contact'
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat mengaktifkan kontak.');
        }
    }

    /**
     * Deactivate contact
     */
    public function deactivate(Contact $contact)
    {
        try {
            $contact->update(['is_active' => false]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Contact deactivated successfully!'
                ]);
            }

            return redirect()->back()
                           ->with('success', 'Kontak berhasil dinonaktifkan!');

        } catch (\Exception $e) {
            Log::error('Error deactivating contact:', [
                'error' => $e->getMessage(),
                'contact_id' => $contact->id
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to deactivate contact'
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menonaktifkan kontak.');
        }
    }
}