<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;

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

        

        Agenda::create($request->all());

        return redirect()->back()->with('success', 'Agenda berhasil ditambahkan!');
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

}