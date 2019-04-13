@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div>
                我的短信余额：{{ $number }}条
            </div>
            <div class="layui-btn-group">
                <a class="layui-btn layui-btn-sm" href="http://sms.kouhaobang.com/member/login">充值</a>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-sm" lay-event="edit">修 改</a>
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;

            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                // ,height: 500
                ,url: "{{ route('admin.sysmsg.recharge.data') }}" //数据接口
//                ,page: true //开启分页
                ,cols: [[ //表头
                    {field: 'order_no', title: '订单号'}
                    ,{field: 'type', title: '套餐名称',templet:function (d) {
                        if(d.charge){
                            return d.charge.name;
                        }else{
                            return ''
                        }
                    }}
                    ,{field: 'money', title: '金额',templet:function (d) {
                        if(d.charge){
                            return d.charge.money;
                        }else{
                            return ''
                        }
                    }}
                    ,{field: 'number', title: '短信条数',templet:function (d) {
                        if(d.charge){
                            return d.charge.number;
                        }else{
                            return ''
                        }
                    }}
                    ,{field: 'status', title: '订单状态',templet:function (d) {
                        if(d.status == 2){
                            return '已完成';
                        }else{
                            return '未完成'
                        }
                    }}
                    ,{field: 'created_at', title: '充值时间'}
                ]]
            });
        })
    </script>
@endsection