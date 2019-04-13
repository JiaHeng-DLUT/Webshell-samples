{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">下载模板</label>
    <div class="layui-input-inline">
        <a href="/template/excel/phone.xls" class="layui-btn" >下载导入模板 </a>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>导入号码</label>
    <div class="layui-input-inline">
        <input type="hidden" name="path" value="">
        <button type="button" class="layui-btn" id="importPhone">
            <i class="layui-icon">&#xe67c;</i>上传Excel
        </button>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>导入方式</label>
    <div class="layui-input-block">
        <input type="radio" name="import_type" value="append" title="追加导入" checked>
        <input type="radio" name="import_type" value="cover" title="覆盖导入">
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="save">确定</button>
        <a href="{{route('admin.virtualPhone')}}" class="layui-btn"  >返 回</a>
    </div>
</div>


