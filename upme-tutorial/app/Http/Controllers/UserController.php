<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        // validate the field
        $fields = $request->validate([
            'avatar'             => ['nullable', 'file', 'max:300'],
            'first_name'         => ['nullable', 'string', 'max:255'],
            'middle_name'        => ['nullable', 'string', 'max:255'],
            'last_name'          => ['nullable', 'string', 'max:255'],
        
            // Philippine mobile number regex: starts with 09 or +639, followed by 9 digits
            // 'cellphone_num' => ['required', 'regex:/^(09|\+639)\d{8}$/'],
            'cellphone_num'      => ['nullable', 'string', 'max:255'],
        
            'email'              => ['nullable', 'email', 'max:255'],
            'address'            => ['nullable', 'string', 'max:255'],
        
            // Assuming dropdowns use string values matching ENUMs in the DB
            'department'         => ['nullable', 'string', 'in:Product and Technology,Sales,Marketing,HR/Admin,Finance'], 
            'position'           => ['nullable', 'string', 'max:255'],
            'status'             => ['nullable', 'string', 'in:Active,Inactive,Terminiated,Deleted,On-leave'], 

            'is_admin'           => ['nullable', 'boolean'],
        ]);

    
        if($request->hasFile('avatar')) {
            $fields['avatar'] = Storage::disk('public')->put('avatars', $request->file('avatar'));
        }
        
        // Update the user with the validated data
        $user->update($fields);

        // Optionally: If you need to update password, make sure it's hashed
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        // After updating the user, return a response or redirect
        return redirect()->route('user.edit', ['user' => $user->id])->with('success', 'User updated successfully!');

    }
    
    public function soft_delete(Request $request, User $user)
    {
        $user->status = 'Deleted'; 
        $user->save();
    
        session()->flash('message', 'User soft-deleted successfully');

        return redirect()->back();
    }

    public function restore_user(Request $request, User $user)
    {
        // Example: set status to "Inactive"
        $user->status = 'Active'; 
        $user->save();
    
        // Flash message to session
        session()->flash('message', 'User restored successfully');

        // Redirect back to the previous page (or wherever you want)
        return redirect()->back();
    }

    public function perma_delete(Request $request, User $user)
    {
        $user->delete(); // This deletes the user from the database
    
        session()->flash('message', 'User permanently deleted.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
