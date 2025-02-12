<?php

namespace App\Http\Controllers;

use App\Models\LoginUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function index() 
    {
        // Ambil semua data dari tabel tbmahasiswa
        $admin = LoginUser::all();

        // Kirim data ke view
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
        ]);
        LoginUser::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
            return 'gagal';
        }
        
    }
}
