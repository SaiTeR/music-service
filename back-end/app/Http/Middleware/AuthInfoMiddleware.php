<?php

namespace App\Http\Middleware;


use App\Models\TokenPayloadModel;
use App\Services\Jwt\TokenService;
use Closure;
use Illuminate\Http\Request;

class AuthInfoMiddleware
{
    public function __construct(
        private readonly TokenService $tokenService,
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authInfo = $this->getAuthInfo($request);
        $request->attributes->add(['authInfo' => $authInfo]);

        return $next($request);
    }

    private function getAuthInfo(Request $request): ?TokenPayloadModel
    {
        $token = $this->tokenService->getTokenFromRequest($request);
        if (!$token) {
            return null;
        }
        $tokenPayload = $this->tokenService->getTokenPayload($token);

        if(!$tokenPayload) {
            return null;
        }

        return $tokenPayload;
    }
}
