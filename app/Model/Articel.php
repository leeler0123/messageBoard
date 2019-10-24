<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Articel extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'articel';
    public $timestamps = false;

    //关联评论表
    public function comments()
    {
        return $this->hasMany('App\Model\Comment','articel_id','id');
    }

    //关联用户表
    public function user()
    {
        return $this->hasOne('App\Model\User','id','user_id');
    }


    // 格式化日期
    public function getCtimeAttribute($ctime)
    {
        $second = time() - $ctime;
        switch ($second){
            case $second < 3600 :
                return floor($second/60) .'分钟前';
            case $second < 86400 :
                return floor($second/3600) .'小时前';
            case $second < 2592000 :
                return floor($second/86400) .'天前';
            default :
                return date('Y-m-d H:i:s',$ctime);
        }
        return date('Y-m-d',$ctime);
    }
}
