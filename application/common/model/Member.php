<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Member extends Model
{
    use SoftDelete;

    protected $readonly = [
        'username',
        'email'
    ];

    public function article()
    {
        return $this->hasMany('Article', 'articleid', 'id');
    }

    public function add($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        $data['nickname'] = $data['username'];
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '添加失败！';
        }
    }

    public function edit($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }
        $memberInfo = $this->find($data['id']);
        if ($memberInfo['password'] != $data['oldpass']) {
            return '原密码不正确！';
        }
        $memberInfo->password = $data['newpass'];
        $memberInfo->nickname = $data['nickname'];
        $result = $memberInfo->save();
        if ($result) {
            return 1;
        }else {
            return '操作失败！';
        }
    }

    public function login($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        unset($data['verify']);
        $result = $this->where($data)->find();
        if ($result) {
            if ($result['status'] != 1) {
                return '账号被禁用，无法登录！';
            }else {
                session('index', ['id' => $result['id'], 'nickname' => $result['nickname']]);
                return 1;
            }
        }else {
            return '用户名或者密码错误！';
        }
    }

    public function register($data)
    {
        $validate = new \app\common\validate\Member();
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
}
