<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
Route::rule('/', 'index/index/main');


Route::group('index', function () {
    Route::rule('index/[:id]', 'index/index/index', 'get');
    Route::rule('/', 'index/index/index');
    Route::rule('article/[:id]', 'index/article/article', 'get');
    Route::rule('search', 'index/article/articlesearch', 'post');
    Route::rule('login', 'index/index/login', 'get|post');
    Route::rule('loginout', 'index/index/loginout', 'post');
    Route::rule('register', 'index/index/register', 'get|post');
    Route::rule('my', 'index/article/articlemember', 'get');
    Route::rule('comment', 'index/article/articlecomment', 'post');
    Route::miss('index/index/miss');
});


Route::group('admin', function () {
    Route::rule('/', 'admin/index/login', 'get|post');
    Route::rule('register', 'admin/index/register', 'get|post');
    Route::rule('forget', 'admin/index/forget', 'get|post');
    Route::rule('loginout', 'admin/index/loginout', 'post');
    Route::rule('forgetre', 'admin/index/forgetre', 'post');
    Route::rule('index', 'admin/home/index', 'get');
    Route::rule('catelist', 'admin/cate/catelist', 'get');
    Route::rule('catedd', 'admin/cate/cateadd', 'get|post');
    Route::rule('catesrot', 'admin/cate/catesort', 'post');
    Route::rule('cateedit/[:id]', 'admin/cate/cateedit', 'get|post');
    Route::rule('catedel', 'admin/cate/catedel', 'post');
    Route::rule('adminlist/[:status]', 'admin/admin/adminlist', 'get');
    Route::rule('adminstatus', 'admin/admin/adminstatus', 'post');
    Route::rule('adminadd', 'admin/admin/adminadd', 'get|post');
    Route::rule('adminedit/[:id]', 'admin/admin/adminedit', 'get|post');
    Route::rule('admindel', 'admin/admin/admindel', 'post');
    Route::rule('articlelist/[:cateid]', 'admin/article/articlelist', 'get');
    Route::rule('articleadd', 'admin/article/articleadd', 'get|post');
    Route::rule('articletop', 'admin/article/articletop', 'post');
    Route::rule('articleedit/[:id]', 'admin/article/articleedit', 'get|post');
    Route::rule('articledel', 'admin/article/articledel', 'post');
    Route::rule('memberlist/[:status]', 'admin/member/memberlist', 'get');
    Route::rule('memberadd', 'admin/member/memberadd', 'get|post');
    Route::rule('memberstatus', 'admin/member/memberstatus', 'post');
    Route::rule('memberedit/[:id]', 'admin/member/memberedit', 'get|post');
    Route::rule('memberdel', 'admin/member/memberdel', 'post');
    Route::rule('commemtlist', 'admin/comment/commentlist', 'get');
    Route::rule('commentread/:id', 'admin/comment/commentread', 'get');
    Route::rule('commentdel', 'admin/comment/commentdel', 'post');
    Route::rule('set', 'admin/system/set', 'get|post');
    Route::miss('admin/index/miss');
});
