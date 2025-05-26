<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Relay extends Model
{
    use HasFactory;

    protected $table = 'tbrelay'; 
    protected $primaryKey = 'id_relay';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function mahasiswa()
    {
        return $this->belongsTo(Datamahasiswa::class, 'uid', 'uid');
    }
    
    public function setDatabaseConnection($connection)
    {
        $this->setConnection($connection);
        return $this;
    }
}
