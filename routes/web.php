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

Route::get('/request/create', function () {
    return view('request-form');
})->name('requests.create');


Route::get('/my-requests', function () {
    return view('my-request');
})->name('my-requests');

Route::get('/request-history', function () {
     return view('request-history');
});

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/help', function () {
    return view('help');
})->name('help');