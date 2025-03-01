<?php

namespace App\Http\Controllers;
use App\Models\Storage;

class StorageController extends Controller
{
    public function index()
    {
        $storage = Storage::all();
        return view('storage.index',compact(['storage']));
    }
}
