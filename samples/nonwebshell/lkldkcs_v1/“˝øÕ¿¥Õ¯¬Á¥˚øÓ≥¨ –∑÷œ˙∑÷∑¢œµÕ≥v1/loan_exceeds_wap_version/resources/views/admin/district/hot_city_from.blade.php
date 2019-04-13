{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>选择城市</label>
    <div class="layui-input-inline">
        <select name="province_id" lay-verify="required" lay-filter="province">
            <option value="">请选择省份</option>
            @if($provinces->count())
                @foreach($provinces as $province)
                    <option value="{{$province->id}}" @if(($city->city?$city->city->parent_id:'')==$province->id) selected @endif>{{$province->name}}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="layui-input-inline">
        <select name="city_id" lay-verify="required" id="city">
            <option value=""><strong class="item-required">*</strong>请选择城市</option>
            @if($cities->count())
                @foreach($cities as $item)
                    <option value="{{$item->id}}" @if($city->city_id==$item->id) selected @endif>{{$item->name}}</option>
                @endforeach
            @endif
        </select>
    </div>


</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>排序值</label>
    <div class="layui-input-inline">
        <input type="number" name="sort" oninput="if(value.length>4)value=value.slice(0,4)" value="{{$city->sort??old('sort',0)}}" lay-verify="required|number|sort" class="layui-input" placeholder="请填写排序值">
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="save">保存</button>
        <a href="{{route('admin.hotCity')}}" class="layui-btn"  >返 回</a>
    </div>
</div>

@section('script')
    <script>
        layui.use(['upload','form'],function () {
            var form = layui.form;

            form.on("select(province)",function (data) {
                var id=data.value;
                var html='<option value="">请选择城市</option>';
                if(id){
                    $.get("{{route('getCityByProvince')}}",{id:id},function (res) {
                        if(res.code===0){
                            var data=res.data;
                            if(data.length>0){
                                $.each(data,function(key,item){
                                    html+='<option value="'+item.id+'">'+item.name+'</option>'
                                });
                            }
                            $('#city').html(html);
                            form.render();
                        }else {
                            layer.msg(res.msg,{icon:2})
                        }
                    })
                }else {
                    $('#city').html(html);
                    form.render();
                }
            });

            form.verify({
                sort: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(value<-999 || value>999){
                        return '排序取值范围是-999~999';
                    }
                },
            });


            form.on('submit(save)', function(data){
                $.post($('#form-hotCity').attr('action'),data.field,function (res) {
                    if(res.code===0){
                        layer.msg(res.msg,{icon:1});
                        setTimeout(function () {
                            window.location.href="{{route('admin.hotCity')}}";
                        },1500);
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


