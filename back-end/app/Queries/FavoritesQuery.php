<?php

namespace App\Queries;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Favorites\UserAlbum;
use App\Models\Favorites\UserArtist;
use App\Models\Favorites\UserSong;
use App\Models\Song;
use App\Queries\Interfaces\FavoritesQueryInterface;
use Illuminate\Support\Collection;

class FavoritesQuery implements FavoritesQueryInterface
{

    public function addSong(int $userId, int $songId): int
    {
        $pair = new UserSong();

        $pair->user_id = $userId;
        $pair->song_id = $songId;

        $pair->save();

        return $pair->id;
    }

    public function deleteSong(int $userId, int $songId): bool
    {
        $deletedAmount = UserSong::query()
            ->where('user_id', '=', $userId)
            ->where('song_id', '=', $songId)
            ->delete();

        return bool($deletedAmount);
    }

    public function addArtist(int $userId, int $artistId): int
    {
        $pair = new UserAlbum();

        $pair->user_id = $userId;
        $pair->artist_id = $artistId;

        $pair->save();

        return $pair->id;
    }

    public function deleteArtist(int $userId, int $artistId): bool
    {
        $deletedAmount = UserSong::query()
            ->where('user_id', '=', $userId)
            ->where('artist_id', '=', $artistId)
            ->delete();

        return bool($deletedAmount);
    }

    public function addAlbum(int $userId, int $albumId): int
    {
        $pair = new UserAlbum();

        $pair->user_id = $userId;
        $pair->album_id = $albumId;

        $pair->save();

        return $pair->id;
    }

    public function deleteAlbum(int $userId, int $albumId): bool
    {
        $deletedAmount = UserSong::query()
            ->where('user_id', '=', $userId)
            ->where('album_id', '=', $albumId)
            ->delete();

        return bool($deletedAmount);
    }

    public function getSongs(int $userId): Collection
    {
        $songIds = UserSong::query()
            ->where('user_id', $userId)
            ->pluck('song_id');

        return Song::query()
            ->whereIn('id', $songIds)
            ->get();
    }

    public function getArtists(int $userId): Collection
    {
        $artistIds = UserArtist::query()
            ->where('user_id', $userId)
            ->pluck('artist_id');

        return Artist::query()
            ->whereIn('id', $artistIds)
            ->get();

    }

    public function getAlbums(int $userId): array
    {
        $albumIds = UserAlbum::query()
            ->where('user_id', $userId)
            ->pluck('album_id');

        return Album::query()
            ->whereIn('id', $albumIds)
            ->get();

    }
}
