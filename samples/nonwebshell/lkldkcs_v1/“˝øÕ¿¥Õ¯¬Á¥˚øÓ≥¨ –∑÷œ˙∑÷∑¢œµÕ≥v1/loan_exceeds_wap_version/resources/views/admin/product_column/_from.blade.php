{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong> 栏目名称</label>
    <div class="layui-input-inline">
        <input type="text" name="name" maxlength="6" value="{{$productColumn->name??old('name')}}" lay-verify="required" class="layui-input" placeholder="请填写栏目名称">
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>排序值</label>
    <div class="layui-input-inline">
        <input type="number" name="sort" oninput="if(value.length>3)value=value.slice(0,3)" value="{{$productColumn->sort??old('sort',0)}}" lay-verify="required|number" class="layui-input" placeholder="请填写排序值">
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="save">保存</button>
        <a href="{{route('admin.productColumn')}}" class="layui-btn"  >返 回</a>
    </div>
</div>


