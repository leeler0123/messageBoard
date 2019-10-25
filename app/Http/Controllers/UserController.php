<?php

namespace App\Http\Controllers;

use App\Model\Blacklist;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @describe    用户列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        //分页操作
        $users = User::select(['id','username','email','is_super','ctime'])->with(['blacklist'=>function($query){
            $query->select(['user_id']);
        }])->paginate(5);
        return $this->output('user/list',['users'=>$users]);
    }

    /**
     * @describe    黑名单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blacklist()
    {
        //分页操作
        $blacklist = Blacklist::select(['id','user_id','set_user_id','ctime'])
            ->with(['user'=>function($query){
                $query->select(['id','username','email']);
            }])
            ->paginate(10);
        return $this->output('user/blacklist',['blacklist'=>$blacklist]);
    }

    /**
     * @describe    拉黑用户
     * @param $user_id  用户ID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function set_black($user_id)
    {
        $flag = Blacklist::where('user_id',$user_id)->first();
        if($flag){
            return redirect('/user_manage');
        }else{
            $bl = new Blacklist();
            $bl->user_id = $user_id;
            $bl->set_user_id = session('userinfo')['id'];
            $bl->ctime = time();
            $ret = $bl->save();
            return back();
        }
    }

    /**
     * @describe    取消拉黑
     * @param $id   用户ID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function del_black($id)
    {
        $bls = Blacklist::destroy($id);
        return redirect('/blacklist');

    }
}
