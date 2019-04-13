@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">
            <form class="layui-form-item" id="search-form">

                @include('admin.component.start-end')
                @include('admin.component.department-channel')

                <div class="layui-inline">
                    <label class="layui-form-label">标记类型</label>
                    <div class="layui-input-block">
                        <select name="mark" id="mark">
                            <option value="">不限</option>
                            <option value="1">D</option>
                            <option value="0">E</option>
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
                        @can('access.deduct.excel')
                            <a class="layui-btn layui-btn-sm" id="toExcel">导 出</a>
                        @endcan
                    </div>
                </div>

            </form>



            {{--<div class="layui-btn-group ">


                <button class="layui-btn layui-btn-sm" id="toExcel">导 出</button>
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>/
            </div>
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" placeholder="开始时间" name="start_time" id="start_time" autocomplete="off">
                </div>
                <div class="layui-form-mid layui-word-aux" style="float:none;display: inline;margin-right: 0">-</div>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" placeholder="结束时间" name="end_time" id="end_time" autocomplete="off">
                </div>
                @include('admin.common._department_get_channel')
            </div>--}}
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">


                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>

            <script type="text/html" id="category">





            </script>

        </div>
    </div>
@endsection

@section('script')
    {{--@can('admin.website.article')--}}
        {{--@include('admin.common._js_department_get_channel')--}}
        @include('admin.component.department-channel-js')
        <script>
            layui.use(['layer','table','form','laydate'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                var laydate = layui.laydate;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    // ,height: 500
                    ,url: "{{ route('admin.access.deduct.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'channel_name', title: '注册渠道名称',templet:function (d) {
                                if(d.channel){
                                    return d.channel.channel_name
                                }else{
                                    return "没找到相关渠道"
                                }
                            }}
                        ,{field: 'phone', title: '用户电话'}
                        ,{field: 'created_at', title: '注册时间'}
                        ,{field: 'reduce_rate', title: '数值',templet:function (d) {
                                if(d.reduce_type == 'register'){
                                    return d.reduce_rate
                                }else{
                                    return ''
                                }
                            }}
                        // ,{field: 'reduce_rate', title: '正常申请注册比',templet:function (d) {
                        //         if(d.reduce_type == 'apply_register'){
                        //             return d.reduce_rate
                        //         }else{
                        //             return ''
                        //         }
                        //     }}
                        ,{field: 'status', title: '标记',templet:function (d) {
                                if(d.status){
                                    return 'D'
                                }else{
                                    return 'E'
                                }
                            }}
                        // ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                    ]]
                });


                //导出
                $("#toExcel").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }
                    var start_time = $("#start_time").val();
                    var end_time = $("#end_time").val();
                    var channel_code = $("#channel_code").val();
                    var u = '{{ route('admin.access.deduct.excel') }}';
                    u = u+'?start_time='+start_time+'&end_time='+end_time+'&channel_code='+channel_code+'&ids='+ids;
                    window.location.href=u;
                })


                //监听搜索
                form.on('submit(search)', function(data){
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

               /* //搜索
                $("#search").click(function () {

                    var start_time = $("#start_time").val();
                    var end_time = $("#end_time").val();
                    var channel_code = $("#channel_code").val();
                    dataTable.reload({
                        where:{channel_code:channel_code,start_time:start_time,end_time:end_time},
                        page:{curr:1}
                    })
                });*/

                laydate.render({
                    elem: '#start' //指定元素
                    ,type: 'date'
                });
                laydate.render({
                    elem: '#end' //指定元素
                    ,type: 'date'
                });
            });

        </script>
    {{--@endcan--}}
@endsection