<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaults = [
            'contact_whatsapp' => '0812-7890-1950',
            'contact_whatsapp_label' => 'Sekretariat & Info Pondok',
            'wa_helpdesk_message' => "Assalamu'alaikum Admin Utama PPRU Sakatiga, saya ingin berkonsultasi mengenai informasi pesantren / pendaftaran santri baru...",
            'ppdb_hotline_phone' => '0812-7890-1950',
            'ppdb_hotline_name' => 'Panitia SPMB PPRU',
            'ppdb_hotline_2_phone' => '0812-7890-1950',
            'ppdb_hotline_2_name' => 'Sekretariat Pesantren',
            'ppdb_wa_template' => "Assalamu'alaikum Panitia PSB Pondok Pesantren Raudhatul Ulum Sakatiga, saya ingin konsultasi pendaftaran santri baru.",
            'wa_alumni_article' => '0812-7890-1950',
            'wa_alumni_article_template' => "Assalamu'alaikum Redaksi IKARUS PPRU, saya alumni ingin mengirimkan naskah karya tulis untuk website.",
            'wa_santri_article' => '0812-7890-1950',
            'wa_santri_article_template' => "Assalamu'alaikum Redaksi Web PPRU, saya santri/asatidz ingin mengirimkan naskah karya tulis untuk website.",
            'ptsp_helpdesk_phone' => '0812-7890-1950',
            'ptsp_helpdesk_wa_template' => "Assalamu'alaikum Humas PPRU Sakatiga, saya ingin konsultasi layanan terpadu",
            'wa_layanan_sewa' => '0812-7890-1950',
            'wa_layanan_kerjasama' => '0812-7890-1950',
            'wa_layanan_izin' => '0812-7890-1950',
            'donation_confirm_phone' => '0812-7890-1950',
            'donation_confirm_text' => "Assalamu'alaikum, saya ingin konfirmasi infaq/wakaf untuk Pondok Pesantren Raudhatul Ulum Sakatiga.",
        ];

        foreach ($defaults as $key => $val) {
            if (! Setting::where('key', $key)->exists()) {
                Setting::create([
                    'key' => $key,
                    'value' => $val,
                    'group' => 'whatsapp',
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $newKeys = [
            'contact_whatsapp_label',
            'wa_helpdesk_message',
            'ppdb_wa_template',
            'wa_alumni_article',
            'wa_alumni_article_template',
            'wa_santri_article',
            'wa_santri_article_template',
            'wa_layanan_sewa',
            'wa_layanan_kerjasama',
            'wa_layanan_izin',
        ];

        Setting::whereIn('key', $newKeys)->delete();
    }
};
