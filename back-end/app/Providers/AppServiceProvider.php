<?php

namespace App\Providers;

use App\Repositories\AlbumRepository;
use App\Repositories\ArtistRepository;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Repositories\Interfaces\ArtistRepositoryInterface;
use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use App\Repositories\Interfaces\PlaylistSongRepositoryInterface;
use App\Repositories\Interfaces\SongRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\PlaylistRepository;
use App\Repositories\PlaylistSongRepository;
use App\Repositories\SongRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AlbumRepositoryInterface::class,
            AlbumRepository::class
        );

        $this->app->bind(
            ArtistRepositoryInterface::class,
            ArtistRepository::class
        );

        $this->app->bind(
            PlaylistRepositoryInterface::class,
            PlaylistRepository::class
        );

        $this->app->bind(
            PlaylistSongRepositoryInterface::class,
            PlaylistSongRepository::class
        );

        $this->app->bind(
            SongRepositoryInterface::class,
            SongRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
