<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TempatPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TempatPklController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TempatPkl::query();

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tempat', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('pembimbing_lapangan', 'like', "%{$search}%");
            });
        }

        $tempatPkls = $query->orderBy('nama_tempat')->paginate(15);

        return view('admin.tempat-pkl.index', compact('tempatPkls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tempat-pkl.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'pembimbing_lapangan' => 'nullable|string|max:255',
            'kuota' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        try {
            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('gambar')) {
                $imageName = time() . '.' . $request->gambar->extension();
                $request->gambar->move(public_path('images/tempat-pkl'), $imageName);
                $data['gambar'] = 'images/tempat-pkl/' . $imageName;
            }

            TempatPkl::create($data);

            return redirect()->route('admin.tempat-pkl.index')
                ->with('success', 'Tempat PKL berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating tempat PKL', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan tempat PKL: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TempatPkl $tempatPkl)
    {
        // Load approved registrations with student details
        $tempatPkl->load([
            'approvedRegistrations' => function ($query) {
                $query->with('student');
            }
        ]);

        return view('admin.tempat-pkl.show', compact('tempatPkl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TempatPkl $tempatPkl)
    {
        return view('admin.tempat-pkl.edit', compact('tempatPkl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TempatPkl $tempatPkl)
    {
        $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'pembimbing_lapangan' => 'nullable|string|max:255',
            'kuota' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        try {
            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($tempatPkl->gambar && file_exists(public_path($tempatPkl->gambar))) {
                    unlink(public_path($tempatPkl->gambar));
                }

                $imageName = time() . '.' . $request->gambar->extension();
                $request->gambar->move(public_path('images/tempat-pkl'), $imageName);
                $data['gambar'] = 'images/tempat-pkl/' . $imageName;
            }

            $tempatPkl->update($data);

            return redirect()->route('admin.tempat-pkl.index')
                ->with('success', 'Tempat PKL berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating tempat PKL', [
                'id' => $tempatPkl->id,
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui tempat PKL: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TempatPkl $tempatPkl)
    {
        try {
            $tempatPkl->delete();

            return redirect()->route('admin.tempat-pkl.index')
                ->with('success', 'Tempat PKL berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting tempat PKL', [
                'id' => $tempatPkl->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus tempat PKL: ' . $e->getMessage());
        }
    }
}
