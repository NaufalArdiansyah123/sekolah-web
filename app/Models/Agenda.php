<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content', 
        'event_date',
        'location',
        'status',
        'created_by',
        'calendar_event_id',
        // Legacy fields for backward compatibility
        'judul', 'deskripsi', 'tanggal', 'waktu', 
        'kategori', 'prioritas', 'penanggung_jawab'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'tanggal' => 'datetime',
        'waktu' => 'string'
    ];

    /**
     * Get the calendar event associated with this agenda
     */
    public function calendarEvent(): BelongsTo
    {
        return $this->belongsTo(CalendarEvent::class);
    }

    /**
     * Get the user who created this agenda
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for published agendas
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for upcoming agendas
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now());
    }

    /**
     * Get the calendar event associated with this agenda (using legacy fields)
     */
    public function calendarEventLegacy()
    {
        return CalendarEvent::where('source_type', 'agenda')
                           ->where('source_id', $this->id)
                           ->first();
    }

    /**
     * Sync this agenda to calendar
     */
    public function syncToCalendar()
    {
        try {
            // Check if already synced
            $existingEvent = $this->calendarEventLegacy();
            
            $startDate = \Carbon\Carbon::parse($this->tanggal ?? $this->event_date);
            
            // If time is provided, combine with date
            if ($this->waktu) {
                try {
                    $time = \Carbon\Carbon::parse($this->waktu);
                    $startDate->setTime($time->hour, $time->minute);
                } catch (\Exception $e) {
                    // If time parsing fails, use date only
                }
            }

            $eventData = [
                'title' => $this->judul ?? $this->title,
                'description' => $this->deskripsi ?? $this->content ?? '',
                'start_date' => $startDate,
                'end_date' => $startDate,
                'color' => '#10b981', // Green for agenda
                'type' => 'agenda',
                'location' => $this->lokasi ?? $this->location,
                'created_by' => auth()->id(),
                'source_type' => 'agenda',
                'source_id' => $this->id
            ];

            if ($existingEvent) {
                $existingEvent->update($eventData);
            } else {
                CalendarEvent::create($eventData);
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Error syncing agenda to calendar: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove from calendar
     */
    public function removeFromCalendar()
    {
        try {
            CalendarEvent::where('source_type', 'agenda')
                        ->where('source_id', $this->id)
                        ->delete();
            return true;
        } catch (\Exception $e) {
            \Log::error('Error removing agenda from calendar: ' . $e->getMessage());
            return false;
        }
    }
}