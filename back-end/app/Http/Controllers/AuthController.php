<?php

namespace App\Http\Controllers;


use App\Facades\AuthFacade;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Jwt\TokenService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly TokenService        $tokenService
    ) {
    }


    public function signup(SignupRequest $request): JsonResponse
    {
        $data = $request->body();

        $user = $this->userRepository->createUser(
            $data->login,
            Hash::make($data->password),
            $data->email,
            $data->username
        );

        $token = $this->tokenService->createToken($user);
        return $this->respondWithToken($token);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->body();

        $user = $this->userRepository->getUserByLogin($credentials->login);
        if (!Hash::check($credentials->password, $user->password)) {
            return response()->json([],403);
        }

        $token = $this->tokenService->createToken($user);

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponse
    {
        $tokenPayload = AuthFacade::getAuthInfo();
        return response()->json($tokenPayload);
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $this->tokenService->getTokenFromRequest($request);
        $this->tokenService->logoutByToken($token);

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function refresh(Request $request): JsonResponse
    {
        $token = $this->tokenService->getTokenFromRequest($request);
        $newToken = $this->tokenService->refreshToken($token);

        return $this->respondWithToken($newToken);
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => (int)config('jwt.ttl'),
        ]);
    }
}
