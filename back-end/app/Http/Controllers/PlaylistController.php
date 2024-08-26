<?php

namespace App\Http\Controllers;

use App\Facades\AuthFacade;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\PlaylistRequest;
use App\Mappers\PlaylistMapper;
use App\Mappers\SongMapper;
use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use App\Repositories\Interfaces\PlaylistSongRepositoryInterface;
use App\Repositories\Interfaces\SongRepositoryInterface;
use App\Services\Domain\PlaylistService;
use App\Services\Domain\SongService;
use Illuminate\Http\JsonResponse;

class PlaylistController extends Controller
{
    public function __construct(
        private readonly PlaylistRepositoryInterface $playlistRepository,
        private readonly PlaylistSongRepositoryInterface $playlistSongRepository,
        private readonly SongRepositoryInterface $songRepository,
        private readonly PlaylistMapper $playlistMapper,
        private readonly PlaylistService $playlistService,
        private readonly SongMapper $songMapper,
    ){}

    public function getAllPlaylists(): JsonResponse
    {
        $playlists = $this->playlistRepository->getAllPlaylists();
        $playlistDTOs = $this->playlistMapper->getMultiplePlaylistDTO($playlists);

        return response()->json($playlistDTOs);
    }
    public function getPlaylist(int $playlistId): JsonResponse
    {
        $playlist = $this->playlistRepository->getPlaylistById($playlistId);
        $playlistDTO = $this->playlistMapper->getPlaylistDTO($playlist);

        return response()->json($playlistDTO);
    }
    public function getUserPlaylists(): JsonResponse
    {
        $playlists = $this->playlistRepository->getAllUserPlaylists(AuthFacade::getAuthInfo()->id);
        $playlistDTOs = $this->playlistMapper->getMultiplePlaylistDTO($playlists);

        return response()->json($playlistDTOs);
    }

    public function createPlaylist(PlaylistRequest $request): JsonResponse
    {
        $playlistId = $this->playlistService->createPlaylist($request->body(), AuthFacade::getAuthInfo()->id);

        return response()->json($playlistId);
    }



    public function updatePlaylist(PlaylistRequest $request, int $playlistId): JsonResponse // Обновление информации о плейлисте (имя), песни не затрагивает
    {
        $playlistId = $this->playlistRepository->updatePlaylistName($request->body()->playlistName, $playlistId);

        if($playlistId) {
            return response()->json($playlistId);
        } else {
            return response()->json(['message' => 'Playlist not found'],404);
        }
    }

    public function updatePlaylistImage(ImageRequest $request, int $playlistId): JsonResponse
    {
        return response()->json($this->playlistService->updatePlaylistImage($request->body(), $playlistId));
    }

    public function deletePlaylist(int $playlistId): JsonResponse
    {
        $playlist = $this->playlistRepository->getPlaylistById($playlistId);

        if(!$playlist) {
            return response()->json(['message' => 'Playlist not found'], 404);
        }

        $serviceResponse = $this->playlistService->deletePlaylist($playlist);

        if($serviceResponse) {
            return response()->json(['message' => 'Playlist was deleted successfully!']);
        } else {
            return response()->json(['message' => 'Error during Playlist deletion!'], 500);
        }
    }

    public function getSongs(int $playlistId): JsonResponse
    {
        $songs = $this->songRepository->getSongsByPlaylistId($playlistId);
        $songsDTOs = $this->songMapper->getMultipleSongsDTO($songs);

        return response()->json($songsDTOs);
    }

    public function addSongToPlaylist(int $playlistId, int $songId): JsonResponse
    {
        return response()->json($this->playlistSongRepository->addSong($playlistId, $songId));
    }

    public function deleteSongFromPlaylist(int $playlistId, int $songId): JsonResponse
    {
        $response = $this->playlistSongRepository->deleteSong($playlistId, $songId);

        if($response) {
            return response()->json(['message' => 'Song was deleted from playlist successfully!']);
        }

        return response()->json(['message' => 'Song not found in this playlist!'], 404);
    }
}
