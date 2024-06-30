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
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
        ]);

        // Update data user
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
