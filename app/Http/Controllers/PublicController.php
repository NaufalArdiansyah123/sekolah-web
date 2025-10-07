<?php
// app/Http/Controllers/PublicController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow; // Tambahkan ini untuk menggunakan model Slideshow

use App\Models\BlogPost;
use App\Models\Video;
use App\Models\Post;
use App\Models\CalendarEvent;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\SchoolProfile;
use App\Models\Vision;
use App\Models\Achievement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
  public function index()
{
    $slideshows = Slideshow::where('status', 'active')
                          ->orderBy('order', 'asc')
                          ->get();
    
    // Get latest blog posts for homepage (berita terbaru)
    $latestNews = BlogPost::with('user')
                          ->published()
                          ->latest('published_at')
                          ->take(3)
                          ->get();
    
    // Get latest announcements for homepage (pengumuman penting)
    $latestAnnouncements = Announcement::published()
                                      ->latest('created_at')
                                      ->take(3)
                                      ->get();
    
    // Get upcoming agendas for homepage
    $upcomingAgendas = Post::where('type', 'agenda')
                          ->where('status', 'published')
                          ->where('event_date', '>=', now())
                          ->orderBy('event_date', 'asc')
                          ->take(3)
                          ->get();
    
    return view('public.home', [
        'title' => 'Beranda',
        'description' => 'Website resmi SMA Negeri 1 - Excellence in Education',
        'slideshows' => $slideshows,
        'latestNews' => $latestNews,
        'latestAnnouncements' => $latestAnnouncements,
        'upcomingAgendas' => $upcomingAgendas
    ]);
}


    public function aboutProfile()
    {
        $schoolProfile = SchoolProfile::getActiveProfile();
        
        // If no active profile, create default data
        if (!$schoolProfile) {
            $schoolProfile = $this->getDefaultProfileData();
        }
        
        // Get principal from teachers database
        $principal = \App\Models\Teacher::where('position', 'Kepala Sekolah')
                                        ->where('status', 'active')
                                        ->first();
        
        // Override principal data with database data if available
        if ($principal) {
            $schoolProfile->principal_name = $principal->name;
            $schoolProfile->principal_photo = $principal->photo ? asset('storage/' . $principal->photo) : null;
            $schoolProfile->principal_education = $principal->education;
            $schoolProfile->principal_nip = $principal->nip;
            $schoolProfile->principal_email = $principal->email;
            $schoolProfile->principal_phone = $principal->phone;
        }
        
        // Get latest achievements from database
        $achievements = Achievement::active()
                                  ->featured()
                                  ->latest('achievement_date')
                                  ->take(6)
                                  ->get();
        
        // If no featured achievements, get latest achievements
        if ($achievements->count() === 0) {
            $achievements = Achievement::active()
                                      ->latest('achievement_date')
                                      ->take(6)
                                      ->get();
        }
        
        return view('public.about.profile', [
            'title' => 'Profil Sekolah',
            'profile' => $schoolProfile,
            'principal' => $principal,
            'achievements' => $achievements
        ]);
    }
    
    /**
     * Get default profile data when no profile is set
     */
    private function getDefaultProfileData()
    {
        return (object) [
            'school_name' => 'SMK PGRI 2 PONOROGO',
            'school_motto' => 'Excellence in Education',
            'about_description' => 'SMK PGRI 2 PONOROGO adalah institusi pendidikan menengah atas yang telah berkiprah dalam dunia pendidikan selama lebih dari 30 tahun.',
            'vision' => 'Menjadi sekolah unggulan yang menghasilkan lulusan berkarakter, berprestasi, dan siap menghadapi tantangan masa depan.',
            'mission' => 'Memberikan pendidikan berkualitas dengan mengintegrasikan nilai-nilai karakter, teknologi, dan kearifan lokal.',
            'history' => 'Didirikan pada tahun 1990 dengan komitmen memberikan pendidikan terbaik untuk generasi penerus bangsa.',
            'established_year' => 1990,
            'accreditation' => 'A',
            'principal_name' => 'Singgih Wibowo A Se.MM',
            'address' => 'Jl. Pendidikan No. 123, Balong',
            'phone' => '(021) 4567890',
            'email' => 'info@sman1balong.sch.id',
            'website' => 'www.sman1balong.sch.id',
            'student_count' => 2400,
            'teacher_count' => 120,
            'staff_count' => 40,
            'industry_partnerships' => 110,
            'social_media' => [
                'facebook' => '#',
                'instagram' => '#',
                'twitter' => '#',
                'youtube' => '#'
            ],
            'facilities' => [
                ['name' => 'Studio Seni', 'description' => 'Ruang musik, tari, dan seni rupa untuk pengembangan bakat', 'features' => ['Piano & keyboard', 'Sound system', 'Panggung mini']],
                ['name' => 'Laboratorium IPA', 'description' => 'Laboratorium lengkap untuk praktikum fisika, kimia, dan biologi', 'features' => ['Mikroskop digital', 'Alat praktikum lengkap', 'Ruang ber-AC']],
                ['name' => 'Perpustakaan Digital', 'description' => 'Perpustakaan modern dengan koleksi buku dan e-book', 'features' => ['10,000+ buku fisik', 'E-library access', 'Ruang baca nyaman']]
            ],
            'achievements' => [
                ['title' => 'Juara 1 Olimpiade Sains Nasional 2024', 'description' => 'Bidang Matematika - Tingkat Nasional', 'level' => 'Nasional', 'year' => 2024],
                ['title' => 'Sekolah Adiwiyata Tingkat Provinsi', 'description' => 'Penghargaan sekolah berwawasan lingkungan', 'level' => 'Provinsi', 'year' => 2024],
                ['title' => 'Juara Umum Debat Bahasa Inggris', 'description' => 'English Debate Competition 2024', 'level' => 'Kota', 'year' => 2024]
            ],
            'programs' => [
                'IPA', 'IPS', 'Bahasa & Budaya'
            ],
            'vice_principals' => [
                ['name' => 'Dr. Siti Nurhaliza, S.Pd', 'position' => 'Wakil Kepala Sekolah', 'field' => 'Bidang Kurikulum dan Pembelajaran'],
                ['name' => 'Budi Santoso, M.Pd', 'position' => 'Wakil Kepala Sekolah', 'field' => 'Bidang Kesiswaan dan Karakter']
            ]
        ];
    }
    
    /**
     * Get default vision data when no vision is set
     */
    private function getDefaultVisionData()
    {
        return (object) [
            'title' => 'Visi & Misi Sekolah',
            'vision_text' => 'Terwujudnya sekolah yang unggul, berkarakter, dan berwawasan lingkungan dalam menghasilkan lulusan yang cerdas, kreatif, mandiri, dan berakhlak mulia',
            'hero_title' => 'Visi & Misi',
            'hero_subtitle' => 'Komitmen kami untuk menciptakan pendidikan berkualitas dan membentuk generasi yang berkarakter, berprestasi, dan siap menghadapi tantangan masa depan.',
            'hero_image' => null,
            'mission_items_formatted' => [
                [
                    'number' => 1,
                    'title' => 'Menyelenggarakan pendidikan berkualitas',
                    'description' => 'dengan mengintegrasikan kurikulum nasional dan teknologi pembelajaran modern',
                    'icon' => 'fas fa-graduation-cap'
                ],
                [
                    'number' => 2,
                    'title' => 'Mengembangkan karakter siswa',
                    'description' => 'melalui program pendidikan nilai-nilai keagamaan, nasionalisme, dan kepemimpinan',
                    'icon' => 'fas fa-users'
                ],
                [
                    'number' => 3,
                    'title' => 'Memfasilitasi pengembangan bakat dan minat',
                    'description' => 'siswa melalui kegiatan ekstrakurikuler dan program unggulan',
                    'icon' => 'fas fa-star'
                ],
                [
                    'number' => 4,
                    'title' => 'Membangun budaya sekolah',
                    'description' => 'yang kondusif, aman, nyaman, dan berwawasan lingkungan',
                    'icon' => 'fas fa-leaf'
                ],
                [
                    'number' => 5,
                    'title' => 'Menjalin kemitraan strategis',
                    'description' => 'dengan stakeholder untuk mendukung program pendidikan dan pengembangan sekolah',
                    'icon' => 'fas fa-handshake'
                ]
            ],
            'goals_with_icons' => [
                [
                    'title' => 'Kualitas Akademik',
                    'description' => 'Meningkatkan prestasi akademik dan daya saing lulusan di tingkat nasional',
                    'icon' => 'fas fa-graduation-cap',
                    'color' => 'primary'
                ],
                [
                    'title' => 'Pembentukan Karakter',
                    'description' => 'Menghasilkan lulusan yang berakhlak mulia dan berkarakter kuat',
                    'icon' => 'fas fa-users',
                    'color' => 'success'
                ],
                [
                    'title' => 'Peduli Lingkungan',
                    'description' => 'Mewujudkan sekolah hijau dan berkelanjutan untuk masa depan',
                    'icon' => 'fas fa-leaf',
                    'color' => 'success'
                ],
                [
                    'title' => 'Wawasan Global',
                    'description' => 'Mempersiapkan siswa dengan kompetensi global dan daya saing internasional',
                    'icon' => 'fas fa-globe',
                    'color' => 'info'
                ]
            ],
            'values_with_colors' => [
                [
                    'title' => 'KEADILAN',
                    'description' => 'Perlakuan yang adil dan merata untuk seluruh warga sekolah tanpa diskriminasi',
                    'icon' => 'fas fa-balance-scale',
                    'color' => 'primary'
                ],
                [
                    'title' => 'PEDULI LINGKUNGAN',
                    'description' => 'Kepedulian terhadap kelestarian lingkungan dan pembangunan berkelanjutan',
                    'icon' => 'fas fa-leaf',
                    'color' => 'success'
                ],
                [
                    'title' => 'INOVASI',
                    'description' => 'Kreativitas dan pembaruan berkelanjutan dalam metode dan pendekatan pendidikan',
                    'icon' => 'fas fa-lightbulb',
                    'color' => 'info'
                ]
            ],
            'focus_areas_with_icons' => [
                [
                    'title' => 'Peningkatan Kualitas Pembelajaran',
                    'description' => 'Fokus pada inovasi metode pembelajaran dan teknologi pendidikan',
                    'items' => [
                        'Implementasi kurikulum merdeka',
                        'Pembelajaran berbasis teknologi',
                        'Pengembangan critical thinking',
                        'Program literasi digital'
                    ],
                    'icon' => 'fas fa-brain',
                    'color' => 'primary'
                ],
                [
                    'title' => 'Pengembangan Karakter',
                    'description' => 'Pembentukan karakter dan nilai-nilai moral siswa',
                    'items' => [
                        'Program pendidikan karakter terintegrasi',
                        'Kegiatan keagamaan dan spiritual',
                        'Pengembangan kepemimpinan siswa',
                        'Program service learning'
                    ],
                    'icon' => 'fas fa-seedling',
                    'color' => 'success'
                ],
                [
                    'title' => 'Prestasi & Kompetisi',
                    'description' => 'Pengembangan bakat dan prestasi siswa',
                    'items' => [
                        'Program olimpiade sains',
                        'Kompetisi debat dan public speaking',
                        'Festival seni dan budaya',
                        'Turnamen olahraga'
                    ],
                    'icon' => 'fas fa-medal',
                    'color' => 'warning'
                ],
                [
                    'title' => 'Kemitraan Global',
                    'description' => 'Jaringan kerjasama internasional',
                    'items' => [
                        'Sister school program',
                        'Student exchange program',
                        'International certification',
                        'Global competency development'
                    ],
                    'icon' => 'fas fa-globe',
                    'color' => 'info'
                ]
            ],
            'roadmap_phases_formatted' => [
                [
                    'year' => '2025',
                    'title' => 'Fase Konsolidasi',
                    'description' => 'Penguatan sistem manajemen sekolah dan standardisasi proses pembelajaran digital',
                    'target' => 'Akreditasi A+ dan sertifikasi ISO 9001',
                    'color' => 'primary',
                    'status' => 'planned'
                ],
                [
                    'year' => '2026-2027',
                    'title' => 'Fase Ekspansi',
                    'description' => 'Pengembangan program unggulan dan kemitraan internasional',
                    'target' => '3 program sister school dan 5 sertifikasi internasional',
                    'color' => 'success',
                    'status' => 'planned'
                ],
                [
                    'year' => '2028-2029',
                    'title' => 'Fase Optimalisasi',
                    'description' => 'Implementasi full smart school dan pengembangan pusat keunggulan',
                    'target' => 'Center of Excellence dan Smart School Certification',
                    'color' => 'warning',
                    'status' => 'planned'
                ],
                [
                    'year' => '2030',
                    'title' => 'Pencapaian Visi',
                    'description' => 'Menjadi sekolah unggulan rujukan nasional dengan lulusan berkarakter global',
                    'target' => 'Top 10 sekolah terbaik nasional',
                    'color' => 'info',
                    'status' => 'planned'
                ]
            ]
        ];
    }

    public function aboutVision()
    {
        $vision = Vision::getActiveVision();
        
        // If no active vision, create default data
        if (!$vision) {
            $vision = $this->getDefaultVisionData();
        }
        
        return view('public.about.vision', [
            'title' => $vision->meta_title ?? $vision->title ?? 'Visi & Misi',
            'description' => $vision->meta_description ?? 'Visi, Misi, dan Tujuan Strategis Sekolah',
            'vision' => $vision
        ]);
    }
    
    public function sejarah()
    {
        $history = \App\Models\History::getActiveHistory();
        
        return view('public.about.sejarah', [
            'title' => $history ? $history->meta_title ?? $history->title : 'Sejarah Sekolah',
            'description' => $history ? $history->meta_description ?? 'Sejarah dan perjalanan sekolah kami' : 'Sejarah dan perjalanan sekolah kami',
            'history' => $history
        ]);
    }

    public function facilities()
    {
        return view('public.facilities.index', [
            'title' => 'Fasilitas Sekolah'
        ]);
    }

    public function achievements()
    {
        // Redirect ke route public achievements
        return app(\App\Http\Controllers\Public\AchievementController::class)->index(request());
    }

    // extracurriculars method moved to Public\ExtracurricularController

    public function academicPrograms()
    {
        return view('public.academic.programs', [
            'title' => 'Program Studi'
        ]);
    }

    public function academicCalendar(Request $request)
    {
        try {
            // Get calendar events
            $events = [];
            
            // Get events from calendar_events table if exists
            if (\Schema::hasTable('calendar_events')) {
                $calendarEvents = CalendarEvent::where('status', 'active')
                                              ->get()
                                              ->map(function($event) {
                                                  return [
                                                      'id' => 'calendar_' . $event->id,
                                                      'title' => $event->title,
                                                      'start' => $event->start_date->toISOString(),
                                                      'end' => $event->end_date ? $event->end_date->toISOString() : null,
                                                      'color' => $event->color ?? '#3b82f6',
                                                      'description' => $event->description,
                                                      'location' => $event->location,
                                                      'type' => $event->type,
                                                      'source' => 'calendar'
                                                  ];
                                              });
                $events = array_merge($events, $calendarEvents->toArray());
            }
            
            // Get events from agendas table if exists
            if (\Schema::hasTable('agendas')) {
                $agendaEvents = Agenda::all()
                                     ->map(function($agenda) {
                                         $startDate = Carbon::parse($agenda->tanggal);
                                         
                                         // If time is provided, combine with date
                                         if ($agenda->waktu) {
                                             try {
                                                 $time = Carbon::parse($agenda->waktu);
                                                 $startDate->setTime($time->hour, $time->minute);
                                             } catch (\Exception $e) {
                                                 // If time parsing fails, use date only
                                             }
                                         }
                                         
                                         return [
                                             'id' => 'agenda_' . $agenda->id,
                                             'title' => $agenda->judul,
                                             'start' => $startDate->toISOString(),
                                             'end' => $startDate->toISOString(),
                                             'color' => '#10b981', // Green for agenda
                                             'description' => $agenda->deskripsi ?? '',
                                             'location' => $agenda->lokasi,
                                             'type' => 'agenda',
                                             'source' => 'agenda'
                                         ];
                                     });
                $events = array_merge($events, $agendaEvents->toArray());
            }
            
            // Get events from posts table (agenda type)
            $postAgendas = Post::where('type', 'agenda')
                              ->where('status', 'published')
                              ->get()
                              ->map(function($agenda) {
                                  return [
                                      'id' => 'post_agenda_' . $agenda->id,
                                      'title' => $agenda->title,
                                      'start' => $agenda->event_date->toISOString(),
                                      'end' => $agenda->event_date->toISOString(),
                                      'color' => '#10b981', // Green for agenda
                                      'description' => $agenda->content,
                                      'location' => $agenda->location,
                                      'type' => 'agenda',
                                      'source' => 'post'
                                  ];
                              });
            $events = array_merge($events, $postAgendas->toArray());
            
            // No dummy data needed anymore
            
            // Get statistics
            $stats = [
                'total_events' => count($events),
                'upcoming_events' => collect($events)->filter(function($event) {
                    return Carbon::parse($event['start'])->isFuture();
                })->count(),
                'this_month_events' => collect($events)->filter(function($event) {
                    $eventDate = Carbon::parse($event['start']);
                    return $eventDate->month === now()->month && $eventDate->year === now()->year;
                })->count(),
                'today_events' => collect($events)->filter(function($event) {
                    return Carbon::parse($event['start'])->isToday();
                })->count()
            ];
            
            // Get upcoming events for sidebar
            $upcomingEvents = collect($events)
                            ->filter(function($event) {
                                return Carbon::parse($event['start'])->isFuture();
                            })
                            ->sortBy('start')
                            ->take(5)
                            ->values();
            
            return view('public.academic.calendar', [
                'title' => 'Kalender Akademik',
                'events' => $events,
                'stats' => $stats,
                'upcomingEvents' => $upcomingEvents
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error loading public calendar: ' . $e->getMessage());
            
            return view('public.academic.calendar', [
                'title' => 'Kalender Akademik',
                'events' => [],
                'stats' => [
                    'total_events' => 0,
                    'upcoming_events' => 0,
                    'this_month_events' => 0,
                    'today_events' => 0
                ],
                'upcomingEvents' => [],
                'error' => 'Terjadi kesalahan saat memuat kalender. Silakan coba lagi nanti.'
            ]);
        }
    }

    public function news(Request $request)
    {
        $query = Announcement::published()
                            ->latest('created_at');

        // Search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('kategori', $request->category);
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('prioritas', $request->priority);
        }

        $announcements = $query->paginate(12);
        
        // Get categories for filter
        $categories = Announcement::published()
                                 ->distinct()
                                 ->pluck('kategori')
                                 ->filter()
                                 ->sort();

        // Get priorities for filter
        $priorities = Announcement::published()
                                 ->distinct()
                                 ->pluck('prioritas')
                                 ->filter()
                                 ->sort();

        // Get latest announcements for sidebar
        $latestAnnouncements = Announcement::published()
                                          ->latest('created_at')
                                          ->take(5)
                                          ->get();

        return view('public.news.index', [
            'title' => 'Berita Terkini',
            'announcements' => $announcements,
            'categories' => $categories,
            'priorities' => $priorities,
            'latestAnnouncements' => $latestAnnouncements
        ]);
    }

    public function newsDetail($identifier)
    {
        // Try to find by slug first, then by ID
        $announcement = Announcement::published()
                                   ->where('slug', $identifier)
                                   ->first();
        
        if (!$announcement) {
            $announcement = Announcement::published()
                                       ->findOrFail($identifier);
        }
        
        // Increment view count
        $announcement->incrementViews();
        
        // Get related announcements
        $relatedAnnouncements = Announcement::published()
                                           ->where('id', '!=', $announcement->id)
                                           ->where('kategori', $announcement->kategori)
                                           ->latest('created_at')
                                           ->take(4)
                                           ->get();
        
        // If not enough related announcements, get more from other categories
        if ($relatedAnnouncements->count() < 4) {
            $additionalAnnouncements = Announcement::published()
                                                  ->where('id', '!=', $announcement->id)
                                                  ->whereNotIn('id', $relatedAnnouncements->pluck('id'))
                                                  ->latest('created_at')
                                                  ->take(4 - $relatedAnnouncements->count())
                                                  ->get();
            $relatedAnnouncements = $relatedAnnouncements->merge($additionalAnnouncements);
        }

        return view('public.news.show', [
            'title' => $announcement->judul,
            'announcement' => $announcement,
            'relatedAnnouncements' => $relatedAnnouncements
        ]);
    }

    public function agenda(Request $request)
    {
        $query = Post::where('type', 'agenda')
                    ->where('status', 'published')
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

        // Period filter
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'upcoming':
                    $query->where('event_date', '>', now());
                    break;
                case 'today':
                    $query->whereDate('event_date', today());
                    break;
                case 'this_week':
                    $query->whereBetween('event_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('event_date', now()->month)
                          ->whereYear('event_date', now()->year);
                    break;
                case 'past':
                    $query->where('event_date', '<', now());
                    break;
            }
        }

        // Month filter (only if period is not set to specific time ranges)
        if ($request->filled('month') && !in_array($request->period, ['today', 'this_week', 'this_month'])) {
            $query->whereMonth('event_date', $request->month);
        }
        
        // Year filter
        if ($request->filled('year') && !in_array($request->period, ['today', 'this_week', 'this_month'])) {
            $query->whereYear('event_date', $request->year);
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'date_asc':
                $query->orderBy('event_date', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('event_date', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default: // latest
                $query->latest('event_date');
        }
        
        $agendas = $query->paginate(10);
        
        // Statistics
        $totalAgenda = Post::where('type', 'agenda')->where('status', 'published')->count();
        $upcomingAgenda = Post::where('type', 'agenda')->where('status', 'published')->where('event_date', '>', now())->count();
        $todayAgenda = Post::where('type', 'agenda')->where('status', 'published')->whereDate('event_date', today())->count();
        $agendaWithLocation = Post::where('type', 'agenda')->where('status', 'published')->whereNotNull('location')->count();

        return view('public.agenda.index', [
            'title' => 'Agenda Kegiatan',
            'agendas' => $agendas,
            'totalAgenda' => $totalAgenda,
            'upcomingAgenda' => $upcomingAgenda,
            'todayAgenda' => $todayAgenda,
            'agendaWithLocation' => $agendaWithLocation
        ]);
    }
    
    public function agendaDetail($id)
    {
        $agenda = Post::where('type', 'agenda')
                     ->where('status', 'published')
                     ->findOrFail($id);
        
        // Get related agendas
        $relatedAgendas = Post::where('type', 'agenda')
                             ->where('status', 'published')
                             ->where('id', '!=', $id)
                             ->latest('event_date')
                             ->take(3)
                             ->get();
        
        return view('public.agenda.show', [
            'title' => $agenda->title,
            'agenda' => $agenda,
            'relatedAgendas' => $relatedAgendas
        ]);
    }

    public function galleryPhotos()
    {
        // Redirect to main gallery index
        return redirect()->route('gallery.index');
    }

    public function galleryVideos()
    {
        return view('public.gallery.videos', [
            'title' => 'Galeri Video'
        ]);
    }
    
    public function videos(Request $request)
    {
        $query = Video::active()->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $videos = $query->paginate(12);
        $featuredVideos = Video::active()->featured()->latest()->take(6)->get();
        $categories = Video::getCategoryOptions();

        // Get video statistics
        $stats = [
            'total_videos' => Video::active()->count(),
            'total_views' => Video::active()->sum('views'),
            'total_downloads' => Video::active()->sum('downloads'),
            'categories_count' => Video::active()->distinct('category')->count(),
        ];

        return view('public.videos.index', [
            'title' => 'Video Dokumentasi',
            'videos' => $videos,
            'featuredVideos' => $featuredVideos,
            'categories' => $categories,
            'stats' => $stats
        ]);
    }
    
    public function videoDetail($id)
    {
        $video = Video::active()->findOrFail($id);
        
        // Increment view count
        $video->increment('views');
        
        // Get related videos
        $relatedVideos = Video::active()
                             ->where('id', '!=', $id)
                             ->where('category', $video->category)
                             ->latest()
                             ->take(6)
                             ->get();
        
        // If not enough related videos, get more from other categories
        if ($relatedVideos->count() < 6) {
            $additionalVideos = Video::active()
                                   ->where('id', '!=', $id)
                                   ->whereNotIn('id', $relatedVideos->pluck('id'))
                                   ->latest()
                                   ->take(6 - $relatedVideos->count())
                                   ->get();
            $relatedVideos = $relatedVideos->merge($additionalVideos);
        }
        
        return view('public.videos.show', [
            'title' => $video->title,
            'video' => $video,
            'relatedVideos' => $relatedVideos
        ]);
    }
    
    public function incrementVideoView($id)
    {
        $video = Video::active()->findOrFail($id);
        $video->increment('views');
        
        return response()->json(['success' => true, 'views' => $video->views]);
    }
    
    public function videoDownload($id)
    {
        $video = Video::active()->findOrFail($id);
        
        // Increment download count
        $video->increment('downloads');
        
        // Check if video file exists
        if (!$video->filename || !file_exists(storage_path('app/public/videos/' . $video->filename))) {
            abort(404, 'Video file not found');
        }
        
        $filePath = storage_path('app/public/videos/' . $video->filename);
        $fileName = $video->original_name ?: ($video->title . '.' . pathinfo($video->filename, PATHINFO_EXTENSION));
        
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }
    
    public function galleryIndex()
    {
        return redirect()->route('gallery.index');
    }



    public function contact()
    {
        $contact = \App\Models\Contact::getActiveContact();
        
        return view('public.contact', [
            'title' => 'Kontak Kami',
            'description' => 'Hubungi kami untuk informasi lebih lanjut tentang sekolah',
            'contact' => $contact
        ]);
    }

    public function announcements(Request $request)
    {
        $query = Announcement::published()
                            ->latest('created_at');

        // Search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('kategori', $request->category);
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('prioritas', $request->priority);
        }

        $announcements = $query->paginate(12);
        
        // Get categories for filter
        $categories = Announcement::published()
                                 ->distinct()
                                 ->pluck('kategori')
                                 ->filter()
                                 ->sort();

        // Get priorities for filter
        $priorities = Announcement::published()
                                 ->distinct()
                                 ->pluck('prioritas')
                                 ->filter()
                                 ->sort();
        
        return view('public.announcements.index', [
            'title' => 'Pengumuman Sekolah',
            'announcements' => $announcements,
            'categories' => $categories,
            'priorities' => $priorities
        ]);
    }

    public function announcementDetail($id)
    {
        $announcement = Announcement::published()
                                   ->findOrFail($id);
        
        // Increment view count
        $announcement->incrementViews();
        
        // Get related announcements
        $relatedAnnouncements = Announcement::published()
                                           ->where('id', '!=', $announcement->id)
                                           ->where('kategori', $announcement->kategori)
                                           ->latest('created_at')
                                           ->take(4)
                                           ->get();
        
        // If not enough related announcements, get more from other categories
        if ($relatedAnnouncements->count() < 4) {
            $additionalAnnouncements = Announcement::published()
                                                  ->where('id', '!=', $announcement->id)
                                                  ->whereNotIn('id', $relatedAnnouncements->pluck('id'))
                                                  ->latest('created_at')
                                                  ->take(4 - $relatedAnnouncements->count())
                                                  ->get();
            $relatedAnnouncements = $relatedAnnouncements->merge($additionalAnnouncements);
        }
        
        return view('public.announcements.show', [
            'title' => $announcement->judul,
            'announcement' => $announcement,
            'relatedAnnouncements' => $relatedAnnouncements
        ]);
    }

    public function submitContact(Request $request)
    {
        // Handle contact form submission
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Here you would typically save to database or send email
        // For now, just return success
        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    public function downloads(Request $request)
    {
        // For now, return the downloads view with sample data
        // In the future, this would fetch from a downloads model/database
        return view('public.downloads.index', [
            'title' => 'Download Center',
            'description' => 'Akses berbagai materi pembelajaran, dokumentasi kegiatan, dan file penting lainnya'
        ]);
    }

    public function downloadDetail($id)
    {
        // For now, return a simple response
        // In the future, this would fetch specific download details
        return view('public.downloads.show', [
            'title' => 'Download Detail',
            'id' => $id
        ]);
    }

    public function downloadFile($id)
    {
        // For now, return a simple response
        // In the future, this would handle actual file downloads
        return response()->json([
            'success' => true,
            'message' => 'Download started for file ID: ' . $id
        ]);
    }


}