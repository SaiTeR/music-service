<?php

declare(strict_types=1);

namespace App\Http\RequestModels;

use Illuminate\Http\UploadedFile;

class SongModel
{
    public string $songName;
    public string $duration;
    public bool $isExplicit;
    public string $songType;
    public UploadedFile $file;
}
