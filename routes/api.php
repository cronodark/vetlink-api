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

Route::middleware(['auth:sanctum'])->group(function () {

    Route::group(['prefix' => 'customer'], function () {
        Route::middleware(['role:customer'])->group(function () {
            //queue
            Route::get('/queues', [QueueController::class, 'indexCustomer'])->name('api.customer.show.queues');
            Route::get('/queue/latest', [QueueController::class, 'latest'])->name('api.customer.latest.queue');
            Route::get('/queue/{id}', [QueueController::class, 'showCustomer'])->name('api.customer.show.queue');
            Route::post('/queue', [QueueController::class, 'create'])->name('api.customer.create.queue');

            //veteriner
            Route::get('/veteriners', [VeterinerController::class, 'customerIndex'])->name('api.customer.show.veteriners');
            Route::get('/veteriner/{id}', [VeterinerController::class, 'customerShow'])->name('api.customer.show.veteriner');

            //pet
            Route::get('/pets', [PetController::class, 'index'])->name('api.customer.show.pets');
            Route::get('/pet/{id}', [PetController::class, 'show'])->name('api.customer.show.pet');
            Route::post('/pet/{id}', [PetController::class, 'update'])->name('api.customer.update.pet');
            Route::post('/pet', [PetController::class, 'create'])->name('api.customer.create.pet');
            Route::delete('/pet/{id}', [PetController::class, 'delete'])->name('api.customer.delete.pet');
            Route::get('/pet-types-with-breeds', [PetController::class, 'typeWithBreeds'])->name('api.customer.get.type-with-breeds');

            //forum
            Route::post('/forum', [ForumController::class, 'store'])->name('api.customer.forum.store');
            Route::get('/forums', [ForumController::class, 'index'])->name('api.customer.forum.index');
            Route::post('/forum/{id}', [ForumController::class, 'update'])->name('api.customer.forum.update');
            Route::delete('/forum/{id}', [ForumController::class, 'destroy'])->name('api.customer.forum.delete');
        });
    });

    Route::middleware(['role:veteriner'])->group(function () {
        Route::group(['prefix' => 'veteriner'], function () {
            Route::get('/veteriner/queues', [QueueController::class, 'indexVeteriner'])->name('api.veteriner.show.queues');
            Route::get('/veteriner/queue/{id}', [QueueController::class, 'showVeteriner'])->name('api.veteriner.show.queue');
            Route::delete('/veteriner/queue/{id}', [QueueController::class, 'destroy'])->name('api.veteriner.delete.queue');
        });
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::group(['prefix' => 'admin'], function () {
            Route::get('/veteriners', [VeterinerController::class, 'index'])->name('api.admin.veteriners.index');
            Route::get('/veteriner/{id}', [VeterinerController::class, 'show'])->name('api.admin.veteriners.show');
            Route::post('/veteriner/{id}', [VeterinerController::class, 'update'])->name('api.admin.veteriners.update');
            Route::delete('/veteriner/{id}', [VeterinerController::class, 'destroy'])->name('api.admin.veteriners.delete');

            Route::get('/forums', [ForumController::class, 'index'])->name('api.admin.forums.index');
            Route::post('/forum/{id}', [ForumController::class, 'show'])->name('api.admin.forum.show');
            Route::delete('/forum/{id}', [ForumController::class, 'destroy'])->name('api.admin.forum.delete');
        });
    });
});
