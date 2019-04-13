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
                <div class="layui-inline">
                    <label class="layui-form-label">产品类型</label>
                    <div class="layui-input-inline">
                        <select name="product_type"  id="product_type" lay-filter="product_type">
                            <option value="">不限</option>
                            <option value="1">贷款产品</option>
                            <option value="2">信用卡</option>

                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">操作类型</label>
                    <div class="layui-input-inline">
                        <select name="operate_type"  id="operate_type" lay-filter="operate_type">
                            <option value=""     >请选择操作类型</option>
                            <option value="1" >注册</option>
                            <option value="2" >登陆</option>
                            <option value="3" >启动app</option>
                            <option value="4" >查看贷款产品详情</option>
                            <option value="5" >申请贷款产品</option>
                            <option value="6" >查看贷款分类</option>
                            <option value="7" >查看信用卡产品详情</option>
                            <option value="8" >申请信用卡产品</option>

                        </select>
                    </div>
                </div>

                <div class="layui-inline" >
                    <label class="layui-form-label">注册渠道</label>
                    <div class="layui-input-inline">
                        <select name="register_channel_name"  id="register_channel_name" lay-search>
                            <option value="">请选择用户注册渠道</option>
                            @if(count($register_channel_name))
                                @foreach($register_channel_name as $item)
                                    <option value="{{ $item->register_channel_name }}">{{ $item->register_channel_name }}</option>
                                @endforeach
                            @endif

                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">注册分发页</label>
                    <div class="layui-input-inline">
                        <select name="register_page_name"  id="register_page_name" lay-search>
                            <option value="">注册分发页</option>
                            @if(count($register_page_name))
                                @foreach($register_page_name as $item)
                                    <option value="{{ $item->register_page_name }}">{{ $item->register_page_name }}</option>
                                @endforeach
                            @endif


                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">操作平台</label>
                    <div class="layui-input-inline">
                        <select name="operate_platform"  id="operate_platform">
                            <option value="">用户操作平台</option>
                            <option value="android">android</option>
                            <option value="ios">ios</option>
                            <option value="pc">pc</option>
                            <option value="wap">wap</option>


                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">操作渠道</label>
                    <div class="layui-input-inline">
                        <select name="operate_channel_name"  id="operate_channel_name" lay-search>
                            <option value="">用户操作渠道</option>
                            @if(count($operate_channel_name))
                                @foreach($operate_channel_name as $item)
                                    <option value="{{ $item->operate_channel_name }}">{{ $item->operate_channel_name }}</option>
                                @endforeach
                            @endif


                        </select>
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label">操作分发页</label>
                    <div class="layui-input-inline">
                        <select name="operate_page_name"  id="operate_page_name" lay-search>
                            <option value="">操作分发页</option>
                            @if(count($operate_page_name))
                                @foreach($operate_page_name as $item)
                                    <option value="{{ $item->operate_page_name }}">{{ $item->operate_page_name }}</option>
                                @endforeach
                            @endif


                        </select>
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
                    @can('admin.member.behaviorlog.toExcel')
                        <button class="layui-btn layui-btn-sm layui-btn-container" id="toExcel">导 出</button>
                    @endcan
                </div>
            </div>




        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    {{--@can('zixun.behaviorlog.edit')--}}
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
    @can('admin.member.behaviorlog')
        @include('admin.common._js_department_get_channel')
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
                    ,url: "{{ route('admin.behaviorlog.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'created_at', title: '操作时间'}
                        ,{field: 'phone', title: '用户电话'}
                        ,{field: 'product_type', title: '产品类型',templet:function (d) {
                                if(d.operate_type==1){
                                    return ''
                                }else if(d.operate_type==2){
                                    return ''
                                }else if(d.operate_type==3){
                                    return ''
                                }else if(d.operate_type==4){
                                    return '贷款产品'
                                }else if(d.operate_type==5){
                                    return '贷款产品'
                                }else if(d.operate_type==6){
                                    return '贷款产品'
                                }else if(d.operate_type==7){
                                    return '信用卡'
                                }else if(d.operate_type==8){
                                    return '信用卡'
                                }else if(d.operate_type==11){
                                    return ''
                                }else if(d.operate_type==22){
                                    return ''
                                }else if(d.operate_type==103){
                                    return ''
                                }
                            }}
                        ,{field: 'register_channel_name', title: '注册渠道'}
                        ,{field: 'register_page_name', title: '注册分发页'}
                        ,{field: 'operate_type', title: '操作类型',templet: function(d){
                                if(d.operate_type==1){
                                    return '注册'
                                }else if(d.operate_type==2){
                                    return '登陆'
                                }else if(d.operate_type==3){
                                    return '启动app'
                                }else if(d.operate_type==4){
                                    return '查看贷款产品详情'
                                }else if(d.operate_type==5){
                                    return '申请贷款产品'
                                }else if(d.operate_type==6){
                                    return '查看贷款分类'
                                }else if(d.operate_type==7){
                                    return '查看信用卡产品详情'
                                }else if(d.operate_type==8){
                                    return '申请信用卡产品'
                                }else if(d.operate_type==11){
                                    return '未加密注册'
                                }else if(d.operate_type==22){
                                    return '未加密登录'
                                }else if(d.operate_type==103){
                                    return '未定义操作'
                                }

                            }}
                        ,{field: 'operate_channel_name', title: '操作渠道'}
                        ,{field: 'operate_platform', title: '操作平台'}
                        ,{field: 'operate_page_name', title: '操作分发页'}
                        ,{field: 'operate_params', title: '操作参数',templet:function (d) {

                                if(d.operate_params != ""){
                                    if(d.operate_type === 6 ) {
                                        if(d.operate_params.name != ""){
                                            return '类别：'+d.operate_params.name
                                        }else{
                                            return ""
                                        }
                                    }else if(d.operate_type === 5 || d.operate_type === 8){
                                        return '产品：'+d.operate_params.name
                                    }else {
                                        var html = '';
                                        if(d.operate_params.name != ""){
                                            html +=' 产品：'+d.operate_params.name
                                        }
                                        if(d.operate_params.from != ""){
                                            html +=' 访问来源：'+d.operate_params.from
                                        }
                                        return html;
                                    }
                                }else{
                                    return ""
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
                    var operate_type = $("#operate_type").val()
                    var register_channel_name = $("#register_channel_name").val();
                    var register_page_name = $("#register_page_name").val();
                    var operate_platform = $("#operate_platform").val();
                    var operate_channel_name = $("#operate_channel_name").val();
                    var operate_page_name = $("#operate_page_name").val();
                    var start_time = $("#start_time").val();
                    var end_time = $("#end_time").val();
                    var phone = $("#phone").val();
                    var product_type = $("#product_type").val();
                    var u = '{{ route('admin.behaviorlog.toExcel') }}';
                    u = u+'?operate_type='+operate_type+'&register_channel_name='+register_channel_name+'&register_page_name='+register_page_name+'&operate_platform='+operate_platform+'&ids='+ids+'&operate_channel_name='+operate_channel_name+"&operate_page_name="+operate_page_name+'&phone='+phone+'&start_time='+start_time+'&end_time='+end_time+'&product_type='+product_type;
                    window.location.href=u;
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

                form.on('select(product_type)', function(data){
                    var pid = data.value;

                    if(pid === ''){
                        $('#operate_type').val(0)
                        $('#operate_type option').each(function () {
                            $(this).attr('disabled',false)
                            form.render()
                        })
                    }
                    else if(pid === '1'){
                        // $('#operate_type').removeSelected()
                        $('#operate_type').val(0)
                        $('#operate_type').find('option').attr('disabled',false)
                        form.render()

                        $('#operate_type option').each(function () {
                            // console.log($(this).text())


                            if($(this).text() === '查看贷款产品详情'){


                            }else if($(this).text() === '申请贷款产品'){


                            }else if($(this).text() === '查看贷款分类'){


                            }else{
                                $(this).attr('disabled','disabled')
                                form.render()
                            }

                        })



                    }else if(pid === '2'){
                        // $('#operate_type').removeSelected()

                        $('#operate_type').val(0)
                        $('#operate_type').find('option').attr('disabled',false)
                        form.render()
                        $('#operate_type option').each(function () {


                            if($(this).text() === '查看信用卡产品详情'){

                            }else if($(this).text() === '申请信用卡产品'){

                            }else {
                                $(this).attr('disabled','disabled')
                                form.render()
                            }
                        })
                    }
                });
            });






        </script>


    @endcan
@endsection

