<?php


namespace App\Services;


use App\Model\Blacklist;

class BlacklistService
{
    // 黑名单列表
    public function list()
    {
        return Blacklist::select(['id','user_id','set_user_id','ctime'])
            ->with(['user'=>function($query){
                $query->select(['id','username','email']);
            }])
            ->paginate(10);
    }

    /**
     * @describe    验证用户是否在黑名单内
     * @param int $user_id  用户ID
     * @return bool
     */
    public function check_user(int $user_id)
    {
        $flag = Blacklist::where('user_id',$user_id)->first();
        if($flag){
            return true;
        }
        return false;
    }


    /**
     * @describe    拉黑用户
     * @param $user_id  用户ID
     * @return bool
     */
    public function set_black($user_id)
    {
        $flag = Blacklist::where('user_id',$user_id)->first();
        if($flag){
            return true;
        }else{
            $bl = new Blacklist();
            $bl->user_id = $user_id;
            $bl->set_user_id = session('userinfo')['id'];
            $bl->ctime = time();
            return $bl->save();

        }
    }

    /**
     * @describe    删除黑名单
     * @param $user_id  用户ID
     * @return bool
     */
    public function del_black($user_id)
    {
        $ret =  Blacklist::destroy($user_id);
        if($ret){
            return true;
        }
        return false;
    }
}
