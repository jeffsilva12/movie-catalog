<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;


Route::get('/movies/popular', [MovieController::class, 'popular']);
Route::get('/favorite/movies', [MovieController::class, 'myFavoriteMovies']);
Route::post('/add-movie', [MovieController::class, 'addFavoriteMovies']);
Route::get('/genre/movies', [MovieController::class, 'getGenreMap']);
Route::delete('/favorite/movies/{id}', [MovieController::class, 'destroy']);
