<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    public function __construct(
        private readonly StorageService $storageService
    ) {}



    public function saveImage(UploadedFile $file): string
    {
        return $filePath = $this->storageService->storeImage($file);
    }

    public function getImage(string $path): string
    {
        return $this->storageService->getFileUrl('image',$path);
    }

    public function deleteImage(string $path): bool
    {
        return $this->storageService->removeFile('image', $path);
    }
}
