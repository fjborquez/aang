<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ConsumptionLevelController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\NutritionalProfileController;
use App\Http\Controllers\NutritionalRestrictionController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ResidentController;
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
Route::delete('/person/{personId}', [PersonController::class, 'delete']);

Route::post('/person/{userId}/nutritional-profile', [NutritionalProfileController::class, 'store']);
Route::get('/person/{userId}/nutritional-profile', [NutritionalProfileController::class, 'get']);
Route::put('/person/{userId}/nutritional-profile', [NutritionalProfileController::class, 'update']);
Route::delete('/person/{userId}/nutritional-profile/{productCategoryId}', [NutritionalProfileController::class, 'delete']);

Route::post('/person/{userId}/house', [PersonController::class, 'storeHouses']);
Route::get('/person/{userId}/house', [PersonController::class, 'getHouses']);
Route::put('/person/{userId}/house', [PersonController::class, 'updateHouses']);

Route::get('/nutritional-restriction', [NutritionalRestrictionController::class, 'list']);

Route::get('/house', [HouseController::class, 'list']);
Route::post('/house', [HouseController::class, 'store']);
Route::get('/house/{houseId}', [HouseController::class, 'get']);
Route::put('/house/{houseId}', [HouseController::class, 'update']);
Route::get('/house/{houseId}/person', [ResidentController::class, 'list']);
Route::post('/house/{houseId}/person', [HouseController::class, 'storePersons']);
Route::put('/house/{houseId}/person', [HouseController::class, 'updatePersons']);
Route::put('/house/{houseId}/enable', [HouseController::class, 'enable']);
Route::put('/house/{houseId}/disable', [HouseController::class, 'disable']);
Route::delete('/house/{houseId}/person/{residentId}', [ResidentController::class, 'delete']);

Route::get('/consumption-level', [ConsumptionLevelController::class, 'list']);

Route::get('/city', [CityController::class, 'list']);
