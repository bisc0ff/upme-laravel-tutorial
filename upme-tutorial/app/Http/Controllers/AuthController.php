<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        // validate the field
        $fields = $request->validate([
            'name'      =>['required', 'string', 'max:255'],
            'email'     =>['required', 'email', 'max:255', 'unique:users'],
            'password'  =>['required', 'confirmed']        
        ]);

        //register 
        $user = User::create($fields);

        //login 
        Auth::login($user);

        //redirect
        return redirect()->route('home');
        
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
 
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
