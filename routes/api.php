<?php

use App\Http\Controllers\Api\MovieByUserController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/movies/{sort?}', [MovieController::class, 'index']);
Route::get('/movie-by-user/{id}', MovieByUserController::class);
Route::middleware('auth:sanctum')->post('add', [MovieController::class, 'add']);

// Route::group(['prefix' => 'movies', 'middleware' => 'auth:sanctum'], function () {
//     Route::get('/', [MovieController::class, 'index']);
//     Route::post('add', [MovieController::class, 'add']);
// });