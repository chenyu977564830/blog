<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\View;
use App\Http\Model\Nav;
use App\Http\Controllers\Controller;
use App\Http\Model\Article;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Link;
use Illuminate\Support\Facades\Config;

class CommonController extends Controller
{
    public function __construct(){

		//文章推荐5篇推荐的文章的按时间选art_time
        $page_size=Config::get('web.page_size');//分页条数配置
        $art_recommends = DB::table('article')
                ->join('category', 'article.cate_id', '=', 'category.cate_id')
                ->where('article.art_recommend','1')->where('article.art_open','1')
                ->select('article.*', 'category.cate_name')
                ->paginate($page_size);
        //个人博客模板位置6篇点击量最高的art_view 点击排行6篇点击量最高的
        $art_views=Article::orderBy('art_view','desc')->where('art_open','1')->limit(6)->get();
        //最新文章8篇art_time
        $art_news=Article::orderBy('art_time','desc')->where('art_open','1')->limit(6)->get();
        //友情链接
        $link_num=Config::get('web.web_link_num')?Config::get('web.web_link_num'):2;
        $links=Link::where('link_myproject','0')->orderBy('link_order','desc')->limit($link_num)->get();
        //个人项目
        $links_my=Link::where('link_myproject','1')->orderBy('link_order','desc')->get();
        $default_image=Config::get('web.default_image');//如果文章没有图片则显示网站配置的默认图片
    	$navs=Nav::all();//导航
        $weixin_image=Config::get('web.weixin_image');//微信图片
    	View::share([
    		'art_views'=>$art_views,
    		'navs'=>$navs,
    		'art_news'=>$art_news,
    		'links'=>$links,
    		'links_my'=>$links_my,
    		'default_image'=>$default_image,
    		'art_recommends'=>$art_recommends,
            'weixin_image'=>$weixin_image
    	]);
    }
}
