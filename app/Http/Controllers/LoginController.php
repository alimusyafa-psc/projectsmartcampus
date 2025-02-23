<?php

namespace App\Http\Controllers;

use App\Models\LoginPost;
use App\Models\LoginUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index() 
    {
        // Redirect authenticated users to /storage
        if (Auth::check()) {
            return redirect('/storage');
        }

        // Show login page for guests
        $admin = LoginUser::all();
        return view("auth.login", compact('admin'));    
    }

    public function create()
    {
        return view("auth.register");
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);
        LoginUser::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        LoginPost::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/sesi/signup')->with('success','Data Berhasil Ditambahkan.');    
    }
    
    function login(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ],[
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $user = LoginUser::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect('/storage')->with('success','Sukses Login');
        } else {
            return redirect('/sesi');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/sesi')->with('success', 'Anda telah berhasil logout');
    }
    
}
