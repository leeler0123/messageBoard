@extends('layouts.app')

@section('title','用户列表')

@section('content')
    <div class="container">
        <ul class="breadcrumb">
{{--            <li><a href="{{url('/blacklist')}}">用户管理</a></li>--}}
        </ul>
        <div class="row">
            <div class="col-xs-6 col-md-2"></div>
            <div class="col-xs-6 col-md-8">
                <h3><span>用户列表</span><span style="margin-left: 10px;"><a href="{{url('/blacklist')}}" >黑名单管理</a></span><span style="margin-left: 10px;"><a href="{{url('/message/manage_msg')}}" >留言管理</a></span></h3>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>#</td>
                        <td>用户名</td>
                        <td>邮箱</td>
                        <td>超级管理员</td>
                        <td>是否拉黑</td>
                        <td>注册日期</td>
                        <td>操作</td>
                    </tr>
                    @foreach($users as $k => $v)
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>{{$v->username}}</td>
                            <td>{{$v->email}}</td>
                            <td>{{($v->is_super == 1) ? '是':'否'}}</td>
                            <td></td>
                            <td>{{date('Y-m-d H:i:s',$v->ctime)}}</td>
                            <td>
                                @if( empty($v->blacklist))
                                    <a class="btn btn-danger" href='{{url("set_black/{$v->id}")}}' > 拉黑 </a>
                                @else
                                     <span>已拉黑</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $users->render() }}

            </div>
            <div class="col-xs-6 col-md-2"></div>
        </div>
    </div>
@endsection
