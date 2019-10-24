{{--<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
    </title>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"
          rel="stylesheet">
</head>--}}

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
            <form action="{{url('login/register')}}" method="POST">
                @method('POST')
                @csrf
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
                    <span class="">验证码<img src="{{captcha_src('mini')}}" style="display: inline" onclick="this.src='{{captcha_src('mini')}}?'+Math.random()"></span>
                    <span><input  name="captcha" /></span>
                </div>
                <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    <span>注册</span>
                </button>


                @if ($errors->any())
                    <div  style="color:red">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </form>
        </div>
        <div class="signin-page">
            <form action="{{url('login')}}" method="POST">
                @method('POST')
                @csrf
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

                {{--<span id="control-group">
                  <label>
                    <input type="checkbox" value="option1">
                    记住我 |
                  </label>
                  <a href="/user/newpasswd">忘记密码</a>
                </span>--}}
                <br>
                <button class="btn btn-lg btn-info btn-block">
                    <span>登陆</span>
                </button>
                @if (!empty($login_error))
                    <div  style="color:red">{{$login_error}}<div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

</html>
<style>
    .navbar-USF{
        left:0;
        top:0;
        position:fixed;
        height:100%;
        width:45px;
        background-color:#3C3C3C;
    }
    .navbar-USF a{
        display:block;
        padding:10px;
        line-height: 25px;
        height:45px;
        font-size:16px;
        text-align: center;
    }
    .navbar-USF a:hover{
        background:#E0E0E0;
    }
    .navbar-USF a span{
        height:25px;
        width: 25px;
    }

    .sign-page{
        margin-top:30px;
        padding:40px;
    }

    .alert{
        position:absolute;
        width:18%;
        left:40%;
        top:5%;
        display:none;
    }


    .alert p{
        text-align:center;
    }
    .signup-page{
        float:left;
        width:49%;
        display:inline-block;
        vertical-align:top;
        border-right: 1px solid #d9d9d9;
    }

    .signin-page{
        float:left;
        width:49%;
        display:inline-block;
        vertical-align:top;
    }

    form{
        width:301px;
        display:block;
        margin:20px;
        margin-left:100px;
    }
    .input-prepend span{
        width:42px;
        height:42px;
    }
    .input-prepend input{
        width:228px;
        height:42px;
        padding:4px 12px;
    }
    span#control-group{
        margin:0 0 100px 0;
    }
</style>
