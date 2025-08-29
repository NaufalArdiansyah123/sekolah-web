<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Facility;
use App\Models\Extracurricular;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolInfoController extends Controller
{
    public function facilities(Request $request)
    {
        $facilities = Post::byType('facility')
                         ->with(['category', 'author'])
                         ->latest()
                         ->paginate(12);

        return view('admin.school-info.facilities', compact('facilities'));
    }

    public function storeFacility(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'featured_image' => 'required|image|max:2048',
            'gallery.*' => 'image|max:2048',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            // 'content' => $request->content,
            'type' => 'facility',
            'status' => $request->status ?? 'published',
            'category_id' => $request->category_id,
            'created_by' => auth()->id(),
            'published_at' => now(),
            'meta_data' => [
                'capacity' => $request->capacity,
                'location' => $request->location,
                'features' => $request->features ? explode(',', $request->features) : [],
            ]
        ]);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $post->addMediaFromRequest('featured_image')->toMediaCollection('featured');
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $post->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return redirect()->back()->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function extracurriculars()
    {
        $extracurriculars = Post::byType('extracurricular')
                               ->with(['category', 'author'])
                               ->latest()
                               ->paginate(12);

        return view('admin.school-info.extracurriculars', compact('extracurriculars'));
    }

    public function achievements()
    {
        $achievements = Post::byType('achievement')
                           ->with(['category', 'author'])
                           ->latest()
                           ->paginate(12);

        return view('admin.school-info.achievements', compact('achievements'));
    }

    public function staff()
    {
        $teachers = Teacher::with(['user', 'subjects', 'classes'])
                          ->where('status', 'active')
                          ->paginate(20);

        return view('admin.school-info.staff', compact('teachers'));
    }
}