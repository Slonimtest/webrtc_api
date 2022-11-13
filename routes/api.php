<?php

use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\StudioResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('studios', StudioController::class);
    Route::apiResource('settings', SettingController::class);
    Route::apiResource('resources', StudioResourceController::class);
});
