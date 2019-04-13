{{csrf_field()}}
{{--{{ dd(strpos($_SERVER['REQUEST_URI'],'edit')) }}--}}
<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>圈子类型</label>
    <div class="layui-input-inline">
        <select name="slug" lay-verify="my_slug">
            <option value="@if(strpos($_SERVER['REQUEST_URI'],'edit')) 0 @endif" @if(strpos($_SERVER['REQUEST_URI'],'edit')) disabled @endif>请选择</option>
            <option value="wechat_public" @if(isset($circle->slug)&&$circle->slug=='wechat_public')selected @endif @if(old('slug')=='wechat_public') selected @endif @if(in_array('wechat_public',$slug)) disabled @endif @if(strpos($_SERVER['REQUEST_URI'],'edit')) disabled @endif>微信公众号</option>
            <option value="wechat_person" @if(isset($circle->slug)&&$circle->slug=='wechat_person')selected @endif @if(old('slug')=='wechat_person') selected @endif @if(in_array('wechat_person',$slug)) disabled @endif @if(strpos($_SERVER['REQUEST_URI'],'edit')) disabled @endif>微信个人号</option>
            <option value="qq" @if(isset($circle->slug)&&$circle->slug=='qq')selected @endif @if(old('slug')=='qq') selected @endif @if(in_array('qq',$slug)) disabled @endif @if(strpos($_SERVER['REQUEST_URI'],'edit')) disabled @endif>QQ</option>

        </select>
    </div>
    <span style="line-height: 40px">一个类型只能有一个，一旦选择不能更改</span>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>二维码图片</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <span class="help">请上传1M以内的png、jpg格式的图片 建议尺寸：260*260px</span>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($circle->url))
                        <li><img src="{{ env('IMG_URL').$circle->url }}" /><p>上传成功</p></li>
                    @endif
                    @if(old('cover'))
                            <li><img src="{{ env('IMG_URL').old('url') }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="url" lay-verify="my_url"  id="url" value="{{ $circle->url??old('url') }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$circle->title??old('title')}}" lay-verify="my_title" placeholder="请输入标题 最多能输入8个字" class="layui-input" maxlength="8">
    </div>
</div>




<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>可复制内容</label>
    <div class="layui-input-block">
        <input type="text" name="copy_content" value="{{$circle->copy_content??old('copy_content')}}" lay-verify="my_copy_content" placeholder="请输入可复制内容 最多能输入16个字" class="layui-input" maxlength="16">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>描述</label>
    <div class="layui-input-block">
        <textarea name="intro" maxlength="50" placeholder="请输入描述 最多能输入50个字" lay-verify="my_intro" class="layui-textarea">{{$circle->intro??old('intro')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>排序</label>
    <div class="layui-input-block">
        <input type="text"  name="sort" value="{{$circle->sort??old('sort')}}" lay-verify="my_sort"  placeholder="请输入排序(-999 ~ 999)数字" class="layui-input" >
    </div>
</div>





<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.website.circle')}}" >返 回</a>
    </div>
</div>