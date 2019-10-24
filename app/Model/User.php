<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table = 'user';
    public $timestamps = false;
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['username','email','password','ctime'];

    // 关联黑名单
    public function blacklist(){
        return $this->hasOne('App\Model\Blacklist','user_id','id');
    }

}
