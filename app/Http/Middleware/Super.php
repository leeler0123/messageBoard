<?php

namespace App\Http\Middleware;

use Closure;

class Super
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
        $userinfo = session('userinfo');
        if($userinfo['is_super'] == 1){
            return $next($request);
        }else{
            return redirect('no_rank');
        }

    }
}
