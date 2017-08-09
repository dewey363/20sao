<?php
/**
 * Created by IntelliJ IDEA.
 * User: tingfeng
 * Date: 2017/5/7
 * Time: 1:49
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Video extends Base
{
    protected $guarded = [];

    /**
     * 获取随机标题
     * @return mixed
     */
    public static function getRandTitle(){
        return self::orderBy(DB::Raw('rand()'))->limit(1)->value('title');
    }
}