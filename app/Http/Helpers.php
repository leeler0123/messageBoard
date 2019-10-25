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


if(!function_exists('responseSuc')) {
    /**
     * @describe 成功返回
     * @param array $data
     * @param int $status
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
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

if(!function_exists('formatCtime')) {
    /**
     * @describe 格式化日期
     * @param int $ctime  时间戳
     * @return string 例：如1小时前
     */
    function formatCtime($ctime){
        $second = time() - $ctime;
        switch ($second){
            case $second < 3600 :
                return floor($second/60) .'分钟前';
            case $second < 86400 :
                return floor($second/3600) .'小时前';
            case $second < 2592000 :
                return floor($second/86400) .'天前';
            default :
                return date('Y-m-d H:i:s',$ctime);
        }
    }
}


