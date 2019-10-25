<?php

namespace App\Http\Middleware;

use App\Services\BlacklistService;
use Closure;

class BlackList
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
        $user_id = session('userinfo')['id'];
        $flag = (new BlacklistService())->check_user($user_id);
        if($flag){
            if(request()->ajax()){
                return responseErr('您已被拉黑');
            }
            return redirect('no_rank');
        }
        return $next($request);
    }
}
