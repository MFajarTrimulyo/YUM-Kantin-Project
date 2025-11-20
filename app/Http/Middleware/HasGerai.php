<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasGerai
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Pastikan user adalah Penjual
        if ($user && $user->role === 'penjual') {
            
            // 2. Cek: Apakah dia SUDAH punya data Gerai?
            if (!$user->gerai) {
                // Jika belum punya gerai, izinkan akses ke halaman buat gerai
                if ($request->routeIs('gerai.create') || $request->routeIs('gerai.store')) {
                    return $next($request);
                }
                // Lempar ke form pembuatan gerai
                return redirect()->route('gerai.create')
                    ->with('warning', 'Silakan lengkapi profil Gerai Anda sebelum melanjutkan.');
            }

            // 3. Cek: Apakah Gerai SUDAH DIVERIFIKASI Admin?
            if ($user->gerai->is_verified == false) {
                // Izinkan akses ke halaman "Pending" agar tidak infinite loop
                if ($request->routeIs('gerai.pending')) {
                    return $next($request);
                }
                // Lempar ke halaman pending
                return redirect()->route('gerai.pending');
            }
        }

        return $next($request);
    }
}
