<?php
// app/Http/Controllers/PublicController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home', [
            'title' => 'Beranda',
            'description' => 'Website resmi SMA Negeri 1 - Excellence in Education'
        ]);
    }

    public function aboutProfile()
    {
        return view('public.about.profile', [
            'title' => 'Profil Sekolah'
        ]);
    }

    public function aboutVision()
    {
        return view('public.about.vision', [
            'title' => 'Visi & Misi'
        ]);
    }
    public function sejarah()
    {
        return view('public.about.sejarah', [
            'title' => 'Sejarah Sekolah'
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
        return view('public.achievements.index', [
            'title' => 'Prestasi Sekolah'
        ]);
    }

    public function extracurriculars()
    {
        return view('public.extracurriculars.index', [
            'title' => 'Ekstrakurikuler'
        ]);
    }

    public function academicPrograms()
    {
        return view('public.academic.programs', [
            'title' => 'Program Studi'
        ]);
    }

    public function academicCalendar()
    {
        return view('public.academic.calendar', [
            'title' => 'Kalender Akademik'
        ]);
    }

    public function news()
    {
        return view('public.news.index', [
            'title' => 'Berita Terkini'
        ]);
    }

    public function newsDetail($slug)
    {
        return view('public.news.show', [
            'title' => 'Detail Berita'
        ]);
    }

    public function announcements()
    {
        return view('public.announcements.index', [
            'title' => 'Pengumuman'
        ]);
    }

    public function agenda()
    {
        return view('public.agenda.index', [
            'title' => 'Agenda Kegiatan'
        ]);
    }

    public function galleryPhotos()
    {
        return view('public.gallery.photos', [
            'title' => 'Galeri Foto'
        ]);
    }

    public function galleryVideos()
    {
        return view('public.gallery.videos', [
            'title' => 'Galeri Video'
        ]);
    }
    public function galleryIndex()
    {
        return view('public.gallery.index', [
            'title' => 'Galeri Video dan Video'
        ]);
    }

    public function downloads()
    {
        return view('public.downloads.index', [
            'title' => 'Download Center'
        ]);
    }

    public function contact()
    {
        return view('public.contact', [
            'title' => 'Kontak Kami'
        ]);
    }
}