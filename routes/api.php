<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
});

Route::get('/admin/dashboard', function () {
    return "atmin";
})->middleware(['auth:sanctum', 'role:admin']);

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/user/profile', function (Request $request) {
        return $request->user();
    });
});

