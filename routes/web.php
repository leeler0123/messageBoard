<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('no_rank',function(){
    return '无权限';
});// 无权限

Route::group(['middleware'=>['throttle:60,1']],function(){ // 1分钟60次限频
    Route::get('/','Login@show'); //登录注册页面
    Route::get('/login','Login@show'); //登录注册页面
    Route::post('/login','Login@login'); // 登录
    Route::post('/login/register','Login@register'); // 注册
    Route::get('/login/logout','Login@logout'); //注销

    Route::get('/message','MessageController@list'); // 文章列表
    Route::get('/message/detail/{id}','MessageController@detail')->where('id','[0-9]+'); // 文章详情
    Route::get('/message/manage_msg','MessageController@manage_msg'); // 留言管理列表

    // 黑名单用户不可访问
    Route::group(['middleware'=>['blacklist']],function(){
        Route::post('/message/add','MessageController@add')->middleware('checklogin'); // 新增留言
    });

    // 需要管理员权限的
    Route::group(['middleware'=>['super']],function(){
        Route::get('user_manage','UserController@list'); // 用户管理
        Route::get('blacklist','UserController@blacklist'); // 用户管理
        Route::get('set_black/{id}','UserController@set_black')->where('id','[0-9]+');; // 拉黑
        Route::get('del_black/{id}','UserController@del_black')->where('id','[0-9]+');; // 取消拉黑
        Route::get('/message/del/{id}','MessageController@del')->where('id','[0-9]+'); // 删除留言
    });

});

