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

Route::get('index', '@portal/index/index');
//文章搜索页
Route::get('search', '@portal/search/index');


Route::get('/:alias','@portal/article/list');


Route::get('/article/:aid', '@portal/article/detail');



Route::get('/help/:id', '@portal/info/detail');

Route::get('/help/:cate', '@portal/info/list');



// 个人中心
Route::get('u/:uid', '@user/home/index');


Route::get('u/:uid/collect', '@user/home/collect');

Route::get('u/:uid/comment', '@user/home/comment');
