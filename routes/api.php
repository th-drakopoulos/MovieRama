<?php

use App\Http\Controllers\Api\HasRatingByMovieIdController;
use App\Http\Controllers\Api\MovieByUserController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\RatingsByUserController;
use App\Http\Controllers\Api\ReverseRatingController;
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
Route::middleware('auth:sanctum')->post('/movies', [MovieController::class, 'store']);
Route::middleware('auth:sanctum')->post('/movies/{id}/likes', [MovieController::class, 'like']);
Route::middleware('auth:sanctum')->post('/movies/{id}/hates', [MovieController::class, 'hate']);
Route::middleware('auth:sanctum')->get('/ratings', [RatingController::class, 'show']);
Route::middleware('auth:sanctum')->get('/ratings/{movieId?}', HasRatingByMovieIdController::class);
Route::middleware('auth:sanctum')->get('/ratings-by-user', RatingsByUserController::class);
Route::middleware('auth:sanctum')->post('/ratings/{id}/reverse', ReverseRatingController::class);
Route::middleware('auth:sanctum')->post('/ratings/{movieId}', [RatingController::class, 'store']);