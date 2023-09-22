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

Route::group('admin', function () {
    Route::get('/index', 'Admin/index');
    Route::get('/table/:table', 'Admin/table');
    Route::get('/form/:form', 'Admin/form');
});

Route::group('api', function () {
    Route::get('/:model/index', 'Api/index');
    Route::get('/:model/read/:id', 'Api/read');
    Route::post('/:model/save', 'Api/save');
    Route::put('/:model/update/:id', 'Api/update');
    Route::delete('/:model/delete/:id', 'Api/delete');
});