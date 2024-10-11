<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('api.login');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum')->name('api.me');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {});

Route::get('/admin/dashboard', function () {
    return response()->json("atmin");
})->middleware(['auth:sanctum', 'role:admin']);

Route::get('/admin/dashboard', function () {
    return response()->json("veteriner");
})->middleware(['auth:sanctum', 'role:veteriner']);

Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
    Route::get('/customer/{id}/pets', [PetController::class, 'index'])->name('api.customer.show.pets');
    Route::get('/customer/pet/{id}', [PetController::class, 'show'])->name('api.customer.show.pet');
    Route::post('/customer/pet/{id}', [PetController::class, 'update'])->name('api.customer.update.pet');
    Route::post('/customer/pet', [PetController::class, 'create'])->name('api.customer.create.pet');
    Route::delete('/customer/pet/{id}', [PetController::class, 'delete'])->name('api.customer.delete.pet');
});
