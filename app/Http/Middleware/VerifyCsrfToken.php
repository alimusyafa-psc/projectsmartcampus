<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    // protected $except = [
    //     //
    //   'sesi/login',
    // ];

    protected $except = [
    'sesi/login',
    'tamu',
    'tamu/import',
    'tamu/path',
    'datamahasiswa',
    'datamahasiswa/import',
    'jadwal',
    // tambahkan semua endpoint POST yang dipakai di Postman atau frontend JS tanpa token CSRF
];

}
