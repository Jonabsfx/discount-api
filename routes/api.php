<?php

use App\Http\Controllers\{
    CityController,
    GroupController
};
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;


Route::apiResource('cities', CityController::class);
Route::apiResource('groups', GroupController::class);

Route::get('/groups/{group_id}/add-city/{city_id}', [GroupController::class, 'addCity']);

Route::get('/', function () {
    return response()->json(['message' => 'success']);
});
