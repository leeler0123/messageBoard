@extends('layouts.app')

@section('title','黑名单管理')

@section('content')
    <div class="container">
        <ul class="breadcrumb">
{{--            <li><a href="{{url('/user_manage')}}">黑名单管理</a></li>--}}
        </ul>
        <div class="row">
            <div class="col-xs-6 col-md-2"></div>
            <div class="col-xs-6 col-md-8">
                <h3><a href="{{url('/user_manage')}}" >用户列表</a><span style="margin-left: 10px;">黑名单管理</span><span style="margin-left: 10px;"><a href="{{url('/message/manage_msg')}}" >留言管理</a></span></h3>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>#</td>
                        <td>用户名</td>
                        <td>email</td>
                        <td>拉黑日期</td>
                        <td>操作</td>
                    </tr>
                    @foreach($blacklist as $k => $v)
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>{{$v->user->username}}</td>
                            <td>{{$v->user->email}}</td>
                            <td>{{date('Y-m-d H:i',$v->ctime)}}</td>
                            <td>
                                <button class='btn btn-info' onclick='del_black({{$v->id}})' > 取消拉黑 </button></td>
                        </tr>
                    @endforeach

                </table>
                {{ $blacklist->render() }}

            </div>
            <div class="col-xs-6 col-md-2"></div>
        </div>
    </div>
@endsection
<script>
    function del_black(user_id){
        $.ajax({
            type:'GET',
            dataType:'json',
            url:"{{url('/del_black')}}/" + user_id,
            success : function (ret) {
                if(ret.code == 0){
                    alert('操作成功')
                    window.location.reload();
                }else{
                    alert(ret.msg);
                }
            },
            error : function() {
                alert('服务器异常');
            }
        })
    }

</script>
