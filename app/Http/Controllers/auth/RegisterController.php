<?php

// app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:6|confirmed',
            'role'                  => 'required|exists:roles,id',
            'position'              => 'required|string|max:255',
            'department'            => 'required|string|max:255',
            'organization'          => 'required|string|max:255',
        ]);
        $role = Role::find($request->role);
        if ($role && strtolower($role->name) === 'reviewer') {
            $request->validate([
                'field' => 'required|array|min:1|max:3',  // 1 to 3 topics selected
                'field.*' => 'string|max:255',
            ]);
        }

        // Prepare field string (comma-separated) if role is reviewer
        $fieldString = null;
        if ($request->has('field')) {
            $fieldString = implode(',', $request->field);
        }

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'position'      => $request->position,
            'department'    => $request->department,
            'organization'  => $request->organization,
            'field'         => $fieldString,
        ]);

        if ($role) {
            $user->roles()->attach($role->id);
        }

        // If reviewer, do NOT auto-login and show info to wait for approval
        if ($role && strtolower($role->name) === 'reviewer') {
            return redirect()->route('guest.home', ['section' => 'login'])
                ->with('info', 'Registration successful! Please wait for admin approval.');
        }

        // Auto-login other roles
        Auth::login($user);

        // Redirect after login based on role
        if (Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->intended('/dashboard')->with('success', 'Registration successful!');
        } else {
            return redirect()->intended('/')->with('success', 'Registration successful!');
        }
    }
}