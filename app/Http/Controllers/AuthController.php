<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $r)
    {
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
        logActivity('User registered', ['user_id' => $user->id, 'email' => $user->email]);
        return redirect()->route('dashboard');
    }

    public function login(Request $r)
    {
        $credentials = $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::attempt($credentials)) {
            $r->session()->regenerate();
            logActivity('User logged in', ['user_id' => auth()->id()]);
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    public function logout(Request $r)
    {
        logActivity('User logged out', ['user_id' => auth()->id()]);
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login');
    }
}
