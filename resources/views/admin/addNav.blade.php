@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加导航
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
        <form action="{{url('admin/nav')}}" method="post">
        {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>

                        <th><i class="require">*</i>导航名称：</th>
                        <td>
                            <input type="text"  name="nav_name" value="{{isset($navEdit->nav_name) ?$navEdit->nav_name : ''}}" >
                             <span><i class="fa fa-exclamation-circle yellow"></i>2-20字</span>
                        </td>
                    </tr>
                    <tr>
                        <th>导航英文名:</th>
                        <td>
                            <input type="text"  name="nav_alias" value="{{isset($navEdit->nav_alias) ?$navEdit->nav_alias : ''}}" >
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>导航地址:</th>
                        <td>
                            <input type="text" name="nav_url" value="{{isset($navEdit->nav_url) ?$navEdit->nav_url : ''}}" >
                        </td>
                    </tr>
                      <tr>
                        <th></i>导航用户名:</th>
                        <td>
                            <input type="text" name="nav_user" value="{{isset($navEdit->nav_user) ?$navEdit->nav_user : ''}}" >
                        </td>
                    </tr>
                    <tr>
                        <th></i>导航用户名密码:</th>
                        <td>
                            <input type="text" name="nav_password" value="{{isset($navEdit->nav_password) ?$navEdit->nav_password : ''}}" >
                        </td>
                    </tr>
                    <tr>
                        <th></i>导航描述:</th>
                        <td>
                            <input type="text" name="nav_description" value="{{isset($navEdit->nav_description) ?$navEdit->nav_description : ''}}" >
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="nav_order" value="{{isset($navEdit->nav_order) ?$navEdit->nav_order : '0'}}" >
                        </td>
                    </tr>
                    
                    <tr>
                        <th></th>
                        <td>
                            <input type="hidden" name='nav_id' value="{{isset($navEdit->nav_id) ?$navEdit->nav_id : ''}}" >
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection