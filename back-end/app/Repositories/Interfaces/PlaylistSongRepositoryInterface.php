<?php

namespace App\Repositories\Interfaces;

interface PlaylistSongRepositoryInterface
{
    public function addSong(int $playlistId, int $songId): int;
    public function deleteSong(int $playlistId, int $songId): bool;

    public function deletePlaylistConnectedRows(int $playlistId): bool;
}
