<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IsLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/sesi')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();
        $routeName = $request->route()->getName(); // Dapatkan nama route

        // Izinkan akses ke logout tanpa cek role
        if ($routeName === 'logout') {
            return $next($request);
        }

        // Cek akses berdasarkan role
        if (!$this->hasAccess($user, $routeName)) {
            return redirect('/storage')->with('error', 'Anda tidak memiliki akses ke halaman');
        }

        return $next($request);
    }


    protected function hasAccess($user, ?string $routeName): bool
    {
       $accessRules = [
    'ADMIN' => [
        'storage',
        'datamahasiswa', 'datamahasiswa.create', 'datamahasiswa.store', 'datamahasiswa.import', 'datamahasiswa.delete',
        'mahasiswa', 'mahasiswa.create',
        'jadwal', 'jadwal.create', 'jadwal.store', 'jadwal.delete',
        'tamu', 'tamu.create', 'tamu.store', 'tamu.import',
        'path', 'path.create', 'path.store', 'path.delete',
        'profile', 'profile.update',
        'signup', 'signup.post'
    ],
    'TAMU' => [
        'storage',
        'tamu', 'tamu.create', 'tamu.store', 'tamu.import',
        'path', 'path.create', 'path.store', 'path.delete',
        'profile', 'profile.update',
    ],
    'MAHASISWA' => [
        'storage',
        'datamahasiswa', 'datamahasiswa.create', 'datamahasiswa.store', 'datamahasiswa.import',
        'mahasiswa', 'mahasiswa.create',
        'jadwal', 'jadwal.create', 'jadwal.store', 'jadwal.delete',
        'profile', 'profile.update',
    ],
];


        $role = $user->isAdmin() ? 'ADMIN' : 
               ($user->isTamu() ? 'TAMU' : 
               ($user->isMahasiswa() ? 'MAHASISWA' : null));

        return in_array($routeName, $accessRules[$role] ?? []);
    }
}
