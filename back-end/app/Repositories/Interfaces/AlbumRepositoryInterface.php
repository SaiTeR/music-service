<?php

namespace App\Repositories\Interfaces;

use App\Models\Album;
use Illuminate\Support\Collection;

interface AlbumRepositoryInterface
{
    public function getAllAlbums(): Collection;
    public function getAllAlbumsIds(): Collection;
    public function updateAlbumPlaybacks(int $id, int $playbacks): void;
    public function getAlbumById(int $id): ?Album;
    public function getAlbumsByArtistId(int $artistId): Collection;
    public function createAlbum(
        int $artistId,
        string $albumName,
        string $releaseYear,
        bool $isExplicit,
        string $albumType,
        string $genre,
        string $imagePath
    ): int;

    public function updateAlbum(
        int $id,
        string $albumName,
        string $releaseYear,
        bool $isExplicit,
        string $albumType,
        string $genre,
    ): bool;
    public function updateAlbumImage(int $id, string $imagePath): bool;

    public function deleteAlbum(int $id): bool;

}
