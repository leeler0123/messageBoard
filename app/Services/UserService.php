<?php


namespace App\Services;


use App\Model\Comment;
use App\Model\User;

class UserService
{
    public function list()
    {
        return User::select(['id','username','email','is_super','ctime'])->with(['blacklist'=>function($query){
                    $query->select(['user_id']);
                }])->paginate(5);
    }


}
