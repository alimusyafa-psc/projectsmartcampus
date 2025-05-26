<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TamuPost extends Model
{
    protected $connection = 'db_tamu'; // Nama koneksi sesuai dengan konfigurasi database.php
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $guarded = ['id'];
    
    public $timestamps = false; // Tambahkan ini
}
