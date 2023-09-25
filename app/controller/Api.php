<?php
declare(strict_types=1);

namespace app\controller;

use app\BaseController;
use app\common\Output;
use app\model\Base;
use think\facade\App;
use think\facade\Request;

class Api extends BaseController
{
    use Output;

    public $table = null;

    public function __construct()
    {
        $pathinfos = explode('/', Request::pathinfo());
        $table_json = file_get_contents(App::getRootPath() . '/public/json/table/' . $pathinfos[1] . '.json');
        $this->table = json_decode($table_json, true);
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $model = new Base($this->table['model']);
        $data = $model->getPage($this->table);

        return $this->pageful($data->getCollection(), $data->total());
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        return 'save';
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $model = new Base('users');
        return json($model->getId($id));
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        return 'update';
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $model = new Base($this->table['model']);
        $model->setDelete($id);
        return $this->successful('删除成功');
    }
}