<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;

Route::get('/user', [UserController::class, 'list']);
Route::post('/user', [UserController::class, 'store']);
Route::delete('/user/{userId}', [UserController::class, 'delete']);

Route::post('/user/{userId}/user-profile', [UserProfileController::class, 'store']);
