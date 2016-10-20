@extends('layouts.admin')
@section('content')
    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
    <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('resources/org/uploadify/uploadify.css')}}">
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加文章
    </div>

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

    <!--面包屑导航 结束-->   
    <div class="result_wrap">
        <form action="{{url('admin/article')}}" method="post">
        {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>文章分类：</th>
                        <td>
                            <select name="cate_id">
                                <option value="">==请选择==</option>
                                @foreach($cates as $cate)
                                <option value="{{$cate->cate_id}}" @if(isset($article)&&$article->cate_id==$cate->cate_id) selected="selected" @endif>{{$cate->html}}{{$cate->cate_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_title" value="@if(isset($article)) {{$article->art_title}} @endif" >
                            <span><i class="fa fa-exclamation-circle yellow"></i>5-20字</span>
                        </td>
                    </tr>
                    <tr>
                        <th>发布人：</th>
                        <td>
                            <input type="text" name="art_editor" value="@if(isset($article)) {{$article->art_editor}} @endif" >
                            <span><i class="fa fa-exclamation-circle yellow"></i>15字以内</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>点击量：</th>
                        <td>
                            <input type="text" class="sm" name="art_view" value="@if(isset($article)) {{$article->art_view}}@else 100 @endif" disabled="disabled" >
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <label style="float:left;"><input type="hidden" class="lg" value="@if(isset($article)) {{$article->art_thumb}} @endif"  name="art_thumb"></label>
                            <label style="float:left;"><input id="file_upload" name="file_upload" type="file" multiple="true"></label>
                            <img src="@if(isset($article)) {{$article->art_thumb}} @endif" id='art_thumb_img' style="max-width: 350px;max-height: 100px;" >
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>开放：</th>
                        <td>
                            <label for=""><input type="radio" name="art_open" value="1" checked="checked" >是</label>
                            <label for=""><input type="radio" name="art_open" @if(isset($article) &&$article->art_open==0 ) checked="checked" @endif value="0" >否</label>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>关键词：</th>
                        <td>
                            <input type="text" class="sm" name="art_tag" value="@if(isset($article)) {{$article->art_tag}} @endif" >
                             <span><i class="fa fa-exclamation-circle yellow"></i>逗号分割</span>
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="art_discription">@if(isset($article)) {{$article->art_discription}} @endif</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>详细内容：</th>
                        <td>
                            <textarea class="lg" id="editor" name="art_content" style="width:860px;height:500px;" >@if(isset($article)) {{$article->art_content}} @endif</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script type="text/javascript">

        var ue = UE.getEditor('editor');//编辑器
        
        //文件上传
        <?php $timestamp = time();?>
        $(function() {
            $('#file_upload').uploadify({
                'buttonText' : '图片上传',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    '_token'     : "{{csrf_token()}}"
                },
                'swf'      : "{{asset('resources/org/uploadify/uploadify.swf')}}",
                'uploader' : "{{url('admin/upload')}}",
                'onUploadSuccess' : function(file, data, response) {
                   $("input[name='art_thumb']").val(data);
                   $("#art_thumb_img").attr('src',data);
                }
            });
        });
    </script>
    <style>
        .edui-default{line-height: 28px;}
        div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
        {overflow: hidden; height:20px;}
        div.edui-box{overflow: hidden; height:22px;}
        .uploadify{display:inline-block;}
        .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
        table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
    </style>
@endsection