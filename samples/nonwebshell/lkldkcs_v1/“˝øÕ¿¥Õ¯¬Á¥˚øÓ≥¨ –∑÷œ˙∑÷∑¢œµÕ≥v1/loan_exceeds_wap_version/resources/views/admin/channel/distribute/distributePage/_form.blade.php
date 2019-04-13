{{csrf_field()}}

<input type="hidden" name="channel_code" value="{{$channel['channel_code']??''}}">
<div class="layui-form-item">
    <label for="" class="layui-form-label">分发页模板</label>
    <div class="layui-input-inline">
        <select name="distributeTemplate_id" lay-filter="redirect_type">
            @if(count($distributeTemplates))
                @foreach($distributeTemplates as $distributeTemplate)
                    <option value="{{ $distributeTemplate->id }}" @if(old('distributeTemplate_id')==$distributeTemplate->id) selected @endif data="{{$distributeTemplate->name}}">{{ $distributeTemplate->name }}</option>
                @endforeach
            @endif
                {{--{{$distributeTemplate->name}}--}}
        </select>
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>分发页名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" id="name" maxlength="15" value="{{old('name')}}" lay-verify="my_name" placeholder="请输入分发页名称" class="layui-input" style="width: 190px">
    </div>
</div>
<div class="layui-form-item" id="redirect_type" style="display: none;">
    <label for="" class="layui-form-label">去向</label>
    <div class="layui-input-block">
        <input type="radio" name="redirect_type" value="information_page" title="跳信息页面"
               @if(old('redirect_type')== 'information_page') checked @elseif(old('redirect_type') != 'information_page')  checked @endif>
        <input type="radio" name="redirect_type" value="download_page" title="跳下载" @if(old('redirect_type')== 'information_page') checked @endif>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">扣量模式</label>
    <div class="layui-input-inline">
        <select name="reduce_type" >
            <option value="apply_register" @if(old('reduce_type')=='apply_register') selected @endif>按正常申请注册比扣量</option>
            <option value="register" @if(old('reduce_type')=='register') selected @endif>按比例扣量</option>
        </select>
    </div>
    <span>一旦设定不能更改</span>
</div>

{{--@if($id ==1)
    --}}{{--列表页&专题页模板--}}{{--
@elseif($id ==2)
    --}}{{--主页模板--}}{{--
@elseif($id ==3)
    --}}{{--注册页模板(跳转到下载页)--}}{{--
@elseif($id ==4)
    --}}{{--产品详情页模板--}}{{--
@elseif($id ==5)
    --}}{{--手机号激活模板--}}{{--
@elseif($id ==6)
    --}}{{--下载模板-新用户秒过--}}{{--
@elseif($id ==7)
    --}}{{--下载模板-无门槛急速借款--}}{{--
@elseif($id ==8)
    --}}{{--注册页模板(跳转到首页)--}}{{--
@elseif($id ==9)
    --}}{{--信息流注册模板(跳转到下载)--}}{{--
@elseif($id ==10)
    --}}{{--信息流注册模板(跳转到首页)--}}{{--
@endif--}}



<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.channel.distribute',['id'=>$id])}}" >返 回</a>
    </div>
</div>