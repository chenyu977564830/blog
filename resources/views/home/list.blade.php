@extends('layouts.home')
@section('css')
<title></title>
<meta name="keywords" content="{{$cate_detal->cate_keywords}}" />
<meta name="description" content="{{$cate_detal->cate_description}}" />
<link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
@endsection
@section('content')
<article class="blogs">
<h1 class="t_nav">
  <span>{{$cate_detal->cate_description}}</span>
  <a href="{{url('/')}}" class="n1">网站首页</a><a href="/" class="n2">{{$cate_detal->cate_name}}</a></h1>
<div class="newblog left">
  @foreach($articleList as $v)
  <h2>{{$v->art_title}}</h2>
  <p class="dateview" style="margin:10px 0 0 -10px;" ><span style="margin:0 10px 0 10px;" >发布时间：{{date('Y-m-d H:i:s',$v->art_time)}}</span><span>作者：{{$v->art_editor}}</span><span>分类：[<a href="{{url('cate')}}/{{$v->art_id}}">{{$v->cate_name}}</a>]</span></p>
    <figure><img src="@if($v->art_thumb){{$v->art_thumb}} @else {{$default_image}} @endif "></figure>
    <ul class="nlist">
      <p>{{$v->art_description}}</p>
      <a title="{{$v->art_title}}" href="{{url('art')}}/{{$v->art_id}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <div class="line"></div>
  @endforeach
    <div class="blank"></div>
    <div class="ad">  
    <img src="{{$ad_image}}">
    </div>
    <div class="page">
    {!!$articleList->links()!!}
    </div>
</div>
<aside class="right">
   <div class="rnav">
      <ul>
      @foreach($cate_childs as $k => $v)
       <li class="rnav{{$k+1}}"><a href="{{url('cate')}}/{{$v->cate_id}}" target="_blank">{{$v->cate_name}}</a></li>
      @endforeach     
     </ul>      
    </div>
@endsection