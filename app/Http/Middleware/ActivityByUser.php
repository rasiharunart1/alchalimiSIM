<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivityByUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $expiresAt = now()->addMinutes(1); // Cache for 1 minute to avoid too many DB writes
            cache()->remember('user-is-online-' . auth()->id(), $expiresAt, function () {
                return true;
            });
            
            // Direct update for simple tracker (or use cache if high traffic)
            auth()->user()->update(['last_seen' => now()]);
        }

        return $next($request);
    }
}
