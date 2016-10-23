@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>&raquo; 配置列表
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
    <form action="{{url('admin/conf/confUpdate')}}" method="post">
    {{csrf_field()}}
        <div class="result_wrap" >
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/conf/create')}}"><i class="fa fa-plus"></i>新增配置</a>
                    <a href="{{url('admin/conf')}}"><i class="fa fa-refresh"></i>更新排序</a>
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
                        <th>配置名称</th>
                        <th>配置标题</th>
                        <th>说明</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($confs as $conf)
                    <tr>
                        <td class="tc">{{$conf->conf_id}}</td>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$conf->conf_id}})" value="{{$conf->conf_order}}">
                        </td>
                        <td>{{$conf->conf_name}}</td>
                        <td>{{$conf->conf_title}}</td>
                        <td>{{$conf->conf_tips}}</td>
                        <td>{!!$conf->conf_content!!}</td>
                        <td>
                            <a href="{{url('admin/conf/'.$conf->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:void(0);" onclick="deleteconf({{$conf->conf_id}})" >删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div style="height: 5px;" ></div>
                <input type="submit" value="提交">
                <input type="button" class="back" onclick="history.go(-1)" value="返回">
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(obj,conf_id){
            conf_order=$(obj).val();
            $.post("{{url('admin/conf/order')}}",{'_token':'{{csrf_token()}}','conf_order':conf_order,'conf_id':conf_id},function(data){
                if(data['status']==0){
                    layer.msg(data['msg'],{icon:6});
                }else{
                    layer.msg(data['msg'],{icon:5});
                }

            });
        }

        function deleteconf(conf_id){
            layer.confirm('您确定要删除吗？', {
                  btn: ['确定','取消'] //按钮
                }, function(){
                  $.post("{{url('admin/conf')}}"+"/"+conf_id,{'_token':'{{csrf_token()}}','_method':'delete'},function(data){
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
