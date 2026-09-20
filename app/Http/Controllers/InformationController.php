<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Agenda;
use App\Models\Feedback;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\ServiceSubmission;
use App\Models\Setting;
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

    public function ikarus(Request $request)
    {
        $search = $request->input('q');

        $query = Post::whereIn('status', ['publish', 'published'])
            ->where(function ($q) {
                $q->whereHas('categories', function ($catQ) {
                    $catQ->where('slug', 'ikarus')
                        ->orWhere('name', 'like', '%ikarus%');
                })->orWhere('type', 'ikarus');
            })
            ->with(['categories', 'author', 'unitPendidikan']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%");
            });
        }

        $featured = (clone $query)->where('is_featured', true)->latest('published_at')->first();
        if (! $featured && ! $search) {
            $featured = (clone $query)->latest('published_at')->first();
        }

        $posts = $query->latest('published_at')->latest('id')->paginate(9)->withQueryString();

        $totalKarya = Post::whereIn('status', ['publish', 'published'])
            ->where(function ($q) {
                $q->whereHas('categories', function ($catQ) {
                    $catQ->where('slug', 'ikarus')
                        ->orWhere('name', 'like', '%ikarus%');
                })->orWhere('type', 'ikarus');
            })->count();

        $alumniProfilesCount = Post::where('type', 'alumni')->whereIn('status', ['publish', 'published'])->count();

        return view('frontend.ikarus.index', compact(
            'posts',
            'featured',
            'search',
            'totalKarya',
            'alumniProfilesCount'
        ));
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
        $stored = json_decode(Setting::get('layanan_izin_accordions', '[]'), true) ?: [];
        $accordions = ! empty($stored) ? $stored : self::getDefaultAccordions('izin');

        return view('frontend.layanan.izin', compact('page', 'accordions'));
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

        $letterPath = null;
        if ($request->hasFile('letter_file')) {
            $letterPath = $this->handleSecureUpload($request->file('letter_file'), 'surat_izin');
        }

        $ktpPath = null;
        if ($request->hasFile('ktp_file')) {
            $ktpPath = $this->handleSecureUpload($request->file('ktp_file'), 'ktp_izin');
        }

        $messageContent = "PERMOHONAN IZIN KUNJUNGAN KE SEKOLAH\n".
            "Nama: {$validated['name']}\n".
            "Instansi: {$validated['agency']}\n".
            "WhatsApp: {$validated['whatsapp']}\n".
            "Keperluan: {$validated['purpose']}\n".
            ($letterPath ? "Surat: {$letterPath}\n" : '').
            ($ktpPath ? "KTP: {$ktpPath}\n" : '');

        ServiceSubmission::create([
            'service_type' => 'izin_kunjungan',
            'name' => $validated['name'],
            'agency' => $validated['agency'],
            'whatsapp' => $validated['whatsapp'],
            'purpose' => $validated['purpose'],
            'letter_path' => $letterPath,
            'ktp_path' => $ktpPath,
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

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

        $waText = urlencode("Assalamu'alaikum Humas Pondok Pesantren Raudhatul Ulum Sakatiga,\n\nSaya telah mengajukan Permohonan Izin Kunjungan ke Sekolah:\n- Nama: {$validated['name']}\n- Instansi: {$validated['agency']}\n- Keperluan: {$validated['purpose']}\n\nMohon konfirmasi dan tindak lanjutnya. Terima kasih.");
        $waUrl = "https://wa.me/6281278901950?text={$waText}";

        return redirect()->route('layanan.izin')->with('success', 'Permohonan izin kunjungan Anda berhasil dikirim! Silakan konfirmasi via WhatsApp untuk respon cepat.')->with('wa_url', $waUrl);
    }

    public function kerjasama()
    {
        $page = Post::pages()->where('slug', 'permohonan-kerja-sama')->first();
        $stored = json_decode(Setting::get('layanan_kerjasama_accordions', '[]'), true) ?: [];
        $accordions = ! empty($stored) ? $stored : self::getDefaultAccordions('kerjasama');

        return view('frontend.layanan.kerjasama', compact('page', 'accordions'));
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

        $letterPath = null;
        if ($request->hasFile('letter_file')) {
            $letterPath = $this->handleSecureUpload($request->file('letter_file'), 'proposal');
        }

        $ktpPath = null;
        if ($request->hasFile('ktp_file')) {
            $ktpPath = $this->handleSecureUpload($request->file('ktp_file'), 'ktp_kerjasama');
        }

        $messageContent = "PERMOHONAN KERJA SAMA / KEMITRAAN\n".
            "Nama: {$validated['name']}\n".
            "Instansi: {$validated['agency']}\n".
            "WhatsApp: {$validated['whatsapp']}\n".
            "Keperluan: {$validated['purpose']}\n".
            ($letterPath ? "Surat: {$letterPath}\n" : '').
            ($ktpPath ? "KTP: {$ktpPath}\n" : '');

        ServiceSubmission::create([
            'service_type' => 'kerja_sama',
            'name' => $validated['name'],
            'agency' => $validated['agency'],
            'whatsapp' => $validated['whatsapp'],
            'purpose' => $validated['purpose'],
            'letter_path' => $letterPath,
            'ktp_path' => $ktpPath,
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

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

        $waText = urlencode("Assalamu'alaikum Humas Pondok Pesantren Raudhatul Ulum Sakatiga,\n\nSaya telah mengajukan Permohonan Kerja Sama / Kemitraan:\n- Nama: {$validated['name']}\n- Lembaga/Instansi: {$validated['agency']}\n- Rencana Kemitraan: {$validated['purpose']}\n\nMohon informasi waktu koordinasi dan tindak lanjutnya. Terima kasih.");
        $waUrl = "https://wa.me/6281278901950?text={$waText}";

        return redirect()->route('layanan.kerjasama')->with('success', 'Permohonan kerja sama berhasil dikirim! Silakan konfirmasi via WhatsApp untuk respon cepat.')->with('wa_url', $waUrl);
    }

    public function sewaBarang()
    {
        $page = Post::pages()->where('slug', 'sewa-barang')->first();
        $stored = json_decode(Setting::get('layanan_sewa_accordions', '[]'), true) ?: [];
        $accordions = ! empty($stored) ? $stored : self::getDefaultAccordions('sewa');

        return view('frontend.layanan.sewa', compact('page', 'accordions'));
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

        $letterPath = null;
        if ($request->hasFile('letter_file')) {
            $letterPath = $this->handleSecureUpload($request->file('letter_file'), 'sewa_surat');
        }

        $ktpPath = null;
        if ($request->hasFile('ktp_file')) {
            $ktpPath = $this->handleSecureUpload($request->file('ktp_file'), 'sewa_ktp');
        }

        $npwpPath = null;
        if ($request->hasFile('npwp_file')) {
            $npwpPath = $this->handleSecureUpload($request->file('npwp_file'), 'sewa_npwp');
        }

        $messageContent = "PERMOHONAN SEWA MENYEWA BARANG / FASILITAS SEKOLAH\n".
            "Nama Pemohon: {$validated['name']}\n".
            "Instansi / Komunitas: {$validated['agency']}\n".
            "WhatsApp: {$validated['whatsapp']}\n".
            "Barang/Fasilitas yang Ingin Disewa: {$validated['purpose']}\n".
            ($letterPath ? "Surat: {$letterPath}\n" : '').
            ($ktpPath ? "KTP: {$ktpPath}\n" : '').
            ($npwpPath ? "NPWP: {$npwpPath}\n" : '');

        ServiceSubmission::create([
            'service_type' => 'sewa_barang',
            'name' => $validated['name'],
            'agency' => $validated['agency'],
            'whatsapp' => $validated['whatsapp'],
            'purpose' => $validated['purpose'],
            'letter_path' => $letterPath,
            'ktp_path' => $ktpPath,
            'npwp_path' => $npwpPath,
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

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

        $waText = urlencode("Assalamu'alaikum Humas Sarpras Pondok Pesantren Raudhatul Ulum Sakatiga,\n\nSaya telah mengajukan Permohonan Sewa Fasilitas/Barang Sekolah:\n- Nama: {$validated['name']}\n- Instansi/Komunitas: {$validated['agency']}\n- Fasilitas/Barang: {$validated['purpose']}\n\nMohon konfirmasi ketersediaan jadwal dan syarat sewanya. Terima kasih.");
        $waUrl = "https://wa.me/6281278901950?text={$waText}";

        return redirect()->route('layanan.sewa')->with('success', 'Permohonan sewa barang/fasilitas berhasil dikirim! Silakan konfirmasi via WhatsApp untuk respon cepat.')->with('wa_url', $waUrl);
    }

    /**
     * High Security Upload Validator & Mover
     */
    private function handleSecureUpload($file, string $prefix): string
    {
        $safeExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower($file->guessExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
        if (! in_array($ext, $safeExtensions, true)) {
            $ext = 'pdf';
        }

        $filename = $prefix.'_'.time().'_'.Str::random(16).'.'.$ext;
        $targetDir = public_path('uploads/layanan');
        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $file->move($targetDir, $filename);

        return '/uploads/layanan/'.$filename;
    }

    /**
     * Default detailed accordions for PPRU portal
     */
    public static function getDefaultAccordions(string $type): array
    {
        return match ($type) {
            'izin' => [
                [
                    'title' => 'Persyaratan Pelayanan',
                    'content' => '<ul><li>Pemohon memiliki akun pada system untuk melakukan permohonan kunjungan</li><li>Pemohon melakukan pengajuan melalui system</li><li>Bukti permohonan kunjungan sudah di tandatangani oleh yang berwenang dan cap serta dibawa ketika hari kunjungan</li><li>Maksimal pengunjung 100 orang</li><li>Hari kunjungan adalah hari senin dan kamis</li><li>Waktu kunjungan adalah pukul 09.00-11.00 wib</li><li>Pengunjung menggunakan pakaian yang sopan dan rapi</li><li>Wajib menerapkan protkes ketat</li></ul>',
                ],
                [
                    'title' => 'Jangka Waktu Penyelesaian',
                    'content' => '<p>1 Hari kerja</p>',
                ],
                [
                    'title' => 'Biaya dan Tarif',
                    'content' => '<p>Gratis (Tidak dipungut biaya apapun)</p>',
                ],
                [
                    'title' => 'Produk Layanan',
                    'content' => '<p>Surat Persetujuan Kunjungan ke Pondok Pesantren Raudhatul Ulum Sakatiga</p>',
                ],
                [
                    'title' => 'Pengaduan, Saran dan Masukan',
                    'content' => '<p>Pengaduan, saran dan masukan dapat disampaikan ke bagian Sekretariat &amp; Humas Layanan Terpadu Pondok Pesantren Raudhatul Ulum Sakatiga.</p><p><strong>Alamat:</strong> Kompleks Pondok Pesantren Raudhatul Ulum, Desa Sakatiga, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan 30662</p><p><strong>No. HP (WhatsApp):</strong> <a href="https://wa.me/6281278901950" target="_blank" class="text-[#00843d] font-bold">0812-7890-1950</a></p><p><strong>Website:</strong> <a href="https://ppru.ac.id" target="_blank" class="text-[#00843d] font-bold">ppru.ac.id</a></p><p><strong>Email:</strong> <a href="mailto:sekretariat@ppru.ac.id" class="text-[#00843d] font-bold">sekretariat@ppru.ac.id</a></p>',
                ],
            ],
            'kerjasama' => [
                [
                    'title' => 'Persyaratan Pelayanan',
                    'content' => '<ul><li>Surat permohonan dari Pemerintah/Swasta/Industri/Yayasan/Organisasi/Instansi lainnya.</li><li>Surat permohonan dari Individu (perorangan)</li></ul>',
                ],
                [
                    'title' => 'Sistem Mekanisme dan Prosedur',
                    'content' => '<ul><li>Pemohon mengajukan surat permohonan kerja sama melalui form online atau langsung ke kantor pesantren.</li><li>Pihak pesantren meneliti dan memverifikasi kelayakan serta kesesuaian program kemitraan.</li><li>Pesantren mengonfirmasi kesepakatan dan menyusun MoU / Perjanjian Kerja Sama.</li></ul>',
                ],
                [
                    'title' => 'Jangka Waktu Penyelesaian',
                    'content' => '<p>3 - 7 Hari kerja tergantung kompleksitas kemitraan</p>',
                ],
                [
                    'title' => 'Biaya dan Tarif',
                    'content' => '<p>Gratis (Tidak dipungut biaya apapun)</p>',
                ],
                [
                    'title' => 'Produk Layanan',
                    'content' => '<p>Surat Perjanjian Kerja Sama / MoU (Memorandum of Understanding)</p>',
                ],
                [
                    'title' => 'Pengaduan, Saran dan Masukan',
                    'content' => '<p>Pengaduan, saran dan masukan dapat disampaikan ke bagian Sekretariat &amp; Humas Layanan Terpadu Pondok Pesantren Raudhatul Ulum Sakatiga.</p><p><strong>Alamat:</strong> Kompleks Pondok Pesantren Raudhatul Ulum, Desa Sakatiga, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan 30662</p><p><strong>No. HP (WhatsApp):</strong> <a href="https://wa.me/6281278901950" target="_blank" class="text-[#00843d] font-bold">0812-7890-1950</a></p><p><strong>Website:</strong> <a href="https://ppru.ac.id" target="_blank" class="text-[#00843d] font-bold">ppru.ac.id</a></p><p><strong>Email:</strong> <a href="mailto:sekretariat@ppru.ac.id" class="text-[#00843d] font-bold">sekretariat@ppru.ac.id</a></p>',
                ],
            ],
            'sewa' => [
                [
                    'title' => 'Persyaratan Pelayanan',
                    'content' => '<ul><li>Individu (perorangan):<ul><li>Surat Permohonan</li><li>Fotokopi KTP</li><li>Fotokopi NPWP (jika ada)</li></ul></li><li>Lembaga Organisasi<ul><li>Surat Permohonan</li><li>Fotokopi NPWP</li></ul></li></ul>',
                ],
                [
                    'title' => 'Sistem Mekanisme dan Prosedur',
                    'content' => '<ul><li>Pemohon mengajukan formulir permohonan sewa menyewa fasilitas milik pesantren.</li><li>Pemeriksaan ketersediaan sarana dan jadwal pemakaian oleh bagian sarana & prasarana.</li><li>Penerbitan surat izin pemakaian/sewa dan berita acara serah terima fasilitas.</li></ul>',
                ],
                [
                    'title' => 'Jangka Waktu Penyelesaian',
                    'content' => '<p>1 - 2 Hari kerja</p>',
                ],
                [
                    'title' => 'Biaya dan Tarif',
                    'content' => '<p>Sesuai dengan ketentuan tarif infaq / sewa sarana prasarana pesantren yang berlaku</p>',
                ],
                [
                    'title' => 'Produk Layanan',
                    'content' => '<p>Surat Izin Pemakaian / Sewa Fasilitas dan Berita Acara Peminjaman</p>',
                ],
                [
                    'title' => 'Pengaduan, Saran dan Masukan',
                    'content' => '<p>Pengaduan, saran dan masukan dapat disampaikan ke bagian Sekretariat &amp; Humas Layanan Terpadu Pondok Pesantren Raudhatul Ulum Sakatiga.</p><p><strong>Alamat:</strong> Kompleks Pondok Pesantren Raudhatul Ulum, Desa Sakatiga, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan 30662</p><p><strong>No. HP (WhatsApp):</strong> <a href="https://wa.me/6281278901950" target="_blank" class="text-[#00843d] font-bold">0812-7890-1950</a></p><p><strong>Website:</strong> <a href="https://ppru.ac.id" target="_blank" class="text-[#00843d] font-bold">ppru.ac.id</a></p><p><strong>Email:</strong> <a href="mailto:sekretariat@ppru.ac.id" class="text-[#00843d] font-bold">sekretariat@ppru.ac.id</a></p>',
                ],
            ],
            default => [],
        };
    }
}
