<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'deskripsi', 'tanggal', 'waktu', 
        'kategori', 'prioritas', 'lokasi', 'penanggung_jawab'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'waktu' => 'string'
    ];
}