<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @describe  响应输出,兼容web和api
     * @param string $route|$msg 路由|msg
     * @param array $data
     * @param int $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    function output($route = '',$data = [],$code = 0){
        if($this->request->ajax()){
            if(empty($code)) $code = RETURN_SUS_CODE;
            if(empty($msg)) $msg = RETURN_SUS_MSG;
            return responseJson($code , $msg , $data);
        }else{
            return view($route,$data);
        }
    }
}
