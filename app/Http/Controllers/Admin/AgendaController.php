<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Post;
use App\Models\CalendarEvent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function create()
    {
        $latestAgendas = Agenda::latest()->take(5)->get();
        return view('admin.agenda.tambah-agenda', compact('latestAgendas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'waktu' => 'nullable',
            'kategori' => 'nullable|string',
            'prioritas' => 'required|in:low,medium,high',
            'lokasi' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Create agenda
            $agenda = Agenda::create($request->all());

            // Auto-sync to calendar akademik
            $startDate = Carbon::parse($request->tanggal);
            
            // If time is provided, combine with date
            if ($request->waktu) {
                try {
                    $time = Carbon::parse($request->waktu);
                    $startDate->setTime($time->hour, $time->minute);
                } catch (\Exception $e) {
                    // If time parsing fails, use date only
                    Log::warning('Failed to parse time: ' . $request->waktu);
                }
            }

            // Create calendar event
            CalendarEvent::create([
                'title' => $request->judul,
                'description' => $request->deskripsi ?? '',
                'start_date' => $startDate,
                'end_date' => $startDate,
                'color' => '#10b981', // Green for agenda
                'type' => 'agenda',
                'location' => $request->lokasi,
                'created_by' => auth()->id(),
                'source_type' => 'agenda',
                'source_id' => $agenda->id
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Agenda berhasil ditambahkan dan telah masuk ke kalender akademik!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating agenda: ' . $e->getMessage());
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Terjadi kesalahan saat menyimpan agenda.');
        }
    }

// Show Detail Agenda
public function showAgenda($id)
{
    $agenda = Post::where('type', 'agenda')->findOrFail($id);
    return view('admin.posts.agenda.show', compact('agenda'));
}

// Form Edit Agenda  
public function editAgenda($id)
{
    $agenda = Post::where('type', 'agenda')->findOrFail($id);
    return view('admin.posts.agenda.edit', compact('agenda'));
}

// Update Agenda
public function updateAgenda(Request $request, $id)
{
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'event_date' => 'required|date',
        'location' => 'nullable|max:255',
        'organizer' => 'nullable|max:255',
    ]);

    $agenda = Post::where('type', 'agenda')->findOrFail($id);
    
    $agenda->update([
        'title' => $request->title,
        'slug' => Str::slug($request->title),
        'content' => $request->content,
        'event_date' => $request->event_date,
        'event_time' => $request->event_time,
        'location' => $request->location,
        'organizer' => $request->organizer,
    ]);

    return redirect()->route('admin.posts.agenda.show', $agenda->id)
                    ->with('success', 'Agenda berhasil diperbarui!');
}

// Delete Agenda
public function destroyAgenda($id)
{
    $agenda = Post::where('type', 'agenda')->findOrFail($id);
    $agenda->delete();

    return redirect()->route('admin.posts.agenda.index')
                    ->with('success', 'Agenda berhasil dihapus!');
}

public function index()
{
    $agendas = Agenda::latest()->get();
    return view('admin.posts.agenda.index', compact('agendas'));
}

/**
 * Update agenda and sync to calendar
 */
public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'deskripsi' => 'nullable|string',
        'waktu' => 'nullable',
        'kategori' => 'nullable|string',
        'prioritas' => 'required|in:low,medium,high',
        'lokasi' => 'nullable|string|max:255',
        'penanggung_jawab' => 'nullable|string|max:255',
    ]);

    try {
        DB::beginTransaction();

        $agenda = Agenda::findOrFail($id);
        $agenda->update($request->all());

        // Sync to calendar
        $agenda->syncToCalendar();

        DB::commit();

        return redirect()->back()->with('success', 'Agenda berhasil diperbarui dan kalender akademik telah disinkronkan!');

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error updating agenda: ' . $e->getMessage());
        return redirect()->back()
                        ->withInput()
                        ->with('error', 'Terjadi kesalahan saat memperbarui agenda.');
    }
}

/**
 * Delete agenda and remove from calendar
 */
public function destroy($id)
{
    try {
        DB::beginTransaction();

        $agenda = Agenda::findOrFail($id);
        
        // Remove from calendar first
        $agenda->removeFromCalendar();
        
        // Delete agenda
        $agenda->delete();

        DB::commit();

        return redirect()->back()->with('success', 'Agenda berhasil dihapus dan telah dihapus dari kalender akademik!');

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error deleting agenda: ' . $e->getMessage());
        return redirect()->back()
                        ->with('error', 'Terjadi kesalahan saat menghapus agenda.');
    }
}

/**
 * Sync all existing agendas to calendar
 */
public function syncAllToCalendar()
{
    try {
        $agendas = Agenda::all();
        $syncedCount = 0;

        foreach ($agendas as $agenda) {
            if ($agenda->syncToCalendar()) {
                $syncedCount++;
            }
        }

        return redirect()->back()->with('success', "Berhasil sinkronisasi {$syncedCount} agenda ke kalender akademik!");

    } catch (\Exception $e) {
        Log::error('Error syncing all agendas: ' . $e->getMessage());
        return redirect()->back()
                        ->with('error', 'Terjadi kesalahan saat sinkronisasi agenda.');
    }
}

}