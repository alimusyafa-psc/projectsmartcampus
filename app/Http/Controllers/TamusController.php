<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTamu;
use App\Models\Tamu;
use App\Models\TamuPost;
use Illuminate\Http\Request;

class TamusController extends Controller
{
    public function index()
    {
        $riwayatTamu = RiwayatTamu::with('tamu')
            ->orderBy('id', 'desc')
            ->paginate(10);
    
        return view('tamu.index', compact('riwayatTamu'));
    }
    
    public function create()
    {
        return view('tamu.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
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
            'last_visit' => $data['last_visit'],
        ]);

        TamuPost::create([
            'name' => $request->name,
            'asal' => $request->asal,
            'rfid' => $request->rfid,
            'pekerjaan' => $request->pekerjaan,
            'preferences' => $request->preferences,
            'last_visit' => $data['last_visit'],
        ]);

        return redirect('/tamu')->with('success', 'Data Berhasil Ditambahkan.');
    }
}
