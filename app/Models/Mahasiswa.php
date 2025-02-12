<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Mahasiswa extends Model
{
    protected $connection = 'mysql'; // Nama koneksi yang sesuai dengan konfigurasi di database.php
    protected $table = 'tbmahasiswa'; // Tabel yang menyimpan data mahasiswa
    protected $primaryKey = 'id_mahasiswa'; // Misalnya, jika primary key-nya bukan 'id'

    use HasFactory;
}
