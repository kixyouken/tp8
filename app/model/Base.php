<?php

namespace app\model;

use think\facade\Db;
use think\facade\Request;

class Base
{
    public $table = null;

    public function __construct($table)
    {
        $this->table = Db::table($table);
    }

    public function getId($id)
    {
        return $this->table->where('id', $id)->find();
    }

    public function getPage()
    {
        $limit = Request::get('limit', 10);
        return $this->table->paginate($limit);
    }
}