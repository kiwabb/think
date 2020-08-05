<?php

namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;

class Index extends Controller
{
    public function login()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password')
            ];
            $result = model('Admin')->login($data);
            if ($result == 1) {
                $this->success('登录成功！', 'admin/home/index');
            }else {
                $this->error($result);
            }
        }
        if (session('?admin.id')) {
            $this->redirect('admin/home/index');
        }
        return view();
    }

    public function register()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'email' => input('post.email')
            ];
            $result = model('Admin')->register($data);
            if ($result == 1) {
                $this->success('注册成功！', 'admin/index/login');
            }else {
                $this->error($result);
            }
        }
        return view();
    }

    public function forget()
    {
        if (request()->isAjax()) {
            $code = mt_rand(1000, 9999);
            session('code', $code);
            $data = [
                'email' => input('post.email')
            ];
            $result = model('Admin')->forget($data);
            if ($result == 1) {
                $this->success('验证码发送成功！');
            }else {
                $this->error($result);
            }
        }
        return view();
    }

    public function forgetRe()
    {
        $data = [
            'email' => input('post.email'),
            'code' => input('post.code')
        ];
        if (session('code') != $data['code']) {
            $this->error('验证码不正确！');
        }else {
            $newpass = mt_rand(10000,99999);
            $adminInfo = model('Admin')->where('email', $data['email'])->find();
            $adminInfo->password = $newpass;
            $result = $adminInfo->save();
            $content = '您好，' . $adminInfo['nickname'] . '！<br>' . '您的密码已重置成功。<br>' .
                '用户名：' . $adminInfo['username'] . '<br>' . '新密码：' . $newpass;
            if ($result && email($adminInfo['email'], $adminInfo['nickname'], '密码重置成功--梦中程序员', $content)) {
                $this->success('新密码已发往邮箱！', 'admin/index/login');
            }else {
                $this->error('密码重置失败！');
            }
        }
    }

    public function loginout()
    {
        session(null);
        if (session('?admin.id')) {
            $this->error('退出失败！');
        }else {
            $this->success('退出成功！', 'admin/index/login');
        }
    }

    public function miss()
    {
        return view();
    }
}
