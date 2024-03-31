<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;

Route::post('/user', [UserController::class, 'store']);
Route::post('/user/{userId}/user-profile', [UserProfileController::class, 'store']);
