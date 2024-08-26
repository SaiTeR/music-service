<?php

namespace App\Repositories;

use App\Models\PlaylistSong;
use App\Models\Song;
use App\Repositories\Interfaces\SongRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SongRepository implements SongRepositoryInterface
{

    public function getSongsByPlaylistId(int $playlistId): Collection
    {
        $songIds = PlaylistSong::query()
            ->where('playlist_id', '=', $playlistId)
            ->pluck('song_id');

        return Song::whereIn('id', $songIds)->get();
    }
    public function getSongsByAlbumId(int $albumId): Collection
    {
        return Song::query()->where('album_id', '=', $albumId)->get();
    }

    public function getSongById(int $songId): ?Song
    {
        return Song::find($songId);
    }


    public function createSong(int $artistID, int $albumID, string $songName, string $duration,  bool $isExplicit, string $songType, string $filePath): int
    {
        $song = new Song();

        $song->artist_id = $artistID;
        $song->album_id = $albumID;
        $song->song_name = $songName;
        $song->duration = $duration;
        $song->is_explicit = $isExplicit;
        $song->song_type = $songType;
        $song->path = $filePath;

        $song->save();

        return $song->id;
    }

    public function deleteSong(int $songId): bool
    {
        $deletedAmount = Song::query()->where('id', '=', $songId)->delete();

        return bool($deletedAmount);
    }

    public function listenToSong(int $songId): void
    {
        DB::table('songs')
            ->where('id', $songId)
            ->increment('playbacks');
    }
}
