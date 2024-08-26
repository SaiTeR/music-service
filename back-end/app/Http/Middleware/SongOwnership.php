<?php

namespace App\Http\Middleware;

use App\Facades\AuthFacade;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Repositories\Interfaces\SongRepositoryInterface;
use Closure;
use Illuminate\Http\Request;

class SongOwnership
{
    public function __construct(
        private readonly SongRepositoryInterface $songRepository
    )
    {}

    public function handle(Request $request, Closure $next)
    {
        $songId = $request->route('songId');
        $song = $this->songRepository->getSongById($songId);

        if(!$song) {
            return response()->json(['message' => 'Song not fond!'], 404);
        }

        if(!in_array($song->artist_id, AuthFacade::getAuthInfo()->artistIds)) {
            return response()->json(['message' => 'You do not own this song'], 403);
        }

        return $next($request);
    }
}
