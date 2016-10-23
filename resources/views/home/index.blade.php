@extends('layouts.home')
@section('css')
<title>cy博客</title>
<meta name="keywords" content="say why 个人博客" />
<meta name="description" content="做你想做的" />
<link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="banner">
  <section class="box">
    <ul class="texts">
      {!!$wisdom!!}
    </ul>
    <div class="avatar"><a href="#"><span>cy</span></a> </div>
  </section>
</div>
<div class="template">
  <div class="box">
    <h3>
      <p><span>个人博客</span> 精华文章</p>
    </h3>
    <ul>
    @foreach($art_views as $v)
      <li><a href="{{url('art')}}/{{$v->art_id}}"  target="_blank"><img src="@if($v->art_thumb) $v->art_thumb @else {{$default_image}} @endif"></a><span>{{$v->art_title}}</span></li>
    @endforeach
    </ul>
  </div>
</div>
<article>
  <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
  <div class="bloglist left">
    @foreach($art_recommends as $v)
    <h3>{{$v->art_title}}</h3>
    <figure><img src="@if($v->art_thumb) $v->art_thumb @else {{$default_image}} @endif"></figure>
    <ul>
      <p>{{$v->art_description}}</p>
      <a title="{{$v->art_title}}" href="{{url('art')}}/{{$v->art_id}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <p class="dateview" style="margin:10px 0 0 -10px;"><span style="margin:0 10px 0 10px;" >{{date('Y-m-d H:i:s',$v->art_time)}}</span><span>作者：{{$v->art_editor}}</span><span>分类：[<a href="{{url('cate')}}/{{$v->cate_id}}">{{$v->cate_name}}</a>]</span></p>
    @endforeach
    <div class="page">
      {!! $art_recommends->links() !!}
    </div>
  </div>
  <aside class="right">
    <div class="weather"><iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe></div>
   
@endsection