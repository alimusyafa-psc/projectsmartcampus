<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginUser;

class ProfileController extends Controller
{
    public function index($id)
    {
        $user = LoginUser::findOrFail($id); 
        return view('profile.index', compact('user'));
    }
    

    public function update(Request $request, $id)
    {
        $user = LoginUser::where('id', $id)->firstOrFail();
    
        $request->validate([
            'nama' => 'required|string|max:255',
            'password_lama' => 'required',
            'password_baru' => 'nullable|min:6',
            'password_konfirmasi' => 'same:password_baru',
        ]);
    
        // Cek password lama
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama salah']);
        }
    
        // Update nama
        $user->nama = $request->nama;
    
        // Update password jika diisi
        if ($request->filled('password_baru')) {
            $user->password = Hash::make($request->password_baru);
        }
    
        $user->save();
    
        return redirect()->route('profile', ['id' => $user->id])->with('success', 'Profil berhasil diperbarui');
    }
    
}
