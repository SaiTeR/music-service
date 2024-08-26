<?php

namespace App\Http\Middleware;

use App\Facades\AuthFacade;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use Closure;
use Illuminate\Http\Request;

class CheckAlbumPublishStatus
{
    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository)
    {}

    public function handle(Request $request, Closure $next)
    {
        $album = $this->albumRepository->getAlbumById($request->albumId);

        if($album) {
            $userArtistsIds = AuthFacade::getAuthInfo()->artistIds;

            if (in_array($album->artistId, $userArtistsIds) || $album->isPublished) {
                return $next($request);
            }

            return response()->json("",403);
        }
        return response()->json("",404);
    }
}
