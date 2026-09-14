<?php

namespace App\Http\Controllers;

use App\Models\AnggotaDewan;
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
                ->take(6)
                ->get();
        }

        $otherUnits = UnitPendidikan::active()->where('id', '!=', $unit->id)->orderBy('order', 'asc')->take(6)->get();

        return view('frontend.pendidikan.show', compact('unit', 'teachers', 'otherUnits'));
    }
}
