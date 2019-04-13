@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header">短信配置</div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $id }}">
                <div style="border:1px solid green; margin-top: 20px;padding: 20px 0px 20px 0px;">
                    <div class="layui-form-item">
                        <label class="layui-form-label"><strong class="item-required"></strong>姓名：</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" lay-verify="" autocomplete="on" placeholder="请输入姓名" class="layui-input" value="{{ $info->name }}" maxlength="50"  id="phone" readonly>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><strong class="item-required"></strong>账号：</label>
                        <div class="layui-input-block">
                            <input type="text" name="phone" lay-verify="" autocomplete="on" placeholder="请输入APPID" class="layui-input" value="{{ $info->phone }}" maxlength="50"  id="phone" readonly>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><strong class="item-required"></strong>密码：</label>
                        <div class="layui-input-block">
                            <input type="password" name="appsecret" lay-verify="" autocomplete="on" placeholder="" class="layui-input" value="{{ $info->password }}" maxlength="50" readonly style="display: inline-block;width: 30%;margin-right: 10px;" id="password">
                            <a class="layui-btn" onclick="passShow(this,1)">查看密码</a>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><strong class="item-required"></strong>短信签名：</label>
                        <div class="layui-input-block">
                            <input type="text" name="signature" lay-verify="" autocomplete="on" placeholder="" class="layui-input" value="{{$info->signature}}" maxlength="50" readonly >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><strong class="item-required"></strong>AppKey：</label>
                        <div class="layui-input-block">
                            <input type="text" name="AppKey" lay-verify="" autocomplete="on" placeholder="" class="layui-input" value="{{$info->appkey}}" maxlength="50" readonly  >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><strong class="item-required"></strong>AppSecret：</label>
                        <div class="layui-input-block">
                            <input type="text" name="AppSecret" lay-verify="" autocomplete="on" placeholder="" class="layui-input" value="{{ $info->appsecret }}" maxlength="50" readonly >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">开通模板：</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="module[register]" title="找回密码" checked="" disabled>
                            <div class="layui-unselect layui-form-checkbox"><span>找回密码</span><i class="layui-icon layui-icon-ok"></i></div>
                            <input type="checkbox" name="module[forgot]" title="注册模板" checked="" disabled>
                            <div class="layui-unselect layui-form-checkbox"><span>注册模板</span><i class="layui-icon layui-icon-ok"></i></div>
                            <input type="checkbox" name="module[notice]" title="消息通知" checked="" disabled>
                            <div class="layui-unselect layui-form-checkbox"><span>消息通知</span><i class="layui-icon layui-icon-ok"></i></div>
                        </div>
                    </div>
                    <div class="layui-form-item layui-layout-admin">
                        <div class="layui-input-block">
                            <div class="layui-footer" style="left: 0;">
                                <button type="submit" class="layui-btn" lay-submit="" lay-filter="*">确 认</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function passShow(obj,a){
            if(a == 1) {
                $("#password").attr('type', 'text');
                $(obj).attr('onclick','passShow(this,2)')
            }else{
                $("#password").attr('type', 'password');
                $(obj).attr('onclick','passShow(this,1)')
            }
        }
    </script>
@endsection