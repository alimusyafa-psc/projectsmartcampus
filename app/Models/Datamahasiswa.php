<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datamahasiswa extends Model
{
    use HasFactory;

    protected $table = 'tbmahasiswa'; // Tabel yang menyimpan data mahasiswa
    protected $primaryKey = 'id_mahasiswa';
    protected $guarded = ['id'];

    public $timestamps = false; // Tambahkan ini

    public function setDatabaseConnection($connection)
    {
        $this->setConnection($connection);
        return $this;
    }
}
