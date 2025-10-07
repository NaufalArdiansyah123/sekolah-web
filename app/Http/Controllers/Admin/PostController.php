<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CalendarEvent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    // Slideshow Methods
    public function slideshow()
    {
        $slideshows = Post::where('type', 'slideshow')
                         ->latest()
                         ->paginate(10);
        
        return view('admin.posts.slideshow.index', compact('slideshows'));
    }

    public function createSlideshow()
    {
        return view('admin.posts.slideshow.create');
    }

    public function storeSlideshow(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived'
        ]);

        $imagePath = $request->file('image')->store('slideshows', 'public');

        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content ?? '',
            'type' => 'slideshow',
            'image' => $imagePath,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.posts.slideshow')
                        ->with('success', 'Slideshow berhasil ditambahkan!');
    }

    public function editSlideshow($id)
    {
        $slideshow = Post::where('type', 'slideshow')->findOrFail($id);
        return view('admin.posts.slideshow.edit', compact('slideshow'));
    }

    public function updateSlideshow(Request $request, $id)
    {
        $slideshow = Post::where('type', 'slideshow')->findOrFail($id);
        
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived'
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content ?? $slideshow->content,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('slideshows', 'public');
        }

        $slideshow->update($data);

        return redirect()->route('admin.posts.slideshow')
                        ->with('success', 'Slideshow berhasil diperbarui!');
    }

    public function destroySlideshow($id)
    {
        $slideshow = Post::where('type', 'slideshow')->findOrFail($id);
        $slideshow->delete();

        return redirect()->route('admin.posts.slideshow')
                        ->with('success', 'Slideshow berhasil dihapus!');
    }

    // Agenda Methods
    public function agenda(Request $request)
    {
        $query = Post::where('type', 'agenda')
                     ->with('user')
                     ->latest('event_date');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Period filter
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'upcoming':
                    $query->where('event_date', '>', now());
                    break;
                case 'today':
                    $query->whereDate('event_date', today());
                    break;
                case 'past':
                    $query->where('event_date', '<', now());
                    break;
            }
        }
        
        $agendas = $query->paginate(10);
        
        return view('admin.posts.agenda.index', compact('agendas'));
    }

    public function createAgenda()
    {
        return view('admin.posts.agenda.create');
    }

    public function storeAgenda(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'event_date' => 'required|date',
            'location' => 'nullable|max:255',
            'status' => 'required|in:draft,published,archived'
        ]);

        try {
            DB::beginTransaction();

            // Create agenda post
            $agenda = Post::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'type' => 'agenda',
                'event_date' => $request->event_date,
                'location' => $request->location,
                'status' => $request->status,
                'user_id' => auth()->id(),
            ]);

            // Auto-sync to calendar if status is published
            if ($request->status === 'published') {
                CalendarEvent::create([
                    'title' => $request->title,
                    'description' => $request->content,
                    'start_date' => $request->event_date,
                    'end_date' => $request->event_date,
                    'color' => '#10b981', // Green for agenda
                    'type' => 'agenda',
                    'location' => $request->location,
                    'created_by' => auth()->id(),
                    'source_type' => 'agenda',
                    'source_id' => $agenda->id
                ]);
            }

            DB::commit();

            $message = 'Agenda berhasil ditambahkan!';
            if ($request->status === 'published') {
                $message .= ' Event juga telah ditambahkan ke kalender akademik.';
            }

            return redirect()->route('admin.posts.agenda')
                            ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating agenda: ' . $e->getMessage());
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Terjadi kesalahan saat menyimpan agenda.');
        }
    }

    public function editAgenda($id)
    {
        $agenda = Post::where('type', 'agenda')->findOrFail($id);
        return view('admin.posts.agenda.edit', compact('agenda'));
    }

    public function updateAgenda(Request $request, $id)
    {
        $agenda = Post::where('type', 'agenda')->findOrFail($id);
        
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'event_date' => 'required|date',
            'location' => 'nullable|max:255',
            'status' => 'required|in:draft,published,archived'
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $agenda->status;

            // Update agenda post
            $agenda->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'event_date' => $request->event_date,
                'location' => $request->location,
                'status' => $request->status,
            ]);

            // Handle calendar synchronization
            $calendarEvent = CalendarEvent::where('source_type', 'agenda')
                                         ->where('source_id', $agenda->id)
                                         ->first();

            if ($request->status === 'published') {
                if ($calendarEvent) {
                    // Update existing calendar event
                    $calendarEvent->update([
                        'title' => $request->title,
                        'description' => $request->content,
                        'start_date' => $request->event_date,
                        'end_date' => $request->event_date,
                        'location' => $request->location
                    ]);
                } else {
                    // Create new calendar event
                    CalendarEvent::create([
                        'title' => $request->title,
                        'description' => $request->content,
                        'start_date' => $request->event_date,
                        'end_date' => $request->event_date,
                        'color' => '#10b981', // Green for agenda
                        'type' => 'agenda',
                        'location' => $request->location,
                        'created_by' => auth()->id(),
                        'source_type' => 'agenda',
                        'source_id' => $agenda->id
                    ]);
                }
            } else {
                // If status changed from published to draft/archived, remove from calendar
                if ($calendarEvent && $oldStatus === 'published') {
                    $calendarEvent->delete();
                }
            }

            DB::commit();

            $message = 'Agenda berhasil diperbarui!';
            if ($request->status === 'published') {
                $message .= ' Kalender akademik telah disinkronkan.';
            } elseif ($oldStatus === 'published' && $request->status !== 'published') {
                $message .= ' Event telah dihapus dari kalender akademik.';
            }

            return redirect()->route('admin.posts.agenda')
                            ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating agenda: ' . $e->getMessage());
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Terjadi kesalahan saat memperbarui agenda.');
        }
    }

    public function destroyAgenda($id)
    {
        $agenda = Post::where('type', 'agenda')->findOrFail($id);
        
        try {
            DB::beginTransaction();

            // Delete related calendar event if exists
            CalendarEvent::where('source_type', 'agenda')
                        ->where('source_id', $agenda->id)
                        ->delete();

            // Delete agenda
            $agenda->delete();

            DB::commit();

            return redirect()->route('admin.posts.agenda')
                            ->with('success', 'Agenda berhasil dihapus! Event juga telah dihapus dari kalender akademik.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting agenda: ' . $e->getMessage());
            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan saat menghapus agenda.');
        }
    }

    // Announcement Methods
    public function announcement()
    {
        $announcements = Post::where('type', 'announcement')
                            ->latest()
                            ->paginate(10);
        
        return view('admin.posts.announcement.index', compact('announcements'));
    }

    public function createAnnouncement()
    {
        return view('admin.posts.announcement.create');
    }

    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:draft,published,archived'
        ]);

        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'type' => 'announcement',
            'priority' => $request->priority,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.posts.announcement')
                        ->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function editAnnouncement($id)
    {
        $announcement = Post::where('type', 'announcement')->findOrFail($id);
        return view('admin.posts.announcement.edit', compact('announcement'));
    }

    public function updateAnnouncement(Request $request, $id)
    {
        $announcement = Post::where('type', 'announcement')->findOrFail($id);
        
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:draft,published,archived'
        ]);

        $announcement->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.posts.announcement')
                        ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroyAnnouncement($id)
    {
        $announcement = Post::where('type', 'announcement')->findOrFail($id);
        $announcement->delete();

        return redirect()->route('admin.posts.announcement')
                        ->with('success', 'Pengumuman berhasil dihapus!');
    }

    // Blog Methods
    public function blog()
    {
        $blogs = Post::where('type', 'blog')
                    ->latest()
                    ->paginate(10);
        
        return view('admin.posts.blog.index', compact('blogs'));
    }

    public function createBlog()
    {
        return view('admin.posts.blog.create');
    }

    public function storeBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived'
        ]);

    $data = [
    'title' => $request->title,
    'slug' => Str::slug($request->title),
    'excerpt' => $request->excerpt,
    'content' => $request->input('content'), // ✅ sudah benar
    'type' => 'blog',
    'tags' => $request->tags,
    'status' => $request->status,
    'user_id' => auth()->id(),
];

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.blog')
                        ->with('success', 'Blog berhasil ditambahkan!');

    }

    public function editBlog($id)
    {
        $blog = Post::where('type', 'blog')->findOrFail($id);
        return view('admin.posts.blog.edit', compact('blog'));
    }

    public function updateBlog(Request $request, $id)
    {
        $blog = Post::where('type', 'blog')->findOrFail($id);
        
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived'
        ]);

       $data = [
    'title' => $request->title,
    'slug' => Str::slug($request->title),
    'excerpt' => $request->excerpt,
    'content' => $request->input('content'), // ✅ tambahkan ini
    'tags' => $request->tags,
    'status' => $request->status,
];


        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.posts.blog')
                        ->with('success', 'Blog berhasil diperbarui!');
    }

    public function destroyBlog($id)
    {
        $blog = Post::where('type', 'blog')->findOrFail($id);
        $blog->delete();

        return redirect()->route('admin.posts.blog')
                        ->with('success', 'Blog berhasil dihapus!');
    }

     public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }
    
    public function showAgenda($id)
    {
        $agenda = Post::where('type', 'agenda')->findOrFail($id);
        return view('admin.posts.agenda.show', compact('agenda'));
    }

}