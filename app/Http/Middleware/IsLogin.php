<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


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
            'ADMIN' => ['storage', 'datamahasiswa', 'jadwal', 'jadwal.store', 'jadwal.create', 'jadwal.edit', 'jadwal.update', 'mahasiswa', 'tamu', 'register', 'path', 'profile', 'profile.update', 'datamahasiswa.import', 'tamu.import', 'path.edit', 'path.update'],
            'TAMU' => ['storage', 'tamu', 'register', 'path', 'profile', 'profile.update', 'tamu.import', 'path.edit', 'path.update'],
            'MAHASISWA' => ['storage', 'jadwal', 'datamahasiswa', 'mahasiswa', 'register', 'profile', 'profile.update', 'datamahasiswa.import', 'jadwal.store', 'jadwal.create', 'jadwal.edit', 'jadwal.update']
        ];

        $role = $user->isAdmin() ? 'ADMIN' : ($user->isTamu() ? 'TAMU' : ($user->isMahasiswa() ? 'MAHASISWA' : null));

        return in_array($routeName, $accessRules[$role] ?? []);
    }
}
