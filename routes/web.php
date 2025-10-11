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
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Public\BlogController as PublicBlogController;

use App\Http\Controllers\Admin\{
    DashboardController,
    PostController,
    BlogController,  // TAMBAHAN UNTUK BLOG
    VideoController,  // TAMBAHAN UNTUK VIDEO
    ExtracurricularController,
    AchievementController,
    TeacherController,
    StudentController,
    UserController,
    RoleController,
    SettingController,
    SlideshowController,
    CalendarController,
    StudyProgramController,
};

// Import Public Controllers
use App\Http\Controllers\Public\AchievementController as PublicAchievementController;

// Import Student Controllers
use App\Http\Controllers\Student\MaterialController;
use App\Http\Controllers\Student\AssignmentController;
use App\Http\Controllers\Student\GradeController;
use App\Http\Controllers\Student\QuizController;
use App\Http\Controllers\Student\AttendanceController;
// use App\Http\Controllers\Admin\StudyProgramController;

/*
|--------------------------------------------------------------------------
| Debug Session Routes (REMOVE IN PRODUCTION)
|--------------------------------------------------------------------------
*/

// Simple session debug routes
Route::middleware(['web'])->group(function () {
    
    // Test session set
    Route::get('/debug/session/set', function() {
        \Log::info('🧪 Debug session set route called');
        
        session(['debug_test' => 'Session is working!']);
        session(['debug_time' => now()->toDateTimeString()]);
        session()->save();
        
        \Log::info('🧪 Session data set:', [
            'session_id' => session()->getId(),
            'debug_test' => session('debug_test'),
            'all_session' => session()->all()
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Session data set',
            'session_id' => session()->getId(),
            'data' => session()->all()
        ]);
    });
    
    // Test session get
    Route::get('/debug/session/get', function() {
        \Log::info('🧪 Debug session get route called');
        
        $data = [
            'session_id' => session()->getId(),
            'debug_test' => session('debug_test'),
            'all_session' => session()->all()
        ];
        
        \Log::info('🧪 Session data retrieved:', $data);
        
        return response()->json($data);
    });
    
    // Test flash message
    Route::get('/debug/session/flash', function() {
        \Log::info('🧪 Debug flash message route called');
        
        session()->flash('debug_flash', 'This is a flash message!');
        session()->save();
        
        \Log::info('🧪 Flash message set:', [
            'session_id' => session()->getId(),
            'has_debug_flash' => session()->has('debug_flash'),
            'all_session' => session()->all()
        ]);
        
        return redirect('/debug/session/check-flash');
    });
    
    // Check flash message
    Route::get('/debug/session/check-flash', function() {
        \Log::info('🧪 Debug check flash route called');
        
        $data = [
            'session_id' => session()->getId(),
            'has_debug_flash' => session()->has('debug_flash'),
            'debug_flash' => session('debug_flash'),
            'all_session' => session()->all()
        ];
        
        \Log::info('🧪 Flash message checked:', $data);
        
        return response()->json($data);
    });
    
    // Test alternative session method (using put instead of flash)
    Route::get('/debug/session/alt-success', function() {
        \Log::info('🧪 Debug alternative success route called');
        
        // Use session put instead of flash
        session()->put('alt_success_message', 'Alternative success message - modal should appear!');
        session()->put('alt_message_timestamp', now()->timestamp);
        session()->save();
        
        \Log::info('🧪 Alternative session message set:', [
            'session_id' => session()->getId(),
            'has_alt_success_message' => session()->has('alt_success_message'),
            'alt_success_message' => session('alt_success_message'),
            'timestamp' => session('alt_message_timestamp'),
            'all_session' => session()->all()
        ]);
        
        return redirect()->route('admin.settings.index');
    });
    
    // Test alternative session page (Laravel route)
    Route::get('/test-alternative-session', function() {
        $html = '<!DOCTYPE html>
<html>
<head>
    <title>Test Alternative Session Method</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .debug-box { background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .btn { padding: 10px 15px; margin: 5px; background: #007bff; color: white; text-decoration: none; border-radius: 3px; display: inline-block; }
    </style>
</head>
<body>
    <h1>🧪 Test Alternative Session Method</h1>
    
    <div class="debug-box">
        <strong>🔍 Current Session Status:</strong><br>
        Session ID: ' . session()->getId() . '<br>
        Session Driver: ' . config('session.driver') . '<br>
        Session Cookie: ' . config('session.cookie') . '<br>
    </div>';
    
        // Handle test actions
        if (request()->has('action')) {
            switch (request()->get('action')) {
                case 'set_alt_success':
                    session()->put('alt_success_message', 'Alternative success message - this should work!');
                    session()->put('alt_message_timestamp', now()->timestamp);
                    session()->save();
                    $html .= '<div class="success">✅ Alternative success message set in session!</div>';
                    break;
                    
                case 'clear_session':
                    session()->flush();
                    session()->regenerate();
                    $html .= '<div class="success">🧹 Session cleared and regenerated!</div>';
                    break;
            }
        }
        
        // Display current session data
        $html .= '<div class="debug-box">';
        $html .= '<strong>📊 Current Session Data:</strong><br>';
        $sessionData = session()->all();
        if (empty($sessionData)) {
            $html .= 'No session data found.<br>';
        } else {
            foreach ($sessionData as $key => $value) {
                if (!in_array($key, ['_token', '_previous'])) {
                    $html .= $key . ': ' . (is_string($value) ? $value : json_encode($value)) . '<br>';
                }
            }
        }
        $html .= '</div>';
        
        // Check for alternative success message
        if (session()->has('alt_success_message')) {
            $html .= '<div class="success">';
            $html .= '🎉 Alternative Success Message Found: ' . session('alt_success_message');
            if (session()->has('alt_message_timestamp')) {
                $html .= '<br>⏰ Timestamp: ' . date('Y-m-d H:i:s', session('alt_message_timestamp'));
            }
            $html .= '</div>';
            
            // Clear the message after displaying (simulate flash behavior)
            session()->forget(['alt_success_message', 'alt_message_timestamp']);
        }
        
        $html .= '
    <h3>🧪 Test Actions:</h3>
    <a href="?action=set_alt_success" class="btn">Set Alternative Success Message</a>
    <a href="?action=clear_session" class="btn">Clear Session</a>
    <a href="/test-alternative-session" class="btn">Refresh Page</a>
    
    <h3>🔗 Laravel Debug Routes:</h3>
    <a href="/debug/session/alt-success" class="btn">Test Laravel Alternative Success</a>
    <a href="/admin/settings" class="btn">Go to Settings Page</a>
    
    <script>
        // Auto-refresh after action
        if (window.location.search.includes("action=")) {
            setTimeout(() => {
                window.location.href = "/test-alternative-session";
            }, 3000);
        }
    </script>
</body>
</html>';
        
        return response($html);
    });
    
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/about/profile', [PublicController::class, 'aboutProfile'])->name('about.profile');
Route::get('/about/vision', [PublicController::class, 'aboutVision'])->name('about.vision');
Route::get('/about/sejarah', [PublicController::class, 'sejarah'])->name('about.sejarah');
Route::get('/news', [PublicController::class, 'news'])->name('news.index');
Route::get('/news/{blog}', [PublicController::class, 'newsDetail'])->name('news.detail');
Route::get('/agenda', [PublicController::class, 'agenda'])->name('agenda.index');
Route::get('/agenda/{id}', [PublicController::class, 'agendaDetail'])->name('agenda.show');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery');
// Extracurricular routes moved to Public\ExtracurricularController group below
Route::get('/announcements', [PublicController::class, 'announcements'])->name('announcements.index');
Route::get('/announcements/{id}', [PublicController::class, 'announcementDetail'])->name('announcements.show');

// Public Facility Routes
Route::prefix('facilities')->name('public.facilities.')->group(function () {
    Route::get('/search', [App\Http\Controllers\Public\FacilityController::class, 'search'])->name('search');
    Route::get('/category/{category}', [App\Http\Controllers\Public\FacilityController::class, 'getByCategory'])->name('category');
    Route::get('/{facility}', [App\Http\Controllers\Public\FacilityController::class, 'show'])->name('show');
    Route::get('/', [App\Http\Controllers\Public\FacilityController::class, 'index'])->name('index');
});

// Legacy route for backward compatibility
Route::get('/facilities', [App\Http\Controllers\Public\FacilityController::class, 'index'])->name('facilities.index');

// Public Achievement Routes
Route::prefix('achievements')->name('public.achievements.')->group(function () {
    Route::get('/', [PublicAchievementController::class, 'index'])->name('index');
    Route::get('/{achievement}', [PublicAchievementController::class, 'show'])->name('show');
});

// Public Study Programs Routes
Route::prefix('study-programs')->name('study-programs.')->group(function () {
    Route::get('/', [App\Http\Controllers\StudyProgramController::class, 'index'])->name('index');
    Route::get('/search', [App\Http\Controllers\StudyProgramController::class, 'search'])->name('search');
    Route::get('/featured', [App\Http\Controllers\StudyProgramController::class, 'featured'])->name('featured');
    Route::get('/statistics', [App\Http\Controllers\StudyProgramController::class, 'statistics'])->name('statistics');
    Route::get('/degree/{degree}', [App\Http\Controllers\StudyProgramController::class, 'byDegree'])->name('by-degree');
    Route::get('/faculty/{faculty}', [App\Http\Controllers\StudyProgramController::class, 'byFaculty'])->name('by-faculty');
    Route::get('/{studyProgram}', [App\Http\Controllers\StudyProgramController::class, 'show'])->name('show');
});

// Alternative naming for backward compatibility
Route::get('/achievements', [PublicAchievementController::class, 'index'])->name('achievements.index');
Route::get('/achievements/{achievement}', [PublicAchievementController::class, 'show'])->name('achievements.show');

// Simple route name for easy access
Route::get('/prestasi', [PublicAchievementController::class, 'index'])->name('public.achievements');
Route::get('/prestasi/{achievement}', [PublicAchievementController::class, 'show'])->name('public.achievements.show');
Route::get('/academic/programs', [App\Http\Controllers\StudyProgramController::class, 'index'])->name('public.academic.programs');
Route::get('/academic/programs/{studyProgram}', [App\Http\Controllers\StudyProgramController::class, 'show'])->name('public.academic.program-detail');
Route::get('/academic/calendar', [PublicController::class, 'academicCalendar'])->name('academic.calendar');
Route::get('/videos', [PublicController::class, 'videos'])->name('public.videos.index');
Route::get('/videos/{id}', [PublicController::class, 'videoDetail'])->name('public.videos.show');
Route::post('/videos/{id}/increment-view', [PublicController::class, 'incrementVideoView'])->name('public.videos.increment-view');
Route::get('/videos/{id}/download', [PublicController::class, 'videoDownload'])->name('public.videos.download');
// Blog routes
Route::get('/blog', [PublicBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [PublicBlogController::class, 'show'])->name('public.blog.show');

Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'submitContact'])->name('contact.submit');

// Downloads Routes
Route::get('/downloads', [PublicController::class, 'downloads'])->name('downloads.index');
Route::get('/downloads/{id}', [PublicController::class, 'downloadDetail'])->name('downloads.show');
Route::get('/downloads/{id}/download', [PublicController::class, 'downloadFile'])->name('downloads.download');

// Legacy Gallery Routes (redirect to new gallery system)
Route::get('/gallery/photos', [PublicController::class, 'galleryPhotos'])->name('gallery.photos');
Route::get('/gallery/videos', [PublicController::class, 'galleryVideos'])->name('gallery.videos');

// Public Teacher Routes
Route::prefix('teachers')->name('public.teachers.')->group(function () {
    Route::get('/', [App\Http\Controllers\Public\TeacherController::class, 'index'])->name('index');
    Route::get('/{teacher}', [App\Http\Controllers\Public\TeacherController::class, 'show'])->name('show');
});

// Public Extracurricular Routes
Route::prefix('extracurriculars')->name('public.extracurriculars.')->group(function () {
    Route::get('/', [App\Http\Controllers\Public\ExtracurricularController::class, 'index'])->name('index');
    Route::get('/check', [App\Http\Controllers\Public\ExtracurricularController::class, 'checkRegistration'])->name('check');
    Route::get('/{extracurricular}', [App\Http\Controllers\Public\ExtracurricularController::class, 'show'])->name('show');
    Route::get('/{extracurricular}/register', [App\Http\Controllers\Public\ExtracurricularController::class, 'register'])->name('register');
    Route::post('/{extracurricular}/register', [App\Http\Controllers\Public\ExtracurricularController::class, 'storeRegistration'])->name('store-registration');
});



/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

// Student Account Registration Routes (Pendaftaran Akun Siswa)
Route::middleware(['registration.enabled'])->group(function () {
    Route::get('/student/register', [App\Http\Controllers\Auth\StudentRegisterController::class, 'showRegistrationForm'])->name('student.register.form');
    Route::post('/student/register', [App\Http\Controllers\Auth\StudentRegisterController::class, 'register'])->name('student.register');
    Route::get('/student/check-nis', [App\Http\Controllers\Auth\StudentRegisterController::class, 'checkNis'])->name('student.check-nis');
    Route::get('/student/check-email', [App\Http\Controllers\Auth\StudentRegisterController::class, 'checkEmail'])->name('student.check-email');
    Route::get('/student/check-data', [App\Http\Controllers\Auth\StudentRegisterController::class, 'checkStudentData'])->name('student.check-data');
});
Route::get('/student/registration/pending', [App\Http\Controllers\Auth\StudentRegisterController::class, 'showPendingPage'])->name('student.registration.pending');

// Student Account Registration Rejection Routes (Penolakan Pendaftaran Akun Siswa)
Route::get('/auth/rejection', [App\Http\Controllers\Auth\RejectionController::class, 'show'])->name('auth.rejection.show');
Route::post('/auth/rejection/contact', [App\Http\Controllers\Auth\RejectionController::class, 'contact'])->name('auth.rejection.contact');

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
        

        \Illuminate\Support\Facades\Log::info('Dashboard redirect for user: ' . $user->email, [
            'roles' => $user->roles->pluck('name')->toArray(),
            'has_admin' => $user->hasRole('admin'),
            'has_teacher' => $user->hasRole('teacher'),
            'has_student' => $user->hasRole('student')
        ]);
        
        // Prioritas: admin > teacher > student
        if ($user->hasRole('admin')) {
            \Illuminate\Support\Facades\Log::info('Redirecting to admin dashboard');
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('teacher')) {
            \Illuminate\Support\Facades\Log::info('Redirecting to teacher dashboard');
            return redirect()->route('teacher.dashboard');
        } elseif ($user->hasRole('student')) {
            \Illuminate\Support\Facades\Log::info('Redirecting to student dashboard');
            return redirect()->route('student.dashboard');
        } elseif ($user->hasRole('parent')) {
            \Illuminate\Support\Facades\Log::info('Redirecting to parent dashboard');
            return redirect()->route('parent.dashboard');
        }
        
        \Illuminate\Support\Facades\Log::info('No specific role found, redirecting to home');
        return redirect()->route('home');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes - PROTECTED WITH ROLE MIDDLEWARE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management Routes
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update')->middleware('throttle:5,1');
    Route::put('/profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password')->middleware('throttle:3,1');
    Route::post('/profile/avatar', [App\Http\Controllers\Admin\ProfileController::class, 'updateAvatar'])->name('profile.avatar')->middleware('throttle:5,1');
    Route::post('/profile/logout-devices', [App\Http\Controllers\Admin\ProfileController::class, 'logoutOtherDevices'])->name('profile.logout-devices')->middleware('throttle:2,1');
    Route::get('/profile/activity', [App\Http\Controllers\Admin\ProfileController::class, 'getActivity'])->name('profile.activity');
    Route::get('/profile/security', [App\Http\Controllers\Admin\ProfileController::class, 'getSecuritySettings'])->name('profile.security');
    Route::post('/profile/two-factor', [App\Http\Controllers\Admin\ProfileController::class, 'toggleTwoFactor'])->name('profile.two-factor')->middleware('throttle:3,1');
    Route::get('/profile/download-data', [App\Http\Controllers\Admin\ProfileController::class, 'downloadData'])->name('profile.download-data')->middleware('throttle:2,1');
    
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
    
    // Posts Management Routes
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        
        // Slideshow Management
        Route::get('/slideshow', [SlideshowController::class, 'index'])->name('slideshow');
        Route::get('/slideshow/create', [SlideshowController::class, 'create'])->name('slideshow.create');
        Route::post('/slideshow', [SlideshowController::class, 'store'])->name('slideshow.store');
        Route::get('/slideshow/{slideshow}/edit', [SlideshowController::class, 'edit'])->name('slideshow.edit');
        Route::put('/slideshow/{slideshow}', [SlideshowController::class, 'update'])->name('slideshow.update');
        Route::delete('/slideshow/{slideshow}', [SlideshowController::class, 'destroy'])->name('slideshow.destroy');
        
        // Blog Management
        Route::get('blog', [BlogController::class, 'index'])->name('blog');
        Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');
        Route::post('blog', [BlogController::class, 'store'])->name('blog.store');
        Route::get('blog/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::put('blog/{blog}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('blog/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');
        Route::get('blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
        
        // Agenda Routes
        Route::get('/agenda', [PostController::class, 'agenda'])->name('agenda');
        Route::get('/agenda/create', [PostController::class, 'createAgenda'])->name('agenda.create');
        Route::post('/agenda', [PostController::class, 'storeAgenda'])->name('agenda.store');
        Route::get('/agenda/{id}', [PostController::class, 'showAgenda'])->name('agenda.show');
        Route::get('/agenda/{id}/edit', [PostController::class, 'editAgenda'])->name('agenda.edit');
        Route::put('/agenda/{id}', [PostController::class, 'updateAgenda'])->name('agenda.update');
        Route::delete('/agenda/{id}', [PostController::class, 'destroyAgenda'])->name('agenda.destroy');
        
        // Announcement Routes
        Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement');
        Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('announcement.create');
        Route::post('/announcement', [AnnouncementController::class, 'store'])->name('announcement.store');
        Route::get('/announcement/{id}', [AnnouncementController::class, 'show'])->name('announcement.show');
        Route::get('/announcement/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcement.edit');
        Route::put('/announcement/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
        Route::delete('/announcement/{id}', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');
        Route::post('/announcement/{id}/toggle-status', [AnnouncementController::class, 'toggleStatus'])->name('announcement.toggle-status');
    });
    
    // Media & Files Routes
    Route::resource('videos', VideoController::class);
    Route::post('videos/bulk-action', [VideoController::class, 'bulkAction'])->name('videos.bulk-action');
    Route::post('videos/{video}/toggle-featured', [VideoController::class, 'toggleFeatured'])->name('videos.toggle-featured');
    
    // Extracurriculars management
    Route::resource('extracurriculars', ExtracurricularController::class);
    Route::post('extracurriculars/bulk-action', [ExtracurricularController::class, 'bulkAction'])->name('extracurriculars.bulk-action');
    Route::post('extracurriculars/{extracurricular}/toggle-status', [ExtracurricularController::class, 'toggleStatus'])->name('extracurriculars.toggle-status');
    Route::get('extracurriculars/{extracurricular}/members', [ExtracurricularController::class, 'showMembers'])->name('extracurriculars.members');
    Route::get('extracurriculars/{extracurricular}/registrations', [ExtracurricularController::class, 'showRegistrations'])->name('extracurriculars.registrations');
    Route::post('extracurriculars/registration/{registration}/approve', [ExtracurricularController::class, 'approveRegistration'])->name('extracurriculars.registration.approve');
    Route::post('extracurriculars/registration/{registration}/reject', [ExtracurricularController::class, 'rejectRegistration'])->name('extracurriculars.registration.reject');
    Route::get('extracurriculars/registration/{registration}', [ExtracurricularController::class, 'showRegistrationDetail'])->name('extracurriculars.registration.detail');
    Route::get('pending-registrations', [ExtracurricularController::class, 'pendingRegistrations'])->name('extracurriculars.pending-registrations');
    
    // Dedicated pending registrations page
    Route::get('extracurriculars-registrations', [ExtracurricularController::class, 'pendingRegistrationsPage'])->name('extracurriculars.registrations.page');
    Route::post('extracurriculars-registrations/bulk-approve', [ExtracurricularController::class, 'bulkApproveRegistrations'])->name('extracurriculars.registrations.bulk-approve');
    Route::post('extracurriculars-registrations/bulk-reject', [ExtracurricularController::class, 'bulkRejectRegistrations'])->name('extracurriculars.registrations.bulk-reject');
    
    // API endpoints for AJAX calls
    Route::get('extracurriculars/{extracurricular}/members-json', [ExtracurricularController::class, 'getMembersJson'])->name('extracurriculars.members.json');
    Route::get('extracurriculars/{extracurricular}/registrations-json', [ExtracurricularController::class, 'getRegistrationsJson'])->name('extracurriculars.registrations.json');
    Route::get('extracurriculars/all-pending-registrations', [ExtracurricularController::class, 'getAllPendingRegistrations'])->name('extracurriculars.all-pending-registrations');
    Route::post('extracurriculars/member/{registration}/status', [ExtracurricularController::class, 'updateMemberStatus'])->name('extracurriculars.member.status');
    Route::post('extracurriculars/registration/{registration}/status', [ExtracurricularController::class, 'updateRegistrationStatus'])->name('extracurriculars.registration.status');
    Route::get('extracurriculars/registration/{registration}/detail', [ExtracurricularController::class, 'getRegistrationDetail'])->name('extracurriculars.registration.get-detail');
    

    
    // Teachers management with additional routes
    Route::resource('teachers', TeacherController::class);
    Route::post('teachers/bulk-action', [TeacherController::class, 'bulkAction'])->name('teachers.bulk-action');
    Route::post('teachers/{teacher}/toggle-status', [TeacherController::class, 'toggleStatus'])->name('teachers.toggle-status');
    
    // Students management with additional routes
    // IMPORTANT: Specific routes must come BEFORE resource routes
    Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
    Route::get('students/test-export', function() {
        return response()->json([
            'status' => 'success',
            'message' => 'Export route is accessible',
            'timestamp' => now()->toISOString()
        ]);
    })->name('students.test-export');
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
    Route::post('students/bulk-action', [StudentController::class, 'bulkAction'])->name('students.bulk-action');
    
    // AJAX validation routes for students
    Route::get('students/check-nis', [StudentController::class, 'checkNis'])->name('students.check-nis');
    Route::get('students/check-nisn', [StudentController::class, 'checkNisn'])->name('students.check-nisn');
    Route::get('students/generate-nis', [StudentController::class, 'generateNis'])->name('students.generate-nis');
    
    // Resource routes (must come after specific routes)
    Route::resource('students', StudentController::class);
    Route::post('students/{student}/toggle-status', [StudentController::class, 'toggleStatus'])->name('students.toggle-status');
    Route::delete('students/{student}/photo', [StudentController::class, 'deletePhoto'])->name('students.delete-photo');
    
    // System Routes
    Route::resource('users', UserController::class);
    Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('users/{user}/reset-password', [UserController::class, 'showResetPassword'])->name('users.reset-password');
    Route::post('users/{user}/reset-password', [UserController::class, 'processResetPassword'])->name('users.reset-password.store');
    Route::post('users/{user}/reset-password-ajax', [UserController::class, 'resetPassword'])->name('users.reset-password-ajax');
    
    Route::resource('roles', RoleController::class);
    Route::post('roles/bulk-action', [RoleController::class, 'bulkAction'])->name('roles.bulk-action');
    
    // Downloads Management Routes
    Route::resource('downloads', App\Http\Controllers\Admin\DownloadController::class);
    Route::post('downloads/bulk-action', [App\Http\Controllers\Admin\DownloadController::class, 'bulkAction'])->name('downloads.bulk-action');
    Route::post('downloads/{download}/toggle-featured', [App\Http\Controllers\Admin\DownloadController::class, 'toggleFeatured'])->name('downloads.toggle-featured');
    
    // Settings Routes
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [App\Http\Controllers\Admin\SettingController::class, 'reset'])->name('settings.reset');
    Route::post('/settings/clear-cache', [App\Http\Controllers\Admin\SettingController::class, 'clearCache'])->name('settings.clear-cache');
    Route::post('/settings/optimize', [App\Http\Controllers\Admin\SettingController::class, 'optimize'])->name('settings.optimize');
    Route::post('/settings/create-backup', [App\Http\Controllers\Admin\SettingController::class, 'createBackup'])->name('settings.create-backup');
    Route::post('/settings/test-email', [App\Http\Controllers\Admin\SettingController::class, 'testEmail'])->name('settings.test-email');
    Route::get('/settings/system-health', [App\Http\Controllers\Admin\SettingController::class, 'systemHealth'])->name('settings.system-health');
    Route::get('/settings/list-backups', [App\Http\Controllers\Admin\SettingController::class, 'listBackups'])->name('settings.list-backups');
    Route::get('/settings/download-backup', [App\Http\Controllers\Admin\SettingController::class, 'downloadBackup'])->name('settings.download-backup');
    Route::delete('/settings/delete-backup', [App\Http\Controllers\Admin\SettingController::class, 'deleteBackup'])->name('settings.delete-backup');

    Route::post('/settings/optimize-database', [App\Http\Controllers\Admin\SettingController::class, 'optimizeDatabase'])->name('settings.optimize-database');
    Route::post('/settings/clear-logs', [App\Http\Controllers\Admin\SettingController::class, 'clearLogs'])->name('settings.clear-logs');
    Route::get('/settings/system-monitoring', [App\Http\Controllers\Admin\SettingController::class, 'systemMonitoring'])->name('settings.system-monitoring');
    
    // Test routes for debugging modal issues (remove in production)
    Route::get('/settings/test-success', function() {
        \Log::info('🧪 Test success route called');
        
        // Test the exact same method as the real controller
        \Log::info('🧪 Before redirect - session state:', [
            'session_id' => session()->getId(),
            'all_session' => session()->all()
        ]);
        
        // Use the exact same redirect method as SettingController
        return redirect()->route('admin.settings.index')
                        ->with('success', 'Test success message - modal should appear!')
                        ->with('test_flag', 'success_test')
                        ->with('debug_timestamp', now()->toDateTimeString());
    })->name('settings.test-success');
    
    Route::get('/settings/test-error', function() {
        \Log::info('🧪 Test error route called');
        
        session()->flash('error', 'Test error message - modal should appear!');
        session()->save();
        
        \Log::info('🧪 Error session set in test route:', [
            'has_error' => session()->has('error'),
            'error_value' => session('error'),
            'session_id' => session()->getId()
        ]);
        
        return redirect()->route('admin.settings.index')
                        ->with('error', 'Test error message - modal should appear!')
                        ->with('test_flag', 'error_test');
    })->name('settings.test-error');
    
    Route::get('/settings/test-validation', function() {
        \Log::info('🧪 Test validation route called');
        
        return redirect()->route('admin.settings.index')
                        ->withErrors(['test_field' => 'This is a test validation error'])
                        ->withInput(['test_field' => 'test_value'])
                        ->with('test_flag', 'validation_test');
    })->name('settings.test-validation');

    // Vision & Mission Management
    Route::resource('vision', App\Http\Controllers\Admin\VisionController::class);
    Route::post('vision/{vision}/activate', [App\Http\Controllers\Admin\VisionController::class, 'activate'])->name('vision.activate');
    Route::post('vision/{vision}/deactivate', [App\Http\Controllers\Admin\VisionController::class, 'deactivate'])->name('vision.deactivate');

    // Backup Management Routes
    Route::prefix('backup')->name('backup.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\BackupController::class, 'index'])->name('index');
        Route::post('/create-full', [App\Http\Controllers\Admin\BackupController::class, 'createFullBackup'])->name('create-full');
        Route::post('/create-database', [App\Http\Controllers\Admin\BackupController::class, 'createDatabaseBackup'])->name('create-database');
        Route::post('/create-files', [App\Http\Controllers\Admin\BackupController::class, 'createFilesBackup'])->name('create-files');
        Route::get('/download/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'downloadBackup'])->name('download');
        Route::delete('/delete', [App\Http\Controllers\Admin\BackupController::class, 'deleteBackup'])->name('delete');
    });
    
    // Notifications Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('index');
        Route::get('/recent', [App\Http\Controllers\Admin\NotificationController::class, 'recent'])->name('recent');
        Route::get('/unread-count', [App\Http\Controllers\Admin\NotificationController::class, 'unreadCount'])->name('unread-count');
        Route::post('/{id}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/mark-all-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('destroy');
        Route::post('/clear-old', [App\Http\Controllers\Admin\NotificationController::class, 'clearOld'])->name('clear-old');
    });
    
    // Student Account Registration Management Routes (Manajemen Pendaftaran Akun Siswa)
    Route::prefix('student-registrations')->name('student-registrations.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\StudentRegistrationController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Admin\StudentRegistrationController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [App\Http\Controllers\Admin\StudentRegistrationController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [App\Http\Controllers\Admin\StudentRegistrationController::class, 'reject'])->name('reject');
        Route::post('/bulk-action', [App\Http\Controllers\Admin\StudentRegistrationController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/bulk-reject', [App\Http\Controllers\Admin\StudentRegistrationController::class, 'bulkReject'])->name('bulk-reject');
        Route::get('/export/data', [App\Http\Controllers\Admin\StudentRegistrationController::class, 'export'])->name('export');
    });
    
    // Security Violations Management Routes
    Route::prefix('security-violations')->name('security-violations.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SecurityViolationController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Admin\SecurityViolationController::class, 'show'])->name('show');
        Route::post('/{id}/review', [App\Http\Controllers\Admin\SecurityViolationController::class, 'review'])->name('review');
        Route::post('/{id}/resolve', [App\Http\Controllers\Admin\SecurityViolationController::class, 'resolve'])->name('resolve');
        Route::post('/bulk-action', [App\Http\Controllers\Admin\SecurityViolationController::class, 'bulkAction'])->name('bulk-action');
        Route::get('/export', [App\Http\Controllers\Admin\SecurityViolationController::class, 'export'])->name('export');
        Route::get('/statistics', [App\Http\Controllers\Admin\SecurityViolationController::class, 'statistics'])->name('statistics');
    });
    
    // Calendar Academic Routes
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('index');
        Route::get('/events', [CalendarController::class, 'getEvents'])->name('events');
        Route::post('/events', [CalendarController::class, 'storeEvent'])->name('events.store');
        Route::get('/events/{id}', [CalendarController::class, 'getEvent'])->name('events.show');
        Route::put('/events/{id}', [CalendarController::class, 'updateEvent'])->name('events.update');
        Route::delete('/events/{id}', [CalendarController::class, 'deleteEvent'])->name('events.delete');
        Route::post('/sync-agenda', [CalendarController::class, 'syncFromAgenda'])->name('sync-agenda');
        Route::get('/upcoming-events', [CalendarController::class, 'upcomingEventsApi'])->name('upcoming-events');
    });
    
    // Agenda Management Routes (for legacy agenda table)
    Route::prefix('agenda')->name('agenda.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AgendaController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\AgendaController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\AgendaController::class, 'store'])->name('store');
        Route::put('/{id}', [App\Http\Controllers\Admin\AgendaController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\AgendaController::class, 'destroy'])->name('destroy');
        Route::post('/sync-all', [App\Http\Controllers\Admin\AgendaController::class, 'syncAllToCalendar'])->name('sync-all');
    });
    
    // School Profile Management Routes
    Route::prefix('school-profile')->name('school-profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SchoolProfileController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\SchoolProfileController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\SchoolProfileController::class, 'store'])->name('store');
        Route::get('/{schoolProfile}', [App\Http\Controllers\Admin\SchoolProfileController::class, 'show'])->name('show');
        Route::get('/{schoolProfile}/edit', [App\Http\Controllers\Admin\SchoolProfileController::class, 'edit'])->name('edit');
        Route::put('/{schoolProfile}', [App\Http\Controllers\Admin\SchoolProfileController::class, 'update'])->name('update');
        Route::delete('/{schoolProfile}', [App\Http\Controllers\Admin\SchoolProfileController::class, 'destroy'])->name('destroy');
        Route::post('/{schoolProfile}/activate', [App\Http\Controllers\Admin\SchoolProfileController::class, 'activate'])->name('activate');
        Route::post('/{schoolProfile}/deactivate', [App\Http\Controllers\Admin\SchoolProfileController::class, 'deactivate'])->name('deactivate');
    });
    
    // History Management Routes
    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\HistoryController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\HistoryController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\HistoryController::class, 'store'])->name('store');
        Route::get('/{history}', [App\Http\Controllers\Admin\HistoryController::class, 'show'])->name('show');
        Route::get('/{history}/edit', [App\Http\Controllers\Admin\HistoryController::class, 'edit'])->name('edit');
        Route::put('/{history}', [App\Http\Controllers\Admin\HistoryController::class, 'update'])->name('update');
        Route::delete('/{history}', [App\Http\Controllers\Admin\HistoryController::class, 'destroy'])->name('destroy');
        Route::post('/{history}/activate', [App\Http\Controllers\Admin\HistoryController::class, 'activate'])->name('activate');
        Route::post('/{history}/deactivate', [App\Http\Controllers\Admin\HistoryController::class, 'deactivate'])->name('deactivate');
    });
    
    // Contact Management Routes
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\ContactController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\ContactController::class, 'store'])->name('store');
        Route::get('/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'show'])->name('show');
        Route::get('/{contact}/edit', [App\Http\Controllers\Admin\ContactController::class, 'edit'])->name('edit');
        Route::put('/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'update'])->name('update');
        Route::delete('/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('destroy');
        Route::post('/{contact}/activate', [App\Http\Controllers\Admin\ContactController::class, 'activate'])->name('activate');
        Route::post('/{contact}/deactivate', [App\Http\Controllers\Admin\ContactController::class, 'deactivate'])->name('deactivate');
    });
    
    // Achievements Management Routes
    Route::prefix('achievements')->name('achievements.')->group(function () {
        Route::get('/', [AchievementController::class, 'index'])->name('index');
        Route::get('/create', [AchievementController::class, 'create'])->name('create');
        Route::post('/', [AchievementController::class, 'store'])->name('store');
        Route::get('/{achievement}', [AchievementController::class, 'show'])->name('show');
        Route::get('/{achievement}/edit', [AchievementController::class, 'edit'])->name('edit');
        Route::put('/{achievement}', [AchievementController::class, 'update'])->name('update');
        Route::delete('/{achievement}', [AchievementController::class, 'destroy'])->name('destroy');
        Route::post('/{achievement}/toggle-status', [AchievementController::class, 'toggleStatus'])->name('achievements.toggle-status');
        Route::post('/{achievement}/toggle-featured', [AchievementController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/bulk-action', [AchievementController::class, 'bulkAction'])->name('bulk-action');
    });
    
    // Study Programs Management Routes
    Route::prefix('study-programs')->name('study-programs.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\StudyProgramController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\StudyProgramController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\StudyProgramController::class, 'store'])->name('store');
        Route::get('/{studyProgram}', [App\Http\Controllers\Admin\StudyProgramController::class, 'show'])->name('show');
        Route::get('/{studyProgram}/edit', [App\Http\Controllers\Admin\StudyProgramController::class, 'edit'])->name('edit');
        Route::put('/{studyProgram}', [App\Http\Controllers\Admin\StudyProgramController::class, 'update'])->name('update');
        Route::delete('/{studyProgram}', [App\Http\Controllers\Admin\StudyProgramController::class, 'destroy'])->name('destroy');
        Route::post('/{studyProgram}/activate', [App\Http\Controllers\Admin\StudyProgramController::class, 'activate'])->name('activate');
        Route::post('/{studyProgram}/deactivate', [App\Http\Controllers\Admin\StudyProgramController::class, 'deactivate'])->name('deactivate');
        Route::post('/{studyProgram}/feature', [App\Http\Controllers\Admin\StudyProgramController::class, 'feature'])->name('feature');
        Route::post('/{studyProgram}/unfeature', [App\Http\Controllers\Admin\StudyProgramController::class, 'unfeature'])->name('unfeature');
    });
    
    // Facilities Management Routes
    Route::prefix('facilities')->name('facilities.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\FacilityController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\FacilityController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\FacilityController::class, 'store'])->name('store');
        Route::get('/{facility}', [App\Http\Controllers\Admin\FacilityController::class, 'show'])->name('show');
        Route::get('/{facility}/edit', [App\Http\Controllers\Admin\FacilityController::class, 'edit'])->name('edit');
        Route::put('/{facility}', [App\Http\Controllers\Admin\FacilityController::class, 'update'])->name('update');
        Route::delete('/{facility}', [App\Http\Controllers\Admin\FacilityController::class, 'destroy'])->name('destroy');
        Route::post('/{facility}/toggle-status', [App\Http\Controllers\Admin\FacilityController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{facility}/toggle-featured', [App\Http\Controllers\Admin\FacilityController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/bulk-action', [App\Http\Controllers\Admin\FacilityController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/update-sort-order', [App\Http\Controllers\Admin\FacilityController::class, 'updateSortOrder'])->name('update-sort-order');
    });
});

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    
    // Teacher Profile Management Routes
    Route::get('/profile', [App\Http\Controllers\Teacher\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [App\Http\Controllers\Teacher\ProfileController::class, 'update'])->name('profile.update')->middleware('throttle:5,1');
    Route::put('/profile/password', [App\Http\Controllers\Teacher\ProfileController::class, 'updatePassword'])->name('profile.password')->middleware('throttle:3,1');
    Route::post('/profile/avatar', [App\Http\Controllers\Teacher\ProfileController::class, 'updateAvatar'])->name('profile.avatar')->middleware('throttle:5,1');
    Route::post('/profile/logout-devices', [App\Http\Controllers\Teacher\ProfileController::class, 'logoutOtherDevices'])->name('profile.logout-devices')->middleware('throttle:2,1');
    Route::get('/profile/activity', [App\Http\Controllers\Teacher\ProfileController::class, 'getActivity'])->name('profile.activity');
    Route::get('/profile/security', [App\Http\Controllers\Teacher\ProfileController::class, 'getSecuritySettings'])->name('profile.security');
    Route::get('/profile/download-data', [App\Http\Controllers\Teacher\ProfileController::class, 'downloadData'])->name('profile.download-data')->middleware('throttle:2,1');
    
    // Teacher Assignment Management Routes
    Route::prefix('assignments')->name('assignments.')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\AssignmentController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Teacher\AssignmentController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Teacher\AssignmentController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Teacher\AssignmentController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Teacher\AssignmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Teacher\AssignmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Teacher\AssignmentController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/submissions', [App\Http\Controllers\Teacher\AssignmentController::class, 'submissions'])->name('submissions');
        Route::get('/{assignmentId}/submissions/{submissionId}', [App\Http\Controllers\Teacher\AssignmentController::class, 'showSubmission'])->name('grade');
        Route::post('/{assignmentId}/submissions/{submissionId}/grade', [App\Http\Controllers\Teacher\AssignmentController::class, 'gradeSubmission'])->name('grade.store');
        Route::post('/{assignmentId}/bulk-grade', [App\Http\Controllers\Teacher\AssignmentController::class, 'bulkGrade'])->name('bulk-grade');
        Route::get('/{assignmentId}/submissions/progress', [App\Http\Controllers\Teacher\AssignmentController::class, 'getSubmissionProgress'])->name('submissions.progress');
    });
    
    // Posts Management Routes for Teachers
    Route::prefix('posts')->name('posts.')->group(function () {
        // Slideshow Management
        Route::get('/slideshow', [App\Http\Controllers\Teacher\PostController::class, 'slideshow'])->name('slideshow');
        Route::get('/slideshow/create', [App\Http\Controllers\Teacher\PostController::class, 'createSlideshow'])->name('slideshow.create');
        Route::post('/slideshow', [App\Http\Controllers\Teacher\PostController::class, 'storeSlideshow'])->name('slideshow.store');
        Route::get('/slideshow/{id}/edit', [App\Http\Controllers\Teacher\PostController::class, 'editSlideshow'])->name('slideshow.edit');
        Route::put('/slideshow/{id}', [App\Http\Controllers\Teacher\PostController::class, 'updateSlideshow'])->name('slideshow.update');
        Route::delete('/slideshow/{id}', [App\Http\Controllers\Teacher\PostController::class, 'destroySlideshow'])->name('slideshow.destroy');
        
        // Teacher Blog Routes
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/', [App\Http\Controllers\Teacher\BlogController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Teacher\BlogController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Teacher\BlogController::class, 'store'])->name('store');
            Route::get('/{blog}', [App\Http\Controllers\Teacher\BlogController::class, 'show'])->name('show');
            Route::get('/{blog}/edit', [App\Http\Controllers\Teacher\BlogController::class, 'edit'])->name('edit');
            Route::put('/{blog}', [App\Http\Controllers\Teacher\BlogController::class, 'update'])->name('update');
            Route::delete('/{blog}', [App\Http\Controllers\Teacher\BlogController::class, 'destroy'])->name('destroy');
        });
        
        // Agenda Routes
        Route::get('/agenda', [App\Http\Controllers\Teacher\PostController::class, 'agenda'])->name('agenda');
        Route::get('/agenda/create', [App\Http\Controllers\Teacher\PostController::class, 'createAgenda'])->name('agenda.create');
        Route::post('/agenda', [App\Http\Controllers\Teacher\PostController::class, 'storeAgenda'])->name('agenda.store');
        Route::get('/agenda/{id}', [App\Http\Controllers\Teacher\PostController::class, 'showAgenda'])->name('agenda.show');
        Route::get('/agenda/{id}/edit', [App\Http\Controllers\Teacher\PostController::class, 'editAgenda'])->name('agenda.edit');
        Route::put('/agenda/{id}', [App\Http\Controllers\Teacher\PostController::class, 'updateAgenda'])->name('agenda.update');
        Route::delete('/agenda/{id}', [App\Http\Controllers\Teacher\PostController::class, 'destroyAgenda'])->name('agenda.destroy');
        
        // Announcement Routes
        Route::get('/announcement', [App\Http\Controllers\Teacher\PostController::class, 'announcement'])->name('announcement');
        Route::get('/announcement/create', [App\Http\Controllers\Teacher\PostController::class, 'createAnnouncement'])->name('announcement.create');
        Route::post('/announcement', [App\Http\Controllers\Teacher\PostController::class, 'storeAnnouncement'])->name('announcement.store');
        Route::get('/announcement/{id}', [App\Http\Controllers\Teacher\PostController::class, 'show'])->name('announcement.show');
        Route::get('/announcement/{id}/edit', [App\Http\Controllers\Teacher\PostController::class, 'editAnnouncement'])->name('announcement.edit');
        Route::put('/announcement/{id}', [App\Http\Controllers\Teacher\PostController::class, 'updateAnnouncement'])->name('announcement.update');
        Route::delete('/announcement/{id}', [App\Http\Controllers\Teacher\PostController::class, 'destroyAnnouncement'])->name('announcement.destroy');
    });

    // Teacher Learning Management Routes
    Route::prefix('learning')->name('learning.')->group(function () {
        // Materials Routes
        Route::prefix('materials')->name('materials.')->group(function () {
            Route::get('/', [App\Http\Controllers\Teacher\LearningController::class, 'materials'])->name('index');
            Route::get('/create', [App\Http\Controllers\Teacher\LearningController::class, 'createMaterial'])->name('create');
            Route::post('/', [App\Http\Controllers\Teacher\LearningController::class, 'storeMaterial'])->name('store');
            Route::get('/{id}/edit', [App\Http\Controllers\Teacher\LearningController::class, 'editMaterial'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\Teacher\LearningController::class, 'updateMaterial'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\Teacher\LearningController::class, 'destroyMaterial'])->name('destroy');
        });

        // Assignments Routes
        Route::prefix('assignments')->name('assignments.')->group(function () {
            Route::get('/', [App\Http\Controllers\Teacher\LearningController::class, 'assignments'])->name('index');
            Route::get('/create', [App\Http\Controllers\Teacher\LearningController::class, 'createAssignment'])->name('create');
            Route::post('/', [App\Http\Controllers\Teacher\LearningController::class, 'storeAssignment'])->name('store');
            Route::get('/{id}', [App\Http\Controllers\Teacher\LearningController::class, 'showAssignment'])->name('show');
            Route::get('/{id}/edit', [App\Http\Controllers\Teacher\LearningController::class, 'editAssignment'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\Teacher\LearningController::class, 'updateAssignment'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\Teacher\LearningController::class, 'destroyAssignment'])->name('destroy');
        });
    });

    // Teacher Student Management Routes
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\StudentController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Teacher\StudentController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Teacher\StudentController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Teacher\StudentController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Teacher\StudentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Teacher\StudentController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Teacher\StudentController::class, 'destroy'])->name('destroy');
        Route::get('/export', [App\Http\Controllers\Teacher\StudentController::class, 'export'])->name('export');
    });

    // Teacher Attendance Management Routes
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\AttendanceController::class, 'index'])->name('index');
        Route::post('/mark', [App\Http\Controllers\Teacher\AttendanceController::class, 'markAttendance'])->name('mark');
        Route::post('/bulk-mark', [App\Http\Controllers\Teacher\AttendanceController::class, 'bulkMarkAttendance'])->name('bulk-mark');
        Route::post('/update-notes', [App\Http\Controllers\Teacher\AttendanceController::class, 'updateAttendanceNotes'])->name('update-notes');
        Route::post('/update-time', [App\Http\Controllers\Teacher\AttendanceController::class, 'updateAttendanceTime'])->name('update-time');
        Route::get('/history', [App\Http\Controllers\Teacher\AttendanceController::class, 'attendanceHistory'])->name('history');
        Route::get('/export', [App\Http\Controllers\Teacher\AttendanceController::class, 'exportAttendance'])->name('export');
        Route::get('/monthly-report', [App\Http\Controllers\Teacher\AttendanceController::class, 'monthlyReport'])->name('monthly-report');
        Route::get('/statistics', [App\Http\Controllers\Teacher\AttendanceController::class, 'attendanceStatistics'])->name('statistics');
    });

    // Teacher Quiz Management Routes
    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\QuizController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Teacher\QuizController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Teacher\QuizController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Teacher\QuizController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Teacher\QuizController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Teacher\QuizController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Teacher\QuizController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/publish', [App\Http\Controllers\Teacher\QuizController::class, 'publish'])->name('publish');
        Route::patch('/{id}/unpublish', [App\Http\Controllers\Teacher\QuizController::class, 'unpublish'])->name('unpublish');
        Route::get('/{id}/attempts', [App\Http\Controllers\Teacher\QuizController::class, 'attempts'])->name('attempts');
        Route::get('/{quizId}/attempts/{attemptId}', [App\Http\Controllers\Teacher\QuizController::class, 'attemptDetail'])->name('attempt-detail');
        Route::post('/{quizId}/attempts/{attemptId}/grade-essay', [App\Http\Controllers\Teacher\QuizController::class, 'gradeEssay'])->name('grade-essay');
    });



    // Teacher Grades Management Routes
    Route::prefix('grades')->name('grades.')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\GradeController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Teacher\GradeController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Teacher\GradeController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Teacher\GradeController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Teacher\GradeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Teacher\GradeController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Teacher\GradeController::class, 'destroy'])->name('destroy');
        Route::get('/report', [App\Http\Controllers\Teacher\GradeController::class, 'report'])->name('report');
        Route::get('/recap', [App\Http\Controllers\Teacher\GradeController::class, 'recap'])->name('recap');
    });


});

