@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">

            <form class="layui-form-item" id="search-form">

                @include('admin.component.start-end')

                <div class="layui-inline">
                    <label class="layui-form-label">产品名称</label>
                    <div class="layui-input-block">
                        <div class="layui-input-inline">
                            <input type="text" name="name" placeholder="请输入产品名称" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label">产品状态</label>
                    <div class="layui-input-block">
                        <select name="status" id="status">
                            <option value="">不限</option>
                            <option value="1">上架中</option>
                            <option value="0">下架中</option>
                        </select>
                    </div>
                </div>

                @include('admin.component.department-channel')
                @include('admin.component.platform')

                <div class="layui-inline">
                    <label class="layui-form-label">产品类型</label>
                    <div class="layui-input-block">
                        <select name="product_type" id="product_type">
                            <option value="product">贷款产品</option>
                            <option value="credit">信用卡</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>

                <div>
                    <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-sm" id="this-month" lay-submit="" lay-filter="this-month">查看本月</a>
                        <a class="layui-btn layui-btn-sm" id="last-month" lay-submit="" lay-filter="last-month">查看上月</a>
                        @can('access.product.excel')
                            <a class="layui-btn layui-btn-sm" id="excel">导出</a>
                        @endcan
                    </div>
                </div>

            </form>

        </div>
        <div class="layui-card-body">

            <div class="layui-row" style="margin-bottom: 10px">
                <div class="layui-col-md1">
                    当前条件合计 :
                </div>
                <div class="layui-col-md11">
                    <div class="layui-row">
                        <div class="layui-col-md2">
                            <label for="">PV : <srtong id="pv"></srtong></label>
                        </div>
                        <div class="layui-col-md2">
                            <label for="">UV : <srtong id="uv"></srtong></label>
                        </div>
                        <div class="layui-col-md2">
                            <label for="">注册数 : <srtong id="reg"></srtong></label>
                        </div>
                        <div class="layui-col-md2">
                            <label for="">注册数转化率 : <srtong id="reg_rate"></srtong></label>
                        </div>
                        <div class="layui-col-md2">
                            <label for="">申请数 : <srtong id="apply"></srtong></label>
                        </div>
                        <div class="layui-col-md2">
                            <label for="">申请转化率 : <srtong id="apply_rate"></srtong></label>
                        </div>
                    </div>
                </div>


            </div>

            <table id="dataTable" lay-filter="dataTable"></table>

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
                ,url: "{{ route('admin.access.product.data') }}" //数据接口
                ,page: true //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    {field: 'name', title: '产品名称'}
                    ,{title: '产品类型',templet:function (d) {
                            var type=$('#product_type').val();
                            return type==='product'?'贷款产品':'信用卡';
                        }}
                    ,{field: 'status', title: '产品状态',templet:function (d) {
                            return d.status===1?'上架中':'下架中';
                    }}
                    ,{field: 'pv', title: 'PV',sort:true}
                    ,{field: 'uv', title: 'UV',sort:true}
                    ,{field: 'reg', title: '注册数',sort:true}
                    ,{field: 'reg_rate', title: '注册数转化率',sort:true,templet:function (d) {
                        return d.reg_rate+'%';
                    }}
                    ,{field: 'apply', title: '申请数',sort:true}
                    ,{field: 'apply_rate', title: '申请率',sort:true,templet:function (d) {
                        return d.apply_rate+'%';
                    }}
                ]]
                ,done: function(res, curr, count){
                    var total=res.total;
                    $('#pv').html(total.pv);
                    $('#uv').html(total.uv);
                    $('#reg').html(total.reg);
                    $('#reg_rate').html(total.reg_rate);
                    $('#apply').html(total.apply);
                    $('#apply_rate').html(total.apply_rate);
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

            //监听搜索
            form.on('submit(search)', function(data){
                var field = data.field;
                var start=new Date(field.start);
                var end=new Date(field.end);
                if(start > end){
                    layer.msg('开始时间不能比结束时间大');return false;
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
                    location.href = '/admin/access/channel/show?id='+data.id+'&'+$('#search-form').serialize();
                }else {

                }
            });

            //excel
            $("#excel").click(function () {
                var params=$('#search-form').serialize();
                var field=localStorage.getItem('field');
                var order=localStorage.getItem('order');
                window.location.href="{{ route('admin.access.product.excel') }}"+"?"+params+"&field="+field+"&order="+order;
            });



        })
    </script>
@endsection