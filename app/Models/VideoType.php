<?php

namespace App\Models;

class VideoType extends Base
{
    /**
     * 获取类型名称
     * @param $id
     * @return mixed
     */
    public static function getNameById($id){
        return self::where('id', $id)->value('name');
    }
}