/*
|--------------------------------------------------------------------------
| Student Routes - FIXED
|--------------------------------------------------------------------------
*/

// Student Routes with explicit middleware and naming
Route::group([
    'middleware' => ['auth', 'role:student'],
    'prefix' => 'student',
    'as' => 'student.'
], function () {
    
    // Student Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    // Student Profile Management Routes
    Route::get('/profile', [App\Http\Controllers\Student\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update')->middleware('throttle:5,1');
    Route::put('/profile/password', [App\Http\Controllers\Student\ProfileController::class, 'updatePassword'])->name('profile.password')->middleware('throttle:3,1');
    Route::post('/profile/avatar', [App\Http\Controllers\Student\ProfileController::class, 'updateAvatar'])->name('profile.avatar')->middleware('throttle:5,1');
    Route::post('/profile/logout-devices', [App\Http\Controllers\Student\ProfileController::class, 'logoutOtherDevices'])->name('profile.logout-devices')->middleware('throttle:2,1');
    Route::get('/profile/activity', [App\Http\Controllers\Student\ProfileController::class, 'getActivity'])->name('profile.activity');
    Route::get('/profile/security', [App\Http\Controllers\Student\ProfileController::class, 'getSecuritySettings'])->name('profile.security');
    Route::get('/profile/download-data', [App\Http\Controllers\Student\ProfileController::class, 'downloadData'])->name('profile.download-data')->middleware('throttle:2,1');
    
    // Student Materials Routes - EXPLICIT DEFINITION
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/{id}', [MaterialController::class, 'show'])->name('materials.show');
    Route::get('/materials/{id}/download', [MaterialController::class, 'download'])->name('materials.download');
    
    // Student Assignments Routes
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{id}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::post('/assignments/{id}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');
    Route::get('/assignments/{id}/status', [AssignmentController::class, 'checkStatus'])->name('assignments.status');
    
    // Student Notifications Routes
    Route::get('/notifications', [\App\Http\Controllers\Student\NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::get('/notifications/count', [\App\Http\Controllers\Student\NotificationController::class, 'getNotificationCount'])->name('notifications.count');
    
    // Student Quiz Routes
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{id}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{id}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::get('/quiz-attempts/{attemptId}/take', [QuizController::class, 'take'])->name('quizzes.take');
    Route::post('/quiz-attempts/{attemptId}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quiz-attempts/{attemptId}/result', [QuizController::class, 'result'])->name('quizzes.result');
    

    
    // Student Attendance Routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/sessions/{sessionId}/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');
    Route::post('/attendance/excuse', [AttendanceController::class, 'submitExcuse'])->name('attendance.excuse');
    
    // Student Grades Routes
    Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
    Route::get('/grades/subject/{subject}', [GradeController::class, 'subject'])->name('grades.subject');
    Route::get('/grades/{id}', [GradeController::class, 'show'])->name('grades.show');
    
    // Student QR Attendance Routes
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/qr-scanner', [App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('qr-scanner');
        Route::post('/scan', [App\Http\Controllers\Student\AttendanceController::class, 'scanQr'])->name('scan');
        Route::post('/process-qr-file', [App\Http\Controllers\Student\AttendanceController::class, 'processQrFile'])->name('process-qr-file');
        Route::get('/my-qr', [App\Http\Controllers\Student\AttendanceController::class, 'getMyQrCode'])->name('my-qr');
        Route::get('/download-qr', [App\Http\Controllers\Student\AttendanceController::class, 'downloadMyQrCode'])->name('download-qr');
        Route::get('/history', [App\Http\Controllers\Student\AttendanceHistoryController::class, 'index'])->name('history');
        Route::get('/realtime-data', [App\Http\Controllers\Student\AttendanceHistoryController::class, 'getRealTimeData'])->name('realtime-data');
        Route::get('/export', [App\Http\Controllers\Student\AttendanceHistoryController::class, 'export'])->name('export');
    });
    
    // Legacy route for backward compatibility
    Route::get('/materials-legacy', [MaterialController::class, 'index'])->name('materials');
});

/*
|--------------------------------------------------------------------------
| Announcement Routes - Admin & Public
|--------------------------------------------------------------------------
*/

// Admin Announcement Routes (Protected by role middleware)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('announcements', AnnouncementController::class);
    Route::post('announcements/{id}/toggle-status', [AnnouncementController::class, 'toggleStatus'])
         ->name('announcements.toggle-status');
});

