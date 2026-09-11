<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SyncDonationSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'donation_bank_1_name' => 'Bank Sumsel Babel Syariah',
            'donation_bank_1_code' => '120',
            'donation_bank_1_rekening' => '',
            'donation_bank_1_holder' => 'DPD PKS KABUPATEN OGAN ILIR',
            'donation_bank_2_name' => 'Bank Syariah Indonesia (BSI)',
            'donation_bank_2_code' => '451',
            'donation_bank_2_rekening' => '',
            'donation_bank_2_holder' => 'DPD PKS KABUPATEN OGAN ILIR',
            'donation_confirm_phone' => '',
            'donation_confirm_text' => "Assalamu'alaikum Bendahara DPD PKS Ogan Ilir, saya telah menyalurkan donasi perjuangan dakwah.",
            'donation_intro_text' => 'Salurkan infaq dan donasi perjuangan dakwah untuk kemaslahatan masyarakat Kabupaten Ogan Ilir melalui rekening resmi DPD PKS Ogan Ilir.',
        ];

        foreach ($settings as $key => $val) {
            Setting::firstOrCreate(
                ['key' => $key],
                ['value' => $val, 'group' => 'general']
            );
        }
    }
}
