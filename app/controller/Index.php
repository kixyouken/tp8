<?php

namespace app\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        $content = file_get_contents($this->app->getAppPath() . '/json/menu.json');
        $data = json_decode($content, true);
        return view('', $data);
    }

    public function hello($name = 'ThinkPHP8')
    {
        return 'hello,' . $name;
    }
}
