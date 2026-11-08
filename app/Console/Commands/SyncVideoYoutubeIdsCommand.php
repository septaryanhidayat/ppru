<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;

class SyncVideoYoutubeIdsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:sync-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi YouTube ID dari tautan youtube_url (termasuk live streaming, shorts, youtu.be)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Memulai sinkronisasi YouTube ID pada tabel videos...');

        $updated = Video::syncMissingYoutubeIds();

        $this->info("Selesai! {$updated} video berhasil disinkronisasi ID YouTube-nya.");

        return Command::SUCCESS;
    }
}
