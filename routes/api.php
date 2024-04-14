<?php

use App\Http\Controllers\NutritionalProfileController;
use App\Http\Controllers\NutritionalRestrictionController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'list']);
Route::get('/user/{userId}', [UserController::class, 'get']);
Route::post('/user', [UserController::class, 'store']);
Route::delete('/user/{userId}', [UserController::class, 'delete']);
Route::put('/user/{userId}', [UserController::class, 'update']);
Route::put('/user/{userId}/enable', [UserController::class, 'enable']);
Route::put('/user/{userId}/disable', [UserController::class, 'disable']);
Route::post('/user/{userId}/nutritional-profile', [NutritionalProfileController::class, 'store']);


Route::get('/person', [PersonController::class, 'list']);
Route::post('/person', [PersonController::class, 'store']);

Route::get('/nutritional-restriction', [NutritionalRestrictionController::class, 'list']);
