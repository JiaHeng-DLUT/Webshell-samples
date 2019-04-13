@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header">消息@if(!isset($info))添加@else编辑@endif</div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="push">
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>消息名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" lay-verify="name" autocomplete="off" placeholder="请输入2-20个字系统消息名称" class="layui-input" value="{{ $info->title??'' }}" maxlength="20">
                    </div>
                </div>
                @include('vendor.ueditor.assets')
                <div class="layui-form-item">
                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>消息内容</label>
                    <div class="layui-input-block" >
                        <script id="container" name="content" type="text/plain" style="height: 320px;">
                            {!! $info->content??old('content') !!}
                        </script>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>发送时间</label>
                    <div class="layui-input-block">
                        <input type="radio" name="send_type"  lay-filter="send_type" value="1" title="即时推送" @if(!isset($info) || $info->send_type == 1 ) checked  @endif >
                        <div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i>
                            <div>即时推送</div>
                        </div>
                        <input type="radio" name="send_type" lay-filter="send_type" value="2" title="自定义时间" @if(isset($info) && $info->send_type == 2 ) checked @endif>
                        <div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i>
                            <div>自定义时间</div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item send_type" style="display: @if(isset($info) && $info->send_type == 2 ) block @else none; @endif">
                    <div class="layui-inline">
                        <label class="layui-form-label">设置时间</label>
                        <div class="layui-input-inline">
                            <input type="text" name="action_time" id="action_time" lay-verify="" placeholder="请输入自定义时间" autocomplete="off" class="layui-input" lay-key="1" value="{{ $info->fixed_at ??'' }}">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>发送对象</label>
                    <div class="layui-input-block">
                        {{--<input type="radio" name="user_type" lay-filter="user_type" value="1" title="全部用户" @if(!isset($info) || $info->send_object == 1 ) checked  @endif >
                        <div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i>
                            <div>全部用户（访客+注册）</div>
                        </div>--}}
                        <input type="radio" name="user_type" lay-filter="user_type"  value="2" title="注册用户" @if(!isset($info) || $info->send_object == 2 ) checked @endif>
                        <div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i>
                            <div>注册用户</div>
                        </div>
                        <input type="radio" name="user_type" lay-filter="user_type" value="3" title="指定注册用户" @if(isset($info) && $info->send_object == 3 ) checked @endif>
                        <div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i>
                            <div>指定注册用户</div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item user_type" style="display:  @if(isset($info) && $info->send_object == 3 ) block @else  none @endif">
                    <label class="layui-form-label">模型用户</label>
                    <div class="layui-input-block">
                        <select name="model" xm-select="modelId" lay-verify="" id="modelId">
                            @if($models)
                                @foreach($models as $item)
                                    <option value="{{$item->id}}" @if(isset($info) && in_array($item->id,$info['userModel'])) selected @endif>{{$item->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        <input type="hidden" name="" id="modelStr" value="{{ isset($info['userModel'])? implode(',',$info['userModel']) :'' }}">
                    </div>

                    <div class="layui-form-item" >
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">追加号码</label>
                            <div class="layui-input-block">
                                <textarea name="customNumbers" id="customNumbers" placeholder="请输入电话号码（英文‘，’）逗号隔开" class="layui-textarea" lay-verify="" >{{ $info->appends['phone']??'' }}</textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="" class="layui-form-label">附件上传</label>
                            <div class="layui-input-block">
                                <div class="layui-upload">
                                    <button type="button" class="layui-btn" id="app" lay-data="{accept: 'file',exts: 'xls|xlsx'}"><i class="layui-icon">&#xe67c;</i>excel上传</button>
                                    <a  class="layui-btn layui-btn-danger" href="/template_.xlsx"><i class="layui-icon"></i>模板下载</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">人数预览</label>
                        <div class="layui-input-inline">
                            <input type="text" name="counts"  autocomplete="off" class="layui-input" lay-key="1" readonly id="counts" value="{{$info->counts??''}}">
                        </div>
                        <a class="layui-btn " onclick="refreshNumbers()">刷 新</a>
                    </div>
                </div>
                <div class="layui-form-item layui-layout-admin">
                    <div class="layui-input-block">
                        <div class="layui-footer" style="left: 0;">
                            @if(isset($info) && $info->status == 0 || !isset($info))
                                <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
                            @endif
                            @if(isset($info))
                                <button type="reset" class="layui-btn " onclick="redirectToPage('{{route('admin.push')}}')">返回</button>
                            @else
                                <button type="reset" class="layui-btn " onclick="redirectToPage('{{route('admin.push')}}')">返回</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection
    @section('script')
            <!-- 引入样式 -->
    <link rel="stylesheet" type="text/css" href="//raw.githack.com/hnzzmsf/layui-formSelects/master/dist/formSelects-v4.css"/>
    <!-- 引入jquery依赖 -->
    <script src="//unpkg.com/jquery@3.3.1/dist/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <!-- 引入组件 -->
    <script src="//raw.githack.com/hnzzmsf/layui-formSelects/master/dist/formSelects-v4.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var ue = UE.getEditor('container',{  toolbars: [
            ['fullscreen', 'source', 'undo', 'redo','bold', 'italic', 'underline', 'fontborder', 'simpleupload', 'cleardoc']
        ],
            initialFrameHeight: 400,
            autoHeightEnabled: false
        });

        layui.use(['upload','form','laydate'],function () {
            var laydate = layui.laydate;
            var upload = layui.upload

            @if(session('success'))
            layer.msg('{{session('success')}}',{icon:6});
            @endif
            //excel 上传
            upload.render({
                elem: '#app'
                ,url: '{{ route("admin.push.import") }}'
                ,multiple: false
                ,data:{"_token":"{{ csrf_token() }}",maxSize:1,filename:'file'}
                ,done: function(res){
                    if(res.code == 0){//成功
                        //原有自定义号码：
                        var numbers = $("#customNumbers").val();
                        if(numbers!=''){
                            $("#customNumbers").val(numbers+','+res.data.str)
                        }else{
                            $("#customNumbers").val(res.data.str)
                        }
                        return layer.msg(res.message,{icon:6});
                    }//失败
                    return layer.msg(res.message,{icon:5});
                }
            });
            var form = layui.form;
            form.verify({
                name: [
                    /^[\S]{2,20}$/
                    ,'标题必填，字符2到20位，且不能出现空格'
                ],
                introduce: [
                    /^[\S]{1,50}$/
                    ,'内容必填，字符1到50位，且不能出现空格'
                ],
                cash_amount: [
                    /^[\S]{1,15}$/
                    ,'取现额度必填，字符1到15位，且不能出现空格'
                ],
                base_apply_num: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(value>99999 || value < 0){
                        return '申请基数必填，范围0~99999';
                    }
                },
                sort: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(value>999 || value < -999){
                        return '排序值必填，范围-999~999';
                    }
                }
            });
            form.on('select(redirect_model)', function(data){
                if(data.value == 'CustomLink'){
                    $(".custom-link").show();
                }else{
                    $(".custom-link").hide()
                    $('input[name="redirect_model_detail"]').val('');
                }
            });
            form.on('radio(send_type)', function(data){
                if(data.value == 2){
                    $(".send_type").show()
                }else{
                    $(".send_type").hide()
                }
            });
            form.on('radio(user_type)', function(data){
                if(data.value == 3){
                    $(".user_type").show();
                }else{
                    $(".user_type").hide()
                }
            });
            var  currentTime = new Date().toLocaleString('chinese', { hour12: false }) // 获取当前时间
            laydate.render({
                elem: '#action_time' //指定元素
                ,type: 'datetime'
                ,min: currentTime
            });
            form.on('submit(formDemo)', function(data){
                if(!ue.hasContents()){
                    layer.msg('内容不能为空',{icon:5});
                    return false;
                }
                if(ue.getPlainTxt().length >1000){

                    layer.msg('内容最多输入1000个字符',{icon:5});
                    return false;
                }
                return true;
            });
        });
        //刷新统计用户数量
        function  refreshNumbers(){
            var params = {};
            params.str = $("#customNumbers").val();
            params.models  = $("#modelStr").val();
            params.type  =$("input[name='user_type']:checked").val()
            $.ajax({
                url:'{{ route('admin.push.count') }}',
                type: "post",
                data: params,
                dataType: "json",
                success:function(res){
                    if(res.code == 0){
                        $("#counts").val(res.data.count)
                        layer.msg(res.info,{icon:1});
                    }else{
                        layer.msg(res.info,{icon:2});
                    }
                }
            })
        };
        var formSelects = layui.formSelects;
        formSelects.on('modelId', function(id, vals, val, isAdd, isDisabled){
            //id:           点击select的id
            //vals:         当前select已选中的值
            //val:          当前select点击的值
            //isAdd:        当前操作选中or取消
            //isDisabled:   当前选项是否是disabled
            var arr = [];
            for(var i = 0; i<vals.length;i++ ){
                arr.push(vals[i]['value'])
            }
            $("#modelStr").val(arr)
        }, true);
        function redirectToPage(u){
            window.location.href = u;
        }
    </script>
@endsection