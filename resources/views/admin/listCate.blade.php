@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>&raquo; 分类列表
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap" style="display: none;" >
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap" >
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-refresh"></i>更新排序</a>
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
                        <th>分类名称</th>
                        <th>分类标题</th>
                        <th>点击量</th>
                        <th>关键词</th>
                        <th>分类描述</th>
                        <th>操作</th>
                    </tr>
                    @foreach($cates as $cate)
                    <tr>
                        <td class="tc">{{$cate->cate_id}}</td>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$cate->cate_id}})" value="{{$cate->cate_order}}">
                        </td>
                        <td>{{$cate->html}}{{$cate->cate_name}}</td>
                        <td>{{$cate->cate_title}}</td>
                        <td>{{$cate->cate_view}}</td>
                        <td>{{$cate->cate_keywords}}</td>
                        <td>{{$cate->cate_description}}</td>
                        <td>
                            <a href="{{url('admin/category/'.$cate->cate_id.'/edit')}}">修改</a>
                            <a href="javascript:void(0);" onclick="deleteCate({{$cate->cate_id}})" >删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(obj,cate_id){
            cate_order=$(obj).val();
            $.post("{{url('admin/order')}}",{'_token':'{{csrf_token()}}','cate_order':cate_order,'cate_id':cate_id},function(data){
                if(data['status']==0){
                    layer.msg(data['msg'],{icon:6});
                }else{
                    layer.msg(data['msg'],{icon:5});
                }

            });
        }

        function deleteCate(cate_id){
            layer.confirm('您确定要删除吗？', {
                  btn: ['确定','取消'] //按钮
                }, function(){
                  $.post("{{url('admin/category')}}"+"/"+cate_id,{'_token':'{{csrf_token()}}','_method':'delete'},function(data){
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
