<?php

namespace App\Http\Controllers;

use App\Models\riwayattamu;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class TamusController extends Controller
{
    public function index()
    {
        $riwayatTamu = RiwayatTamu::with('tamu')
            ->orderBy('id', 'desc') // Mengurutkan berdasarkan ID terbaru
            ->paginate(10); // Menggunakan pagination agar tidak memunculkan semua data sekaligus
    
        return view('tamu.index', compact('riwayatTamu'));
    }
    
    public function create()
    {
        return view('tamu.create');
    }
    public function store(Request $request)
    {
        $data = $request->all(); // Ambil semua data dari request
        $data['last_visit'] = now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');    
    
        $request->validate([
            'name' => 'required',
            'asal' => 'required',
            'rfid' => 'required',
            'pekerjaan' => 'required',
            'preferences' => 'required',
        ]);

        Tamu::create([
            'name' => $request->name,
            'asal' => $request->asal,
            'rfid' => $request->rfid,
            'pekerjaan' => $request->pekerjaan,
            'preferences' => $request->preferences,
            'last_visit' => $data['last_visit'], // Pastikan nilainya ada
        ]);

        return redirect('/tamu')->with('success','Data Berhasil Ditambahkan.');
    }
    
    
    
}
