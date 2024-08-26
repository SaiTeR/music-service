<?php

declare(strict_types=1);

namespace App\Http\RequestModels;

use Illuminate\Http\UploadedFile;

class AlbumModel
{
    public string $albumName;
    public string $releaseYear;
    public bool $isExplicit;
    public string $albumType;
    public string $genre;

    public UploadedFile $image;

}
