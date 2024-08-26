<?php

declare(strict_types=1);

namespace App\Services\Jwt;

use App\Models\TokenPayloadModel;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;


class EncodeDecodeService
{
    private string $authJwtKey;
    private string $algo;

    public function __construct(
    )
    {
        $this->authJwtKey = config('jwt.key');
        $this->algo = config('jwt.algorithm');
    }

    public function encode(TokenPayloadModel $model): string
    {
        return JWT::encode((array)$model, $this->authJwtKey, $this->algo);
    }

    public function decode(string $token): TokenPayloadModel
    {
        $decodeKey = new Key($this->authJwtKey, $this->algo);

        $payloadStdClass = JWT::decode($token, $decodeKey);



        $authModel = new TokenPayloadModel();
        $authModel->id = $payloadStdClass->id;
        $authModel->username = $payloadStdClass->username;
        $authModel->artistIds = $payloadStdClass->artistIds;
        $authModel->expiredAt = $payloadStdClass->expiredAt;
        $authModel->refreshableUntil = $payloadStdClass->refreshableUntil;
        $authModel->createdAt = $payloadStdClass->createdAt;

        return $authModel;
    }
}
