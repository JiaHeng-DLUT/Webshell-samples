@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">
            <div class="layui-row">查看详情</div>
{{--            <a class="layui-btn layui-btn-sm" id="returnParent" pid="0" href="{{ route('admin.access.channel') }}">返回上级</a>--}}
            {{--<a class="layui-btn layui-btn-sm" id="returnParent" pid="0" href="javascript:history.back()">返回上级</a>--}}
        </div>
        <div class="layui-card-body">

            {{--<div class="layui-row" style="margin-bottom: 10px">--}}
                {{--<div class="layui-col-md2">--}}
                    {{--当前条件合计 :--}}
                {{--</div>--}}
                {{--<div class="layui-col-md2">--}}
                    {{--<label for="">PV : <srtong id="pv">10</srtong></label>--}}
                {{--</div>--}}
                {{--<div class="layui-col-md2">--}}
                    {{--<label for="">UV : <srtong id="uv">10</srtong></label>--}}
                {{--</div>--}}
                {{--<div class="layui-col-md2">--}}
                    {{--<label for="">激活数 : <srtong id="act">10</srtong></label>--}}
                {{--</div>--}}
                {{--<div class="layui-col-md2">--}}
                    {{--<label for="">注册数 : <srtong id="reg">10</srtong></label>--}}
                {{--</div>--}}
                {{--<div class="layui-col-md2">--}}
                    {{--<label for="">总申请 : <srtong id="apply">10</srtong></label>--}}
                {{--</div>--}}
            {{--</div>--}}

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
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            var laydate=layui.laydate;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,url: "{{ route('admin.access.channel.showData') }}?{!! http_build_query($params) !!}" //数据接口
                ,page: false //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    {field: 'channel_name', title: '渠道名称'}
                    ,{field: 'platform', title: '平台'}
                    ,{field: 'page_name', title: '分发页'}
                    ,{field: 'pv', title: 'PV',sort:true}
                    ,{field: 'uv', title: 'UV',sort:true}
                    ,{field: 'act', title: '激活数',sort:true}
                    ,{field: 'reg', title: '总注册',sort:true}
                    ,{field: 'apply', title: '总申请',sort:true}
                ]]
                ,done: function(res, curr, count){
                    // var total=res.total;
                    // $('#pv').html(total.pv);
                    // $('#uv').html(total.uv);
                    // $('#act').html(total.act);
                    // $('#reg').html(total.reg);
                    // $('#apply').html(total.apply);
                }
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


        })
    </script>
@endsection