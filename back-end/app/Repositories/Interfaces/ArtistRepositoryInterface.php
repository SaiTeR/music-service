<?php

namespace App\Repositories\Interfaces;

use App\Models\Artist;
use Illuminate\Support\Collection;

interface ArtistRepositoryInterface
{
    public function getAllArtists(): Collection;
    public function getArtistById(int $artistId): ?Artist;

    public function getArtistsByUserId(int $userId);
    public function createArtist(int $userId, string $artistName, string $imagePath): int;
    public function updateArtist(int $artistId, string $artistName): bool;
    public function updateArtistImage(int $artistId, string $imagePath): bool;
    public function deleteArtist(int $artistId): bool;
}
