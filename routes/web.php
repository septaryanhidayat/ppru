<?php

use App\Http\Controllers\Admin\AdminAgendaController;
use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminBackupController;
use App\Http\Controllers\Admin\AdminBidangController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDewanController;
use App\Http\Controllers\Admin\AdminDownloadController;
use App\Http\Controllers\Admin\AdminFeedbackController;
use App\Http\Controllers\Admin\AdminHeroSlideController;
use App\Http\Controllers\Admin\AdminLayananController;
use App\Http\Controllers\Admin\AdminMediaController;
use App\Http\Controllers\Admin\AdminNavMenuController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminPopupController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminPpdbController;
use App\Http\Controllers\Admin\AdminProgramUnggulanController;
use App\Http\Controllers\Admin\AdminQuickMenuController;
use App\Http\Controllers\Admin\AdminSecurityController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminStaticPageController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminUnitPendidikanController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DewanController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\KhutbahController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\UnitPendidikanController;
use Illuminate\Support\Facades\Route;

// === AUTHENTICATION ROUTES ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === ADMIN CMS PANEL ROUTES (PROTECTED) ===
Route::prefix('admin')->middleware(['auth', 'unit.access'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/maintenance/toggle', [AdminDashboardController::class, 'toggleMaintenance'])->name('maintenance.toggle');

    // Analitik Pengunjung & Tren Pembaca
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');
    Route::post('/analytics/prune', [AdminAnalyticsController::class, 'prune'])->name('analytics.prune');

    // Posts & Categories Management
    Route::post('/categories/quick', [AdminCategoryController::class, 'quickStore'])->name('categories.quick');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('posts', AdminPostController::class);

    // Hero Banner Slider Beranda
    Route::resource('hero-slides', AdminHeroSlideController::class);

    // Nav Menus (Header & Footer Dynamic Links)
    Route::resource('nav-menus', AdminNavMenuController::class);

    // Static Pages Management (Profil, Visi Misi, Sejarah, Sambutan, Struktur, Privacy Policy, Halaman Baru)
    Route::get('/pages/create', [AdminPageController::class, 'create'])->name('pages.create');
    Route::post('/pages', [AdminPageController::class, 'store'])->name('pages.store');
    Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
    Route::get('/pages/donasi', [AdminStaticPageController::class, 'donasi'])->name('pages.donasi');
    Route::post('/pages/donasi', [AdminStaticPageController::class, 'updateDonasi'])->name('pages.donasi.update');
    Route::get('/pages/hymne-mars', [AdminStaticPageController::class, 'hymneMars'])->name('pages.hymne-mars');
    Route::post('/pages/hymne-mars', [AdminStaticPageController::class, 'updateHymneMars'])->name('pages.hymne-mars.update');
    Route::get('/pages/logo', [AdminStaticPageController::class, 'logo'])->name('pages.logo');
    Route::post('/pages/logo', [AdminStaticPageController::class, 'updateLogo'])->name('pages.logo.update');
    Route::get('/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}', [AdminPageController::class, 'destroy'])->name('pages.destroy');

    // Unit Pendidikan PPRU
    Route::get('/profil-unit', [AdminUnitPendidikanController::class, 'myUnit'])->name('profil-unit');
    Route::post('/unit/seed-demo', [AdminDashboardController::class, 'seedUnitDemo'])->name('unit.seed-demo');
    Route::resource('unit-pendidikan', AdminUnitPendidikanController::class);

    // Dewan Guru & GTK
    Route::resource('dewan', AdminDewanController::class);

    // Fasilitas Sekolah
    Route::resource('bidang', AdminBidangController::class);

    // Program Unggulan
    Route::resource('program-unggulan', AdminProgramUnggulanController::class);
    Route::resource('dpc', AdminProgramUnggulanController::class);

    // Galeri Foto & Video YouTube
    Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
    Route::post('/media/photo', [AdminMediaController::class, 'storePhoto'])->name('media.photo.store');
    Route::put('/media/photo/{photo}', [AdminMediaController::class, 'updatePhoto'])->name('media.photo.update');
    Route::delete('/media/photo/{photo}', [AdminMediaController::class, 'destroyPhoto'])->name('media.photo.destroy');
    Route::post('/media/video', [AdminMediaController::class, 'storeVideo'])->name('media.video.store');
    Route::delete('/media/video/{video}', [AdminMediaController::class, 'destroyVideo'])->name('media.video.destroy');

    // Agenda & Pengumuman
    Route::get('/agenda', [AdminAgendaController::class, 'index'])->name('agenda.index');
    Route::post('/agenda', [AdminAgendaController::class, 'storeAgenda'])->name('agenda.store');
    Route::delete('/agenda/{agenda}', [AdminAgendaController::class, 'destroyAgenda'])->name('agenda.destroy');
    Route::post('/pengumuman', [AdminAgendaController::class, 'storePengumuman'])->name('pengumuman.store');
    Route::delete('/pengumuman/{pengumuman}', [AdminAgendaController::class, 'destroyPengumuman'])->name('pengumuman.destroy');

    // Download Center Management
    Route::resource('downloads', AdminDownloadController::class);

    // Quick Menus (Menu Utama Beranda)
    Route::resource('quick-menus', AdminQuickMenuController::class);

    // PPDB Online Management
    Route::get('/ppdb', [AdminPpdbController::class, 'index'])->name('ppdb.index');
    Route::get('/ppdb/content', [AdminPpdbController::class, 'content'])->name('ppdb.content');
    Route::post('/ppdb/content', [AdminPpdbController::class, 'updateContent'])->name('ppdb.content.update');
    Route::match(['POST'], '/ppdb/fields/add', [AdminPpdbController::class, 'addField'])->name('ppdb.fields.add');
    Route::post('/ppdb/fields', [AdminPpdbController::class, 'addField']);
    Route::post('/ppdb/fields/reset', [AdminPpdbController::class, 'resetFields'])->name('ppdb.fields.reset');
    Route::match(['POST', 'DELETE'], '/ppdb/fields/{key}', [AdminPpdbController::class, 'deleteField'])->name('ppdb.fields.delete');
    Route::match(['POST', 'DELETE'], '/ppdb/fields/{key}/delete', [AdminPpdbController::class, 'deleteField']);
    Route::get('/ppdb/export/excel', [AdminPpdbController::class, 'exportExcel'])->name('ppdb.export.excel');
    Route::get('/ppdb/export/pdf', [AdminPpdbController::class, 'exportPdf'])->name('ppdb.export.pdf');
    Route::get('/ppdb/{ppdb}', [AdminPpdbController::class, 'show'])->name('ppdb.show');
    Route::match(['POST', 'PUT'], '/ppdb/{ppdb}/status', [AdminPpdbController::class, 'updateStatus'])->name('ppdb.status');
    Route::delete('/ppdb/{ppdb}', [AdminPpdbController::class, 'destroy'])->name('ppdb.destroy');
    Route::get('/ppdb/{ppdb}/print', [AdminPpdbController::class, 'print'])->name('ppdb.print');

    // Popup Banner Beranda
    Route::get('/popup', [AdminPopupController::class, 'index'])->name('popup.index');
    Route::post('/popup', [AdminPopupController::class, 'update'])->name('popup.update');

    // Testimonials Management
    Route::resource('testimonials', AdminTestimonialController::class);

    // Users & Multi-Role Management
    Route::resource('users', AdminUserController::class);

    // Feedbacks / Aspirasi Inbox
    Route::get('/feedbacks', [AdminFeedbackController::class, 'index'])->name('feedbacks.index');
    Route::post('/feedbacks/{feedback}/read', [AdminFeedbackController::class, 'markAsRead'])->name('feedbacks.read');
    Route::delete('/feedbacks/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('feedbacks.destroy');

    // Layanan Terpadu (Izin Sekolah, Kerja Sama, Sewa Barang)
    Route::get('/layanan', [AdminLayananController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/content', [AdminLayananController::class, 'content'])->name('layanan.content');
    Route::post('/layanan/content', [AdminLayananController::class, 'updateContent'])->name('layanan.content.update');
    Route::get('/layanan/{submission}', [AdminLayananController::class, 'show'])->name('layanan.show');
    Route::match(['POST', 'PUT'], '/layanan/{submission}/status', [AdminLayananController::class, 'updateStatus'])->name('layanan.status');
    Route::delete('/layanan/{submission}', [AdminLayananController::class, 'destroy'])->name('layanan.destroy');

    // Security & Activity Logs
    Route::get('/security', [AdminSecurityController::class, 'index'])->name('security.index');
    Route::post('/security/clear', [AdminSecurityController::class, 'clear'])->name('security.clear');

    // Database Backup & Download
    Route::get('/backup', [AdminBackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/download', [AdminBackupController::class, 'download'])->name('backup.download');

    // Website & SEO Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Database Migration Runner
    Route::post('/migrate', [AdminDashboardController::class, 'runMigration'])->name('migrate');
});

// === FRONTEND PUBLIC ROUTES ===

// Beranda (Homepage)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/beranda', fn () => redirect()->route('home'));

// Berita & Artikel
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('artikel.show');
Route::get('/kategori/{slug}', [ArticleController::class, 'category'])->name('kategori.show');
Route::get('/tag/{slug}', [ArticleController::class, 'tag'])->name('tag.show');

// Profil Pages
Route::get('/sambutan', [PageController::class, 'sambutan'])->name('page.sambutan');
Route::get('/sambutan-mudir', [PageController::class, 'sambutan']);
Route::get('/sambutan-kepala-sekolah', [PageController::class, 'sambutan']);
Route::get('/sambutan-pimpinan', [PageController::class, 'sambutan']);
Route::get('/sambutan-ketua-dpd', fn () => redirect()->route('page.sambutan', [], 301));
Route::get('/tentang-kami', [PageController::class, 'tentangKami'])->name('page.tentang-kami');
Route::get('/visi-dan-misi', [PageController::class, 'visiMisi'])->name('page.visi-misi');
Route::get('/sejarah', [PageController::class, 'sejarah'])->name('page.sejarah');
Route::get('/struktur-organisasi', [PageController::class, 'struktur'])->name('page.struktur');
Route::get('/struktur-kepengurusan', [PageController::class, 'struktur']);
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('page.privacy-policy');

// Unit Pendidikan (Jenjang & Lembaga Pesantren)
Route::get('/pendidikan', [UnitPendidikanController::class, 'index'])->name('pendidikan.index');
Route::get('/pendidikan/{slug}', [UnitPendidikanController::class, 'show'])->name('pendidikan.show');

// Dewan Guru & GTK
Route::get('/dewan-guru', [DewanController::class, 'index'])->name('dewan.index');
Route::get('/anggota-dewan', [DewanController::class, 'index']);

// Fasilitas Sekolah
Route::get('/fasilitas', [BidangController::class, 'index'])->name('bidang.index');
Route::get('/bidang', [BidangController::class, 'index']);
Route::get('/bidang/{slug}', [BidangController::class, 'show'])->name('bidang.show');

// Informasi (Agenda, Pengumuman, Testimonial, Video, Galeri, Prestasi, Ekskul, Alumni, Layanan)
Route::get('/agenda', [InformationController::class, 'agenda'])->name('agenda.index');
Route::get('/agenda/{slug}', [InformationController::class, 'agendaShow'])->name('agenda.show');
Route::get('/pengumuman', [InformationController::class, 'pengumuman'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [InformationController::class, 'pengumumanShow'])->name('pengumuman.show');
Route::get('/prestasi', [InformationController::class, 'prestasi'])->name('prestasi.index');
Route::get('/prestasi/{slug}', [InformationController::class, 'prestasiShow'])->name('prestasi.show');
Route::get('/ekstrakurikuler', [InformationController::class, 'ekskul'])->name('ekskul.index');
Route::get('/data-alumni', [InformationController::class, 'alumni'])->name('alumni.index');
Route::get('/ikarus', [InformationController::class, 'ikarus'])->name('ikarus.index');
Route::get('/alumni', fn () => redirect()->route('ikarus.index'));
Route::get('/alumni-ru', fn () => redirect()->route('ikarus.index'));
Route::get('/karya-alumni', fn () => redirect()->route('ikarus.index'));
Route::get('/alumni-ikarus', fn () => redirect()->route('ikarus.index'));

// Mimbar Khutbah Jum'at & Kajian Dakwah PPRU
Route::get('/khutbah', [KhutbahController::class, 'index'])->name('khutbah.index');
Route::get('/khutbah/{slug}', [KhutbahController::class, 'show'])->name('khutbah.show');
Route::get('/tausiyah', fn () => redirect()->route('khutbah.index'));
Route::get('/khutbah-jumat', fn () => redirect()->route('khutbah.index'));
Route::get('/layanan-terpadu', [InformationController::class, 'layanan'])->name('layanan.index');
Route::get('/layanan-terpadu-2', [InformationController::class, 'layananTerpadu'])->name('layanan.terpadu');
Route::get('/izin-sekolah', [InformationController::class, 'izinSekolah'])->name('layanan.izin');
Route::post('/izin-sekolah', [InformationController::class, 'submitIzin'])->middleware('throttle:15,1')->name('layanan.izin.submit');
Route::get('/permohonan-kerja-sama', [InformationController::class, 'kerjasama'])->name('layanan.kerjasama');
Route::post('/permohonan-kerja-sama', [InformationController::class, 'submitKerjasama'])->middleware('throttle:15,1')->name('layanan.kerjasama.submit');
Route::get('/sewa-barang', [InformationController::class, 'sewaBarang'])->name('layanan.sewa');
Route::post('/sewa-barang', [InformationController::class, 'submitSewa'])->middleware('throttle:15,1')->name('layanan.sewa.submit');
Route::get('/testimonial', [InformationController::class, 'testimonial'])->name('testimonial.index');
Route::get('/video', [InformationController::class, 'video'])->name('video.index');
Route::get('/galeri-video', fn () => redirect()->route('video.index'));
Route::get('/galeri', [InformationController::class, 'galeri'])->name('galeri.index');
Route::get('/galeri-kegiatan', fn () => redirect()->route('galeri.index'));

// SPMB & PPDB Online (Landing Page, Form Pendaftaran & Sukses)
Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb.index');
Route::get('/spmb', fn () => redirect()->route('ppdb.index'));
Route::get('/form_ppdb', [PpdbController::class, 'form'])->name('ppdb.form');
Route::get('/form-ppdb', fn () => redirect()->route('ppdb.form'));
Route::get('/ppdb/form', fn () => redirect()->route('ppdb.form'));
Route::post('/form_ppdb', [PpdbController::class, 'store'])->middleware('throttle:15,1')->name('ppdb.store');
Route::post('/ppdb/form', [PpdbController::class, 'store'])->middleware('throttle:15,1');
Route::get('/ppdb/sukses', [PpdbController::class, 'success'])->name('ppdb.success');

// Download & Media
Route::get('/download', [DownloadController::class, 'index'])->name('download.index');
Route::get('/e-book', [DownloadController::class, 'ebook'])->name('download.ebook');
Route::get('/download/ebook', fn () => redirect()->route('download.ebook'));
Route::get('/download/e-book', fn () => redirect()->route('download.ebook'));
Route::get('/hymne-mars', [DownloadController::class, 'hymneMars'])->name('download.hymne-mars');
Route::get('/download/hymne-mars', fn () => redirect()->route('download.hymne-mars'));
Route::get('/download/mars', fn () => redirect()->route('download.hymne-mars'));
Route::get('/logo', [DownloadController::class, 'logo'])->name('download.logo');
Route::get('/download/logo', fn () => redirect()->route('download.logo'));
Route::get('/unduh/{id}', [DownloadController::class, 'downloadFile'])->name('download.file');
Route::get('/download/file/{id}', [DownloadController::class, 'downloadFile'])->name('download.file.alt');
Route::get('/download-file/{id}', [DownloadController::class, 'downloadFile']);

// Program Unggulan
Route::get('/program-unggulan', [PageController::class, 'programUnggulan'])->name('program-unggulan.index');
Route::get('/program-unggulan-santri', fn () => redirect()->route('program-unggulan.index'));
Route::get('/dpc', [PageController::class, 'programUnggulan'])->name('dpc.index');

// Dewan Guru & GTK Alias
Route::get('/guru', fn () => redirect()->route('dewan.index'));

// Hubungi & Donasi
Route::get('/hubungi', [ContactController::class, 'hubungi'])->name('hubungi');
Route::get('/kontak', fn () => redirect()->route('hubungi'));
Route::post('/hubungi', [ContactController::class, 'submitFeedback'])->middleware('throttle:15,1')->name('feedback.store');
Route::post('/hubungi-store', [ContactController::class, 'submitFeedback'])->middleware('throttle:15,1')->name('hubungi.store');
Route::get('/donasi', [ContactController::class, 'donasi'])->name('donasi');

// Legacy URL 301 Redirect for WordPress images to clean Laravel /uploads/ path
Route::get('/wp-content/uploads/{path}', function (string $path) {
    // Prevent path traversal and null byte injections
    if (str_contains($path, '..') || str_contains($path, "\0")) {
        abort(404);
    }

    $allowedExtensions = ['webp', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'pdf', 'mp3'];
    $requestedExt = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    if (! in_array($requestedExt, $allowedExtensions)) {
        abort(404);
    }

    // 1. If webp version exists in uploads, 301 redirect to it
    $baseName = pathinfo($path, PATHINFO_DIRNAME).'/'.pathinfo($path, PATHINFO_FILENAME);
    $webpPath = public_path('uploads/'.trim($baseName, '/').'.webp');
    $realUploadsBase = realpath(public_path('uploads'));

    if (file_exists($webpPath)) {
        $realWebp = realpath($webpPath);
        if ($realWebp && $realUploadsBase && str_starts_with($realWebp, $realUploadsBase)) {
            return redirect('/uploads/'.trim($baseName, '/').'.webp', 301);
        }
    }

    // 2. If original file exists inside public/uploads, 301 redirect to it
    $originalPath = public_path('uploads/'.$path);
    if (file_exists($originalPath)) {
        $realOriginal = realpath($originalPath);
        if ($realOriginal && $realUploadsBase && str_starts_with($realOriginal, $realUploadsBase)) {
            return redirect('/uploads/'.ltrim($path, '/'), 301);
        }
    }

    abort(404);
})->where('path', '.*');

// Block legacy WordPress paths from bots and scanners (return 404 immediately without hitting page query)
Route::any('/wp-{any}', function () {
    abort(404);
})->where('any', '.*');

// Generic page fallback route
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
