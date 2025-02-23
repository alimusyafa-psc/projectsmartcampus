<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPath extends Model
{
    use HasFactory;

    protected $table = 'videos'; // Nama tabel
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    
    public $timestamps = false;

    /**
     * Set koneksi database secara dinamis.
     */
    public function setDatabaseConnection($connection)
    {
        $this->setConnection($connection);
        return $this;
    }
}


