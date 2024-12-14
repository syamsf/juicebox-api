<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Controllers\UserController;

Route::prefix("/api")->middleware(["json.response", "auth:api"])->group(function () {
    Route::get("/users/{id}", [UserController::class, "fetchById"]);
    Route::post("/logout", [UserController::class, "logout"]);
    Route::get("/token/refresh", [UserController::class, "refreshToken"]);
});

Route::prefix("/api")->middleware("json.response")->group(function () {
    Route::post("/register", [UserController::class, "createUser"]);
    Route::post("/login", [UserController::class, "login"]);
    Route::get("/token/validate", [UserController::class, "validateToken"]);
});
