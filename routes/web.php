<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    sleep(1);
    return Inertia::render('index');
});

Route::get('/home', function () {
    sleep(1);
    return Inertia::render('auth/Dashboard');
});

Route::get('/service', function () {
    sleep(1);
    return Inertia::render('service/index');
});


Route::resource('accounts', App\Http\Controllers\AccountController::class)->only('index', 'store');
