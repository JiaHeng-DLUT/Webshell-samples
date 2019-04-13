<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
    <!-- 重置css -->
    <link rel="stylesheet" href="{{asset('pc/css/common/reset.css')}}">
    <!-- 公共css -->
    <link rel="stylesheet" href="{{asset('pc/css/common/common.css')}}">
</head>

<body>
<!-- 顶部导航 -->
<section class="topNav bgff">
    <div class="wrap">
        <div class="top-logo pcub">
            <div class="pcub pcub-ac tx-r ">
                <a href="{{url('/').'/'.session('city_pinyin')}}">
                    <img class="logo-img mr40" src="{{asset('pc/images/logo.png')}}" alt="">
                </a>
                <a class="logo-nav-li pointer _h100 fz16 plr10 mr40 active bold" href="./index.html">用户登录</a>
            </div>
            <div class="pcub pcub-ac pcub-pe pcub-f1">
                <span class="c-ac mr10">今日借款</span>
                <p class="c-2f75ec lesp2 bold mr20 fz16">{{$count['today']}}人</p>
                <span class="c-ac mr10">累计借款</span>
                <p class="c-2f75ec lesp2 bold mr20 fz16">{{$count['all']}}人</p>
                <span class="mr20 c-ac">|</span>
                <img src="{{asset('pc/images//phone.png')}}" alt="">
                <a href="javascript:;"><span class="tel">15680529067</span></a>
            </div>
        </div>
    </div>
</section>
<div class="loginBg flex-c">
    <!-- 登录框 -->
    <div class="login_box bgff mr68">
        <div class="title flex-sp">
            <div>
                <h2 class="active">手机动态码登录</h2>
                <p class="login_box_line"></p>
            </div>
            <div>
                <h2>手机密码登录</h2>
                <p class="login_box_line none"></p>
            </div>
        </div>

        <form action="">
            {{csrf_field()}}
            <div class="form_group mb24">
                <p class="input_text">手机号</p>
                <input type="tel" class="form_name" id="inputName" name="phone" placeholder="请输入手机号">
                <img src="{{asset('pc/images/手机号.png')}}" alt="" class="input_icon">
            </div>
            <div class="mb24">
                <p class="input_text">图形验证码</p>
                <div class="flex-sp">
                    <input type="text" name="captcha" class="form_input" id="inputVerify" maxlength="4" placeholder="请输入图形验证码">
                    <div class="form_pic_code">
                        <img src="/getCaptcha" onclick="this.src='/getCaptcha?'+Math.random()" style="cursor: pointer;">
                    </div>
                </div>
            </div>
            <div class="mb30">
                <p class="input_text">短信验证码</p>
                <div class="flex-sp">
                    <input type="tel" name="verifyCode" class="form_input" id="inputVerify" maxlength="6" placeholder="请输入短信验证码">
                    <div class="form_pic_code tx-c" id="getVerifyCode">免费获取验证码</div>
                </div>
            </div>
            <button type="submit" class="loginBtn">登录</button>
        </form>
        <p class="to_register tx-c">
            我还没有账户，去<a href="" class="c-2f75ec">免费注册</a>
        </p>
    </div>
    <!--  -->
    <div class="code_box flex-ffai">
        <h2>贷贷狐</h2>
        <p class="line"></p>
        <p class="fz18 white mt60">一站式线上贷款服务智能平台</p>
        <div class="code mt50">
            <img src="{{asset('pc/images/二维码-app.png')}}" alt="">
        </div>
        <p class="white">扫一扫下载APP</p>
    </div>
</div>
@include('pc.layout.footer')
<script src="{{asset('pc/js/tool/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('pc/js/common/login.js')}}"></script>
<script>
    window._token="{{csrf_token()}}";
</script>
</body>

</html>