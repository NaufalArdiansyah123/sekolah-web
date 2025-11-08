<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatPkl extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tempat',
        'alamat',
        'kota',
        'kontak',
        'pembimbing_lapangan',
        'kuota',
        'gambar',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'kuota' => 'integer',
    ];

    // Relationships
    public function registrations()
    {
        return $this->hasMany(PklRegistration::class, 'tempat_pkl_id');
    }

    public function approvedRegistrations()
    {
        return $this->registrations()->approved();
    }

    public function getKuotaTersediaAttribute()
    {
        return $this->kuota - $this->approvedRegistrations()->count();
    }
}
