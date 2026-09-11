<?php

use App\Http\Controllers\Admin\AdminAgendaController;
use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminBackupController;
use App\Http\Controllers\Admin\AdminBidangController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDewanController;
use App\Http\Controllers\Admin\AdminDownloadController;
use App\Http\Controllers\Admin\AdminDpcController;
use App\Http\Controllers\Admin\AdminFeedbackController;
use App\Http\Controllers\Admin\AdminMediaController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminQuickMenuController;
use App\Http\Controllers\Admin\AdminSecurityController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DewanController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// === AUTHENTICATION ROUTES ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === ADMIN CMS PANEL ROUTES (PROTECTED) ===
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Analitik Pengunjung & Tren Pembaca
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');
    Route::post('/analytics/prune', [AdminAnalyticsController::class, 'prune'])->name('analytics.prune');

    // Posts Management
    Route::resource('posts', AdminPostController::class);

    // Static Pages Management (Profil, Visi Misi, Sejarah, Sambutan, Struktur, Privacy Policy)
    Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
    Route::get('/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');

    // Anggota Dewan (Fraksi PKS)
    Route::resource('dewan', AdminDewanController::class);

    // Bidang DPD
    Route::resource('bidang', AdminBidangController::class);

    // DPC Kecamatan
    Route::resource('dpc', AdminDpcController::class);

    // Galeri Foto & Video YouTube
    Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
    Route::post('/media/photo', [AdminMediaController::class, 'storePhoto'])->name('media.photo.store');
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

    // Testimonials Management
    Route::resource('testimonials', AdminTestimonialController::class);

    // Users & Multi-Role Management
    Route::resource('users', AdminUserController::class);

    // Feedbacks / Aspirasi Inbox
    Route::get('/feedbacks', [AdminFeedbackController::class, 'index'])->name('feedbacks.index');
    Route::post('/feedbacks/{feedback}/read', [AdminFeedbackController::class, 'markAsRead'])->name('feedbacks.read');
    Route::delete('/feedbacks/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('feedbacks.destroy');

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
Route::get('/sambutan-kepala-sekolah', [PageController::class, 'sambutan'])->name('page.sambutan');
Route::get('/sambutan-ketua-dpd', [PageController::class, 'sambutan']);
Route::get('/tentang-kami', [PageController::class, 'tentangKami'])->name('page.tentang-kami');
Route::get('/visi-dan-misi', [PageController::class, 'visiMisi'])->name('page.visi-misi');
Route::get('/sejarah', [PageController::class, 'sejarah'])->name('page.sejarah');
Route::get('/struktur-organisasi', [PageController::class, 'struktur'])->name('page.struktur');
Route::get('/struktur-kepengurusan', [PageController::class, 'struktur']);
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('page.privacy-policy');

// Dewan Guru & GTK
Route::get('/dewan-guru', [DewanController::class, 'index'])->name('dewan.index');
Route::get('/anggota-dewan', [DewanController::class, 'index']);

// Fasilitas Sekolah
Route::get('/fasilitas', [BidangController::class, 'index'])->name('bidang.index');
Route::get('/bidang', [BidangController::class, 'index']);
Route::get('/bidang/{slug}', [BidangController::class, 'show'])->name('bidang.show');

// Informasi (Agenda, Pengumuman, Testimonial, Video, Galeri)
Route::get('/agenda', [InformationController::class, 'agenda'])->name('agenda.index');
Route::get('/agenda/{slug}', [InformationController::class, 'agendaShow'])->name('agenda.show');
Route::get('/pengumuman', [InformationController::class, 'pengumuman'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [InformationController::class, 'pengumumanShow'])->name('pengumuman.show');
Route::get('/testimonial', [InformationController::class, 'testimonial'])->name('testimonial.index');
Route::get('/video', [InformationController::class, 'video'])->name('video.index');
Route::get('/galeri', [InformationController::class, 'galeri'])->name('galeri.index');

// Download & Media
Route::get('/download', [DownloadController::class, 'index'])->name('download.index');
Route::get('/e-book', [DownloadController::class, 'ebook'])->name('download.ebook');
Route::get('/hymne-mars', [DownloadController::class, 'hymneMars'])->name('download.hymne-mars');
Route::get('/hymne-mars-pks', [DownloadController::class, 'hymneMars']);
Route::get('/logo', [DownloadController::class, 'logo'])->name('download.logo');
Route::get('/unduh/{id}', [DownloadController::class, 'downloadFile'])->name('download.file');
Route::get('/download/file/{id}', [DownloadController::class, 'downloadFile'])->name('download.file.alt');
Route::get('/download-file/{id}', [DownloadController::class, 'downloadFile']);

// Program Unggulan
Route::get('/program-unggulan', [PageController::class, 'dpc'])->name('dpc.index');
Route::get('/dpc', [PageController::class, 'dpc']);
Route::get('/dpc-pks', [PageController::class, 'dpc']);

// Hubungi & Donasi
Route::get('/hubungi', [ContactController::class, 'hubungi'])->name('hubungi');
Route::post('/hubungi', [ContactController::class, 'submitFeedback'])->name('feedback.store');
Route::post('/hubungi-store', [ContactController::class, 'submitFeedback'])->name('hubungi.store');
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
