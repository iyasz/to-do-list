<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::post("/login", [AuthController::class, 'loginHandle']);
Route::get("/logout", [AuthController::class, 'logout']);
