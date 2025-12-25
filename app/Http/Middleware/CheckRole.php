<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    // dd([
    //    'apakah_login_terdeteksi' => Auth::check(),
    //    'isi_semua_data_user' => Auth::user() ? Auth::user()->getAttributes() : 'User tidak terbaca',
    //    'role_terdeteksi' => Auth::user() ? Auth::user()->role : 'Role kosong',
    // ]);

    // 1. Pastikan user sudah login (sebagai pengaman tambahan)
    if (!Auth::check()) {
        return redirect('login');
    }

    // 2. Ambil role user saat ini
    $userRole = Auth::user()->role;

    // 3. Cek apakah role user ada di dalam daftar $roles yang dikirim dari route
    // Menggunakan in_array karena $roles adalah sebuah array
    if (!in_array($userRole, $roles)) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    return $next($request);
}
}
