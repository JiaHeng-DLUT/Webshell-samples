@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">
            <form class="layui-form-item" id="search-form">
                <div class="layui-inline">
                    <label class="layui-form-label">反馈时间</label>
                    <div class="layui-input-block">
                        <div class="layui-input-inline">
                            <input type="text" name="start_time" placeholder="开始时间" autocomplete="off" class="layui-input" id="start_time">
                        </div>
                        <div class="layui-form-mid">至</div>
                        <div class="layui-input-inline">
                            <input type="text" name="end_time" placeholder="结束时间" autocomplete="off" class="layui-input" id="end_time">
                        </div>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">反馈分类</label>
                    <div class="layui-input-inline">
                        <select name="channel_id" lay-verify="" id="channel_id">
                            <option value="">请选择分类</option>
                            @foreach($channels as $item)
                                <option value="{{ $item->id }}" >{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">反馈人号码</label>
                    <div class="layui-input-inline">
                        <input type="text" name="phone" id="phone" placeholder="反馈人号码" class="layui-input" >
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">回复状态</label>
                    <div class="layui-input-inline">
                        <select name="reply_status" lay-verify="" id="reply_status">
                            <option value="">回复状态</option>
                            <option value="1" >已回复</option>
                            <option value="0" >未回复</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="searchBtn">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>

            </form>
            <div>
                <div class="layui-btn-group">
                    <button class="layui-btn layui-btn-sm" id="listExport">导 出</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    {{--@can('zixun.article.edit')--}}
                    <a class="layui-btn layui-btn-sm" lay-event="edit">处理</a>
                    {{--@endcan--}}
                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>
            <script type="text/html" id="category">
                @{{ d.category.name }}
            </script>
        </div>
    </div>
@endsection

@section('script')
    {{--@can('zixun.article')--}}
    <script>
        layui.use(['layer','table','form','laydate'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            var laydate = layui.laydate;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,url: "{{ route('admin.feedback.data') }}" //数据接口
                ,page: true //开启分页
                ,limits: [50,100,200]
                ,limit: 50 //每页默认显示的数量
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
//                    ,{field: 'id', title: 'ID',width:80}
                    ,{field: 'phone', title: '反馈人'}
                    ,{field: 'created_at', title: '反馈时间'}
                    ,{field: 'category', title: '反馈分类'}
                    ,{field: 'content', title: '反馈内容'}
                    ,{field: 'status', title: '回复状态',templet: function(d){
                        if(d.status == 1){
                            return '已回复';
                        }else{
                            return '未回复';
                        }
                    }
                    }
                    ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                ]]
            });

            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("{{--{{ route('admin.article.destroy') }}--}}",{_method:'delete',ids:[data.id]},function (result) {
                            if (result.code==0){
                                obj.del(); //删除对应行（tr）的DOM结构
                            }
                            layer.close(index);
                            layer.msg(result.msg,{icon:6})
                        });
                    });
                }
                else if(layEvent === 'edit'){
                    location.href = '/admin/feedback/'+data.id+'/edit';
                }
            });
            //按钮批量删除
            $("#listDelete").click(function () {
                var ids = []
                var hasCheck = table.checkStatus('dataTable')
                var hasCheckData = hasCheck.data
                if (hasCheckData.length>0){
                    $.each(hasCheckData,function (index,element) {
                        ids.push(element.id)
                    })
                }
                if (ids.length>0){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("{{ route('admin.website.article.destroy') }}",{_method:'delete',ids:ids},function (result) {
                            if (result.code==0){
                                dataTable.reload()
                            }
                            layer.close(index);
                            layer.msg(result.msg,{icon:6})
                        });
                    })
                }else {
                    layer.msg('请选择删除项',{icon:5})
                }
            })
            //按钮批量导出
            $("#listExport").click(function () {
                var ids = []
                var hasCheck = table.checkStatus('dataTable')
                var hasCheckData = hasCheck.data
                if (hasCheckData.length>0){
                    $.each(hasCheckData,function (index,element) {
                        ids.push(element.id)
                    })
                }
                var idStr = '';
                if (ids.length>0){
                    idStr =  ids.join(",")
                }else{
                    idStr = '';
                }
                var channels_id = $("#channels_id").val()
                var reply_status = $("#reply_status").val();
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();
                var phone = $("#phone").val();
                var u = '{{ route('admin.feedback.export') }}'
                u = u+'?channels_id='+channels_id+'&reply_status='+reply_status+'&start_time='+start_time+'&end_time='+end_time+'&phone='+phone+'&ids='+idStr
                window.location.href=u;
            })

            //监听搜索
            form.on('submit(searchBtn)', function(data){
                 var field = data.field;
                console.log(data.field)
                 //执行重载
                 table.reload('dataTable', {
                  where: field
                 ,page: {
                     curr: 1 //重新从第 1 页开始
                 }
                 });
                 return false;
            });
            laydate.render({
                elem: '#start_time' //指定元素
                ,type: 'datetime'
            });
            laydate.render({
                elem: '#end_time' //指定元素
                ,type: 'datetime'
            });
        });

    </script>
    {{--@endcan--}}
@endsection