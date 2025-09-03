<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Extracurricular, Achievement, Teacher, Student};


// TeacherController.php
class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'nip' => 'nullable|unique:teachers,nip',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'subject' => 'required|max:255',
            'position' => 'required|max:255',
            'education' => 'nullable|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('photo');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        Teacher::create($data);

        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|max:255',
            'nip' => 'nullable|unique:teachers,nip,' . $teacher->id,
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'subject' => 'required|max:255',
            'position' => 'required|max:255',
            'education' => 'nullable|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update($data);

        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->photo && \Storage::disk('public')->exists($teacher->photo)) {
            \Storage::disk('public')->delete($teacher->photo);
        }

        $teacher->delete();

        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Data guru berhasil dihapus!');
    }
}