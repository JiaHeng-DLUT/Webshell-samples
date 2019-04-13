{{csrf_field()}}


{{--<div class="layui-form-item">
    <label for="" class="layui-form-label my_width"><strong class="item-required">*</strong>渠道码</label>
    <div class="layui-input-inline">
        <input type="text" name="channel_code" id="channel_code" value="{{$channel->channel_code??old('channel_code')}}" lay-verify="my_channel_name" placeholder="请输入渠道码" maxlength="6" class="layui-input" style="width: 190px" @if(isset($channel)) readonly @endif>
    </div>
    <span>一旦设定不允许修改</span>
</div>--}}
<div class="layui-form-item">
    <label for="" class="layui-form-label my_width"><strong class="item-required">*</strong>渠道名称</label>
    <div class="layui-input-inline">
        <input type="text" name="channel_name" id="channel_name" value="{{$channel->channel_name??old('channel_name')}}" lay-verify="my_channel_name" placeholder="请输入渠道名称" maxlength="15" class="layui-input" style="width: 190px" @if(isset($channel)) readonly @endif>
    </div>
    <span>一旦设定不允许修改</span>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label my_width" ><strong class="item-required">*</strong>渠道所属部门</label>
    <div class="layui-input-inline">
        <select name="department_id" lay-verify="my_department_id" >
            <option value="@if(isset($channel)) 0 @endif" @if(isset($channel)) disabled @endif>请选择</option>
            @if(count($departments))
                @foreach($departments as $department)
                <option value="{{ $department->id }}" @if(isset($channel->department_id)&&$channel->department_id==$department->id)selected @endif @if(old('department_id')==$department->id) selected @endif @if(isset($channel) && $channel->department_id!=$department->id) disabled @endif>{{ $department->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <span>一旦设定不允许修改</span>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label my_width"><strong class="item-required">*</strong>渠道负责人</label>
    <div class=" layui-input-inline">
        <input type="text" name="manager" id="manager" value="{{$channel->manager??old('manager')}}" lay-verify="my_manager" placeholder="请输入渠道负责人" class="layui-input" maxlength="10" style="width: 190px" @if(isset($channel)) readonly @endif >
    </div>
    <span>一旦设定不允许修改</span>

</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label my_width" ><strong class="item-required">*</strong>渠道包扣量模式</label>
    <div class="layui-input-inline">
        <select name="reduce_type" lay-verify="my_reduce_type" id="reduce_type">
            <option value="@if(isset($channel)) 0 @endif" @if(isset($channel)) disabled @endif>请选择</option>
            <option value="apply_register" @if(isset($channel) && $channel->reduce_type == 'apply_register') selected @endif @if(old('reduce_type') == 'apply_register') selected @endif @if(isset($channel) && $channel->reduce_type != 'apply_register') disabled @endif>按正常申请注册比</option>
            <option value="register" @if(isset($channel) && $channel->reduce_type == 'register') selected @endif @if(old('reduce_type') == 'register') selected @endif @if(isset($channel) && $channel->reduce_type != 'register') disabled @endif >按比例扣量</option>

        </select>
    </div>
    <span>一旦设定不允许修改</span>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label my_width"><strong class="item-required">*</strong>渠道角色</label>
    <div class="layui-input-inline">
        <select name="role_id" lay-verify="my_role_id" >
            <option value="@if(isset($channel)) 0 @endif" @if(isset($channel)) disabled @endif>请选择</option>
            @if(count($roles))
                @foreach($roles as $role)
                <option value="{{ $role->id }}" @if(isset($channel)&&$channel->role_id==$role->id)selected @endif @if(old('role_id')==$role->id) selected @endif @if(isset($channel) && $channel->role_id!=$role->id) disabled @endif>{{ $role->display_name }}</option>
            @endforeach
            @endif

        </select>
    </div>
    <span>一旦设定不允许修改</span>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label my_width" >单日注册上限</label>
    <div class="layui-input-inline">
        <input type="number"   name="ceiling_num" id="ceiling_num" value="{{$channel->ceiling_num??old('ceiling_num')}}"   placeholder="请输入单日注册上限" class="layui-input" style="width: 190px;">
    </div>
    <span>默认留空代表不设置注册上限 一旦设置值后不能设置0和留空</span>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label my_width"><strong class="item-required">*</strong>登陆用户</label>
    <div class="layui-input-inline">
        <input type="text"  name="username" id="username" value="@if(isset($channel)){{ $channel->user->username }}@else{{ old('username') }}@endif" lay-verify="my_username" placeholder="请输入登陆用户" class="layui-input" style="width: 190px;" @if(isset($channel)) readonly @endif>
    </div>
    <span>一旦设定不允许修改</span>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label my_width">@if(!isset($channel))<strong class="item-required">*</strong>@endif登录密码</label>
    <div class="layui-input-block">
        <input type="password" name="password" id="password" value="" @if(!isset($channel))lay-verify="my_password" @else @endif  placeholder="请输入登录密码" maxlength="18" class="layui-input" style="width: 190px;">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">标签</label>
    <div class="layui-input-block">
        @if($new_labels->count())
            @foreach($new_labels as $new_label)
                <input type="checkbox" name="new_label[]" lay-filter="label"  title="{{$new_label->name}}" lay-skin="primary" value="{{$new_label->id}}" {{in_array($new_label->id,isset($channel)?$channel->newLabel->pluck('id')->all():[])?'checked':''}}>
            @endforeach
        @endif
    </div>
</div>







<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.channel')}}" >返 回</a>
    </div>
</div>