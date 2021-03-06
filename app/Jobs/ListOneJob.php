<?php

namespace App\Jobs;

use App\Models\Video;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class ListOneJob extends Job
{
    private $dataMap = [];
    public $tries = 3;
    public function __construct(Array $dataMap)
    {
        $this->dataMap = $dataMap;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dataMap = $this->dataMap;

        $findRes = Video::where($dataMap)->first();
        if(is_null($findRes))
        {
            $map = Video::create($dataMap);
            try{
                $html = self::getUrlHtml($map->source_url);
                if(preg_match('/video=\["(.*)"\]/', $html, $match))
                {
                    if(strpos($match[1], '.mp4')){
                        $map->file_url = $match[1];
                        $map->save();
                        $client = new Client();
                        $file = $client->get($match[1]);
                        Storage::disk('local')->put('video/'.$map->id.'.mp4', $file->getBody());
                    }
                }
            }catch (\Exception $e)
            {
                return;
            }

        }
    }

    /**
     * 获取Url内容
     * @return bool|string
     */
    private static function getUrlHtml($url)
    {
        $fileName = 'pageOne.txt';
        $content = file_get_contents($url);
        $content = iconv("gb2312",
            "utf-8//IGNORE",
            str_replace('gb2312', 'utf-8', $content)
        );
        file_put_contents(storage_path($fileName), $content);
        $content = file_get_contents(storage_path($fileName));
        return $content;
    }
}
