@extends('layouts.public')

@section('title', 'Visi & Misi')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Visi Misi SMA Negeri 1 Balong</h1>
                <p class="lead mb-4">Menjadi sekolah unggulan yang mencetak generasi berkarakter dan berprestasi</p>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-school" style="font-size: 8rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="bi bi-eye"></i> Visi Sekolah</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">"Menjadi sekolah unggulan yang mencetak generasi berkarakter, berprestasi, dan siap menghadapi tantangan global dengan dilandasi iman dan takwa."</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0"><i class="bi bi-list-task"></i> Misi Sekolah</h3>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>Menyelenggarakan pendidikan yang bermutu dan berkarakter</li>
                            <li>Mengembangkan potensi akademik dan non-akademik siswa secara optimal</li>
                            <li>Menumbuhkan semangat keunggulan dan kompetitif yang sehat</li>
                            <li>Membangun lingkungan sekolah yang nyaman, aman, dan kondusif</li>
                            <li>Menjalin kerjasama yang harmonis dengan orang tua dan masyarakat</li>
                            <li>Mengembangkan pembelajaran yang inovatif dan berwawasan global</li>
                        </ol>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h3 class="mb-0"><i class="bi bi-bullseye"></i> Tujuan Sekolah</h3>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Mencapai kelulusan 100% dengan nilai yang memuaskan</li>
                            <li>Menghasilkan lulusan yang berakhlak mulia dan berkarakter kuat</li>
                            <li>Meningkatkan prestasi siswa di bidang akademik dan non-akademik</li>
                            <li>Mengoptimalkan pemanfaatan teknologi dalam pembelajaran</li>
                            <li>Menjadi sekolah rujukan dalam penerapan pendidikan karakter</li>
                            <li>Meningkatkan kompetensi guru melalui pengembangan profesional berkelanjutan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection