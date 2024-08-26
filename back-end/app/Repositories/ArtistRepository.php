<?php

namespace App\Repositories;

use App\Models\Artist;
use App\Repositories\Interfaces\ArtistRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class ArtistRepository implements ArtistRepositoryInterface
{
    public function getAllArtists(): Collection
    {
        return Artist::all();
    }

    public function getArtistById(int $artistId): ?Artist
    {
        return Artist::find($artistId);
    }

    public function getArtistsByUserId(int $userId)
    {
        return Artist::query()->where('user_id', '=', $userId)->get();
    }

    public function createArtist(int $userId, string $artistName, string $imagePath): int
    {
        $artist = new Artist();
        $artist->user_id = $userId;
        $artist->artist_name = $artistName;
        $artist->image_path = $imagePath;

        $artist->save();
        return $artist->id;
    }

    public function updateArtist(int $artistId, string $artistName): bool
    {
        $affected = DB::table('artists')
            ->where('id', $artistId)
            ->update(['artist_name' => $artistName]);

        return bool($affected);
    }

    public function updateArtistImage(int $artistId, string $imagePath): bool
    {
        $affected = DB::table('artists')
            ->where('id', $artistId)
            ->update(['image_path' => $imagePath]);

        return bool($affected);
    }

    public function deleteArtist($artistId): bool
    {
        return bool(Artist::query()->where('id', '=', $artistId)->delete());
    }

}
