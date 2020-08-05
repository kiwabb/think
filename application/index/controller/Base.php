<?php

namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
    public function initialize()
    {
        $webInfo = model('System')->find();
        $cates = model('Cate')->order(['sort' => 'asc'])->select();
        $topArticles = model('Article')->where('atop', 1)->limit(10)->select();
        $shareData = [
            'webInfo' => $webInfo,
            'cates' => $cates,
            'topArticles' => $topArticles
        ];
        $this->view->share($shareData);
    }
}
