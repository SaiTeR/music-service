<?php

namespace App\Services;

use App\Repositories\AlbumRepository;
use App\Repositories\SongRepository;
use Illuminate\Http\UploadedFile;

class AudioService
{
    public function __construct(
        private readonly AlbumRepository $albumRepository,
        private readonly SongRepository $songRepository,

        private readonly StorageService $storageService
    ) {}


    public function saveAudio(int $artistId, int $albumId, string $songName, string $duration, bool $isExplicit, string $songType, UploadedFile $file): int
    {
        $album = $this->albumRepository->getAlbumById($albumId);

        $filePath = $this->storageService->storeAudio($album->cdn_folder_id, $file);

        return $this->songRepository->createSong($artistId, $albumId, $songName, $duration, $isExplicit, $songType, $filePath);
    }

    public function getAudio(string $path): string
    {
        return $this->storageService->getFileUrl('audio', $path);
    }

    public function deleteAudio(string $path): bool
    {
        return $this->storageService->removeFile('audio', $path);
    }
}
