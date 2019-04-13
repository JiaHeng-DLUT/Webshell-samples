{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>页面名称</label>
    <div class="layui-input-block">
        <input type="text" name="title" disabled value="{{$page->title??old('title')}}" lay-verify="required" class="layui-input" placeholder="请填写页面名称">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>页面标识</label>
    <div class="layui-input-block">
        <input type="text" name="slug" disabled value="{{$page->slug??old('slug')}}" lay-verify="required" class="layui-input" placeholder="请填写页面标识">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>排序值</label>
    <div class="layui-input-block">
        <input type="number" name="sort" min="-999" max="999" oninput="if(value.length>4)value=value.slice(0,4)" value="{{$page->sort??old('sort')}}" lay-verify="required|number|sort" class="layui-input" placeholder="请填写排序值">
    </div>
</div>

@include('vendor.ueditor.assets')
<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>内容</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain">
            {!! $page->content??old('content') !!}
        </script>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="save">保存</button>
        <a href="{{route('admin.page')}}" class="layui-btn"  >返 回</a>
    </div>
</div>


