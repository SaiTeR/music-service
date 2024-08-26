<?php

namespace App\Services\Domain;

use App\Http\RequestModels\AlbumModel;
use App\Http\RequestModels\ArtistModel;
use App\Http\RequestModels\ImageModel;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Services\ImageService;

class AlbumService
{
    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly SongService $songService,
        private readonly ImageService $imageService
    )
    {}

    public function deleteAlbum($album): bool
    {
        $songs = $this->songRepository->getSongsByAlbumId($album->id);

        if ($songs->isNotEmpty()) {
            foreach ($songs as $song) {
                $this->songService->deleteSong($song);
            }
        }
        $this->imageService->deleteImage($album->image_path);
        return $this->albumRepository->deleteAlbum($album->id);
    }

    public function createAlbum(AlbumModel $model, int $artistId)
    {
        $imagePath = null;
        if($model->image !== null) {
            $imagePath = $this->imageService->saveImage($model->image);
        }

        return $this->albumRepository->createAlbum(
            $artistId,
            $model->albumName,
            $model->releaseYear,
            $model->isExplicit,
            $model->albumType,
            $model->genre,
            $imagePath
        );
    }

    public function updateAlbumImage(ImageModel $model, int $albumId)
    {
        $album = $this->albumRepository->getAlbumById($albumId);

        $oldImagePath = $album->image_path;
        if ($oldImagePath != "image/default-album.png") {
            $this->imageService->deleteImage($album->image_path);
        }

        $newImagePath = $this->imageService->saveImage($model->image);

        return $this->albumRepository->updateAlbumImage($albumId, $newImagePath);
    }
}
