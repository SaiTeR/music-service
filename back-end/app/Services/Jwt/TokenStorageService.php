<?php

namespace App\Services\Jwt;


use App\Services\Redis\RedisStorageService;

class TokenStorageService
{
    public function __construct(
        private readonly RedisStorageService $redisStorageService,
    ) {}

    public function saveToken(string $token, int $userId): void
    {
        $timeToRefresh = (int)config('jwt.ttr');
        $this->redisStorageService->save($token, (string)$userId, $timeToRefresh);
    }


    public function deleteToken(string $token): void
    {
        $this->redisStorageService->delete($token);
    }


    public function findToken(string $token): string|null
    {
        return $this->redisStorageService->find($token);
    }
}
