<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;

Route::get('/user', [UserController::class, 'list']);
Route::get('/user/{userId}', [UserController::class, 'get']);
Route::post('/user', [UserController::class, 'store']);
Route::delete('/user/{userId}', [UserController::class, 'delete']);
Route::put('/user/{userId}', [UserController::class, 'update']);

Route::post('/user/{userId}/user-profile', [UserProfileController::class, 'store']);
Route::put('/user/{userId}/user-profile', [UserProfileController::class, 'update']);
