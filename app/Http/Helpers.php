<?php



if(!function_exists('responseJson')) {
    function responseJson($status = 0, $msg = 'success', $data = []){
        return response()->json(array(
            'code' => $status,
            'msg' => $msg,
            'data' => $data
        ));
    }
}

// 成功返回
if(!function_exists('responseSuc')) {
    function responseSuc($data = [],$status = 0, $msg = 'success'){
        return responseJson($status,$msg,$data);
    }
}
// 异常返回
if(!function_exists('responseErr')) {
    function responseErr($msg = 'failed',$status = 1, $data = []){
        return responseJson($status,$msg,$data);
    }
}
