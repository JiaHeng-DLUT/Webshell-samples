@extends('admin.layouts.base')

@section('content')
    <style>
        .layui-col-md3{
            padding-left: 10px
        }
        .layui-col-md3 .layui-input-block{
            margin-left: 30px;
            line-height: 2;
            margin-bottom: 10px;
        }
        #department-channel{
            border: 1px solid #eeeeee;
            margin: 20px 0 50px 0;
        }
        .layui-tab-card>.layui-tab-title .layui-this{
            background-color: #1E9FFF;
        }
        .layui-tab-title .layui-this{
            color: #ffffff;
        }
        .access-icon li{
            text-align: center;
        }
        .icon-circle{
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #00a0e9;
            display: inline-block;
            position: relative;
        }
        .icon-circle .layui-icon{
            position: absolute;
            top: 33%;
            left: 28%;
        }
        .layui-tab-content{
            padding-top: 25px;
        }
    </style>


    <div class="layui-card layui-form" id="search-form">

        <div class="layui-row">
                <div class="layui-col-md3">
                    <div  id="department-channel">
                        <div class="layui-card-header">渠道选择</div>
                        <div class="layui-form-item">
                            @if($departments->count())
                                @foreach($departments as $department)
                                    <div class="layui-input-block channel">
                                        <input type="checkbox" class="chooseAll" lay-filter="chooseAll" name="department[{{$department->id}}]" value="{{$department->id}}" lay-skin="primary" title="{{$department->name}}">
                                        <div>
                                            <div class="layui-input-block">
                                                @if($department->channel->count())
                                                    @foreach($department->channel as $channel)
                                                        @if($channel->status==1)
                                                            <input type="checkbox" class="chooseItem" lay-filter="chooseItem" name="channel[]" value="{{$channel->channel_code}}" lay-skin="primary" title="{{$channel->channel_name}}">
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
                <div class="layui-col-md9" style="padding-left: 1%">
                    <div class="layui-card-header layuiadmin-card-header-auto layui-form">

                        @include('admin.component.start-end-month')

                        <div class="layui-inline">
                            <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="search">
                                <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                            </button>
                            @can('access.page.excel')
                                <a class="layui-btn" id="excel">导出详细数据</a>
                            @endcan
                        </div>

                    </div>
                    <div class="layui-card-body">

                        <div class="layui-tab layui-tab-card" style="margin-bottom: 20px">
                            <ul class="layui-tab-title layui-row" id="menu">
                                <input type="hidden" name="slug" value="all">
                                <li class="layui-this layui-col-md3" lay-submit="" lay-filter="search" data-slug="all">总览</li>
                                <li class="layui-col-md3" lay-submit="" lay-filter="search" data-slug="home">首页</li>
                                <li class="layui-col-md3" lay-submit="" lay-filter="search" data-slug="product">贷款</li>
                                <li class="layui-col-md3" lay-submit="" lay-filter="search" data-slug="article">发现</li>
                            </ul>
                            <div class="layui-tab-content">
                                <div class="layui-tab-item layui-show">
                                    <ul class="layui-row access-icon">
                                        <li class="layui-col-md4">
                                            <div class="icon-circle" style="background-color: #393D49">
                                                <i class="layui-icon layui-icon-ok" style="font-size: 30px; color: #ffffff;"></i>
                                            </div>
                                            <div class="doc-icon-name"><strong>激活量</strong></div>
                                            <div class="act"><strong>&nbsp;</strong></div>
                                        </li>
                                        <li class="layui-col-md4">
                                            <div class="icon-circle" style="background-color: #01AAED">
                                                <i class="layui-icon layui-icon-read" style="font-size: 30px; color: #ffffff;"></i>
                                            </div>
                                            <div class="doc-icon-name"><strong>浏览次数(PV)</strong></div>
                                            <div class="pv"><strong></strong></div>
                                        </li>
                                        <li class="layui-col-md4">
                                            <div class="icon-circle" style="background-color: #5FB878">
                                                <i class="layui-icon layui-icon-username" style="font-size: 30px; color: #ffffff;"></i>
                                            </div>
                                            <div class="doc-icon-name"><strong>独立访客(UV)</strong></div>
                                            <div class="uv"><strong></strong></div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="layui-tab-item">
                                    <ul class="layui-row access-icon">
                                        <li class="layui-col-md4">
                                            <div class="icon-circle" style="background-color: #01AAED">
                                                <i class="layui-icon layui-icon-read" style="font-size: 30px; color: #ffffff;"></i>
                                            </div>
                                            <div class="doc-icon-name"><strong>浏览次数(PV)</strong></div>
                                            <div class="pv"><strong>&nbsp;</strong></div>
                                        </li>
                                        <li class="layui-col-md4">
                                            <div class="icon-circle" style="background-color: #5FB878">
                                                <i class="layui-icon layui-icon-username" style="font-size: 30px; color: #ffffff;"></i>
                                            </div>
                                            <div class="doc-icon-name"><strong>独立访客(UV)</strong></div>
                                            <div class="uv"><strong></strong></div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="layui-tab-item">
                                    <ul class="layui-row access-icon">
                                        <li class="layui-col-md4">
                                            <div class="icon-circle" style="background-color: #01AAED">
                                                <i class="layui-icon layui-icon-read" style="font-size: 30px; color: #ffffff;"></i>
                                            </div>
                                            <div class="doc-icon-name"><strong>浏览次数(PV)</strong></div>
                                            <div class="pv"><strong>&nbsp;</strong></div>
                                        </li>
                                        <li class="layui-col-md4">
                                            <div class="icon-circle" style="background-color: #5FB878">
                                                <i class="layui-icon layui-icon-username" style="font-size: 30px; color: #ffffff;"></i>
                                            </div>
                                            <div class="doc-icon-name"><strong>独立访客(UV)</strong></div>
                                            <div class="uv"><strong></strong></div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="layui-tab-item">
                                    <ul class="layui-row access-icon">
                                        <li class="layui-col-md4">
                                            <div class="icon-circle" style="background-color: #01AAED">
                                                <i class="layui-icon layui-icon-read" style="font-size: 30px; color: #ffffff;"></i>
                                            </div>
                                            <div class="doc-icon-name"><strong>浏览次数(PV)</strong></div>
                                            <div class="pv"><strong>&nbsp;</strong></div>
                                        </li>
                                        <li class="layui-col-md4">
                                            <div class="icon-circle" style="background-color: #5FB878">
                                                <i class="layui-icon layui-icon-username" style="font-size: 30px; color: #ffffff;"></i>
                                            </div>
                                            <div class="doc-icon-name"><strong>独立访客(UV)</strong></div>
                                            <div class="uv"><strong></strong></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div>
                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                                <legend>图形报表</legend>
                            </fieldset>
                            <div id="chart" style="width: 100%;height: 400px"></div>
                        </div>

                        <div>
                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                                <legend>详细报表</legend>
                            </fieldset>
                            <table id="dataTable" lay-filter="dataTable"></table>
                        </div>

                    </div>
                </div>
            </div>

    </div>


