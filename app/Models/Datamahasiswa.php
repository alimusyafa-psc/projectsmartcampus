<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Relay; // <<-- tambahkan ini

class Datamahasiswa extends Model
{
    use HasFactory;

    protected $table = 'tbmahasiswa'; // Tabel mahasiswa
    protected $primaryKey = 'id_mahasiswa';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function setDatabaseConnection($connection)
    {
        $this->setConnection($connection);
        return $this;
    }

    public function relay()
    {
        return $this->hasOne(Relay::class, 'uid', 'uid')->withDefault(); 
    }
}
