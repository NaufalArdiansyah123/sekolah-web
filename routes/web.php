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
};

// Import Student Controllers
use App\Http\Controllers\Student\MaterialController;
use App\Http\Controllers\Student\AssignmentController;
use App\Http\Controllers\Student\GradeController;
use App\Http\Controllers\Student\QuizController;
use App\Http\Controllers\Student\AttendanceController;

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
Route::get('/extracurriculars', [PublicController::class, 'extracurriculars'])->name('extracurriculars.index');
Route::get('/extracurriculars/{slug}', [PublicController::class, 'extracurricularDetail'])->name('extracurriculars.detail');
Route::post('/extracurriculars/{extracurricular}/register', [PublicController::class, 'registerExtracurricular'])->name('extracurriculars.register');
Route::get('/announcements', [PublicController::class, 'announcements'])->name('announcements.index');
Route::get('/announcements/{id}', [PublicController::class, 'announcementDetail'])->name('announcements.show');

Route::get('/facilities', [PublicController::class, 'facilities'])->name('facilities.index');
Route::get('/achievements', [PublicController::class, 'achievements'])->name('achievements.index');
Route::get('/academic/programs', [PublicController::class, 'academicPrograms'])->name('public.academic.programs');
Route::get('/academic/calendar', [PublicController::class, 'academicCalendar'])->name('academic.calendar');
Route::get('/videos', [PublicController::class, 'videos'])->name('public.videos.index');
Route::get('/videos/{id}', [PublicController::class, 'videoDetail'])->name('public.videos.show');
Route::post('/videos/{id}/increment-view', [PublicController::class, 'incrementVideoView'])->name('public.videos.increment-view');
Route::get('/videos/{id}/download', [PublicController::class, 'videoDownload'])->name('public.videos.download');
Route::get('/blog', [PublicBlogController::class, 'index'])->name('public.blog.index');
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
    
    // API endpoints for AJAX calls
    Route::get('extracurriculars/{extracurricular}/members-json', [ExtracurricularController::class, 'getMembersJson'])->name('extracurriculars.members.json');
    Route::get('extracurriculars/{extracurricular}/registrations-json', [ExtracurricularController::class, 'getRegistrationsJson'])->name('extracurriculars.registrations.json');
    Route::get('extracurriculars/all-pending-registrations', [ExtracurricularController::class, 'getAllPendingRegistrations'])->name('extracurriculars.all-pending-registrations');
    Route::post('extracurriculars/member/{registration}/status', [ExtracurricularController::class, 'updateMemberStatus'])->name('extracurriculars.member.status');
    Route::post('extracurriculars/registration/{registration}/status', [ExtracurricularController::class, 'updateRegistrationStatus'])->name('extracurriculars.registration.status');
    
    // Achievements management
    Route::resource('achievements', AchievementController::class);
    Route::post('achievements/bulk-action', [AchievementController::class, 'bulkAction'])->name('achievements.bulk-action');
    Route::post('achievements/{achievement}/toggle-featured', [AchievementController::class, 'toggleFeatured'])->name('achievements.toggle-featured');
    
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