<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Str;

class PpdbFormService
{
    /**
     * Get section definitions with friendly labels and icons.
     */
    public static function getSections(): array
    {
        return [
            'pilihan' => [
                'name' => 'Pilihan Gelombang, Jalur & Program',
                'icon' => 'fa-solid fa-list-ol',
                'color' => 'bg-blue-100 text-blue-700',
            ],
            'siswa' => [
                'name' => 'Data Calon Siswa',
                'icon' => 'fa-solid fa-user-graduate',
                'color' => 'bg-emerald-100 text-[#00913e]',
            ],
            'ayah' => [
                'name' => 'Data Ayah / Wali',
                'icon' => 'fa-solid fa-user-tie',
                'color' => 'bg-slate-100 text-slate-700',
            ],
            'ibu' => [
                'name' => 'Data Ibu / Wali',
                'icon' => 'fa-solid fa-person-dress',
                'color' => 'bg-pink-100 text-pink-700',
            ],
            'berkas' => [
                'name' => 'Upload Berkas Pendaftaran',
                'icon' => 'fa-solid fa-cloud-arrow-up',
                'color' => 'bg-amber-100 text-amber-700',
            ],
            'tambahan' => [
                'name' => 'Data Tambahan / Isian Kustom',
                'icon' => 'fa-solid fa-folder-plus',
                'color' => 'bg-purple-100 text-purple-700',
            ],
        ];
    }

