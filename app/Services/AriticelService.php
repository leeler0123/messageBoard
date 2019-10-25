<?php


namespace App\Services;


use App\Model\Articel;

class AriticelService
{
    //获取文章列表
    public function list()
    {
        return Articel::select(['id','user_id','title','content','ctime'])
            ->with(['user'=>function($query){
                $query->select(['id','username']);
            }])->limit(50)->get();
    }

    /**
     * @describe 获取文章详情
     * @param int $articel_id
     */
    public function detail(int $articel_id)
    {
        return Articel::select(['id','user_id','title','content','ctime'])->where('id',$articel_id)
            ->with(['user'=>function($query){
                $query->select(['id','username']);
            }])->first();
    }
}
