@extends('layouts.home')
@section('css') 
<title>{{$article_detal->art_title}}</title>
<meta name="keywords" content="{{$article_detal->art_tag}}" />
<meta name="description" content="{{$article_detal->art_description}}" />
<link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">
@endsection
@section('content')
<article class="blogs">
  <h1 class="t_nav">
    <span>您当前的位置：
      <a href="{{url('/')}}">首页</a>
      @foreach($cates as $v)
      &nbsp;&gt;&nbsp;<a href="{{url('cate')}}/{{$v->cate_id}}">{{$v->cate_name}}</a>
      @endforeach
    </span>
    <a href="{{url('/')}}" class="n1">网站首页</a>
    <a href="{{url('cate')}}/{{$article_detal->cate_id}}" class="n2">{{$article_detal->cate_name}}</a>
  </h1>
  <div class="index_about">
    <h2 class="c_titile">{{$article_detal->art_title}}</h2>
    <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d H:i:s',$article_detal->art_time)}}</span><span>编辑：{{$article_detal->art_editor}}</span><span>查看次数:{{$article_detal->art_view}}</span></p>
    <ul class="infos">
     {!!$article_detal->art_content!!}
    </ul>
    <div class="keybq">
    <p><span>关键字词</span>:{{$article_detal->art_tag}}</p>
    
    </div>
    <div class="ad"> </div>
    <div class="nextinfo">
      @if($art_pre)
      <p>上一篇：<a href="{{url('art')}}/{{$art_pre->art_id}}">{{$art_pre->art_title}}</a></p>
      @endif
      @if($art_next)
      <p>下一篇：<a href="{{url('art')}}/{{$art_next->art_id}}">{{$art_next->art_title}}</a></p>
      @endif
    </div>
    <div class="otherlink">
      <h2>相关文章</h2>
      <ul>
        @foreach($art_releatives as $v)
        <li><a href="{{url('art')}}/{{$v->art_id}}" title="{{$v->art_title}}">{{$v->art_title}}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
  <aside class="right">
    <div class="blank"></div> 
@endsection