{{csrf_field()}}
<style>
    .layui-upload-box1 li{
        width: 120px;
        height: 100px;
        float: left;
        position: relative;
        overflow: hidden;
        margin-right: 10px;
        border:1px solid #ddd;
    }
    .layui-upload-box1 li img{
        width: 100%;
    }
    .layui-upload-box1 li p{
        width: 100%;
        height: 22px;
        font-size: 12px;
        position: absolute;
        left: 0;
        bottom: 0;
        line-height: 22px;
        text-align: center;
        color: #fff;
        background-color: #333;
        opacity: 0.6;
    }
    .layui-upload-box1 li i{
        display: block;
        width: 20px;
        height:20px;
        position: absolute;
        text-align: center;
        top: 2px;
        right:2px;
        z-index:999;
        cursor: pointer;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
    input[type="number"]{
        -moz-appearance: textfield;
    }

</style>


<input type="hidden" name="app_id" value="{{$app['id']??''}}">
<div class="layui-form-item">
    <label for="" class="layui-form-label" ><strong class="item-required">*</strong>名称</label>
    <div class="layui-input-block">
        <input type="text"  name="name" id="name" maxlength="10" value="{{$app['name']??old('name')}}" lay-verify="my_name" placeholder="请输入名称" class="layui-input" >
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label" ><strong class="item-required">*</strong>包名</label>
    <div class="layui-input-block">
        <input type="text"  name="package_name" maxlength="30" id="package_name" value="{{$app['package_name']??old('package_name')}}" lay-verify="my_package_name" placeholder="请输入包名" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>上传图片</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="logo"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <span class="help">请上传2M以内的png、jpg格式的图片</span>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box1" class="layui-clear layui-upload-box1">
                    @if(isset($app['logo']) && $app['logo'] != '')
                        <li><img src="{{ env('IMG_URL').$app['logo'] }}" /><p>上传成功</p></li>
                    @endif
                    @if(old('logo'))
                        <li><img src="{{ env('IMG_URL').old('logo') }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="logo" id="uplogo" lay-verify="my_logo"  value="{{ $app['logo']??old('logo') }}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>上传apk</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="apk">选择apk文件</button> 文件名称: <span id="fileName"></span>
            <button type="button" class="layui-btn" id="apk1"><i class="layui-icon">&#xe67c;</i>确认上传</button>
            <div class="layui-progress layui-progress-big" lay-showPercent="yes" lay-filter="progressBar" style="margin-top: 10px">
                <div class="layui-progress-bar layui-bg-red" lay-percent="0%"></div>
            </div>
            <span>已存在的文件路径：{{ $app['download_url']??old('download_url') }}</span>
            <input type="hidden" name="download_url" id="download_url" lay-verify="my_download_url" value="{{$app['download_url']??old('download_url')}}">

        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label" ><strong class="item-required">*</strong>版本</label>
    <div class="layui-input-inline">
        <input type="number" min="0" max="99" name="version1"  value="{{ $app['version'][0]??old('version1') }}" lay-verify="my_version" placeholder="" class="layui-input my_input_number" style="width: 190px;">

    </div>

    <div class="layui-input-inline">
        <input type="number" min="0" max="99"  name="version2" value="{{ $app['version'][1]??old('version2') }}" lay-verify="my_version" placeholder="" class="layui-input " style="width: 190px;">

    </div>
    <div class="layui-input-inline">
        <input type="number" min="0" max="99"  name="version3"  value="{{ $app['version'][2]??old('version3') }}" lay-verify="my_version" placeholder="" class="layui-input " style="width: 190px;">

    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">更新日志</label>
    <div class="layui-input-block">
        <textarea name="update_log" id="update_log" maxlength="200" placeholder="请输入更新日志"  class="layui-textarea">{{$app['update_log']??old('update_log')}}</textarea>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.channel.distribute',['id'=>$id])}}" >返 回</a>
    </div>
</div>