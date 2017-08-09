<?php
/**
 * Created by IntelliJ IDEA.
 * User: tingfeng
 * Date: 2017/5/31
 * Time: 19:46
 */

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class Youjizz extends Command
{
    protected $signature = 'se:youjizzList {--page=} {--next=}';

    protected $description = 'Command description';
    public $host = '';
    public function __construct()
    {
        parent::__construct();
        $this->host = 'https://www.youjizz.com';
    }

    public function handle()
    {
        $page = $this->option('page');
        $next = $this->option('next');
        $page = is_null($page)?1:$page;
        $next = is_null($next)?1:$next;
        $url = $this->host.'/most-popular/'.$page.'.html';
        try{
            $html = self::getUrlHtml($url);
            $dom = \phpQuery::newDocument($html);
            $data = $dom->find('.video-thumb.desktop-only');
            $currentPage = $dom->find('.pagination:first>.active>a')->text();
            unset($dom,$html,$url);
            if(empty($currentPage)){
                if($currentPage == $next)
                {
                    Log::info("finash,page:".$currentPage);
                    echo "finash";
                }else{
                    Artisan::call('se:youjizz', [
                        '--page' => $page,
                        '--next' => $page
                    ]);
                }
                unset($page, $next, $currentPage);
                exit();
            }
        }catch (\Exception $e){
            Artisan::call('se:youjizz', [
                '--page' => $page,
                '--next' => $page
            ]);
            unset($page, $next, $e);
            exit();
        }

        echo "ing: page:{$page},next:{$next},memory:",(memory_get_usage()/(1024*1024)),"M\r\n";
        foreach ($data as $item)
        {
            $map = pq($item);
            $datas = [
                'title' => $map->find('.video-title')->text(),
                'parse_type' => 'youjizz.com',
                'type_id' => 7,
                'sort' => 0,
                'source_url' => $this->host.$map->find('a')->attr('href'),
                'thumb' => 'https:'.$map->find('.lazy.img-responsive')->attr('data-original'),
            ];
            $obj = new \App\Jobs\Youjizz($datas);
            dispatch($obj);
            unset($map,$datas, $obj);
        }
        Artisan::call('se:youjizz', [
            '--page' => ($page+1),
            '--next' => ($page+1)
        ]);
    }

    /**
     * 获取Url内容
     * @param $url
     * @return bool|string
     */
    private static function getUrlHtml($url)
    {
        $content = file_get_contents($url);
        return $content;
    }
}