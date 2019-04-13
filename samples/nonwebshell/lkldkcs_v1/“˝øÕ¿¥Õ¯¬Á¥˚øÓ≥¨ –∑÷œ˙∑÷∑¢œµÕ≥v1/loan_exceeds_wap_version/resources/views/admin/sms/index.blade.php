@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @if(!count($sms))
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.sysmsg.create') }}">申请开通</a>
                @endif
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
                ,url: "{{ route('admin.sysmsg.data') }}" //数据接口
//                ,page: true //开启分页
                ,cols: [[ //表头
                    {field: 'id', title: '编号'}
                    ,{field: 'type', title: '服务商',templet:function (d) {
                        return  '<a href="http://sms.kouhaobang.com" style="color:green;">口号帮</a>';;
                        }
                    }
                    ,{field: 'status', title: '开启状态',templet:function (d) {
                        if(d.status == 1){
                            return '启用中';
                        }else{
                            return '去配置';
                        }
                      }
                    }
                    ,{field: 'created_at', title: '开通时间'}
                    ,{fixed: 'right', title:'操作',width: 100, align:'center', toolbar: '#options'}
                ]]
            });

            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'edit'){
                    location.href = '/admin/sms/'+data.id+'/edit';
                }
            });
        })
    </script>
@endsection