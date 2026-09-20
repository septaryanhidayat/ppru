<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function hubungi()
    {
        $page = Post::pages()->where('slug', 'hubungi')->first();

        return view('frontend.hubungi.index', compact('page'));
    }

    public function submitFeedback(Request $request)
    {
        // 1. Honeypot check: If the hidden field is filled, it is an automated spam bot
        if ($request->filled('_hp_security_check')) {
            // Silently pretend success without saving spam into database
            return redirect()->route('hubungi')->with('success', 'Terima kasih! Pesan, kritik, dan saran Anda telah berhasil dikirimkan.');
        }

        // 2. Rate limiting: Max 5 submissions per 5 minutes per IP address
        $ipThrottleKey = 'feedback-submission|'.$request->ip();
        if (RateLimiter::tooManyAttempts($ipThrottleKey, 5)) {
            $seconds = RateLimiter::availableIn($ipThrottleKey);

            return back()->withErrors([
                'saran_kritik' => "Terlalu banyak pengiriman pesan. Silakan tunggu {$seconds} detik sebelum mengirimkan aspirasi kembali.",
            ])->withInput();
        }
        RateLimiter::hit($ipThrottleKey, 300);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
            'whatsapp' => 'nullable|string|max:30',
            'saran_kritik' => 'required|string|max:2000',
        ]);

        // 3. Sanitize inputs to prevent stored XSS or HTML injection
        $cleanName = strip_tags(trim($validated['nama']));
        $cleanEmail = ! empty($validated['email']) ? filter_var(trim($validated['email']), FILTER_SANITIZE_EMAIL) : null;
        $cleanWhatsapp = ! empty($validated['whatsapp']) ? preg_replace('/[^0-9+\-\s]/', '', $validated['whatsapp']) : null;
        $cleanMessage = strip_tags(trim($validated['saran_kritik']));

        Feedback::create([
            'name' => $cleanName,
            'email' => $cleanEmail,
            'whatsapp' => $cleanWhatsapp,
            'message' => $cleanMessage,
            'status' => 'unread',
        ]);

        return redirect()->route('hubungi')->with('success', 'Terima kasih! Pesan dan formulir konsultasi Anda telah berhasil dikirimkan kepada Pondok Pesantren Raudhatul Ulum Sakatiga.');
    }

    public function donasi()
    {
        $page = Post::pages()->where('slug', 'donasi')->first();

        return view('frontend.donasi.index', compact('page'));
    }
}
