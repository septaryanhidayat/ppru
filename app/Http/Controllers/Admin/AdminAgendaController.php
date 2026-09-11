<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agenda;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminAgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::latest('event_date')->paginate(10, ['*'], 'agenda_page');
        $pengumumen = Pengumuman::latest()->paginate(10, ['*'], 'pengumuman_page');

        return view('admin.agenda.index', compact('agendas', 'pengumumen'));
    }

    public function storeAgenda(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed,publish',
        ]);

        $agenda = Agenda::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.time(),
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'content' => $validated['content'] ?? '',
            'status' => $validated['status'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'agenda_create',
            'description' => "Menambahkan Agenda Kegiatan: {$agenda->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', 'Agenda kegiatan berhasil ditambahkan.');
    }

    public function destroyAgenda(Request $request, Agenda $agenda)
    {
        $title = $agenda->title;
        $agenda->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'agenda_delete',
            'description' => "Menghapus Agenda Kegiatan: {$title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return back()->with('success', 'Agenda kegiatan berhasil dihapus.');
    }

    public function storePengumuman(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:publish,draft',
        ]);

        $pengumuman = Pengumuman::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.time(),
            'content' => $validated['content'],
            'status' => $validated['status'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'pengumuman_create',
            'description' => "Menambahkan Pengumuman Resmi: {$pengumuman->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', 'Pengumuman resmi berhasil diterbitkan.');
    }

    public function destroyPengumuman(Request $request, Pengumuman $pengumuman)
    {
        $title = $pengumuman->title;
        $pengumuman->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'pengumuman_delete',
            'description' => "Menghapus Pengumuman: {$title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
