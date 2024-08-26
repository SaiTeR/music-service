<?php

namespace App\Services\Domain;

use App\Http\RequestModels\ImageModel;
use App\Http\RequestModels\PlaylistModel;
use App\Models\Playlist;
use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use App\Repositories\Interfaces\PlaylistSongRepositoryInterface;

class PlaylistService
{
    public function __construct(
        private readonly PlaylistRepositoryInterface $playlistRepository,
        private readonly PlaylistSongRepositoryInterface $playlistSongRepository,
    ) {}


    public function deletePlaylist(Playlist $playlist): bool
    {
        $this->playlistSongRepository->deletePlaylistConnectedRows($playlist->id);

        return ($this->playlistRepository->deletePlaylist($playlist->id));
    }

    public function createPlaylist(PlaylistModel $model, int $userId)
    {
        $imagePath = null;
        if($model->image !== null) {
            $imagePath = $this->imageService->saveImage($model->image);
        }

        return $this->playlistRepository->createPlaylist($userId, $model->playlistName, $imagePath);
    }

    public function updatePlaylistImage(ImageModel $model, int $playlistId)
    {
        $playlist = $this->playlistRepository->getPlaylistById($playlistId);

        $oldImagePath = $playlist->image_path;
        if ($oldImagePath != "image/default-playlist.png") {
            $this->imageService->deleteImage($playlist->image_path);
        }

        $newImagePath = $this->imageService->saveImage($model->image);

        return $this->playlistRepository->updatePlaylistImage($playlistId, $newImagePath);
    }
}
