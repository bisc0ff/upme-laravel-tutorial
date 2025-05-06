<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

// Landing page route
Route::get('/', function(Request $request) {
    return Inertia('Home', [
                            // for search functionality
        'users' => User::when($request->search, function($query) use ($request) {
            //filters data based on the search input
            $query
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%');
        })->paginate(5)->withQueryString(),

        'searchTerm' => $request->search,

        'can' => [
            // check if user is authenticated, if so, check if they can delete a user which is hard coded in UserPolicy
            'delete_user' => 
                Auth::user() ? 
                    Auth::user()->can('delete', User::class) : 
                    null,
        ]
    ]);
})->name('home');

Route::middleware('auth')->group(function(){
    Route ::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route ::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route ::inertia('/about', 'About')->name('about');

Route::middleware('guest')->group(function(){
    // Register page using Inertia route helper
    Route::inertia('/register', 'Auth/Register')->name('register');
    Route ::post('/register', [AuthController::class, 'register']);
    
    
    // login routes
    Route::inertia('/login', 'Auth/Login')->name('login');
    Route ::post('/login', [AuthController::class, 'login']);
});
    
