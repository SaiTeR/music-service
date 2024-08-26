<?php

declare(strict_types=1);

namespace App\Services\Jwt;

use App\Models\Auth\AuthJwtModel;
use App\Models\User;
use App\Utils\Mapper;
use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;

class AuthJwtService
{
    /**
     * @param string[] $permissions
     */
    public function createToken(User $user, array $permissions = []): string
    {
        $model = new AuthJwtModel();
        $model->userId = $user->id;
        $model->email = $user->email;
        $model->name = $user->name;
        $model->permissions = $permissions;
        $model->refreshAt = Carbon::now()->addSeconds((int)config('auth.jwt.refresh_after_sec'))->getTimestamp();
        $model->exp = Carbon::now()->addSeconds((int)config('auth.jwt.expired_after_sec'))->getTimestamp();

        return $this->encodeToken($model);
    }

    public function encodeToken(AuthJwtModel $model): string
    {
        try {
            return JWT::encode((array)$model, config('auth.jwt.key'), config('auth.jwt.algorithm'));
        } catch (Exception $e) {
            Log::error('Cannot encode jwt token ' . $e);

            throw $e;
        }
    }

    public function decodeToken(string $token): ?AuthJwtModel
    {
        try {
            $decodeKey = new Key(config('auth.jwt.key'), config('auth.jwt.algorithm'));

            return Mapper::from(JWT::decode($token, $decodeKey))->mapTo(new AuthJwtModel());
        } catch (Exception) {
            return null;
        }
    }
}
