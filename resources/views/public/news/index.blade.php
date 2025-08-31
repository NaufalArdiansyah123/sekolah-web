@extends('layouts.public')

@section('title', 'Berita Terbaru')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Berita - SMA Negeri 1 Balong</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --accent-color: #20c997;
            --dark-color: #212529;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #004d9e 100%);
            color: white;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateX(-50px) translateY(-50px); }
            100% { transform: translateX(50px) translateY(50px); }
        }

        .blog-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .blog-card img {
            transition: transform 0.3s ease;
            height: 200px;
            object-fit: cover;
        }

        .blog-card:hover img {
            transform: scale(1.05);
        }

        .featured-card {
            background: linear-gradient(45deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            overflow: hidden;
        }

        .featured-card img {
            height: 250px;
        }

        .badge-custom {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .sidebar-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .category-item {
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 1rem;
            text-decoration: none;
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .category-item:hover {
            background: var(--primary-color) !important;
            color: white !important;
            transform: translateX(5px);
        }

        .popular-item {
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            border-left: 4px solid var(--accent-color);
        }

        .popular-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }

        .pagination-custom .page-link {
            border-radius: 10px;
            margin: 0 2px;
            border: none;
            color: var(--primary-color);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .pagination-custom .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            transform: scale(1.1);
        }

        .pagination-custom .page-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .newsletter-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
        }

        .btn-gradient {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Blog Berita SMA Negeri 1 Balong</h1>
                    <p class="lead mb-4">Informasi terkini seputar kegiatan, prestasi, dan perkembangan sekolah dalam format blog yang mudah dibaca.</p>
                    <div class="d-flex gap-3">
                        <span class="badge bg-light text-dark fs-6">📰 Berita Terbaru</span>
                        <span class="badge bg-light text-dark fs-6">🏆 Prestasi</span>
                        <span class="badge bg-light text-dark fs-6">📚 Akademik</span>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-newspaper" style="font-size: 8rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Blog Content -->
                <div class="col-lg-8">
                    <!-- Loading Indicator -->
                    <div class="loading" id="loading">
                        <div class="spinner"></div>
                        <p>Memuat berita...</p>
                    </div>

                    <!-- Blog Posts Container -->
                    <div id="blog-container" class="fade-in">
                        <!-- Featured Post -->
                        <article class="featured-card shadow mb-5 blog-card">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <img src="https://picsum.photos/400/250?random=1" class="img-fluid h-100" alt="Featured News">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body p-4">
                                        <span class="badge badge-custom bg-primary mb-3">✨ Utama</span>
                                        <h3 class="card-title fw-bold mb-3">SMA Negeri 1 Balong Raih Juara Umum Olimpiade Sains Nasional 2024</h3>
                                        <p class="card-text text-muted">Prestasi membanggakan kembali ditorehkan oleh siswa-siswi SMA Negeri 1 Balong dengan meraih 5 medali emas dan 3 medali perak dalam Olimpiade Sains Nasional 2024. Pencapaian ini membuktikan kualitas pendidikan...</p>
                                        <div class="d-flex justify-content-between align-items-center mt-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <small class="text-muted"><i class="fas fa-calendar me-1"></i> 15 September 2024</small>
                                                <small class="text-muted"><i class="fas fa-user me-1"></i> Admin</small>
                                                <small class="text-muted"><i class="fas fa-eye me-1"></i> 1,245 views</small>
                                            </div>
                                            <a href="#" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <!-- Blog Posts Grid -->
                        <div class="row g-4" id="posts-grid">
                            <!-- Posts will be loaded here -->
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Blog pagination" class="mt-5">
                        <ul class="pagination pagination-custom justify-content-center" id="pagination">
                            <!-- Pagination will be generated here -->
                        </ul>
                    </nav>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Search -->
                    <div class="sidebar-card mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3"><i class="fas fa-search me-2 text-primary"></i>Cari Berita</h5>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Kata kunci..." id="searchInput">
                                <button class="btn btn-primary" type="button" onclick="searchPosts()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Kategori Berita</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column" id="categories">
                                <a href="#" class="category-item bg-light text-dark" onclick="filterByCategory('all')">
                                    <span>Semua Berita</span>
                                    <span class="badge bg-primary">28</span>
                                </a>
                                <a href="#" class="category-item bg-light text-dark" onclick="filterByCategory('prestasi')">
                                    <span>Prestasi</span>
                                    <span class="badge bg-primary">12</span>
                                </a>
                                <a href="#" class="category-item bg-light text-dark" onclick="filterByCategory('kegiatan')">
                                    <span>Kegiatan</span>
                                    <span class="badge bg-primary">8</span>
                                </a>
                                <a href="#" class="category-item bg-light text-dark" onclick="filterByCategory('akademik')">
                                    <span>Akademik</span>
                                    <span class="badge bg-primary">5</span>
                                </a>
                                <a href="#" class="category-item bg-light text-dark" onclick="filterByCategory('beasiswa')">
                                    <span>Beasiswa</span>
                                    <span class="badge bg-primary">3</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Popular Posts -->
                    <div class="sidebar-card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Postingan Populer</h5>
                        </div>
                        <div class="card-body">
                            <div id="popular-posts">
                                <div class="popular-item">
                                    <h6 class="mb-2">Penerimaan Peserta Didik Baru 2024/2025 Dibuka</h6>
                                    <small class="text-muted"><i class="fas fa-eye me-1"></i> 1,245 views • 2 hari yang lalu</small>
                                </div>
                                <div class="popular-item">
                                    <h6 class="mb-2">Workshop Digital Marketing untuk Siswa Kelas XII</h6>
                                    <small class="text-muted"><i class="fas fa-eye me-1"></i> 987 views • 3 hari yang lalu</small>
                                </div>
                                <div class="popular-item">
                                    <h6 class="mb-2">Siswa SMA Negeri 1 Balong Lolos OSN Tingkat Nasional</h6>
                                    <small class="text-muted"><i class="fas fa-eye me-1"></i> 856 views • 5 hari yang lalu</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="sidebar-card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Tag Populer</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border" style="cursor: pointer;" onclick="filterByTag('olimpiade')">#olimpiade</span>
                                <span class="badge bg-light text-dark border" style="cursor: pointer;" onclick="filterByTag('prestasi')">#prestasi</span>
                                <span class="badge bg-light text-dark border" style="cursor: pointer;" onclick="filterByTag('olahraga')">#olahraga</span>
                                <span class="badge bg-light text-dark border" style="cursor: pointer;" onclick="filterByTag('seni')">#seni</span>
                                <span class="badge bg-light text-dark border" style="cursor: pointer;" onclick="filterByTag('akademik')">#akademik</span>
                                <span class="badge bg-light text-dark border" style="cursor: pointer;" onclick="filterByTag('beasiswa')">#beasiswa</span>
                            </div>
                        </div>
                    </div>

                    <!-- Archive -->
                    <div class="sidebar-card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="fas fa-archive me-2"></i>Arsip Blog</h5>
                        </div>
                        <div class="card-body">
                            <select class="form-select mb-3" id="yearSelect" onchange="filterByDate()">
                                <option>Pilih Tahun</option>
                                <option value="2024" selected>2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                            </select>
                            <select class="form-select mb-3" id="monthSelect" onchange="filterByDate()">
                                <option>Pilih Bulan</option>
                                <option value="09" selected>September</option>
                                <option value="08">Agustus</option>
                                <option value="07">Juli</option>
                            </select>
                            <button class="btn btn-outline-primary w-100" onclick="filterByDate()">
                                <i class="fas fa-search me-2"></i>Lihat Arsip
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h3 class="mb-3 fw-bold">📧 Berlangganan Newsletter Blog</h3>
                    <p class="text-muted mb-4">Dapatkan update postingan blog dan berita terbaru dari SMA Negeri 1 Balong langsung ke email Anda setiap minggu.</p>
                    <form class="row g-3 justify-content-center" onsubmit="subscribeNewsletter(event)">
                        <div class="col-md-8">
                            <input type="email" class="form-control form-control-lg" placeholder="Masukkan alamat email Anda" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-gradient btn-lg w-100">Berlangganan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Blog data simulation
        const allPosts = [
            {
                id: 1,
                title: "Tim Basket Putra Juara Turnamen Antarsekolah",
                excerpt: "Tim basket putra SMA Negeri 1 Balong berhasil menjadi juara dalam turnamen antarsekolah se-kota yang diselenggarakan akhir pekan lalu dengan permainan yang menawan.",
                category: "prestasi",
                date: "2024-09-10",
                author: "Admin Olahraga",
                views: 543,
                image: "https://picsum.photos/300/200?random=2",
                tags: ["olahraga", "prestasi", "basket"]
            },
            {
                id: 2,
                title: "Peringatan Hari Kemerdekaan RI ke-79 di SMA Negeri 1 Balong",
                excerpt: "Berbagai lomba dan kegiatan seru digelar dalam rangka memeriahkan Hari Kemerdekaan RI ke-79 di lingkungan sekolah dengan partisipasi seluruh warga sekolah.",
                category: "kegiatan",
                date: "2024-09-05",
                author: "Admin Sekolah",
                views: 789,
                image: "https://picsum.photos/300/200?random=3",
                tags: ["kemerdekaan", "kegiatan", "lomba"]
            },
            {
                id: 3,
                title: "Workshop Pengembangan Kurikulum untuk Guru",
                excerpt: "Sebanyak 80 guru SMA Negeri 1 Balong mengikuti workshop pengembangan kurikulum untuk meningkatkan kualitas pembelajaran di era digital.",
                category: "akademik",
                date: "2024-09-03",
                author: "Tim Akademik",
                views: 432,
                image: "https://picsum.photos/300/200?random=4",
                tags: ["guru", "kurikulum", "akademik"]
            },
            {
                id: 4,
                title: "20 Siswa Berprestasi Terima Beasiswa Pendidikan",
                excerpt: "Sebanyak 20 siswa berprestasi dari keluarga kurang mampu menerima beasiswa pendidikan dari Yayasan Peduli Pendidikan Indonesia senilai total 200 juta rupiah.",
                category: "beasiswa",
                date: "2024-09-01",
                author: "Admin Siswa",
                views: 654,
                image: "https://picsum.photos/300/200?random=5",
                tags: ["beasiswa", "prestasi", "bantuan"]
            },
            {
                id: 5,
                title: "Festival Sains dan Teknologi SMA Negeri 1 Balong 2024",
                excerpt: "Ajang kreativitas siswa dalam bidang sains dan teknologi dengan berbagai inovasi menarik dari proyek-proyek siswa kelas X hingga XII.",
                category: "kegiatan",
                date: "2024-08-28",
                author: "Tim Sains",
                views: 567,
                image: "https://picsum.photos/300/200?random=6",
                tags: ["sains", "teknologi", "festival"]
            },
            {
                id: 6,
                title: "Siswa Kelas XI Raih Medali Perak Kompetisi Matematika Tingkat Provinsi",
                excerpt: "Prestasi gemilang diraih Muhammad Fadil siswa kelas XI IPA 2 yang berhasil meraih medali perak dalam Kompetisi Matematika tingkat Provinsi.",
                category: "prestasi",
                date: "2024-08-25",
                author: "Guru Matematika",
                views: 445,
                image: "https://picsum.photos/300/200?random=7",
                tags: ["matematika", "olimpiade", "prestasi"]
            },
            {
                id: 7,
                title: "Program Literasi Digital untuk Seluruh Siswa",
                excerpt: "SMA Negeri 1 Balong meluncurkan program literasi digital komprehensif untuk membekali siswa dengan kemampuan teknologi informasi yang mumpuni.",
                category: "akademik",
                date: "2024-08-20",
                author: "Tim IT",
                views: 678,
                image: "https://picsum.photos/300/200?random=8",
                tags: ["digital", "literasi", "teknologi"]
            },
            {
                id: 8,
                title: "Ekstrakurikuler Robotic Club Juara Regional",
                excerpt: "Tim robot SMA Negeri 1 Balong meraih juara 1 dalam kompetisi robotik tingkat regional dengan inovasi robot pembersih lingkungan.",
                category: "prestasi",
                date: "2024-08-15",
                author: "Pembina Robotik",
                views: 523,
                image: "https://picsum.photos/300/200?random=9",
                tags: ["robotik", "prestasi", "teknologi"]
            }
        ];

        let currentPage = 1;
        let postsPerPage = 4;
        let filteredPosts = allPosts;
        let currentCategory = 'all';

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            loadPosts();
        });

        function loadPosts() {
            showLoading();
            
            setTimeout(() => {
                const startIndex = (currentPage - 1) * postsPerPage;
                const endIndex = startIndex + postsPerPage;
                const postsToShow = filteredPosts.slice(startIndex, endIndex);

                displayPosts(postsToShow);
                generatePagination();
                hideLoading();
            }, 500);
        }

        function showLoading() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('blog-container').style.opacity = '0.5';
        }

        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('blog-container').style.opacity = '1';
        }

        function displayPosts(posts) {
            const container = document.getElementById('posts-grid');
            container.innerHTML = '';

            posts.forEach(post => {
                const categoryBadge = getCategoryBadge(post.category);
                const postCard = `
                    <div class="col-md-6">
                        <article class="blog-card shadow h-100">
                            <img src="${post.image}" class="card-img-top" alt="${post.title}">
                            <div class="card-body p-4">
                                ${categoryBadge}
                                <h5 class="card-title fw-bold mb-3">${post.title}</h5>
                                <p class="card-text text-muted">${post.excerpt}</p>
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    ${post.tags.map(tag => `<span class="badge bg-light text-dark border">#${tag}</span>`).join('')}
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div>
                                        <small class="text-muted d-block"><i class="fas fa-calendar me-1"></i> ${formatDate(post.date)}</small>
                                        <small class="text-muted"><i class="fas fa-eye me-1"></i> ${post.views} views</small>
                                    </div>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Baca</a>
                                </div>
                            </div>
                        </article>
                    </div>
                `;
                container.innerHTML += postCard;
            });

            // Add fade-in animation
            container.classList.add('fade-in');
        }

        function getCategoryBadge(category) {
            const badges = {
                'prestasi': '<span class="badge badge-custom bg-success mb-3">🏆 Prestasi</span>',
                'kegiatan': '<span class="badge badge-custom bg-info mb-3">🎉 Kegiatan</span>',
                'akademik': '<span class="badge badge-custom bg-warning text-dark mb-3">📚 Akademik</span>',
                'beasiswa': '<span class="badge badge-custom bg-danger mb-3">💰 Beasiswa</span>'
            };
            return badges[category] || '<span class="badge badge-custom bg-secondary mb-3">📰 Berita</span>';
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
        }

        function generatePagination() {
            const totalPages = Math.ceil(filteredPosts.length / postsPerPage);
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            // Previous button
            const prevDisabled = currentPage === 1 ? 'disabled' : '';
            pagination.innerHTML += `
                <li class="page-item ${prevDisabled}">
                    <a class="page-link" href="#" onclick="changePage(${currentPage - 1})" ${prevDisabled ? 'tabindex="-1" aria-disabled="true"' : ''}>
                        <i class="fas fa-chevron-left"></i> Sebelumnya
                    </a>
                </li>
            `;

            // Page numbers
            const startPage = Math.max(1, currentPage - 2);
            const endPage = Math.min(totalPages, startPage + 4);

            for (let i = startPage; i <= endPage; i++) {
                const active = i === currentPage ? 'active' : '';
                pagination.innerHTML += `
                    <li class="page-item ${active}">
                        <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                    </li>
                `;
            }

            // Next button
            const nextDisabled = currentPage === totalPages ? 'disabled' : '';
            pagination.innerHTML += `
                <li class="page-item ${nextDisabled}">
                    <a class="page-link" href="#" onclick="changePage(${currentPage + 1})" ${nextDisabled ? 'tabindex="-1" aria-disabled="true"' : ''}>
                        Selanjutnya <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            `;
        }

        function changePage(page) {
            const totalPages = Math.ceil(filteredPosts.length / postsPerPage);
            if (page < 1 || page > totalPages) return;
            
            currentPage = page;
            loadPosts();
            
            // Smooth scroll to top of content
            document.getElementById('blog-container').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }

        function filterByCategory(category) {
            currentCategory = category;
            currentPage = 1;
            
            if (category === 'all') {
                filteredPosts = allPosts;
            } else {
                filteredPosts = allPosts.filter(post => post.category === category);
            }
            
            loadPosts();
            
            // Update active category
            document.querySelectorAll('.category-item').forEach(item => {
                item.classList.remove('bg-primary', 'text-white');
                item.classList.add('bg-light', 'text-dark');
            });
            event.target.closest('.category-item').classList.remove('bg-light', 'text-dark');
            event.target.closest('.category-item').classList.add('bg-primary', 'text-white');
        }

        function filterByTag(tag) {
            currentPage = 1;
            filteredPosts = allPosts.filter(post => post.tags.includes(tag));
            loadPosts();
        }

        function searchPosts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            if (searchTerm.trim() === '') {
                filteredPosts = allPosts;
            } else {
                filteredPosts = allPosts.filter(post => 
                    post.title.toLowerCase().includes(searchTerm) ||
                    post.excerpt.toLowerCase().includes(searchTerm) ||
                    post.tags.some(tag => tag.toLowerCase().includes(searchTerm))
                );
            }
            currentPage = 1;
            loadPosts();
        }

        function filterByDate() {
            const year = document.getElementById('yearSelect').value;
            const month = document.getElementById('monthSelect').value;
            
            if (year && month) {
                filteredPosts = allPosts.filter(post => {
                    const postDate = new Date(post.date);
                    return postDate.getFullYear() === parseInt(year) && 
                           String(postDate.getMonth() + 1).padStart(2, '0') === month;
                });
                currentPage = 1;
                loadPosts();
            }
        }

        function subscribeNewsletter(event) {
            event.preventDefault();
            const email = event.target.querySelector('input[type="email"]').value;
            
            // Show success message
            const button = event.target.querySelector('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check me-2"></i>Berhasil!';
            button.classList.add('btn-success');
            button.classList.remove('btn-gradient');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-gradient');
                event.target.reset();
            }, 2000);
        }

        // Search on Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                searchPosts();
            }
        });

        // Add more posts for demonstration
        const additionalPosts = [
            {
                id: 9,
                title: "Kelas Fotografi Ekstrakurikuler Pamerkan Hasil Karya",
                excerpt: "Siswa ekstrakurikuler fotografi menggelar pameran foto dengan tema 'Keindahan Nusantara' yang menampilkan 50 karya terbaik dari 30 siswa.",
                category: "kegiatan",
                date: "2024-08-12",
                author: "Pembina Fotografi",
                views: 356,
                image: "https://picsum.photos/300/200?random=10",
                tags: ["fotografi", "seni", "pameran"]
            },
            {
                id: 10,
                title: "Pelatihan Public Speaking untuk Siswa OSIS",
                excerpt: "Pengurus OSIS mengikuti pelatihan public speaking intensif selama 3 hari untuk meningkatkan kemampuan komunikasi dan kepemimpinan.",
                category: "akademik",
                date: "2024-08-08",
                author: "Pembina OSIS",
                views: 423,
                image: "https://picsum.photos/300/200?random=11",
                tags: ["osis", "leadership", "komunikasi"]
            },
            {
                id: 11,
                title: "Tim Voli Putri Lolos ke Babak Semifinal Kejuaraan Daerah",
                excerpt: "Dengan permainan yang solid dan semangat juang tinggi, tim voli putri berhasil mengalahkan 3 sekolah unggulan untuk melaju ke semifinal.",
                category: "prestasi",
                date: "2024-08-05",
                author: "Pelatih Voli",
                views: 489,
                image: "https://picsum.photos/300/200?random=12",
                tags: ["voli", "olahraga", "prestasi"]
            },
            {
                id: 12,
                title: "Bakti Sosial ke Panti Asuhan Bersama Komunitas Peduli",
                excerpt: "Siswa-siswi SMA Negeri 1 Balong menggelar bakti sosial ke 3 panti asuhan dengan menyumbangkan buku, alat tulis, dan makanan.",
                category: "kegiatan",
                date: "2024-07-30",
                author: "PMR",
                views: 612,
                image: "https://picsum.photos/300/200?random=13",
                tags: ["baksos", "sosial", "komunitas"]
            }
        ];

        // Combine all posts
        allPosts.push(...additionalPosts);
        filteredPosts = allPosts;

        // Smooth scrolling for category clicks
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
            });
        });

        // Auto-refresh posts every 30 seconds (simulation)
        setInterval(() => {
            // In real application, this would fetch new posts from server
            console.log('Checking for new posts...');
        }, 30000);

        // Add visual feedback for interactions
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('page-link')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>