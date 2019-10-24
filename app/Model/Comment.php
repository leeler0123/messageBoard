<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'Comment';
    public $timestamps = false;

    // 关联用户
    public function user(){
        return $this->hasOne('App\Model\User','id','user_id');
    }

    // 关联文章
    public function articel(){
        return $this->hasOne('App\Model\Articel','id','articel_id');
    }

    // 关联黑名单
    public function blacklist(){
        return $this->hasOne('App\Model\Blacklist','user_id','user_id');
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

    // 防止xss 攻击
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = clean($value);
    }

    public function getContentAttribute($v){
        return clean($v);
    }

}
