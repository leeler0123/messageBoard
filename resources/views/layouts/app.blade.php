<html>
<head>
    <title> @yield('title')</title>
</head>
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<link href="{{URL::asset('css/navbar.css')}}" rel="stylesheet" type="text/css">
<body>
@section('navbar')
    <div class="navbar-USF">
        <div class="dropdown">
            <a href="{{url('message')}}" >
                <span class="glyphicon glyphicon-list-alt"></span>
            </a>
            @if (session('userinfo')['is_super'] == 1)
                <a href="{{url('user_manage')}}" >
                    <span class="glyphicon glyphicon-user"></span>
                </a>
            @endif
        </div>
    </div>
@show

<div class="container">
        @if (session('userinfo')['is_super'] == 1)
            管理员
        @endif
        @if (empty(session('userinfo')['username']) )
           <a href="{{url('login')}}" >请登录</a>
         @else
            {{session('userinfo')['username']}} ，你好 <a href="{{url('login/logout')}}" > 注销</a>
         @endif
    @yield('content')
</div>
</body>
</html>
