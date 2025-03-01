<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Storage extends Model
{
    use HasFactory;

    protected $connection = 'db_storage'; 
    protected $table = 'storage_usage'; 
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public $timestamps = false;
}
