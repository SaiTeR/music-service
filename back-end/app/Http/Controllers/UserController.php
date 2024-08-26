<?php

namespace App\Http\Controllers;

use App\Facades\AuthFacade;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\UserRequest;
use App\Mappers\UserMapper;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Domain\UserService;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserService $userService,
        private readonly UserMapper $userMapper,
        private readonly ImageService $imageService,
    ){}

    public function getMyUser(): JsonResponse
    {
        $user = $this->userRepository->getById(AuthFacade::getAuthInfo()->id);
        $userDTO = $this->userMapper->getUserDTO($user);

        return response()->json($userDTO);
    }
    public function getAllUsers(): JsonResponse
    {
        $users = $this->userRepository->getAll();
        $userDTOs = $this->userMapper->getMultipleUserDTOs($users);

        return response()->json($userDTOs);
    }


    public function getUser(int $userId): JsonResponse
    {
        $user = $this->userRepository->getById($userId);

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }


    public function updateUser(UserRequest $request): JsonResponse
    {
        $body = $request->body();
        $response = $this->userRepository->updateUser(AuthFacade::getAuthInfo()->id, $body->login, $body->password, $body->email,$body->username);

        if ($response) {
            return response()->json($response);
        } else {
            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    public function updateUserAvatar(ImageRequest $request): JsonResponse
    {
        return response()->json($this->userService->updateUserImage($request->body()));
    }

    public function deleteUser(): JsonResponse
    {
        $user = $this->userRepository->getById(AuthFacade::getAuthInfo()->id);
        if (!$user) {
            return response()->json(['message' => 'User not found!'], 404);
        }

        $serviceResponse = $this->userService->deleteUser($user);

        if ($serviceResponse) {
            return response()->json(['message' => 'User was deleted successfully!']);
        } else {
            return response()->json(['message' => 'Error during User deletion!'], 500);
        }


    }
}
