@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>&raquo; 分类列表
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
    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap" >
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/link/create')}}"><i class="fa fa-plus"></i>新增链接</a>
                    <a href="{{url('admin/link')}}"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>排序</th>
                        <th>链接名称</th>
                        <th>链接标题</th>
                        <th>链接说明</th>
                        <th>后台用户名</th>
                        <th>后台密码</th>
                        <th>个人项目</th>
                        <th>操作</th>
                    </tr>
                    @foreach($links as $link)
                    <tr>
                        <td class="tc">{{$link->link_id}}</td>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$link->link_id}})" value="{{$link->link_order}}">
                        </td>
                        <td><a href="{{$link->link_url}}">{{$link->link_name}}</a></td>
                        <td>{{$link->link_title}}</td>
                        <td>{{$link->link_description}}</td>
                        <td>{{$link->link_user}}</td>
                        <td>{{$link->link_password}}</td>
                         <td class="tc"  style="cursor: pointer; " >@if($link->link_myproject==1)<img src="{{url('resources/image/y.png')}}" >@else <img src="{{url('resources/image/x.png')}}" > @endif</td>

                        
                        <td>
                            <a href="{{url('admin/link/'.$link->link_id.'/edit')}}">修改</a>
                            <a href="javascript:void(0);" onclick="deletelink({{$link->link_id}})" >删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(obj,link_id){
            link_order=$(obj).val();
            $.post("{{url('admin/link/order')}}",{'_token':'{{csrf_token()}}','link_order':link_order,'link_id':link_id},function(data){
                if(data['status']==0){
                    layer.msg(data['msg'],{icon:6});
                }else{
                    layer.msg(data['msg'],{icon:5});
                }

            });
        }

        function deleteLink(link_id){
            layer.confirm('您确定要删除吗？', {
                  btn: ['确定','取消'] //按钮
                }, function(){
                  $.post("{{url('admin/link')}}"+"/"+link_id,{'_token':'{{csrf_token()}}','_method':'delete'},function(data){
                        if(data['status']==0){
                            window.location.reload();
                            layer.msg(data['msg'],{icon:6});
                        }else{
                            layer.msg(data['msg'],{icon:5});
                        }
                });
              });
        }
    </script>
@endsection
