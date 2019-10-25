<?php

namespace App\Http\Controllers;

use App\Model\Blacklist;
use App\Model\User;
use App\Services\BlacklistService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @describe 用户列表
     * @param UserService $userService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function list(UserService $userService)
    {
        $users = $userService->list();
        return $this->output('user/list',['users'=>$users]);
    }

    /**
     * @describe    黑名单列表
     * @param BlacklistService $blacklistService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function blacklist(BlacklistService $blacklistService)
    {
        //分页操作
        $blacklist = $blacklistService->list();
        return $this->output('user/blacklist',['blacklist'=>$blacklist]);
    }

    /**
     * @describe    拉黑用户
     * @param BlacklistService $blacklistService
     * @param $user_id  用户ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function set_black(BlacklistService $blacklistService , $user_id)
    {
        $ret = $blacklistService->set_black($user_id);
        if($ret){
            return responseSuc(['ret'=>$ret]);
        }else{
            return responseErr('操作失败');
        }
    }

    /**
     * @describe 取消拉黑
     * @param BlacklistService $blacklistService
     * @param $user_id  用户id
     * @return \Illuminate\Http\JsonResponse
     */
    public function del_black(BlacklistService $blacklistService , $user_id)
    {
        $ret = $blacklistService->del_black($user_id);
        return responseSuc(['ret'=>$ret]);
    }
}
