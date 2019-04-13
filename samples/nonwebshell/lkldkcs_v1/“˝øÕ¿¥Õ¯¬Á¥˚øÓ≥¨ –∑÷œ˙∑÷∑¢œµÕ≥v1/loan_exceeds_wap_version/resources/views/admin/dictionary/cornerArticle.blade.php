@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form" action="javascript:void(0)">
                {{csrf_field()}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">字段名称:</label>
                    <div class="layui-input-inline">
                        <label for="" class="layui-form-label">文章角标</label>
                    </div>
                </div>

                <div class="layui-col-sm-3">
                    <label for="" class="layui-form-label">字段值:</label>
                </div>
                <div class="layui-col-sm-9" id="corners">

                    @if($corners->count())
                        @foreach($corners as $corner)
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <div class="layui-input-inline">
                                        <button type="button" class="layui-btn upload" id="upload_old_{{$corner->id}}">上传图片</button>
                                        <div class="layui-upload-list">
                                            <img class="layui-upload-img" id="old[{{$corner->id}}][img]" style="width: 64px;height: 64px" @if($corner->url) src="{{iAsset($corner->url)}}" @endif>
                                            <input type="hidden" name="old[{{$corner->id}}][url]" id="old[{{$corner->id}}][url]" lay-verify="corner_url" value="{{$corner->url}}">
                                        </div>
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="hidden" name="ids[]" value="{{$corner->id}}">
                                        <input type="hidden" name="old[{{$corner->id}}][id]" value="{{$corner->id}}">
                                        <input type="hidden" name="old[{{$corner->id}}][type]" value="article">
                                        <input type="text" name="old[{{$corner->id}}][name]" maxlength="{{$model->per_length}}" value="{{$corner->name}}" lay-verify="required|unique" class="layui-input corner-item" placeholder="字段值">
                                    </div>
                                    <div class="layui-input-inline" style="width: 100px;">
                                        <input type="number" min="0" max="999" name="old[{{$corner->id}}][sort]" value="{{$corner->sort}}" lay-verify="required" class="layui-input" placeholder="字段排序">
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
                        <button type="submit" class="layui-btn" lay-submit lay-filter="save-corner" >保存</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['form','upload'], function(){
            var form = layui.form;
            var upload=layui.upload;
            var index_open = parent.layer.getFrameIndex(window.name);
            var index=0;

            if($('#corners').find('.layui-form-item').length>=parseInt("{{$model->max_num}}")){
                $('#add').addClass('layui-btn-disabled');
            }

            $('#add').on('click',function () {
                if($('body').find('#add').hasClass('layui-btn-disabled')){
                    return false;
                }
                var html='<div class="layui-form-item">\n'+
                    '                        <div class="layui-input-block">\n' +
                    '<div class="layui-input-inline">\n' +
                    '                                        <button type="button" class="layui-btn upload" id="upload_new_'+index+'">上传图片</button>\n' +
                    '                                        <div class="layui-upload-list">\n' +
                    '                                            <img class="layui-upload-img" id="new['+index+'][img]" style="width: 64px;height: 64px" >\n' +
                    '                                            <input type="hidden" lay-verify="corner_url" name="new['+index+'][url]" id="new['+index+'][url]" value="">\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n'+
                    '                            <div class="layui-input-inline">\n' +
                    '                                <input type="hidden"  name="new['+index+'][type]"  value="article">\n' +
                    '                                <input type="text"  name="new['+index+'][name]" maxlength="{{$model->per_length}}" value="" lay-verify="required|unique" class="layui-input corner-item" placeholder="字段值">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline" style="width: 100px;">\n' +
                    '                                <input type="number" min="0" max="999" name="new['+index+'][sort]" value="0" lay-verify="required" class="layui-input" placeholder="字段排序">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-input-inline">\n' +
                    '                                <a class="layui-btn layui-btn-danger layui-btn-sm del">删除</a>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>';
                $('#corners').append(html);
                uploadCorner('#upload_new_'+index);
                index++;
                if($('#corners').find('.layui-form-item').length>=parseInt("{{$model->max_num}}")){
                    $('#add').addClass('layui-btn-disabled');
                }else {
                    $('#add').removeClass('layui-btn-disabled');
                }
            });

            $('body').on('click','.del',function () {
                $(this).closest('.layui-form-item').remove();
                if($('#corners').find('.layui-form-item').length<=parseInt("{{$model->max_num}}")){
                    $('#add').removeClass('layui-btn-disabled');
                }
            });



            form.verify({
                unique:function (value,item) {
                    var all=$(item).closest('.layui-form-item').prevAll();
                    var flag=0;
                    $.each(all,function (key,obj) {
                       if($(obj).find('.corner-item').val()==value){
                           flag++;
                       }
                    });
                    if(flag>0){
                        return '文章角标名称不能重复';
                    }
                },
                corner_url:function (value,item) {
                    if(!value){
                        return '请上传角标图片';
                    }
                }
            });

            //监听提交
            form.on('submit(save-corner)', function(data){
                $.post("{{route('admin.article.corner.store')}}",data.field,function (res) {
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


            @if($corners->count())
                @foreach($corners as $corner)
                    var id='#upload_old_'+"{{$corner->id}}";
                    uploadCorner(id);
                @endforeach
            @endif

            function uploadCorner(id) {
                var uploadInst = upload.render({
                    elem: id
                    ,url: '/uploadImage'
                    ,size:1024
                    ,data:{"_token":"{{ csrf_token() }}"}
                    ,before: function(obj){
                        var subject=this.item.closest('div');
                        obj.preview(function(index, file, result){
                            subject.find('img').attr('src',result);
                        });
                    }
                    ,done: function(res){
                        var subject=this.item.closest('div');
                        if(res.code === 0){
                            subject.find('input[type="hidden"]').val(res.url);
                        }else {
                            return layer.msg('上传失败');
                        }
                    }
                    ,error: function(){
                        //演示失败状态，并实现重传
                        demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                        demoText.find('.demo-reload').on('click', function(){
                            uploadInst.upload();
                        });
                    }
                });
            }

        });
    </script>
@endsection
