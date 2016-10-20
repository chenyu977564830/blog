@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 文章列表
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="{{url('admin/article/search')}}" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select id="cate">
                            <option value="">全部</option>
                            @foreach($cates as $cate)
                            <option value="{{$cate->cate_id}}" @if($cate_id==$cate->cate_id) selected="selected" @endif >{{$cate->html}}{{$cate->cate_name}}</option>
                            @endforeach
                        </select>
                        <script>
                            $('#cate').change(function(){
                                window.location.href="{{url('admin/cate')}}"+'/'+$(this).val()+'/null';
                            });
                        </script>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" id="keywords" placeholder="文章标题"></td>
                    <td><input type="button" id="sub" value="查询"></td>
                    <script>
                        $('#sub').click(function(){
                            window.location.href="{{url('admin/cate')}}"+'/'+$("#cate option:selected").val()+'/'+$("#keywords").val();
                        });
                    </script>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="javascript:void(0);" id='delMuch'  ><i class="fa fa-recycle"></i>批量删除</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    
                    <tr>
                        <th class="tc" width="5%"><input type="checkbox" id="checked"></th>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>文章分类</th>
                        <th>缩略图</th>
                        <th>关键词</th>
                        <th class="tc" >开放</th>
                        <th class="tc" >推荐</th>
                        <th>点击量</th>
                        <th>发布人</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($articleList as $v)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id" value="{{$v->art_id}}"></td>
                        <td class="tc">{{$v->art_id}}</td>
                        <td>
                            <a href="#">{{$v->art_title}}</a>
                        </td>
                        <td>{{$v->cate_name}}</td>
                        <td>@if($v->art_thumb)<img src="{{$v->art_thumb}}" style="max-width: 350px;max-height: 100px;" />@endif</td>
                        <td>{{$v->art_tag}}</td>
                        <td class="tc"  style="cursor: pointer; " >@if($v->art_open==1)<img src="{{url('resources/image/y.png')}}">@else<img src="{{url('resources/image/x.png')}}" > @endif</td>
                        <td class="tc"  style="cursor: pointer; " >@if($v->art_recommend==1)<img src="{{url('resources/image/y.png')}}" >@else <img src="{{url('resources/image/x.png')}}" > @endif</td>
                        <td>{{$v->art_view}}</td>
                        <td>{{$v->art_editor? $v->art_editor : '佚名'}}</td>
                        <td>{{date('Y-m-d H-i-s',$v->art_time)}}</td>
                        <td>
                            <a href="{{url('admin/article/'.$v->art_id.'/edit')}}">修改</a>
                            <a href="javascript:void(0);" onclick="deleteArt({{$v->art_id}})" >删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>

    


                <div class="page_list">
                    {!! $articleList->links() !!}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <style>
        .result_content ul li {
            padding: 6px 12px;
        }
    </style>
    <script>
        function deleteArt(art_id){
            layer.confirm('您确定要删除吗？', {
                  btn: ['确定','取消'] //按钮
                }, function(){
                  $.post("{{url('admin/article')}}"+"/"+art_id,{'_token':'{{csrf_token()}}','_method':'delete'},function(data){
                        if(data['status']==0){
                            window.location.reload();
                            layer.msg(data['msg'],{icon:6});
                        }else{
                            layer.msg(data['msg'],{icon:5});
                        }
                });
              });
        }

        $("#delMuch").click(function(){
            var checkboxs=new Array();
            $('input[name="id"]:checked').each(function(){ 
                    checkboxs.push($(this).val()); 
            });
            layer.confirm('您确定要删除吗？', {
                  btn: ['确定','取消'] //按钮
                }, function(){
                  $.post("{{url('admin/article/delMuch')}}",{'_token':'{{csrf_token()}}',art_ids:checkboxs},function(data){
                        if(data['status']==0){
                            window.location.reload();
                        }else{
                            layer.msg(data['msg'],{icon:5});
                        }
                });
              }); 
            
        });

    </script>
@endsection