<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AlbumOwnership;
use App\Http\Middleware\ArtistOwnership;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckAlbumPublishStatus;
use App\Http\Middleware\PlaylistOwnership;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Аутентификация
Route::group(['prefix' => 'auth'], function () {
    Route::post('signup',[AuthController::class, 'signup']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});


// Пользователи
Route::group(['prefix' => 'users', 'middleware' => Authenticate::class], function () {
    Route::get('all', [UserController::class,'getAllUsers']);
    Route::get('me', [UserController::class,'getMyUser']);
    Route::get('{userId}', [UserController::class,'getUser']);
    Route::put('', [UserController::class,'updateUser']);
    Route::put('update-image', [UserController::class,'updateUserAvatar']);
    Route::delete('', [UserController::class,'deleteUser']);
});


// Любимые
Route::group(['prefix' => 'favorites', 'middleware' => Authenticate::class], function () {
    Route::group(['prefix' => 'songs'], function () {
        Route::get('', [FavoritesController::class,'getFavoriteSongs']);
        Route::post('like', [FavoritesController::class,'likeSong']);
        Route::post('dislike', [FavoritesController::class,'dislikeSong']);
    });
    Route::group(['prefix' => 'artists'], function () {
        Route::get('', [FavoritesController::class,'getFavoriteArtists']);
        Route::post('like', [FavoritesController::class,'likeArtist']);
        Route::post('dislike', [FavoritesController::class,'dislikeArtist']);
    });
    Route::group(['prefix' => 'albums'], function () {
        Route::get('', [FavoritesController::class,'getFavoriteAlbums']);
        Route::post('like', [FavoritesController::class,'likeAlbum']);
        Route::post('dislike', [FavoritesController::class,'dislikeAlbum']);
    });
});


// Артисты
Route::group(['prefix' => 'artists', 'middleware' => Authenticate::class], function(){
   Route::get('all',[ArtistController::class,'getAllArtists']);
   Route::get('{artistId}',[ArtistController::class,'getArtist']);
   Route::post('',[ArtistController::class,'createArtist']);

   Route::group(['middleware' => ArtistOwnership::class], function (){
       Route::put('{artistId}',[ArtistController::class, 'updateArtist']);
       Route::put('{artistId}/update-image',[ArtistController::class, 'updateArtistImage']);
       Route::delete('{artistId}',[ArtistController::class, 'deleteArtist']);
   });
});


// Альбомы
Route::group(['prefix' => 'albums', 'middleware' => Authenticate::class], function (){
    Route::get('all', [AlbumController::class,'getAllAlbums']);

    Route::group(['middleware' => CheckAlbumPublishStatus::class], function (){
        Route::get('{albumId}', [AlbumController::class,'getAlbum']);
        Route::get('{albumId}/songs',[AlbumController::class, 'getAlbumWithSongs']); //TODO
    });

    Route::group(['prefix' => '{artistId}'], function (){
        Route::get('all',[AlbumController::class, 'getAllArtistAlbums']);

        Route::group(['middleware' => ArtistOwnership::class], function (){
            Route::post('', [AlbumController::class, 'createAlbum']);

            Route::group(['prefix' => '{albumId}', 'middleware' => AlbumOwnership::class], function (){
                Route::put('',[AlbumController::class, 'updateAlbum']);
                Route::put('update-image',[AlbumController::class, 'updateAlbumImage']);
                Route::delete('', [AlbumController::class, 'deleteAlbum']);

                // Песни
                Route::group(['prefix' => 'songs'], function () {
                    Route::post('', [SongController::class, 'uploadSong']); // Post Song
                    Route::put('{songId}', [SongController::class, 'updateSong']); // Put Song  TODO
                    Route::delete('{songId}', [SongController::class, 'deleteSong']); // Delete Song
                });
            });
        });
    });
});

// Послушать песню
Route::group(['prefix' => 'songs'], function (){
    Route::post('{songId}', [SongController::class, 'listenToSong']);
});

// Плейлисты
Route::group(['prefix' => 'playlists' , 'middleware' => Authenticate::class], function (){
    Route::get('all', [PlaylistController::class, 'getAllPlaylists']);
    Route::get('{playlistId}', [PlaylistController::class, 'getPlaylist']);
    Route::post('', [PlaylistController::class, 'createPlaylist']);
    Route::get('{playlistId}/songs', [PlaylistController::class, 'getSongs']);
    Route::get('my-playlists', [PlaylistController::class, 'getUserPlaylists']);

    Route::group(['middleware' => PlaylistOwnership::class], function (){
        Route::put('{playlistId}', [PlaylistController::class, 'updatePlaylist']);
        Route::put('{playlistId}/update-image', [PlaylistController::class, 'updatePlaylistImage']);
        Route::delete('{playlistId}', [PlaylistController::class, 'deletePlaylist']);

        Route::post('{playlistId}/add/{songId}', [PlaylistController::class, 'addSongToPlaylist']);
        Route::delete('{playlistId}/delete/{songId}', [PlaylistController::class, 'deleteSongFromPlaylist']);
    });


});



