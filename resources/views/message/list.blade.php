@extends('layouts.app')

@section('title','文章列表')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-xs-6 col-md-3"></div>
        <div class="col-xs-6 col-md-6">
            <table class="table table-hover table-striped">
                <a href="www.baidu.com">
                    <tr>
                        <td>#</td>
                        <td>标题</td>
                        <td>作者</td>
                        <td>时间</td>
                    </tr>
                </a>

                @foreach($art as $k => $v)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td><a href="{{url('/message/detail',['id'=>$v->id])}}">{{$v->title}}</a></td>
                        <td>{{$v->user->username}}</td>
                        <td>{{$v->ctime}}</td>
                    </tr>
                @endforeach


            </table>
        </div>
        <div class="col-xs-6 col-md-3"></div>
    </div>
</div>
@endsection




