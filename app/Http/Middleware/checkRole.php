<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();
        if ($user && in_array($user->role->role ?? '', $roles)) {
            return $next($request);
        }
        
        // Jika akun pelanggan biasa mengakses halaman POS/Admin, arahkan ke Dashboard Pelanggan
        if ($user && $user->isPelanggan()) {
            return redirect()->route('customer.pesanan')->with('warning', 'Halaman tersebut khusus untuk Kasir / Petugas Toko.');
        }

        abort(403, 'Tidak Ada Akses !');
    }
}
