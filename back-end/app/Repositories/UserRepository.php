<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function getAll(): Collection
    {
        return User::all();
    }

    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function createUser(string $login, string $password, string $email, string $username): int
    {
        $user = new User();
        $user->login = $login;
        $user->password = $password;
        $user->email = $email;
        $user->username = $username;
        $user->image_path = "image/default-avatar.png";

        $user->save();
        return $user->id;
    }

    public function updateUser(int $id, string $login, string $password, string $email, string $username): bool
    {
        $affected = DB::table('users')
            ->where('id', $id)
            ->update([
                'login' => $login,
                'password' => Hash::make($password),
                'email' => $email,
                'username' => $username,
            ]);

        return bool($affected);
    }

    public function updateImage(int $id, string $imagePath): bool
    {
        $affected = DB::table('users')
            ->where('id', $id)
            ->update([
                'image_path' => $imagePath
            ]);

        return bool($affected);
    }

    public function deleteUser(int $id): bool
    {
        return bool(User::query()->where('id', '=', $id)->delete());
    }

    public function getUserByLogin(string $login): User
    {
        return User::query()->where('login', '=', $login)->get()->first();
    }
}
