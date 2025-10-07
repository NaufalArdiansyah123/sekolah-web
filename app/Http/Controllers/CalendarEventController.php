<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'getEvents']);
    }

    /**
     * Display the calendar page
     */
    public function index()
    {
        return view('public.academic.calendar');
    }

    /**
     * Get events for calendar (AJAX)
     */
    public function getEvents(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $events = CalendarEvent::active()
            ->inDateRange($start, $end)
            ->with('creator')
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'start' => $event->is_all_day 
                        ? $event->formatted_start_date 
                        : $event->formatted_start_date . 'T' . $event->start_time,
                    'end' => $event->end_date 
                        ? ($event->is_all_day 
                            ? Carbon::parse($event->end_date)->addDay()->format('Y-m-d')
                            : $event->formatted_end_date . 'T' . $event->end_time)
                        : ($event->is_all_day 
                            ? Carbon::parse($event->start_date)->addDay()->format('Y-m-d')
                            : null),
                    'allDay' => $event->is_all_day,
                    'backgroundColor' => $event->color,
                    'borderColor' => $event->color,
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'category' => $event->category,
                        'location' => $event->location,
                        'creator' => $event->creator ? $event->creator->name : 'System',
                        'status' => $event->status
                    ]
                ];
            });

        return response()->json($events);
    }

    /**
     * Store a new event
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'category' => 'required|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'location' => 'nullable|string|max:255',
            'is_all_day' => 'boolean'
        ]);

        $event = CalendarEvent::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date ?: $request->start_date,
            'start_time' => $request->is_all_day ? null : $request->start_time,
            'end_time' => $request->is_all_day ? null : $request->end_time,
            'category' => $request->category,
            'color' => $request->color,
            'location' => $request->location,
            'is_all_day' => $request->boolean('is_all_day'),
            'created_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil ditambahkan',
            'event' => $event
        ]);
    }

    /**
     * Update an event
     */
    public function update(Request $request, CalendarEvent $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'category' => 'required|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'location' => 'nullable|string|max:255',
            'is_all_day' => 'boolean'
        ]);

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date ?: $request->start_date,
            'start_time' => $request->is_all_day ? null : $request->start_time,
            'end_time' => $request->is_all_day ? null : $request->end_time,
            'category' => $request->category,
            'color' => $request->color,
            'location' => $request->location,
            'is_all_day' => $request->boolean('is_all_day')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil diperbarui',
            'event' => $event
        ]);
    }

    /**
     * Delete an event
     */
    public function destroy(CalendarEvent $event)
    {
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dihapus'
        ]);
    }

    /**
     * Get event details
     */
    public function show(CalendarEvent $event)
    {
        $event->load('creator');
        
        return response()->json([
            'success' => true,
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start_date' => $event->formatted_start_date,
                'end_date' => $event->formatted_end_date,
                'start_time' => $event->formatted_start_time,
                'end_time' => $event->formatted_end_time,
                'category' => $event->category,
                'color' => $event->color,
                'location' => $event->location,
                'is_all_day' => $event->is_all_day,
                'status' => $event->status,
                'creator' => $event->creator ? $event->creator->name : 'System',
                'created_at' => $event->created_at->format('d/m/Y H:i')
            ]
        ]);
    }

    /**
     * Update event dates (for drag & drop)
     */
    public function updateDates(Request $request, CalendarEvent $event)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $event->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date ?: $request->start_date
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tanggal event berhasil diperbarui'
        ]);
    }
}