<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'color',
        'type',
        'created_by',
        'is_all_day',
        'all_day',
        'status',
        'source_type',
        'source_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_all_day' => 'boolean'
    ];

    protected $attributes = [
        'status' => 'active',
        'is_all_day' => true,
        'color' => '#3b82f6'
    ];

    /**
     * Get the user who created this event
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for active events
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for events in date range
     */
    public function scopeInDateRange($query, $start, $end)
    {
        return $query->where(function($q) use ($start, $end) {
            $q->whereBetween('start_date', [$start, $end])
              ->orWhereBetween('end_date', [$start, $end])
              ->orWhere(function($q2) use ($start, $end) {
                  $q2->where('start_date', '<=', $start)
                     ->where('end_date', '>=', $end);
              });
        });
    }

    /**
     * Get formatted start date
     */
    public function getFormattedStartDateAttribute()
    {
        return $this->start_date->format('d/m/Y');
    }

    /**
     * Get formatted end date
     */
    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('d/m/Y') : null;
    }

    /**
     * Get formatted start time
     */
    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time ? Carbon::parse($this->start_time)->format('H:i') : null;
    }

    /**
     * Get formatted end time
     */
    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? Carbon::parse($this->end_time)->format('H:i') : null;
    }

    /**
     * Check if event is multi-day
     */
    public function getIsMultiDayAttribute()
    {
        if (!$this->end_date) return false;
        return $this->start_date->toDateString() !== $this->end_date->toDateString();
    }

    /**
     * Get event duration in days
     */
    public function getDurationInDaysAttribute()
    {
        if (!$this->end_date) return 1;
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Check if event is today
     */
    public function getIsTodayAttribute()
    {
        $today = Carbon::today();
        return $this->start_date->toDateString() <= $today->toDateString() &&
               ($this->end_date ? $this->end_date->toDateString() >= $today->toDateString() : 
                $this->start_date->toDateString() === $today->toDateString());
    }

    /**
     * Check if event is upcoming
     */
    public function getIsUpcomingAttribute()
    {
        return $this->start_date->isFuture();
    }

    /**
     * Check if event is past
     */
    public function getIsPastAttribute()
    {
        $endDate = $this->end_date ?: $this->start_date;
        return $endDate->isPast();
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->is_today) {
            return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
        } elseif ($this->is_upcoming) {
            return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
        } else {
            return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
        }
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        if ($this->is_today) {
            return 'Hari Ini';
        } elseif ($this->is_upcoming) {
            return 'Akan Datang';
        } else {
            return 'Selesai';
        }
    }

    /**
     * Get full datetime for start
     */
    public function getStartDateTimeAttribute()
    {
        if ($this->is_all_day || !$this->start_time) {
            return $this->start_date;
        }
        
        return Carbon::parse($this->start_date->toDateString() . ' ' . $this->start_time);
    }

    /**
     * Get full datetime for end
     */
    public function getEndDateTimeAttribute()
    {
        $endDate = $this->end_date ?: $this->start_date;
        
        if ($this->is_all_day || !$this->end_time) {
            return $endDate;
        }
        
        return Carbon::parse($endDate->toDateString() . ' ' . $this->end_time);
    }
}