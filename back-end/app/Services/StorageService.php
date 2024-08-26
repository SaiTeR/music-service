<?php

namespace App\Services;

use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;
class StorageService
{
    public function storeAudio(string $albumFolderId, UploadedFile $file): string
    {
        $fileName = uniqid(more_entropy: true);
        $filePath = "audio/{$albumFolderId}/{$fileName}.mp3";

        $this->getClient()->putObject(
            [
                'Bucket' => 'audio',
                'Key' => $filePath,
                'ACL' => 'public-read',
                'Body' => $file->getContent(),
            ]
        );

        $this->getClient()->waitUntil('ObjectExists', ['Bucket' => 'audio', 'Key' => $filePath]);

        return $filePath;
    }

    public function checkAudio(string $path): bool
    {
        $bucket = 'audio';

        try {
            $this->getClient()->headObject([
                'Bucket' => $bucket,
                'Key' => $path,
            ]);
            return true; // Файл существует
        } catch (\Aws\S3\Exception\S3Exception $e) {
            // Если возникает исключение, значит, файл не существует
            return false;
        }
    }
    public function getFileUrl(string $bucket, string $filePath): string
    {
        return "http://image.music.local:9005/image/{$filePath}";
    }

    public function removeFile(string $bucket, string $filePath): bool
    {
        $result = $this->getClient()->deleteObject([
            'Bucket' => $bucket,
            'Key' => $filePath,
        ]);

        if ($result['@metadata']['statusCode'] === 204) {
            return true;
        } else {
            return false;
        }
    }


    public function storeImage(UploadedFile $file): string
    {
        $fileName = uniqid(more_entropy: true);
        $filePath = "{$fileName}.png";

        $this->getClient()->putObject(
            [
                'Bucket' => 'image',
                'Key' => $filePath,
                'Body' => $file->getContent(),
            ]
        );

        $this->getClient()->waitUntil('ObjectExists', ['Bucket' => 'image', 'Key' => $filePath]);

        return $filePath;
    }

    private function getClient(): S3Client
    {
        return new S3Client(config('aws'));
    }
}
