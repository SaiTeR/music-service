<?php

namespace App\Repositories\Interfaces;

use App\Models\Playlist;
use Illuminate\Support\Collection;

interface PlaylistRepositoryInterface
{
    public function getAllUserPlaylists(int $userId): Collection;
    public function getUserPlaylistByName(int $userId, int $playlistName): Collection;

    public function getAllPlaylists(): Collection;
    public function getPlaylistById(int $playlistId): ?Playlist;

    public function createPlaylist(int $userId, int $playlistName, string $imagePath): int;
    public function updatePlaylistName(int $playlistId, string $newName): bool;
    public function updatePlaylistImage(int $playlistId, string $imagePath): bool;
    public function deletePlaylist(int $playlistId): bool;

}
