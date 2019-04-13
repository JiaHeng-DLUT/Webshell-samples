@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.channel.channelReduce') }}">返 回</a>
            </div>


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
        <script>
            layui.use(['layer','table','form','laydate'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                var laydate = layui.laydate;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('admin.channel.channelReduce.reduceRecordData',['id'=>$id]) }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'before_modify', title: '变更前'}
                        ,{field: 'after_modify', title: '变更后'}
                        ,{field: '', title: '有效时间段',templet:function (d) {
                                if(d.reduce_type == 'apply_register'){
                                    if(d.effect_on !=null){
                                        return '从 '+d.effect_on+' 开始生效！'
                                    }


                                }else if(d.reduce_type == 'register'){
                                    if(d.effect_start != null && d.effect_end != null){
                                        return d.effect_start+' 到 '+d.effect_end
                                    }else{
                                        return '从 '+d.created_at+' 开始生效'
                                    }

                                }
                            }}
                        ,{field: 'updated_at', title: '修改时间'}
                        ,{field: 'modifier_name', title: '修改人'}
                        ,{field: 'mark', title: '备注'}
                        // ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                    ]]
                });


            });

        </script>
@endsection