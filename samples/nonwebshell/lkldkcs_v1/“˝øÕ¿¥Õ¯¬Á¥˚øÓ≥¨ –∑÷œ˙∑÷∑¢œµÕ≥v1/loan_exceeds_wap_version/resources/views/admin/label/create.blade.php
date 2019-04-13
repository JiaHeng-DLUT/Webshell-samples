@extends('admin.layouts.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-body">
        <form class="layui-form" action="javascript:void(0)">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label">标签名</label>
                <div class="layui-input-block">
                    <input type="text" name="name" maxlength="15" required  lay-verify="required" placeholder="请输入标签名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-block">
                    <input type="text" name="intro"   autocomplete="off" class="layui-input">
                </div>
            </div>


            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn" lay-submit lay-filter="save-label" >保存</button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    layui.use('form', function(){
        var form = layui.form;
        var index_open = parent.layer.getFrameIndex(window.name);

        //监听提交
        form.on('submit(save-label)', function(data){
            $.post("{{route('admin.label.store')}}",data.field,function (res) {
                if(res.code===0){
                    parent.localStorage.setItem('label_status','success');
                    parent.layer.close(index_open);
                }else {
                    layer.msg(res.msg,{icon:2});
                }
            }).error(function (data) {
                $.each(data.responseJSON.errors,function (key,value) {
                    layer.msg(value[0],{icon:2});
                    return false;
                })
            });
            return false;
        });
    });
</script>
@endsection
