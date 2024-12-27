<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Mengambil data user yang sedang login
        return view('pages.app.profile.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user(); // Mengambil data user yang sedang login
        return view('pages.app.profile.edit', compact('user'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
<<<<<<< HEAD
            'phone' => 'required|nullable|string|min:11|max:20',
            'email' => 'required|string|email|min:5|max:30|regex:/^[\w\.-]+@[\w\.-]+\.\w+$/|unique:users,email,' . $user->id,
            'address' => 'required|nullable|string|max:255',

        ], [
            'name.required' => 'nama tidak boleh kosong',
            'phone.required' => 'nomor telepon tidak boleh kosong',
            'phone.min' => 'nomor telepon yang anda masukkan kurang',
            'phone.max' => 'nomor telepon yang anda masukkan terlalu panjang',
            'email.required' => 'email tidak boleh kosong',
            'email.min' => 'Email terlalu pendek',
            'email.max' => 'Email terlalu panjang',
            'email.regex' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
            'address.required' => 'alamat rumah tidak boleh kosong',
=======
            'phone' => 'nullable|string|max:20|regex:/^[0-9+\-\s]*$/',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
>>>>>>> d09a30915e62852e7366215391d69973fd2286f0
        ]);

        // Update data user
        $user->name = $request->input('name');
        $user->phone = $request->input('phone'); //preg_replace('/\D/','',
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}

