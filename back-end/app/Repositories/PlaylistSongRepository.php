<?php

namespace App\Repositories;

use App\Models\PlaylistSong;
use App\Repositories\Interfaces\PlaylistSongRepositoryInterface;

class PlaylistSongRepository implements PlaylistSongRepositoryInterface
{

    public function addSong(int $playlistId, int $songId): int
    {
        $pair = new PlaylistSong();

        $pair->playlist_id = $playlistId;
        $pair->song_id = $songId;

        $pair->save();

        return $pair->id;
    }

    public function deleteSong(int $playlistId, int $songId): bool
    {
        $deletedAmount = PlaylistSong::query()
            ->where('playlist_id', '=', $playlistId)
            ->where('song_id', '=',$songId)
            ->delete();

        return bool($deletedAmount);
    }

    public function deletePlaylistConnectedRows(int $playlistId): bool
    {
        return bool(PlaylistSong::query()->where('playlist_id', $playlistId)->delete());
    }
}
