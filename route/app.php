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
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

Route::get(':controller/index', 'Common/index');
Route::get(':controller/create', 'Common/create');
Route::get(':controller/read/:id', 'Common/read');
Route::get(':controller/edit/:id', 'Common/edit');
Route::put(':controller/update/:id', 'Common/update');
Route::post(':controller/save', 'Common/save');
Route::delete(':controller/delete/:id', 'Common/delete');
