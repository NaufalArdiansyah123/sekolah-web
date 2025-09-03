<?php
// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AcademicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\GalleryController;


// 
use App\Http\Controllers\Admin\{
    DashboardController,
    PostController,
    DownloadController,
    ExtracurricularController,
    AchievementController,
    TeacherController,
    StudentController,
    UserController,
    RoleController,
    SettingController,
    SlideshowController,
};
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about/profile', [PublicController::class, 'aboutProfile'])->name('about.profile');
Route::get('/about/vision', [PublicController::class, 'aboutVision'])->name('about.vision');
Route::get('/about/sejarah', [PublicController::class, 'sejarah'])->name('about.sejarah');
Route::get('/facilities', [PublicController::class, 'facilities'])->name('facilities.index');
Route::get('/achievements', [PublicController::class, 'achievements'])->name('achievements.index');
Route::get('/extracurriculars', [PublicController::class, 'extracurriculars'])->name('extracurriculars.index');
Route::get('/academic/programs', [PublicController::class, 'academicPrograms'])->name('academic.programs');
Route::get('/academic/programs', [AcademicController::class, 'index'])->name('public.academic.programs');
Route::get('/academic/calendar', [PublicController::class, 'academicCalendar'])->name('academic.calendar');
Route::get('/news', [PublicController::class, 'news'])->name('news.index');
Route::get('/news/{slug}', [PublicController::class, 'newsDetail'])->name('news.show');
Route::get('/announcements', [PublicController::class, 'announcements'])->name('announcements.index');
Route::get('/announcements/{slug}', [PublicController::class, 'announcementDetail'])->name('announcements.show');
Route::get('/agenda', [PublicController::class, 'agenda'])->name('agenda.index');
Route::get('/gallery/photos', [PublicController::class, 'galleryPhotos'])->name('gallery.photos');
Route::get('/gallery/videos', [PublicController::class, 'galleryVideos'])->name('gallery.videos');
Route::get('/gallery/index', [PublicController::class, 'galleryVideos'])->name('gallery.index');
Route::get('/downloads', [PublicController::class, 'downloads'])->name('downloads.index');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->hasRole('super_admin') || $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('teacher')) {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->hasRole('student')) {
            return redirect()->route('student.dashboard');
        } elseif ($user->hasRole('parent')) {
            return redirect()->route('parent.dashboard');
        }
        
        return redirect()->route('home');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin,admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('profile');
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
    
    // Content Management Routes
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/slideshow', function () { return view('admin.posts.slideshow.index'); })->name('slideshow');
        Route::get('/agenda', function () { return view('admin.posts.agenda.index'); })->name('agenda');
        Route::get('/announcement', function () { return view('admin.posts.announcement.index'); })->name('announcement');
        Route::get('/blog', function () { return view('admin.posts.blog.index'); })->name('blog');
        Route::get('/quote', function () { return view('admin.posts.quote.index'); })->name('quote');
    });
    
    // Academic Management Routes
    Route::get('/facilities', function () { return view('admin.facilities.index'); })->name('facilities.index');
    Route::get('/extracurriculars', function () { return view('admin.extracurriculars.index'); })->name('extracurriculars.index');
    Route::get('/achievements', function () { return view('admin.achievements.index'); })->name('achievements.index');
    Route::get('/teachers', function () { return view('admin.teachers.index'); })->name('teachers.index');
    Route::get('/students', function () { return view('admin.students.index'); })->name('students.index');
    
    // Media & Files Routes
    Route::get('/downloads', function () { return view('admin.downloads.index'); })->name('downloads.index');
    Route::get('/gallery', function () { return view('admin.gallery.index'); })->name('gallery.index');
    
    // Learning Management Routes
    Route::get('/materials', function () { return view('admin.materials.index'); })->name('materials.index');
    Route::get('/assignments', function () { return view('admin.assignments.index'); })->name('assignments.index');
    
    // System Routes
    Route::get('/users', function () { return view('admin.users.index'); })->name('users.index');
    Route::get('/roles', function () { return view('admin.roles.index'); })->name('roles.index');
});

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
});



/*
|--------------------------------------------------------------------------
| Upload berbagai macam
|--------------------------------------------------------------------------
*/


