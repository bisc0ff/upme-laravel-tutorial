<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){


        // validate the field
        $fields = $request->validate([
            'avatar'    => ['file', 'nullable', 'max:300'],
            'name'      =>['required', 'string', 'max:255'],
            'email'     =>['required', 'email', 'max:255', 'unique:users'],
            'password'  =>['required', 'confirmed']        
        ]);

        if($request->hasFile('avatar')) {
            $fields['avatar'] =  Storage::disk('public')->put('avatars', $request->avatar);
        }

        //register 
        $user = User::create($fields);

        //login 
        Auth::login($user);

        //redirect
        return redirect()->route('dashboard');
        
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ]);
 
        //attempt login
        if (Auth::attempt($fields, $request->remember)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard')->with('greet', 'Welcome back!');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect()->route('home');
    }
}
