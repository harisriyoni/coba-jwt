<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::post('/users', [Authcontroller::class, 'register']);
Route::post('/users/login', [Authcontroller::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->middleware('role:admin');
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->middleware('role:user');
});
