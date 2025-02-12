<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class riwayattamu extends Model
{
    use HasFactory;
    protected $connection = 'second_db'; // Koneksi ke database kedua

    protected $table = 'user_video_access'; // Nama tabel riwayat akses
    
    protected $primaryKey = 'id'; // Primary key tabel ini
    
    // Definisikan relasi antara RiwayatAkses dan Mahasiswa
    public function tamu()
    {
        return $this->belongsTo(Tamu::class, 'user_id');
    }}
