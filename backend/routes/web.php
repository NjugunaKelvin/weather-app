<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('welcome');
});

// API Routes (with prefix for clarity)
Route::prefix('api')->group(function () {
    Route::get('/weather', [WeatherController::class, 'getWeather']);
    Route::get('/historical-weather', [WeatherController::class, 'getHistoricalWeather']);
});
