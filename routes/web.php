<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/hospital', function () {
    return view('admin.hospital');
})->name('hospital');

Route::get('/forum', function () {
    return view('admin.forum');
})->name('forum');