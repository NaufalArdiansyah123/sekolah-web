<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Extracurricular, Achievement, Teacher, Student};

// StudentController.php
class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'nis' => 'required|unique:students,nis',
            'nisn' => 'nullable|unique:students,nisn',
            'email' => 'nullable|email|unique:students,email',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'class' => 'required|max:50',
            'birth_date' => 'required|date',
            'birth_place' => 'required|max:255',
            'gender' => 'required|in:male,female',
            'parent_name' => 'required|max:255',
            'parent_phone' => 'nullable|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|in:active,inactive,graduated'
        ]);

        $data = $request->except('photo');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        Student::create($data);

        return redirect()->route('admin.students.index')
                        ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|max:255',
            'nis' => 'required|unique:students,nis,' . $student->id,
            'nisn' => 'nullable|unique:students,nisn,' . $student->id,
            'email' => 'nullable|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'class' => 'required|max:50',
            'birth_date' => 'required|date',
            'birth_place' => 'required|max:255',
            'gender' => 'required|in:male,female',
            'parent_name' => 'required|max:255',
            'parent_phone' => 'nullable|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|in:active,inactive,graduated'
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($data);

        return redirect()->route('admin.students.index')
                        ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Student $student)
    {
        if ($student->photo && \Storage::disk('public')->exists($student->photo)) {
            \Storage::disk('public')->delete($student->photo);
        }

        $student->delete();

        return redirect()->route('admin.students.index')
                        ->with('success', 'Data siswa berhasil dihapus!');
    }
}