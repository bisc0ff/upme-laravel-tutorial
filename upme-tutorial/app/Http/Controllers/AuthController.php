<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){


        // validate the field
        $fields = $request->validate([
            'avatar'             => ['nullable', 'file', 'max:300'],
            'first_name'         => ['required', 'string', 'max:255'],
            'middle_name'        => ['required', 'string', 'max:255'],
            'last_name'          => ['required', 'string', 'max:255'],
        
            // Philippine mobile number regex: starts with 09 or +639, followed by 9 digits
            // 'cellphone_num' => ['required', 'regex:/^(09|\+639)\d{8}$/'],
            'cellphone_num' => ['required', 'string', 'max:255'],
        
            'email'              => ['required', 'email', 'max:255', 'unique:users,email'],
            'address'            => ['required', 'string', 'max:255'],
        
            // Assuming dropdowns use string values matching ENUMs in the DB
            'department'         => ['required', 'string', 'in:Product and Technology,Sales,Marketing,HR/Admin,Finance'], // customize the list
            'position'           => ['required', 'string', 'max:255'],
            'status'             => ['required', 'string', 'in:Active,Inactive,Terminiated,Deleted,On-leave'], // customize the list

            'is_admin'           => ['required', 'boolean'],
            'password'           => ['required', 'string', 'confirmed'],
        ]);

        // Uppercase first character of each name
        $fields['first_name']  = Str::title(trim($fields['first_name']));
        $fields['middle_name'] = Str::title(trim($fields['middle_name']));
        $fields['last_name']   = Str::title(trim($fields['last_name']));

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
