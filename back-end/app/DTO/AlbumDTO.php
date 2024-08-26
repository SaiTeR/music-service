<?php

namespace App\DTO;

class AlbumDTO
{

    public int $id;
    public string $albumName;
    public string $artistName;
    public int $releaseYear;
    public bool $isExplicit;
    public string $albumType;
    public string $genre;
    public int $playbacks;
    public string $imagePath;


    public function __construct(
        int $id,
        string $albumName,
        string $artistName,
        int $releaseYear,
        bool $isExplicit,
        string $albumType,
        string $genre,
        int $playbacks,
        string $imagePath
    ) {
        $this->id = $id;
        $this->albumName = $albumName;
        $this->artistName = $artistName;
        $this->releaseYear = $releaseYear;
        $this->isExplicit = $isExplicit;
        $this->albumType = $albumType;
        $this->genre = $genre;
        $this->playbacks = $playbacks;
        $this->imagePath = $imagePath;
    }
}
