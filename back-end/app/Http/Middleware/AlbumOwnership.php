<?php

namespace App\Http\Middleware;

use App\Facades\AuthFacade;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use Closure;
use Illuminate\Http\Request;

class AlbumOwnership
{
    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository,
    )
    {}

    public function handle(Request $request, Closure $next)
    {
        $albumId = $request->route('albumId');
        $album = $this->albumRepository->getAlbumById($albumId);

        if(!$album) {
            return response()->json(['message' => 'Album not fond!'], 404);
        }

        if(!in_array($album->artist_id, AuthFacade::getAuthInfo()->artistIds)) {
            return response()->json(['message' => 'You do not own this album'], 403);
        }

        return $next($request);
    }
}
