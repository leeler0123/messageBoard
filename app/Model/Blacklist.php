<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'blacklist';
    public $timestamps = false;
    // 关联用户
    public function user(){
        return $this->hasOne('App\Model\User','id','user_id');
    }

}
