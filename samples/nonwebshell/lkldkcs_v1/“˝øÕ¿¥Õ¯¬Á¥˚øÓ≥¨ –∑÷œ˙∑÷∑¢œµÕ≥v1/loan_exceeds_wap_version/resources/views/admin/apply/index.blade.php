@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">
            <form class="layui-form-item" id="search-form">
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
                @include('admin.component.department-channel')
                <div class="layui-inline" >
                    <label class="layui-form-label">产品类型</label>
                    <div class="layui-input-inline">
                        <select name="type"  id="type">
                            <option value="">所有产品类型</option>
                            <option value="product">贷款产品</option>
                            <option value="credit">信用卡</option>

                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">申请平台</label>
                    <div class="layui-input-inline">
                        <select name="platform"  id="platform">
                            <option value="">所有申请平台</option>
                            <option value="android">android</option>
                            <option value="ios">ios</option>
                            <option value="pc">pc</option>
                            <option value="wap">wap</option>


                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">负责人</label>
                    <div class="layui-input-inline">
                        <input type="text" name="manager" id="manager"  placeholder="请输入渠道负责人" class="layui-input">
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
                    @can('admin.member.apply.toExcel')
                        <button class="layui-btn layui-btn-sm layui-btn-container" id="toExcel">导 出</button>
                    @endcan
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    {{--@can('zixun.apply.edit')--}}
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    {{--@endcan--}}

                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>


        </div>
    </div>
@endsection

@section('script')
    @can('admin.member.apply')
        @include('admin.component.department-channel-js')
        <script>
            layui.use(['layer','table','form','laydate','laypage'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                var laydate = layui.laydate;
                var laypage = layui.laypage;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    // ,height: 500
                    ,url: "{{ route('admin.apply.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'phone', title: '用户电话',templet: function(d){
                                if(d.member != null){
                                    return d.member.phone
                                }else{
                                    return ''
                                }

                            }}
                        ,{field: 'type', title: '产品类型',templet: function(d){
                                if(d.type=='product'){
                                    return '贷款'
                                }else if(d.type=='credit'){
                                    return '信用卡'
                                }
                            }}
                        ,{field: 'model_id', title: '意向产品',templet: function(d){
                                if(d.product != null || d.credit != null){
                                    if(d.type=='product'){
                                        return d.product.name
                                    }
                                    if(d.type=='credit'){
                                        return d.credit.name
                                    }
                                }else{
                                    return ''
                                }

                            }}
                        ,{field: 'platform', title: '申请平台'}
                        ,{field: 'created_at', title: '意向时间'}
                        ,{field: 'channel_id', title: '申请来源渠道',templet: function(d){
                                if(d.channel != null){
                                    return d.channel.channel_name
                                }else{
                                    return ''
                                }

                            }}
                        ,{field: 'channel_id', title: '注册来源渠道',templet: function(d){
                                if(d.member != null && d.member.channel != null){
                                    return d.member.channel.channel_name
                                }else{
                                    return ''
                                }

                            }}
                        ,{field: 'platform_register', title: '注册来源平台',templet: function(d){

                                if(d.member != null){

                                    return d.member.platform_register
                                }else{
                                    return ''
                                }
                            }}
                        ,{field: '', title: '注册分发页',templet: function(d){
                                if(d.register_page != null){
                                    return d.register_page.name
                                }else{
                                    return ''
                                }

                            }}
                        ,{field: '', title: '渠道所属部门',templet: function(d){
                                if(d.channel != null){
                                    if(d.channel.department){
                                        return d.channel.department.name
                                    }else{
                                        return ''
                                    }
                                }else{
                                    return ''
                                }


                            }}
                        ,{field: '', title: '渠道负责人',templet: function(d){
                                if(d.channel != null){
                                    return d.channel.manager
                                }else{
                                    return ''
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
                    var type = $("#type").val()
                    var platform = $("#platform").val();
                    var start_time = $("#start_time").val();
                    var end_time = $("#end_time").val();
                    var department_id = $("#department_id").val();
                    var channel_code = $("#channel_code").val();
                    var manager = $("#manager").val();
                    var phone = $("#phone").val();
                    var u = '{{ route('admin.apply.toExcel') }}';
                    u = u+'?type='+type+'&start_time='+start_time+'&end_time='+end_time+'&platform='+platform+'&ids='+ids+'&department_id='+department_id+"&channel_code="+channel_code+'&manager'+manager+'&phone='+phone;
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

