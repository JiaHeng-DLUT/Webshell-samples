{{csrf_field()}}


<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>显示名称</label>
    <div class="layui-input-inline">
        <input type="text" name="name" maxlength="10" value="{{ $user->name ?? old('name') }}" lay-verify="required" placeholder="请输入昵称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>登录用户名</label>
    <div class="layui-input-inline">
        <input type="text" name="username" maxlength="50" value="{{ $user->username ?? old('username') }}" lay-verify="required" placeholder="请输入用户名" class="layui-input" >
    </div>
</div>

{{--<div class="layui-form-item">--}}
    {{--<label for="" class="layui-form-label">邮箱</label>--}}
    {{--<div class="layui-input-inline">--}}
        {{--<input type="email" name="email" value="{{$user->email??old('email')}}" lay-verify="email" placeholder="请输入Email" class="layui-input" >--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="layui-form-item">--}}
    {{--<label for="" class="layui-form-label">手机号</label>--}}
    {{--<div class="layui-input-inline">--}}
        {{--<input type="text" name="phone" value="{{$user->phone??old('phone')}}" required="phone" lay-verify="phone" placeholder="请输入手机号" class="layui-input">--}}
    {{--</div>--}}
{{--</div>--}}

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>密码</label>
    <div class="layui-input-inline">
        <input type="password" name="password" minlength="6" maxlength="18" placeholder="请输入密码" @if(!$user->id) lay-verify="required|password"  @endif class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>确认密码</label>
    <div class="layui-input-inline">
        <input type="password" name="password_confirmation" minlength="6" maxlength="18" @if(!$user->id) lay-verify="required"  @endif placeholder="请输入确认密码" class="layui-input">
    </div>
</div>

{{--<div class="layui-form-item">--}}
    {{--<label class="layui-form-label">状态</label>--}}
    {{--<div class="layui-input-block">--}}
        {{--<input type="checkbox" name="status" lay-skin="switch" lay-text="启用|禁用" value="{{old('status',$user->status)}}"  {{old('status',$user->id?$user->status:'1')=='1'?'checked':''}}>--}}
    {{--</div>--}}
{{--</div>--}}

<div class="layui-form-item">
    <label class="layui-form-label"><strong class="item-required">*</strong>角色</label>
    <div class="layui-input-inline">
        <select name="role_id" lay-verify="required">
            <option value="">请选择角色类型</option>
            @if($roles->count())
                @foreach($roles as $role)
                    <option value="{{$role->id}}" {{old('role_id',(isset($user->roles[0])?$user->roles[0]->id:0))==$role->id?'selected':''}}>{{$role->display_name}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.user')}}" >返 回</a>
    </div>
</div>

@section('script')
    <script>
        layui.use(['upload','form'],function () {
            var form = layui.form

            form.verify({
                password: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(!/^\S+$/.test(value)){
                        return '密码中不能包含空格';
                    }
                },

            });

            form.on('submit(formDemo)', function(data){
                if($('input[name="password"]').val() && !/^\S+$/.test($('input[name="password"]').val())){
                    layer.msg('密码中不能包含空格',{icon:2});
                    return false;
                }
                {{--$.post($('#form-page').attr('action'),data.field,function (res) {--}}
                    {{--if(res.code===0){--}}
                        {{--layer.msg(res.msg,{icon:1});--}}
                        {{--setTimeout(function () {--}}
                            {{--window.location.href="{{route('admin.page')}}";--}}
                        {{--},1500);--}}
                    {{--}else {--}}
                        {{--layer.msg(res.msg,{icon:2});--}}
                    {{--}--}}
                {{--}).error(function (data) {--}}
                    {{--$.each(data.responseJSON.errors,function (key,value) {--}}
                        {{--layer.msg(value[0],{icon:2});--}}
                        {{--return false;--}}
                    {{--})--}}
                {{--});--}}
                // return false;
            });


        });


    </script>

@endsection

