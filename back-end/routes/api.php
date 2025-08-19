<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;


Route::get('/movies/popular', [MovieController::class, 'popular']);
Route::get('/favorite/movies', [MovieController::class, 'myFavoriteMovies']);
Route::post('/add-movie', [MovieController::class, 'addFavoriteMovies']);
Route::get('/search/movies', [MovieController::class, 'searchMovies']);
Route::get('/genre/movies', [MovieController::class, 'getGenreMap']);
Route::delete('/favorite/movies/{id}', [MovieController::class, 'destroy']);
