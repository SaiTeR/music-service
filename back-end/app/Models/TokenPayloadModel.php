<?php

namespace App\Models;

use Illuminate\Support\Collection;

class TokenPayloadModel
{
    public int $id;
    public string $login;
    public string $username;
    public array $artistIds;
    public int $createdAt;
    public int $refreshableUntil;
    public int $expiredAt;
}
