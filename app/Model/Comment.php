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


    /**
     * @describe    格式化日期
     * @param $ctime  时间戳
     * @return string   格式化后字符串 ，如一小时后
     */
    public function getCtimeAttribute($ctime)
    {
        return formatCtime($ctime);
    }

    /**
     * @describe    过滤字段 防止xss 攻击
     * @param $value
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = clean($value);
    }

    //获取留言内容
    public function getContentAttribute($v){
        return clean($v);
    }

}
