<?php

use Illuminate\Support\Facades\Route;
use Modules\Weather\Controllers\DataFetcherController;

Route::prefix("/api")->middleware(["json.response"])->group(function () {
    Route::get("/weather", [DataFetcherController::class, "fetchWeather"]);
});
