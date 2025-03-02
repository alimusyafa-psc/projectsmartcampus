<?php

namespace App\Http\Controllers;

use App\Models\riwayatakses;
use Illuminate\Http\Request;

class MahasiswasController extends Controller
{
    public function index()
    {
        $riwayatAkses = RiwayatAkses::with('mahasiswa')
            ->orderBy('id_riwayat', 'desc')
            ->paginate(10);
    
        return view('mahasiswa.index', compact('riwayatAkses'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }
    
}
