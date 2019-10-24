
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
                <form action="" id="form1">
                    <h4>留言</h4>
                    <input type="hidden" value="{{$articel->id}}" name="articel_id" id="articel_id">
                    <textarea rows="6" cols="80" name="content" id="content">

                    </textarea>
                    <button type="button" class="btn btn-info" onclick="commit()">提交</button>
                </form>

            </div>

        </div>
        <div class="col-xs-6 col-md-2"></div>
    </div>
</div>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script>


    function commit() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var articel = $("#articel_id").val();
        var content = $("#content").val();

        $.ajax({
            type: "POST",//方法类型
            dataType: "json",//预期服务器返回的数据类型
            url: "{{url('/message/add')}}" ,//url
            data: {articel_id:articel,content:content},
            success: function (result) {
                if (result.code == 0) {
                    alert(result.msg);
                    window.location.reload();
                }else{
                    alert(result.msg);
                }
            },
            error : function(data) {
                alert("服务器异常！",data);
            }
        });
    }
</script>


