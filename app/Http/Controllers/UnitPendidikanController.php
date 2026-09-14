<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\UnitPendidikan;

class UnitPendidikanController extends Controller
{
    public function index()
    {
        $units = UnitPendidikan::active()->orderBy('order', 'asc')->get();

        return view('frontend.pendidikan.index', compact('units'));
    }

    public function show(string $slug)
    {
        $unit = UnitPendidikan::where('slug', $slug)->firstOrFail();

        $teachers = AnggotaDewan::where('fraction', $unit->short_name)
            ->orWhere('fraction', $unit->name)
            ->orderBy('order', 'asc')
            ->get();

        if ($teachers->isEmpty()) {
            $teachers = AnggotaDewan::whereNotIn('fraction', ['Yayasan', 'Pimpinan Pesantren'])
                ->orderBy('order', 'asc')
                ->take(8)
                ->get();
        }

        $otherUnits = UnitPendidikan::active()->where('id', '!=', $unit->id)->orderBy('order', 'asc')->get();

        // Unit-specific or latest authentic pesantren agendas
        $agendas = Agenda::orderBy('event_date', 'desc')->take(3)->get();

        // Unit-specific or latest authentic pesantren announcements
        $pengumumen = Pengumuman::orderBy('created_at', 'desc')->take(3)->get();

        // Unit-specific or latest achievements
        $prestasi = Post::whereHas('categories', function ($q) {
            $q->where('slug', 'prestasi');
        })->latest()->take(4)->get();

        if ($prestasi->isEmpty()) {
            $prestasi = Post::latest()->take(4)->get();
        }

        return view('frontend.pendidikan.show', compact('unit', 'teachers', 'otherUnits', 'agendas', 'pengumumen', 'prestasi'));
    }
}
