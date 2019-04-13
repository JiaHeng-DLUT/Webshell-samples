@extends('admin.layouts.base')

@section('content')
    @php
        $endDate=\Carbon\Carbon::now()->toDateString();
    @endphp
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">

            <form class="layui-form-item" id="search-form">

                <div class="layui-inline">
                    <label class="layui-form-label">时间区间</label>
                    <div class="layui-input-block">
                        <div class="layui-input-inline">
                            <input type="text" name="start" placeholder="开始时间" autocomplete="off" class="layui-input" id="start" value="{{\Carbon\Carbon::parse('-1 month')->toDateString()}}">
                        </div>
                        <div class="layui-form-mid">至</div>
                        <div class="layui-input-inline">
                            <input type="text" name="end" placeholder="结束时间" autocomplete="off" class="layui-input" id="end" value="{{$endDate}}">
                        </div>
                    </div>
                </div>

                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>

            </form>

        </div>
        <div class="layui-card-body">
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
            var start_date=$('input[name="start"]').val();
            var end_date=$('input[name="end"]').val();
            var dataTable = table.render({
                elem: '#dataTable'
                ,url: "{{ route('admin.access.reg.dayChannelData') }}" //数据接口
                ,page: true //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    ,{field: 'today', title: '日期'}
                    ,{field: 'reg', title: '注册数'}
                ]]
                ,done: function(res, curr, count){
                }
                ,where:{
                    start:start_date,
                    end:end_date
                }
            });

            var start=laydate.render({
                elem: '#start'
                ,type: 'date'
                ,max: "{{$endDate}}"
                ,done: function (value, dates) {
                    end.config.min = {
                        year: dates.year,
                        month: dates.month - 1, //关键
                        date: dates.date,
                        hours: 0,
                        minutes: 0,
                        seconds: 0
                    };
                }
            });
            var end=laydate.render({
                elem: '#end'
                ,max: "{{$endDate}}"
                ,done: function (value, dates) {
                    start.config.max = {
                        year: dates.year,
                        month: dates.month - 1,//关键
                        date: dates.date,
                        hours: 0,
                        minutes: 0,
                        seconds: 0
                    }
                }
            });

            form.render();

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

                //执行重载
                table.reload('dataTable', {
                    where: field
                    ,page:{
                        curr:1
                    }
                });
                return false;
            });

        })
    </script>
@endsection