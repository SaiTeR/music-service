<?php

namespace App\Mappers;

use App\DTO\AlbumDTO;
use App\DTO\AlbumWithSongsDTO;
use App\Models\Album;
use App\Repositories\Interfaces\ArtistRepositoryInterface;
use App\Services\ImageService;
use Illuminate\Support\Collection;

class AlbumMapper
{
    public function __construct(
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly ImageService $imageService
    )
    {}


    public function getAlbumDTO(Album $album): AlbumDTO
    {
        $artist = $this->artistRepository->getArtistById($album->artist_id);
        $imageUrl = $this->imageService->getImage($album->image_path);

        return new AlbumDTO(
            $album->id,
            $album->album_name,
            $artist->artist_name,
            $album->release_year,
            $album->is_explicit,
            $album->album_type,
            $album->genre,
            $album->playbacks,
            $imageUrl
        );
    }

    public function getMultipleAlbumDTOs(Collection $albums): Collection
    {
        $albumDTOs = new Collection();

        foreach ($albums as $album) {
            $albumDTOs->add($this->getAlbumDTO($album));
        }

        return $albumDTOs;
    }
}
