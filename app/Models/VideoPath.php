<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPath extends Model
{
    use HasFactory;

    protected $connection = 'second_db'; // Menggunakan database kedua
    protected $table = 'videos'; // Nama tabel
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    
    public $timestamps = false;
}

