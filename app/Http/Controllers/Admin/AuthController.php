<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman login
     */
    function index() : View{
        return view('login');
    }

    /**
     * (POST)
     * Memproses login pengguna 
     */
    function authenticate(Request $request) : RedirectResponse {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ],[
            'username.required' =>  'Masukkan nama pengguna!',
            'password.required' =>  'Masukkan password!'
        ]);
 
        if (Auth::attempt($credentials, $request->rememberCheck)) {
            $request->session()->regenerate();
 
            return redirect()->intended(route('admin.dashboard'));
        }
        
        return back()->withErrors([
            'username' => 'Username atau password anda salah',
        ])->onlyInput('username');
    }

    /**
     * (POST)
     * Logout dan hapus session
     */
    function logout(Request $request) : RedirectResponse {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
