<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Download;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::latest()->paginate(10);
        return view('admin.downloads.index', compact('downloads'));
    }

    public function create()
    {
        return view('admin.downloads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'file' => 'required|file|max:10240', // 10MB max
            'category' => 'required|max:100',
            'status' => 'required|in:active,inactive'
        ]);

        $filePath = $request->file('file')->store('downloads', 'public');
        $fileName = $request->file('file')->getClientOriginalName();
        $fileSize = $request->file('file')->getSize();

        Download::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'category' => $request->category,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.downloads.index')
                        ->with('success', 'File download berhasil ditambahkan!');
    }

    public function show(Download $download)
    {
        return view('admin.downloads.show', compact('download'));
    }

    public function edit(Download $download)
    {
        return view('admin.downloads.edit', compact('download'));
    }

    public function update(Request $request, Download $download)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'file' => 'nullable|file|max:10240',
            'category' => 'required|max:100',
            'status' => 'required|in:active,inactive'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status,
        ];

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('downloads', 'public');
            $data['file_name'] = $request->file('file')->getClientOriginalName();
            $data['file_size'] = $request->file('file')->getSize();
        }

        $download->update($data);

        return redirect()->route('admin.downloads.index')
                        ->with('success', 'File download berhasil diperbarui!');
    }

    public function destroy(Download $download)
    {
        // Delete file from storage
        if ($download->file_path && \Storage::disk('public')->exists($download->file_path)) {
            \Storage::disk('public')->delete($download->file_path);
        }

        $download->delete();

        return redirect()->route('admin.downloads.index')
                        ->with('success', 'File download berhasil dihapus!');
    }
}