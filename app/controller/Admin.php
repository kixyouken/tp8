<?php

declare(strict_types=1);

namespace app\controller;

use app\BaseController;
use think\facade\View;

class Admin extends BaseController
{
    public function index()
    {
        $content = file_get_contents($this->app->getAppPath() . '/json/menu.json');
        $data = json_decode($content, true);
        $pathinfos = explode('/', $this->request->pathinfo());
        View::assign('rule', '/' . $this->request->pathinfo());
        View::assign('pathinfos', $pathinfos);
        return view('', $data);
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function table()
    {
        $content = file_get_contents($this->app->getAppPath() . '/json/menu.json');
        $data = json_decode($content, true);
        $pathinfos = explode('/', $this->request->pathinfo());
        View::assign('rule', '/' . $this->request->pathinfo());
        View::assign('pathinfos', $pathinfos);

        $pathinfos = explode('/', $this->request->pathinfo());
        $table_json = file_get_contents($this->app->getAppPath() . '/json/table/' . $pathinfos[2] . '.json');
        $table = json_decode($table_json, true);
        View::assign($table);
        return view('', $data);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function form()
    {
        return 'form';
    }
}