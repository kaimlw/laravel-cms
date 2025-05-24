<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman login
     */
    function index() : View|RedirectResponse{
        // Jika pengguna sudah login diarahkan ke halaman dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('login');
    }

    /**
     * (POST)
     * Memproses login pengguna 
     */
    function authenticate(Request $request) : RedirectResponse {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ],[
            'username.required' =>  'Masukkan nama pengguna!',
            'password.required' =>  'Masukkan password!'
        ]); 

        // Pengecekan login ke database
        if (!Auth::attempt($credentials, $request->rememberCheck)) {
            // Jika gagal kembali ke halaman login dengan error message
            return back()->withErrors([
                'username' => 'Username atau password anda salah',
            ])->onlyInput('username');
        }
        
        // Cek apakah user memiliki web_id sesuai dengan subdomain
        $web_id = CustomHelpers::get_webid_subdomain();
        if (!CustomHelpers::check_username_in_web($request->username, $web_id)) {
            // Jika gagal kembali ke halaman login dengan error message
            Auth::logout();
            return back()->withErrors([
                'username' => 'Username anda tidak terdaftar',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
        
        
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
