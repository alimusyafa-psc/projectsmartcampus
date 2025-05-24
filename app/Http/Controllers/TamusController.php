<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTamu;
use App\Models\Tamu;
use App\Models\TamuPost;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
                
                $validated = Validator::make($row->toArray(), [
                    '0' => 'required', // name
                    '1' => 'required', // asal
                    '2' => 'required', // rfid
                    '3' => 'required', // pekerjaan
                    '4' => 'required', // preferences
                    '5' => 'required', // tanggal_kunjungan (required)
                ])->validate();
                
                $name = $row[1];
                $asal = $row[2];
                $rfid = $row[0];
                $pekerjaan = $row[3];
                $preferences = $row[4];
                
                // Handle tanggal dari Excel (tanggal manual, waktu auto)
                $last_visit = null;
                try {
                    $currentTime = now()->setTimezone('Asia/Jakarta');
                    
                    // Jika berupa angka (Excel serial number)
                    if (is_numeric($row[5]) && $row[5] > 1000) {
                        try {
                            $excelDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]);
                            // Gabungkan tanggal dari Excel dengan waktu sekarang
                            $last_visit = $excelDate->format('Y-m-d') . ' ' . $currentTime->format('H:i:s');
                        } catch (\Exception $e) {
                            // Lanjut ke format string
                        }
                    }
                    
                    // Jika belum berhasil, coba format string
                    if (!$last_visit) {
                        $dateFormats = ['d/m/Y','Y/m/d'];
                        
                        foreach ($dateFormats as $format) {
                            $date = \DateTime::createFromFormat($format, $row[5]);
                            if ($date !== false && $date->format($format) === $row[5]) {
                                // Gabungkan tanggal dari Excel dengan waktu sekarang
                                $last_visit = $date->format('Y-m-d') . ' ' . $currentTime->format('H:i:s');
                                break;
                            }
                        }
                    }
                    
                    // Jika masih gagal, coba dengan strtotime
                    if (!$last_visit) {
                        $timestamp = strtotime($row[5]);
                        if ($timestamp !== false) {
                            $dateOnly = date('Y-m-d', $timestamp);
                            $last_visit = $dateOnly . ' ' . $currentTime->format('H:i:s');
                        }
                    }
                    
                    // Jika semua gagal, throw error
                    if (!$last_visit) {
                        throw new \Exception("Format tanggal tidak valid: " . $row[5]);
                    }
                    
                } catch (\Exception $e) {
                    throw new \Exception("Error parsing tanggal pada baris " . ($index + 1) . ": " . $e->getMessage());
                }
                
                // Simpan ke tabel Tamu
                Tamu::create([
                    'name' => $name,
                    'asal' => $asal,
                    'rfid' => $rfid,
                    'pekerjaan' => $pekerjaan,
                    'preferences' => $preferences,
                    'last_visit' => $last_visit,
                ]);
                
                // Simpan ke tabel TamuPost
                TamuPost::create([
                    'name' => $name,
                    'asal' => $asal,
                    'rfid' => $rfid,
                    'pekerjaan' => $pekerjaan,
                    'preferences' => $preferences,
                    'last_visit' => $last_visit,
                ]);
            }
            
            DB::commit();
            return back()->with('success', 'Data berhasil diimport dari Excel.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}