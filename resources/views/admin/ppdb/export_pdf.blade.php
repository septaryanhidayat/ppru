<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Pendaftar PPDB - Pondok Pesantren Raudhatul Ulum Sakatiga</title>
    <link rel="icon" type="image/png" href="/uploads/logo-ppru-square.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @page {
            size: A4 landscape;
            margin: 1.2cm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 3px double #0f172a;
            padding-bottom: 12px;
            margin-bottom: 16px;
            gap: 20px;
        }
        .header img {
            height: 75px;
            width: auto;
        }
        .header-text {
            text-align: center;
        }
        .header-text h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
            color: #064e3b;
            letter-spacing: 0.5px;
        }
        .header-text h3 {
            margin: 3px 0;
            font-size: 15px;
            font-weight: 800;
            color: #b91c1c;
        }
        .header-text p {
            margin: 2px 0;
            font-size: 10px;
            color: #475569;
        }
        .title-box {
            text-align: center;
            margin-bottom: 14px;
        }
        .title-box h1 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
            color: #0f172a;
            text-decoration: underline;
        }
        .title-box p {
            margin: 3px 0 0 0;
            font-size: 10px;
            color: #64748b;
        }
        .stats-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
            font-size: 10px;
        }
        .stat-item {
            border: 1px solid #cbd5e1;
            padding: 6px 12px;
            border-radius: 6px;
            background: #f8fafc;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #94a3b8;
            padding: 6px 7px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #0f172a;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .text-center { text-align: center; }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-verified { background: #e0f2fe; color: #0369a1; }
        .badge-accepted { background: #dcfce7; color: #15803d; }
        .badge-rejected { background: #fee2e2; color: #b91c1c; }
        .signatures {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .sig-box {
            text-align: center;
            width: 250px;
        }
        .sig-space {
            height: 65px;
        }
        .no-print {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }
        .btn-primary { background: #00913e; color: #fff; }
        .btn-secondary { background: #64748b; color: #fff; }
    </style>
</head>
<body>

    <div class="no-print">
        <div>
            <strong>Laporan Rekapitulasi Data PPDB Online</strong> - Format Cetak / Simpan sebagai PDF (A4 Landscape)
        </div>
        <div style="display: flex; gap: 8px;">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
            </button>
            <a href="{{ route('admin.ppdb.export.excel') }}" class="btn" style="background: #107c41; color: #fff;">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.ppdb.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- KOP SURAT --}}
    <div class="header">
        <img src="/uploads/logo-ppru-square.png" alt="Logo PPRU">
        <div class="header-text">
            <h2>YAYASAN PERGURUAN ISLAM RAUDHATUL ULUM (YAPIRUS)</h2>
            <h3>PONDOK PESANTREN RAUDHATUL ULUM SAKATIGA</h3>
            <p><strong>TERAKREDITASI A &bull; MUADALAH AL-AZHAR KAIRO</strong> &bull; NPSN: 10648831</p>
            <p>Desa Sakatiga, Kecamatan Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan 30816</p>
            <p>Telp/WA: 0812-7890-1950 | Email: sekretariat@ppru.ac.id | Web: https://ppru.ac.id</p>
        </div>
    </div>

    {{-- JUDUL LAPORAN --}}
    <div class="title-box">
        <h1>REKAPITULASI PENDAFTARAN PESERTA DIDIK BARU (PPDB) ONLINE</h1>
        <p>Tahun Pelajaran {{ \App\Models\Setting::get('ppdb_year', '2026/2027') }} &bull; Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    {{-- RINGKASAN STATISTIK --}}
    <div class="stats-bar">
        <div class="stat-item">Total Pendaftar: {{ $stats['total'] }}</div>
        <div class="stat-item" style="color: #92400e;">Pending / Menunggu: {{ $stats['pending'] }}</div>
        <div class="stat-item" style="color: #0369a1;">Terverifikasi: {{ $stats['verified'] }}</div>
        <div class="stat-item" style="color: #15803d;">Diterima: {{ $stats['accepted'] }}</div>
        <div class="stat-item" style="color: #b91c1c;">Ditolak: {{ $stats['rejected'] }}</div>
    </div>

    {{-- TABEL DATA --}}
    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>No. Registrasi</th>
                <th>Tgl Daftar</th>
                <th>Nama Calon Siswa</th>
                <th>Jalur &amp; Program</th>
                <th>L/P</th>
                <th>Tempat, Tgl Lahir</th>
                <th>Asal Sekolah</th>
                <th>NISN</th>
                <th>No. HP Siswa</th>
                <th>Nama Orang Tua</th>
                <th>Pekerjaan Ayah</th>
                <th>No. HP Orang Tua</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $index => $r)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center" style="font-family: monospace; font-weight: bold;">{{ $r->registration_number }}</td>
                    <td class="text-center">{{ $r->created_at ? $r->created_at->format('d/m/Y') : '-' }}</td>
                    <td><strong>{{ $r->full_name }}</strong></td>
                    <td>
                        <div style="font-weight: bold; color: #00913e;">{{ $r->track ?: 'Reguler' }}</div>
                        <div style="color: #64748b; font-size: 8.5px;">{{ $r->program_type ?: 'Boarding' }}</div>
                    </td>
                    <td class="text-center">{{ $r->gender === 'Laki-laki' ? 'L' : 'P' }}</td>
                    <td>{{ $r->birth_place }}, {{ $r->birth_date ? date('d/m/Y', strtotime($r->birth_date)) : '-' }}</td>
                    <td>{{ $r->previous_school }}</td>
                    <td class="text-center">{{ $r->nisn ?: '-' }}</td>
                    <td>{{ $r->phone }}</td>
                    <td>{{ $r->father_name }} / {{ $r->mother_name }}</td>
                    <td>{{ $r->father_job }}</td>
                    <td>{{ $r->father_phone ?: $r->mother_phone ?: '-' }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ $r->status }}">{{ $r->status_label }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="text-center" style="padding: 20px; color: #94a3b8;">
                        Belum ada data calon santri yang mendaftar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="signatures">
        <div class="sig-box">
            <p>Mengetahui,</p>
            <p><strong>Kepala Pondok Pesantren Raudhatul Ulum</strong></p>
            <div class="sig-space"></div>
            <p><strong><u>KH. Tol'at Wafa Ahmad, Lc.</u></strong></p>
            <p>NIY. 20190701001</p>
        </div>
        <div class="sig-box">
            <p>Sakatiga, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p><strong>Ketua Panitia PPDB</strong></p>
            <div class="sig-space"></div>
            <p><strong><u>Panitia SPMB PPRU</u></strong></p>
            <p>Pondok Pesantren Raudhatul Ulum</p>
        </div>
    </div>

</body>
</html>
