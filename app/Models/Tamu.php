<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tamu extends Model
{
    use HasFactory;

    protected $connection = 'second_db';
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $guarded = ['id'];
    
    public $timestamps = false; // Tambahkan ini
}

