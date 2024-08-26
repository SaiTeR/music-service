<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use App\Models\Playlist;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlaylistRepository implements PlaylistRepositoryInterface
{

    public function getAllPlaylists(): Collection
    {
        return Playlist::where('is_public', 1)->get();
    }

    public function getAllUserPlaylists(int $userId): Collection
    {
        return Playlist::query()->where('user_id', '=', $userId)->get();
    }

    public function getUserPlaylistByName(int $userId, int $playlistName): Collection
    {
        return Playlist::query()
            ->where('user_id', $userId)
            ->where('playlist_name', $playlistName)
            ->get();
    }

    public function getPlaylistById(int $playlistId): ?Playlist
    {
        return Playlist::query()->where('id', '=', $playlistId)->get()->first();
    }

    public function createPlaylist(int $userId, int $playlistName, string $imagePath): int
    {
        $playlist = new Playlist();

        $playlist->user_id = $userId;
        $playlist->playlist_name = $playlistName;
        $playlist->iamge_path = $imagePath;

        $playlist->save();

        return $playlist->id;
    }

    public function updatePlaylistName(int $playlistId, string $newName): bool
    {
        $affected = DB::table('playlists')
            ->where('id', $playlistId)
            ->update(['playlist_name' => $newName]);

        return bool($affected);
    }

    public function updatePlaylistImage($playlistId, string $imagePath): bool
    {
        $affected = DB::table('playlists')
            ->where('id', $playlistId)
            ->update(['image_path' => $imagePath]);

        return bool($affected);
    }

    public function deletePlaylist($playlistId): bool
    {
        $deletedAmount = Playlist::query()->where('id', '=', $playlistId)->delete();

        return bool($deletedAmount);
    }
}
