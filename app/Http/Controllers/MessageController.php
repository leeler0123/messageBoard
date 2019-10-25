<?php


namespace App\Http\Controllers;

use App\Model\Articel;
use App\Model\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * @describe   文章列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
        public function list(Request $request)
        {
            //echo session()->getId();die;
            $art = Articel::select(['id','user_id','title','content','ctime'])
                ->with(['user'=>function($query){
                    $query->select(['id','username']);
                }])
                ->limit(50)->get();
            return $this->output('/message/list',['art'=>$art]);
        }

    /**
     * @describe 文章详情
     * @param $id 文章ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
        public function detail($id)
        {
            $articel = Articel::select(['id','user_id','title','content','ctime'])->where('id',intval($id))
                ->with(['user'=>function($query){
                   $query->select(['id','username']);
                }])->first();

            $comments = Comment::select(['id','user_id','articel_id','content','ctime'])
                ->where(['articel_id'=>intval($id),'is_del'=>0])->orderBy('id','DESC')
                ->with(['user'=>function($query){
                    $query->select(['id','username']);
                }])
                ->paginate(10);

            return $this->output('/message/detail',['articel'=>$articel,'comments'=>$comments]);
        }

    /**
     * @describe 新增留言
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
        public function add(Request $request)
        {
            $params = $request->only(['articel_id','content']);
            $validator = Validator::make($request->all(), [
                'content' => 'required|min:5|max:255',
                'articel_id' => 'required|Integer',
            ]);

            if ($validator->fails()) {
                return responseErr('留言长度必须要5-255字符之间');
            }
            $comment = new Comment;
            $comment->user_id = session('userinfo')['id'];
            $comment->articel_id = $params['articel_id'];
            $comment->content = $params['content'];
            $comment->ctime = time();
            $insert_id = $comment-> save();
            if($insert_id){
                return responseSuc(['id'=>$insert_id],0,'留言成功');
            }else{
                return responseErr(['留言失败']);
            }
        }

    /**
     * @describe 留言管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
        public function manage_msg()
        {
                $list = Comment::select(['content','id','user_id','articel_id','ctime','is_del'])->with([
                    'articel'=>function($query){
                        $query->select(['id','title']);
                    },
                    'user'=>function($query){
                        $query->select(['id','username']);
                    },
                    'blacklist'=>function($query){
                        $query->select(['user_id']);
                }])->orderBy('id','desc')->paginate(10);
                return $this->output('/message/manage_msg',['list'=>$list]);
        }

    /**
     * @describe  删除留言
     * @param $id  留言ID
     * @return \Illuminate\Http\RedirectResponse
     */
        public function del($id)
        {
            $ret = Comment::where('id',intval($id))->update(['is_del'=>1]);
            return back();
        }


}
