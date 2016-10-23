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
        <form action="{{url('admin/link')}}" method="post">
        {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>链接名称：</th>
                        <td>
                            <input type="text"  name="link_name" value="{{isset($linkEdit->link_name) ?$linkEdit->link_name : ''}}" >
                             <span><i class="fa fa-exclamation-circle yellow"></i>2-20字</span>
                        </td>
                    </tr>
                    <tr>
                        <th>链接标题:</th>
                        <td>
                            <input type="text" class="lg" name="link_title" value="{{isset($linkEdit->link_title) ?$linkEdit->link_title : ''}}" >
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>链接地址:</th>
                        <td>
                            <input type="text" name="link_url" value="{{isset($linkEdit->link_url) ?$linkEdit->link_url : ''}}" >
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="link_order" value="{{isset($linkEdit->link_order) ?$linkEdit->link_order : '0'}}" >
                        </td>
                    </tr>
                     <tr>
                        <th>后台用户名：</th>
                        <td>
                            <input type="text" class="sm" name="link_user" value="{{isset($linkEdit->link_user) ?$linkEdit->link_user : ''}}" >
                        </td>
                    </tr>
                     <tr>
                        <th>后台密码：</th>
                        <td>
                            <input type="text" class="sm" name="link_password" value="{{isset($linkEdit->link_password) ?$linkEdit->link_password : ''}}" >
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="radio" name="link_myproject"  value="0" checked="checked">普通链接&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="link_myproject"  value="1" @if(isset($linkEdit)&&$linkEdit->link_myproject==1) checked='checked' @endif >自己项目链接
                        </td>
                    </tr>
                     <tr>
                        <th>项目说明：</th>
                        <td>
                           <textarea name="link_description">{{isset($linkEdit->link_description) ? $linkEdit->link_description : ''}}</textarea>
                        </td>
                    </tr>
                    
                    <tr>
                        <th></th>
                        <td>
                            <input type="hidden" name='link_id' value="{{isset($linkEdit->link_id) ?$linkEdit->link_id : ''}}" >
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection