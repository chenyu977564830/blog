<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Model\Article;
use App\Http\Model\Category;

require_once('resources/org/UnlimitedForLevel.class.php');
class ArticleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cate_id=null,$keywords=null)
    {

        $cates=Category::orderBy('cate_order','asc')->get();
        $cates=\unlimitedLevel::unlimitedForLevel($cates);
        if($cate_id || $keywords ){//如果分类id存在或者关键词存在就会进行搜索
            if($cate_id&&$keywords!="null"){
                $articleList = DB::table('article')
                ->join('category', 'article.cate_id', '=', 'category.cate_id')
                ->where('article.cate_id',$cate_id)->where('art_title','like','%'.$keywords.'%')
                ->select('article.*', 'category.cate_name')
                ->paginate(5);
            }elseif($cate_id){
                 $articleList = DB::table('article')
                ->join('category', 'article.cate_id', '=', 'category.cate_id')
                ->where('article.cate_id',$cate_id)
                ->select('article.*', 'category.cate_name')
                ->paginate(5);
            }else{
                $articleList = DB::table('article')
                ->join('category', 'article.cate_id', '=', 'category.cate_id')
                ->where('art_title','like','%'.$keywords.'%')
                ->select('article.*', 'category.cate_name')
                ->paginate(5);
            }
            
        }else{
            $articleList = DB::table('article')
                ->join('category', 'article.cate_id', '=', 'category.cate_id')
                ->select('article.*', 'category.cate_name')
                ->paginate(5);
        }
        return view('admin.listArticle',compact('articleList','cates','cate_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cates=Category::orderBy('cate_order','asc')->get();
        $cates=\unlimitedLevel::unlimitedForLevel($cates);

        return view('admin.addArticle',compact('cates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->input();
        $input['art_time']=time();//文章添加/修改时间
        $rules=[
            'cate_id'=>'required',
            'art_content'=>'required',
            'art_title'=>'required|between:5,20',
            'art_time'=>'required',
            'art_open'=>'required',
            'art_description'=>'between:50,100'
        ];
        $message=[
            'cate_id.required'=>'分类不能为空',
            'art_content.required'=>'文章内容不能为空',
            'art_time.required'=>'文章添加时间不能为空',
            'art_open.required'=>'请确认是否开放',
            'art_title.required'=>'文章标题不能为空',
            'art_title.between'=>'文章标题在5-20字之间',
            'art_description.between'=>'文章描述在50-100字之间'
        ];

        $validator=Validator::make($input,$rules,$message);
        if($validator->passes()){
            if(isset($input['art_id'])&&$input['art_id']!=''){//更新
                $data=Input::except('_token','art_id');
                Article::where('art_id',$input['art_id'])->update($data);
                $msg='修改文章成功';
            }else{
                Article::create(Input::all());
                $msg='添加文章成功';
            }
            return back()->with('msg',$msg);
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cates=Category::orderBy('cate_order','asc')->get();
        $cates=\unlimitedLevel::unlimitedForLevel($cates);
        $article=Article::find($id);
        return view('admin.addArticle',compact('cates','article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $art=Article::find($id);
        $re=$art->delete();
        if($re){
            $data=[
                'status'=>0,
                'msg'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'删除失败'
            ];
        }
        return $data;
    }

    public function delMuch()
    {
        $input=Input::all();
        foreach($input['art_ids'] as $v){
            $art=Article::find($v);
            $re=$art->delete();
            if(!$re){
                $data=[
                'status'=>1,
                'msg'=>'删除失败'
                ];
            }
        }
        $data=[
            'status'=>0,
            'msg'=>'删除成功'
        ];

        return $data;

    }
}
