<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?User;

    public function createUser(string $login, string $password, string $email, string $username): int;

    public function updateUser(int $id, string $login, string $password, string $email, string $username): bool;
    public function updateImage(int $id, string $imagePath): bool;

    public function deleteUser(int $id): bool;

    public function getUserByLogin(string $login): ?User;
}
