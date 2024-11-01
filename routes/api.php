<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VeterinerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('checkEmail');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('api.login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');
Route::get('/profile', [AuthController::class, 'me'])->middleware('auth:sanctum')->name('api.me');

Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
    Route::get('/pets', [PetController::class, 'index'])->name('api.customer.show.pets');
    Route::get('/pet/{id}', [PetController::class, 'show'])->name('api.customer.show.pet');
    Route::post('/pet/{id}', [PetController::class, 'update'])->name('api.customer.update.pet');
    Route::post('/pet', [PetController::class, 'create'])->name('api.customer.create.pet');
    Route::delete('/pet/{id}', [PetController::class, 'delete'])->name('api.customer.delete.pet');
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

    Route::group(['prefix' => 'customer'], function () {
        Route::middleware(['role:customer'])->group(function () {
            //queue
            Route::get('/queues', [QueueController::class, 'indexCustomer'])->name('api.customer.show.queues');
            Route::get('/queue/{id}', [QueueController::class, 'showCustomer'])->name('api.customer.show.queue');
            Route::post('/queue', [QueueController::class, 'create'])->name('api.customer.create.queue');

            //veteriner
            Route::get('/veteriners', [VeterinerController::class, 'customerIndex'])->name('api.customer.show.veteriners');
            Route::get('/veteriner/{id}', [VeterinerController::class, 'customerShow'])->name('api.customer.show.veteriner');
        });
    });


    Route::middleware(['role:veteriner'])->group(function () {
        Route::get('/veteriner/queues', [QueueController::class, 'indexVeteriner'])->name('api.veteriner.show.queues');
        Route::get('/veteriner/queue/{id}', [QueueController::class, 'showVeteriner'])->name('api.veteriner.show.queue');
        Route::delete('/veteriner/queue/{id}', [QueueController::class, 'destroy'])->name('api.veteriner.delete.queue');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::group(['prefix' => 'admin'], function () {
            Route::get('/veteriners', [VeterinerController::class, 'index'])->name('api.veteriners.index');
            Route::get('/veteriner/{id}', [VeterinerController::class, 'show'])->name('api.veteriners.show');
        });
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/forums/{id}/comments', [CommentController::class, 'index']);
        Route::post('/forums/{id}/comments', [CommentController::class, 'store']);
        Route::get('/forums/{id}/comments/{commentid}', [CommentController::class, 'show']);
        Route::put('/forums/{id}/comments/{commentid}', [CommentController::class, 'update']);
        Route::delete('/forums/{id}/comments/{commentid}', [CommentController::class, 'destroy']);
    });
});
