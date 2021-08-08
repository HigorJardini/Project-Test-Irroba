<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LogoutUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Validar se o usúario está realmente ativo
        if (Auth::user()->deleted_at || !Auth::user()->active) {
            return redirect()->route('login.logout');
        } else
            return $next($request);
    }
}
