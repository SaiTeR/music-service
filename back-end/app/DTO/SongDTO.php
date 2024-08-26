<?php

namespace App\DTO;

class SongDTO
{
    public int $id;
    public string $songName;
    public string $duration;
    public bool $isExplicit;
    public string $songType;

    public string $audioUrl;
    public string $imageUrl;

    public function __construct(
        int $id,
        string $songName,
        string $duration,
        bool $isExplicit,
        string $songType,
        string $audioUrl,
        string $imageUrl
    ){
        $this->id = $id;
        $this->songName = $songName;
        $this->duration = $duration;
        $this->isExplicit = $isExplicit;
        $this->songType = $songType;
        $this->audioUrl = $audioUrl;
        $this->imageUrl = $imageUrl;
    }
}
