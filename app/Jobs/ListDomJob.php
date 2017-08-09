<?php
/**
 * Created by IntelliJ IDEA.
 * User: tingfeng
 * Date: 2017/5/7
 * Time: 1:04
 */

namespace App\Jobs;


class ListDomJob extends Job
{
    private $html;
    public $tries = 3;
    private $host;
    private $type;
    public function __construct($html, $host, $type)
    {
        $this->html = $html;
        $this->host = $host;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $html = $this->html;
        $listDom = \phpQuery::newDocument($html);
        $list = $listDom->find('ul>li');
        $count = $list->count();
        for($i = 1; $i <= $count; $i++){
            $map = pq($list->eq($count - $i));
            $data = [
                'title' => $map->find('a')->text(),
                'parse_type' => '20sao.com',
                'type_id' => $this->type,
                'source_url' => $this->host.$map->find('a')->attr('href'),
                'thumb' => $map->find('a>img')->attr('src'),
            ];
            dispatch(new ListOneJob($data));
        }
    }
}