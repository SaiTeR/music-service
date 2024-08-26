<?php

namespace App\Console\Commands;

use App\Jobs\Options\UpdateAlbumsPlaybacksOptions;
use App\Jobs\UpdateAlbumsPlaybacksChunkJob;
use App\Repositories\AlbumRepository;
use AWS\CRT\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class UpdateAlbumsPlaybacks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-albums-playbacks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates album`s playbacks count, summing all connected songs` playbacks';

    /**
     * Execute the console command.
     */
    public function __construct(private readonly AlbumRepository $albumRepository)
    {
        parent::__construct();
    }


    public function handle()
    {
        $albumIdsToUpdatePlaybacks = $this->albumRepository->getAllAlbumsIds();

        foreach($albumIdsToUpdatePlaybacks->chunk(100) as $chunk) {
            UpdateAlbumsPlaybacksChunkJob::dispatch(new UpdateAlbumsPlaybacksOptions($chunk))
                ->onQueue('default');
        }
    }
}
