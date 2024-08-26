<?php

namespace App\Mappers;

use App\DTO\SongDTO;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Services\AudioService;
use App\Services\ImageService;
use Illuminate\Support\Collection;

class SongMapper
{
    public function __construct(
        private readonly AudioService $audioService,
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly ImageService $imageService
    )
    {}

    public function getMultipleSongsDTO($songs): Collection
    {
        $songDTOs = new Collection();

        foreach ($songs as $song) {
            $songDTO = $this->getSongDTO($song);
            $songDTOs[] = $songDTO;
        }

        return  $songDTOs;
    }

    public function getSongDTO($song): SongDTO
    {
        $audioUrl = $this->audioService->getAudio($song->path);

        $album = $this->albumRepository->getAlbumById($song->album_id);
        $imageUrl = $this->imageService->getImage($album->image_path);

        return new SongDTO(
            $song->id,
            $song->song_name,
            $song->duration,
            $song->is_explicit,
            $song->song_type,
            $audioUrl,
            $imageUrl
        );
    }
}
