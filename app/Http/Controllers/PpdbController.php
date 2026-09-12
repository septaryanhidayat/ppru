<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\PpdbRegistration;
use App\Services\WebpService;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function __construct(protected WebpService $webpService) {}

    /**
     * Display the SPMB / PPDB Info Page matching Screenshot 2.
     */
    public function index()
    {
        return view('frontend.ppdb.index');
    }

    /**
     * Display the PPDB Registration Form matching Screenshot 1.
     */
    public function form()
    {
        return view('frontend.ppdb.form');
    }

    /**
     * Store a new PPDB Registration from online form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Data Calon Siswa
            'full_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'address' => 'required|string|max:1000',
            'living_with' => 'required|string|max:100',
            'child_order' => 'required|integer|min:1|max:30',
            'siblings_count' => 'required|integer|min:0|max:30',
            'previous_school' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:50',
            'hobby' => 'required|string|max:255',
            'favorite_subject' => 'nullable|string|max:255',
            'ambition' => 'required|string|max:255',
            'achievements' => 'nullable|string|max:1000',
            'phone' => 'required|string|max:50',

            // Data Ayah / Wali
            'father_name' => 'required|string|max:255',
            'father_birth_place' => 'required|string|max:100',
            'father_birth_date' => 'required|date',
            'father_address' => 'required|string|max:1000',
            'father_education' => 'required|string|max:100',
            'father_job' => 'required|string|max:100',
            'father_income' => 'required|string|max:100',
            'father_phone' => 'nullable|string|max:50',

            // Data Ibu / Wali
            'mother_name' => 'required|string|max:255',
            'mother_birth_place' => 'required|string|max:100',
            'mother_birth_date' => 'required|date',
            'mother_address' => 'required|string|max:1000',
            'mother_education' => 'required|string|max:100',
            'mother_job' => 'required|string|max:100',
            'mother_income' => 'required|string|max:100',
            'mother_phone' => 'nullable|string|max:50',

            // Berkas Pendaftaran
            'birth_certificate' => 'required|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
            'payment_proof' => 'required|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
        ]);

        // Process Birth Certificate File
        $birthCertPath = null;
        if ($request->hasFile('birth_certificate')) {
            $file = $request->file('birth_certificate');
            $ext = strtolower($file->getClientOriginalExtension());
            if ($ext === 'pdf') {
                $filename = 'akta_'.time().'_'.uniqid().'.pdf';
                $file->move(public_path('uploads/ppdb/akta'), $filename);
                $birthCertPath = '/uploads/ppdb/akta/'.$filename;
            } else {
                $converted = $this->webpService->processUploadedFile($file, 'ppdb/akta', 82, 1600);
                $birthCertPath = $converted['success'] ? $converted['url'] : null;
            }
        }

        // Process Payment Proof File
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $ext = strtolower($file->getClientOriginalExtension());
            if ($ext === 'pdf') {
                $filename = 'bukti_bayar_'.time().'_'.uniqid().'.pdf';
                $file->move(public_path('uploads/ppdb/bukti'), $filename);
                $paymentProofPath = '/uploads/ppdb/bukti/'.$filename;
            } else {
                $converted = $this->webpService->processUploadedFile($file, 'ppdb/bukti', 82, 1600);
                $paymentProofPath = $converted['success'] ? $converted['url'] : null;
            }
        }

        $regNumber = PpdbRegistration::generateRegistrationNumber();

        $registration = PpdbRegistration::create([
            'registration_number' => $regNumber,
            'full_name' => $validated['full_name'],
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'living_with' => $validated['living_with'],
            'child_order' => $validated['child_order'],
            'siblings_count' => $validated['siblings_count'],
            'previous_school' => $validated['previous_school'],
            'nisn' => $validated['nisn'] ?? null,
            'hobby' => $validated['hobby'],
            'favorite_subject' => $validated['favorite_subject'] ?? null,
            'ambition' => $validated['ambition'],
            'achievements' => $validated['achievements'] ?? null,
            'phone' => $validated['phone'],

            'father_name' => $validated['father_name'],
            'father_birth_place' => $validated['father_birth_place'],
            'father_birth_date' => $validated['father_birth_date'],
            'father_address' => $validated['father_address'],
            'father_education' => $validated['father_education'],
            'father_job' => $validated['father_job'],
            'father_income' => $validated['father_income'],
            'father_phone' => $validated['father_phone'] ?? null,

            'mother_name' => $validated['mother_name'],
            'mother_birth_place' => $validated['mother_birth_place'],
            'mother_birth_date' => $validated['mother_birth_date'],
            'mother_address' => $validated['mother_address'],
            'mother_education' => $validated['mother_education'],
            'mother_job' => $validated['mother_job'],
            'mother_income' => $validated['mother_income'],
            'mother_phone' => $validated['mother_phone'] ?? null,

            'birth_certificate_path' => $birthCertPath,
            'payment_proof_path' => $paymentProofPath,
            'status' => 'pending',
            'academic_year' => '2026/2027',
        ]);

        ActivityLog::create([
            'user_id' => null,
            'user_name' => 'Calon Santri: '.$registration->full_name,
            'action' => 'ppdb_registration',
            'description' => "Pendaftaran PPDB Baru: {$registration->full_name} ({$registration->registration_number}) dari {$registration->previous_school}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('ppdb.success', ['reg' => $registration->registration_number])
            ->with('ppdb_success', [
                'name' => $registration->full_name,
                'reg_number' => $registration->registration_number,
                'phone' => $registration->phone,
            ]);
    }

    /**
     * Display registration success page.
     */
    public function success(Request $request)
    {
        $regNumber = $request->query('reg');
        $regId = session('ppdb_registered_id');

        $registration = null;
        if ($regNumber) {
            $registration = PpdbRegistration::where('registration_number', $regNumber)->first();
        } elseif ($regId) {
            $registration = PpdbRegistration::find($regId);
        }

        if (! $registration) {
            abort(404, 'Data pendaftaran tidak ditemukan.');
        }

        return view('frontend.ppdb.success', compact('registration'));
    }
}
