@extends('admin.layouts.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-body">
        <form class="layui-form" action="javascript:void(0)">
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$remind?$remind->id:''}}">
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">短信提示</label>
                <div class="layui-input-block">
                    <textarea name="phones" id="phones" lay-verify="required" placeholder='请输入手机号，多个用";"符号分开' class="layui-textarea">{{$remind?$remind->phones:''}}</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn" lay-submit lay-filter="save-phone" >保存</button>
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

        // form.verify({
        //     unique:function (value,item) {
        //         var all=$(item).closest('.layui-form-item').prevAll();
        //         var flag=0;
        //         $.each(all,function (key,obj) {
        //             if($(obj).find('.bank-item').val()==value){
        //                 flag++;
        //             }
        //         });
        //         if(flag>0){
        //             return '发卡行名称不能重复';
        //         }
        //     },
        // });

        //监听提交
        form.on('submit(save-phone)', function(data){
            $.post("{{route('admin.warn.phoneStore')}}",data.field,function (res) {
                if(res.code===0){
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
