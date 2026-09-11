<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(15);

        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    public function markAsRead(Feedback $feedback)
    {
        $feedback->update(['status' => 'read']);

        return back()->with('success', 'Status pesan diperbarui menjadi dibaca.');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
