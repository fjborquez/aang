<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'list']);
Route::get('/user/{userId}', [UserController::class, 'get']);
Route::post('/user', [UserController::class, 'store']);
Route::delete('/user/{userId}', [UserController::class, 'delete']);
Route::put('/user/{userId}', [UserController::class, 'update']);
Route::put('/user/{userId}/enable', [UserController::class, 'enable']);
Route::put('/user/{userId}/disable', [UserController::class, 'disable']);
