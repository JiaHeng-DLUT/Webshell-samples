{{csrf_field()}}



<div class="layui-form-item">
    <label for="" class="layui-form-label" ><strong class="item-required">*</strong>手机号码</label>
    <div class="layui-input-block">
        <input type="text" name="phone" id="phone"  value="{{$member->phone??old('phone')}}" lay-verify="my_phone" placeholder="请输入编辑手机号码" class="layui-input" maxlength="11">
    </div>
</div>




<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.member')}}" >返 回</a>
    </div>
</div>