<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DriverRider\DriverRiderController;

Route::group([
    'middleware' => ['checkPassword','api'],
], function ($router) {
    Route::Group(['middleware' =>'auth.guard:driver-api'], function(){
        Route::post('driver/cost', [DriverRiderController::class, 'calculate_trip_cost']);        
    });
    Route::Group(['middleware' =>'auth.guard:rider-api'], function(){
        Route::post('rider/cost', [DriverRiderController::class, 'calculate_trip_cost']);
    });
});
Route::get('/start', function () {
    return 'test api';
});