<?php

use App\Http\Controllers\HouseController;
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


Route::get('/person', [PersonController::class, 'list']);
Route::get('/person/{personId}', [PersonController::class, 'get']);
Route::post('/person', [PersonController::class, 'store']);
Route::put('/person/{personId}', [PersonController::class, 'update']);
Route::post('/person/{userId}/nutritional-profile', [NutritionalProfileController::class, 'store']);
Route::get('/person/{userId}/nutritional-profile', [NutritionalProfileController::class, 'get']);
Route::put('/person/{userId}/nutritional-profile', [NutritionalProfileController::class, 'update']);
Route::post('/person/{userId}/house', [PersonController::class, 'storeHouses']);
Route::get('/person/{userId}/house', [PersonController::class, 'getHouses']);

Route::get('/nutritional-restriction', [NutritionalRestrictionController::class, 'list']);

Route::get('/house', [HouseController::class, 'list']);
Route::post('/house', [HouseController::class, 'store']);
Route::put('/house/{houseId}', [HouseController::class, 'update']);
Route::post('/house/{houseId}/persons', [HouseController::class, 'storePersons']);
