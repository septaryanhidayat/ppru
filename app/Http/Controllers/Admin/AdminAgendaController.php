<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agenda;
use App\Models\Pengumuman;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminAgendaController extends Controller
{
    public function __construct(
        protected WebpService $webpService
    ) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->input('tab', 'agenda');

        $agendaQuery = Agenda::latest('event_date');
        if ($search && $tab === 'agenda') {
            $agendaQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }
        $agendas = $agendaQuery->paginate(10, ['*'], 'agenda_page')->withQueryString();

        $pengumumanQuery = Pengumuman::latest();
        if ($search && $tab === 'pengumuman') {
            $pengumumanQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }
        $pengumumen = $pengumumanQuery->paginate(10, ['*'], 'pengumuman_page')->withQueryString();

        return view('admin.agenda.index', compact('agendas', 'pengumumen', 'search', 'tab'));
    }

    public function storeAgenda(Request $request)
    {
        if ($request->has('content') && trim(strip_tags((string) $request->input('content'))) === '') {
            $request->merge(['content' => null]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed,publish',
            'featured_image_file' => 'nullable|image|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('featured_image_file'), 'agenda', 85, 1200);
            if ($converted['success']) {
                $imagePath = $converted['url'];
            }
        }

        $agenda = Agenda::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.time(),
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'content' => $validated['content'] ?? '',
            'status' => $validated['status'],
            'featured_image' => $imagePath,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'agenda_create',
            'description' => "Menambahkan Agenda Kegiatan: {$agenda->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.agenda.index', ['tab' => 'agenda'])->with('success', 'Agenda kegiatan berhasil ditambahkan.');
    }

    public function updateAgenda(Request $request, Agenda $agenda)
    {
        if ($request->has('content') && trim(strip_tags((string) $request->input('content'))) === '') {
            $request->merge(['content' => null]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed,publish',
            'featured_image_file' => 'nullable|image|max:10240',
        ]);

        $data = [
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'content' => $validated['content'] ?? '',
            'status' => $validated['status'],
        ];

        if ($request->hasFile('featured_image_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('featured_image_file'), 'agenda', 85, 1200);
            if ($converted['success']) {
                $data['featured_image'] = $converted['url'];
            }
        }

        $agenda->update($data);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'agenda_update',
            'description' => "Memperbarui Agenda Kegiatan: {$agenda->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.agenda.index', ['tab' => 'agenda'])->with('success', 'Agenda kegiatan berhasil diperbarui.');
    }

    public function destroyAgenda(Request $request, Agenda $agenda)
    {
        $title = $agenda->title;
        $agenda->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'agenda_delete',
            'description' => "Menghapus Agenda Kegiatan: {$title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.agenda.index', ['tab' => 'agenda'])->with('success', 'Agenda kegiatan berhasil dihapus.');
    }

    public function storePengumuman(Request $request)
    {
        if ($request->has('content') && trim(strip_tags((string) $request->input('content'))) === '') {
            $request->merge(['content' => null]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:publish,draft',
            'file_attachment_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:10240',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('file_attachment_file')) {
            $file = $request->file('file_attachment_file');
            $filename = 'pengumuman_'.time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $targetDir = public_path('uploads/pengumuman');
            if (! is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $file->move($targetDir, $filename);
            $attachmentPath = '/uploads/pengumuman/'.$filename;
        }

        $pengumuman = Pengumuman::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.time(),
            'content' => $validated['content'],
            'status' => $validated['status'],
            'file_attachment' => $attachmentPath,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'pengumuman_create',
            'description' => "Menambahkan Pengumuman Resmi: {$pengumuman->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.agenda.index', ['tab' => 'pengumuman'])->with('success', 'Pengumuman resmi berhasil diterbitkan.');
    }

    public function updatePengumuman(Request $request, Pengumuman $pengumuman)
    {
        if ($request->has('content') && trim(strip_tags((string) $request->input('content'))) === '') {
            $request->merge(['content' => null]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:publish,draft',
            'file_attachment_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:10240',
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('file_attachment_file')) {
            $file = $request->file('file_attachment_file');
            $filename = 'pengumuman_'.time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $targetDir = public_path('uploads/pengumuman');
            if (! is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $file->move($targetDir, $filename);
            $data['file_attachment'] = '/uploads/pengumuman/'.$filename;
        }

        $pengumuman->update($data);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'pengumuman_update',
            'description' => "Memperbarui Pengumuman / Info: {$pengumuman->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.agenda.index', ['tab' => 'pengumuman'])->with('success', 'Pengumuman / Informasi resmi berhasil diperbarui.');
    }

    public function destroyPengumuman(Request $request, Pengumuman $pengumuman)
    {
        $title = $pengumuman->title;
        $pengumuman->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'pengumuman_delete',
            'description' => "Menghapus Pengumuman: {$title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.agenda.index', ['tab' => 'pengumuman'])->with('success', 'Pengumuman berhasil dihapus.');
    }
}
