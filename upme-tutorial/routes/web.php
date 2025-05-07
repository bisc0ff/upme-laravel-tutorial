<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

// Landing page route


Route::inertia('/home', 'Home')->name('home');

Route::middleware('auth')->group(function(){

    Route::get('dashboard', function(Request $request) {
        return Inertia('Dashboard', [
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
    })->name('dashboard');

    Route ::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/user/{user:id}', function (User $user) {
        return Inertia::render('UserInfo', [ // re-use the register page to display user info
            'user' => $user,
            'can' => [
                'update' => Auth::user()?->can('update', $user),
                'delete' => Auth::user()?->can('delete', $user),
            ],
        ]);
    })->name('user.profile');

    // Register page using Inertia route helper
    Route::inertia('/register', 'Auth/Register')->name('register');
    Route ::post('/register', [AuthController::class, 'register']);
});

Route ::inertia('/about', 'About')->name('about');

Route::middleware('guest')->group(function(){    
    // login routes
    Route::inertia('/', 'Auth/Login')->name('login');
    Route ::post('/', [AuthController::class, 'login']);
});
    
