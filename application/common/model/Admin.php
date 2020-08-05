<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    use SoftDelete;

    public function login($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        $result = $this->where($data)->find();
        if ($result) {
            if ($result['status'] != 1) {
                return '此账户被禁用！';
            }
            session('admin', ['id' => $result['id'],
                'nickname' => $result['nickname'],
                'super' => $result['super']]);
            return 1;
        }else {
            return '用户名或者密码错误！';
        }
    }

    public function register($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }
        $data['nickname'] = $data['username'];
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '注册失败！';
        }
    }

    public function forget($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('forget')->check($data)) {
            return $validate->getError();
        }
        $result = $this->where($data)->find();
        $subject = '重置密码验证码--梦中程序员';
        $content = '您的验证码是：'. session('code');
        if ($result && email($data['email'], $result['nickname'], $subject, $content)) {
            return 1;
        }else {
            return '没有此注册邮箱！';
        }
    }

    public function add($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '添加失败！';
        }
    }

    public function edit($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }
        $adminInfo = $this->find($data['id']);
        if ($adminInfo['password'] != $data['oldpass']) {
            return '原密码不正确！';
        }
        $adminInfo->password = $data['newpass'];
        $adminInfo->nickname = $data['nickname'];
        $adminInfo->email = $data['email'];
        $adminInfo->super = $data['super'];
        $result = $adminInfo->save();
        if ($result) {
            return 1;
        }else {
            return '修改失败！';
        }
    }
}
