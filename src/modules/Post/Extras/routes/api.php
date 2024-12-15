<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Controllers\PostsController;

Route::prefix("/api/posts")->middleware(["json.response", "auth:api"])->group(function () {
    Route::get("/", [PostsController::class, "fetchAll"]);
    Route::get("/{id}", [PostsController::class, "fetchById"]);
    Route::post("/", [PostsController::class, "create"]);
    Route::patch("/{id}", [PostsController::class, "update"]);
    Route::delete("/{id}", [PostsController::class, "delete"]);
});
