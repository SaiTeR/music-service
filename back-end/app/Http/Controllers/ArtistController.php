<?php

namespace App\Http\Controllers;

use App\Facades\AuthFacade;
use App\Http\Requests\ArtistRequest;
use App\Http\Requests\ImageRequest;
use App\Mappers\ArtistMapper;
use App\Repositories\Interfaces\ArtistRepositoryInterface;
use App\Services\Domain\ArtistService;
use Illuminate\Http\JsonResponse;

class ArtistController extends Controller
{
    public function __construct(
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly ArtistService $artistService,
        private readonly ArtistMapper $artistMapper,
    ){}

    public function getAllArtists(): JsonResponse
    {
        $artists = $this->artistRepository->getAllArtists();

        $artistDTOs = $this->artistMapper->getMultipleArtistDTOs($artists);

        return response()->json($artistDTOs);
    }

    public function getArtist(int $artistId): JsonResponse
    {
        $artist = $this->artistRepository->getArtistById($artistId);

        if ($artist) {
            return response()->json($artist);
        } else {
            return response()->json(['message' => 'Artist not found'], 404);
        }
    }
    public function createArtist(ArtistRequest $request): JsonResponse
    {
        $body = $request->body();
        $userId = AuthFacade::getAuthInfo()->id;

        $artistId = $this->artistService->createArist($body, $userId);

        return response()->json($artistId);
    }

    public function updateArtist(ArtistRequest $request, int $artistId): JsonResponse
    {
        $body = $request->body();
        $response = $this->artistRepository->updateArtist($artistId, $body->artistName);

        if ($response) {
            return response()->json($response);
        } else {
            return response()->json(['message' => 'Artist not found'], 404);
        }
    }

    public function updateArtistImage(ImageRequest $request, int $artistId): JsonResponse
    {
        return response()->json($this->artistService->updateArtistImage($request->body(), $artistId));
    }

    public function deleteArtist(int $artistId): JsonResponse
    {
        $artist = $this->artistRepository->getArtistById($artistId);
        if(!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $serviceResponse = $this->artistService->deleteArtist($artist);

        if ($serviceResponse) {
            return response()->json(['message' => 'Artist deleted successfully!']);
        } else {
            return response()->json(['message' => 'Error during Artist deletion!'], 500);
        }
    }
}
