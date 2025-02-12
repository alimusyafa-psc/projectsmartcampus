<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    public function index()
    {
        $tamus = Tamu::all();
        return view('tamu.index',compact(['tamus']));
    }
}
