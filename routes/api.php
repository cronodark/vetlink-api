<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {});

Route::get('/admin/dashboard', function () {
    return response()->json("atmin");
})->middleware(['auth:sanctum', 'role:admin']);

Route::get('/admin/dashboard', function () {
    return response()->json("veteriner");
})->middleware(['auth:sanctum', 'role:veteriner']);

Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
    Route::get('/user/profile', function (Request $request) {
        return response()->json("veteriner");
    });
});
