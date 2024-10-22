<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\QueueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('checkEmail');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('api.login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');
Route::get('/profile', [AuthController::class, 'me'])->middleware('auth:sanctum')->name('api.me');

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



// Route::apiResource('forums', ForumController::class);

// Route::middleware('auth:sanctum')->post('/forums', [ForumController::class, 'store']);
// Route::middleware('auth:sanctum')->get('/forums/{id}', [ForumController::class,'show']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/forums', [ForumController::class, 'index']);
    Route::get('/forums/{id}', [ForumController::class, 'show']);
    Route::post('/forums', [ForumController::class, 'store']);
    Route::put('/forums/{id}', [ForumController::class, 'update']);
    Route::delete('/forums/{id}', [ForumController::class, 'destroy']);
    Route::get('/user/forums', [ForumController::class, 'userForums']);
});




Route::middleware(['auth:sanctum'])->group(function () {

    Route::middleware(['role:customer'])->group(function () {
        Route::get('/customer/{id}/queues', [QueueController::class, 'indexCustomer'])->name('api.customer.show.queues');
        Route::get('/customer/queue/{id}', [QueueController::class, 'showCustomer'])->name('api.customer.show.queue');
        Route::post('/customer/queue', [QueueController::class, 'create'])->name('api.customer.create.queue');
    });

    Route::middleware(['role:veteriner'])->group(function () {
        Route::get('/veteriner/queues', [QueueController::class, 'indexVeteriner'])->name('api.veteriner.show.queues');
        Route::get('/veteriner/queue/{id}', [QueueController::class, 'showVeteriner'])->name('api.veteriner.show.queue');
        Route::delete('/veteriner/queue/{id}', [QueueController::class, 'destroy'])->name('api.veteriner.delete.queue');
    });
});
