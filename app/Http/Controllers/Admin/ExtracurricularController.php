<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Extracurricular, Achievement, Teacher, Student};

// ExtracurricularController.php
class ExtracurricularController extends Controller
{
    public function index()
    {
        $extracurriculars = Extracurricular::latest()->paginate(10);
        return view('admin.extracurriculars.index', compact('extracurriculars'));
    }

    public function create()
    {
        return view('admin.extracurriculars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'coach' => 'required|max:255',
            'schedule' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('extracurriculars', 'public');
        }

        Extracurricular::create($data);

        return redirect()->route('admin.extracurriculars.index')
                        ->with('success', 'Ekstrakurikuler berhasil ditambahkan!');
    }

    public function show(Extracurricular $extracurricular)
    {
        return view('admin.extracurriculars.show', compact('extracurricular'));
    }

    public function edit(Extracurricular $extracurricular)
    {
        return view('admin.extracurriculars.edit', compact('extracurricular'));
    }

    public function update(Request $request, Extracurricular $extracurricular)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'coach' => 'required|max:255',
            'schedule' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('extracurriculars', 'public');
        }

        $extracurricular->update($data);

        return redirect()->route('admin.extracurriculars.index')
                        ->with('success', 'Ekstrakurikuler berhasil diperbarui!');
    }

    public function destroy(Extracurricular $extracurricular)
    {
        if ($extracurricular->image && \Storage::disk('public')->exists($extracurricular->image)) {
            \Storage::disk('public')->delete($extracurricular->image);
        }

        $extracurricular->delete();

        return redirect()->route('admin.extracurriculars.index')
                        ->with('success', 'Ekstrakurikuler berhasil dihapus!');
    }
}