@extends('pc.layout.pc')
@section('content')
    <body>
    <!-- 头部 -->
    <script src="./pc/js/common/topNav.js"></script>
    <section>
        <div id="main">
            <div class="tx-c">
                <h2 class="title pt70">热门产品推荐</h2>
                <p class="engText mb50">PRODUCTS RECOMMENDED</p>
            </div>
            <ul class="list flex-c">
                @foreach($hot_products as $hot_product)
                <li>
                    <img src="./pc/images/贷乐多2-1.png" alt="">
                    <div class="text">
                        <p class="pro-name">{{$hot_product->name}}</p>
                        <p>为贷款服务而生</p>
                    </div>
                </li>
                    @endforeach
            </ul>
            <!-- 筛选 -->
            <ul class="screen bgff clear mt60">
                <li>
                    <div class="screenList">
                        <span class="cate mr70">贷款额度：</span>
                        <label>不限</label>
                        <input type="checkbox" name="100-2000元" id="">
                        <label>100-2000元</label>
                        <input type="checkbox" name="2000-10000元" id="">
                        <label>2000-10000元</label>
                        <input type="checkbox" name="10000元以上" id="">
                        <label>10000元以上</label>
                    </div>
                </li>
                <li>
                    <div class="screenList">
                        <span class="cate mr70">贷款额度：</span>
                        <label>不限</label>
                        <input type="checkbox" name="100-2000元" id="">
                        <label>100-2000元</label>
                        <input type="checkbox" name="2000-10000元" id="">
                        <label>2000-10000元</label>
                        <input type="checkbox" name="10000元以上" id="">
                        <label>10000元以上</label>
                    </div>
                </li>
                <li>
                    <div class="screenList">
                        <span class="cate mr70">贷款额度：</span>
                        <label>不限</label>
                        <input type="checkbox" name="100-2000元" id="">
                        <label>100-2000元</label>
                        <input type="checkbox" name="2000-10000元" id="">
                        <label>2000-10000元</label>
                        <input type="checkbox" name="10000元以上" id="">
                        <label>10000元以上</label>
                    </div>
                </li>
            </ul>
            <!-- 条件 -->
            <ul class="term bgff mt10 mb30 flex-alc">
                <li>
                    <span>100-2000元</span>
                    <img src="./pc/images/叉.png" alt="">
                </li>
                <li>
                    <span>手机号</span>
                    <img src="./pc/images/叉.png" alt="">
                </li>
                <li>
                    <span>14天以上</span>
                    <img src="./pc/images/叉.png" alt="">
                </li>
                <li>
                    清除筛选条件
                </li>
            </ul>
            <!-- 产品 -->
            <div class="bgff">
                <!-- 表头 -->
                <div class="protuct_top">
                    <div class="bor_b flex-sb">
                        <h3>符合您要求的产品</h3>
                        <div>
                            <span>默认排序</span>
                            <span>成功率</span>
                            <span>放款速度</span>
                            <span>放款额度</span>
                        </div>
                    </div>
                </div>
                <!-- 产品列表 -->
                <div id="product">
                    <table class="mt30">
                        <thead>
                        <tr>
                            <th>产品名称</th>
                            <th>贷款额度</th>
                            <th>产品描述</th>
                            <th>标签</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="hover-f7">
                            <td>
                                <img src="./pc/images/product1.png" alt="">
                                <span class="proName"> 小狐钱包</span>
                            </td>
                            <td class="proCost">1000-1600元</td>
                            <td>
                                <p>年前大放水，无视黑白，来就放！</p>
                            </td>
                            <td>
                                <p>低利率；身份证贷</p>
                            </td>
                            <td>
                                <a href="./loanDetail.html">
                                    <button class="lookBtn">查看详情</button>
                                </a>
                            </td>
                        </tr>
                        <tr class="hover-f7">
                            <td>
                                <img src="./pc/images/product1.png" alt="">
                                <span class="proName"> 小狐钱包</span>
                            </td>
                            <td class="proCost">1000-1600元</td>
                            <td>
                                <p>年前大放水，无视黑白，来就放！</p>
                            </td>
                            <td>
                                <p>低利率；身份证贷</p>
                            </td>
                            <td>
                                <a href="./loanDetail.html">
                                    <button class="lookBtn">查看详情</button>
                                </a>
                            </td>
                        </tr>
                        <tr class="hover-f7">
                            <td>
                                <img src="./pc/images/product1.png" alt="">
                                <span class="proName"> 小狐钱包</span>
                            </td>
                            <td class="proCost">1000-1600元</td>
                            <td>
                                <p>年前大放水，无视黑白，来就放！</p>
                            </td>
                            <td>
                                <p>低利率；身份证贷</p>
                            </td>
                            <td>
                                <a href="./loanDetail.html">
                                    <button class="lookBtn">查看详情</button>
                                </a>
                            </td>
                        </tr>
                        <tr class="hover-f7">
                            <td>
                                <img src="./pc/images/product1.png" alt="">
                                <span class="proName"> 小狐钱包</span>
                            </td>
                            <td class="proCost">1000-1600元</td>
                            <td>
                                <p>年前大放水，无视黑白，来就放！</p>
                            </td>
                            <td>
                                <p>低利率；身份证贷</p>
                            </td>
                            <td>
                                <a href="./loanDetail.html">
                                    <button class="lookBtn">查看详情</button>
                                </a>
                            </td>
                        </tr>
                        <tr class="hover-f7">
                            <td>
                                <img src="./pc/images/product1.png" alt="">
                                <span class="proName"> 小狐钱包</span>
                            </td>
                            <td class="proCost">1000-1600元</td>
                            <td>
                                <p>年前大放水，无视黑白，来就放！</p>
                            </td>
                            <td>
                                <p>低利率；身份证贷</p>
                            </td>
                            <td>
                                <a href="./loanDetail.html">
                                    <button class="lookBtn">查看详情</button>
                                </a>
                            </td>
                        </tr>
                        <tr class="hover-f7">
                            <td>
                                <img src="./pc/images/product1.png" alt="">
                                <span class="proName"> 小狐钱包</span>
                            </td>
                            <td class="proCost">1000-1600元</td>
                            <td>
                                <p>年前大放水，无视黑白，来就放！</p>
                            </td>
                            <td>
                                <p>低利率；身份证贷</p>
                            </td>
                            <td>
                                <a href="./loanDetail.html">
                                    <button class="lookBtn">查看详情</button>
                                </a>
                            </td>
                        </tr>
                        <tr class="hover-f7">
                            <td>
                                <img src="./pc/images/product1.png" alt="">
                                <span class="proName"> 小狐钱包</span>
                            </td>
                            <td class="proCost">1000-1600元</td>
                            <td>
                                <p>年前大放水，无视黑白，来就放！</p>
                            </td>
                            <td>
                                <p>低利率；身份证贷</p>
                            </td>
                            <td>
                                <a href="./loanDetail.html">
                                    <button class="lookBtn">查看详情</button>
                                </a>
                            </td>
                        </tr>
                        <tr class="hover-f7">
                            <td>
                                <img src="./pc/images/product1.png" alt="">
                                <span class="proName"> 小狐钱包</span>
                            </td>
                            <td class="proCost">1000-1600元</td>
                            <td>
                                <p>年前大放水，无视黑白，来就放！</p>
                            </td>
                            <td>
                                <p>低利率；身份证贷</p>
                            </td>
                            <td>
                                <a href="./loanDetail.html">
                                    <button class="lookBtn">查看详情</button>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--翻页-->
                    <div class="zxf_pagediv mt10 pb30"></div>
                </div>
            </div>

            <div class="priorityPic">
                <img src="./pc/images/底部banner.png" alt="">
            </div>
        </div>
    </section>
    <!-- 页脚 -->
    <script src="./js/common/footer.js"></script>
    <!-- 翻页 -->
    <script src="./js/tool/page.js"></script>
    <script type="text/javascript">
        //翻页
        $(".zxf_pagediv").createPage({
            pageNum: 20,
            current: 6,
            backfun: function (e) {
                //console.log(e);//回调
            }
        });
    </script>
    </body>
    @endsection