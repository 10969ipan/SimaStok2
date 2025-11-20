<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login backend.
     */
    public function loginBackend()
    {
        return view('backend.v_login.login', [
            'judul' => 'Login Backend'
        ]);
    }

    /**
     * Proses autentikasi login backend.
     */
    public function authenticateBackend(Request $request)
    {
        // Validasi input form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login dengan data tersebut
        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // Jika user belum aktif (status = 0)
            if ($user->status == 0) {
                Auth::logout();
                return back()->with('error', 'Akun Anda belum aktif.');
            }

            // Regenerasi session agar lebih aman
            $request->session()->regenerate();

            // Arahkan ke halaman beranda setelah login berhasil
            return redirect()->intended(route('backend.beranda'));
        }

        // Jika gagal login
        return back()->with('error', 'Email atau password salah.');
    }

    /**
     * Logout dari backend.
     */
    public function logoutBackend(Request $request)
    {
        Auth::logout();

        // Hapus dan regenerasi session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('backend.login'));
    }
}
