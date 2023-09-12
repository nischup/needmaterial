<?php

namespace App\Http\Middleware;

use App\Models\UserProfile;
use Closure;
use Illuminate\Http\Request;

class ProfileCompleteStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if (auth()->user()->hasRole('super_admin')) {
                return $next($request);
            }

            view()->share('complete_profile', profileStatusCompleted());
        }

        return $next($request);
    }
}
