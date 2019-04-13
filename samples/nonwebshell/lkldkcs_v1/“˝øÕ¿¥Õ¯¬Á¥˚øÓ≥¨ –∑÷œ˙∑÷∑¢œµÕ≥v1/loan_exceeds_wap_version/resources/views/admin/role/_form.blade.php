{{csrf_field()}}

<div class="layui-form-item">
    <label class="layui-form-label"><strong class="item-required">*</strong>角色类型</label>
    <div class="layui-input-block">
        <input type="radio" name="type" value="admin" {{$role->type=='admin'?'checked':''}} title="后台管理员角色">
        <input type="radio" name="type" value="channel" {{$role->type=='channel'?'checked':''}} title="渠道角色">
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>角色标识</label>
    <div class="layui-input-inline">
        <input class="layui-input" type="text" maxlength="20" name="name" lay-verify="required" value="{{$role->name??old('name')}}" placeholder="如:admin">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>显示名称</label>
    <div class="layui-input-inline">
        <input class="layui-input" type="text" maxlength="10" name="display_name" lay-verify="required" value="{{$role->display_name??old('display_name')}}" placeholder="如：管理员" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" >确 认</button>
        <a href="{{route('admin.role')}}" class="layui-btn" >返 回</a>
    </div>
</div>