{{csrf_field()}}



<div class="layui-form-item">
    <label for="" class="layui-form-label" style="width: 105px"><strong class="item-required">*</strong>模板名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" id="name" maxlength="30" value="{{$distribute_template->name??old('name')}}" lay-verify="my_name" placeholder="请输入模板名称" class="layui-input" style="width: 200px">
    </div>
</div>




<div class="layui-form-item">
    <label for="" class="layui-form-label" style="width: 105px">是否支持定制</label>
    <div class="layui-input-block">
        <input type="radio" name="support_custom"   value="0" title="否" {{ $distribute_template->support_custom??old('support_custom') }} @if(isset($distribute_template->support_custom) && $distribute_template->support_custom == 0) checked @endif checked>
        <input type="radio" name="support_custom"   value="1" title="是" {{ $distribute_template->support_custom??old('support_custom') }} @if(isset($distribute_template->support_custom) && $distribute_template->support_custom == 1) checked @endif >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label" style="width: 105px">是否定制</label>
    <div class="layui-input-block">
        <input type="radio" name="custom_status"   value="0" title="未定制" {{ $distribute_template->custom_status??old('custom_status') }} @if(isset($distribute_template->custom_status) && $distribute_template->custom_status == 0) checked @endif checked>
        <input type="radio" name="custom_status"   value="1" title="已定制" {{ $distribute_template->custom_status??old('custom_status') }} @if(isset($distribute_template->custom_status) && $distribute_template->custom_status == 1) checked @endif>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label" style="width: 105px"><strong class="item-required">*</strong>模板文件名称</label>
    <div class="layui-input-block">
        <input type="text" name="html_name" id="html_name" maxlength="30" value="{{$distribute_template->html_name??old('html_name')}}" lay-verify="html_name" placeholder="如：channelGdt.html" class="layui-input" style="width: 200px">

    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label" style="width: 105px"><strong class="item-required">*</strong>可定制范围</label>
    <div class="layui-input-block">
        <input type="checkbox" name="custom_range[]" value="banner" title="图片" {{ $distribute_template->custom_range??old('custom_range') }} @if(isset($distribute_template->custom_range) && in_array('banner',json_decode($distribute_template['custom_range']))) checked @endif >
        <input type="checkbox" name="custom_range[]" value="register" title="注册" {{ $distribute_template->custom_range??old('custom_range') }} @if(isset($distribute_template->custom_range) && in_array('register',json_decode($distribute_template['custom_range']))) checked @endif>
        <input type="checkbox" name="custom_range[]" value="product" title="产品" {{ $distribute_template->custom_range??old('custom_range') }} @if(isset($distribute_template->custom_range) && in_array('product',json_decode($distribute_template['custom_range']))) checked @endif>
    </div>
</div>



<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.channel.distributeTemplate')}}" >返 回</a>
    </div>
</div>