{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>类目名称</label>
    <div class="layui-input-inline">
        <input type="text" name="name" maxlength="5" value="{{$productCategory->name??old('name')}}" lay-verify="required" class="layui-input" placeholder="请填写栏目名称">
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>排序值</label>
    <div class="layui-input-inline">
        <input type="number" name="sort" oninput="if(value.length>4)value=value.slice(0,4)" value="{{$productCategory->sort??old('sort',0)}}" lay-verify="required|number|sort" class="layui-input" placeholder="请填写排序值">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>类目icon</label>
    <div class="layui-input-inline">
        <button type="button" class="layui-btn" id="icon">上传图片</button>
        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm"  id="iconRemove">移除</button>
        <div class="layui-upload-list">
            <img class="layui-upload-img" id="iconImg" style="width: 100px;height: 100px;@if(!$productCategory->icon)display: none;@endif" @if($productCategory->icon) src="{{iAsset($productCategory->icon)}}" @endif>
            <input type="hidden" name="icon" value="{{$productCategory->icon}}" lay-verify="icon">
            <p id="iconText"></p>
        </div>
        <span>建议尺寸 : 100*100</span>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>APP_banner</label>
    <div class="layui-input-inline">
        <button type="button" class="layui-btn" id="banner">上传图片</button>
        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm"  id="bannerRemove">移除</button>
        <div class="layui-upload-list">
            <img class="layui-upload-img" id="bannerImg" style="width: 750px;height: 150px;@if(!$productCategory->banner)display: none;@endif" @if($productCategory->banner) src="{{iAsset($productCategory->banner)}}" @endif>
            <input type="hidden" name="banner" value="{{$productCategory->banner}}" lay-verify="banner">
            <p id="bannerText"></p>
        </div>
        <span>建议尺寸 : 750*150</span>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>PC_banner</label>
    <div class="layui-input-inline">
        <button type="button" class="layui-btn" id="pc_banner">上传图片</button>
        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm"  id="pc_bannerRemove">移除</button>
        <div class="layui-upload-list">
            <img class="layui-upload-img" id="pc_bannerImg" style="width: 750px;height: 150px;@if(!$productCategory->banner)display: none;@endif" @if($productCategory->pc_banner) src="{{iAsset($productCategory->pc_banner)}}" @endif>
            <input type="hidden" name="pc_banner" value="{{$productCategory->pc_banner}}" lay-verify="pc_banner">
            <p id="bannerText"></p>
        </div>
        <span>建议尺寸 : </span>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">跳转类型</label>
    <div class="layui-input-block">
        <input type="radio" name="redirect_type" value="" title="不跳转" lay-filter="redirect_type" {{$productCategory->redirect_type?'':'checked'}}>
        <input type="radio" name="redirect_type" value="inside" title="内部跳转" lay-filter="redirect_type" {{$productCategory->redirect_type=='inside'?'checked':''}}>
        <input type="radio" name="redirect_type" value="outside" title="外部跳转" lay-filter="redirect_type" {{$productCategory->redirect_type=='outside'?'checked':''}}>
    </div>
</div>

<div class="layui-form-item" {{$productCategory->redirect_type?'':'hidden'}} id="redirect_to">
    <label for="" class="layui-form-label">banner跳转</label>
    <div id="outside" class="layui-input-block" {{$productCategory->redirect_type=='outside'?'':'hidden'}}>
        <input type="text" name="banner_redirect" value="{{$productCategory->banner_redirect??old('banner_redirect')}}"  class="layui-input" placeholder="">
    </div>
    <div id="inside" class="layui-input-block" {{$productCategory->redirect_type=='inside'?'':'hidden'}}>

        <div class="layui-inline">
            <div class="layui-input-block" style="margin-left:0">
                <select name="redirect_slug" id="redirect_slug" lay-filter="redirect_slug">
                    <option value="" {{$productCategory->redirect_slug==''?'selected':''}}>请选择页面类型</option>
                    <option value="product" {{$productCategory->redirect_slug=='product'?'selected':''}}>贷款产品</option>
                    <option value="credit" {{$productCategory->redirect_slug=='credit'?'selected':''}}>信用卡</option>
                    <option value="article" {{$productCategory->redirect_slug=='article'?'selected':''}}>资讯</option>
                    <option value="help" {{$productCategory->redirect_slug=='help'?'selected':''}}>新手帮助</option>
                    <option value="about" {{$productCategory->redirect_slug=='about'?'selected':''}}>关于我们</option>
                </select>
            </div>
        </div>

        <div class="layui-inline" id="list">

            <div class="layui-input-block" style="margin-left:0" id="product_list" {{$productCategory->redirect_slug=='product'?'':'hidden'}}>
                <select name="{{$productCategory->redirect_slug=='product'?'redirect_id':''}}">
                    <option value="0" {{$productCategory->redirect_id=='0'?'selected':''}}>列表</option>
                    <optgroup label="产品详情">
                        @php
                            $products=\App\Models\Product::select('id','name')->where(['status'=>1])->orderBy('sort','desc')->get();
                        @endphp
                        @if($products->count())
                            @foreach($products as $product)
                                <option value="{{$product->id}}" {{$productCategory->redirect_id==$product->id?'selected':''}}>{{$product->name}}</option>
                            @endforeach
                        @endif
                    </optgroup>
                </select>
            </div>

            <div class="layui-input-block" style="margin-left:0" id="credit_list" {{$productCategory->redirect_slug=='credit'?'':'hidden'}}>
                <select name="{{$productCategory->redirect_slug=='credit'?'redirect_id':''}}">
                    <option value="0">列表</option>
                    <optgroup label="信用卡详情">
                        @php
                            $credits=\App\Models\Credit::select('id','name')->where(['status'=>1])->orderBy('sort','desc')->get();
                        @endphp
                        @if($credits->count())
                            @foreach($credits as $credit)
                                <option value="{{$credit->id}}">{{$credit->name}}</option>
                            @endforeach
                        @endif
                    </optgroup>
                </select>
            </div>

            <div class="layui-input-block" style="margin-left:0" id="article_list" {{$productCategory->redirect_slug=='article'?'':'hidden'}}>
                <select name="{{$productCategory->redirect_slug=='article'?'redirect_id':''}}">
                    <option value="0">列表</option>
                    <optgroup label="资讯详情">
                        @php
                            $articles=\App\Models\Article::select('id','title')->where(['status'=>1])->orderBy('id','desc')->get();
                        @endphp
                        @if($articles->count())
                            @foreach($articles as $article)
                                <option value="{{$article->id}}">{{$article->title}}</option>
                            @endforeach
                        @endif
                    </optgroup>
                </select>
            </div>

        </div>

    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="save">保存</button>
        <a href="{{route('admin.productCategory')}}" class="layui-btn"  >返 回</a>
    </div>
</div>


