<?php

namespace app\admin\controller;

class Article extends Base
{
    public function articleList()
    {
        $where = [];
        $catename = null;
        if (input('?cateid')) {
            $where = [
                'cateid' => input('cateid')
            ];
            $catename = model('Cate')->where('id', input('cateid'))->value('catename');
        }
        $articles = model('Article')->where($where)->with('cate')->order(['atop' => 'asc', 'create_time' => 'desc'])->paginate(10, false, ['query' => $where]);
        $viewData = [
            'articles' => $articles,
            'catename' => $catename
        ];
        $this->assign($viewData);
        return view('articlelist');
    }

    public function articleAdd()
    {
        if (request()->isAjax()) {
            $data = [
                'title' => input('post.title'),
                'atop' => input('post.atop') ?? 0,
                'cateid' => input('post.cateid'),
                'author' => input('post.author'),
                'tags' => input('post.tags'),
                'desc' => input('post.desc'),
                'content' => input('post.content')
            ];
            $result = model('Article')->add($data);
            if ($result == 1) {
                $this->success('文章添加成功！', 'admin/article/articlelist');
            }else {
                $this->error($result);
            }
        }
        $cates = model('Cate')->select();
        $viewData = [
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view('articleadd');
    }

    public function articleTop()
    {
        $articleInfo = model('Article')->find(input('id'));
        $articleInfo->atop = input('post.atop') ? 0 : 1;
        $result = $articleInfo->save();
        if ($result) {
            $this->success('操作成功！', 'admin/article/articlelist');
        }else {
            $this->error('操作失败！');
        }
    }

    public function articleEdit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'title' => input('post.title'),
                'cateid' => input('cateid'),
                'tags' => input('post.tags'),
                'desc' => input('post.desc'),
                'content' => input('post.content')
            ];
            $result = model('Article')->edit($data);
            if ($result == 1) {
                $this->success('文章编辑成功！', 'admin/article/articlelist');
            }else {
                $this->error($result);
            }
        }
        $cates = model('Cate')->select();
        $articleInfo = model('Article')->with('cate')->find(input('id'));
        $str = implode('|',$articleInfo['tags']);
        $viewData = [
            'tags' => $str,
            'articleInfo' => $articleInfo,
            'cates' => $cates
        ];;
        $this->assign($viewData);
        return view('articleedit');
    }

    public function articleDel()
    {
        $articleInfo = model('Article')->with('comments')->find(input('post.id'));
        $result = $articleInfo->together('comments')->delete();
        if ($result) {
            $this->success('文章删除成功！', 'admin/article/articlelist');
        }else {
            $this->error('文章删除失败！');
        }
    }
}
