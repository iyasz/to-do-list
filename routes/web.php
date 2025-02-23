<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get("/", [IndexController::class, 'index']);


Route::middleware(['auth'])->group(function () {

    Route::post("/activity", [IndexController::class, 'store']);
    Route::put("/activity/{id}", [IndexController::class, 'handleCompleted']);
    Route::delete("/activity/{id}", [IndexController::class, 'destroy']);
    
    Route::get("/logout", [AuthController::class, 'logout']);
});

Route::post("/login", [AuthController::class, 'loginHandle']);