    /**
     * Default schema containing all standard fields.
     */
    public static function getDefaultSchema(): array
    {
        return [
            // Section 1: Pilihan
            [
                'key' => 'wave',
                'label' => 'Gelombang Pendaftaran',
                'section' => 'pilihan',
                'type' => 'select',
                'required' => false,
                'enabled' => true,
                'options' => ['Gelombang 1 (Early Bird)', 'Gelombang 2 (Reguler)', 'Gelombang 3 (Prestasi)'],
                'placeholder' => 'Pilih Gelombang...',
                'is_system' => true,
            ],
            [
                'key' => 'track',
                'label' => 'Jalur Pendaftaran',
                'section' => 'pilihan',
                'type' => 'select',
                'required' => false,
                'enabled' => true,
                'options' => [
                    'Jalur Reguler / Tes Mandiri',
                    'Jalur Prestasi Akademik & Non-Akademik',
                    "Jalur Hafizh Al-Qur'an (Tahfidz)",
                    'Jalur Alumni SMPIT Ishum',
                    'Jalur Beasiswa / Afirmasi',
                ],
                'placeholder' => 'Pilih Jalur Masuk...',
                'is_system' => true,
            ],
            [
                'key' => 'program_type',
                'label' => 'Program Pilihan',
                'section' => 'pilihan',
                'type' => 'select',
                'required' => false,
                'enabled' => true,
                'options' => ['Boarding School (Asrama Santri)', 'Full Day School (Sekolah Terpadu)'],
                'placeholder' => 'Pilih Program Belajar...',
                'is_system' => true,
            ],

            // Section 2: Siswa
            [
                'key' => 'full_name',
                'label' => 'Nama Lengkap Siswa',
                'section' => 'siswa',
                'type' => 'text',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Masukkan nama lengkap sesuai akta...',
                'is_system' => true,
            ],
            [
                'key' => 'birth_place',
                'label' => 'Tempat Lahir Siswa',
                'section' => 'siswa',
                'type' => 'text',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Kota kelahiran...',
                'is_system' => true,
            ],
            [
                'key' => 'birth_date',
                'label' => 'Tanggal Lahir Siswa',
                'section' => 'siswa',
                'type' => 'date',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => '',
                'is_system' => true,
            ],
            [
                'key' => 'gender',
                'label' => 'Jenis Kelamin',
                'section' => 'siswa',
                'type' => 'select',
                'required' => true,
                'enabled' => true,
                'options' => ['Laki-laki', 'Perempuan'],
                'placeholder' => 'Pilih Jenis Kelamin...',
                'is_system' => true,
            ],
            [
                'key' => 'address',
                'label' => 'Alamat Tempat Tinggal',
                'section' => 'siswa',
                'type' => 'textarea',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten...',
                'is_system' => true,
            ],
            [
                'key' => 'living_with',
                'label' => 'Tinggal Bersama',
                'section' => 'siswa',
                'type' => 'select',
                'required' => true,
                'enabled' => true,
                'options' => ['Orang Tua', 'Wali', 'Asrama / Boarding', 'Kost', 'Lainnya'],
                'placeholder' => 'Pilih Tempat Tinggal...',
                'is_system' => true,
            ],
            [
                'key' => 'child_order',
                'label' => 'Anak ke -',
                'section' => 'siswa',
                'type' => 'number',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => '1',
                'is_system' => true,
            ],
            [
                'key' => 'siblings_count',
                'label' => 'Dari Jumlah Saudara',
                'section' => 'siswa',
                'type' => 'number',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => '1',
                'is_system' => true,
            ],
            [
                'key' => 'previous_school',
                'label' => 'Asal Sekolah (SMP / MTs)',
                'section' => 'siswa',
                'type' => 'text',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Nama SMP / MTs asal...',
                'is_system' => true,
            ],
            [
                'key' => 'nisn',
                'label' => 'Nomor Induk Siswa Nasional (NISN)',
                'section' => 'siswa',
                'type' => 'text',
                'required' => false,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Nomor NISN 10 digit (jika ada)...',
                'is_system' => true,
            ],
            [
                'key' => 'hobby',
                'label' => 'Hobi Calon Siswa',
                'section' => 'siswa',
                'type' => 'text',
                'required' => false,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Membaca, Futsal, Robotika, dll...',
                'is_system' => true,
            ],
            [
                'key' => 'favorite_subject',
                'label' => 'Bidang Studi Paling Disukai',
                'section' => 'siswa',
                'type' => 'text',
                'required' => false,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Matematika, IPA, PAI, Bahasa Arab, dll...',
                'is_system' => true,
            ],
            [
                'key' => 'ambition',
                'label' => 'Cita-cita',
                'section' => 'siswa',
                'type' => 'text',
                'required' => false,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Dokter, Ulama, Dosen, Pengusaha, dll...',
                'is_system' => true,
            ],
            [
                'key' => 'achievements',
                'label' => 'Prestasi yang Pernah Diraih',
                'section' => 'siswa',
                'type' => 'textarea',
                'required' => false,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Sebutkan prestasi akademik, tahfidz, olahraga atau lomba yang pernah diraih...',
                'is_system' => true,
            ],
            [
                'key' => 'phone',
                'label' => 'Nomor HP / WhatsApp Siswa',
                'section' => 'siswa',
                'type' => 'tel',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => '08xxxxxxxxxx',
                'is_system' => true,
            ],

            // Section 3: Ayah
            [
                'key' => 'father_name',
                'label' => 'Nama Lengkap Ayah / Wali',
                'section' => 'ayah',
                'type' => 'text',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Nama lengkap ayah/wali...',
                'is_system' => true,
            ],
            [
                'key' => 'father_birth_place',
                'label' => 'Tempat Lahir Ayah',
                'section' => 'ayah',
                'type' => 'text',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Kota kelahiran ayah...',
                'is_system' => true,
            ],
            [
                'key' => 'father_birth_date',
                'label' => 'Tanggal Lahir Ayah',
                'section' => 'ayah',
                'type' => 'date',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => '',
                'is_system' => true,
            ],
            [
                'key' => 'father_address',
                'label' => 'Alamat Ayah / Wali',
                'section' => 'ayah',
                'type' => 'textarea',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Alamat domisili ayah/wali...',
                'is_system' => true,
            ],
            [
                'key' => 'father_education',
                'label' => 'Pendidikan Terakhir Ayah',
                'section' => 'ayah',
                'type' => 'select',
                'required' => true,
                'enabled' => true,
                'options' => [
                    'Tidak Sekolah',
                    'SD / Sederajat',
                    'SMP / Sederajat',
                    'SMA / SMK / MA',
                    'Diploma (D1/D2/D3)',
                    'Sarjana (S1)',
                    'Magister (S2)',
                    'Doktor (S3)',
                ],
                'placeholder' => 'Pilih Pendidikan...',
                'is_system' => true,
            ],
            [
                'key' => 'father_job',
                'label' => 'Pekerjaan Ayah',
                'section' => 'ayah',
                'type' => 'select',
                'required' => true,
                'enabled' => true,
                'options' => [
                    'PNS / Polisi / TNI',
                    'Wiraswasta / Pengusaha',
                    'Karyawan Swasta / BUMN',
                    'Guru / Dosen',
                    'Petani / Pekebun',
                    'Buruh / Tenaga Harian',
                    'Pensiunan',
                    'Lainnya',
                ],
                'placeholder' => 'Pilih Pekerjaan...',
                'is_system' => true,
            ],
            [
                'key' => 'father_income',
                'label' => 'Penghasilan Ayah per Bulan',
                'section' => 'ayah',
                'type' => 'select',
                'required' => true,
                'enabled' => true,
                'options' => [
                    'Tidak Berpenghasilan',
                    '< Rp 1.000.000',
                    'Rp 1.000.000 - Rp 3.000.000',
                    'Rp 3.000.000 - Rp 5.000.000',
                    'Rp 5.000.000 - Rp 10.000.000',
                    '> Rp 10.000.000',
                ],
                'placeholder' => 'Pilih Kisaran Penghasilan...',
                'is_system' => true,
            ],
            [
                'key' => 'father_phone',
                'label' => 'Nomor HP / WhatsApp Ayah',
                'section' => 'ayah',
                'type' => 'tel',
                'required' => false,
                'enabled' => true,
                'options' => [],
                'placeholder' => '08xxxxxxxxxx',
                'is_system' => true,
            ],

            // Section 4: Ibu
            [
                'key' => 'mother_name',
                'label' => 'Nama Lengkap Ibu / Wali',
                'section' => 'ibu',
                'type' => 'text',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Nama lengkap ibu/wali...',
                'is_system' => true,
            ],
            [
                'key' => 'mother_birth_place',
                'label' => 'Tempat Lahir Ibu',
                'section' => 'ibu',
                'type' => 'text',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Kota kelahiran ibu...',
                'is_system' => true,
            ],
            [
                'key' => 'mother_birth_date',
                'label' => 'Tanggal Lahir Ibu',
                'section' => 'ibu',
                'type' => 'date',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => '',
                'is_system' => true,
            ],
            [
                'key' => 'mother_address',
                'label' => 'Alamat Ibu / Wali',
                'section' => 'ibu',
                'type' => 'textarea',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Alamat domisili ibu/wali...',
                'is_system' => true,
            ],
            [
                'key' => 'mother_education',
                'label' => 'Pendidikan Terakhir Ibu',
                'section' => 'ibu',
                'type' => 'select',
                'required' => true,
                'enabled' => true,
                'options' => [
                    'Tidak Sekolah',
                    'SD / Sederajat',
                    'SMP / Sederajat',
                    'SMA / SMK / MA',
                    'Diploma (D1/D2/D3)',
                    'Sarjana (S1)',
                    'Magister (S2)',
                    'Doktor (S3)',
                ],
                'placeholder' => 'Pilih Pendidikan...',
                'is_system' => true,
            ],
            [
                'key' => 'mother_job',
                'label' => 'Pekerjaan Ibu',
                'section' => 'ibu',
                'type' => 'select',
                'required' => true,
                'enabled' => true,
                'options' => [
                    'Ibu Rumah Tangga',
                    'PNS / Polisi / TNI',
                    'Wiraswasta / Pengusaha',
                    'Karyawan Swasta / BUMN',
                    'Guru / Dosen',
                    'Petani / Pekebun',
                    'Lainnya',
                ],
                'placeholder' => 'Pilih Pekerjaan...',
                'is_system' => true,
            ],
            [
                'key' => 'mother_income',
                'label' => 'Penghasilan Ibu per Bulan',
                'section' => 'ibu',
                'type' => 'select',
                'required' => true,
                'enabled' => true,
                'options' => [
                    'Tidak Berpenghasilan',
                    '< Rp 1.000.000',
                    'Rp 1.000.000 - Rp 3.000.000',
                    'Rp 3.000.000 - Rp 5.000.000',
                    'Rp 5.000.000 - Rp 10.000.000',
                    '> Rp 10.000.000',
                ],
                'placeholder' => 'Pilih Kisaran Penghasilan...',
                'is_system' => true,
            ],
            [
                'key' => 'mother_phone',
                'label' => 'Nomor HP / WhatsApp Ibu',
                'section' => 'ibu',
                'type' => 'tel',
                'required' => false,
                'enabled' => true,
                'options' => [],
                'placeholder' => '08xxxxxxxxxx',
                'is_system' => true,
            ],

            // Section 5: Berkas
            [
                'key' => 'birth_certificate',
                'label' => 'Scan Akta Kelahiran / Kartu Keluarga',
                'section' => 'berkas',
                'type' => 'file',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Pilih file PDF / Foto (Maks 5 MB)',
                'is_system' => true,
            ],
            [
                'key' => 'payment_proof',
                'label' => 'Scan / Foto Bukti Pembayaran Pendaftaran',
                'section' => 'berkas',
                'type' => 'file',
                'required' => true,
                'enabled' => true,
                'options' => [],
                'placeholder' => 'Pilih file bukti transfer (Maks 5 MB)',
                'is_system' => true,
            ],
        ];
    }

