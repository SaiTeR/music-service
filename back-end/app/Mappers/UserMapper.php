<?php

namespace App\Mappers;

use App\DTO\UserDTO;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Support\Collection;
use Nette\Utils\Image;

class UserMapper
{
    public function __construct(
        private readonly ImageService $imageService,
    )
    {}

    public function getUserDTO(User $user): UserDTO
    {
        $imageUrl = $this->imageService->getImage($user->image_path);
        return new UserDTO($user->id, $user->login, $user->email, $user->username, $imageUrl);
    }

    public function getMultipleUserDTOs(Collection $users): Collection
    {
        $userDTOs = new Collection();
        foreach ($users as $user) {
            $userDTOs->add($this->getUserDTO($user));
        }

        return $userDTOs;
    }
}
