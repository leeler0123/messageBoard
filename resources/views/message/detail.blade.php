@extends('layouts.app')

@section('title','文章详情')

@section('content')
<div class="container">
    <ul class="breadcrumb">
        <li><a href="{{url('/message')}}">文章列表</a></li>
        <li class="active">{{$articel->title}}</li>
    </ul>
    <div class="row">
        <div class="col-xs-6 col-md-2"></div>
        <div class="col-xs-6 col-md-8">
            <div>
                <h3>{{$articel->title}}</h3>
                <div>{{$articel->user->username}} &nbsp;&nbsp;{{$articel->ctime}}</div>
                <p>{{$articel->content}}</p>
            </div>
            <hr>
            留言板
            <table class="table table-hover table-striped">
                <tr>
                    <td>#</td>
                    <td>内容</td>
                    <td>用户</td>
                    <td>时间</td></tr>
                @foreach($comments as $k => $v)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{htmlspecialchars ($v->content)}}</td>
                        <td>{{$v->user->username}}</td>
                        <td>{{$v->ctime}}</td>
                    </tr>
                @endforeach

            </table>
            {{ $comments->render() }}


            <hr>
            <div>
                <form action="{{url('/message/add')}}" method="POST">
                    @method("POST")
                    @csrf

                    <h4>留言</h4>
                    <input type="hidden" value="{{$articel->id}}" name="articel_id">
                    <textarea rows="6" cols="80" name="content">

                    </textarea>
                    <button type="submit" class="btn btn-info">提交</button>
                </form>

            </div>

        </div>
        <div class="col-xs-6 col-md-2"></div>
    </div>
</div>
@endsection

