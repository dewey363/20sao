<?php
/**
 * Created by IntelliJ IDEA.
 * User: root
 * Date: 2017/7/15
 * Time: 20:37
 */

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoType;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class Se extends Controller
{
    private $agent;
    public function __construct()
    {
        $this->agent = new Agent();
        $category = VideoType::get();
        $title = Video::getRandTitle();
        view()->share('data', [
            'category' => $category,
            'title' => substr($title, 2),
            'isMobile' => $this->agent->isMobile()
        ]);
    }

    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $info = Video::orderBy('id', 'desc')->limit(6)->get();
        $infoPc = Video::orderBy('id', 'desc')->limit(12)->get();
        $rands = Video::orderBy(DB::Raw('rand()'))->limit(6)->get();
        $randsPc = Video::orderBy(DB::Raw('rand()'))->limit(12)->get();
        return $this->view($request, 'index', compact('info', 'rands', 'infoPc', 'randsPc'));
    }

    /**
     * 分类
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request, $id, $page = 1){
        $request->merge(['page' => $page]);
        $list = Video::where('type_id', $id)->orderBy('id', 'desc')->paginate(6);
        $listPc = Video::where('type_id', $id)->orderBy('id', 'desc')->paginate(16);
        if(is_null($list)) return response('404');
        $cateName = VideoType::getNameById($id);
        return $this->view($request, 'category', compact('list', 'id', 'cateName', 'listPc'));
    }

    /**
     * 详细
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info(Request $request, $id){
        $info = Video::find($id);
        if(is_null($info)) return response('404');
        $info['typeName'] = VideoType::where('id', $info->type_id)->value('name');
        $rands = Video::orderBy(DB::Raw('rand()'))->limit(4)->get();
        $randPc = Video::orderBy(DB::Raw('rand()'))->limit(12)->get();
        return $this->view($request, 'info', compact('info', 'rands', 'randPc'));
    }

    /**
     * 搜索
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request, $title = '', $page = 1){
        $title = $request->has('title')?$request->input('title'):$title;
        $request->merge(['page' => $page]);
        if($this->agent->isMobile()){
            $list = Video::where('title', 'like', '%'.$title.'%')
                ->orderBy('id', 'asc')->paginate(6);
        }else{
            $list = Video::where('title', 'like', '%'.$title.'%')
                ->orderBy('id', 'asc')->paginate(16);
        }
        if(is_null($list)) return response('404');
        return $this->view($request, 'search', compact('list', 'title'));
    }

    /**
     * 获取缩略图
     * @param $id 数据ID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getThumb($id){
        $info = Video::find($id);
        if(is_null($info)) return response('404');
        $client = new Client();
        $file = $client->get($info->thumb);
        return response($file->getBody()->getContents())->header('Content-Type', "image/png");
    }

    /**
     * 手机自适应模板
     * @param string $template
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function view(Request $request, $template = '', $data = []){
        if(!$request->ajax()){
            $template = 'http_m_se.'.$template;
        }else{
            $template = 'm_se.'.$template;
        }
        return view($template, $data);
    }
}