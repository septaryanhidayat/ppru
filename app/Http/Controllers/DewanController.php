<?php

namespace App\Http\Controllers;

use App\Models\AnggotaDewan;

class DewanController extends Controller
{
    public function index()
    {
        $dewan = AnggotaDewan::orderBy('order', 'asc')->get();

        return view('frontend.dewan.index', compact('dewan'));
    }
}
