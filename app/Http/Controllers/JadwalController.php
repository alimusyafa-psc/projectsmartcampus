<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
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
        return view('jadwal.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'id_kelas' => 'required|unique:mysql.tb_kelas,id_kelas',
            'mata_kuliah' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['kelas', 'id_kelas', 'mata_kuliah', 'waktu_mulai', 'waktu_selesai']);

            (new Jadwal())->setDatabaseConnection('mysql')->create($data);
            (new Jadwal())->setDatabaseConnection('db_mahasiswa')->create($data);

            DB::commit();
            return redirect('/jadwal')->with('success', 'Jadwal berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/jadwal/create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id_kelas)
    {
        $jadwal = (new Jadwal())->setDatabaseConnection('mysql')->findOrFail($id_kelas);
        return view('jadwal.create', compact('jadwal')); // <== view diubah
    }

    public function update(Request $request, $id_kelas)
    {
        $request->validate([
            'kelas' => 'required',
            'mata_kuliah' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['kelas', 'mata_kuliah', 'waktu_mulai', 'waktu_selesai']);

            // Update database utama
            $jadwal1 = (new Jadwal())->setDatabaseConnection('mysql')->findOrFail($id_kelas);
            $jadwal1->update($data);

            // Update database kedua
            $jadwal2 = (new Jadwal())->setDatabaseConnection('db_mahasiswa')->find($id_kelas);
            if ($jadwal2) {
                $jadwal2->update($data);
            }

            DB::commit();
            return redirect('/jadwal')->with('success', 'Jadwal berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
