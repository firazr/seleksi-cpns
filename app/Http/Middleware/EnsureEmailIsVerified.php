<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Skip verification check for admin users
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        if (!$request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('warning', 'Anda harus memverifikasi email terlebih dahulu.');
        }

        return $next($request);
    }
}
