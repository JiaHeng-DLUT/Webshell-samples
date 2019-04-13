{{csrf_field()}}


<input type="hidden" name="page_id" value="{{$id??old('page_id')}}">
<input type="hidden" name="template_id" value="{{$distributePage->template_id??old('template_id')}}">

@if(in_array('banner',$distributePage->custom_range))
    {{--列表页&专题页模板--}}
    <div class="layui-form-item">
        <label for="" class="layui-form-label">banner1</label>
        <div class="layui-input-block">
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="banner1"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                <span class="help">请上传2M以内的png、jpg格式的图片</span>
                <div class="layui-upload-list" >
                    <ul id="layui-upload-box1" class="layui-clear layui-upload-box1">
                        @if(isset($distributePageContent) && json_decode($distributePageContent->banners[0]) !=null && json_decode($distributePageContent->banners[0])[0]->url)
                            <li><img src="{{ env('IMG_URL').json_decode($distributePageContent->banners[0])[0]->url }}" /><p>上传成功</p></li>
                        @endif
                    </ul>
                    <input type="hidden" name="background1" id="background1"   value="{{ json_decode($distributePageContent->banners[0])[0]->url??'' }}">
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">跳转链接</label>
        <div class="layui-input-block">
            <input type="text" name="link1"  id="link1" value="{{ json_decode($distributePageContent->banners[0])[0]->redirect_url??'' }}"  placeholder="请跳转链接" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">banner2</label>
        <div class="layui-input-block">
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="banner2"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                <span class="help">请上传2M以内的png、jpg格式的图片</span>
                <div class="layui-upload-list" >
                    <ul id="layui-upload-box2" class="layui-clear layui-upload-box1">
                        @if(isset($distributePageContent) && json_decode($distributePageContent->banners[0]) !=null && json_decode($distributePageContent->banners[0])[1]->url)
                            <li><img src="{{ env('IMG_URL').json_decode($distributePageContent->banners[0])[1]->url }}" /><p>上传成功</p></li>
                        @endif
                    </ul>
                    <input type="hidden" name="background2" id="background2"   value="{{ json_decode($distributePageContent->banners[0])[1]->url??'' }}">
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">跳转链接</label>
        <div class="layui-input-block">
            <input type="text" name="link2" id="link2" value="{{ json_decode($distributePageContent->banners[0])[1]->redirect_url??'' }}"  placeholder="请跳转链接"  autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">banner3</label>
        <div class="layui-input-block">
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="banner3"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                <span class="help">请上传2M以内的png、jpg格式的图片</span>
                <div class="layui-upload-list" >
                    <ul id="layui-upload-box3" class="layui-clear layui-upload-box1">
                        @if(isset($distributePageContent) && json_decode($distributePageContent->banners[0]) !=null && json_decode($distributePageContent->banners[0])[2]->url)
                            <li><img src="{{ env('IMG_URL').json_decode($distributePageContent->banners[0])[2]->url }}" /><p>上传成功</p></li>
                        @endif
                    </ul>
                    <input type="hidden" name="background3" id="background3"   value="{{ json_decode($distributePageContent->banners[0])[2]->url??'' }}">
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">跳转链接</label>
        <div class="layui-input-block">
            <input type="text" name="link3" id="link3" value="{{ json_decode($distributePageContent->banners[0])[2]->redirect_url??'' }}"  placeholder="请跳转链接" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item" >
        <label class="layui-form-label">展示的产品</label>
        <div class="layui-input-block">
            <dl class="cate-box">
                @if(count($products))
                <dt>
                    <input type="checkbox" name="" id="allChoose" title="全选（以下都是上架产品）" lay-skin="primary" lay-filter="allChoose">
                </dt>
                <dd>
                        @foreach($products as $product)
                            <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" title="{{ $product->name }}" lay-skin="primary" lay-filter="isAll" class="product_ids" @if( json_decode($distributePageContent->product_ids) != null  && in_array($product->id,json_decode($distributePageContent->product_ids)))checked @endif>
                        @endforeach
                </dd>
                @else
                    没有上架产品
                @endif
            </dl>

        </div>
    </div>

@elseif($distributePage->template_id ==2)
    {{--主页模板--}}
@elseif(in_array('register',$distributePage->custom_range))
    {{--注册页模板(跳转到下载页)--}}
    <div class="layui-form-item">
        <label for="" class="layui-form-label">背景图设置</label>
        <div class="layui-input-block">
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="banner"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                <span class="help">请上传2M以内的png、jpg格式的图片</span>
                <div class="layui-upload-list" >
                    <ul id="layui-upload-box1" class="layui-clear layui-upload-box1">
                        @if(isset($distributePageContent->register_img_url) && $distributePageContent->register_img_url)
                            <li><img src="{{ env('IMG_URL').$distributePageContent->register_img_url }}" /><p>上传成功</p></li>
                        @endif
                    </ul>
                    <input type="hidden" name="background" id="background" lay-verify="my_banner"  value="{{ $distributePageContent->register_img_url??'' }}">
                </div>
            </div>
        </div>
    </div>
    @if($distributePage->template_id == 14)
        <div class="layui-form-item" id="redirect_type" >
            <label for="" class="layui-form-label">跳转配置</label>
            <div class="layui-input-block">
                <input type="radio" name="redirect_type" value="information_page" title="跳信息页面"
                       @if($distributePage->redirect_type == 'information_page') checked @endif>
                <input type="radio" name="redirect_type" value="download_page" title="跳下载"  @if($distributePage->redirect_type == 'download_page') checked @endif>
            </div>
        </div>
    @endif
@elseif(in_array('product',$distributePage->custom_range))
    {{--产品详情页模板--}}
    <div class="layui-form-item">
        <label class="layui-form-label" style="width: 110px;">选择展示产品</label>
        <div class="layui-input-block">
            @if(count($products))
                @foreach($products as $k => $product)
                    <input type="radio" name="product_ids"  value="{{ $product->id }}" title="{{ $product->name }}" @if($k == 0) checked @endif>
                @endforeach
            @endif
        </div>
    </div>
@elseif($distributePage->template_id ==5)
    {{--手机号激活模板--}}
@elseif($distributePage->template_id ==6)
    {{--下载模板-新用户秒过--}}
@elseif($distributePage->template_id ==7)
    {{--下载模板-无门槛急速借款--}}
@elseif($distributePage->template_id ==8)
    {{--注册页模板(跳转到首页)--}}
@elseif($distributePage->template_id ==9)
    {{--信息流注册模板(跳转到下载)--}}
@elseif($distributePage->template_id ==10)
    {{--信息流注册模板(跳转到首页)--}}
@endif



<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.channel.distribute',['id'=>$channel->id])}}" >返 回</a>
    </div>
</div>