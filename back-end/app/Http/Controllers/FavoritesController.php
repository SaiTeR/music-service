<?php

namespace App\Http\Controllers;

use App\Facades\AuthFacade;
use App\Http\Requests\FavoriteRequest;
use App\Queries\Interfaces\FavoritesQueryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavoritesController extends Controller
{
    public function __construct(
        private readonly FavoritesQueryInterface $favoritesQuery,
    )
    {}

    public function getFavoriteSongs(): JsonResponse
    {
        $songs = $this->favoritesQuery->getSongs(AuthFacade::getAuthInfo()->id);
        if ($songs) {
            return response()->json($songs);
        }

        return response()->json("You don't liked any songs yet");
    }

    public function getFavoriteAlbums(): JsonResponse
    {
        $albums = $this->favoritesQuery->getAlbums(AuthFacade::getAuthInfo()->id);
        if ($albums) {
            return response()->json($albums);
        }

        return response()->json("You don't liked any albums yet");
    }

    public function getFavoriteArtists(): JsonResponse
    {
        $artists = $this->favoritesQuery->getArtists(AuthFacade::getAuthInfo()->id);
        if ($artists) {
            return response()->json($artists);
        }

        return response()->json("You don't liked any artists yet");
    }
    public function likeSong(FavoriteRequest $request): JsonResponse
    {
        $id = $this->favoritesQuery->addSong(AuthFacade::getAuthInfo()->id, $request->body()->id);
        return response()->json($id);
    }

    public function dislikeSong(FavoriteRequest $request): JsonResponse
    {
        $wasDisliked = $this->favoritesQuery->deleteSong(AuthFacade::getAuthInfo()->id, $request->body()->id);
        if($wasDisliked) {
            return response()->json("Song was disliked successfully!");
        }

        return response()->json("Song wasn't disliked");
    }

    public function likeArtist(FavoriteRequest $request): JsonResponse
    {
        $id = $this->favoritesQuery->addSong(AuthFacade::getAuthInfo()->id, $request->body()->id);
        return response()->json($id);
    }

    public function dislikeArtist(FavoriteRequest $request): JsonResponse
    {
        $wasDisliked = $this->favoritesQuery->deleteSong(AuthFacade::getAuthInfo()->id, $request->body()->id);
        if($wasDisliked) {
            return response()->json("Artist was disliked successfully!");
        }

        return response()->json("Artist wasn't disliked");
    }

    public function likeAlbum(FavoriteRequest $request): JsonResponse
    {
        $id = $this->favoritesQuery->addSong(AuthFacade::getAuthInfo()->id, $request->body()->id);
        return response()->json($id);
    }

    public function dislikeAlbum(FavoriteRequest $request): JsonResponse
    {
        $wasDisliked = $this->favoritesQuery->deleteSong(AuthFacade::getAuthInfo()->id, $request->body()->id);
        if($wasDisliked) {
            return response()->json("Album was disliked successfully!");
        }

        return response()->json("Album wasn't disliked");
    }
}
