<?php

namespace App\Http\Middleware;

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
        $flag = \App\Model\Blacklist::where('user_id',$user_id)->first();
        if($flag){
            if(request()->ajax()){
                return responseErr('您已被拉黑');die;
            }
            return redirect('no_rank');
        }
        return $next($request);
    }
}