@endsection

@section('script')
    <script>
        layui.use(['layer','table','form','echarts','echartsTheme','laydate'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            var laydate=layui.laydate;
            var echarts=layui.echarts;
            var echartsTheme=layui.echartsTheme;



            //统计表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,url: "{{ route('admin.access.app.data') }}" //数据接口
                ,page: true //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    {field: 'today', title: '日期'}
                    ,{field: 'act', title: '激活数'}
                    ,{field: 'pv', title: '浏览次数(PV)'}
                    ,{field: 'uv', title: '独立访客(UV)'}
                ]]
                ,done: function(res, curr, count){
                    var sum=res.sum;
                    $('.act').find('strong').html(sum.act);
                    $('.pv').find('strong').html(sum.pv);
                    $('.uv').find('strong').html(sum.uv);
                    if(res.slug!=='all'){
                        $(".layui-table-box").find("[data-field='act']").css("display","none");
                    }
                    setChart(res.chart,res.slug);
                }
            });



            function setChart(chart,slug) {
                var x=chart.x;
                var y=chart.y;
                var legendArr=['激活量','浏览次数(PV)','独立访客(UV)'];
                var seriesArr=[
                    {
                        name:'激活量',
                        type:'line',
                        data:y.act,
                        itemStyle : {
                            normal : {
                                color:'#393D49',
                                lineStyle:{
                                    color:'#393D49'
                                }
                            }
                        },
                    },
                    {
                        name:'浏览次数(PV)',
                        type:'line',
                        data:y.pv,
                        itemStyle : {
                            normal : {
                                color:'#01AAED',
                                lineStyle:{
                                    color:'#01AAED'
                                }
                            }
                        },

                    },
                    {
                        name:'独立访客(UV)',
                        type:'line',
                        data:y.uv,
                        itemStyle : {
                            normal : {
                                color:'#5FB878',
                                lineStyle:{
                                    color:'#5FB878'
                                }
                            }
                        },
                    }
                ];
                if(slug!=='all'){
                    legendArr.splice(0,1);
                    seriesArr.splice(0,1);
                }
                var option = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data:legendArr
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    toolbox: {
                        feature: {
                            saveAsImage: {}
                        }
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: x
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series:seriesArr
                };

                var myChart = echarts.init(document.getElementById('chart'),echartsTheme);
                myChart.setOption(option);
            }
            
            //全选
            form.on('checkbox(chooseAll)', function(data){
                var child = $(data.elem).closest('div').find('.chooseItem');
                child.each(function(index, item){
                    item.checked = data.elem.checked;
                });
                form.render('checkbox');
            });
            form.on('checkbox(chooseItem)',function(data){
                var sib = $(data.elem).closest('div').find('input[type="checkbox"]:checked').length;
                var total = $(data.elem).closest('div').find('input[type="checkbox"]').length;
                if(sib === total){
                    $(data.elem).closest('.channel').find('.chooseAll').prop("checked",true);
                    form.render();
                }else{
                    $(data.elem).closest('.channel').find('.chooseAll').prop("checked",false);
                    form.render();
                }
            });



            var start=laydate.render({
                elem: '#start'
                ,type: 'date'
                ,max: "{{\Carbon\Carbon::now()->toDateString()}}"
                ,done: function (value, dates) {
                    // end.config.min = {
                    //     year: dates.year,
                    //     month: dates.month - 1, //关键
                    //     date: dates.date,
                    //     hours: 0,
                    //     minutes: 0,
                    //     seconds: 0
                    // };
                }
            });
            var end=laydate.render({
                elem: '#end'
                ,max: "{{\Carbon\Carbon::now()->toDateString()}}"
                ,done: function (value, dates) {
                    // start.config.max = {
                    //     year: dates.year,
                    //     month: dates.month - 1,//关键
                    //     date: dates.date,
                    //     hours: 0,
                    //     minutes: 0,
                    //     seconds: 0
                    // }
                }
            });

            form.render();



            $('#menu').find('li').on('click',function () {
                $('input[name="slug"]').val($(this).data('slug'));
            });

            //监听搜索
            form.on('submit(search)', function(data){
                var field = data.field;
                var start=field.start;
                var end=field.end;
                if(!start){
                    layer.msg('请选择开始时间');return false;
                }
                if(!end){
                    layer.msg('请选择结束时间');return false;
                }

                var start_date=new Date(field.start);
                var end_date=new Date(field.end);
                if(start_date > end_date){
                    layer.msg('开始时间不能比结束时间大');return false;
                }

                var slug=field.slug;
                var channel=[];
                $('.chooseItem:checked').each(function () {
                     channel.push($(this).val());
                });
                localStorage.setItem('channel',channel);
                //执行重载
                table.reload('dataTable', {
                    where: {
                        start:start,
                        end:end,
                        slug:slug,
                        channel:localStorage.getItem('channel')
                    }
                    ,page:{
                        curr:1
                    }
                });
            });


            //excel
            $("#excel").click(function () {
                var start=$('input[name="start"]').val();
                var end=$('input[name="end"]').val();
                var slug=$('input[name="slug"]').val();
                if(!start){
                    layer.msg('请选择开始时间');return false;
                }
                if(!end){
                    layer.msg('请选择结束时间');return false;
                }
                var channel=[];
                $('.chooseItem:checked').each(function () {
                    channel.push($(this).val());
                });
                localStorage.setItem('channel',channel);
                var channel=localStorage.getItem('channel');
                var param_str="?start="+start+"&end="+end+"&slug="+slug+"&channel="+channel;
                window.location.href="{{ route('admin.access.app.excel') }}"+param_str;
            });



        })
    </script>
@endsection