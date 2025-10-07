<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class TeacherController extends Controller
{
    /**
     * Display a listing of active teachers for public view with organizational hierarchy
     */
    public function index(Request $request)
    {
        $query = Teacher::active();
        
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
        
        // Order by hierarchy: Principal -> Vice Principal -> Department Heads -> Teachers -> Staff
        $query->orderByRaw("
            CASE 
                WHEN position LIKE '%Kepala Sekolah%' THEN 1
                WHEN position LIKE '%Wakil Kepala%' THEN 2
                WHEN position LIKE '%Kepala%' AND position NOT LIKE '%Kepala Sekolah%' AND position NOT LIKE '%Wakil Kepala%' THEN 3
                WHEN position LIKE '%Guru%' AND position NOT LIKE '%Kepala%' THEN 4
                ELSE 5
            END, name ASC
        ");
        
        $teachers = $query->get(); // Get all for organizational chart display
        
        // Get unique subjects for filter
        $subjects = Teacher::active()
            ->pluck('subject')
            ->flatMap(function ($subject) {
                return explode(',', $subject);
            })
            ->map(function ($subject) {
                return trim($subject);
            })
            ->filter(function ($subject) {
                return !empty($subject);
            })
            ->unique()
            ->sort()
            ->values();
        
        // Get unique positions for filter
        $positions = Teacher::active()
            ->pluck('position')
            ->filter(function ($position) {
                return !empty($position);
            })
            ->unique()
            ->sort()
            ->values();
        
        // Add initials property to each teacher for photo placeholder
        $teachers->each(function ($teacher) {
            $nameParts = explode(' ', $teacher->name);
            $initials = '';
            foreach ($nameParts as $part) {
                if (!empty($part)) {
                    $initials .= strtoupper(substr($part, 0, 1));
                }
            }
            $teacher->initials = substr($initials, 0, 2); // Limit to 2 characters
        });
        
        return view('public.teachers.index', compact('teachers', 'subjects', 'positions'));
    }
    
    /**
     * Display the specified teacher
     */
    public function show($id)
    {
        $teacher = Teacher::active()->findOrFail($id);
        
        // Add initials for photo placeholder
        $nameParts = explode(' ', $teacher->name);
        $initials = '';
        foreach ($nameParts as $part) {
            if (!empty($part)) {
                $initials .= strtoupper(substr($part, 0, 1));
            }
        }
        $teacher->initials = substr($initials, 0, 2);
        
        // Get related teachers (same subject or position level)
        $relatedTeachers = Teacher::active()
            ->where('id', '!=', $teacher->id)
            ->where(function($query) use ($teacher) {
                // Same subject
                if ($teacher->subject) {
                    $subjects = explode(',', $teacher->subject);
                    foreach ($subjects as $subject) {
                        $query->orWhere('subject', 'LIKE', '%' . trim($subject) . '%');
                    }
                }
                
                // Same position level
                if (strpos($teacher->position, 'Kepala') !== false) {
                    $query->orWhere('position', 'LIKE', '%Kepala%');
                } elseif (strpos($teacher->position, 'Guru') !== false) {
                    $query->orWhere('position', 'LIKE', '%Guru%');
                }
            })
            ->limit(6)
            ->get();
        
        // Add initials to related teachers
        $relatedTeachers->each(function ($relatedTeacher) {
            $nameParts = explode(' ', $relatedTeacher->name);
            $initials = '';
            foreach ($nameParts as $part) {
                if (!empty($part)) {
                    $initials .= strtoupper(substr($part, 0, 1));
                }
            }
            $relatedTeacher->initials = substr($initials, 0, 2);
        });
        
        return view('public.teachers.show', compact('teacher', 'relatedTeachers'));
    }
}