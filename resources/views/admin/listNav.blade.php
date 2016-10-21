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
                    <a href="{{url('admin/nav/create')}}"><i class="fa fa-plus"></i>新增导航 </a>
                    <a href="{{url('admin/nav')}}"><i class="fa fa-refresh"></i>更新排序</a>
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
                        <th>导航名称</th>
                        <th>导航英文名</th>
                        <th>导航地址</th>
                        <th>导航用户</th>
                        <th>导航用户密码</th>
                        <th>导航描述</th>
                        <th>操作</th>
                    </tr>
                    @foreach($navs as $nav)
                    <tr>
                        <td class="tc">{{$nav->nav_id}}</td>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$nav->nav_id}})" value="{{$nav->nav_order}}">
                        </td>
                        <td>{{$nav->html}}{{$nav->nav_name}}</td>
                        <td>{{$nav->nav_alias}}</td>
                        <td><a href="{{$nav->nav_url}}">{{$nav->nav_url}}</a></td>
                        <td>{{$nav->nav_user}}</td>
                        <td>{{$nav->nav_password}}</td>
                        <td>{{$nav->nav_description}}</td>
                        <td>
                            <a href="{{url('admin/nav/'.$nav->nav_id.'/edit')}}">修改</a>
                            <a href="javascript:void(0);" onclick="deleteNav({{$nav->nav_id}})" >删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(obj,nav_id){
            nav_order=$(obj).val();
            $.post("{{url('admin/nav/order')}}",{'_token':'{{csrf_token()}}','nav_order':nav_order,'nav_id':nav_id},function(data){
                if(data['status']==0){
                    layer.msg(data['msg'],{icon:6});
                }else{
                    layer.msg(data['msg'],{icon:5});
                }

            });
        }

        function deleteNav(nav_id){
            layer.confirm('您确定要删除吗？', {
                  btn: ['确定','取消'] //按钮
                }, function(){
                  $.post("{{url('admin/nav')}}"+"/"+nav_id,{'_token':'{{csrf_token()}}','_method':'delete'},function(data){
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
