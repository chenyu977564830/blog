<!doctype html>
<head>
<meta charset="utf-8">
<link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
<link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">

<script type="text/javascript" src="{{asset('resources/views/admin/style/js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/org/layer/layer.js')}}"></script>


@yield('css')
<!--[if lt IE 9]>
<script src="{{asset('resources/views/home/js/modernizr.js')}}"></script>
<![endif]-->
</head>
<body>
<header>
  <div id="logo"><a href="/"></a></div>
  <nav class="topnav" id="topnav">
  @foreach($navs as $nav)
  <a href="{{$nav->nav_url}}"><span>{{$nav->nav_name}}</span><span class="en">{{$nav->nav_alias}}</span></a>
  @endforeach
  </nav>
</header>

@yield('content')
 <div class="news">
    
    <h3>
      <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
      @foreach($art_news as $v)
      <li><a href="{{url('art')}}/{{$v->art_id}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
      @endforeach
    </ul>
   
    <h3 class="ph">
      <p>点击<span style="color:red;" >排行</span></p>
   </h3>
    <ul class="paih">
    @foreach($art_recommends as $v)
      <li><a href="{{url('art')}}/{{$v->art_id}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
      @endforeach
    </ul>

     <h3 class="ph">
      <p>项目<span>展示</span></p>
    </h3>
    <ul class="paih">
      @foreach($links_my as $v)
      <li class='mp' >
        <a href="{{$v->link_url}}" title="{{$v->link_title}}" target="_blank">{{$v->link_name}}</a>
        <div style="display: none;" >{{$v->link_description}}</div>
      </li>
      @endforeach
    </ul>
   
    <h3 class="links">
      <p>友情<span>链接</span></p>
    </h3>
    <ul class="website">
      @foreach($links as $v)
      <li><a href="{{$v->link_url}}" title="{{$v->link_title}}" target="_blank">{{$v->link_name}}</a></li>
      @endforeach
    </ul> 
    </div>
    <div>
      <div>关注微信公众号 寻找<span style="color:green"><b>失踪人口</b></span></div>
      <img src="{{$weixin_image}}" style="max-width:200px;max-height: 200px" />
    </div>  
    <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script> 
    <script type="text/javascript" id="bdshell_js"></script> 
    <script type="text/javascript">
      document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
      //项目介绍
      $('.mp').mouseover(function(){
        var content=$(this).find('div').eq(0).text();
        //alert(content);
        layer.tips(content, $(this), {
          tips: [1, '#3595CC'],
          time: 10000
        });
      });
    </script> 
    <!-- Baidu Button END -->   
    </aside>
</article>
<footer>
    <p>Design by 后盾网 <a href="http://www.miitbeian.gov.cn/" target="_blank">http://www.houdunwang.com</a> <a href="/">网站统计</a></p>
</footer>
</body>
</html>
