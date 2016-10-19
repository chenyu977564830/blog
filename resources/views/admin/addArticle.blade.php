@extends('layouts.admin')
@section('content')
    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加文章
    </div>
    <!--面包屑导航 结束-->   
    <div class="result_wrap">
        <form action="{{url('admin/article')}}" method="post">
        {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>文章分类：</th>
                        <td>
                            <select name="art_cate_id">
                                <option value="">==请选择==</option>
                                @foreach($cates as $cate)
                                <option value="{{$cate->cate_id}}">{{$cate->html}}{{$cate->cate_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>20字以内</span>
                        </td>
                    </tr>
                    <tr>
                        <th>发布人：</th>
                        <td>
                            <input type="text" name="art_editor">
                            <span><i class="fa fa-exclamation-circle yellow"></i>15字以内</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>点击量：</th>
                        <td>
                            <input type="text" class="sm" name="art_view" value="100" >
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="art_order" value='0' >
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>缩略图：</th>
                        <td><input type="file" name="art_thumb"></td>
                    </tr>
                    <tr>
                        <th>开放：</th>
                        <td>
                            <label for=""><input type="radio" name="art_open" value="1" checked="checked" >是</label>
                            <label for=""><input type="radio" name="art_open" value="0" >否</label>
                        </td>
                    </tr>
                  
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="art_discription"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>详细内容：</th>
                        <td>
                            <textarea class="lg" id="editor" name="art_content" style="width:860px;height:500px;" ></textarea>
                            <p>标题可以写30个字</p>
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
    <script>
        var ue = UE.getEditor('editor');
    </script>
    <style>
    .edui-default{line-height: 28px;}
    div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
    {overflow: hidden; height:20px;}
    div.edui-box{overflow: hidden; height:22px;}
</style>
@endsection