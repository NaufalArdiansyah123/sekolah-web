<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of active teachers for public view
     */
    public function index(Request $request)
    {
        $query = Teacher::active()->latest();
        
        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('subject', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('position', 'LIKE', '%' . $request->search . '%');
            });
        }
        
        // Filter berdasarkan mata pelajaran
        if ($request->filled('subject')) {
            $query->where('subject', 'LIKE', '%' . $request->subject . '%');
        }
        
        // Filter berdasarkan posisi
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }
        
        $teachers = $query->paginate(12);
        
        // Get unique subjects for filter
        $subjects = Teacher::active()
            ->pluck('subject')
            ->flatMap(function ($subject) {
                return explode(',', $subject);
            })
            ->map(function ($subject) {
                return trim($subject);
            })
            ->unique()
            ->sort()
            ->values();
        
        // Get unique positions for filter
        $positions = Teacher::active()
            ->pluck('position')
            ->unique()
            ->sort()
            ->values();
        
        return view('public.teachers.index', compact('teachers', 'subjects', 'positions'));
    }
    
    /**
     * Display the specified teacher
     */
    public function show($id)
    {
        $teacher = Teacher::active()->findOrFail($id);
        
        // Get related teachers (same subject)
        $relatedTeachers = Teacher::active()
            ->where('id', '!=', $teacher->id)
            ->where(function($query) use ($teacher) {
                $subjects = explode(',', $teacher->subject);
                foreach ($subjects as $subject) {
                    $query->orWhere('subject', 'LIKE', '%' . trim($subject) . '%');
                }
            })
            ->limit(4)
            ->get();
        
        return view('public.teachers.show', compact('teacher', 'relatedTeachers'));
    }
}