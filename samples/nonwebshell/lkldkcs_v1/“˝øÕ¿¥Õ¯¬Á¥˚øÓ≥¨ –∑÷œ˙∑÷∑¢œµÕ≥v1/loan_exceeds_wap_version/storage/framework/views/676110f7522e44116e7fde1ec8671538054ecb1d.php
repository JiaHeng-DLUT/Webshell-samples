<?php $__env->startSection('content'); ?>
    <div class="layui-row layui-col-space15">

        <div class="layui-col-md8">

            <div class="layui-row layui-col-space15">

                <div class="layui-col-md6">

                    <div class="layui-card">

                        <div class="layui-card-header">订单</div>

                        <div class="layui-card-body">
                            <div class="layui-carousel layadmin-carousel layadmin-backlog">

                                <div carousel-item>

                                    <ul class="layui-row layui-col-space10">

                                        <li class="layui-col-xs6">

                                            <a lay-href="javascript:;" class="layadmin-backlog-body">

                                                <h3>待接单</h3>

                                                <p><cite>66</cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a lay-href="javascript:;" class="layadmin-backlog-body">

                                                <h3>执行中</h3>

                                                <p><cite>12</cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a lay-href="javascript:;" class="layadmin-backlog-body">

                                                <h3>已完成</h3>

                                                <p><cite>99</cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a href="javascript:;"  class="layadmin-backlog-body">

                                                <h3>已流失</h3>

                                                <p><cite>20</cite></p>

                                            </a>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="layui-col-md6">

                    <div class="layui-card">

                        <div class="layui-card-header">产品</div>

                        <div class="layui-card-body">



                            <div class="layui-carousel layadmin-carousel layadmin-backlog">

                                <div carousel-item>

                                    <ul class="layui-row layui-col-space10">

                                        <li class="layui-col-xs6">

                                            <a lay-href="javascript:;" class="layadmin-backlog-body">

                                                <h3>待审核</h3>

                                                <p><cite>66</cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a lay-href="javascript:;" class="layadmin-backlog-body">

                                                <h3>现金产品</h3>

                                                <p><cite>12</cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a lay-href="javascript:;" class="layadmin-backlog-body">

                                                <h3>住贷产品</h3>

                                                <p><cite>99</cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a href="javascript:;"  class="layadmin-backlog-body">

                                                <h3>云资源</h3>

                                                <p><cite>20</cite></p>

                                            </a>

                                        </li>

                                    </ul>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="layui-col-md12">

                    <div class="layui-card">

                        <div class="layui-card-header">数据概览</div>

                        <div class="layui-card-body">
                            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-dataview">

                                <div carousel-item id="LAY-index-dataview">

                                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="layui-col-md4">

            <div class="layui-card">

                <div class="layui-card-header">版本信息</div>

                <div class="layui-card-body layui-text">

                    <table class="layui-table">

                        <colgroup>

                            <col width="100">

                            <col>

                        </colgroup>

                        <tbody>

                        <tr>

                            <td>当前版本</td>

                            <td>

                                <script type="text/html" template>
                                    v4.0
                                </script>

                            </td>

                        </tr>

                        <tr>

                            <td>主要特色</td>

                            <td>  大气 / 清爽 / 极简</td>

                        </tr>
                        <tr>

                            <td>主要版本</td>

                            <td>媒体 / 贷超 / 分销</td>

                        </tr>
                        <tr>

                            <td>官方网站</td>

                            <td style="padding-bottom: 0;">

                                <div class="layui-btn-container">

                                    <a href="http://www.zongshitang.com" target="_blank" class="layui-btn layui-btn-danger">官方网站</a>

                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="layui-card">
                <div class="layui-card-header">
                    用户
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">周</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">9,999,666</p>
                    <p>
                        总计用户
                        <span class="layuiadmin-span-color">88万 <i class="layui-inline layui-icon layui-icon-flag"></i></span>
                    </p>
                </div>
            </div>
            <div class="layui-card">
                <div class="layui-card-header">
                    收入
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">周</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">9,999,666</p>
                    <p>
                        总计收入
                        <span class="layuiadmin-span-color">88万 <i class="layui-inline layui-icon layui-icon-flag"></i></span>
                    </p>
                </div>
            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        layui.use(['index', 'console']);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>