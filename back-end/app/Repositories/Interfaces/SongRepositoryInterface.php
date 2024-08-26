<?php

namespace App\Repositories\Interfaces;

use App\Models\Song;
use Illuminate\Support\Collection;

interface SongRepositoryInterface
{
    public function getSongsByPlaylistId(int $playlistId): Collection;
    public function getSongsByAlbumId(int $albumId): Collection;
    public function getSongById(int $songId): ?Song;
    public function deleteSong(int $songId): bool;
    public function createSong(
        int $artistID,
        int $albumID,
        string $songName,
        string $duration,
        bool $isExplicit,
        string $songType,
        string $filePath
    ): int;

    public function listenToSong(int $songId): void;
}
