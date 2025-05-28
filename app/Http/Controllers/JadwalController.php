<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal; // Pastikan model diimport
use Illuminate\Support\Facades\DB;


class JadwalController extends Controller
{
    public function index()
    {
        $tbkelas = (new Jadwal())->setDatabaseConnection('mysql')->get();
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
            'id_kelas' => 'required',


        ]);
        try {
            DB::beginTransaction();

            // Simpan ke database utama
            (new Jadwal())->setDatabaseConnection('mysql')->create([
                'kelas' => $request->kelas,
                'id_kelas' => $request->id_kelas,
                'mata_kuliah' => $request->mata_kuliah,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
            ]);

            // Simpan ke database kedua
            (new Jadwal())->setDatabaseConnection('db_mahasiswa')->create([
                'kelas' => $request->kelas,
                'id_kelas' => $request->id_kelas,
                'mata_kuliah' => $request->mata_kuliah,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
            ]);

            DB::commit();
            return redirect('/jadwal')->with('success', 'Jadwal berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/datamahasiswa/create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($id_kelas)
    {

        try {
            DB::beginTransaction(); // Mulai transaksi

            // Hapus dari database utama
            $tbkelas = (new Jadwal())->setDatabaseConnection('mysql')->find($id_kelas);
            if ($tbkelas) {
                $tbkelas->delete();
            }

            // Hapus dari database kedua
            $tbkelas2 = (new Jadwal())->setDatabaseConnection('db_mahasiswa')->find($id_kelas);
            if ($tbkelas2) {
                $tbkelas2->delete();
            }

            DB::commit(); // Commit transaksi jika sukses
            return redirect('/jadwal')->with('success', 'Data berhasil Dihapus.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika ada kesalahan
            return redirect('/jadwal/create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
