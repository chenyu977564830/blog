@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加配置
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
        <form action="{{url('admin/conf')}}" method="post">
        {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>配置名称：</th>
                        <td>
                            <input type="text"  name="conf_name" value="{{isset($confEdit->conf_name) ?$confEdit->conf_name : ''}}" >
                             <span><i class="fa fa-exclamation-circle yellow"></i>2-20字</span>
                        </td>
                    </tr>
                    <tr>
                        <th>配置标题:</th>
                        <td>
                            <input type="text" class="lg" name="conf_title" value="{{isset($confEdit->conf_title) ?$confEdit->conf_title : ''}}" >
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>配置显示类型:</th>
                        <td>
                            <input type="radio" name="field_type" value="input" checked="checked" >input
                            <input type="radio" name="field_type" value="radio" id='radio' >radio
                            <input type="radio" name="field_type" value="textarea">textarea
                        </td>
                    </tr>
                    <script>
                        $("#radio").click(function(){
                            $('#radio-x').css('display','');
                        });
                        $("input[type='radio']").not('#radio').click(function(){
                            $('#radio-x').css('display','none');
                        });
                    </script>
                    <tr id='radio-x' style="display: none;">
                        <th><i class="require">*</i>类型值:</th>
                        <td>
                            <input type="radio" name="field_value" value="1">开启
                            <input type="radio" name="field_value" value="0">关闭
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="conf_order" value="{{isset($confEdit->conf_order) ?$confEdit->conf_order : '0'}}" >
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>说明：</th>
                        <td>
                            <textarea name="conf_tips" id="" cols="30" rows="10"></textarea>
                        </td>
                    </tr>
                    
                    <tr>
                        <th></th>
                        <td>
                            <input type="hidden" name='conf_id' value="{{isset($confEdit->conf_id) ?$confEdit->conf_id : ''}}" >
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection