<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the role of 'seller'
        if (Auth::check() && Auth::user()->role === 'seller') {
            return $next($request);
        }

        // If not a seller, redirect or abort
        return redirect('/login')->with('error', 'You do not have seller access.');
        // Or:
        // abort(403, 'Unauthorized access.');
    }
}
