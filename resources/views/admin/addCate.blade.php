@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加分类
    </div>
    <!--面包屑导航 结束-->
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            @if(count($errors)>0)
            <div class="mark">
                @foreach($errors->all() as $v)
                   <p>{{$v}}</p>
                @endforeach
            </div>
            @endif
           @if(session('msg'))
                <div class="mark">
                    {{session('msg')}}
                </div>
            @endif
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/category')}}" method="post">
        {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="cate_pid">
                                <option value="0">顶级分类</option>
                                @foreach($cates as $cate)
                                <option value="{{$cate->cate_id}}" @if(isset($cateEdit)&&$cate->cate_id==$cateEdit->cate_pid) selected="selected" @endif >{{$cate->html}}{{$cate->cate_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类名称：</th>
                        <td>
                            <input type="text" class="lg" name="cate_name" value="{{isset($cateEdit->cate_name) ?$cateEdit->cate_name : ''}}" >
                            <p>2-10个字</p>
                        </td>
                    </tr>
                    <tr>
                        <th>分类标题:</th>
                        <td>
                            <input type="text" name="cate_title" value="{{isset($cateEdit->cate_title) ?$cateEdit->cate_title : ''}}" >
                        </td>
                    </tr>
                    <tr>
                        <th>关键词:</th>
                        <td>
                            <input type="text" name="cate_keywords" value="{{isset($cateEdit->cate_keywords) ?$cateEdit->cate_keywords : ''}}" >
                        </td>
                    </tr>
                    <tr>
                        <th>分类描述：</th>
                        <td>
                            <textarea class="lg" name="cate_description" value="{{isset($cateEdit->cate_description) ?$cateEdit->cate_description : ''}}" ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="cate_order" value="{{isset($cateEdit->cate_order) ?$cateEdit->cate_order : ''}}" >
                        </td>
                    </tr>
                    
                    <tr>
                        <th></th>
                        <td>
                            <input type="hidden" name='cate_id' value="{{isset($cateEdit->cate_id) ?$cateEdit->cate_id : ''}}" >
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection