<?php
/**
 * Created by DreamPHP.
 * User: Leruge
 * Date: 2018/4/5 0005
 * Time: 17:12
 * Email: leruge@163.com
 * Url: http://www.dreamphp.com.cn/
 */

namespace app\common\validate;

use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title|文章标题' => 'require|unique:article',
        'cateid|所属栏目' => 'require',
        'tags|标签' => 'require',
        'desc|文章概要' => 'require',
        'content|文章内容' => 'require'
    ];

    public function sceneAdd()
    {
        return $this->only(['title', 'cateid', 'tags', 'desc', 'content']);
    }

    public function sceneEdit()
    {
        return $this->only(['title', 'cateid', 'tags', 'desc', 'content']);
    }
}