    /**
     * Get the active form fields schema from settings or defaults.
     */
    public static function getSchema(): array
    {
        $raw = Setting::get('ppdb_form_schema');
        if (! empty($raw)) {
            $decoded = json_decode((string) $raw, true);
            if (is_array($decoded) && count($decoded) > 0) {
                return $decoded;
            }
        }

        return self::getDefaultSchema();
    }

    /**
     * Save schema to settings.
     */
    public static function saveSchema(array $fields): void
    {
        Setting::set('ppdb_form_schema', json_encode(array_values($fields), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'ppdb');
    }

    /**
     * Get only active/enabled fields.
     */
    public static function getActiveFields(): array
    {
        $all = self::getSchema();

        return array_values(array_filter($all, fn ($f) => ! empty($f['enabled'])));
    }

    /**
     * Get active fields grouped by section.
     */
    public static function getActiveFieldsGrouped(): array
    {
        $active = self::getActiveFields();
        $grouped = [];

        foreach ($active as $field) {
            $sec = $field['section'] ?? 'siswa';
            $grouped[$sec][] = $field;
        }

        return $grouped;
    }

    /**
     * Add a new field to schema.
     */
    public static function addField(array $data): array
    {
        $fields = self::getSchema();

        $label = trim($data['label'] ?? 'Kolom Baru');
        $key = ! empty($data['key']) ? Str::slug($data['key'], '_') : 'custom_'.Str::slug($label, '_').'_'.substr(uniqid(), -4);

        // Ensure key is unique
        $existingKeys = array_column($fields, 'key');
        if (in_array($key, $existingKeys)) {
            $key .= '_'.time();
        }

        $options = [];
        if (! empty($data['options'])) {
            if (is_array($data['options'])) {
                $options = $data['options'];
            } else {
                $options = array_values(array_filter(array_map('trim', explode("\n", (string) $data['options']))));
            }
        }

        $newField = [
            'key' => $key,
            'label' => $label,
            'section' => $data['section'] ?? 'tambahan',
            'type' => $data['type'] ?? 'text',
            'required' => ! empty($data['required']),
            'enabled' => true,
            'options' => $options,
            'placeholder' => $data['placeholder'] ?? '',
            'is_system' => false,
        ];

        $fields[] = $newField;
        self::saveSchema($fields);

        return $newField;
    }

    /**
     * Delete / remove a field from the schema.
     */
    public static function deleteField(string $key): bool
    {
        $fields = self::getSchema();
        $filtered = array_values(array_filter($fields, fn ($f) => ($f['key'] ?? '') !== $key));

        if (count($filtered) !== count($fields)) {
            self::saveSchema($filtered);

            return true;
        }

        return false;
    }

    /**
     * Reset schema back to default.
     */
    public static function resetToDefault(): void
    {
        self::saveSchema(self::getDefaultSchema());
    }
}
