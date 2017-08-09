<?php
/**
 * Created by IntelliJ IDEA.
 * User: tingfeng
 * Date: 2017/5/31
 * Time: 20:36
 */

namespace App\Jobs;


use App\Models\Video;

class Youjizz extends Job
{
    private $dataMap = [];
    public $tries = 3;
    public function __construct(Array $dataMap)
    {
        $this->dataMap = $dataMap;
    }

    public function handle()
    {
        $video = Video::where($this->dataMap)->first();
        if(is_null($video))
        {
            $video = Video::create($this->dataMap);
        }
        if(is_null($video->file))
        {
            $html = self::getUrlHtml($video->source_url);
            $dom = \phpQuery::newDocument($html);
            $fileUrl = 'https:'.$dom->find('source:nth-last-child(1)')->attr('src');
            $video->file_url = $fileUrl;
            $video->save();
        }
    }
    /**
     * 获取Url内容
     * @return bool|string
     */
    private static function getUrlHtml($url)
    {
        $content = file_get_contents($url);
        return $content;
    }
}