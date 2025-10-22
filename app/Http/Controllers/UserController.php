<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // Tampilkan halaman profil
    public function profile()
    {
        return view('user.profile');
    }

    // Tampilkan form edit profil
    public function editProfile()
    {
        return view('user.profile_edit');
    }

    // Proses update profil
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            // DIUBAH: Ditambahkan aturan 'unique' untuk email
            // Ini akan mengecek email unik, KECUALI untuk 'id_user' milik user ini.
            'email' => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    // Tampilkan form ubah password
    public function changePassword()
    {
        return view('user.profile_password');
    }

    // Proses update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        // DIUBAH: Hapus 'Hash::make()'.
        // Model User Anda akan otomatis men-hash ini karena 
        // memiliki cast 'password' => 'hashed'.
        $user->password = $request->new_password;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Password berhasil diubah.');
    }
}
