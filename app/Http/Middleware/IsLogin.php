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
            return redirect('/storage')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }


    protected function hasAccess($user, ?string $routeName): bool
    {
        $accessRules = [
            'ADMIN' => ['storage', 'datamahasiswa', 'jadwal','mahasiswa','tamu','register','path'],
            'TAMU' => ['storage','tamu','register','path'],
            'MAHASISWA' => ['storage', 'jadwal','datamahasiswa','mahasiswa','register']
        ];

        $role = $user->isAdmin() ? 'ADMIN' : 
               ($user->isTamu() ? 'TAMU' : 
               ($user->isMahasiswa() ? 'MAHASISWA' : null));

        return in_array($routeName, $accessRules[$role] ?? []);
    }
}
