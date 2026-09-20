<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(15);

        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    public function markAsRead(Request $request, Feedback $feedback)
    {
        $feedback->update(['status' => 'read']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Administrator',
            'action' => 'feedback_read',
            'description' => "Menandai pesan aspirasi/masukan dari {$feedback->name} sebagai telah dibaca",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', 'Status pesan diperbarui menjadi dibaca.');
    }

    public function destroy(Request $request, Feedback $feedback)
    {
        $senderName = $feedback->name;
        $feedback->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Administrator',
            'action' => 'feedback_delete',
            'description' => "Menghapus pesan aspirasi/masukan dari {$senderName}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
