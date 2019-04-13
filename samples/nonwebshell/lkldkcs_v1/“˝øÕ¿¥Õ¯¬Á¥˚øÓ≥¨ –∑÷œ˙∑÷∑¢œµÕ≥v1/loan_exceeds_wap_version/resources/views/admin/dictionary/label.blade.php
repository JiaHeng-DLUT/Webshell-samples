@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form" action="javascript:void(0)">
                {{csrf_field()}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">字段名称:</label>
                    <div class="layui-input-block">
                        <label for="" class="layui-form-label" style="width: 100px">贷款产品标签</label>
                    </div>
                </div>

                <div class="layui-col-sm-3">
                    <label for="" class="layui-form-label">字段值:</label>
                </div>
                <div class="layui-col-sm-9" id="labels">

                    @if($labels->count())
                        @foreach($labels as $label)
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <div class="layui-input-inline">
                                        <input type="hidden" name="ids[]" value="{{$label->id}}">
                                        <input type="hidden" name="old[{{$label->id}}][id]" value="{{$label->id}}">
                                        <input type="text" name="old[{{$label->id}}][name]" maxlength="{{$model->per_length}}" value="{{$label->name}}" lay-verify="required|unique" class="layui-input label-item" placeholder="字段值">
                                    </div>
                                    <div class="layui-input-inline">
                                        <select name="old[{{$label->id}}][color]" lay-verify="required">
                                            <option value="">请选择颜色</option>
                                            <option value="#FF5722" {{$label->color=='#FF5722'?'selected':''}} >红</option>
                                            <option value="#FFB800" {{$label->color=='#FFB800'?'selected':''}}>黄</option>
                                            <option value="#5FB878" {{$label->color=='#5FB878'?'selected':''}}>绿</option>
                                        </select>
                                    </div>
                                    <div class="layui-input-inline" style="width: 100px;">
                                        <input type="number" min="0" max="999" name="old[{{$label->id}}][sort]" value="{{$label->sort}}" lay-verify="required" class="layui-input" placeholder="字段排序">
                                    </div>
                                    <div class="layui-input-inline">
                                        <a class="layui-btn layui-btn-danger layui-btn-sm del">删除</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>


                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <a class="layui-btn" id="add"  >+</a>
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
            var index=0;

            if($('#labels').find('.layui-form-item').length>=parseInt("{{$model->max_num}}")){
                $('#add').addClass('layui-btn-disabled');
            }

            $('#add').on('click',function () {
                if($('body').find('#add').hasClass('layui-btn-disabled')){
                    return false;
                }
                var html='<div class="layui-form-item">\n' +
                    '                        <div class="layui-input-block">\n' +
                    '                            <div class="layui-input-inline">\n' +
                    '                                <input type="text" name="new['+index+'][name]" maxlength="{{$model->per_length}}" value="" lay-verify="required|unique" class="layui-input label-item" placeholder="字段值">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline">\n' +
                    '                                <select name="new['+index+'][color]" lay-verify="required">\n' +
                    '                                    <option value="">请选择颜色</option>\n' +
                    '                                    <option value="#FF5722">红</option>\n' +
                    '                                    <option value="#FFB800">黄</option>\n' +
                    '                                    <option value="#5FB878">绿</option>\n' +
                    '                                </select>\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline" style="width: 100px;">\n' +
                    '                                <input type="number" min="0" max="999" name="new['+index+'][sort]" value="0" lay-verify="required" class="layui-input" placeholder="字段排序">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline">\n' +
                    '                                <a class="layui-btn layui-btn-danger layui-btn-sm del">删除</a>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>';

                $('#labels').append(html);
                index++;
                if($('#labels').find('.layui-form-item').length>=parseInt("{{$model->max_num}}")){
                    $('#add').addClass('layui-btn-disabled');
                }else {
                    $('#add').removeClass('layui-btn-disabled');
                }
                form.render();
            });

            $('body').on('click','.del',function () {
                $(this).closest('.layui-form-item').remove();
                if($('#labels').find('.layui-form-item').length<=parseInt("{{$model->max_num}}")){
                    $('#add').removeClass('layui-btn-disabled');
                }
            });



            form.verify({
                unique:function (value,item) {
                    var all=$(item).closest('.layui-form-item').prevAll();
                    var flag=0;
                    $.each(all,function (key,obj) {
                        if($(obj).find('.label-item').val()==value){
                            flag++;
                        }
                    });
                    if(flag>0){
                        return '产品标签名称不能重复';
                    }
                },
            });

            //监听提交
            form.on('submit(save-label)', function(data){
                $.post("{{route('admin.product.label.store')}}",data.field,function (res) {
                    if(res.code===0){
                        parent.localStorage.setItem('dictionary_status','success');
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
