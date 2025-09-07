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

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('profile');
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
    
    // ===========================================
    // SLIDESHOW ROUTES - DIPERBAIKI & DISATUKAN
    // ===========================================
    Route::prefix('posts')->name('posts.')->group(function () {
        // Slideshow Management - Menggunakan SlideshowController
        Route::get('/slideshow', [SlideshowController::class, 'index'])->name('slideshow');
        Route::get('/slideshow/create', [SlideshowController::class, 'create'])->name('slideshow.create');
        Route::post('/slideshow', [SlideshowController::class, 'store'])->name('slideshow.store');
        Route::get('/slideshow/{slideshow}/edit', [SlideshowController::class, 'edit'])->name('slideshow.edit');
        Route::put('/slideshow/{slideshow}', [SlideshowController::class, 'update'])->name('slideshow.update');
        Route::delete('/slideshow/{slideshow}', [SlideshowController::class, 'destroy'])->name('slideshow.destroy');
        
        // Other Post Routes
        Route::get('/agenda', [PostController::class, 'agenda'])->name('agenda');
        Route::get('/blog', [PostController::class, 'blog'])->name('blog');
        Route::get('/quote', [PostController::class, 'quote'])->name('quote');
        
        // Announcement Routes
        Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement');
        Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('announcement.create');
        Route::post('/announcement', [AnnouncementController::class, 'store'])->name('announcement.store');
        Route::get('/announcement/{id}', [AnnouncementController::class, 'show'])->name('announcement.show');
        Route::get('/announcement/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcement.edit');
        Route::put('/announcement/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
        Route::delete('/announcement/{id}', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');
        Route::post('/announcement/{id}/toggle-status', [AnnouncementController::class, 'toggleStatus'])->name('announcement.toggle-status');
        
        // Agenda Routes (jika menggunakan PostController)
        Route::get('/agenda/create', [PostController::class, 'createAgenda'])->name('agenda.create');
        Route::post('/agenda', [PostController::class, 'storeAgenda'])->name('agenda.store');
        Route::get('/agenda/{id}/edit', [PostController::class, 'editAgenda'])->name('agenda.edit');
        Route::put('/agenda/{id}', [PostController::class, 'updateAgenda'])->name('agenda.update');
        Route::delete('/agenda/{id}', [PostController::class, 'destroyAgenda'])->name('agenda.destroy');
        
        // Blog Routes (jika menggunakan PostController)
        Route::get('/blog/create', [PostController::class, 'createBlog'])->name('blog.create');
        Route::post('/blog', [PostController::class, 'storeBlog'])->name('blog.store');
        Route::get('/blog/{id}/edit', [PostController::class, 'editBlog'])->name('blog.edit');
        Route::put('/blog/{id}', [PostController::class, 'updateBlog'])->name('blog.update');
        Route::delete('/blog/{id}', [PostController::class, 'destroyBlog'])->name('blog.destroy');
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
    
    // ANNOUNCEMENT ROUTES (Resource routes untuk backup/alternatif)
    Route::resource('announcements', AnnouncementController::class);
    Route::post('announcements/{id}/toggle-status', [AnnouncementController::class, 'toggleStatus'])
         ->name('announcements.toggle-status');
    
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

// ========== PUBLIC ROUTES untuk announcements ==========
Route::group(['prefix' => 'announcements'], function () {
    Route::get('/', [AnnouncementController::class, 'publicIndex'])->name('announcements.index');
    Route::get('/{id}', [AnnouncementController::class, 'publicShow'])->name('announcements.show');
});

/*
|--------------------------------------------------------------------------
| Gallery Routes - Admin & Public
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

// Halaman daftar galeri
Route::get('/gallery/photos', [App\Http\Controllers\GalleryController::class, 'index'])
    ->name('gallery.photos.index');

// Halaman detail galeri (pakai slug)
Route::get('/gallery/photos/{slug}', [App\Http\Controllers\GalleryController::class, 'show'])
    ->name('gallery.photos');