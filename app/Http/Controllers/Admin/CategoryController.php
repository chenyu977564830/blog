<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Model\Category;
use App\Http\Model\Article;
require_once('resources/org/UnlimitedForLevel.class.php');
class CategoryController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cates=Category::orderBy('cate_order','asc')->get();
        $cates=\unlimitedLevel::unlimitedForLevel($cates);

        return view('admin.listCate',compact('cates'));
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
        return view('admin.addCate',compact('cates'));
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
        $rules=[
            'cate_pid'=>'required',
            'cate_name'=>'required|between:1,20',
            'cate_order'=>'required'
        ];
        $message=[
            'cate_pid.required'=>'父级id不能为空',
            'cate_name.required'=>'分类名称不能为空',
            'cate_name.between'=>'分类名称在1-20字之间',
            'cate_order.required'=>'排序不能为空'
        ];

        $validator=Validator::make($input,$rules,$message);
        if($validator->passes()){
            if(isset($input['cate_id'])&&$input['cate_id']!=''){//更新
                $data=Input::except('_token','cate_id');
                Category::where('cate_id',$input['cate_id'])->update($data);
                $msg='修改分类成功';
            }else{
                Category::create(Input::all());
                $msg='添加分类成功';
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
        $cateEdit=Category::find($id);
        return view('admin.addCate',compact('cateEdit','cates'));
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
        
        $cateChild=Category::where('cate_pid',$id)->get();
        $cateAtricle=Article::where('cate_id',$id)->get();
        if(count($cateChild)>0 || count($cateAtricle)>0){
            $data=[
                'status'=>1,
                'msg'=>'存在文章或子分类，不允许删除'
            ];
        }else{
            $cate=Category::find($id);
            $re=$cate->delete();
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

        }
        return $data;


    }
    
    public function order()
    {
        $input=Input::all();
        $cate=Category::find($input['cate_id']);
        $cate->cate_order=$input['cate_order'];
        $re=$cate->update();
        if($re){
            $data=[
                'status'=>0,
                'msg'=>'排序成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'排序失败'
            ];
        }

        return $data;
    }
}
