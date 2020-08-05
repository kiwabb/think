<?php

namespace app\admin\controller;

class Member extends Base
{
    public function memberList()
    {
        $where = [];
        if (input('?status')) {
            $where = [
                'status' => input('status')
            ];
        }
        $members = model('Member')->where($where)->order(['status' => 'desc', 'create_time' => 'desc'])->paginate(10);
        $viewData = [
            'members' => $members
        ];
        $this->assign($viewData);
        return view('memberlist');
    }

    public function memberAdd()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'status' => input('post.status')
            ];
            $result = model('Member')->add($data);
            if ($result == 1) {
                $this->success('添加成功！', 'admin/member/memberlist');
            }else {
                $this->error($result);
            }
        }
        return view('memberadd');
    }

    public function memberStatus()
    {
        $memberInfo = model('Member')->find(input('post.id'));
        $memberInfo->status = input('post.status') ? 0 : 1;
        $result = $memberInfo->save();
        if ($result) {
            $this->success('操作成功！', 'admin/member/memberlist');
        }else {
            $this->error('操作失败！');
        }
    }

    public function memberEdit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'oldpass' => input('post.oldpass'),
                'newpass' => input('post.newpass'),
                'nickname' => input('post.nickname')
            ];
            $result = model('Member')->edit($data);
            if ($result == 1) {
                $this->success('编辑成功！', 'admin/member/memberlist');
            }else {
                $this->error($result);
            }
        }
        $memberInfo = model('Member')->find(input('id'));
        $viewData = [
            'memberInfo' => $memberInfo
        ];
        $this->assign($viewData);
        return view('memberedit');
    }

    public function memberDel()
    {
        $memberInfo = model('Member')->find(input('post.id'));
        $result = $memberInfo->delete();
        if ($result) {
            $this->success('操作成功！', 'admin/member/memberlist');
        }else {
            $this->error('操作失败！');
        }
    }
}
