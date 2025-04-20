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

Route::get('/login', function () {
    sleep(1);
    return Inertia::render('account/index');
});