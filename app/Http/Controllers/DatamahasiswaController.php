<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datamahasiswa; // Pastikan model diimport
use App\Models\Relay; // Pastikan model diimport
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class DatamahasiswaController extends Controller
{

    public function index()
    {
        $tbmahasiswa = (new Datamahasiswa())
            ->setDatabaseConnection('mysql')
            ->with('relay') // Memuat relasi relay
            ->get();
    
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
            'relay' => 'required' // Tambahkan untuk relay
        ]);
    
        try {
            DB::beginTransaction();
    
            // Simpan ke database utama
            $mahasiswa = (new Datamahasiswa())->setDatabaseConnection('mysql')->create([
                'uid' => $request->uid,
                'nama' => $request->nama,
                'nrp' => $request->nrp,
                'kelas' => $request->kelas,
                'Departemen' => $request->Departemen,
            ]);
    
            (new Relay())->setDatabaseConnection('mysql')->create([
                'uid' => $request->uid,
                'relay' => $request->relay,
            ]);
    
            // Simpan ke database kedua
            (new Datamahasiswa())->setDatabaseConnection('db_mahasiswa')->create([
                'uid' => $request->uid,
                'nama' => $request->nama,
                'nrp' => $request->nrp,
                'kelas' => $request->kelas,
                'Departemen' => $request->Departemen,
            ]);
    
            (new Relay())->setDatabaseConnection('db_mahasiswa')->create([
                'uid' => $request->uid,
                'relay' => $request->relay,
            ]);
    
            DB::commit();
            return redirect('/datamahasiswa')->with('success', 'Data berhasil ditambahkan.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/datamahasiswa/create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
public function importExcel(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);
    
    try {
        $data = Excel::toCollection(null, $request->file('file'))[0]; // Hanya ambil sheet pertama
        
        DB::beginTransaction();
        
        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Lewati header
            
            // Konversi dan bersihkan data
            $uid = isset($row[0]) ? trim((string)$row[0]) : '';
            $nama = isset($row[1]) ? trim((string)$row[1]) : '';
            $nrp = isset($row[2]) ? trim((string)$row[2]) : '';
            $kelas = isset($row[3]) ? trim((string)$row[3]) : '';
            $departemen = isset($row[4]) ? trim((string)$row[4]) : '';
            $relay = isset($row[5]) ? trim((string)$row[5]) : '';
            
            // Simple check - skip jika ada data penting yang kosong
            if (!$uid || !$nama || !$nrp) {
                continue; // Skip baris yang tidak memiliki data utama
            }
            
            // Simpan ke database utama
            (new Datamahasiswa())->setDatabaseConnection('mysql')->create([
                'uid' => $uid,
                'nama' => $nama,
                'nrp' => $nrp,
                'kelas' => $kelas ?: '', // Default empty string jika kosong
                'Departemen' => $departemen ?: '',
            ]);
            
            (new Relay())->setDatabaseConnection('mysql')->create([
                'uid' => $uid,
                'relay' => $relay ?: '', // Default empty string jika kosong
            ]);
            
            // Simpan ke database kedua
            (new Datamahasiswa())->setDatabaseConnection('db_mahasiswa')->create([
                'uid' => $uid,
                'nama' => $nama,
                'nrp' => $nrp,
                'kelas' => $kelas ?: '',
                'Departemen' => $departemen ?: '',
            ]);
            
            (new Relay())->setDatabaseConnection('db_mahasiswa')->create([
                'uid' => $uid,
                'relay' => $relay ?: '',
            ]);
        }
        
        DB::commit();
        return back()->with('success', 'Data berhasil diimport dari Excel.');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal import: ' . $e->getMessage());
    }
}
    public function destroy($id_mahasiswa)
    {
        try {
            DB::beginTransaction(); // Mulai transaksi
    
            // Ambil data mahasiswa dari database utama
            $tbmahasiswa = (new Datamahasiswa)->setDatabaseConnection('mysql')->find($id_mahasiswa);
            if ($tbmahasiswa) {
                // Hapus juga data di tbrelay yang memiliki uid yang sama
                (new Relay)->setDatabaseConnection('mysql')
                    ->where('uid', $tbmahasiswa->uid)
                    ->delete();
                
                $tbmahasiswa->delete();
            }
    
            // Ambil data mahasiswa dari database kedua
            $tbmahasiswa2 = (new Datamahasiswa)->setDatabaseConnection('db_mahasiswa')->find($id_mahasiswa);
            if ($tbmahasiswa2) {
                // Hapus juga data di tbrelay dari database kedua
                (new Relay)->setDatabaseConnection('db_mahasiswa')
                    ->where('uid', $tbmahasiswa2->uid)
                    ->delete();
                
                $tbmahasiswa2->delete();
            }
    
            DB::commit(); // Commit transaksi jika sukses
            return redirect('/datamahasiswa')->with('success', 'Data berhasil dihapus.');
    
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika ada kesalahan
            return redirect('/datamahasiswa')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
}
