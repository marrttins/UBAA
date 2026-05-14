<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $allowedRoles = ['chairman', 'secretary', 'pro', 'admin'];
        if (!in_array(auth()->user()->role, $allowedRoles)) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
