<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($data)) {
            // Jika autentikasi berhasil
            return redirect()->route('admin.dashboard');
        } else {
            // Jika autentikasi gagal
            // Di dalam controller
            return redirect()->route('login')->with('failed', 'Email atau kata sandi salah.');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah berhasil Logout.');
    }
}
