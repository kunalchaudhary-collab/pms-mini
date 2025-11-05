<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showRegister()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }
    public function showLogin()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function register(Request $r)
    {
        if(Auth::check()){
            return redirect()->route('login');
        }
        $r->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:4'
        ]);
        $user = User::create([
            'name' => $r->name,
            'email' => $r->email,
            'password' => Hash::make($r->password)
        ]);
        Auth::login($user);
        logActivity("$user->email:-  User registered", ['user_id' => $user->id, 'email' => $user->email ]);
        return redirect()->route('dashboard');
    }

    public function login(Request $r)
    {
        $credentials = $r->validate(['email' => 'required|email|exists:users,email', 'password' => 'required']);
        if (Auth::attempt($credentials)) {
            $r->session()->regenerate();
            $user=Auth::user();
            logActivity("$user->email:- :-User logged in", ['user_id' => auth()->id()]);
            return redirect()->route('dashboard');
        }
        Log::error("Invalid credentials by $r->email");
        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    public function logout(Request $r)
    {
        $user=Auth::user();
        logActivity("$user->email:- :User logged out", ['user_id' => auth()->id()]);
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login');
    }
}
