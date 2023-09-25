<?php

namespace app\common;

trait Output
{
    public function successful($msg = 'success')
    {
        return json(['code' => 0, 'msg' => $msg]);
    }

    public function dataful($data = null)
    {
        return json(['code' => 0, 'data' => $data, 'msg' => 'success']);
    }

    public function pageful($data = null, $count = 0)
    {
        return json(['code' => 0, 'data' => $data, 'count' => $count, 'msg' => 'success']);
    }
}