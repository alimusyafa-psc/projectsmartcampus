<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class riwayatakses extends Model
{
    use HasFactory;
    
    protected $table = 'tbriwayatakses'; // Nama tabel riwayat akses
    
    protected $primaryKey = 'id_riwayat'; // Primary key tabel ini
    
    // Definisikan relasi antara RiwayatAkses dan Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}
