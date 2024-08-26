<?php

namespace App\Services\Domain;

use App\Http\RequestModels\ArtistModel;
use App\Http\RequestModels\ImageModel;
use App\Models\Artist;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Repositories\Interfaces\ArtistRepositoryInterface;
use App\Services\ImageService;
use Nette\Utils\Image;

class ArtistService
{
    public function __construct(
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly ImageService $imageService,

        private readonly AlbumService $albumService
    )
    {}

    public function deleteArtist(Artist $artist): bool
    {
        $albums = $this->albumRepository->getAlbumsByArtistId($artist->id);

        if ($albums->isNotEmpty()) {
            foreach ($albums as $album) {
                $this->albumService->deleteAlbum($album);
            }
        }

        return $this->artistRepository->deleteArtist($artist->id);
    }

    public function createArist(ArtistModel $model, int $userId): int
    {
        $imagePath = null;
        if($model->image !== null) {
            $imagePath = $this->imageService->saveImage($model->image);
        }

        return $this->artistRepository->createArtist($userId, $model->artistName, $imagePath);
    }

    public function updateArtistImage(ImageModel $model, int $artistId): bool
    {
        $artist = $this->artistRepository->getArtistById($artistId);

        $oldImagePath = $artist->image_path;
        if ($oldImagePath != "image/default-artist.png") {
            $this->imageService->deleteImage($artist->image_path);
        }

        $newImagePath = $this->imageService->saveImage($model->image);

        return $this->artistRepository->updateArtistImage($artistId, $newImagePath);
    }
}
