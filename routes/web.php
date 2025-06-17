<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Middleware\RoleAdmin;
use App\Models\Movie;

Route::get('/', [MovieController::class, 'index']);

Route::get('/movie/{id}/{slug}', [MovieController::class, 'detail_movie']);

Route::get('/movie', [MovieController::class, 'data_movie'])->name('dataMovie')->middleware('auth');

Route::get('/movie/create', [MovieController::class, 'create'])->middleware('auth');

Route::post('/movie/store', [MovieController::class, 'store'])->middleware('auth');

Route::get('/movie-edit/{id}', [MovieController::class, 'edit'])->middleware('auth', RoleAdmin::class);

Route::post('/movie-update/{id}', [MovieController::class, 'update'])->middleware('auth', RoleAdmin::class);

Route::post('/movie-delete/{id}', [MovieController::class, 'destroy'])->middleware('auth');

Route::get('/login', [AuthController::class, 'formLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);
