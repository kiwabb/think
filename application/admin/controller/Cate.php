<?php

namespace app\admin\controller;

class Cate extends Base
{
    public function cateList()
    {
        $cates = model('Cate')->order('sort', 'asc')->paginate(10);
        $viewData = [
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view('catelist');
    }

    public function cateAdd()
    {
        if (request()->isAjax()) {
            $data = [
                'catename' => input('post.catename')
            ];
            $result = model('Cate')->add($data);
            if ($result == 1) {
                $this->success('栏目添加成功！', 'admin/cate/catelist');
            }else {
                $this->error($result);
            }
        }
        return view('cateadd');
    }

    public function cateSort()
    {
        $data = [
            'id' => input('post.id'),
            'sort' => input('post.sort')
        ];
        $result = model('Cate')->sort($data);
        if ($result == 1) {
            $this->success('排序成功！');
        }else {
            $this->error($result);
        }
    }

    public function cateEdit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'catename' => input('post.catename')
            ];
            $result = model('Cate')->edit($data);
            if ($result == 1) {
                $this->success('栏目修改成功！', 'admin/cate/catelist');
            }else {
                $this->error($result);
            }
        }
        $cateInfo = model('Cate')->find(input('id'));
        $viewData = [
            'cateInfo' => $cateInfo
        ];
        $this->assign($viewData);
        return view('cateedit');
    }

    public function cateDel()
    {
        $cateInfo = model('Cate')->with('article,article.comments')->find(input('post.id'));
        foreach ($cateInfo['article'] as $k => $v) {
            $v->together('comments')->delete();
        }
        $result = $cateInfo->together('article')->delete();
        if ($result) {
            $this->success('栏目删除成功！', 'admin/cate/catecatelist');
        }else {
            $this->error('栏目删除失败！');
        }
    }
}
