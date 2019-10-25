@extends('layouts.app')

@section('title','登录注册')

@section('content')

<div class="container">
    <div class="sign-page">
        <div class="alert alert-info" role="alert">
            <p>
                注册成功，请登陆
            </p>
        </div>
        <div class="signup-page">
            <form  id="form-register">
                <h3>
                    通过邮箱注册
                </h3>
                <p class="slogan">
                    请填写以下信息
                </p>
                <div class="input-prepend">
                    <span class="glyphicon glyphicon-user"></span>
                    <input type="text" name="username" placeholder="用户名" value="{{old('username')}}">
                </div>
                <br>
                <div class="input-prepend">
                    <span class="glyphicon glyphicon-envelope"></span>
                    <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
                </div>
                <br>
                <div class="input-prepend">
                    <span class="glyphicon glyphicon-lock"></span>
                    <input type="password" name="password" placeholder="******" value="{{old('password')}}">
                </div>
                <br>
                <div class="input-prepend">
                    <span class="glyphicon glyphicon-lock"></span>
                    <input type="password" name="password_confirm" placeholder="******" value="{{old('password_confirm')}}">
                </div>
                <br>
                <div class="input-prepend" >
                    <span class="">验证码<img src="{{captcha_src('mini')}}" style="display: inline" id="captcha_img"  onclick="this.src='{{captcha_src('mini')}}?'+Math.random()"></span>
                    <span><input  name="captcha" id="captcha" /></span>
                </div>
                <br>
                <button class="btn btn-lg btn-primary btn-block"  onclick="register()" type="button" >
                    注册
                </button>


               {{-- @if ($errors->any())
                    <div  style="color:red">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif--}}


            </form>
        </div>
        <div class="signin-page">
            <form action=""  id="form-login">
                <h3>
                    登录
                </h3>
                <p class="slogan">
                    请输入账号密码
                </p>
                <div class="input-prepend">
                    <span class="glyphicon glyphicon-user"></span>
                    <input type="text" placeholder="用户名" name="username" value="{{old('username')}}">
                </div>
                <br>
                <div class="input-prepend">
                    <span class="glyphicon glyphicon-lock"></span>
                    <input type="password" placeholder="******" name="password">
                </div>
                <br>
                <button class="btn btn-lg btn-info btn-block" type="button" onclick="login()">登陆</button>
                @if (!empty($login_error))
                    <div  style="color:red">{{$login_error}}<div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script>


    function login() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var username = $("#form-login input[name='username']").val();
        var password = $("#form-login input[name='password']").val();

        $.ajax({
            type: "POST",//方法类型
            dataType: "json",//预期服务器返回的数据类型
            url: "{{url('/login')}}" ,//url
            data: {username:username,password:password},
            success: function (result) {
                if (result.code == 0) {
                    // alert(result.data);
                    window.location.href = '{{url('message')}}';
                }else{
                    alert(result.msg,123);
                }
            },
            error : function() {
                alert("服务器异常！");
            }
        });
    }

    function register(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var username = $("#form-register input[name='username']").val();
        var email = $("#form-register input[name='email']").val();
        var password = $("#form-register input[name='password']").val();
        var password_confirm = $("#form-register input[name='password_confirm']").val();
        var captcha = $("#form-register input[name='captcha']").val();

        $.ajax({
            type: "POST",//方法类型
            dataType: "json",//预期服务器返回的数据类型
            url: "{{url('/login/register')}}" ,//url
            data: {
                username:username,
                password:password,
                email:email,
                password_confirm:password_confirm,
                captcha:captcha,
            },
            success: function (result) {
                console.log(result);
                if (result.code == 0) {
                    window.location.href = '{{url('message')}}';
                }else{
                    $('#captcha_img').click();
                    alert(result.msg);
                }
            },
            error : function() {
                alert("服务器异常！");
            }
        });
    }
</script>
