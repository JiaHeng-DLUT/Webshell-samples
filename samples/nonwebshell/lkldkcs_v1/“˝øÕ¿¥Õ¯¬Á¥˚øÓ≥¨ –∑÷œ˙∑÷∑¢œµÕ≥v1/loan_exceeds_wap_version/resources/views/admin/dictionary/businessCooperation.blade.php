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
                        <label for="" class="layui-form-label" style="width: 100px">商务合作</label>
                    </div>
                </div>

                <div class="layui-col-sm-3">
                    <label for="" class="layui-form-label">字段值:</label>
                </div>
                <div class="layui-col-sm-9" id="categorys">

                    @if($categories->count())
                        @foreach($categories as $category)
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <div class="layui-input-inline" style="width: 80px;">
                                        <input type="text" name="old[{{$category->id}}][department]"  value="{{$category->department}}" lay-verify="required" class="layui-input category-item" placeholder="部门">
                                    </div>
                                    <div class="layui-input-inline" style="width: 80px;">
                                        <input type="hidden" name="ids[]" value="{{$category->id}}">
                                        <input type="hidden" name="old[{{$category->id}}][id]" value="{{$category->id}}">
                                        <input type="text" name="old[{{$category->id}}][name]" maxlength="{{$model->per_length}}"  value="{{$category->name}}" lay-verify="required|unique" class="layui-input category-item" placeholder="联系人">
                                    </div>

                                    <div class="layui-input-inline" style="width: 100px;">
                                        <input type="text"  name="old[{{$category->id}}][phone]" value="{{$category->phone}}" lay-verify="required" class="layui-input" placeholder="手机号码">
                                    </div>
                                    <div class="layui-input-inline" style="width: 150px;">
                                        <input type="text"  name="old[{{$category->id}}][email]" value="{{$category->email}}" lay-verify="required" class="layui-input" placeholder="邮件">
                                    </div>
                                    <div class="layui-input-inline" style="width: 180px;">
                                        <input type="text" name="old[{{$category->id}}][quantum_time]" value="{{$category->quantum_time}}" lay-verify="required" class="layui-input" placeholder="工作时间">
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
                var html='<div class="layui-form-item">\n'+
                    '                        <div class="layui-input-block">\n' +
                    '                            <div class="layui-input-inline" style="width: 80px;">\n' +
                    '                                <input type="text" name="new['+index+'][department]" lay-verify="required" class="layui-input" placeholder="部门">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline" style="width: 80px;">\n' +
                    '                                <input type="text" name="new['+index+'][name]" lay-verify="required|unique" class="layui-input category-item" placeholder="联系人">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline" style="width: 100px;">\n' +
                    '                                <input type="text" name= "new['+index+'][phone]"   lay-verify="required" class="layui-input" placeholder="手机号码">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline" style="width: 150px;">\n' +
                    '                                <input type="text" name="new['+index+'][email]"  lay-verify="required" class="layui-input" placeholder="邮箱">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline" style="width: 180px;">\n' +
                    '                                <input type="text"name="new['+index+'][quantum_time]"  lay-verify="required" class="layui-input" placeholder="工作时间">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline">\n' +
                    '                                <a class="layui-btn layui-btn-danger layui-btn-sm del">删除</a>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>';
                $('#categorys').append(html);
                index++;
                if($('#categorys').find('.layui-form-item').length>=parseInt("{{$model->max_num}}")){
                    $('#add').addClass('layui-btn-disabled');
                }else {
                    $('#add').removeClass('layui-btn-disabled');
                }
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
                $.post("{{route('admin.business.cooperation.store')}}",data.field,function (res) {
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
