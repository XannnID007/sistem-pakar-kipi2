<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str; 
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form register
    public function showRegister()
    {
        return view('register');
    }

    // Proses register 
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:10|confirmed',
        ]);

        // Set role default untuk pengguna baru (orang tua)
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'orang_tua',
        ]);

        return redirect()->route('login.form')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Tampilkan form login
    public function showLogin()
    {
        return view('login');
    }

    // Proses login 
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Hanya 2 role: bidan_desa & orang_tua
            if ($user->role === 'bidan_desa') {
                return redirect()->route('pakar.dashboard');
            } else { 
                return redirect()->route('dashboard.user');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    // Form lupa password
    public function formLupaPassword()
    {
        return view('auth.lupa_password');
    }

    // Kirim link reset password ke email
    public function kirimLinkReset(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset kata sandi telah dikirim ke email Anda.')
            : back()->withErrors(['email' => 'Email tidak ditemukan atau gagal mengirim.']);
    }

    // Form atur ulang password baru
    public function formAturPasswordBaru($token)
    {
        return view('auth.password_baru', ['token' => $token]);
    }

    // Reset password proses submit
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login.form')->with('status', 'Kata sandi berhasil diatur ulang. Silakan login.')
            : back()->withErrors(['email' => 'Reset gagal. Silakan ulangi kembali.']);
    }
}
