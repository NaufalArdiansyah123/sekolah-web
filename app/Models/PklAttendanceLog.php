<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PklAttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'pkl_registration_id',
        'student_id',
        'qr_code',
        'scan_date',
        'scan_time',
        'ip_address',
        'user_agent',
        'status',
        'log_activity',
        'check_out_time',
        'check_out_user_agent',
        'check_out_ip_address',
    ];

    protected $casts = [
        'scan_date' => 'datetime',
        'scan_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];

    // Relationships
    public function pklRegistration()
    {
        return $this->belongsTo(PklRegistration::class, 'pkl_registration_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tempatPkl()
    {
        return $this->hasOneThrough(TempatPkl::class, PklRegistration::class, 'id', 'id', 'pkl_registration_id', 'tempat_pkl_id');
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('scan_date', today());
    }

    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeByPklRegistration($query, $registrationId)
    {
        return $query->where('pkl_registration_id', $registrationId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('scan_date', [$startDate, $endDate]);
    }

    // Helper methods
    public function getScanDateTimeAttribute()
    {
        if ($this->scan_date && $this->scan_time) {
            return $this->scan_date->format('Y-m-d') . ' ' . $this->scan_time->format('H:i:s');
        }
        return null;
    }

    public function getFormattedScanTimeAttribute()
    {
        return $this->scan_time ? $this->scan_time->format('H:i') : '-';
    }

    public function getFormattedScanDateAttribute()
    {
        return $this->scan_date ? $this->scan_date->format('d/m/Y') : '-';
    }

    public function getLocationDisplayAttribute()
    {
        return $this->location ?: 'Tidak diketahui';
    }

    public function getIpAddressDisplayAttribute()
    {
        return $this->ip_address ?: 'Tidak diketahui';
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha',
            default => 'Tidak Diketahui'
        };
    }

    // Check-out helper methods
    public function getFormattedCheckOutTimeAttribute()
    {
        return $this->check_out_time ? $this->check_out_time->format('H:i') : '-';
    }

    public function getCheckOutLocationDisplayAttribute()
    {
        return $this->check_out_location ?: 'Tidak diketahui';
    }

    public function getCheckOutIpAddressDisplayAttribute()
    {
        return $this->check_out_ip_address ?: 'Tidak diketahui';
    }

    public function getCheckOutDateTimeAttribute()
    {
        return $this->check_out_time ? $this->check_out_time->format('Y-m-d H:i:s') : null;
    }

    public function hasCheckedOut()
    {
        return !is_null($this->check_out_time);
    }

    public function getDurationAttribute()
    {
        if ($this->scan_time && $this->check_out_time) {
            $start = $this->scan_time;
            $end = $this->check_out_time;
            $diff = $start->diff($end);

            return $diff->format('%h jam %i menit');
        }
        return null;
    }
}
