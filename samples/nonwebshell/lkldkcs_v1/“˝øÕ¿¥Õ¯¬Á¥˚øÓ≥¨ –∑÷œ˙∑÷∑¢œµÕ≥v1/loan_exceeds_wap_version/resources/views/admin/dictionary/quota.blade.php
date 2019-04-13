@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form" action="javascript:void(0)">
                {{csrf_field()}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">字段名称:</label>
                    <div class="layui-input-block">
                        <label for="" class="layui-form-label" style="width: 150px">贷款金额筛选区间</label>
                    </div>
                </div>

                <div class="layui-col-sm-3">
                    <label for="" class="layui-form-label">字段值:</label>
                </div>
                <div class="layui-col-sm-9" id="quotas">


                    {{--<div class="layui-form-item">--}}
                        {{--<div class="layui-input-block">--}}
                            {{--<div class="layui-inline">--}}
                                {{--<select name="old[][type]" lay-filter="item-type-old" data-index="" class="range-type" lay-verify="required">--}}
                                    {{--<option value="">请选择区间类型</option>--}}
                                    {{--<option value="1"  >value <=</option>--}}
                                    {{--<option value="2"  ><= value <=</option>--}}
                                    {{--<option value="3" >value >=</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}

                            {{--<div class="layui-inline range-input">--}}
                                {{--<div class="layui-input-inline" style="width: 100px;">--}}
                                    {{--<input type="text" name="old[][min]" placeholder="￥:前值" autocomplete="off" class="layui-input">--}}
                                {{--</div>--}}
                                {{--<div class="layui-form-mid">~</div>--}}
                                {{--<div class="layui-input-inline" style="width: 100px;">--}}
                                    {{--<input type="text" name="old[][max]" placeholder="￥:后值" autocomplete="off" class="layui-input">--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="layui-inline">--}}
                                {{--<select name="old[][unit]" lay-verify="required">--}}
                                    {{--<option value="">请选择单位</option>--}}
                                    {{--<option value="yuan"  >元</option>--}}
                                    {{--<option value="wan"  >万元</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="layui-inline" style="width: 100px;">--}}
                                {{--<input type="number" min="0" max="999" name="old[][sort]" value="0" lay-verify="required" class="layui-input" placeholder="字段排序">--}}
                            {{--</div>--}}
                            {{--<div class="layui-inline">--}}
                                {{--<a class="layui-btn layui-btn-danger layui-btn-sm del">删除</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}



                    @if($quotas->count())
                        @foreach($quotas as $quota)
                            <div class="layui-form-item">
                                <input type="hidden" name="ids[]" value="{{$quota->id}}">
                                <input type="hidden" name="old[{{$quota->id}}][id]" value="{{$quota->id}}">
                                <div class="layui-input-block">
                                    <div class="layui-inline">
                                        <select name="old[{{$quota->id}}][type]" lay-filter="item-type-old" data-type="{{$quota->type}}" data-index="{{$quota->id}}" class="range-type old-item quota-type" lay-verify="required">
                                            <option value="">请选择区间类型</option>
                                            <option value="1" {{$quota->type=='1'?'selected':''}} >value <=</option>
                                            <option value="2" {{$quota->type=='2'?'selected':''}}><= value <=</option>
                                            <option value="3" {{$quota->type=='3'?'selected':''}}>value >=</option>
                                        </select>
                                    </div>
                                    <div class="layui-inline range-input">
                                        @if($quota->type==2)
                                            <div class="layui-input-inline model-range" style="width: 100px;">
                                                <input type="number" name="old[{{$quota->id}}][min]" oninput="if(value.length>5)value=value.slice(0,5)" value="{{$quota->min}}"  placeholder="￥:前值" autocomplete="off" class="layui-input quota-min" lay-verify="required|unique">
                                            </div>
                                            <div class="layui-form-mid model-range">~</div>
                                            <div class="layui-input-inline model-range" style="width: 100px;">
                                                <input type="number" name="old[{{$quota->id}}][max]" oninput="if(value.length>5)value=value.slice(0,5)" value="{{$quota->max}}" placeholder="￥:后值" autocomplete="off" class="layui-input quota-max" lay-verify="required|unique|compare">
                                            </div>
                                        @else
                                            <div class="layui-input-inline model-range" style="width: 230px">
                                                <input type="number" name="old[{{$quota->id}}][per_value]" oninput="if(value.length>5)value=value.slice(0,5)" maxlength="{{$model->per_length}}" value="{{$quota->per_value}}" lay-verify="required|unique" class="layui-input quota-item quota-per" placeholder="￥:单值">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="layui-inline">
                                        <select name="old[{{$quota->id}}][unit]" lay-verify="required" class="quota-unit">
                                            <option value="">请选择单位</option>
                                            <option value="yuan" {{$quota->unit=='yuan'?'selected':''}} >元</option>
                                            <option value="wan" {{$quota->unit=='wan'?'selected':''}} >万元</option>
                                        </select>
                                    </div>

                                    <div class="layui-inline" style="width: 100px;">
                                        <input type="number" oninput="if(value.length>4)value=value.slice(0,4)" name="old[{{$quota->id}}][sort]" value="{{$quota->sort}}" lay-verify="required|sort" class="layui-input sort" placeholder="字段排序">
                                    </div>

                                    <div class="layui-inline">
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
                        <button type="submit" class="layui-btn" lay-submit lay-filter="save-quota" >保存</button>
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
            $('#add').on('click',function () {
                if($('body').find('#add').hasClass('layui-btn-disabled')){
                    return false;
                }
                var html='<div class="layui-form-item">\n' +
                    '                        <div class="layui-input-block">\n' +
                    '                            <div class="layui-inline">\n' +
                    '                                <select name="new['+index+'][type]" lay-filter="item-type-new" data-index="'+index+'" class="range-type new-item quota-type" lay-verify="required">\n' +
                    '                                    <option value="">请选择区间类型</option>\n' +
                    '                                    <option value="1"  >value <=</option>\n' +
                    '                                    <option value="2" selected ><= value <=</option>\n' +
                    '                                    <option value="3" >value >=</option>\n' +
                    '                                </select>\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-inline range-input">\n' +
                    '                                <div class="layui-input-inline" style="width: 100px;">\n' +
                    '                                    <input type="number" oninput="if(value.length>5)value=value.slice(0,5)" name="new['+index+'][min]" placeholder="￥:前值" autocomplete="off" class="layui-input quota-min" lay-verify="required|unique">\n' +
                    '                                </div>\n' +
                    '                                <div class="layui-form-mid">~</div>\n' +
                    '                                <div class="layui-input-inline" style="width: 100px;">\n' +
                    '                                    <input type="number" oninput="if(value.length>5)value=value.slice(0,5)" name="new['+index+'][max]" placeholder="￥:后值" autocomplete="off" class="layui-input quota-max" lay-verify="required|unique|compare">\n' +
                    '                                </div>\n' +
                    '                            </div>'+
                    '                            <div class="layui-inline">\n' +
                    '                                <select name="new['+index+'][unit]" lay-verify="required" class="quota-unit">\n' +
                    '                                    <option value="">请选择单位</option>\n' +
                    '                                    <option value="yuan"  >元</option>\n' +
                    '                                    <option value="wan"  >万元</option>\n' +
                    '                                </select>\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-inline" style="width: 100px;">\n' +
                    '                                <input type="number" oninput="if(value.length>4)value=value.slice(0,4)"  name="new['+index+'][sort]" value="0" lay-verify="required|sort" class="layui-input sort" placeholder="字段排序">\n' +
                    '                            </div>\n' +
                    '                            <div class="layui-inline">\n' +
                    '                                <a class="layui-btn layui-btn-danger layui-btn-sm del">删除</a>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>';

                $('#quotas').append(html);
                index++;
                form.render();
            });


            form.on('select(item-type-old)', function(data){
                var index=$(data.elem).data('index');
                var rangeHtml='';
                if(data.value){
                    if(data.value==='2'){
                        rangeHtml='<div class="layui-input-inline" style="width: 100px;">\n' +
                            '                                    <input type="number" oninput="if(value.length>5)value=value.slice(0,5)" name="old['+index+'][min]" placeholder="￥:前值" autocomplete="off" class="layui-input quota-min" lay-verify="required|unique">\n' +
                            '                                </div>\n' +
                            '                                <div class="layui-form-mid">~</div>\n' +
                            '                                <div class="layui-input-inline" style="width: 100px;">\n' +
                            '                                    <input type="number" oninput="if(value.length>5)value=value.slice(0,5)" name="old['+index+'][max]" placeholder="￥:后值" autocomplete="off" class="layui-input quota-max" lay-verify="required|unique|compare">\n' +
                            '                                </div>';
                    }else {
                        rangeHtml='<div class="layui-input-inline" oninput="if(value.length>5)value=value.slice(0,5)" style="width:230px"><input type="number" name="old['+index+'][per_value]" maxlength="" value="" lay-verify="required|unique" class="layui-input quota-item quota-per" placeholder="￥:单值"></div>\n';
                    }
                }
                $(this).closest('.layui-form-item').find('.range-input').html(rangeHtml);
            });

            form.on('select(item-type-new)', function(data){
                var index=$(data.elem).data('index');
                var rangeHtml='';
                if(data.value){
                    if(data.value==='2'){
                         rangeHtml='<div class="layui-input-inline" style="width: 100px;">\n' +
                            '                                    <input type="number" oninput="if(value.length>5)value=value.slice(0,5)" name="new['+index+'][min]" placeholder="￥:前值" autocomplete="off" class="layui-input quota-min" lay-verify="required|unique">\n' +
                            '                                </div>\n' +
                            '                                <div class="layui-form-mid">~</div>\n' +
                            '                                <div class="layui-input-inline" style="width: 100px;">\n' +
                            '                                    <input type="number" oninput="if(value.length>5)value=value.slice(0,5)" name="new['+index+'][max]" placeholder="￥:后值" autocomplete="off" class="layui-input quota-max" lay-verify="required|unique|compare">\n' +
                            '                                </div>';
                    }else {
                         rangeHtml='<div class="layui-input-inline"  style="width:230px"><input type="number" name="new['+index+'][per_value]" maxlength="" oninput="if(value.length>5)value=value.slice(0,5)" value="" lay-verify="required|unique" class="layui-input quota-item quota-per" placeholder="￥:单值"></div>\n';
                    }
                }
                $(this).closest('.layui-form-item').find('.range-input').html(rangeHtml);
            });

            $('body').on('click','.del',function () {
                $(this).closest('.layui-form-item').remove();
            });

            form.verify({
                unique:function (value,item) {
                    var all=$(item).closest('.layui-form-item').prevAll();
                    var cur_type=$(item).closest('.layui-form-item').find('.quota-type').val();
                    var cur_max=$(item).closest('.layui-form-item').find('.quota-max').val();
                    var cur_min=$(item).closest('.layui-form-item').find('.quota-min').val();
                    var cur_per=$(item).closest('.layui-form-item').find('.quota-per').val();
                    var cur_unit=$(item).closest('.layui-form-item').find('.quota-unit').val();
                    var cur_item_str=cur_type+'-'+cur_max+'-'+cur_min+'-'+cur_per+'-'+cur_unit;
                    var flag=0;
                    $.each(all,function (key,obj) {
                        var type=$(obj).find('.quota-type').val();
                        var max=$(obj).find('.quota-max').val();
                        var min=$(obj).find('.quota-min').val();
                        var per=$(obj).find('.quota-per').val();
                        var unit=$(obj).find('.quota-unit').val();
                        var item_str=type+'-'+max+'-'+min+'-'+per+'-'+unit;
                        if(cur_item_str==item_str){
                            flag++;
                        }
                    });
                    if(flag>0){
                        return '贷款金额区间不能有重复值';
                    }
                },
                compare:function (value,item) {
                    var max_value=parseInt(value);
                    var min_value=parseInt($(item).closest('.layui-form-item').find('.quota-min').val());
                    if(min_value>=max_value){
                        return '后值必须必前值大';
                    }
                },
                sort: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(value<-999 || value>999){
                        return '排序取值范围是-999~999';
                    }
                },

            });

            $('input[type="number"]').on('keyup',function () {

                if(!$(this).hasClass('sort')){
                    if($(this).val()<0){
                        $(this).val('');
                    }
                }
            });

            //监听提交
            form.on('submit(save-quota)', function(data){
                $.post("{{route('admin.product.quota.store')}}",data.field,function (res) {
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
