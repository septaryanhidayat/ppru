<?php

namespace App\Http\Controllers;

use App\Models\Bidang;

class BidangController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::orderBy('order', 'asc')->get();

        return view('frontend.bidang.index', compact('bidangs'));
    }

    public function show(string $slug)
    {
        $bidang = Bidang::where('slug', $slug)->firstOrFail();
        $otherBidangs = Bidang::where('id', '!=', $bidang->id)->take(5)->get();

        return view('frontend.bidang.show', compact('bidang', 'otherBidangs'));
    }
}
