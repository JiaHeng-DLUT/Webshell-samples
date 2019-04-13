@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">

            <form class="layui-form-item" id="search-form">

                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 100px">最后登陆时间</label>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input" placeholder="开始时间" name="start" id="start" autocomplete="off">
                    </div>
                    <div class="layui-form-mid">至</div>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input" placeholder="结束时间" name="end" id="end" autocomplete="off">
                    </div>
                </div>

                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="warn-search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </form>

        </div>
        <div class="layui-card-body">

            <div class="layui-btn-group layui-inline" style="padding-bottom: 10px">
                {{--@can('warn.phoneCreate')--}}
                    <a class="layui-btn layui-btn-sm" id="phoneCreate">添加手机号</a>
                {{--@endcan--}}
                {{--@can('warn.excel')--}}
                    <a class="layui-btn layui-btn-normal layui-btn-sm" id="excel">导 出</a>
                {{--@endcan--}}
            </div>

            <table id="dataTable" lay-filter="dataTable"></table>

        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form','laydate','jquery'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            var laydate = layui.laydate;
            var $=layui.jquery;


            laydate.render({
                elem: '#start' //指定元素
                ,type: 'datetime'
            });
            laydate.render({
                elem: '#end' //指定元素
                ,type: 'datetime'
            });

            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,url: "{{ route('admin.warn.data') }}" //数据接口
                ,page: true //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    // {checkbox: true,fixed: true}
                    {field: 'phone', title: '用户电话'}
                    ,{field: 'deviceid_register', title: '注册设备码'}
                    ,{field: 'deviceid_login', title: '登录设备码'}
                    ,{field: 'ip', title: 'IP'}
                    ,{field: 'channel_code', title: '渠道码'}
                    ,{field: 'platform', title: '来源平台'}
                    ,{field:'department_name',title: '所属部门'}
                    ,{field:'manager',title: '渠道负责人'}
                    ,{field: 'updated_at', title: '最后登陆时间'}
                ]]
            });


            //监听搜索
            form.on('submit(warn-search)', function(data){
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




            //excel
            $("#excel").click(function () {
                var params=$('#search-form').serialize();
                window.location.href="{{ route('admin.warn.excel') }}?"+params;
            })

            //添加手机号
            $('#phoneCreate').on('click',function () {
                layer.open({
                    type: 2,
                    title: '添加短信接收号码',
                    maxmin: true,
                    shadeClose: true, //点击遮罩关闭层
                    area : ['900px' , '520px'],
                    content: "{{route('admin.warn.phoneCreate')}}",
                    success:function(){

                    },
                    end:function () {
                    }
                });
            })

        })
    </script>
@endsection