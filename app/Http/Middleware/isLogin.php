<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // mengecek apakah dia ada riwayat login Auth::check
        if (Auth::check()) {
            // jika ada, diperbolehkan akses
            return $next($request);
        } else {
            // jika tidak ada, dikembalikan ke login
            return redirect()->route('login')->with('failed', 'Silahkan Login terlebih dahulu!');
        }
    }
}
