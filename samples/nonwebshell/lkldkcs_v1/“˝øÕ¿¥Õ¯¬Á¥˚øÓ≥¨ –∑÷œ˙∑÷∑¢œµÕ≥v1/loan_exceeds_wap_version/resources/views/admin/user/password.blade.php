@extends('admin.layouts.base')
@section('content')
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">修改密码</div>
                    <div class="layui-card-body" pad15>

                        <form  class="layui-form" id="resetPwd" method="post">
                            {{csrf_field()}}
                            <div class="layui-form-item">
                                <label class="layui-form-label">当前密码</label>
                                <div class="layui-input-inline">
                                    <input type="password"  maxlength="18" name="oldPassword" lay-verify="oldPassword"  class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">新密码</label>
                                <div class="layui-input-inline">
                                    <input type="password"  maxlength="18" name="password" lay-verify="password"  id="LAY_password" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">密码规则为6~18位数的数字、字母、特殊符号的字符</div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">确认新密码</label>
                                <div class="layui-input-inline">
                                    <input type="password"  maxlength="18" name="password_confirmation" lay-verify="password_confirmation"  autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="resetPwd">确认修改</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use('form', function(){
            var form = layui.form;
            form.verify({
                oldPassword:function (value,item) {
                    if(value.length===0){
                        return '请输入原密码';
                    }
                },
                password: [
                    /^[^\s]*$/
                    ,'密码规则为6~18位数的数字、字母、特殊符号的字符'
                ],
                password_confirmation:function (value) {
                    if(value!==$("input[name='password']").val()){
                        return '两次密码输入不一致';
                    }
                }
            });

            //监听提交
            form.on('submit(resetPwd)', function(data){
                // layer.msg(JSON.stringify(data.field));
                $.post("{{route('admin.postPassword')}}",data.field,function (res) {
                    if(res.code=='0'){
                        layer.msg(res.msg,{icon:1});
                        setTimeout(function () {
                            parent.document.getElementById('logout-form').submit();
                        },2000);
                    }else {
                        layer.msg(res.msg,{icon:2});
                    }
                }).error(function (data) {
                    $.each(data.responseJSON.errors,function (key,value) {
                        layer.msg(value[0],{icon:2});
                        return false;
                    })
                });
                return false;
            });
        });
    </script>
@endsection