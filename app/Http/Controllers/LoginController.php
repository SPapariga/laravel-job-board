<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // @desc Show login form
    // @route GET /login
    public function login() : View
    {
        return view('auth.login');
    }

    // @desc Authenticate User
    // @route POST /login
    public function authenticate(Request $request) : RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|max:100|email',
            'password' => 'required|string',
        ]);

        // dd($credentials);
        //Attempt to autenticate user
        if(Auth::attempt($credentials)){
            //Regenerate the session to prevent fixation attacks
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success','You are now logged in');
        }

        // if auth fails redirect back with error
        return back()->withErrors([
            'email'=> 'The provided credentials do not match our records'
        ])->onlyInput('email');


        // //hash password
        // $validatedData['password'] = Hash::make($validatedData['password']);

        // $user = User::create($validatedData);

        // return redirect()->route('login')->with('success','You are registered and can login');
        // return view('auth.register');
    }

    // @desc Logout
    // @route POST /logout
    public function logout(Request $request) : RedirectResponse
    {
        // return view('auth.login');
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}
