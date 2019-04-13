<div class="layui-form-item">
    <label for="" class="layui-form-label">{{ $name }}</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="{{ $uploadid }}"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($url))
                        <li><img src="{{ $url }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="{{ $hidden_name }}" id="{{ $hidden_name }}" value="{{ $url??'' }}">
            </div>
        </div>
    </div>
</div>