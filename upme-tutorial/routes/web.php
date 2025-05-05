<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Landing page route
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// About page with props
Route::get('/about', function () {
    return Inertia::render('About', [
        'user' => 'Mike',
    ]);
})->name('about');

// Register page using Inertia route helper
Route::inertia('/register', 'Auth/Register')->name('register');
Route ::post('/register', [AuthController::class, 'register']);


// login routes
Route::inertia('/login', 'Auth/Login')->name('login');
Route ::post('/login', [AuthController::class, 'login']);