<?php

namespace App\Jobs;

use App\Console\Commands\UpdateAlbumsPlaybacks;
use App\Jobs\Options\UpdateAlbumsPlaybacksOptions;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Repositories\Interfaces\SongRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAlbumsPlaybacksChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly UpdateAlbumsPlaybacksOptions $options,
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(AlbumRepositoryInterface $albumRepository, SongRepositoryInterface $songRepository): void
    {
        foreach ($this->options->albumsIds as $albumsId) {
            $albumSongs = $songRepository->getSongsByAlbumId($albumsId);

            $sum = 0;
            foreach ($albumSongs as $song) {
                $sum += $song->playbacks;
            }

            $albumRepository->updateAlbumPlaybacks($albumsId, $sum);
        }
    }
}
