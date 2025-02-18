<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datamahasiswa; // Pastikan model diimport

class DatamahasiswaController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel tbmahasiswa
        $tbmahasiswa = Datamahasiswa::all();

        // Kirim data ke view
        return view('datamahasiswa.index', compact('tbmahasiswa'));
    }

    public function create()
    {
        return view('datamahasiswa.create');
    }
    
    public function store(Request $request)
    {
        Datamahasiswa::create([
            'uid' => $request->uid,
            'nama' => $request->nama,
            'nrp' => $request->nrp,
            'kelas' => $request->kelas,
            'Departemen' => $request->Departemen,
        ]);

        return redirect('/datamahasiswa')->with('success','Data Berhasil Ditambahkan.');    
    }
    
    public function destroy($id_mahasiswa)
    {
        $tbmahasiswa = Datamahasiswa::find($id_mahasiswa);
        $tbmahasiswa->delete();
        return redirect('/datamahasiswa')->with('success','Data Mahasiswa Berhasil Dihapus.');
    }

}
