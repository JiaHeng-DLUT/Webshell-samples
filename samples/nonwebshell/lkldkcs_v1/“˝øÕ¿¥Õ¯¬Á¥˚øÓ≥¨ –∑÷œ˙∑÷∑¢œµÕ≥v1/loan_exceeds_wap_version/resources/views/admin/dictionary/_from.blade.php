{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>功能名称</label>
    <div class="layui-input-block">
        <input type="text" name="function_name" value="{{$dictionary->function_name??old('function_name')}}" lay-verify="required" class="layui-input" placeholder="功能名称">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>字段名称</label>
    <div class="layui-input-block">
        <input type="text" name="field_name" value="{{$dictionary->field_name??old('field_name')}}" lay-verify="required" class="layui-input" placeholder="字段名称">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>字段标识</label>
    <div class="layui-input-block">
        <input type="text" name="slug" value="{{$dictionary->slug??old('slug')}}" lay-verify="required" class="layui-input" placeholder="字段标识">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" >确 认</button>
        <a href="{{route('admin.dictionary')}}" class="layui-btn"  >返 回</a>
    </div>
</div>

