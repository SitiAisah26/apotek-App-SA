<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() === false) {
            // jika check nya false (artinya belum login, balikin lagi ke halaman home)
            return $next($request);
        } else {
            return redirect()->route('home')->with('login', 'anda belum login');
        }

    }
}
