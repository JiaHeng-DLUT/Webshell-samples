{{csrf_field()}}



<div class="layui-form-item">
    <label for="" class="layui-form-label">部门名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" id="name"  maxlength="10" value="{{$department->name??old('name')}}" lay-verify="my_name" placeholder="请输入部门名称 10个字以内" class="layui-input" >
    </div>
</div>



<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.channel.department')}}" >返 回</a>
    </div>
</div>