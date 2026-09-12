<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran PPDB - {{ $ppdb->registration_number }} - {{ $ppdb->full_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        .container {
            max-width: 800px;
            margin: auto;
            border: 2px solid #00913e;
            padding: 25px;
            border-radius: 8px;
        }
        .header {
            display: flex;
            align-items: center;
            border-bottom: 3px double #00913e;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .logo {
            width: 75px;
            height: auto;
            margin-right: 20px;
        }
        .header-text {
            text-align: center;
            flex-grow: 1;
        }
        .header-text h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #00913e;
            text-transform: uppercase;
        }
        .header-text h2 {
            margin: 3px 0;
            font-size: 14px;
            font-weight: bold;
            color: #da251c;
        }
        .header-text p {
            margin: 2px 0;
            font-size: 10px;
            color: #555;
        }
        .title-badge {
            text-align: center;
            margin: 15px 0 20px 0;
        }
        .title-badge span {
            background: #00913e;
            color: #fff;
            padding: 6px 16px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 20px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th, table td {
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }
        table th {
            width: 30%;
            color: #555;
            font-weight: normal;
        }
        table td {
            font-weight: bold;
            color: #111;
        }
        .section-title {
            background: #f0fdf4;
            color: #00913e;
            font-weight: bold;
            font-size: 11px;
            padding: 6px 8px;
            text-transform: uppercase;
            border-left: 4px solid #00913e;
            margin: 15px 0 8px 0;
        }
        .footer-signatures {
            margin-top: 35px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }
        .sig-box {
            width: 220px;
        }
        .sig-space {
            height: 60px;
        }
        @media print {
            body { padding: 0; }
            .container { border: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="max-width: 800px; margin: 0 auto 15px auto; text-align: right;">
        <button onclick="window.print()" style="background: #00913e; color: #fff; border: none; padding: 8px 16px; font-weight: bold; border-radius: 6px; cursor: pointer;">
            Cetak Dokumen Ini
        </button>
    </div>

    <div class="container">
        {{-- KOP SURAT --}}
        <div class="header">
            <img src="/uploads/logo-ishum-square.png" alt="Logo" class="logo">
            <div class="header-text">
                <h1>Yayasan Ishlahul Ummah Prabumulih</h1>
                <h2>SMA Islam Terpadu Ishlahul Ummah Prabumulih</h2>
                <p>NPSN: 69990882 &bull; Status Akreditasi B (BAN-SM: 074/BAP-SM/TU/XI/2016)</p>
                <p>Jl. Lingkar Timur, Kel. Gunung Ibul, Kec. Prabumulih Timur, Kota Prabumulih, Sumatera Selatan 31111</p>
                <p>Email: smaitishlahulummah@gmail.com | Website: https://smaitishumpbm.sch.id | WA: 0822-8189-6792</p>
            </div>
        </div>

        <div class="title-badge">
            <span>Tanda Bukti Pendaftaran PPDB 2026/2027</span>
        </div>

        <div style="background: #fff8f8; border: 1px solid #fecaca; padding: 8px 12px; border-radius: 6px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="color: #666; font-size: 11px;">Nomor Pendaftaran:</span>
                <strong style="color: #da251c; font-size: 15px; margin-left: 5px;">{{ $ppdb->registration_number }}</strong>
            </div>
            <div>
                <span style="color: #666; font-size: 11px;">Tanggal Daftar:</span>
                <strong>{{ $ppdb->created_at->translatedFormat('d F Y, H:i') }} WIB</strong>
            </div>
            <div>
                <span style="color: #666; font-size: 11px;">Status:</span>
                <strong style="color: #00913e;">{{ strtoupper($ppdb->status_label) }}</strong>
            </div>
        </div>

        <div class="section-title">A. Data Calon Siswa</div>
        <table>
            <tr>
                <th>Nama Lengkap</th>
                <td>: {{ $ppdb->full_name }}</td>
            </tr>
            <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>: {{ $ppdb->birth_place }}, {{ $ppdb->birth_date->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>: {{ $ppdb->gender }}</td>
            </tr>
            <tr>
                <th>Asal Sekolah (SMP/MTs)</th>
                <td>: {{ $ppdb->previous_school }}</td>
            </tr>
            <tr>
                <th>NISN</th>
                <td>: {{ $ppdb->nisn ?: '-' }}</td>
            </tr>
            <tr>
                <th>Alamat Rumah</th>
                <td>: {{ $ppdb->address }}</td>
            </tr>
            <tr>
                <th>Nomor HP / WhatsApp</th>
                <td>: {{ $ppdb->phone }}</td>
            </tr>
            <tr>
                <th>Cita-cita / Hobi</th>
                <td>: {{ $ppdb->ambition }} / {{ $ppdb->hobby }}</td>
            </tr>
        </table>

        <div class="section-title">B. Data Orang Tua / Wali</div>
        <table>
            <tr>
                <th>Nama Ayah / Pekerjaan</th>
                <td>: {{ $ppdb->father_name }} / {{ $ppdb->father_job }}</td>
            </tr>
            <tr>
                <th>Pendidikan / Penghasilan Ayah</th>
                <td>: {{ $ppdb->father_education }} / {{ $ppdb->father_income }}</td>
            </tr>
            <tr>
                <th>Nama Ibu / Pekerjaan</th>
                <td>: {{ $ppdb->mother_name }} / {{ $ppdb->mother_job }}</td>
            </tr>
            <tr>
                <th>Nomor Kontak Orang Tua</th>
                <td>: {{ $ppdb->father_phone ?: $ppdb->mother_phone ?: $ppdb->phone }}</td>
            </tr>
        </table>

        <div class="section-title">C. Berkas Kelengkapan</div>
        <table>
            <tr>
                <th>Scan Akta Kelahiran</th>
                <td>: {{ $ppdb->birth_certificate_path ? 'Sudah Dilampirkan (Valid)' : 'Belum Ada' }}</td>
            </tr>
            <tr>
                <th>Bukti Pembayaran Pendaftaran</th>
                <td>: {{ $ppdb->payment_proof_path ? 'Sudah Dilampirkan (BSI 7011304251)' : 'Belum Ada' }}</td>
            </tr>
        </table>

        {{-- TANDA TANGAN --}}
        <div class="footer-signatures">
            <div class="sig-box">
                <p>Calon Siswa / Orang Tua,</p>
                <div class="sig-space"></div>
                <p>( {{ $ppdb->full_name }} )</p>
            </div>
            <div class="sig-box">
                <p>Prabumulih, {{ date('d F Y') }}<br>Panitia SPMB Ishum,</p>
                <div class="sig-space"></div>
                <p>( Panitia SPMB TP 2026/2027 )</p>
            </div>
        </div>
    </div>

</body>
</html>
