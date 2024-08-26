<?php

namespace App\Mappers;

use App\DTO\PlaylistDTO;
use App\Models\Playlist;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ImageService;
use Illuminate\Support\Collection;

class PlaylistMapper
{
    public function __construct(
        private readonly ImageService $imageService,
        private readonly UserRepositoryInterface $userRepository
    )
    {}


    public function getPlaylistDTO(Playlist $playlist): PlaylistDTO
    {
        $imageUrl = $this->imageService->getImage($playlist->image_path);
        $ownerName = $this->userRepository->getById($playlist->user_id)->username;

        return new PlaylistDTO(
            $playlist->id,
            $playlist->playlist_name,
            $ownerName,
            $playlist->songs_amount,
            $imageUrl
        );
    }

    public function getMultiplePlaylistDTO(Collection $playlists): Collection
    {
        $playlistDTOs = new Collection();

        foreach ($playlists as $playlist) {
            $playlistDTOs->add($this->getPlaylistDTO($playlist));
        }

        return $playlistDTOs;
    }
}
