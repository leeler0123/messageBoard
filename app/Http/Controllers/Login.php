<?php


namespace App\Http\Controllers;


use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Login extends Controller
{
    // 登录页
    public function show(){
        return view('login/show');
    }

    // 登录
    public function login(Request $request ){

        $params = $request->only(['username','password']);

        if (empty($params['username']) OR empty($params['password'])) {
            return view('login/show',['login_error'=>'用户或密码不能为空']);
        }
        $params['password'] = sha1(md5($params['password']));
        $user = User::where($params)->select(['id','username','email','is_super'])->first();
        // 写session
        if($user){
            session(['userinfo'=>$user->toArray()]);
            return redirect('/message');
        }else{
            return view('login/show',['login_error'=>'用户或密码错误，请检查！']);
        }
    }
    // 注册
    public function register(Request $request){

        $validateData = $request->validate([
            'username' => 'required|max:30|min:6|unique:user',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:6|max:16',
            'password_confirm' => 'required|same:password',
            'captcha' => 'required|captcha'
        ]);

        $data = [
            'username'=> $validateData['username'],
            'email' => $validateData['email'],
            'password' => sha1(md5($validateData['password'])),
            'ctime' => time(),
        ];

        $user = new User($data);
        $ret = $user->save();

        return redirect('/login');

    }
    // 注销
    public function logout(Request $request){
            $request->session()->flush();
            return redirect('message');
    }
}
