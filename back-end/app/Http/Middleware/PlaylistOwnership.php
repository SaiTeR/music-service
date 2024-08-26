<?php

namespace App\Http\Middleware;

use App\Facades\AuthFacade;
use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
class PlaylistOwnership
{
    public function __construct(
        private readonly PlaylistRepositoryInterface $playlistRepository
    )
    {}

    public function handle(Request $request, Closure $next)
    {
        $playlistId = $request->route('playlistId');
        $playlist = $this->playlistRepository->getPlaylistById($playlistId);

        if ($playlist->user_id == AuthFacade::getAuthInfo()->id) {
            return $next($request);
        }

        return response()->json(['message' => 'You are not allowed to interact with this playlist!'],400);
    }
}
