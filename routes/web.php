<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/nowPlaying', [HomeController::class, 'NowPlaying']);

Route::get('/', [LoginController::class, 'LoginPage']);
Route::get('/login', [LoginController::class, 'LoginPage']);
Route::post('/tryLogin', [LoginController::class, 'TryLogin']);
Route::post('/logout', [LoginController::class, 'Logout']);

Route::get('/createStation', [UserController::class, 'CreateStation']);

Route::group(['prefix' => '/', 'middleware' => 'user_auth'], function () {
    Route::get('/dashboard', [HomeController::class, 'Dashboard']);
    Route::get('/editProfile', [HomeController::class, 'EditProfile']);
    Route::get('/playlists', [PlaylistController::class, 'Playlists']);
    Route::get('/playlists/add', [PlaylistController::class, 'AddPlaylist']);
    Route::post('/playlists/save', [PlaylistController::class, 'SavePlaylist']);
    Route::get('/playlists/edit/{id}', [PlaylistController::class, 'EditPlaylist']);
    Route::post('/playlists/update', [PlaylistController::class, 'UpdatePlaylist']);
    Route::get('/playlists/schedule/edit/{id}', [PlaylistController::class, 'EditPlaylistSchedule']);
    Route::post('/playlists/schedule/update', [PlaylistController::class, 'UpdatePlaylistSchedule']);
    Route::get('/playlists/delete/{id}', [PlaylistController::class, 'DeletePlaylist']);
});
