<?php

declare(strict_types=1);

namespace App\Models\Auth;

class AuthJwtModel
{
    public int $userId;

    public int|null $artistId = null;

    public string $email;

    public string $username;


    /** @var string[] */
    public array $permissions;

    public int|null $refreshAt;

    // ---

    public int $exp;
}
