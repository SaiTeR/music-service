<?php

namespace App\Services\Domain;

use App\Models\Song;
use App\Repositories\Interfaces\SongRepositoryInterface;
use App\Services\AudioService;
use App\Services\StorageService;
use Illuminate\Support\Facades\Storage;

class SongService
{
    public function __construct(
        private readonly AudioService $audioService,
        private readonly StorageService $storageService,
        private readonly SongRepositoryInterface $songRepository
    )
    {}

    public function deleteSong(Song $song): bool
    {
        $awsResponse = $this->storageService->checkAudio($song->path);
        if(!$awsResponse) {
            return false;
        }

        $this->audioService->deleteAudio($song->path);
        $this->songRepository->deleteSong($song->id);

        return true;
    }
}
