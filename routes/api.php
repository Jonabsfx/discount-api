<?php

use App\Http\Controllers\{
    CityController,
    GroupController,
    CampaignController,
    ProductController,
    DiscountController
};
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;


Route::apiResource('cities', CityController::class);
Route::apiResource('groups', GroupController::class);
Route::apiResource('campaigns', CampaignController::class);
Route::apiResource('products', ProductController::class);

Route::get('/groups/{group_id}/add-city/{city_id}', [GroupController::class, 'addCity']);
Route::get('/groups/{group_id}/add-campaign/{campaign_id}', [GroupController::class, 'addCampaign']);

Route::get('/campaigns/{campaign_id}/active', [CampaignController::class, 'active']);

Route::post('/discount/{campaign_id}/{product_id}', [DiscountController::class, 'associate_Campaign']);
Route::put('/discount/{campaign_id}/{product_id}', [DiscountController::class, 'edit_associated_Campaign']);
Route::delete('/discount/{campaign_id}/{product_id}', [DiscountController::class, 'remove_associated_Campaign']);


Route::get('/', function () {
    return response()->json(['message' => 'success']);
});
