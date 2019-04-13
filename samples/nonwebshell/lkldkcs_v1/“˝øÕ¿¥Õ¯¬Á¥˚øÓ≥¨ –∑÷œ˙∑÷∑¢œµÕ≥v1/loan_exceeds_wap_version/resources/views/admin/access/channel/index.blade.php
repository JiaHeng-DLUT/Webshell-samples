@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">

            <form class="layui-form-item" id="search-form">
                <div class="layui-inline">
                    <label class="layui-form-label">时间区间</label>
                    <div class="layui-input-block">
                        <div class="layui-input-inline">
                            <input type="text" name="start" placeholder="开始时间" autocomplete="off" class="layui-input" id="start">
                        </div>
                        <div class="layui-form-mid">至</div>
                        <div class="layui-input-inline">
                            <input type="text" name="end" placeholder="结束时间" autocomplete="off" class="layui-input" id="end">
                        </div>
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label">申请时间</label>
                    <div class="layui-input-block">
                        <div class="layui-input-inline">
                            <input type="text" name="apply_start" placeholder="开始时间" autocomplete="off" class="layui-input" id="apply_start">
                        </div>
                        <div class="layui-form-mid">至</div>
                        <div class="layui-input-inline">
                            <input type="text" name="apply_end" placeholder="结束时间" autocomplete="off" class="layui-input" id="apply_end">
                        </div>
                    </div>
                </div>

                @include('admin.component.department-channel')
                @include('admin.component.channel-manager')

                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>

                <div>
                    <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-sm" id="this-month" lay-submit="" lay-filter="this-month">查看本月</a>
                        <a class="layui-btn layui-btn-sm" id="last-month" lay-submit="" lay-filter="last-month">查看上月</a>
                        @can('access.channel.excel')
                            <a class="layui-btn layui-btn-sm" id="excel">导出</a>
                        @endcan
                        @can('access.channel.excelChildren')
                            <a class="layui-btn layui-btn-sm" id="excelChildren">导出全部下钻</a>
                        @endcan
                    </div>
                </div>

            </form>

        </div>
        <div class="layui-card-body">

            <div class="layui-row" style="margin-bottom: 10px">
                <div class="layui-col-md2">
                    当前条件合计 :
                </div>
                <div class="layui-col-md2">
                    <label for="">PV : <srtong id="pv"></srtong></label>
                </div>
                <div class="layui-col-md2">
                    <label for="">UV : <srtong id="uv"></srtong></label>
                </div>
                <div class="layui-col-md2">
                    <label for="">激活数 : <srtong id="act"></srtong></label>
                </div>
                <div class="layui-col-md2">
                    <label for="">注册数 : <srtong id="reg"></srtong></label>
                </div>
                <div class="layui-col-md2">
                    <label for="">总申请 : <srtong id="apply"></srtong></label>
                </div>
            </div>

            <table id="dataTable" lay-filter="dataTable"></table>

            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('access.channel.show')
                        <a class="layui-btn layui-btn-sm" lay-event="show">详情</a>
                    @endcan

                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.component.department-channel-js')
    <script>
        layui.use(['layer','table','form','laydate'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            var laydate=layui.laydate;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,url: "{{ route('admin.access.channel.data') }}" //数据接口
                ,page: true //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    {field: 'channel_name', title: '渠道名称'}
                    ,{field: 'channel_code', title: '渠道码',sort:true}
                    ,{field: 'manager', title: '渠道负责人'}
                    ,{field: 'pv', title: 'PV',sort:true}
                    ,{field: 'uv', title: 'UV',sort:true}
                    ,{field: 'act', title: '激活数',sort:true}
                    ,{field: 'reg', title: '总注册',sort:true}
                    ,{field: 'apply', title: '总申请',sort:true}
                    ,{title:'操作',width: 150, toolbar: '#options'}
                ]]
                ,done: function(res, curr, count){
                    var total=res.total;
                    $('#pv').html(total.pv);
                    $('#uv').html(total.uv);
                    $('#act').html(total.act);
                    $('#reg').html(total.reg);
                    $('#apply').html(total.apply);
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

            var apply_start=laydate.render({
                elem: '#apply_start'
                ,type: 'date'
                ,max: "{{\Carbon\Carbon::now()->toDateString()}}"
                ,done: function (value, dates) {
                    // apply_end.config.min = {
                    //     year: dates.year,
                    //     month: dates.month - 1, //关键
                    //     date: dates.date,
                    //     hours: 0,
                    //     minutes: 0,
                    //     seconds: 0
                    // };
                }
            });
            var apply_end=laydate.render({
                elem: '#apply_end'
                ,type: 'date'
                ,max: "{{\Carbon\Carbon::now()->toDateString()}}"
                ,done: function (value, dates) {
                    // apply_start.config.min = {
                    //     year: dates.year,
                    //     month: dates.month - 1, //关键
                    //     date: dates.date,
                    //     hours: 0,
                    //     minutes: 0,
                    //     seconds: 0
                    // };
                }
            });

            form.render();




            //监听搜索
            form.on('submit(search)', function(data){
                var field = data.field;
                var start=new Date(field.start);
                var end=new Date(field.end);
                var apply_start=new Date(field.apply_start);
                var apply_end=new Date(field.apply_end);
                if(start > end){
                    layer.msg('开始时间不能比结束时间大');return false;
                }
                if(apply_start > apply_end){
                    layer.msg('申请开始时间不能比申请结束时间大');return false;
                }

                //执行重载
                table.reload('dataTable', {
                    where: field
                    ,page:{
                        curr:1
                    }
                });
                return false;
            });


            //查看本月
            $('#this-month').on('click',function () {
                $('input[name="start"]').val("{{\Carbon\Carbon::now()->firstOfMonth()->toDateString()}}");
                $('input[name="end"]').val("{{\Carbon\Carbon::now()->lastOfMonth()->toDateString()}}");

            });

            form.on('submit(this-month)', function(data){

                var field = data.field;
                //执行重载
                table.reload('dataTable', {
                    where: field
                    ,page:{
                        curr:1
                    }
                });
                return false;
            });

            //查看上月
            $('#last-month').on('click',function () {
                $('input[name="start"]').val("{{\Carbon\Carbon::now()->subMonth()->startOfMonth()->toDateString()}}");
                $('input[name="end"]').val("{{\Carbon\Carbon::now()->subMonth()->endOfMonth()->toDateString()}}");

            });
            form.on('submit(last-month)', function(data){

                var field = data.field;
                //执行重载
                table.reload('dataTable', {
                    where: field
                    ,page:{
                        curr:1
                    }
                });
                return false;
            });





            localStorage.setItem('field','id');
            localStorage.setItem('order','asc');

            //监听排序事件
            table.on('sort(dataTable)', function(obj){
                table.reload('dataTable', {
                    initSort: obj
                    ,where: {
                        field: obj.field //排序字段
                        ,order: obj.type //排序方式
                    }
                });
                localStorage.setItem('field',obj.field);
                localStorage.setItem('order',obj.type);
            });


            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){

                }else if(layEvent==='show'){
                    // location.href = '/admin/access/channel/show?id='+data.id+'&'+$('#search-form').serialize();
                    var url = '/admin/access/channel/show?id='+data.id+'&'+$('#search-form').serialize();
                    top.layui.index.openTabsPage(url,'综合统计详情-'+data.channel_code);
                }else {

                }
            });

            //excel
            $("#excel").click(function () {
                var params=$('#search-form').serialize();
                var field=localStorage.getItem('field');
                var order=localStorage.getItem('order');
                window.location.href="{{ route('admin.access.channel.excel') }}"+"?"+params+"&field="+field+"&order="+order;
            });

            //excel导出全部下钻
            $("#excelChildren").click(function () {
                var params=$('#search-form').serialize();
                var field=localStorage.getItem('field');
                var order=localStorage.getItem('order');
                window.location.href="{{ route('admin.access.channel.excelChildren') }}"+"?"+params+"&field="+field+"&order="+order;
            });



        })
    </script>
@endsection