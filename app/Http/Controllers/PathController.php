<?php

namespace App\Http\Controllers;

use App\Models\VideoPath;
use Illuminate\Http\Request;

class PathController extends Controller
{
        // Menampilkan form tambah path video
        public function createPath()
        {
            return view('tamu.create_path');
        }
    
        // Menyimpan path video ke database
        public function storePath(Request $request)
        {
            $request->validate([
                'title' => 'required',
                'path' => 'required',
                'category' => 'required'
            ]);
    
            VideoPath::create([
                'title' => $request->title,
                'path' => $request->path,
                'category' => $request->category,
            ]);
    
            return redirect('/tamu/path')->with('success', 'Path video berhasil ditambahkan.');
        }
    
        // Menampilkan daftar path video
        public function indexPath()
        {
            $videos = VideoPath::all(); // Mengambil semua data tanpa pengurutan
            return view('tamu.path', compact('videos'));
        }
}
