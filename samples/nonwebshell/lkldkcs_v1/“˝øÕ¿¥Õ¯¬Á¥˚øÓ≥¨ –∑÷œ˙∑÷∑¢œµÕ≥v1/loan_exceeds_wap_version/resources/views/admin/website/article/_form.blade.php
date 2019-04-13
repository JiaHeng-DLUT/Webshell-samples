{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>封面图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <span class="help">请上传1Mb以内，png、jpg的格式图片，建议尺寸：168*134px</span>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($article->cover))
                        <li><img src="{{ env('IMG_URL').$article->cover }}" /><p>上传成功</p></li>
                    @endif
                    @if(old('cover'))
                            <li><img src="{{ env('IMG_URL').old('cover') }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="cover" lay-verify="cover" id="cover" value="{{ $article->cover??old('cover') }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>发现标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" id="title" value="{{$article->title??old('title')}}" lay-verify="my_title" placeholder="请输入发现标题" class="layui-input" maxlength="30">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">发现角标</label>
    <div class="layui-input-inline">
        <select name="corner_id" >
            <option value="0">不设置角标</option>
            @foreach($corners as $corner)
                <option value="{{ $corner->id }}" @if(isset($article->corner_id)&&$article->corner_id==$corner->id)selected @endif @if(old('corner_id')==$corner->id) selected @endif>{{ $corner->name }}</option>

            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>发现分类</label>
    <div class="layui-input-inline">
        <select name="category_id" lay-verify="required">
            <option value="">请选择</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(isset($article->category_id)&&$article->category_id==$category->id)selected @endif @if(old('category_id')==$category->id) selected @endif >{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>阅读数基数</label>
    <div class="layui-input-block">
        <input type="number" min="0" max="99999" name="base_views" id="base_views" value="{{$article->base_views??old('base_views')}}" lay-verify="base_views" placeholder="请输入阅读数基数" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>摘要</label>
    <div class="layui-input-block">
        <textarea name="intro" placeholder="请输入摘要" id="my_intro" lay-verify="my_intro" class="layui-textarea" maxlength="50" onkeyup="words_deal();">{{$article->intro??old('intro')}}</textarea>
        <p class="text-count"><span id="textCount">{{ mb_strlen($article->intro)??0 }}</span>/50（最多50个字）</p>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">状态</label>
    <div class="layui-input-block">
        <input type="radio" name="status"   value="1" title="上架" {{ $article->status??old('status') }} @if(isset($article->status) && $article->status == 1) checked @endif checked>
        <input type="radio" name="status"   value="0" title="下架" {{ $article->status??old('status') }} @if(isset($article->status) && $article->status == 0) checked @endif>
    </div>
</div>


@include('vendor.ueditor.assets')
<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>内容</label>
    <div class="layui-input-block" >
        <script id="container" name="content" type="text/plain" style="height: 320px;">
            {!! $article->content??old('content') !!}
        </script>
    </div>
</div>





<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.website.article')}}" >返 回</a>
    </div>
</div>