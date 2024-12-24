<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.auth-login');
    }

    public function dologin(Request $request)
    {
        // validasi input
        $credentials = $request->validate([
            'email' => 'required|string|email:@gmail|min:5|max:30|regex:/^[\w\.\-]+@gmail\.com$/',
            'password' => 'required|string|min:8|max:16',

        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid.',
            'email.max' => 'Username terlalu panjang.',
            'email.min' => 'Username terlalu pendek.',
            'email.regex' => 'Email tidak valid.',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter.',
            'password.max' => 'Password terlalu panjang.',
        ]);


        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Username tidak terdaftar.']);
        }

        // Cek apakah password cocok
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'password salah, silahkan coba lagi']);
        }


        // Jika semua validasi berhasil, coba autentikasi
        if (auth()->attempt($credentials)) {
            // Buat ulang session login
            $request->session()->regenerate();

            // Redirect berdasarkan role
            return redirect()->intended(auth()->user()->role_id === 1 ? '/admin' : '/customer');
        }

        // Jika email atau password salah
        return back()->with('error', 'Email atau password salah.');
    }


    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register()
    {
        return view('pages.auth.auth-register');
    }

    // Handle the registration logic
    public function doRegister(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:@gmail|min:5|max:30|unique:users|regex:/^[\w\.\-]+@gmail\.com$/',
            'password' => 'required|string|min:8|max:16|confirmed',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Email tidak valid.',
            'email.min' => 'Email terlalu pendek',
            'email.max' => 'Email terlalu panjang',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
            'email.regex' => 'Email tidak valid',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 8 karakter. Silakan masukkan password yang lebih panjang.',
            'password.max' => 'Password terlalu panjang. Maksimal 16 karakter.',
            'password.confirmed' => 'Password dan konfirmasi password tidak cocok. Silakan coba lagi.',
        ]);


        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        // Log the user in
        auth()->login($user);

        // Redirect to appropriate dashboard
        return redirect()->intended('/customer');
    }
}
