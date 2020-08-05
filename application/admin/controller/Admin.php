<?php

namespace app\admin\controller;

class Admin extends Base
{
    public function adminList()
    {
        $where = [];
        if (input('?status')) {
            $where = [
                'status' => input('status')
            ];
        }
        $admins = model('Admin')->where($where)->order('super', 'desc')->paginate(10, false, ['query' => $where]);
        $viewData = [
            'admins' => $admins
        ];
        $this->assign($viewData);
        return view('adminlist');
    }

    public function adminStatus()
    {
        $data = [
            'id' => input('post.id'),
            'status' => input('post.status') ? 0 : 1
        ];
        $result = model('Admin')->isUpdate(true)->save($data);
        if ($result) {
            $this->success('操作成功！', 'admin/admin/adminlist');
        }else {
            $this->error('操作失败！');
        }
    }

    public function adminAdd()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'nickname' => input('post.username'),
                'status' => input('post.status'),
                'super' => input('post.super')
            ];
            $result = model('Admin')->add($data);
            if ($result == 1) {
                $this->success('添加成功！', 'admin/admin/adminlist');
            }else {
                $this->error($result);
            }
        }
        return view('adminadd');
    }

    public function adminEdit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'oldpass' => input('post.oldpass'),
                'newpass' => input('post.newpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email'),
                'super' => input('post.super') ?? 0
            ];
            $result = model('Admin')->edit($data);
            if ($result == 1) {
                $this->success('修改成功！', 'admin/admin/adminlist');
            }else {
                $this->error($result);
            }
        }
        $adminInfo = model('Admin')->find(input('id'));
        $viewData = [
            'adminInfo' => $adminInfo
        ];
        $this->assign($viewData);
        return view('adminedit');
    }

    public function adminDel()
    {
        $adminInfo = model('Admin')->find(input('post.id'));
        $result = $adminInfo->delete();
        if ($result) {
            $this->success('删除成功！', 'admin/admin/adminlist');
        }else {
            $this->error('删除失败！');
        }
    }
}
