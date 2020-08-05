<?php
/**
 * Created by DreamPHP.
 * User: Leruge
 * Date: 2018/4/5 0005
 * Time: 19:49
 * Email: leruge@163.com
 * Url: http://www.dreamphp.com.cn/
 */

namespace app\common\validate;

use think\Validate;

class Member extends Validate
{
    protected $rule = [
        'username|用户名' => 'require|unique:member',
        'email|邮箱' => 'require|email',
        'password|密码' => 'require',
        'conpass|确认密码' => 'require|confirm:password',
        'status|状态' => 'require',
        'oldpass|原密码' => 'require',
        'newpass|新密码' => 'require',
        'nickname|昵称' => 'require',
        'verify|验证码' => 'require|captcha'
    ];

    public function sceneAdd()
    {
        return $this->only(['username', 'password', 'status']);
    }

    public function sceneEdit()
    {
        return $this->only(['oldpass', 'newpass', 'nickname']);
    }

    public function sceneLogin()
    {
        return $this->only(['username', 'password', 'verify'])
            ->remove('username', 'unique');
    }

    public function sceneRegister()
    {
        return $this->only(['username', 'email', 'password', 'conpass', 'verify']);
    }
}