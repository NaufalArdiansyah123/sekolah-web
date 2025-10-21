<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use App\Models\Setting;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'qr_code',
        'status',
        'scan_time',
        'attendance_date',
        'location',
        'notes',
        'confirmed_by',
        'confirmed_at',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
        'attendance_date' => 'date',
        'confirmed_at' => 'datetime',
    ];

    /**
     * Relasi ke Student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi ke QR Attendance
     */
    public function qrAttendance(): BelongsTo
    {
        return $this->belongsTo(QrAttendance::class, 'qr_code', 'qr_code');
    }

    /**
     * Relasi ke User yang mengkonfirmasi
     */
    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('attendance_date', $date);
    }

    /**
     * Scope untuk filter berdasarkan bulan
     */
    public function scopeByMonth($query, $month, $year = null)
    {
        $year = $year ?? date('Y');
        return $query->whereMonth('attendance_date', $month)
                    ->whereYear('attendance_date', $year);
    }

    /**
     * Get attendance settings with caching
     */
    public static function getAttendanceSettings(): array
    {
        static $settings = null;
        
        if ($settings === null) {
            $settings = [
                'start_time' => Setting::get('attendance_start_time', '07:00'),
                'end_time' => Setting::get('attendance_end_time', '07:30'),
                'late_tolerance' => (int) Setting::get('late_tolerance_minutes', 15),
                'absent_threshold' => (int) Setting::get('absent_threshold_minutes', 30),
            ];
        }
        
        return $settings;
    }
    
    /**
     * Clear static settings cache
     */
    public static function clearSettingsCache(): void
    {
        // Reset static variable to force reload from database
        $reflection = new \ReflectionClass(static::class);
        $property = $reflection->getProperty('settings');
        $property->setAccessible(true);
        $property->setValue(null, null);
        
        \Log::info('AttendanceLog settings cache cleared');
    }
    
    /**
     * Determine status berdasarkan waktu scan
     */
    public static function determineStatus($scanTime): string
    {
        try {
            $scanTime = Carbon::parse($scanTime);
            $scanHour = $scanTime->format('H:i');
            
            // Get attendance settings
            $settings = self::getAttendanceSettings();
            
            // Validate settings
            if (!$settings['start_time'] || !$settings['end_time']) {
                \Log::warning('Attendance settings not configured, using defaults');
                return self::determineStatusWithDefaults($scanHour);
            }
            
            // Create time objects for today to ensure proper comparison
            $today = Carbon::today();
            $startTime = $today->copy()->setTimeFromTimeString($settings['start_time']);
            $endTime = $today->copy()->setTimeFromTimeString($settings['end_time']);
            $scanTimeObj = $today->copy()->setTimeFromTimeString($scanHour);
            
            // Calculate boundaries
            $lateEndTime = $endTime->copy()->addMinutes($settings['late_tolerance']);
            $absentTime = $endTime->copy()->addMinutes($settings['absent_threshold']);
            
            \Log::info('Attendance Status Calculation:', [
                'scan_time' => $scanHour,
                'settings' => $settings,
                'boundaries' => [
                    'start' => $startTime->format('H:i'),
                    'end' => $endTime->format('H:i'),
                    'late_end' => $lateEndTime->format('H:i'),
                    'absent_start' => $absentTime->format('H:i')
                ]
            ]);
            
            // Determine status based on time ranges
            if ($scanTimeObj->between($startTime, $endTime)) {
                \Log::info('Status: HADIR - Within attendance window');
                return 'hadir';
            } elseif ($scanTimeObj->between($endTime->copy()->addSecond(), $lateEndTime)) {
                \Log::info('Status: TERLAMBAT - Within late tolerance');
                return 'terlambat';
            } else {
                \Log::info('Status: ALPHA - Beyond late tolerance');
                return 'alpha';
            }
            
        } catch (\Exception $e) {
            \Log::error('Error determining attendance status:', [
                'error' => $e->getMessage(),
                'scan_time' => $scanTime,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Fallback to default logic
            return self::determineStatusWithDefaults($scanTime);
        }
    }
    
    /**
     * Fallback method with default time rules
     */
    private static function determineStatusWithDefaults($scanTime): string
    {
        $scanHour = Carbon::parse($scanTime)->format('H:i');
        
        \Log::info('Using default attendance rules for status determination', [
            'scan_time' => $scanHour
        ]);
        
        if ($scanHour <= '07:30') {
            return 'hadir';
        } elseif ($scanHour <= '08:00') {
            return 'terlambat';
        } else {
            return 'alpha';
        }
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'hadir' => 'success',
            'terlambat' => 'warning',
            'izin' => 'info',
            'sakit' => 'secondary',
            'alpha' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha',
            default => 'Unknown'
        };
    }
    
    /**
     * Get current attendance time boundaries for display
     */
    public static function getAttendanceTimeBoundaries(): array
    {
        $settings = self::getAttendanceSettings();
        
        $today = Carbon::today();
        $startTime = $today->copy()->setTimeFromTimeString($settings['start_time']);
        $endTime = $today->copy()->setTimeFromTimeString($settings['end_time']);
        $lateEndTime = $endTime->copy()->addMinutes($settings['late_tolerance']);
        $absentTime = $endTime->copy()->addMinutes($settings['absent_threshold']);
        
        return [
            'on_time' => [
                'start' => $startTime->format('H:i'),
                'end' => $endTime->format('H:i'),
                'label' => 'Tepat Waktu'
            ],
            'late' => [
                'start' => $endTime->copy()->addMinute()->format('H:i'),
                'end' => $lateEndTime->format('H:i'),
                'label' => 'Terlambat (Masih Ditoleransi)'
            ],
            'absent' => [
                'start' => $lateEndTime->copy()->addMinute()->format('H:i'),
                'label' => 'Alpha (Terlalu Terlambat)'
            ],
            'settings' => $settings
        ];
    }
}