<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>贷贷狐官网</title>
    <!-- 重置css -->
    <link rel="stylesheet" href="{{asset('pc/css/common/reset.css')}}">
    <!-- 公共css -->
    <link rel="stylesheet" href="{{asset('pc/css/common/common.css')}}">
    <!-- 当前css -->
    <link rel="stylesheet" href="{{asset('pc/css/index.css')}}">
    <link rel="stylesheet" href="{{asset('pc/css/tool/numberRun.css')}}">
    <link rel="stylesheet" href="{{asset('pc/css/tool/swiper.css')}}">
    @yield('css')
    <!-- 工具js -->
    <script src="{{asset('pc/js/tool/jquery-3.3.1.min.js')}}"></script>
</head>

<body>
<!-- 顶部导航 -->
<section class="topNav bgff">
    <div class="wrap">
        <div class="top-logo pcub">
            <div class="pcub pcub-ac tx-r ">
                <a href="">
                    <img class="logo-img mr40" src="{{asset('pc/images/logo.png')}}" alt="">
                </a>
                <a class="logo-nav-li pointer _h100 fz16 plr10 mr40 active" href="{{url('/').'/'.$city}}">首页</a>
                <a class="logo-nav-li pointer _h100 fz16 plr10 mr40" href="./topspeed.html">极速贷款</a>
                <a class="logo-nav-li pointer _h100 fz16 plr10 mr40" href="./card.html">信用卡</a>
                <a class="logo-nav-li pointer _h100 fz16 plr10 mr40" href="./find.html">发现</a>
                <a class="logo-nav-li pointer _h100 fz16 plr10 " href="./aboutUs.html">关于我们</a>
            </div>
            <div class="pcub pcub-ac pcub-pe pcub-f1">
                <img src="{{asset('pc/images//location.png')}}" alt="">
                <span>&nbsp;&nbsp;{{session('city_name')}}&nbsp;&nbsp;</span>
                <a href='{{url("cityList")}}' class="c-a">[切换]</a>
                <span class="mlr20">|</span>
                <img src="{{asset('pc/images//phone.png')}}" alt="">

                <a href="javascript:;"><span class="tel">15680529067</span></a>
                <span class="mlr20">|</span>
                <a href="{{url('login')}}">登录/注册</a>
            </div>
        </div>
    </div>
</section>

@yield('content')


<!-- 客服 -->
<section class="service white">
    <img src="{{asset('pc/images/icon-对话框.png')}}" alt="">
    &emsp;
    当前专业客服人员在线
</section>
<!-- 对话框 -->
<section id="talk" style="display:none">
    <div class="top white">
        <div class="left">
            <img src="{{asset('pc/images/头像-对话框.png')}}" alt="">
            <span>贷贷狐</span>
        </div>
        <div class="right">
            <img src="{{asset('pc/images/声音-对话框.png')}}" alt="">
            <img src="{{asset('pc/images/缩小-对话框.png')}}" alt="">
        </div>
    </div>
    <div class="main">
        <p>加载历史消息</p>
    </div>
</section>
<!-- 页脚 -->
<footer>
    <div>
        <ul class="clear">
            <li>
                <p><a href="###">新手帮助</a></p>
                <p><a href="###">关于我们</a></p>
                <p><a href="###">商务合作</a></p>
            </li>
            <li>
                <p>贷贷狐app</p>
                <div class="code"> <img src="{{asset('pc/images/二维码-app.png')}}" alt=""></div>
            </li>
            <li>
                <p>扫一扫，关注我们</p>
                <div class="code"><img src="{{asset('pc/images/二维码-公众号.png')}}" alt=""></div>
            </li>
            <li>
                <h2>联系电话：028-86783282</h2>
                <p>服务时间：周一至周五 9:00~18:00</p>
                <span class="icon flex-alc mb20">
                <img src="{{asset('pc/images/icon-QQ.png')}}" alt="" class="mr20">
                <img src="{{asset('pc/images/icon-新浪.png')}}" alt="">
              </span>
                <p>公司地址：成都市锦江区人民东路6号 SAC航空广场7楼</p>
            </li>
        </ul>
        <div class="text">
            西安乾政互联网金融服务有限公司 陕ICP备18014447号 Copyright © 2017~2019 贷贷狐 All Rights Reserved
        </div>
    </div>
</footer>

<script src="{{asset('pc/js/tool/numberRun.js')}}"></script>
<script src="{{asset('pc/js/tool/swiper.js')}}"></script>
<script src="{{asset('pc/js/index.js')}}"></script>
<script>
    window._token="{{csrf_token()}}";
</script>
@yield('js')
</body>

</html>