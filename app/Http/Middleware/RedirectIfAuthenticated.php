<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            //Check Position
            $auth = \DB::table("user")->join("userpositiongroup","user.user_id","userpositiongroup.user_user_id")
                                      ->where("user_id","=",Auth::user()->user_id)
                                      ->get();
            if($auth[0]->rights_rights_id == 1)
            {
                return redirect("/admin");
            }
            

        }
        return $next($request);
    }
}
