<?php

namespace App\Http\Controllers;

use App\Model\Blacklist;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 用户列表
    public function list()
    {
        //分页操作
        $users = User::select(['id','username','email','is_super','ctime'])->with(['blacklist'=>function($query){
            $query->select(['user_id']);
        }])->paginate(5);
        return view('user/list',['users'=>$users]);
    }

    // 黑名单列表
    public function blacklist()
    {
        //分页操作
        $blacklist = Blacklist::select(['id','user_id','set_user_id','ctime'])
            ->with(['user'=>function($query){
                $query->select(['id','username','email']);
            }])
            ->paginate(10);
        return view('user/blacklist',['blacklist'=>$blacklist]);
    }

    // 拉黑
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

    // 取消拉黑
    public function del_black($id)
    {
        $bls = Blacklist::destroy($id);
        return redirect('/blacklist');

    }
}
