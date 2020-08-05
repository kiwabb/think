<?php
/**
 * Created by DreamPHP.
 * User: Leruge
 * Date: 2018/4/6 0006
 * Time: 01:39
 * Email: leruge@163.com
 * Url: http://www.dreamphp.com.cn/
 */

namespace app\common\validate;

use think\Validate;

class Comment extends Validate
{
    protected $rule = [
        'content|评论内容' => 'require'
    ];
}