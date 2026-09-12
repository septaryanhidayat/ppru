<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Agenda;
use App\Models\Feedback;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InformationController extends Controller
{
    public function agenda()
    {
        $agendas = Agenda::where('status', 'publish')
            ->orderBy('event_date', 'desc')
            ->paginate(8);

        return view('frontend.agenda.index', compact('agendas'));
    }

    public function agendaShow(string $slug)
    {
        $agenda = Agenda::where('slug', $slug)->firstOrFail();
        $otherAgendas = Agenda::where('id', '!=', $agenda->id)
            ->where('status', 'publish')
            ->orderBy('event_date', 'desc')
            ->take(4)
            ->get();

        return view('frontend.agenda.show', compact('agenda', 'otherAgendas'));
    }

    public function pengumuman()
    {
        $pengumuman = Pengumuman::where('status', 'publish')
            ->latest()
            ->paginate(8);

        return view('frontend.pengumuman.index', compact('pengumuman'));
    }

    public function pengumumanShow(string $slug)
    {
        $announcement = Pengumuman::where('slug', $slug)->firstOrFail();
        $otherAnnouncements = Pengumuman::where('id', '!=', $announcement->id)
            ->where('status', 'publish')
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.pengumuman.show', compact('announcement', 'otherAnnouncements'));
    }

    public function testimonial()
    {
        $testimonials = Testimonial::where('status', 'publish')->get();

        return view('frontend.testimonial.index', compact('testimonials'));
    }

    public function video()
    {
        $videos = Video::latest()->paginate(9);

        return view('frontend.video.index', compact('videos'));
    }

    public function galeri()
    {
        $page = Post::pages()->where('slug', 'galeri')->first();

        // Ambil semua foto galeri yang diunggah dan foto berita
        $galleryImages = Post::whereIn('type', ['gallery', 'attachment', 'post'])
            ->where('status', 'publish')
            ->whereNotNull('featured_image')
            ->where('featured_image', '!=', '')
            ->orderByRaw("CASE WHEN type = 'gallery' THEN 0 WHEN type = 'attachment' THEN 1 ELSE 2 END")
            ->latest('created_at')
            ->paginate(24);

        return view('frontend.galeri.index', compact('page', 'galleryImages'));
    }

    public function prestasi()
    {
        $prestasi = Post::where('type', 'prestasi')
            ->where('status', 'publish')
            ->latest('published_at')
            ->paginate(9);

        return view('frontend.prestasi.index', compact('prestasi'));
    }

    public function prestasiShow(string $slug)
    {
        $item = Post::where('type', 'prestasi')
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Post::where('type', 'prestasi')
            ->where('id', '!=', $item->id)
            ->where('status', 'publish')
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('frontend.prestasi.show', compact('item', 'related'));
    }

    public function ekskul()
    {
        $ekskul = Post::where('type', 'ekskul')
            ->where('status', 'publish')
            ->latest('created_at')
            ->get();

        return view('frontend.ekskul.index', compact('ekskul'));
    }

    public function alumni()
    {
        $alumni = Post::where('type', 'alumni')
            ->where('status', 'publish')
            ->latest('created_at')
            ->paginate(16);

        return view('frontend.alumni.index', compact('alumni'));
    }

    public function layanan()
    {
        $page = Post::pages()->whereIn('slug', ['layanan-terpadu-2', 'layanan-terpadu'])->first();

        return view('frontend.layanan.index', compact('page'));
    }

    public function layananTerpadu()
    {
        return $this->layanan();
    }

    public function izinSekolah()
    {
        $page = Post::pages()->where('slug', 'izin-sekolah')->first();

        return view('frontend.layanan.izin', compact('page'));
    }

    public function submitIzin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'agency' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:30',
            'purpose' => 'required|string',
            'letter_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:5120',
            'ktp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        $safeExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp'];

        $letterPath = null;
        if ($request->hasFile('letter_file')) {
            $file = $request->file('letter_file');
            $ext = strtolower($file->guessExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            if (! in_array($ext, $safeExtensions, true)) {
                $ext = 'pdf';
            }
            $filename = 'surat_izin_'.time().'_'.Str::random(12).'.'.$ext;
            $file->move(public_path('uploads/layanan'), $filename);
            $letterPath = '/uploads/layanan/'.$filename;
        }

        $ktpPath = null;
        if ($request->hasFile('ktp_file')) {
            $file = $request->file('ktp_file');
            $ext = strtolower($file->guessExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            if (! in_array($ext, $safeExtensions, true)) {
                $ext = 'pdf';
            }
            $filename = 'ktp_izin_'.time().'_'.Str::random(12).'.'.$ext;
            $file->move(public_path('uploads/layanan'), $filename);
            $ktpPath = '/uploads/layanan/'.$filename;
        }

        $messageContent = "PERMOHONAN IZIN KUNJUNGAN KE SEKOLAH\n".
            "Nama: {$validated['name']}\n".
            "Instansi: {$validated['agency']}\n".
            "WhatsApp: {$validated['whatsapp']}\n".
            "Keperluan: {$validated['purpose']}\n".
            ($letterPath ? "Surat: {$letterPath}\n" : '').
            ($ktpPath ? "KTP: {$ktpPath}\n" : '');

        Feedback::create([
            'name' => $validated['name'],
            'email' => $validated['whatsapp'].'@wa.layanan',
            'whatsapp' => $validated['whatsapp'],
            'message' => $messageContent,
            'status' => 'unread',
        ]);

        ActivityLog::create([
            'user_id' => null,
            'user_name' => $validated['name'].' ('.$validated['agency'].')',
            'action' => 'layanan_izin',
            'description' => "Permohonan Izin Kunjungan dari {$validated['name']} ({$validated['agency']})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        $waText = urlencode("Assalamu'alaikum Humas SMA IT Ishlahul Ummah Prabumulih,\n\nSaya telah mengajukan Permohonan Izin Kunjungan ke Sekolah:\n- Nama: {$validated['name']}\n- Instansi: {$validated['agency']}\n- Keperluan: {$validated['purpose']}\n\nMohon konfirmasi dan tindak lanjutnya. Terima kasih.");
        $waUrl = "https://wa.me/6282182680647?text={$waText}";

        return redirect()->route('layanan.izin')->with('success', 'Permohonan izin kunjungan Anda berhasil dikirim! Silakan konfirmasi via WhatsApp untuk respon cepat.')->with('wa_url', $waUrl);
    }

    public function kerjasama()
    {
        $page = Post::pages()->where('slug', 'permohonan-kerja-sama')->first();

        return view('frontend.layanan.kerjasama', compact('page'));
    }

    public function submitKerjasama(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'agency' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:30',
            'purpose' => 'required|string',
            'letter_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:5120',
            'ktp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        $safeExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp'];

        $letterPath = null;
        if ($request->hasFile('letter_file')) {
            $file = $request->file('letter_file');
            $ext = strtolower($file->guessExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            if (! in_array($ext, $safeExtensions, true)) {
                $ext = 'pdf';
            }
            $filename = 'proposal_'.time().'_'.Str::random(12).'.'.$ext;
            $file->move(public_path('uploads/layanan'), $filename);
            $letterPath = '/uploads/layanan/'.$filename;
        }

        $ktpPath = null;
        if ($request->hasFile('ktp_file')) {
            $file = $request->file('ktp_file');
            $ext = strtolower($file->guessExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            if (! in_array($ext, $safeExtensions, true)) {
                $ext = 'pdf';
            }
            $filename = 'ktp_kerjasama_'.time().'_'.Str::random(12).'.'.$ext;
            $file->move(public_path('uploads/layanan'), $filename);
            $ktpPath = '/uploads/layanan/'.$filename;
        }

        $messageContent = "PERMOHONAN KERJA SAMA LEMBAGA\n".
            "Nama Penanggung Jawab: {$validated['name']}\n".
            "Lembaga / Perusahaan: {$validated['agency']}\n".
            "WhatsApp: {$validated['whatsapp']}\n".
            "Bentuk Kerja Sama: {$validated['purpose']}\n".
            ($letterPath ? "Proposal/Surat: {$letterPath}\n" : '').
            ($ktpPath ? "KTP: {$ktpPath}\n" : '');

        Feedback::create([
            'name' => $validated['name'],
            'email' => $validated['whatsapp'].'@wa.layanan',
            'whatsapp' => $validated['whatsapp'],
            'message' => $messageContent,
            'status' => 'unread',
        ]);

        ActivityLog::create([
            'user_id' => null,
            'user_name' => $validated['name'].' ('.$validated['agency'].')',
            'action' => 'layanan_kerjasama',
            'description' => "Permohonan Kerja Sama dari {$validated['name']} ({$validated['agency']})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        $waText = urlencode("Assalamu'alaikum Pimpinan SMA IT Ishlahul Ummah Prabumulih,\n\nKami telah mengajukan Permohonan Kerja Sama Lembaga:\n- Nama: {$validated['name']}\n- Lembaga/Perusahaan: {$validated['agency']}\n- Bentuk Kerjasama: {$validated['purpose']}\n\nMohon informasi dan jadwal tindak lanjutnya. Terima kasih.");
        $waUrl = "https://wa.me/6282182680647?text={$waText}";

        return redirect()->route('layanan.kerjasama')->with('success', 'Permohonan kerja sama berhasil dikirim! Silakan konfirmasi via WhatsApp untuk respon cepat.')->with('wa_url', $waUrl);
    }

    public function sewaBarang()
    {
        $page = Post::pages()->where('slug', 'sewa-barang')->first();

        return view('frontend.layanan.sewa', compact('page'));
    }

    public function submitSewa(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'agency' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:30',
            'purpose' => 'required|string',
            'letter_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:5120',
            'ktp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'npwp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        $safeExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp'];

        $letterPath = null;
        if ($request->hasFile('letter_file')) {
            $file = $request->file('letter_file');
            $ext = strtolower($file->guessExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            if (! in_array($ext, $safeExtensions, true)) {
                $ext = 'pdf';
            }
            $filename = 'sewa_surat_'.time().'_'.Str::random(12).'.'.$ext;
            $file->move(public_path('uploads/layanan'), $filename);
            $letterPath = '/uploads/layanan/'.$filename;
        }

        $ktpPath = null;
        if ($request->hasFile('ktp_file')) {
            $file = $request->file('ktp_file');
            $ext = strtolower($file->guessExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            if (! in_array($ext, $safeExtensions, true)) {
                $ext = 'pdf';
            }
            $filename = 'sewa_ktp_'.time().'_'.Str::random(12).'.'.$ext;
            $file->move(public_path('uploads/layanan'), $filename);
            $ktpPath = '/uploads/layanan/'.$filename;
        }

        $npwpPath = null;
        if ($request->hasFile('npwp_file')) {
            $file = $request->file('npwp_file');
            $ext = strtolower($file->guessExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            if (! in_array($ext, $safeExtensions, true)) {
                $ext = 'pdf';
            }
            $filename = 'sewa_npwp_'.time().'_'.Str::random(12).'.'.$ext;
            $file->move(public_path('uploads/layanan'), $filename);
            $npwpPath = '/uploads/layanan/'.$filename;
        }

        $messageContent = "PERMOHONAN SEWA MENYEWA BARANG / FASILITAS SEKOLAH\n".
            "Nama Pemohon: {$validated['name']}\n".
            "Instansi / Komunitas: {$validated['agency']}\n".
            "WhatsApp: {$validated['whatsapp']}\n".
            "Barang/Fasilitas yang Ingin Disewa: {$validated['purpose']}\n".
            ($letterPath ? "Surat: {$letterPath}\n" : '').
            ($ktpPath ? "KTP: {$ktpPath}\n" : '').
            ($npwpPath ? "NPWP: {$npwpPath}\n" : '');

        Feedback::create([
            'name' => $validated['name'],
            'email' => $validated['whatsapp'].'@wa.layanan',
            'whatsapp' => $validated['whatsapp'],
            'message' => $messageContent,
            'status' => 'unread',
        ]);

        ActivityLog::create([
            'user_id' => null,
            'user_name' => $validated['name'].' ('.$validated['agency'].')',
            'action' => 'layanan_sewa',
            'description' => "Permohonan Sewa Barang/Sarana dari {$validated['name']} ({$validated['agency']})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        $waText = urlencode("Assalamu'alaikum Humas Sarpras SMA IT Ishlahul Ummah Prabumulih,\n\nSaya telah mengajukan Permohonan Sewa Fasilitas/Barang Sekolah:\n- Nama: {$validated['name']}\n- Instansi/Komunitas: {$validated['agency']}\n- Fasilitas/Barang: {$validated['purpose']}\n\nMohon konfirmasi ketersediaan jadwal dan syarat sewanya. Terima kasih.");
        $waUrl = "https://wa.me/6282182680647?text={$waText}";

        return redirect()->route('layanan.sewa')->with('success', 'Permohonan sewa barang/fasilitas berhasil dikirim! Silakan konfirmasi via WhatsApp untuk respon cepat.')->with('wa_url', $waUrl);
    }
}
