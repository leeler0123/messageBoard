<?php


namespace App\Http\Controllers;


use App\Http\Requests\RegisterRequest;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Login extends Controller
{
    /**
     * @describe 登录页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(){
        return view('login/show');
    }

    /**
     * @describe  用户登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request ){

        $params = $request->only(['username','password']);
        if (empty($params['username']) OR empty($params['password'])) {
            return responseErr('用户或密码不能为空');
        }
        $params['password'] = sha1(md5($params['password']));
        $user = User::where($params)->select(['id','username','email','is_super'])->first();
        // 写session
        if($user){
            session(['userinfo'=>$user->toArray()]);
            return responseSuc([],0,'登录成功');
        }else{
            return responseErr('用户或密码错误');
        }
    }

    /**
     * @describe  用户注册
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|max:30|min:6|unique:user',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:6|max:16',
            'password_confirm' => 'required|same:password',
            'captcha' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return responseErr($validator->errors()->first());
        }

        $params = $request->only(['username','email','password']);

        $data = [
            'username'=> $params['username'],
            'email' => $params['email'],
            'password' => sha1(md5($params['password'])),
            'ctime' => time(),
        ];

        $insert_id = DB::table('user')->insertGetId($data);
        if($insert_id){
            // 写入session
            $user = User::where(['id'=>$insert_id])->select(['id','username','email','is_super'])->first();
            session(['userinfo'=>$user->toArray()]);
            return responseSuc([]);
        }else{
            return responseErr('注册用户失败');
        }
    }

    /**
     * @describe  用户注销
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request){
        $request->session()->flush();
        return redirect('message');
    }
}
