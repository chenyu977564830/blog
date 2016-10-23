<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Link;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;


//use Illuminate\Support\Facades\Config;

require_once('resources/org/UnlimitedForLevel.class.php');


class IndexController extends CommonController
{
    public function index()
    {
        $ad_image=Config::get('web.ad_image');
        $wisdom=Config::get('web.wisdom');
    	return view('home.index',compact('ad_image','wisdom'));
    }

    public function article($id)
    {
        //当前篇
        $article_detal = $articleList = DB::table('article')
                ->join('category', 'article.cate_id', '=', 'category.cate_id')
                ->where('art_id',$id)->where('article.art_open','1')
                ->select('article.*', 'category.cate_name')
                ->first();
        $cates=Category::all();//所有分类
        $cates=\unlimitedLevel::getParents($cates,$article_detal->cate_id);
        //上一篇
        $art_pre=Article::where('art_time','<',$article_detal->art_time)->where('art_open','1')->orderBy('art_time','desc')->first();
        //下一篇
        $art_next=Article::where('art_time','>',$article_detal->art_time)->where('art_open','1')->orderBy('art_time','asc')->first();
        //6篇相关文章
        $art_releatives=Article::where('cate_id',$article_detal->cate_id)->where('art_open','1')->orderBy('art_time','desc')->limit(6)->get();
    	return view('home.new',compact('article_detal','art_releatives','art_pre','art_next','cates'));
    }
    public function cate($id)
    {
        $cates=Category::all();//所有分类
        //该分类分类信息
        foreach($cates as $k => $v){
            if($v['cate_id']==$id){
                $cate_detal=$cates[$k];
            }
        }
        if(!isset($cate_detal))return view('errors.404');
        
        //该分类所有子分类
        $cate_childs=\unlimitedLevel::getChilds($cates,$cate_detal->cate_id);
        
        //$id分类下 文章 分页
        $page_size=Config::get('web.page_size');//分页条数配置
        $articleList = DB::table('article')
                ->join('category', 'article.cate_id', '=', 'category.cate_id')
                ->where('category.cate_id',$cate_detal->cate_id)->where('article.art_open','1')
                ->select('article.*', 'category.cate_name')
                ->orderBy('article.art_time','desc')
                ->paginate($page_size);
        //广告图片
        $ad_image=Config::get('web.ad_image');       
    	return view('home.list',compact('cate_childs','cate_detal','articleList','ad_image'));
    }

}
