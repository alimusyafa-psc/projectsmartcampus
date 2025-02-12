<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal; // Pastikan model diimport

class JadwalController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel tbmahasiswa
        $tbkelas = Jadwal::all();

        // Kirim data ke view
        return view('jadwal.index', compact('tbkelas'));
    }
    public function create()
    {
        return view('jadwal.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'mata_kuliah' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);
        Jadwal::create([
            'kelas' => $request->kelas,
            'mata_kuliah' => $request->mata_kuliah,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        return redirect('/jadwal')->with('success','Data Berhasil Ditambahkan.');    
    }

    public function destroy($id_kelas)
    {
        $tbkelas = Jadwal::find($id_kelas);
        $tbkelas->delete();
        return redirect('/jadwal')->with('success','Data Jadwal Berhasil Dihapus.');
    }
}
