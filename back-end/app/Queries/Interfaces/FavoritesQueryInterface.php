<?php

namespace App\Queries\Interfaces;

interface FavoritesQueryInterface
{
    public function getSongs(int $userId);
    public function addSong(int $userId, int $songId);
    public function deleteSong(int $userId, int $songId);

    public function getArtists(int $userId);
    public function addArtist(int $userId, int $artistId);
    public function deleteArtist(int $userId, int $artistId);

    public function getAlbums(int $userId);
    public function addAlbum(int $userId, int $albumId);
    public function deleteAlbum(int $userId, int $albumId);
}
