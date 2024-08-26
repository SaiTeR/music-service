<?php

namespace App\Http\Middleware;

use App\Facades\AuthFacade;
use Closure;
use Illuminate\Http\Request;

class ArtistOwnership
{
    public function handle(Request $request, Closure $next)
    {
        if(!in_array($request->route('artistId'), AuthFacade::getAuthInfo()->artistIds)) {
            return response()->json(['message' => 'You do not own this artist'], 403);
        }

        return $next($request);
    }
}
