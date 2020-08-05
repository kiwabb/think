<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Article extends Model
{
    use SoftDelete;

    public function getTagsAttr($value)
    {
        return explode('|', $value);
    }

    public function cate()
    {
        return $this->belongsTo('Cate', 'cateid', 'id');
    }

    public function comments()
    {
        return $this->hasMany('Comment', 'articleid', 'id');
    }

    public function add($data)
    {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('add')->check($data))
        {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '文章添加失败！';
        }
    }

    public function edit($data)
    {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }
        $articleInfo = $this->find($data['id']);
        $articleInfo->title = $data['title'];
        $articleInfo->cateid = $data['cateid'];
        $articleInfo->tags = $data['tags'];
        $articleInfo->desc = $data['desc'];
        $articleInfo->content = $data['content'];
        $result = $articleInfo->save();
        if ($result) {
            return 1;
        }else {
            return '文章编辑失败！';
        }
    }
}
