@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">
            <form class="layui-form-item" id="search-form">
                <div class="layui-inline">
                    <label class="layui-form-label">用户电话</label>
                    <div class="layui-input-inline">
                        <input type="text" name="phone" id="phone" placeholder="用户电话" class="layui-input" >
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">评论状态</label>
                    <div class="layui-input-inline">
                        <select name="status" lay-verify="" id="status">
                            <option value="">评论状态</option>
                            <option value="0" >待审核</option>
                            <option value="1" >审核通过</option>
                            <option value="-1" >不予显示</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">产品类型</label>
                    <div class="layui-input-inline">
                        <select name="product_type" lay-verify="" id="product_type">
                            <option value="">产品类型</option>
                            <option value="product" >贷款</option>
                            <option value="credit" >信用卡</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">评论类型</label>
                    <div class="layui-input-inline">
                        <select name="comment_type" lay-verify="" id="comment_type">
                            <option value="">评论类型</option>
                            <option value="real" >真实评论</option>
                            <option value="fake" >虚假评论</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">产品名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="model_name" id="model_name" placeholder="产品名称" class="layui-input" >
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">评论时间:</label>
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
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="searchBtn">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </form>
            <div>
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-sm" href="{{route('admin.virtual.comment.create')}}">+虚拟评论</a>
                    <button class="layui-btn layui-btn-sm" id="listAuditPass">批量通过</button>
                    <button class="layui-btn layui-btn-sm" id="listNotShown">批量不予展示</button>
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                    <button class="layui-btn layui-btn-sm" id="listExport">导 出</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @{{# if(d.comment_type == "real" && d.status == 0){}}
                         <a class="layui-btn layui-btn-sm" lay-event="edit" >处理</a>
                    @{{# }}}
                    <span style="margin-right: 20px"></span>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
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
                ,url: "{{ route('admin.comment.data') }}" //数据接口
                ,autoSort: false //禁用前端自动排序。注意：该参数为 layui 2.4.4 新增
                ,page: true //开启分页
                ,limits: [50,100,200]
                ,limit: 50 //每页默认显示的数量
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                  /*  ,{field: 'id', title: 'ID',width:80}*/
                    ,{field: 'comment_type' ,title: '评论类型' ,templet: function(d){
                            if(d.comment_type=='real'){
                                return '真实评论'
                            }else if(d.comment_type=='fake'){
                                return '虚拟评论'
                            }
                        }}
                    ,{field: 'phone', title: '用户电话'}
                    ,{field: 'product_type', title: '产品类型',templet: function(d){
                            if(d.product_type=='product'){
                                return '贷款'
                            }else if(d.product_type=='credit'){
                                return '信用卡'
                            }
                        }}
                    ,{field: 'model_name', title: '产品名称'}
                    ,{field: 'star', title: '评分',  sort: true}
                    ,{field: 'content', title: '评论内容'}
                    ,{field: 'created_at', title: '评论时间', sort: true}
                    ,{field: 'status', title: '状态',templet: function(d){
                            if(d.status=='0'){
                                return '待审核'
                            }else if(d.status=='-1'){
                                return '不予展示'
                            } else if(d.status=='1'){
                                return '审核通过'
                            }
                        }}
                    ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                ]]
            });
            //排序监听
            table.on('sort(dataTable)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var phone = $("#phone").val()
                var status = $("#status").val();
                var product_type = $("#product_type").val();
                var comment_type = $("#comment_type").val();
                var model_name = $("#model_name").val();
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();

                dataTable.reload({
                    initSort: obj
                    ,where:{phone:phone,product_type:product_type,status:status,comment_type:comment_type
                        ,model_name:model_name,start_time:start_time,end_time:end_time//排序字段
                        ,type: obj.field,order: obj.type //排序字段，排序方式
                    },
                    page:{curr:1}
                })
            });

            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("{{ route('admin.comment.destroy') }}",{_method:'delete',id:data.id},function (result) {
                            if (result.code==0){
                                obj.del(); //删除对应行（tr）的DOM结构
                            }
                            layer.close(index);
                            layer.msg(result.info,{icon:6})
                        });
                    });
                }
                else if(layEvent === 'edit'){
                    location.href = '/admin/comment/'+data.id+'/edit';
                }
            });
            @can('zixun.article.edit')
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
            @endcan
            /*//搜索
            $("#searchBtn").click(function () {
                var status = $("#status").val();
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();
                var phone = $("#phone").val();
                var product_type = $("#product_type").val();
                var model_name = $("#model_name").val();
                var comment_type = $("#comment_type").val();
                dataTable.reload({
                    where:{comment_type:comment_type,status:status,start_time:start_time,end_time:end_time,
                        phone:phone,product_type:product_type,model_name:model_name},
                    page:{curr:1}
                })
            });*/
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
            //批量通过
            $("#listAuditPass").click(function () {
                var ids = []
                var hasCheck = table.checkStatus('dataTable')
                var hasCheckData = hasCheck.data
                if (hasCheckData.length>0){
                    $.each(hasCheckData,function (index,element) {
                        ids.push(element.id)
                    })
                }
                if(ids.length>0)
                {
                    layer.confirm('确认批量审核吗？', function(index){
                        $.post("{{ route('admin.comment.auditPass') }}",{ids:ids},function (result) {
                            if (result.code==0){
                                dataTable.reload()
                                layer.close(index);
                                layer.msg(result.info,{icon:6})
                            }else{
                                layer.close(index);
                                layer.msg(result.info,{icon:5})
                            }
                        });
                    })
                }
                else
                {
                    layer.msg('请选择需要批量处理的评论',{icon:5})
                }
            })
            //批量不予展示
            $("#listNotShown").click(function () {
                var ids = []
                var hasCheck = table.checkStatus('dataTable')
                var hasCheckData = hasCheck.data
                if (hasCheckData.length>0){
                    $.each(hasCheckData,function (index,element) {
                        ids.push(element.id)
                    })
                }
                if(ids.length>0)
                {
                    layer.confirm('确认批量不予展示吗？', function(index){
                        $.post("{{ route('admin.comment.notAuditPass') }}",{ids:ids},function (result) {
                            if (result.code==0){
                                dataTable.reload()
                                layer.close(index);
                                layer.msg(result.info,{icon:6})
                            }else{
                                layer.close(index);
                                layer.msg(result.info,{icon:5})
                            }

                        });
                    })
                }
                else
                {
                    layer.msg('请选择需要批量处理的评论',{icon:5})
                }
            })
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
                        $.post("{{ route('admin.comment.auditDestroy') }}",{ids:ids},function (result) {
                            if (result.code==0){
                                delReload(dataTable,ids.length);
                            }
                            layer.close(index);
                            layer.msg(result.info,{icon:6})
                        });
                    })
                }else {
                    layer.msg('请选择需要批量处理的评论',{icon:5})
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

                var status = $("#status").val();
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();
                var phone = $("#phone").val();
                var product_type = $("#product_type").val();
                var model_name = $("#model_name").val();
                var comment_type = $("#comment_type").val();
                var u = '{{ route('admin.comment.export') }}'
                u = u+'?status='+status+'&product_type='+product_type+'&start_time='+start_time+'&end_time='+end_time+'&phone='+phone+'&model_name='+model_name+'&comment_type='+comment_type+'&ids='+ids;
                window.location.href=u;
            })
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