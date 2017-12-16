<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class UserGroup
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

        if(Session::has('upgid'))
            $upgid = Session::get('upgid');
        return $next($request);
    }
}
