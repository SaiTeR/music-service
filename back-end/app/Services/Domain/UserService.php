<?php

namespace App\Services\Domain;

use App\Facades\AuthFacade;
use App\Http\RequestModels\ImageModel;
use App\Models\User;
use App\Repositories\Interfaces\ArtistRepositoryInterface;
use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly PlaylistRepositoryInterface $playlistRepository,

        private readonly ArtistService $artistService, // Дочерняя сущность
        private readonly PlaylistService $playlistService // Дочерняя сущность
    ) {}


    public function deleteUser(User $user): bool
    {
        $artists = $this->artistRepository->getArtistsByUserId($user->id);
        $playlists = $this->playlistRepository->getAllUserPlaylists($user->id);

        if($artists->isNotEmpty()) {
            foreach ($artists as $artist) {
                $this->artistService->deleteArtist($artist);
            }
        }
        if($playlists->isNotEmpty()) {
            foreach ($playlists as $playlist) {
                $this->playlistService->deletePlaylist($playlist);
            }
        }

        return $this->userRepository->deleteUser($user->id);
    }

    public function updateUserImage(ImageModel $model)
    {
        $userId = AuthFacade::getAuthInfo()->id;
        $user = $this->userRepository->getById($userId);

        $oldImagePath = $user->image_path;
        if ($oldImagePath != "image/default-avatar.png") {
            $this->imageService->deleteImage($user->image_path);
        }

        $newImagePath = $this->imageService->saveImage($model->image);

        return $this->userRepository->updateImage($userId, $newImagePath);
    }
}
