<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/hospital', function () {
    return view('hospital');
})->name('hospital');

Route::get('/forum', function () {
    return view('forum');
})->name('forum');