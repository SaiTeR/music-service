<?php

namespace App\Repositories;

use App\Models\Album;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class AlbumRepository implements AlbumRepositoryInterface
{

    public function getAllAlbums(): Collection
    {
        return Album::where('is_published', 1)->get();
    }

    public function getAllAlbumsIds(): Collection
    {
        return Album::pluck('id');
    }

    public function updateAlbumPlaybacks(int $id, int $playbacks): void
    {
        DB::table('albums')
            ->where('id', $id)
            ->update(['playbacks' => $playbacks]);
    }
    public function getAlbumById(int $id): ?Album
    {
        return Album::query()->where('id', '=', $id)->first();
    }

    public function getAlbumsByArtistId(int $artistId): Collection
    {
        return Album::query()->where('artist_id', '=', $artistId)->get();
    }

    public function createAlbum(
        int $artistId,
        string $albumName,
        string $releaseYear,
        bool $isExplicit,
        string $albumType,
        string $genre,
        string $imagePath): int
    {
        $album = new Album();

        $album->artist_id = $artistId;
        $album->album_name = $albumName;
        $album->release_year = $releaseYear;
        $album->is_explicit = $isExplicit;
        $album->album_type = $albumType;
        $album->genre = $genre;
        $album->cdn_folder_id = uniqid(more_entropy: true);
        $album->image_path = $imagePath;

        $album->save();

        return $album->id;
    }

    public function updateAlbum(
        int $id,
        string $albumName,
        string $releaseYear,
        bool $isExplicit,
        string $albumType,
        string $genre
    ): bool
    {
        $affected = DB::table('albums')
            ->where('id', $id)
            ->update([
                'album_name' => $albumName,
                'release_year' => $releaseYear,
                'is_explicit' => $isExplicit,
                'album_type' => $albumType,
                'genre' => $genre,
            ]);

        return bool($affected);
    }

    public function updateAlbumImage(int $id, string $imagePath): bool
    {
        $affected = DB::table('albums')
            ->where('id', $id)
            ->update([
                'image_path' => $imagePath
            ]);

        return bool($affected);
    }

    public function deleteAlbum($id): bool
    {
        return bool(Album::query()->where('id', '=', $id)->delete());
    }

}
