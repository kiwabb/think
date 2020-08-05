<?php
/**
 * Created by DreamPHP.
 * User: Leruge
 * Date: 2018/4/5 0005
 * Time: 21:38
 * Email: leruge@163.com
 * Url: http://www.dreamphp.com.cn/
 */

namespace app\common\validate;

use think\Validate;

class System extends Validate
{
    protected $rule = [
        'webname|网站名称' => 'require',
        'shortname|副标题' => 'require',
        'copyright|版权信息' => 'require'
    ];
}