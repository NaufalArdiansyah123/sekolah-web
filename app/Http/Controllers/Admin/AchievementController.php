<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Extracurricular, Achievement, Teacher, Student};

// ExtracurricularController.php
// AchievementController.php
class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::with('student')->latest()->paginate(10);
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        $students = Student::active()->get();
        return view('admin.achievements.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'student_id' => 'required|exists:students,id',
            'achievement_date' => 'required|date',
            'level' => 'required|in:school,district,city,province,national,international',
            'rank' => 'nullable|max:50',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('certificate');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('certificate')) {
            $data['certificate'] = $request->file('certificate')->store('certificates', 'public');
        }

        Achievement::create($data);

        return redirect()->route('admin.achievements.index')
                        ->with('success', 'Prestasi berhasil ditambahkan!');
    }

    public function show(Achievement $achievement)
    {
        return view('admin.achievements.show', compact('achievement'));
    }

    public function edit(Achievement $achievement)
    {
        $students = Student::active()->get();
        return view('admin.achievements.edit', compact('achievement', 'students'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'student_id' => 'required|exists:students,id',
            'achievement_date' => 'required|date',
            'level' => 'required|in:school,district,city,province,national,international',
            'rank' => 'nullable|max:50',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('certificate');

        if ($request->hasFile('certificate')) {
            $data['certificate'] = $request->file('certificate')->store('certificates', 'public');
        }

        $achievement->update($data);

        return redirect()->route('admin.achievements.index')
                        ->with('success', 'Prestasi berhasil diperbarui!');
    }

    public function destroy(Achievement $achievement)
    {
        if ($achievement->certificate && \Storage::disk('public')->exists($achievement->certificate)) {
            \Storage::disk('public')->delete($achievement->certificate);
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')
                        ->with('success', 'Prestasi berhasil dihapus!');
    }
}