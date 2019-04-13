@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        {{--<div class="layui-card-header layuiadmin-card-header-auto">--}}
        {{--<h2>添加字典</h2>--}}
        {{--</div>--}}
        <div class="layui-card-body">
            <form class="layui-form" action="javascript:void(0)">
                {{csrf_field()}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">字段名称:</label>
                    <div class="layui-input-inline">
                        @if($type == 1)
                            <label for="" class="layui-form-label" style="width: 100px">合作机构</label>
                        @else
                            <label for="" class="layui-form-label" style="width: 100px">友情链接</label>
                        @endif
                    </div>
                </div>

                <div class="layui-col-sm-3">
                    <label for="" class="layui-form-label">字段值:</label>
                </div>
                <div class="layui-col-sm-9" id="categorys">
                    <input type="hidden" name="type" value="{{$type}}">
                    @if($categories->count())
                        @foreach($categories as $category)
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <div class="layui-input-inline" style="width: 100px;">
                                        <input type="hidden" name="ids[]" value="{{$category->id}}">
                                        <input type="hidden" name="old[{{$category->id}}][type]" value="{{$type}}">
                                        <input type="hidden" name="old[{{$category->id}}][id]" value="{{$category->id}}">
                                        <input type="text" name="old[{{$category->id}}][name]" maxlength="{{$model->per_length}}"  value="{{$category->name}}" lay-verify="required|unique" class="layui-input category-item" placeholder="名称">
                                    </div>
                                    <div class="layui-input-inline" style="width: 160px;">
                                        <input type="radio" name="old[{{$category->id}}][redirect_type]" value="inside" title="内链" checked>
                                        <input type="radio" name="old[{{$category->id}}][redirect_type]" value="outside" title="外链" >
                                    </div>
                                    <div class="layui-input-inline" style="width: 150px;">
                                        <input type="text"  name="old[{{$category->id}}][url]" value="{{$category->url}}" lay-verify="required" class="layui-input" placeholder="链接地址">
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
                        <button type="submit" class="layui-btn" lay-submit lay-filter="save-category" >保存</button>
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

            if($('#categorys').find('.layui-form-item').length>=parseInt("{{$model->max_num}}")){
                $('#add').addClass('layui-btn-disabled');
            }
            $('#add').on('click',function () {
                if($('body').find('#add').hasClass('layui-btn-disabled')){
                    return false;
                }
                var htmlAppend='<div class="layui-form-item">\n'+
                    '                        <div class="layui-input-block">\n' +
                    '                          <input type="hidden" name="new['+index+'][type]" value="{{$type}}">\n'+
                    '                            <div class="layui-input-inline" style="width: 100px;">\n' +
                    '                                <input type="text" name="new['+index+'][name]" lay-verify="required|unique" class="layui-input category-item" placeholder="名称">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline" style="width: 160px;">\n'+
                    '                                 <input type="radio" name="new['+index+'][redirect_type]" value="inside" title="内链" checked>\n'+
                    '                                 <input type="radio" name="new['+index+'][redirect_type]" value="outside" title="外链" >\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline" style="width: 150px;">\n' +
                    '                                <input type="text" name= "new['+index+'][url]"   lay-verify="required" class="layui-input" placeholder="链接地址">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline">\n' +
                    '                                <a class="layui-btn layui-btn-danger layui-btn-sm del">删除</a>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>';
                $('#categorys').append(htmlAppend);
                index++;
                if($('#categorys').find('.layui-form-item').length>=parseInt("{{$model->max_num}}")){
                    $('#add').addClass('layui-btn-disabled');
                }else {
                    $('#add').removeClass('layui-btn-disabled');
                }
                form.render();
            });

            $('body').on('click','.del',function () {
                $(this).closest('.layui-form-item').remove();
                if($('#categorys').find('.layui-form-item').length<=parseInt("{{$model->max_num}}")){
                    $('#add').removeClass('layui-btn-disabled');
                }
            });
            form.verify({
                unique:function (value,item) {
                    var all=$(item).closest('.layui-form-item').prevAll();
                    var flag=0;
                    $.each(all,function (key,obj) {
                        if($(obj).find('.category-item').val()==value){
                            flag++;
                        }
                    });
                    if(flag>0){
                        return '名称不能重复';
                    }
                },
            });

            //监听提交
            form.on('submit(save-category)', function(data){
                $.post("{{route('admin.cooperation.store')}}",data.field,function (res) {
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