// routes/web.php



Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // TAMBAHKAN ANNOUNCEMENT ROUTES DI SINI:
    // =======================================
    // Standard CRUD routes for announcements
    Route::resource('announcements', AnnouncementController::class);
    
    // Additional custom routes
    Route::post('announcements/{id}/toggle-status', [AnnouncementController::class, 'toggleStatus'])
         ->name('announcements.toggle-status');
    // =======================================
    
    // Content Management Routes
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/slideshow', [PostController::class, 'slideshow'])->name('slideshow');
        Route::get('/agenda', [PostController::class, 'agenda'])->name('agenda');
        Route::get('/announcement', [PostController::class, 'announcement'])->name('announcement');
        Route::get('/blog', [PostController::class, 'blog'])->name('blog');
        
        // CRUD operations for each post type
        Route::get('/slideshow/create', [PostController::class, 'createSlideshow'])->name('slideshow.create');
        Route::post('/slideshow', [PostController::class, 'storeSlideshow'])->name('slideshow.store');
        Route::get('/slideshow/{id}/edit', [PostController::class, 'editSlideshow'])->name('slideshow.edit');
        Route::put('/slideshow/{id}', [PostController::class, 'updateSlideshow'])->name('slideshow.update');
        Route::delete('/slideshow/{id}', [PostController::class, 'destroySlideshow'])->name('slideshow.destroy');
        
        Route::get('/agenda/create', [PostController::class, 'createAgenda'])->name('agenda.create');
        Route::post('/agenda', [PostController::class, 'storeAgenda'])->name('agenda.store');
        Route::get('/agenda/{id}/edit', [PostController::class, 'editAgenda'])->name('agenda.edit');
        Route::put('/agenda/{id}', [PostController::class, 'updateAgenda'])->name('agenda.update');
        Route::delete('/agenda/{id}', [PostController::class, 'destroyAgenda'])->name('agenda.destroy');
        
        
        
        Route::get('/blog/create', [PostController::class, 'createBlog'])->name('blog.create');
        Route::post('/blog', [PostController::class, 'storeBlog'])->name('blog.store');
        Route::get('/blog/{id}/edit', [PostController::class, 'editBlog'])->name('blog.edit');
        Route::put('/blog/{id}', [PostController::class, 'updateBlog'])->name('blog.update');
        Route::delete('/blog/{id}', [PostController::class, 'destroyBlog'])->name('blog.destroy');
    });
    
    // Media & Files Routes
    // Route::resource('downloads', DownloadController::class);
    // Route::resource('gallery', GalleryController::class);
    // Route::post('/gallery/upload', [GalleryController::class, 'upload'])->name('gallery.upload');
    
    // Academic Routes
    Route::resource('extracurriculars', ExtracurricularController::class);
    Route::resource('achievements', AchievementController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);
    
    // System Routes
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/slideshow', [SlideshowController::class, 'index'])->name('slideshow');
        Route::get('/slideshow/create', [SlideshowController::class, 'create'])->name('slideshow.create');
        Route::post('/slideshow', [SlideshowController::class, 'store'])->name('slideshow.store');
        Route::get('/slideshow/{slideshow}/edit', [SlideshowController::class, 'edit'])->name('slideshow.edit');
        Route::put('/slideshow/{slideshow}', [SlideshowController::class, 'update'])->name('slideshow.update');
        Route::delete('/slideshow/{slideshow}', [SlideshowController::class, 'destroy'])->name('slideshow.destroy');
    });
});

// ========== PUBLIC ROUTES untuk announcements ==========
Route::group(['prefix' => 'announcements'], function () {
    Route::get('/', [AnnouncementController::class, 'publicIndex'])->name('announcements.index');
    Route::get('/{id}', [AnnouncementController::class, 'publicShow'])->name('announcements.show');
});

/*
|--------------------------------------------------------------------------
| bintang 1-9-2025
|--------------------------------------------------------------------------
*/

// Admin Gallery Routes (Protected by auth middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('index');
        Route::get('/upload', [App\Http\Controllers\Admin\GalleryController::class, 'upload'])->name('upload');
        Route::post('/store', [App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('store');
        Route::delete('/{albumId}', [App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('destroy');
    });
});

// Public Gallery Routes
Route::prefix('gallery')->name('gallery.')->group(function () {
    Route::get('/', [App\Http\Controllers\Public\GalleryController::class, 'index'])->name('index');
    Route::get('/photos/{slug}', [App\Http\Controllers\Public\GalleryController::class, 'photos'])->name('photos');
    Route::get('/download/{slug}', [App\Http\Controllers\Public\GalleryController::class, 'downloadAlbum'])->name('download');
    
});


// Photos management
    // Route::prefix('galleries/{gallery}')->name('galleries.')->group(function () {
    //     Route::get('/photos', [AdminPhotoController::class, 'index'])->name('photos.index');
    //     Route::get('/photos/create', [AdminPhotoController::class, 'create'])->name('photos.create');
    //     Route::post('/photos', [AdminPhotoController::class, 'store'])->name('photos.store');
    //     Route::get('/photos/{photo}', [AdminPhotoController::class, 'show'])->name('photos.show');
    //     Route::get('/photos/{photo}/edit', [AdminPhotoController::class, 'edit'])->name('photos.edit');
    //     Route::put('/photos/{photo}', [AdminPhotoController::class, 'update'])->name('photos.update');
    //     Route::delete('/photos/{photo}', [AdminPhotoController::class, 'destroy'])->name('photos.destroy');
    // });


// Halaman daftar galeri
Route::get('/gallery/photos', [App\Http\Controllers\GalleryController::class, 'index'])
    ->name('gallery.photos.index');

// Halaman detail galeri (pakai slug)
Route::get('/gallery/photos/{slug}', [App\Http\Controllers\GalleryController::class, 'show'])
    ->name('gallery.photos');


?>
