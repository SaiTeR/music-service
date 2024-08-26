<?php

namespace App\Http\Controllers;


use App\Facades\AuthFacade;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\ImageRequest;
use App\Mappers\AlbumMapper;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Repositories\Interfaces\SongRepositoryInterface;
use App\Services\Domain\AlbumService;
use Illuminate\Http\JsonResponse;

class AlbumController extends Controller
{
    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly SongRepositoryInterface $songRepository,
        private readonly AlbumService $albumService,
        private readonly AlbumMapper $albumMapper,
    ){}

    public function getAllArtistAlbums(int $artistId): JsonResponse
    {
        $albums = $this->albumRepository->getAlbumsByArtistId($artistId);
        if(!$albums) {
            return response()->json(['message' => 'This artist do not have albums'], 404);
        }

        return response()->json($albums);
    }

    public function getAllAlbums(): JsonResponse
    {
        $albums = $this->albumRepository->getAllAlbums();
        if(!$albums) {
            return response()->json(['message' => 'Albums not found'], 404);
        }

        $albumDTOs = $this->albumMapper->getMultipleAlbumDTOs($albums);

        return response()->json($albumDTOs);
    }

    public function getAlbum(int $albumId): JsonResponse
    {
        $album = $this->albumRepository->getAlbumById($albumId);
        if(!$album){
            return response()->json(['message' => 'Album with this ID not found'], 404);
        }

        return response()->json($album);
    }

    public function getAlbumWithSongs(int $albumId): JsonResponse
    {
        $album = $this->albumRepository->getAlbumById($albumId);
        if(!$album){
                return response()->json(['message' => 'Album with this ID not found'], 404);
        }
        $songs = $this->songRepository->getSongsByAlbumId($albumId);

        $albumDTO = $this->albumMapper->getAlbumWithSongsDTO($album, $songs);
        return response()->json($albumDTO);
    }

    public function createAlbum(AlbumRequest $request, int $artistId): JsonResponse
    {
        $albumId = $this->albumService->createAlbum($request->body(), $artistId);

        return response()->json($albumId);
    }

    public function updateAlbum(AlbumRequest $request, int $artistId, int $albumId): JsonResponse
    {
        $body = $request->body();

        $response = $this->albumRepository->updateAlbum(
            $albumId,
            $body->albumName,
            $body->releaseYear,
            $body->isExplicit,
            $body->albumType,
            $body->genre
        );

        if ($response) {
            return response()->json($response);
        } else {
            return response()->json(['message' => 'Album not found'], 404);
        }
    }

    public function updateAlbumImage(ImageRequest $request, int $albumId)
    {
        return response()->json($this->albumService->updateAlbumImage($request->body(), $albumId));
    }

    public function deleteAlbum(int $artistId, int $albumId): JsonResponse
    {
        $album = $this->albumRepository->getAlbumById($albumId);

        if(!$album) {
            return response()->json(['message' => 'Album with ID = '. $albumId . ' not found!'], 404);
        }

        $serviceResponse = $this->albumService->deleteAlbum($album);

        if ($serviceResponse) {
            return response()->json(['message' => 'Album was deleted successfully!']);
        } else {
            return response()->json(['message' => 'Error during Album deletion!'], 500);
        }
    }
}
