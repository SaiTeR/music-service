<?php

namespace App\Http\Controllers;

use App\DTO\SongDTO;
use App\Facades\AuthFacade;
use App\Http\Requests\SongRequest;
use App\Mappers\SongMapper;
use App\Repositories\Interfaces\SongRepositoryInterface;
use App\Services\AudioService;
use App\Services\Domain\SongService;
use Illuminate\Http\JsonResponse;

class SongController extends Controller
{
    public function __construct(
        private readonly AudioService $audioService ,
        private readonly SongRepositoryInterface $songRepository,
        private readonly SongService $songService,
    ){}

    public function uploadSong(SongRequest $request, int $artistId, int $albumId): JsonResponse
    {
        $body = $request->body();

        $songId = $this->audioService->saveAudio(
            $artistId,
            $albumId,
            $body->songName,
            $body->duration,
            $body->isExplicit,
            $body->songType,
            $body->file
        );

        return response()->json($songId);
    }

//    public function updateSong(SongRequest $request, int $artistId, int $albumId): JsonResponse
//    {
//        return
//    }

    public function deleteSong(int $songId): JsonResponse
    {
        $song = $this->songRepository->getSongById($songId);
        if(!$song) {
            return response()->json(['message' => 'Song not found!'], 404);
        }

        $deleteResponse = $this->songService->deleteSong($song);
        if ($deleteResponse) {
            return response()->json(['message' => 'Song was deleted successfully!']);
        } else {
            return response()->json(['message' => 'Error during Song deletion!'], 500);
        }
    }


    public function listenToSong(int $songId): JsonResponse
    {
        return response()->json($this->songRepository->listenToSong($songId));
    }
}
