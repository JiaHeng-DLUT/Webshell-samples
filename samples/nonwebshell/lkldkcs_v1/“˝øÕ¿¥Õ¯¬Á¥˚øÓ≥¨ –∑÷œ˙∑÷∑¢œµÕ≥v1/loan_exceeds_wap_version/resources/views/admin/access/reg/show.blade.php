@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-row">渠道注册查看详情({{request('channel_code').'/'.request('today')}})</div>
            {{--<a class="layui-btn layui-btn-sm" id="returnParent" pid="0" href="javascript:history.back()">返回上级</a>--}}
        </div>
        <div class="layui-card-body">

            {{--<div class="layui-row" style="margin-bottom: 10px">--}}
                {{--<div class="layui-col-md1">--}}
                    {{--当前条件合计 :--}}
                {{--</div>--}}
                {{--<div class="layui-col-md11">--}}
                    {{--<div class="layui-row">--}}
                        {{--<div class="layui-col-md2">--}}
                            {{--<label for="">PV : <srtong id="pv"></srtong></label>--}}
                        {{--</div>--}}
                        {{--<div class="layui-col-md2">--}}
                            {{--<label for="">UV : <srtong id="uv"></srtong></label>--}}
                        {{--</div>--}}
                        {{--<div class="layui-col-md2">--}}
                            {{--<label for="">注册数 : <srtong id="reg"></srtong></label>--}}
                        {{--</div>--}}
                        {{--<div class="layui-col-md2">--}}
                            {{--<label for="">注册数转化率 : <srtong id="reg_rate"></srtong></label>--}}
                        {{--</div>--}}
                        {{--<div class="layui-col-md2">--}}
                            {{--<label for="">申请数 : <srtong id="apply"></srtong></label>--}}
                        {{--</div>--}}
                        {{--<div class="layui-col-md2">--}}
                            {{--<label for="">申请转化率 : <srtong id="apply_rate"></srtong></label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <table id="dataTable" lay-filter="dataTable"></table>

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
                ,url: "{{ route('admin.access.reg.showData') }}?channel_code={{$channel_code}}&today={{$today}}" //数据接口
                ,page: false //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    {field: 'channel_name', title: '渠道名称'}
                    ,{field: 'platform', title: '平台'}
                    ,{field: 'page_name', title: '分发页'}
                    ,{field: 'reg_real', title: 'A'}
                    ,{field: 'reg_deal', title: 'B'}
                ]]
                ,done: function(res, curr, count){

                }
            });

        })
    </script>
@endsection