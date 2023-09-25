<?php

declare(strict_types=1);

namespace app\controller;

use app\BaseController;
use app\model\Base;
use think\facade\View;

class Admin extends BaseController
{
    public function index()
    {
        $content = file_get_contents($this->app->getRootPath() . '/public/json/menu.json');
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
        $content = file_get_contents($this->app->getRootPath() . '/public/json/menu.json');
        $data = json_decode($content, true);
        $pathinfos = explode('/', $this->request->pathinfo());
        View::assign('rule', '/' . $this->request->pathinfo());
        View::assign('pathinfos', $pathinfos);

        $pathinfos = explode('/', $this->request->pathinfo());
        $table_json = file_get_contents($this->app->getRootPath() . '/public/json/table/' . $pathinfos[2] . '.json');
        $table = json_decode($table_json, true);

        $model_json = file_get_contents($this->app->getRootPath() . '/public/json/model/' . $table['model'] . '.json');
        $model_arr = json_decode($model_json, true);
        $model = new Base($model_arr['table']);
        if (empty($table['columns'])) {
            $fields = $model->getFields();
            $table['columns'] = $model->getColumns($fields);
        }
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
        $pathinfos = explode('/', $this->request->pathinfo());
        View::assign('pathinfos', $pathinfos);

        $form_json = file_get_contents($this->app->getRootPath() . '/public/json/form/' . $pathinfos[2] . '.json');
        $form = json_decode($form_json, true);

        foreach ($form['columns'] as $key => &$value) {
            if (!empty($value['api'])) {
                $model = new Base($value['api']['model']);
                $value['options'] = $model->getAll("", [$value['api']['value'] => 'value', $value['api']['label'] => 'label']);
            }
        }
        return view('', $form);
    }
}