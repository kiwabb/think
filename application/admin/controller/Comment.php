<?php

namespace app\admin\controller;

use think\Controller;

class Comment extends Controller
{
    public function commentList()
    {
        $comments = model('Comment')->with('article', 'member')->order(['create_time' => 'desc'])->paginate(10);
        $viewData = [
            'comments' => $comments
        ];
        $this->assign($viewData);
        return view('commentlist');
    }

    public function commentRead()
    {
        $commentInfo = model('Comment')->find(input('id'));
        $viewData = [
            'commentInfo' => $commentInfo
        ];
        $this->assign($viewData);
        return view('commentread');
    }

    public function commentDel()
    {
        $commentInfo = model('Comment')->find(input('post.id'));
        $result = $commentInfo->delete();
        if ($result) {
            $this->success('删除成功！', 'admin/comment/commentlist');
        }else {
            $this->error('删除失败！');
        }
    }
}
