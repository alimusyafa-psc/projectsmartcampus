<?php

namespace App\Http\Controllers;

use App\Models\VideoPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PathController extends Controller
{
    // Menampilkan form tambah path video
    public function createPath()
    {
        return view('tamu.create_path');
    }

    // Menyimpan path video ke kedua database
    public function storePath(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'path' => 'required',
            'category' => 'required'
        ]);

        try {
            DB::beginTransaction();

            // Simpan ke database utama
            (new VideoPath())->setDatabaseConnection('second_db')->create([
                'title' => $request->title,
                'path' => $request->path,
                'category' => $request->category,
            ]);

            // Simpan ke database kedua
            (new VideoPath())->setDatabaseConnection('db_tamu')->create([
                'title' => $request->title,
                'path' => $request->path,
                'category' => $request->category,
            ]);

            DB::commit();
            return redirect('/tamu/path')->with('success', 'Path video berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/tamu/path')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menampilkan daftar path video dari database kedua
    public function indexPath()
    {
        $videos = (new VideoPath())->setDatabaseConnection('second_db')->get();
        return view('tamu.path', compact('videos'));
    }

        public function destroy($id)
        {
            try {
                DB::beginTransaction(); // Mulai transaksi
        
                // Hapus dari database utama
                $videoMain = (new VideoPath())->setDatabaseConnection('second_db')->find($id);
                if ($videoMain) {
                    $videoMain->delete();
                }
        
                // Hapus dari database kedua
                $videoSecond = (new VideoPath())->setDatabaseConnection('db_tamu')->find($id);
                if ($videoSecond) {
                    $videoSecond->delete();
                }
        
                DB::commit(); // Commit transaksi jika sukses
                return redirect('/tamu/path')->with('success', 'Data Path berhasil Dihapus.');
        
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback jika ada kesalahan
                return redirect('/tamu/path')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
}
