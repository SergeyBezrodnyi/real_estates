<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\RealEstateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/create/agency', [AgencyController::class, 'create']);
    Route::post('/update/{id}/agency', [AgencyController::class, 'update']);
    Route::get('/delete/{id}/agency', [AgencyController::class, 'delete']);

    Route::post('/create/real_estate', [RealEstateController::class, 'create']);
    Route::post('/update/{id}/real_estate', [RealEstateController::class, 'update']);
    Route::get('/delete/{id}/real_estate', [RealEstateController::class, 'delete']);
    Route::get('/get/{id}/real_estate', [RealEstateController::class, 'get']);
    Route::get('/list/real_estate', [RealEstateController::class, 'list']);
    Route::post('/listByType/real_estate', [RealEstateController::class, 'listByType']);
    Route::post('/listByAgencyAndMonth/real_estate', [RealEstateController::class, 'listByAgencyAndMonth']);
});