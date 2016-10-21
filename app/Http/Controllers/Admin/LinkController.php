<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
  
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Model\Link;

class LinkController extends CommonController
{
    /**
     *  
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links=Link::orderBy('link_order','asc')->get();
        return view('admin.listLink',compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addLink');
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
            'link_url'=>'required',
            'link_name'=>'required|between:2,20',
            'link_order'=>'required'
        ];
        $message=[
            'link_url.required'=>'链接地址不能为空',
            'link_name.required'=>'链接名称不能为空',
            'link_name.between'=>'链接名称在2-20字之间',
            'link_order.required'=>'排序不能为空'
        ];

        $validator=Validator::make($input,$rules,$message);
        if($validator->passes()){
            if(isset($input['link_id'])&&$input['link_id']!=''){//更新
                $data=Input::except('_token','link_id');
                Link::where('link_id',$input['link_id'])->update($data);
                $msg='修改链接成功';
            }else{
                Link::create(Input::all());
                $msg='添加链接成功';
            }
            return redirect('admin/link')->with('msg',$msg);
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
        $links=Link::orderBy('link_order','asc')->get();
        $linkEdit=Link::find($id);
        return view('admin.addLink',compact('linkEdit','links'));
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
        $link=Link::find($id);
            $re=$link->delete();
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
        $link=Link::find($input['link_id']);
        $link->link_order=$input['link_order'];
        $re=$link->update();
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
