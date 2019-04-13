@extends('admin.layouts.base')
<style>
    .layui-table-cell .layui-form-checkbox[lay-skin="primary"], .layui-table-cell .layui-form-radio[lay-skin="primary"] {
        top:5px !important;
    }

</style>
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">
            <form class="layui-form-item" id="search-form">


                <div class="layui-inline">
                    <label class="layui-form-label">用户模型</label>
                    <div class="layui-input-inline" style="width: 600px">
                        <select name="user_model_id[]" id="user_model_id" xm-select-search="" xm-select-search-type="dl" xm-select="select1" size="300">
                            @if(count($user_models))
                                <option value="">用户模型</option>
                                @foreach($user_models as $user_model)
                                    <option value="{{ $user_model->id }}" >{{ $user_model->name }}</option>
                                @endforeach

                            @endif

                        </select>
                    </div>
                </div>
                <div class="layui-inline" >
                    <label class="layui-form-label">注册渠道</label>
                    <div class="layui-input-inline">
                        <select name="app_id"  id="app_id" lay-search>
                            <option value="">注册渠道</option>
                            @if(count($channels))
                                @foreach($channels as $channel)
                                    <option value="{{ $channel->channel_code }}" >{{ $channel->channel_name }}</option>
                                @endforeach

                            @endif

                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">来源平台</label>
                    <div class="layui-input-inline">
                        <select name="platform_register"  id="platform_register">
                            <option value="">来源平台</option>
                            <option value="android">android</option>
                            <option value="ios">ios</option>
                            <option value="wap">wap</option>
                            <option value="pc">pc</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">时间区间</label>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input" placeholder="开始时间" name="start_time" id="start_time" autocomplete="off">
                    </div>
                    <div class="layui-form-mid">至</div>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input" placeholder="结束时间" name="end_time" id="end_time" autocomplete="off">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">用户电话</label>
                    <div class="layui-input-inline">
                        <input type="text" name="phone" id="phone"  placeholder="请输入用户电话" class="layui-input">
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
                    @can('admin.member.member.toExcel')
                        <button class="layui-btn layui-btn-sm" id="toExcel">导 出</button>
                    @endcan
                </div>
            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    {{--@can('zixun.member.edit')--}}
                        {{--<a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del" >删除</a>--}}
                    {{--@endcan--}}

                    <a class="layui-btn layui-btn-sm " lay-event="edit" >编辑</a>

                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>


        </div>
    </div>
@endsection
<!-- 首先引入css, 和js, 唯一依赖: jQuery -->
<link href="/static/admin/layuiadmin/layui/dist/formSelects-v4.css" rel="stylesheet" />
<script src="/static/admin/layuiadmin/layui/dist/jquery.min.js"></script>
<script src="/static/admin/layuiadmin/layui/dist/formSelects-v4.min.js"></script>
@section('script')
    @can('admin.member.member')

        <script>
            layui.use(['layer','table','form','laydate'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                var laydate = layui.laydate;


                formSelects.render('selectId');
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    // ,height: 500
                    ,url: "{{ route('admin.member.data') }}" //数据接口
                    ,page: true //开启分页
                    ,limits: [30,50,100,200,500]
                    ,limit: 30 //每页默认显示的数量
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'phone', title: '用户电话'}
                        ,{field: 'channel_name', title: '渠道名称',templet:function (d) {
                                if(d.channel !=null){
                                    return d.channel.channel_name
                                }else{
                                    return ''
                                }
                            }}
                        ,{field: 'platform_register', title: '来源平台'}
                        ,{field: 'page_name', title: '分发页',templet:function (d) {
                                if(d.page != null){
                                    return d.page.name
                                }else{
                                    return ''
                                }
                            }}
                        ,{field: 'department_name', title: '渠道所属部门',templet:function (d) {

                                if(d.channel != null && d.channel.department != null){
                                    return d.channel.department.name
                                }else{
                                    return ''
                                }

                            }}
                        ,{field: 'manager', title: '渠道负责人',templet:function (d) {
                                if(d.channel != null){
                                    return d.channel.manager
                                }else{
                                    return ''
                                }

                            }}
                        ,{field: 'created_at', title: '注册时间', sort: true}
                        ,{field: 'last_login_at', title: '最后登录时间', sort: true}
                        ,{field: 'last_apply_at', title: '最后申请时间', sort: true}
                        // ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                        ,{fixed: 'right', title:'操作',width: 220,align:'center', templet:function (d) {
                                if(d.phone === '18328000299' || d.phone === '18111620952'  || d.phone === '18180936251'  || d.phone === '18180729328'  || d.phone === '13308096817'  || d.phone === '13209368671'  || d.phone === '18582459979'  || d.phone === '18080020504'  || d.phone === '13488931916'  || d.phone === '13982211774'  || d.phone === '18482140158'  || d.phone === '18081877916'  || d.phone === '13198755505'  || d.phone === '13608138510'  || d.phone === '18215620734'    ){
                                    return '<a class="layui-btn layui-btn-sm " lay-event="edit" >编辑</a>'
                                }else{
                                    return ''
                                }
                            }}

                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.member.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/member/'+data.id+'/edit';
                    }
                });


                //监听是否显示
                form.on('switch(isShow)', function(obj){
                    var index = layer.load();
                    var url = $(obj.elem).attr('url')
                    var data = {
                        "is_show" : obj.elem.checked==true?1:0,
                        "_method" : "put"
                    }
                    $.post(url,data,function (res) {
                        layer.close(index)
                        layer.msg(res.msg)
                    },'json');
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
                            $.post("{{--{{ route('admin.member.member.destroy') }}--}}",{_method:'delete',ids:ids},function (result) {
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
                    var app_id = $("#app_id").val()
                    var phone = $("#phone").val();
                    var start_time = $("#start_time").val();
                    var end_time = $("#end_time").val();
                    var user_model_id = formSelects.value('select1', 'val');
                    var platform_register = $("#platform_register").val();
                    var u = '{{ route('admin.member.toExcel') }}';
                    u = u+'?app_id='+app_id+'&start_time='+start_time+'&end_time='+end_time+'&phone='+phone+'&ids='+ids+'&user_model_id='+user_model_id+'&platform_register='+platform_register;
                    // window.location.href=u;
                    window.open(u)
                })

                //监听搜索
                form.on('submit(searchBtn)', function(data){
                    var field = data.field;

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
    @endcan
@endsection