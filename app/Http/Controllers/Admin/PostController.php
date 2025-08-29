<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author', 'tags'])
                    ->latest();

        if ($request->type) {
            $query->byType($request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $tags = Tag::all();
        
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'type' => 'required|in:slideshow,agenda,announcement,editorial,blog,quotes,facility,extracurricular,achievement,staff',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            // 'content' => $request->content,
            'type' => $request->type,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'published_at' => $request->status === 'published' ? now() : null,
            'created_by' => auth()->id(),
            'meta_data' => $this->processMetaData($request),
        ]);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $post->addMediaFromRequest('featured_image')
                 ->toMediaCollection('featured');
        }

        // Handle tags
        if ($request->tags) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('admin.posts.index')
                        ->with('success', 'Post berhasil dibuat.');
    }

    private function processMetaData(Request $request): array
    {
        $metaData = [];

        switch ($request->type) {
            case 'agenda':
                $metaData = [
                    'event_date' => $request->event_date,
                    'event_time' => $request->event_time,
                    'location' => $request->location,
                    'organizer' => $request->organizer,
                ];
                break;
            
            case 'announcement':
                $metaData = [
                    'priority' => $request->priority ?? 'normal',
                    'expires_at' => $request->expires_at,
                    'send_notification' => $request->boolean('send_notification'),
                ];
                break;

            case 'quotes':
                $metaData = [
                    'author' => $request->quote_author,
                    'display_duration' => $request->display_duration ?? 7,
                ];
                break;
        }

        return $metaData;
    }
}