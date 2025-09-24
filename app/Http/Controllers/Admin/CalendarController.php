<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CalendarController extends Controller
{
    public function index()
    {
        try {
            // Check if calendar_events table exists
            if (!\Schema::hasTable('calendar_events')) {
                return view('admin.calendar.index', [
                    'stats' => [
                        'total_events' => 0,
                        'upcoming_events' => 0,
                        'past_events' => 0,
                        'this_month_events' => 0
                    ],
                    'table_missing' => true
                ]);
            }

            // Get statistics
            $stats = [
                'total_events' => CalendarEvent::count(),
                'upcoming_events' => CalendarEvent::where('start_date', '>=', now())->count(),
                'past_events' => CalendarEvent::where('start_date', '<', now())->count(),
                'this_month_events' => CalendarEvent::whereBetween('start_date', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ])->count()
            ];

            return view('admin.calendar.index', compact('stats'));
        } catch (\Exception $e) {
            Log::error('Error loading calendar page: ' . $e->getMessage());
            return view('admin.calendar.index', [
                'stats' => [
                    'total_events' => 0,
                    'upcoming_events' => 0,
                    'past_events' => 0,
                    'this_month_events' => 0
                ],
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getEvents(Request $request)
    {
        try {
            $start = $request->get('start');
            $end = $request->get('end');
            
            $events = CalendarEvent::whereBetween('start_date', [$start, $end])
                                 ->get()
                                 ->map(function($event) {
                                     return [
                                         'id' => 'event_' . $event->id,
                                         'title' => $event->title,
                                         'start' => $event->start_date->toISOString(),
                                         'end' => $event->end_date ? $event->end_date->toISOString() : null,
                                         'color' => $event->color ?? '#3b82f6',
                                         'description' => $event->description,
                                         'type' => $event->type ?? 'event',
                                         'extendedProps' => [
                                             'event_id' => $event->id,
                                             'type' => $event->type,
                                             'location' => $event->location,
                                             'source' => $event->source_type
                                         ]
                                     ];
                                 });
            
            return response()->json($events);
        } catch (\Exception $e) {
            Log::error('Error fetching calendar events: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    public function storeEvent(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i',
                'type' => 'required|in:event,agenda,meeting,holiday,exam'
            ]);

            DB::beginTransaction();

            // Handle datetime combination
            $startDateTime = $request->start_date;
            $endDateTime = $request->end_date ?? $request->start_date;
            
            // If not all day and time is provided, combine date and time
            if (!$request->is_all_day && $request->start_time) {
                $startDateTime = $request->start_date . ' ' . $request->start_time;
            }
            
            if (!$request->is_all_day && $request->end_time && $request->end_date) {
                $endDateTime = $request->end_date . ' ' . $request->end_time;
            } elseif (!$request->is_all_day && $request->end_time) {
                $endDateTime = $request->start_date . ' ' . $request->end_time;
            }

            // Create calendar event
            $event = CalendarEvent::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $startDateTime,
                'end_date' => $endDateTime,
                'start_time' => $request->is_all_day ? null : $request->start_time,
                'end_time' => $request->is_all_day ? null : $request->end_time,
                'is_all_day' => $request->is_all_day ? true : false,
                'color' => $request->color ?? '#3b82f6',
                'type' => $request->type,
                'location' => $request->location,
                'created_by' => Auth::id(),
                'source_type' => 'calendar'
            ]);

            // If type is agenda, also create agenda entry
            if ($request->type === 'agenda') {
                Agenda::create([
                    'title' => $request->title,
                    'content' => $request->description ?? '',
                    'event_date' => $startDateTime,
                    'location' => $request->location,
                    'status' => 'published',
                    'created_by' => Auth::id(),
                    'calendar_event_id' => $event->id
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Event berhasil ditambahkan' . ($request->type === 'agenda' ? ' dan agenda telah dibuat' : ''),
                'event' => [
                    'id' => 'event_' . $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date->toISOString(),
                    'end' => $event->end_date->toISOString(),
                    'color' => $event->color
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating calendar event: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan event'
            ], 500);
        }
    }

    public function updateEvent(Request $request, $id)
    {
        try {
            $event = CalendarEvent::findOrFail($id);
            
            $request->validate([
                'title' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i',
                'type' => 'required|in:event,agenda,meeting,holiday,exam'
            ]);

            DB::beginTransaction();

            $oldType = $event->type;
            
            // Handle datetime combination
            $startDateTime = $request->start_date;
            $endDateTime = $request->end_date ?? $request->start_date;
            
            // If not all day and time is provided, combine date and time
            if (!$request->is_all_day && $request->start_time) {
                $startDateTime = $request->start_date . ' ' . $request->start_time;
            }
            
            if (!$request->is_all_day && $request->end_time && $request->end_date) {
                $endDateTime = $request->end_date . ' ' . $request->end_time;
            } elseif (!$request->is_all_day && $request->end_time) {
                $endDateTime = $request->start_date . ' ' . $request->end_time;
            }
            
            // Update calendar event
            $event->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $startDateTime,
                'end_date' => $endDateTime,
                'start_time' => $request->is_all_day ? null : $request->start_time,
                'end_time' => $request->is_all_day ? null : $request->end_time,
                'is_all_day' => $request->is_all_day ? true : false,
                'color' => $request->color ?? $event->color,
                'type' => $request->type,
                'location' => $request->location
            ]);

            // Handle agenda synchronization
            if ($oldType === 'agenda' && $request->type !== 'agenda') {
                // Remove agenda if type changed from agenda
                Agenda::where('calendar_event_id', $event->id)->delete();
            } elseif ($request->type === 'agenda') {
                // Update or create agenda
                $agenda = Agenda::where('calendar_event_id', $event->id)->first();
                if ($agenda) {
                    $agenda->update([
                        'title' => $request->title,
                        'content' => $request->description ?? '',
                        'event_date' => $startDateTime,
                        'location' => $request->location
                    ]);
                } else {
                    Agenda::create([
                        'title' => $request->title,
                        'content' => $request->description ?? '',
                        'event_date' => $startDateTime,
                        'location' => $request->location,
                        'status' => 'published',
                        'created_by' => Auth::id(),
                        'calendar_event_id' => $event->id
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Event berhasil diupdate' . ($request->type === 'agenda' ? ' dan agenda telah disinkronkan' : '')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating calendar event: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate event'
            ], 500);
        }
    }

    public function deleteEvent($id)
    {
        try {
            $event = CalendarEvent::findOrFail($id);
            
            DB::beginTransaction();

            // Delete related agenda if exists
            if ($event->type === 'agenda') {
                Agenda::where('calendar_event_id', $event->id)->delete();
            }

            $event->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Event berhasil dihapus' . ($event->type === 'agenda' ? ' dan agenda telah dihapus' : '')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting calendar event: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus event'
            ], 500);
        }
    }

    public function getEvent($id)
    {
        try {
            $event = CalendarEvent::findOrFail($id);

            return response()->json([
                'success' => true,
                'event' => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'start_date' => $event->start_date->format('Y-m-d'),
                    'end_date' => $event->end_date ? $event->end_date->format('Y-m-d') : null,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'is_all_day' => $event->is_all_day,
                    'color' => $event->color,
                    'type' => $event->type,
                    'location' => $event->location
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting calendar event: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Event tidak ditemukan'
            ], 404);
        }
    }

    public function syncFromAgenda()
    {
        try {
            DB::beginTransaction();

            $syncedCount = 0;

            // Sync from Posts table (agenda type)
            $postAgendas = \App\Models\Post::where('type', 'agenda')
                                          ->where('status', 'published')
                                          ->get();

            foreach ($postAgendas as $agenda) {
                $existingEvent = CalendarEvent::where('source_type', 'post_agenda')
                                             ->where('source_id', $agenda->id)
                                             ->first();
                
                if (!$existingEvent) {
                    CalendarEvent::create([
                        'title' => $agenda->title,
                        'description' => $agenda->content,
                        'start_date' => $agenda->event_date,
                        'end_date' => $agenda->event_date,
                        'color' => '#10b981', // Green for agenda
                        'type' => 'agenda',
                        'location' => $agenda->location,
                        'created_by' => $agenda->user_id,
                        'source_type' => 'post_agenda',
                        'source_id' => $agenda->id
                    ]);
                    $syncedCount++;
                }
            }

            // Sync from Agendas table (legacy)
            $legacyAgendas = Agenda::all();

            foreach ($legacyAgendas as $agenda) {
                $existingEvent = CalendarEvent::where('source_type', 'agenda')
                                             ->where('source_id', $agenda->id)
                                             ->first();
                
                if (!$existingEvent) {
                    $startDate = \Carbon\Carbon::parse($agenda->tanggal);
                    
                    // If time is provided, combine with date
                    if ($agenda->waktu) {
                        try {
                            $time = \Carbon\Carbon::parse($agenda->waktu);
                            $startDate->setTime($time->hour, $time->minute);
                        } catch (\Exception $e) {
                            // If time parsing fails, use date only
                        }
                    }

                    CalendarEvent::create([
                        'title' => $agenda->judul,
                        'description' => $agenda->deskripsi ?? '',
                        'start_date' => $startDate,
                        'end_date' => $startDate,
                        'color' => '#10b981', // Green for agenda
                        'type' => 'agenda',
                        'location' => $agenda->lokasi,
                        'created_by' => auth()->id(),
                        'source_type' => 'agenda',
                        'source_id' => $agenda->id
                    ]);
                    $syncedCount++;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil sinkronisasi {$syncedCount} agenda ke kalender"
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error syncing agenda to calendar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal sinkronisasi agenda: ' . $e->getMessage()
            ], 500);
        }
    }
}