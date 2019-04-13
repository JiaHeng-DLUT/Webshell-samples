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
                        <label for="" class="layui-form-label">发卡行</label>
                    </div>
                </div>

                <div class="layui-col-sm-3">
                    <label for="" class="layui-form-label">字段值:</label>
                </div>
                <div class="layui-col-sm-9" id="banks">

                    @if($banks->count())
                        @foreach($banks as $bank)
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <div class="layui-input-inline">
                                        <input type="hidden" name="ids[]" value="{{$bank->id}}">
                                        <input type="hidden" name="old[{{$bank->id}}][id]" value="{{$bank->id}}">
                                        <input type="text" name="old[{{$bank->id}}][name]" maxlength="{{$model->per_length}}" value="{{$bank->name}}" lay-verify="required|unique" class="layui-input bank-item" placeholder="字段值">
                                    </div>
                                    <div class="layui-input-inline" style="width: 100px;">
                                        <input type="number" min="0" max="999" name="old[{{$bank->id}}][sort]" value="{{$bank->sort}}" lay-verify="required" class="layui-input" placeholder="字段排序">
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
                        <button type="submit" class="layui-btn" lay-submit lay-filter="save-bank" >保存</button>
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

            if($('#banks').find('.layui-form-item').length>=parseInt("{{$model->max_num}}")){
                $('#add').addClass('layui-btn-disabled');
            }

            $('#add').on('click',function () {
                if($('body').find('#add').hasClass('layui-btn-disabled')){
                    return false;
                }
                var html='<div class="layui-form-item">\n'+
                    '                        <div class="layui-input-block">\n' +
                    '                            <div class="layui-input-inline">\n' +
                    '                                <input type="text"  name="new['+index+'][name]" maxlength="{{$model->per_length}}" value="" lay-verify="required|unique" class="layui-input bank-item" placeholder="字段值">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline" style="width: 100px;">\n' +
                    '                                <input type="number" min="0" max="999" name="new['+index+'][sort]" value="0" lay-verify="required" class="layui-input" placeholder="字段排序">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline">\n' +
                    '                                <a class="layui-btn layui-btn-danger layui-btn-sm del">删除</a>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>';
                $('#banks').append(html);
                index++;
                if($('#banks').find('.layui-form-item').length>=parseInt("{{$model->max_num}}")){
                    $('#add').addClass('layui-btn-disabled');
                }else {
                    $('#add').removeClass('layui-btn-disabled');
                }
            });

            $('body').on('click','.del',function () {
                $(this).closest('.layui-form-item').remove();
                if($('#banks').find('.layui-form-item').length<=parseInt("{{$model->max_num}}")){
                    $('#add').removeClass('layui-btn-disabled');
                }
            });



            form.verify({
                unique:function (value,item) {
                    var all=$(item).closest('.layui-form-item').prevAll();
                    var flag=0;
                    $.each(all,function (key,obj) {
                       if($(obj).find('.bank-item').val()==value){
                           flag++;
                       }
                    });
                    if(flag>0){
                        return '发卡行名称不能重复';
                    }
                },
            });

            //监听提交
            form.on('submit(save-bank)', function(data){
                $.post("{{route('admin.credit.bank.store')}}",data.field,function (res) {
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
