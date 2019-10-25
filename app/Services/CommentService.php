<?php


namespace App\Services;


use App\Model\Comment;

class CommentService
{
    /**
     * @describe 获取文章留言
     * @param int $articel_id
     * @return mixed
     */
    public function get_by_articel_id(int $articel_id)
    {
        return Comment::select(['id','user_id','articel_id','content','ctime'])
            ->where(['articel_id'=>intval($articel_id),'is_del'=>0])->orderBy('id','DESC')
            ->with(['user'=>function($query){
                $query->select(['id','username']);
            }])->paginate(10);
    }

    /**
     * @describe  留言管理列表
     * @return mixed
     */
    public function manage_list()
    {
        return Comment::select(['content','id','user_id','articel_id','ctime','is_del'])->with([
            'articel'=>function($query){
                $query->select(['id','title']);
            },
            'user'=>function($query){
                $query->select(['id','username']);
            },
            'blacklist'=>function($query){
                $query->select(['user_id']);
            }])->orderBy('id','desc')->paginate(10);
    }

    /**
     * @describe    删除留言
     * @param int $id  留言ID
     * @return mixed
     */
    public function del_comment(int $id)
    {
        return Comment::where('id',$id)->update(['is_del'=>1]);
    }

    /**
     * @describe 新增留言
     * @param $params
     */
    public function add($params)
    {
        $comment = new Comment;
        $comment->user_id = session('userinfo')['id'];
        $comment->articel_id = $params['articel_id'];
        $comment->content = $params['content'];
        $comment->ctime = time();
        return $comment-> save();
    }
}