// Legacy announcement routes for backward compatibility (now handled by PublicController)
// Route::get('/announcements', [AnnouncementController::class, 'publicIndex'])->name('announcements.index');
// Route::get('/announcements/{id}', [AnnouncementController::class, 'publicShow'])->name('announcements.show');

/*
|--------------------------------------------------------------------------
| Gallery Routes - Admin & Public
|--------------------------------------------------------------------------
*/

    // Admin Gallery Routes (Protected by role middleware)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('index');
        Route::get('/upload', [App\Http\Controllers\Admin\GalleryController::class, 'upload'])->name('upload');
        Route::post('/store', [App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('store');
        Route::delete('/{albumId}', [App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('destroy');
    });
    
    // QR Attendance Management Routes
    Route::prefix('qr-attendance')->name('qr-attendance.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\QrAttendanceController::class, 'index'])->name('index');
        Route::post('/generate/{student}', [App\Http\Controllers\Admin\QrAttendanceController::class, 'generateQr'])->name('generate');
        Route::post('/regenerate/{student}', [App\Http\Controllers\Admin\QrAttendanceController::class, 'regenerateQr'])->name('regenerate');
        Route::post('/generate-bulk', [App\Http\Controllers\Admin\QrAttendanceController::class, 'generateBulkQr'])->name('generate-bulk');
        Route::get('/view/{student}', [App\Http\Controllers\Admin\QrAttendanceController::class, 'viewQr'])->name('view');
        Route::get('/logs', [App\Http\Controllers\Admin\QrAttendanceController::class, 'attendanceLogs'])->name('logs');
        Route::get('/logs/export', [App\Http\Controllers\Admin\QrAttendanceController::class, 'exportLogs'])->name('logs.export');
        Route::get('/statistics', [App\Http\Controllers\Admin\QrAttendanceController::class, 'statistics'])->name('statistics');
        Route::get('/download/{student}', [App\Http\Controllers\Admin\QrAttendanceController::class, 'downloadQr'])->name('download');
    });
    

});

// Public Gallery Routes
Route::prefix('gallery')->name('gallery.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index');
    Route::get('/search', [GalleryController::class, 'search'])->name('search');
    Route::get('/photos', [GalleryController::class, 'index'])->name('photos.index');
    Route::get('/photos/{slug}', [GalleryController::class, 'photos'])->name('photos');
    Route::get('/show/{slug}', [GalleryController::class, 'show'])->name('show');
    Route::get('/download/{slug}', [GalleryController::class, 'downloadAlbum'])->name('download');
    Route::post('/upload', [GalleryController::class, 'upload'])->name('upload');
    Route::post('/create-album', [GalleryController::class, 'createAlbum'])->name('create-album');
});