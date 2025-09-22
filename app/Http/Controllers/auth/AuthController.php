<?php

namespace App\Http\Controllers\auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->roles->contains('name', 'reviewer') && is_null($user->email_verified_at)) {
                Auth::logout(); // logout the unverified reviewer
                return back()->withErrors([
                    'email' => 'Your email has not been verified.',
                ]);
            } else {


                $request->session()->regenerate();

                if (Auth::check() && Auth::user()->roles->contains('name', 'admin')) {
                    return redirect()->intended('/dashboard'); // redirect after login
                } else {
                    return redirect()->intended('/'); //ဒီမှာကeditor ရေးရမှာ
                }
            }
        }




        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/'); // or wherever you want to redirect after logout
    }
}