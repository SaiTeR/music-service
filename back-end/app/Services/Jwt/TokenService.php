<?php

namespace App\Services\Jwt;

use App\Models\TokenPayloadModel;
use App\Models\User;
use App\Repositories\Interfaces\ArtistRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

use App\Services\Jwt\TokenStorageService;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TokenService
{
    public function __construct(
        private readonly EncodeDecodeService $encodeDecodeService,
        private readonly TokenStorageService $tokenStorageService,
        private readonly UserRepositoryInterface     $userRepository,
        private readonly ArtistRepositoryInterface   $artistRepository
    ) {}


    public function getTokenFromRequest(Request $request): ?string
    {
        $header = $request->header('authorization');
        if ($header === null) {
            return null;
        }

        $parts = explode(' ', $header, 2);

        if (count($parts) < 2) {
            return null;
        }

        [$authHeader, $authToken] = $parts;

        if ($authHeader !== 'Bearer') {
            return null;
        }

        return $authToken;
    }

    public function createToken(User $user): string
    {
        $model = $this->createTokenPayload($user);
        $jwt = $this->encodeDecodeService->encode($model);

        $this->tokenStorageService->saveToken($jwt, $user->id);

        return $jwt;
    }

    private function createTokenPayload(User $user): TokenPayloadModel
    {
        $timeToLive = (int)config('jwt.ttl');
        $timeToRefresh = (int)config('jwt.ttr');

        $model = new TokenPayloadModel();
        $model->id = $user->id;
        $model->login = $user->login;
        $model->username = $user->username;

        $model->artistIds = $this->artistRepository->getArtistsByUserId($user->id)->pluck('id')->toArray();

        $model->createdAt = Carbon::now()->getTimestamp();
        $model->refreshableUntil = Carbon::now()->addSeconds($timeToRefresh)->getTimestamp();
        $model->expiredAt = Carbon::now()->addSeconds($timeToLive)->getTimestamp();

        return $model;
    }


    public function getTokenPayload(string $token): TokenPayloadModel|null
    {
        $tokenPayload = $this->encodeDecodeService->decode($token);

        if ($tokenPayload &&
            $this->tokenStorageService->findToken($token) &&
            $this->checkIfExpired($tokenPayload) &&
            $this->checkIfRefreshable($tokenPayload)
        ) {
            return $tokenPayload;
        }

        return null;
    }


    private function checkIfExpired(TokenPayloadModel $payload): bool
    {
        $currentTime = Carbon::now()->getTimestamp();
        $expiredAt = $payload->expiredAt;
        if ($currentTime > $expiredAt) {
            return false;
        }

        return true;
    }


    private function checkIfRefreshable(TokenPayloadModel $payload): bool
    {
        $currentTime = Carbon::now()->getTimestamp();
        $refreshUntil = $payload->refreshableUntil;
        if ($currentTime > $refreshUntil) {
            return false;
        }

        return true;
    }

    public function refreshToken(string $token): string
    {
//        try {
//            $tokenPayload = $this->getTokenPayload($token);
//        } catch (JwtException $exception) {
//            if ($exception->getMessage() !== 'token expired') {
//                return null;
//            }
//
//            $expiredTokenPayload = $exception->getTokenPayload();
//            return $this->refreshTokenByPayload($token, $expiredTokenPayload);
//        }
        $tokenPayload = $this->getTokenPayload($token);
        return $this->refreshTokenByPayload($token, $tokenPayload);
    }

    private function refreshTokenByPayload(string $token, TokenPayloadModel $tokenPayload): string
    {
//        try {
//            $this->tokenStorageService->deleteToken($token);
//        } catch (RedisException $e) {
//            throw JwtException::invalidToken();
//        }

        $this->tokenStorageService->deleteToken($token);
        $userId = $tokenPayload->id;
        $user = $this->userRepository->getById($userId);
        return $this->createToken($user);
    }

    public function logoutByToken(string $token): void
    {
//        try {
//            $this->tokenStorageService->deleteToken($token);
//        } catch (RedisException $e) {
//            throw JwtException::invalidToken();
//        }

        $this->tokenStorageService->deleteToken($token);
    }

}
