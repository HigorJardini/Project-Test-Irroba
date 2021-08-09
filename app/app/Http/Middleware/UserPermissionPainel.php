<?php

namespace App\Http\Middleware;

use Laratrust\LaratrustFacade as Laratrust;
use Closure;

class UserPermissionPainel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Laratrust::isAbleTo('access-panel-manage-user-permission', true))
            return $next($request);
        else
            return redirect()->route('index');
    }
}
