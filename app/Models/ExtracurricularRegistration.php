<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtracurricularRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'extracurricular_id',
        'student_name',
        'student_class',
        'student_major',
        'student_nis',
        'email',
        'phone',
        'parent_name',
        'parent_phone',
        'address',
        'reason',
        'experience',
        'status',
        'registered_at',
        'approved_at',
        'approved_by',
        'notes'
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Menunggu</span>',
            'approved' => '<span class="badge bg-success">Diterima</span>',
            'rejected' => '<span class="badge bg-danger">Ditolak</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}