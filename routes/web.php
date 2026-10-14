<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/signin', function () {
    return view('signin');
});


Route::get('/signup', function () {
    return view('signup');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::view('/request', 'request')
    ->name('request');

Route::get('/requests/create', function () {
    return view('request-form');
})->name('requests.create');