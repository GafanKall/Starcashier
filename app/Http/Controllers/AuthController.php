<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index () {
        return view('auth.register');
    }

    public function store (Request $request) {
        $request->validate([
            'email' => 'required | email:dns | unique:users',
            'username' => 'required | unique:users',
            'password' => 'required|min:6',
        ]);

        $register = User::create([

            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully, please login.');
    }

    public function login() {
        return view('auth.login');
    }

    public function auth(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended('admin/home');
            } elseif ($user->role === 'petugas') {
                return redirect()->intended('petugas/home');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }
}
