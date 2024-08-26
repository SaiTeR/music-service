<?php

namespace App\DTO;

class UserDTO
{
    public int $id;
    public string $login;
    public string $email;
    public string $username;
    public string $imageUrl;

    public function __construct(int $id, string $login, string $email, string $username, string $imageUrl)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->username = $username;
        $this->imageUrl = $imageUrl;
    }
}
