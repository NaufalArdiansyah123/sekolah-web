<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // For now, return a simple view with sample data
        // In the future, this would fetch from a downloads model
        return view('admin.downloads.index', [
            'title' => 'Manajemen Download',
            'downloads' => collect([]) // Empty collection for now
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.downloads.create', [
            'title' => 'Tambah Download Baru'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'file' => 'required|file|max:51200', // 50MB max
        ]);

        // For now, just return success
        // In the future, this would save to database and handle file upload
        return redirect()->route('admin.downloads.index')
                        ->with('success', 'Download berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.downloads.show', [
            'title' => 'Detail Download',
            'id' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.downloads.edit', [
            'title' => 'Edit Download',
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'file' => 'nullable|file|max:51200', // 50MB max
        ]);

        // For now, just return success
        // In the future, this would update the database record
        return redirect()->route('admin.downloads.index')
                        ->with('success', 'Download berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // For now, just return success
        // In the future, this would delete from database and remove file
        return redirect()->route('admin.downloads.index')
                        ->with('success', 'Download berhasil dihapus.');
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'integer'
        ]);

        $action = $request->action;
        $selectedItems = $request->selected_items;

        // For now, just return success
        // In the future, this would perform bulk operations
        $message = match($action) {
            'delete' => count($selectedItems) . ' download berhasil dihapus.',
            'activate' => count($selectedItems) . ' download berhasil diaktifkan.',
            'deactivate' => count($selectedItems) . ' download berhasil dinonaktifkan.',
        };

        return redirect()->route('admin.downloads.index')
                        ->with('success', $message);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(string $id)
    {
        // For now, just return success
        // In the future, this would toggle featured status in database
        return response()->json([
            'success' => true,
            'message' => 'Status featured berhasil diubah.'
        ]);
    }
}