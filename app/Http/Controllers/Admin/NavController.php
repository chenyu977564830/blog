<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
 
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Model\Nav;

class NavController extends CommonController
{
    /**
     *  
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navs=Nav::orderBy('nav_order','asc')->get();
        return view('admin.listNav',compact('navs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addNav');
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
            'nav_url'=>'required',
            'nav_name'=>'required|between:2,20',
            'nav_order'=>'required'
        ];
        $message=[
            'nav_url.required'=>'导航地址不能为空',
            'nav_name.required'=>'导航名称不能为空',
            'nav_name.between'=>'导航名称在2-20字之间',
            'nav_order.required'=>'排序不能为空'
        ];

        $validator=Validator::make($input,$rules,$message);
        if($validator->passes()){
            if(isset($input['nav_id'])&&$input['nav_id']!=''){//更新
                $data=Input::except('_token','nav_id');
                Nav::where('nav_id',$input['nav_id'])->update($data);
                $msg='修改导航成功';
            }else{
                Nav::create(Input::all());
                $msg='添加导航成功';
            }
            return redirect('admin/nav')->with('msg',$msg);
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
        $navs=nav::orderBy('nav_order','asc')->get();
        $navEdit=Nav::find($id);
        return view('admin.addNav',compact('navEdit','navs'));
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
        $nav=nav::find($id);
            $re=$nav->delete();
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

     public function order()
    {
        $input=Input::all();
        $nav=Nav::find($input['nav_id']);
        $nav->nav_order=$input['nav_order'];
        $re=$nav->update();
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
