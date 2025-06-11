<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

// Landing page route

Route::middleware('auth')->group(function(){

    Route::get('dashboard', function (Request $request) {
        $authUser = Auth::user();
    
        // For admins, fetch all users with search functionality
        if ($authUser->is_admin) {
            $users = User::when($request->search, function ($query) use ($request) {
                $query
                    ->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            })->paginate(10)->withQueryString();
        } else {
            // For non-admin users, just pass their own data (no search or pagination)
            $users = (object)[
                'data' => [$authUser],
                'current_page' => 1,    
                'last_page' => 1,
                'total' => 1, 
            ];
        }
    
        return Inertia::render('Dashboard', [
            'users' => $users,
            'searchTerm' => $request->search,
            'can' => [
                'delete_user' => $authUser?->can('delete', User::class),
                'update_user' => $authUser?->can('update', User::class),
            ],
        ]);
    })->name('dashboard');

    Route ::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/user/{user:id}', function (User $user) {
        $authUser = Auth::user();

        // check if user is either an admin or the same user trying to view their own profile
        $canView = $authUser && (
            $authUser->is_admin || $authUser->id === $user->id
        );

        abort_unless($canView, 403);

        return Inertia::render('Auth/Register', [ 
            'user'    => $user,
            'canView' => $canView,
            'action'  => 'View',

        ]);
    })->name('user.profile');
    

    // Register page using Inertia route helper
    Route::inertia('/register', 'Auth/Register', [
        'action' => 'Register',
    ])->name('register');
    
    Route ::post('/register', [AuthController::class, 'register']);

    //protect update and delete routes by checking if they're an admin
   Route::middleware(['can:update,App\Models\User', 'can:delete,App\Models\User'])->group(function() {
        //edit user route
        Route::get('/user/edit/{user:id}', function(User $user) {
            return Inertia::render('Auth/Register', [
                'user'   => $user,
                'action' => 'Edit'
            ]);
        })->name('user.edit');

        Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
    
        Route::delete('/users/softDel/{user}', [UserController::class, 'soft_delete'])->name('users.softDel');
    
        Route::delete('/users/permaDel/{user}', [UserController::class, 'perma_delete'])->name('users.permaDel');
    
        Route::patch('/users/restore/{user}', [UserController::class, 'restore_user'])->name('users.restore');

        //could use this pala, but Inertia has problems with multipart/form-data when using PUT, PATCH, or DELETE so the workaround was to use POST only
        // 2 solutions are fine, i prefer the individual routes so it's easier to read in the frontend
        // Route::resource('users', UserController::class);
    });
});

Route::middleware('guest')->group(function(){    
    // login routes
    Route::inertia('/', 'Auth/Login')->name('login');
    Route ::post('/', [AuthController::class, 'login']);
});
    
