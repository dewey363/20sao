<?php

/**
 * Created by IntelliJ IDEA.
 * User: tingfeng
 * Date: 2017/4/2
 * Time: 9:51
 */
namespace App\Console\Commands;

use App\Jobs\ListDomJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class Se extends Command
{
    protected $signature = 'se:list {--first=true} {--type=27} {--page=1}';

    protected $description = 'Command description';
    private static $host = 'http://www.68btbt.com';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $typeMap = self::typeMap();
        $page = $this->option('page');
        $type = $this->option('type');
        $first = $this->option('first');
        if(!array_key_exists($type, $typeMap))
        {
            Log::info("不存在的类型：".$type);
            exit();
        }

        try{
            echo "ing: type:{$type},page:{$page}\r\n";
            $content = self::getUrlHtml($type, $page);
            $domMap = new \IvoPetkov\HTML5DOMDocument();
            $domMap->loadHTML($content);
            $listContent = $domMap->querySelector('.tlist')->outerHTML;
            $pageContents = $domMap->querySelector('.page')->outerHTML;
        }catch (\Exception $e)
        {
            if($page == 0)
            {
                $keys = array_keys($typeMap);
                $index = array_search($type, $keys);
                ++$index;
                if(isset($keys[$index]))
                {
                    Artisan::call('se:list', [
                        '--type' => $keys[$index],
                        '--first' => true
                    ]);
                }
                exit();
            }
            echo "error: type:{$type},page:{$page}\r\n";
            Artisan::call('se:list', [
                '--type' => $type,
                '--page' => $page,
                '--first' => false
            ]);
            exit();
        }

        $pageDom = \phpQuery::newDocument($pageContents);
        $pageTxt = $pageDom->find('span:first')->text();
        if(preg_match('/\/(.*)页/', $pageTxt, $pageMatch))
        {
            $totalPage = $pageMatch[1];
            if($first){
                Artisan::call('se:list', [
                    '--type' => $type,
                    '--page' => $totalPage,
                    '--first' => false
                ]);
                exit();
            }
        }else{
            $totalPage = 0;
        }

        dispatch(new ListDomJob($listContent, self::$host, $typeMap[$type]));
        if($page <= $totalPage){
            Artisan::call('se:list', [
                '--type' => $type,
                '--page' => (--$page),
                '--first' => false
            ]);
        }else if($page == 0)
        {
            $keys = array_keys($typeMap);
            $index = array_search($type, $keys);
            ++$index;
            if(isset($keys[$index]))
            {
                Artisan::call('se:list', [
                    '--type' => $keys[$index],
                    '--first' => true
                ]);
            }else{
                Log::info("finash");
                exit("finash");
            }
        }
    }

    /**
     * 获取Url内容
     * @param $type
     * @param $page
     * @return bool|string
     */
    private static function getUrlHtml($type, $page)
    {
        $fileName = 'page.txt';
        $host = self::$host.'/diao/se';
        $pages = ($page == 1)?'':'_'.$page;
        $url = $host.$type.$pages.'.html';
        $content = file_get_contents($url);
        $content = iconv("gb2312",
            "utf-8//IGNORE",
            str_replace('gb2312', 'utf-8', $content)
        );
        file_put_contents(storage_path($fileName), $content);
        $content = file_get_contents(storage_path($fileName));
        return $content;
    }
    /**
     * 类型对应关系
     * @return array
     */
    private static function typeMap()
    {
        $type = [
            '27' => 1,//乱伦
            '28' => 2,//人妻
            '29' => 3,//偷拍
            '34' => 4,//学生
            '54' => 5,//巨乳
            '55' => 6,//日韩
            '56' => 7,//欧美
            '57' => 8,//国产
            '58' => 9,//动漫
        ];
        return $type;
    }
}