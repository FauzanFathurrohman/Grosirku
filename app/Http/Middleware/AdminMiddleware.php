<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
        /**
         * Handle an incoming request.
         *
         * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
         */
        public function handle(Request $request, Closure $next): Response
        {
            // Pastikan pengguna sudah login
            if (!Auth::check()) {
                return redirect('/login'); // Arahkan ke halaman login jika belum login
            }

            // Periksa apakah pengguna yang login memiliki peran admin (asumsi ada kolom 'is_admin' di tabel users)
            if (!Auth::user()->is_admin) {
                // Jika bukan admin, arahkan ke halaman beranda atau tampilkan error 403
            abort(403, 'Akses Dilarang: Anda tidak memiliki izin admin.');
        }

        return $next($request);
    }
}
    