@extends('pc.layout.pc')
@section('content')
    <!-- banner部分 -->
    <section class="">
        <div class="swiper-container my-swper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="./images//banner-1.png" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="./images//banner-1.png" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="./images//banner-1.png" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="./images//banner-1.png" alt="">
                </div>
            </div>
            <!-- 如果需要分页器 -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- 最新口子 -->
    <section class="wrap">
        <div class="sign-contair pcub pcub-pac pt60 pb30 bgff">
            <div style="margin-right:100px;">
                <div class="numberRun numberRun1 clear"></div>
                <p class="tx-c mt30 c-3d3d3f">今日贷款</p>
            </div>
            <div>
                <div class="numberRun numberRun2 clear"></div>
                <p class="tx-c mt30 c-3d3d3f">累计借款</p>
            </div>
        </div>
        <ul class="pcub pcub-pac mt30 bgff fz20">
            <a href="./newEntrance.html">
                <li class="tx-c lh1" style="width:320px;height:270px;">
                    <img class="mtb50" src="./images//sign_1.png" alt="">
                    <p>最新口子</p>
                    <p class="fz16 c-ac mt10">满足不同用户贷款需求</p>
                </li>
            </a>
            <li class="tx-c lh1" style="width:320px;height:270px;">
                <img class="mtb50" src="./images//sign_1.png" alt="">
                <p>最新口子</p>
                <p class="fz16 c-ac mt10">满足不同用户贷款需求</p>
            </li>
            <li class="tx-c lh1" style="width:320px;height:270px;">
                <img class="mtb50" src="./images//sign_1.png" alt="">
                <p>最新口子</p>
                <p class="fz16 c-ac mt10">满足不同用户贷款需求</p>
            </li>
            <li class="tx-c lh1" style="width:320px;height:270px;">
                <img class="mtb50" src="./images//sign_1.png" alt="">
                <p>最新口子</p>
                <p class="fz16 c-ac mt10">满足不同用户贷款需求</p>
            </li>
        </ul>
    </section>
    <!-- 极速贷款 -->
    <section class="bgff mt30">
        <div class="wrap">
            <div class="tx-c pt10 pb20">
                <h3 class="fz36 bold lh1 mt60 mb20">极速贷款</h3>
                <p class="fz30 c-d3 lh1">FAST LOAN</p>
            </div>
            <div class="w100_">
                <table class="w100_ tx-c fz20">
                    <thead>
                    <tr style="height:80px;">
                        <td style="width:6.25%">产品名称</td>
                        <td style="width:30.25%">贷款额度</td>
                        <td style="width:17.96875%">产品描述</td>
                        <td style="width:33.125%">标签</td>
                        <td style="width:12.1875%">操作</td>
                    </tr>
                    </thead>
                    <tbody class="fz14">
                    <tr class="hover-f7" style="height:120px;">
                        <td style="width:6.25%">
                            <img style="width:57px;height:57px;" src="./images//product1.png" alt="">
                            <p class="lh1 mt10">小狐钱包</p>
                        </td>
                        <td style="width:30.25%" class="c-f2752e">1000-1600元</td>
                        <td style="width:17.96875%">年前大放水，无视黑白，来就放！</td>
                        <td style="width:33.125%">低利率；身份证贷</td>
                        <td style="width:12.1875%">
                            <button class="btn">查看详情</button>
                        </td>
                    </tr>
                    <tr class="hover-f7" style="height:120px;">
                        <td style="width:6.25%">
                            <img style="width:57px;height:57px;" src="./images//product1.png" alt="">
                            <p class="lh1 mt10">小狐钱包</p>
                        </td>
                        <td style="width:30.25%" class="c-f2752e">1000-1600元</td>
                        <td style="width:17.96875%">年前大放水，无视黑白，来就放！</td>
                        <td style="width:33.125%">低利率；身份证贷</td>
                        <td style="width:12.1875%">
                            <button class="btn">查看详情</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="mt30 tx-c fz16 c-2f75ec  pb30"><span class="pointer">查看更多</span></div>
            </div>
        </div>
    </section>
    <!-- 信用卡 -->
    <section>
        <div class="wrap">
            <div class="tx-c pt10 pb20">
                <h3 class="fz36 bold lh1 mt60 mb20">信用卡</h3>
                <p class="fz30 c-d3 lh1">THE CREDIT CARD</p>
            </div>
            <ul class="pcub pcub-pac mt30 fz14 lh1">
                <a href="javascript:;">
                    <li class="mr30">
                        <div class="credit-card-hover" style="width:298px;height:168px;">
                            <img class="shadow-1" src="./images//credit-card.png" alt="">
                        </div>
                        <p class="fz16 mb10 mt20">浦发QQ音乐联名卡</p>
                        <p>周三、周六消费半价</p>
                    </li>
                </a>
                <a href="javascript:;">
                    <li class="mr30">
                        <div class="credit-card-hover" style="width:298px;height:168px;">
                            <img class="shadow-1" src="./images//credit-card.png" alt="">
                        </div>
                        <p class="fz16 mb10 mt20">浦发QQ音乐联名卡</p>
                        <p>周三、周六消费半价</p>
                    </li>
                </a>
                <a href="javascript:;">
                    <li class="mr30">
                        <div class="credit-card-hover" style="width:298px;height:168px;">
                            <img class="shadow-1" src="./images//credit-card.png" alt="">
                        </div>
                        <p class="fz16 mb10 mt20">浦发QQ音乐联名卡</p>
                        <p>周三、周六消费半价</p>
                    </li>
                </a>
                <a href="javascript:;">
                    <li>
                        <div class="credit-card-hover" style="width:298px;height:168px;">
                            <img class="shadow-1" src="./images//credit-card.png" alt="">
                        </div>
                        <p class="fz16 mb10 mt20">浦发QQ音乐联名卡</p>
                        <p>周三、周六消费半价</p>
                    </li>
                </a>
            </ul>
            <div class="mt30 tx-c fz16 c-2f75ec pb30"><span class="pointer">查看更多</span></div>
        </div>
    </section>
    <!-- 资讯中心 -->
    <section class="bgff">
        <div>
            <div class="tx-c pt10 pb20">
                <h3 class="fz36 bold lh1 mt60 mb20">资讯中心</h3>
                <p class="fz30 c-d3 lh1">NEWS CENTER</p>
            </div>
            <div class="news_center">
                <div class="pcub pcub-pac nav">
                    <button href="javascript:;" class="nav-btn mr30 active">最新推荐</button>
                    <button href="javascript:;" class="nav-btn mr30">借款攻略</button>
                    <button href="javascript:;" class="nav-btn mr30">申请专题</button>
                    <button href="javascript:;" class="nav-btn">贷款问答</button>
                </div>
                <ul class="content">
                    <li class="hover-f7 ptb30">
                        <div class="wrap pcub pcub-pac">
                            <img style="width:215px;height:130px;" src="./images//img_zixun.png" alt="">
                            <div class="pcub pcub-ver pcub-f1 ml60">
                                <h3 class="fz20 lh1 mb10">小额贷款APP是怎么泄露用户个人信息的？如何保护？</h3>
                                <p class="fz16 pcub-te2">关于小额贷款APP泄露个人信息导致用户资质受损的新闻应该都听到过，很多人不解，小额贷款APP是怎么泄露个人信息的？个人信息真的对自己这么重要吗？该怎么保护个人信息不被泄露？关于小额贷款关于小额贷款APP泄露个人信息导致用户资质受损的新闻应该都听到过，很多人不解，小额贷款APP是怎么泄露个人信息的？个人信息真的对自己这么重要吗？该怎么保护个人信息不被泄露？关于小额贷款</p>
                                <p class="fz14 lh1 mt10">2019-01-14 10001阅读</p>
                            </div>
                        </div>
                    </li>
                    <li class="hover-f7 ptb30">
                        <div class="wrap pcub pcub-pac">
                            <img style="width:215px;height:130px;" src="./images//img_zixun.png" alt="">
                            <div class="pcub pcub-ver pcub-f1 ml60">
                                <h3 class="fz20 lh1 mb10">小额贷款APP是怎么泄露用户个人信息的？如何保护？</h3>
                                <p class="fz16 pcub-te2">
                                    关于小额贷款APP泄露个人信息导致用户资质受损的新闻应该都听到过，很多人不解，小额贷款APP是怎么泄露个人信息的？个人信息真的对自己这么重要吗？该怎么保护个人信息不被泄露？关于小额贷款关于小额贷款APP泄露个人信息导致用户资质受损的新闻应该都听到过，很多人不解，小额贷款APP是怎么泄露个人信息的？个人信息真的对自己这么重要吗？该怎么保护个人信息不被泄露？关于小额贷款
                                </p>
                                <p class="fz14 lh1 mt10">2019-01-14 10001阅读</p>
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- <ul class="" style="width: 1020px; margin: 0 auto">
                    <li class="flex-sp hover-f7">
                        <div class="hot_left">
                            <img src="./images/热门攻略-图片.png" alt="">
                        </div>
                        <div class="hot_right">
                            <h3>小额贷款APP是怎么泄露用户个人信息的？如何保护？</h3>
                            <p class="hot_right_text mt20">关于小额贷款APP泄露个人信息导致用户资质受损的新闻应该都听到过，很多人
                                不解，小额贷款APP是怎么泄露个人信息的？个人信息真的对自己这么重要....</p>
                            <p class="hot_right_date">
                                <span class="mr30">2019-01-14</span><span>10001阅读</span>
                            </p>
                        </div>
                    </li>
                </ul> -->
                <div class="mt30 tx-c fz16 c-2f75ec pb30"><span class="pointer">查看更多</span></div>
            </div>
        </div>
    </section>
    <!-- 合作机构 -->
    <section>
        <div>
            <div id="cooperation">
                <h2 class="white">合作机构</h2>
                <p class="english white">COOPERATION AGENCY</p>
                <ul class="clear mt50">
                    <li><img src="./images/logo-御顺金融.png" alt=""></li>
                    <li><img src="./images/logo-款姐.png" alt=""></li>
                    <li><img src="./images/logo-马上消费金融.png" alt=""></li>
                    <li><img src="./images/logo-小赢卡贷.png" alt=""></li>
                    <li><img src="./images/logo-中国平安.png" alt=""></li>
                </ul>
            </div>
            <div class="friendSrc bgff">
                <h3>友情链接</h3>
                <p>FRIENDLY LINK</p>
                <ul>
                    <li>分期零利息</li>
                    <li>麦卡钱包</li>
                    <li>汇能金融</li>
                    <li>工行贷款利息</li>
                    <li>旗下易贷</li>
                    <li>随手记借款利息</li>
                </ul>
            </div>
        </div>
    </section>
@endsection