<?php

namespace App\Http\Controllers;

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
        $otherUnits = UnitPendidikan::active()->where('id', '!=', $unit->id)->orderBy('order', 'asc')->take(6)->get();

        return view('frontend.pendidikan.show', compact('unit', 'otherUnits'));
    }
}
