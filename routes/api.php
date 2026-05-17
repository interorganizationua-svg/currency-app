<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\ExchangeRateController;
use Illuminate\Support\Facades\Route;

Route::get("/currencies", [CurrencyController::class, 'index']);
Route::get('/chart', [ExchangeRateController::class,'chart']);
Route::get('/rates', [ExchangeRateController::class,'index']);

