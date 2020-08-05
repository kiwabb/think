<?php

namespace app\index\controller;

class Article extends Base
{
    public function article()
    {
        $articleInfo = model('Article')->find(input('id'));
        $articleInfo->setInc('click');
        $viewData = [
            'articleInfo' => $articleInfo
        ];
        $this->assign($viewData);
        return view();
    }

    public function articleSearch()
    {
        $keyword = '%' . input('keyword') . '%';
        $where[] = ['title', 'like', $keyword];
        $articles = model('Article')->where($where)->paginate(10, false, $where);
        $viewData = [
            'articles' => $articles,
            'catename' => '"' . input('keyword') . '"' . '搜索结果'
        ];
        $this->assign($viewData);
        return view('index/index');
    }

    public function articleMember()
    {
        $memberArticles = model('Article')->where('author', session('index.nickname'))->order('create_time', 'desc')->paginate(5);
        $viewData = [
            'articles' => $memberArticles,
            'catename' => '我的文章'
        ];
        $this->assign($viewData);
        return view('index/index');
    }

    public function articleComment()
    {
        $data = [
            'content' => input('post.comment'),
            'articleid' => input('post.articleid'),
            'memberid' => session('index.id')
        ];
        $result = model('Comment')->add($data);
        if ($result == 1) {
            $this->success('评论成功！');
        }else {
            $this->error($result);
        }
    }
}
