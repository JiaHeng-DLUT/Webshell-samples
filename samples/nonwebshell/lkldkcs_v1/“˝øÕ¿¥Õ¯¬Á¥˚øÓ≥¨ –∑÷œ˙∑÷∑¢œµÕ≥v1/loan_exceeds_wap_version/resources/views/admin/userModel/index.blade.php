@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                @can('admin.website.article.destroy')
                    <a class="layui-btn layui-btn-sm "  href="{{ route('admin.userModel.refreshSnapshot') }}">刷新人数</a>
                @endcan

                @can('admin.member.userModel.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.userModel.create') }}">添 加</a>
                @endcan

            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('admin.member.userModel.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan

                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>

        </div>
    </div>
@endsection

@section('script')
    @can('admin.member.userModel')
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
                    ,url: "{{ route('admin.userModel.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'name', title: '模型名称'}
                        ,{field: 'title', title: '条件',width:500,templet:function (d) {
                                if(d.snapshot){
                                    var last_str = '';
                                    if(d.register_at_type ==1){
                                        last_str += d.register_at_abstract_start+' <=注册时间<= '+d.register_at_abstract_end+' || '
                                    }else if(d.register_at_type ==2){
                                        if(d.register_at_relative_unit == 'day'){
                                            var unit = '天'
                                        }else if(d.register_at_relative_unit == 'week'){
                                            var unit = '周'
                                        }
                                        else if(d.register_at_relative_unit == 'month'){
                                            var unit = '月'
                                        }
                                        else if(d.register_at_relative_unit == 'year'){
                                            var unit = '年'
                                        }

                                        if(d.register_at_relative_type == 1){
                                            var type = '以前'
                                        }else if(d.register_at_relative_type == 2){
                                            var type = '以内'
                                        }
                                        last_str += "注册时间 : "+d.register_at_relative_num +unit+type+' || '
                                    }

                                    if(d.register_channels){
                                        last_str += '注册渠道 : '+d.register_channels+' || '
                                    }

                                    if(d.register_platforms){
                                        last_str += '注册平台 : '+d.register_platforms+' || '
                                    }

                                    if(d.all_login_day_start && d.all_login_day_end){
                                        last_str +=  d.all_login_day_start+' <=累计登陆天数<= '+d.all_login_day_end+' || '
                                    }else if(!d.all_login_day_start && d.all_login_day_end){
                                        last_str += '累计登陆天数 <='+d.all_login_day_end+' || '
                                    }else if(d.all_login_day_start && !d.all_login_day_end){
                                        last_str += '累计登陆天数 >='+d.all_login_day_start+' || '
                                    }

                                    if(d.all_apply_num_start && d.all_apply_num_end){
                                        last_str += d.all_apply_num_start+' <=累计产品申请数<= '+d.all_apply_num_end+' || '
                                    }else if(!d.all_apply_num_start && d.all_apply_num_end){
                                        last_str += '累计产品申请数 <='+d.all_apply_num_end+' || '
                                    }else if(d.all_apply_num_start && !d.all_apply_num_end){
                                        last_str += '累计产品申请数 >='+d.all_apply_num_start+' || '
                                    }

                                    if(d.apply_loans){
                                        last_str += '申请过的产品 : '+d.apply_loans+' || '
                                    }

                                    if(d.not_apply_loans){
                                        last_str += '未申请过的产品 : '+d.not_apply_loans+' || '
                                    }

                                    if(d.last_active_at_type ==1){
                                        last_str += d.last_active_at_abstract_start+' <=注册时间<= '+d.last_active_at_abstract_end+' || '
                                    }else if(d.last_active_at_type ==2){
                                        if(d.last_active_at_relative_unit == 'day'){
                                            var last_active_at_relative_unit = '天'
                                        }else if(d.last_active_at_relative_unit == 'week'){
                                            var last_active_at_relative_unit = '周'
                                        }
                                        else if(d.last_active_at_relative_unit == 'month'){
                                            var last_active_at_relative_unit = '月'
                                        }
                                        else if(d.last_active_at_relative_unit == 'year'){
                                            var last_active_at_relative_unit = '年'
                                        }

                                        if(d.last_active_at_relative_type == 1){
                                            var last_active_at_relative_type = '以前'
                                        }else if(d.last_active_at_relative_type == 2){
                                            var last_active_at_relative_type = '以内'
                                        }
                                        last_str += "最后活跃时间 : "+d.last_active_at_relative_num +last_active_at_relative_unit+last_active_at_relative_type+' || '
                                    }

                                    if(d.last_login_platforms){
                                        last_str += "最后登录平台 : "+d.last_login_platforms +' || '
                                    }

                                    if(d.last_apply_loans){
                                        last_str += '最后申请过的产品 : '+d.last_apply_loans+' || '
                                    }

                                    if(d.last_apply_loan_at_type ==1){
                                        last_str += d.last_apply_loan_at_abstract_start+' <=最后申请产品时间<= '+d.last_apply_loan_at_abstract_end+' || '
                                    }else if(d.last_apply_loan_at_type ==2){
                                        if(d.last_apply_loan_at_relative_unit == 'day'){
                                            var last_apply_loan_at_relative_unit = '天'
                                        }else if(d.last_apply_loan_at_relative_unit == 'week'){
                                            var last_apply_loan_at_relative_unit = '周'
                                        }
                                        else if(d.last_apply_loan_at_relative_unit == 'month'){
                                            var last_apply_loan_at_relative_unit = '月'
                                        }
                                        else if(d.last_apply_loan_at_relative_unit == 'year'){
                                            var last_apply_loan_at_relative_unit = '年'
                                        }

                                        if(d.last_apply_loan_at_relative_type == 1){
                                            var last_apply_loan_at_relative_type = '以前'
                                        }else if(d.last_apply_loan_at_relative_type == 2){
                                            var last_apply_loan_at_relative_type = '以内'
                                        }
                                        last_str += "最后申请产品时间 : "+d.last_active_at_relative_num +last_apply_loan_at_relative_unit+last_apply_loan_at_relative_type+' || '
                                    }


                                    return last_str;
                                }
                            }}
                        ,{field: 'created_at', title: '当前模型人数',templet:function (d) {
                                // console.log(d.snapshot[0].client_user_num)
                                if(d.snapshot[0]){
                                    return d.snapshot[0].client_user_num
                                }else{
                                    return '0'
                                }
                            }}
                        ,{field: 'updated_at', title: '上次刷新时间',templet:function (d) {
                                if(d.snapshot[0]){
                                    return d.snapshot[0].created_at
                                }else{
                                    return '0'
                                }
                            }}
                        ,{field: 'updated_at', title: '最后规则修改时间'}
                        ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'edit'){
                        location.href = '/admin/userModel/'+data.id+'/edit';
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
                            $.post("",{_method:'delete',ids:ids},function (result) {
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

                //搜索
                $("#searchBtn").click(function () {
                    var catId = $("#category_id").val()
                    var title = $("#title").val();
                    var start_time = $("#start_time").val();
                    var end_time = $("#end_time").val();
                    dataTable.reload({
                        where:{category_id:catId,title:title,start_time:start_time,end_time:end_time},
                        page:{curr:1}
                    })
                });

                laydate.render({
                    elem: '#start_time' //指定元素
                    ,type: 'datetime'
                });
                laydate.render({
                    elem: '#end_time' //指定元素
                    ,type: 'datetime'
                });

                table.render();
            });

        </script>
    @endcan
@endsection