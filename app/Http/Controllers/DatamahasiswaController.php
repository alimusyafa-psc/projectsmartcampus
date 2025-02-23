<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datamahasiswa; // Pastikan model diimport
use Illuminate\Support\Facades\DB;

class DatamahasiswaController extends Controller
{
    public function index()
    {
        $tbmahasiswa = (new Datamahasiswa())->setDatabaseConnection('mysql')->get();
        return view('datamahasiswa.index', compact('tbmahasiswa'));
    }

    public function create()
    {
        return view('datamahasiswa.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'nama' => 'required',
            'nrp' => 'required',
            'kelas' => 'required',
            'Departemen' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Simpan ke database utama
            (new Datamahasiswa())->setDatabaseConnection('mysql')->create([
                'uid' => $request->uid,
                'nama' => $request->nama,
                'nrp' => $request->nrp,
                'kelas' => $request->kelas,
                'Departemen' => $request->Departemen,
            ]);

            // Simpan ke database kedua
            (new Datamahasiswa())->setDatabaseConnection('db_mahasiswa')->create([
                'uid' => $request->uid,
                'nama' => $request->nama,
                'nrp' => $request->nrp,
                'kelas' => $request->kelas,
                'Departemen' => $request->Departemen,
            ]);

            DB::commit();
            return redirect('/datamahasiswa')->with('success', 'Data berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/datamahasiswa/create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }    }
    
    public function destroy($id_mahasiswa)
    {         
        
        try {
            DB::beginTransaction(); // Mulai transaksi
    
            // Hapus dari database utama
            $tbmahasiswa = (new Datamahasiswa())->setDatabaseConnection('mysql')->find($id_mahasiswa);
            if ($tbmahasiswa) {
                $tbmahasiswa->delete();
            }
    
            // Hapus dari database kedua
            $tbmahasiswa2 = (new Datamahasiswa())->setDatabaseConnection('db_mahasiswa')->find($id_mahasiswa);
            if ($tbmahasiswa2) {
                $tbmahasiswa2->delete();
            }
    
            DB::commit(); // Commit transaksi jika sukses
            return redirect('/datamahasiswa')->with('success', 'Data berhasil Dihapus.');
    
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika ada kesalahan
            return redirect('/datamahasiswa/create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
