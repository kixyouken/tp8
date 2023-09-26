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

    public function getAll($table_json, $fields = ['*'])
    {
        return $this->table->field($fields)->select();
    }

    public function getId($id)
    {
        return $this->table->where('id', $id)->find();
    }

    public function getPage($table_json, $model_json)
    {
        $limit = Request::get('limit', 10);
        $this->table = $this->getModel($model_json);
        $this->table = $this->getWheres();
        return $this->getTable($table_json)->field($model_json['table'] . '.*')->paginate($limit);
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

    private function getModel($model_json)
    {
        if (!empty($model_json['joins'])) {
            foreach ($model_json['joins'] as $key => &$value) {
                $fields = $this->getFields($value['table']);
                $fields = array_map(function ($field) use ($value) {
                    return $value['table'] . '.' . $field . ' AS join_' . $value['table'] . '_' . $field;
                }, $fields);
                $this->table->field($fields)->join($value['table'], $model_json['table'] . '.' . $value['key'] . ' = ' . $value['table'] . '.' . $value['foreign'], $value['join']);
            }
        }

        if (!empty($model_json['wheres'])) {
            foreach ($model_json['wheres'] as $key => &$value) {
                if ($value['value'] == "null") {
                    $this->table->where($value['field'], $value['value']);
                } else {
                    $this->table->where($value['field'], $value['match'], $value['value']);
                }
            }
        }
        return $this->table;
    }

    private function getWheres()
    {
        $wheres = Request::param('wheres');
        if (!empty($wheres)) {
            foreach ($wheres as $key => &$value) {
                if (!empty($value)) {
                    list($field, $match) = explode('+', $key);
                    switch ($match) {
                        case 'like':
                            $this->table->whereLike($field, '%' . $value . '%');
                            break;
                        case 'like.left':
                            $this->table->whereLike($field, '%' . $value);
                            break;
                        case 'like.right':
                            $this->table->whereLike($field, $value . '%');
                            break;
                        default:
                            $this->table->where($field, $match, $value);
                            break;
                    }
                }
            }
        }

        return $this->table;
    }

    public function getFields($table)
    {
        return Db::table($table)->getTableFields();
    }

    public function getColumns($fields)
    {
        $columns = [];
        foreach ($fields as $key => &$value) {
            $columns[$key]['field'] = $value;
            $columns[$key]['title'] = $value;
        }

        return $columns;
    }
}