<?php

namespace App\Http\Controllers;

use App\Models\riwayatakses;
use Illuminate\Http\Request;

class MahasiswasController extends Controller
{
    public function index()
    {
        $riwayatAkses = RiwayatAkses::with('mahasiswa')->get();
        return view('mahasiswa.index', compact('riwayatAkses'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }
    
}
