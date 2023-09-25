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

    public function getPage($table_json)
    {
        $limit = Request::get('limit', 10);
        return $this->getTable($table_json)->paginate($limit);
    }

    public function setDelete($id)
    {
        $this->table->where('id', $id)->useSoftDelete('deleted_at', date('Y-m-d H:i:s'))->delete();
    }

    private function getTable($table_json)
    {
        if (!empty($table_json['orders'])) {
            foreach ($table_json['orders'] as $key => &$value) {
                $this->table->order($value['field'], $value['sort']);
            }
        }

        if (!empty($table_json['wheres'])) {
            foreach ($table_json['wheres'] as $key => &$value) {
                $this->table->where($value['field'], $value['match'], $value['value']);
            }
        }

        return $this->table;
    }
}