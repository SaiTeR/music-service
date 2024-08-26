<?php

namespace App\Mappers;

use App\DTO\ArtistDTO;
use App\Models\Artist;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ImageService;
use Illuminate\Support\Collection;

class ArtistMapper
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly ImageService $imageService,
    )
    {}


    public function getArtistDTO(Artist $artist): ArtistDTO
    {
        $owner = $this->userRepository->getById($artist->user_id)->username;
        $image = $this->imageService->getImage($artist->image_path);

        return new ArtistDTO($artist->id, $artist->artist_name, $owner, $artist->monthly_listeners, $image);
    }

    public function getMultipleArtistDTOs(Collection $artists): Collection
    {
        $artistDTOs = new Collection();

        foreach ($artists as $artist) {
            $artistDTOs->add($this->getArtistDTO($artist));
        }

        return $artistDTOs;
    }
}
