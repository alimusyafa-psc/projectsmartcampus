<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable; // Tambahkan ini
use Illuminate\Auth\Authenticatable as AuthenticatableTrait; // Tambahkan ini

class LoginUser extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait; // Gunakan trait Authenticatable

    protected $connection = 'mysql_third'; // Nama koneksi sesuai dengan konfigurasi database.php
    protected $table = 'admin'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public $timestamps = false;
}
