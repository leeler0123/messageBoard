<?php


namespace App\Http\Controllers;

use App\Model\Comment;
use App\Services\AriticelService;
use App\Services\CommentService;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * @describe   文章列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(AriticelService $ariticelService)
    {
        $data = $ariticelService->list();
        return $this->output('/message/list',['art'=>$data]);
    }

    /**
     * @describe    文章详情
     * @param AriticelService $ariticelService
     * @param CommentService $commentService
     * @param $id   文章ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function detail(AriticelService $ariticelService,CommentService $commentService,$id)
    {
        $articel = $ariticelService->detail($id);
        $comments = $commentService->get_by_articel_id($id);
        return $this->output('/message/detail',['articel'=>$articel,'comments'=>$comments]);
    }

    /**
     * @describe 新增留言
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request,CommentService $commentService)
    {
        $params = $request->only(['articel_id','content']);
        $validator = Validator::make($request->all(), [
            'content' => 'required|min:5|max:255',
            'articel_id' => 'required|Integer',
        ]);

        if ($validator->fails()) {
            return responseErr('留言长度必须要5-255字符之间');
        }
        $ret = $commentService->add($params);
        if($ret){
            return responseSuc([],0,'留言成功');
        }else{
            return responseErr(['留言失败']);
        }
    }

    /**
     * @describe 留言管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage_msg(CommentService $commentService)
    {
        $list = $commentService->manage_list();
        return $this->output('/message/manage_msg',['list'=>$list]);
    }

    /**
     * @describe  删除留言
     * @param $id  留言ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function del(CommentService $commentService,$id)
    {
        $ret = $commentService->del_comment($id);
        if($ret){
            return responseSuc(['ret'=>$ret]);
        }else{
            return responseErr('操作失败');
        }
    }


}
