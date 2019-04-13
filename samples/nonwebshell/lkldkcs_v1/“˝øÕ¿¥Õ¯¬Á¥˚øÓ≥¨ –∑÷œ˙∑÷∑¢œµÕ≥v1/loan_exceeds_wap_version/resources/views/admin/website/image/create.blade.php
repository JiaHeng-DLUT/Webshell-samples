@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                <div class="layui-card-header layuiadmin-card-header-auto">
                    <h2>营销位配置</h2>

                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{ url('admin/website/image/store') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data" id="myform">
                {{csrf_field()}}
                {{method_field('put')}}
                <input type="hidden" name="type" value="0">
                <div class="mytable">
                            <div class="layui-border-box " style="border:1px solid green; margin-top: 20px;padding: 20px 0px 20px 0px;">
                                <input type="hidden" name="ids[]" id="" value="{{ $item['id'] }}">
                                <input type="hidden" name="data[{{ $k }}][id]" id="" value="{{ $item['id']??'' }}">
                                <input type="hidden" name="data[{{ $k }}][type]" id="" value="{{ $item['type']??'' }}">
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>banner</label>
                                    <div class="layui-input-block">
                                        <div class="layui-upload">
                                            <button type="button" class="layui-btn" id="upload{{ $item['id'] }}"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                                            <span class="help">请上传1M以内的png、jpg格式的图片 建议尺寸：750*300px</span><span><a class="layui-btn layui-btn-danger delete" href="javascript:;" {{--onclick="del(this,'{{ $item->id }}')"--}} onclick="_del({{$item['id']}})" >移除</a></span>
                                            <div class="layui-upload-list" >
                                                <ul id="layui-upload-box{{ $k }}" class="layui-clear image-style layui-upload-box">
                                                    @if($item['url'])
                                                        <li><img src="{{ env('IMG_URL').$item['url'] }}" /><p>上传成功</p></li>
                                                    @endif
                                                </ul>
                                                <input type="hidden" class="my_pic" name="data[{{ $k }}][url]" lay-verify="my_pic" id="url{{ $item['id'] }}" value="{{ $item['url']??'' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item" >
                                    <label class="layui-form-label" style="width: 100px">链接类型</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="data[{{ $k }}][redirect_type]" lay-filter="redirect_type{{$item['id']}}" data-value="outside{{$item['id']}}" value="outside" title="外链" @if($item['redirect_type'] == 'outside') checked @endif>
                                        <input type="radio" name="data[{{ $k }}][redirect_type]" lay-filter="redirect_type{{$item['id']}}" data-value="inside{{$item['id']}}" value="inside" title="内链" @if($item['redirect_type'] == 'inside') checked @endif>
                                    </div>
                                </div>
                                <div class="layui-form-item redirect_url{{$item['id']}} init_show" @if($item['redirect_type'] == 'inside') style="display: none"  @endif >
                                    <label for="" class="layui-form-label" style="width: 100px">跳转链接</label>
                                    <div class="layui-input-block">

                                        <input type="text" name="data[{{ $k }}][redirect_url]" value="@if($item['redirect_type'] == 'outside'){{$item['redirect_url']??''}}@endif"  placeholder="请输入跳转链接(必填) 例子：http://www.baidu.com" class="layui-input my_url redirect_url" onkeyup="myurl(this)">
                                    </div>
                                </div>

                                <div class="layui-form-item mynode{{$item['id']}} isnone" @if($item['redirect_type'] == 'inside') style="display: block"  @endif >
                                    <label for="" class="layui-form-label " style="width: 100px;margin-right: 10px;">跳转位置 </label>

                                    <input type="radio" name="data[{{ $k }}][node]" lay-filter="mynode{{$item['id']}}" data-value="product{{$item['id']}}" value="product" title="贷款"   @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['node'] == 'product') checked @endif  @endif checked>
                                    <input type="radio" name="data[{{ $k }}][node]" lay-filter="mynode{{$item['id']}}" data-value="credit{{$item['id']}}" value="credit" title="信用卡"  @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['node'] == 'credit') checked @endif  @endif>
                                    <input type="radio" name="data[{{ $k }}][node]" lay-filter="mynode{{$item['id']}}" data-value="article{{$item['id']}}" value="article" title="发现"  @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['node'] == 'article') checked @endif  @endif>
                                    <input type="radio" name="data[{{ $k }}][node]" lay-filter="mynode{{$item['id']}}" data-value="help{{$item['id']}}" value="help" title="新手帮助"  @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['node'] == 'help') checked @endif  @endif>
                                    <input type="radio" name="data[{{ $k }}][node]" lay-filter="mynode{{$item['id']}}" data-value="about{{$item['id']}}" value="about" title="关于我们"  @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['node'] == 'about') checked @endif  @endif>

                                </div>

                                <div class="layui-form-item product_id{{$item['id']}} isnone" @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['node'] == 'product') style="display: block" @endif  @endif>
                                    <label for="" class="layui-form-label" style="width: 100px">贷款详情</label>
                                    <div class="layui-input-block">
                                        <select name="data[{{ $k }}][product_id]"  lay-verify="" lay-search="">
                                            <option value="0">请选择一个贷款详情(不选跳转列表)</option>
                                            @if(count($products))
                                                @foreach($products as $product)
                                                    <option value="{{ $product['id'] }}" @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['id'] == $product['id']) selected @endif  @endif>{{ $product['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item credit_id{{$item['id']}} isnone" @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['node'] == 'credit') style="display: block" @endif  @endif>
                                    <label for="" class="layui-form-label" style="width: 110px">信用卡详情</label>
                                    <div class="layui-input-block">
                                        <select name="data[{{ $k }}][credit_id]" lay-verify="" lay-search="">
                                            <option value="0">请选择一个信用卡详情(不选跳转列表)</option>
                                            @if(count($credits))
                                                @foreach($credits as $credit)
                                                    <option value="{{ $credit['id'] }}" @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['id'] == $credit['id']) selected @endif  @endif>{{ $credit['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item article_id{{$item['id']}} isnone" @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['node'] == 'article') style="display: block" @endif  @endif>
                                    <label for="" class="layui-form-label" style="width: 100px">发现详情</label>
                                    <div class="layui-input-block">
                                        <select name="data[{{ $k }}][article_id]"  lay-verify="" lay-search="">
                                            <option value="0">请选择一个发现详情(不选跳转列表)</option>
                                            @if(count($articles))
                                                @foreach($articles as $article)
                                                    <option value="{{ $article['id'] }}" @if($item['redirect_type'] == 'inside') @if($item['redirect_url']['id'] == $article['id']) selected @endif  @endif>{{ $article['title'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>排序值</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="data[{{ $k }}][sort]"  value="{{ $item['sort']??'' }}" lay-verify="my_sort" placeholder="请输入排序值(必填)" class="layui-input my_sort" >
                                    </div>
                                </div>
                            </div>

                </div>

                <div class="layui-form-item" style="margin-top: 20px">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" id="add" onclick="Add()">+添 加</button>
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                        <a  class="layui-btn layui-btn-primary" href="{{route('admin.website.image')}}" >返 回</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('script')
    <style>
        .layui-upload-box li{
            width: 120px;
            height: 100px;
            float: left;
            position: relative;
            overflow: hidden;
            margin-right: 10px;
            border:1px solid #ddd;
        }
        .layui-upload-box li img{
            width: 100%;
        }
        .layui-upload-box li p{
            width: 100%;
            height: 22px;
            font-size: 12px;
            position: absolute;
            left: 0;
            bottom: 0;
            line-height: 22px;
            text-align: center;
            color: #fff;
            background-color: #333;
            opacity: 0.6;
        }
        .layui-upload-box li i{
            display: block;
            width: 20px;
            height:20px;
            position: absolute;
            text-align: center;
            top: 2px;
            right:2px;
            z-index:999;
            cursor: pointer;
        }
        .layui-layer-msg{
            top:500px!important;
        }
        .isnone{
            display: none;
        }
        .init_show{
            display: block;
        }
        .delete{
            margin-left: 10px;
        }

    </style>
    <script>

        function myurl(obj){
            $(obj).attr('lay-verify','my_url')
        }


        layui.use(['upload','form'],function () {
            var upload = layui.upload
            var form = layui.form
            var max_number = '{{ $max_number }}';
            @if(session('success'))
            {{--{{ dd(session('success')) }}--}}
            layer.msg('{{session('success')}}',{icon:6});
            {{--{{session('success')}}--}}
            @endif



            @if($data)
            @foreach($data as $k=>$item)
            form.on('radio(redirect_type{{$item['id']}})',function () {
                var index=$(this).data('value');
                console.log(index)

                if(index==='inside{{$item['id']}}'){

                    $('.mynode{{$item['id']}}').show();
                    $('.redirect_url{{$item['id']}}').hide();
                    {{--$('.product_id{{$item['id']}}').show();--}}
                    {{--$('.product_id{{$item['id']}}').find('select').attr('lay-verify','my_product_id')--}}
                }
                if(index==='outside{{$item['id']}}'){
                    $('.mynode{{$item['id']}}').hide();
                    $('.redirect_url{{$item['id']}}').show();
                    $('.product_id{{$item['id']}}').hide();
                    $('.credit_id{{$item['id']}}').hide();
                    $('.article_id{{$item['id']}}').hide();
                    {{--$('.product_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                    {{--$('.credit_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                    {{--$('.article_id{{$item['id']}}').find('select').attr('lay-verify','')--}}

                }
            })
            form.on('radio(mynode{{$item['id']}})',function () {
                var index=$(this).data('value');
                console.log(index)

                if(index==='product{{$item['id']}}'){

                    $('.product_id{{$item['id']}}').show();
                    $('.credit_id{{$item['id']}}').hide();
                    $('.article_id{{$item['id']}}').hide();

                    {{--$('.product_id{{$item['id']}}').find('select').attr('lay-verify','my_product_id')--}}
                    {{--$('.credit_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                    {{--$('.article_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                }
                if(index==='credit{{$item['id']}}'){
                    $('.product_id{{$item['id']}}').hide();
                    $('.credit_id{{$item['id']}}').show();
                    $('.article_id{{$item['id']}}').hide();

                    {{--$('.product_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                    {{--$('.credit_id{{$item['id']}}').find('select').attr('lay-verify','my_credit_id')--}}
                    {{--$('.article_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                }
                if(index==='article{{$item['id']}}'){
                    $('.product_id{{$item['id']}}').hide();
                    $('.credit_id{{$item['id']}}').hide();
                    $('.article_id{{$item['id']}}').show();
                    {{--$('.product_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                    {{--$('.credit_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                    {{--$('.article_id{{$item['id']}}').find('select').attr('lay-verify','my_article_id')--}}

                }
                if(index==='help{{$item['id']}}'){
                    $('.product_id{{$item['id']}}').hide();
                    $('.credit_id{{$item['id']}}').hide();
                    $('.article_id{{$item['id']}}').hide();
                    {{--$('.product_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                    {{--$('.credit_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                    {{--$('.article_id{{$item['id']}}').find('select').attr('lay-verify','my_article_id')--}}

                }
                if(index==='about{{$item['id']}}'){
                    $('.product_id{{$item['id']}}').hide();
                    $('.credit_id{{$item['id']}}').hide();
                    $('.article_id{{$item['id']}}').hide();
                    {{--$('.product_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                    {{--$('.credit_id{{$item['id']}}').find('select').attr('lay-verify','')--}}
                    {{--$('.article_id{{$item['id']}}').find('select').attr('lay-verify','my_article_id')--}}

                }

            })
            @endforeach
            @endif

            $('body').on('click','.delete',function () {
                $(this).closest('.layui-border-box').remove();
                $('#add').removeClass('layui-btn-disabled');
            });




            picupload("#new_upload", "#new-layui-upload-box","new_url")
            function picupload(id, pic, url) {
                upload.render({
                    elem: id
                    , url: '{{ route('uploadImage') }}'
                    , multiple: true
                    ,data:{"_token":"{{ csrf_token() }}"}
                    // ,method:'post'
                    ,before: function(obj){
                        //预读本地文件示例，不支持ie8
                        obj.preview(function(index, file, result){
                            $(pic).html('<li><img src="'+result+'" /><p>上传中</p></li>')
                        });
                    }
                    ,done: function(res){
                        //如果上传失败
                        if(res.code == 0){
                            $(url).val(res.url);
                            $(' '+pic+' li').css('display','block');
                            $(' '+pic+' li p').text('上传成功');
                            return layer.msg(res.msg,{icon:6});
                        }
                        return layer.msg(res.msg,{icon:5});
                    }
                    ,size:1024
                });
            }

            function picOther(index) {

                form.on('radio(new_redirect_type'+index+')',function () {
                    var value=$(this).data('value');
                    // console.log(value)
                    console.log(index)

                    if(value==='inside'+index+''){

                        $('.new_mynode'+index+'').show();
                        $('.new_redirect_url'+index+'').hide();
                        // $('.new_product_id'+index+'').show();
                        // $('.new_product_id'+index+'').find('select').attr('lay-verify','my_product_id')
                    }
                    if(value==='outside'+index+''){
                        $('.new_mynode'+index+'').hide();
                        $('.new_redirect_url'+index+'').show();
                        $('.new_product_id'+index+'').hide();
                        $('.new_credit_id'+index+'').hide();
                        $('.new_article_id'+index+'').hide();
                        // $('.new_product_id'+index+'').find('select').attr('lay-verify','')
                        // $('.new_credit_id'+index+'').find('select').attr('lay-verify','')
                        // $('.new_article_id'+index+'').find('select').attr('lay-verify','')
                    }
                })
                form.on('radio(new_mynode'+index+')',function () {
                    var value=$(this).data('value');
                    console.log(value)
                    console.log(index)

                    if(value==='product'+index+''){

                        $('.new_product_id'+index+'').show();
                        $('.new_credit_id'+index+'').hide();
                        $('.new_article_id'+index+'').hide();
                        // $('.new_product_id'+index+'').find('select').attr('lay-verify','my_product_id')
                        // $('.new_credit_id'+index+'').find('select').attr('lay-verify','')
                        // $('.new_article_id'+index+'').find('select').attr('lay-verify','')
                    }
                    if(value==='credit'+index+''){
                        $('.new_product_id'+index+'').hide();
                        $('.new_credit_id'+index+'').show();
                        $('.new_article_id'+index+'').hide();
                        // $('.new_product_id'+index+'').find('select').attr('lay-verify','')
                        // $('.new_credit_id'+index+'').find('select').attr('lay-verify','my_credit_id')
                        // $('.new_article_id'+index+'').find('select').attr('lay-verify','')
                    }
                    if(value==='article'+index+''){
                        $('.new_product_id'+index+'').hide();
                        $('.new_credit_id'+index+'').hide();
                        $('.new_article_id'+index+'').show();
                        // $('.new_product_id'+index+'').find('select').attr('lay-verify','')
                        // $('.new_credit_id'+index+'').find('select').attr('lay-verify','')
                        // $('.new_article_id'+index+'').find('select').attr('lay-verify','my_article_id')
                    }
                    if(value==='help'+index+''){
                        $('.new_product_id'+index+'').hide();
                        $('.new_credit_id'+index+'').hide();
                        $('.new_article_id'+index+'').hide();
                        // $('.new_product_id'+index+'').find('select').attr('lay-verify','')
                        // $('.new_credit_id'+index+'').find('select').attr('lay-verify','')
                        // $('.new_article_id'+index+'').find('select').attr('lay-verify','my_article_id')
                    }
                    if(value==='about'+index+''){
                        $('.new_product_id'+index+'').hide();
                        $('.new_credit_id'+index+'').hide();
                        $('.new_article_id'+index+'').hide();
                        // $('.new_product_id'+index+'').find('select').attr('lay-verify','')
                        // $('.new_credit_id'+index+'').find('select').attr('lay-verify','')
                        // $('.new_article_id'+index+'').find('select').attr('lay-verify','my_article_id')
                    }
                })
            }



            var index = 0;
            var type = '{{ $type }}';

            window.Add = function () {
                var now_number = $('#myform').find('.layui-border-box').length
                if(now_number>=max_number){
                    $('#add').addClass('layui-btn-disabled');
                    layer.msg('已达上限，请先移出无用banner',{icon:5});
                    return false;
                }

                var recoder = '<div class="layui-border-box " style="border:1px solid green; margin-top: 20px;padding: 20px 0px 20px 0px;">'+

                    '<input type="hidden" name="new_data['+index+'][id]" id="" value="">'+
                    '<input type="hidden" name="new_data['+index+'][type]" id="" value="'+type+'">'+
                    '<div class="layui-form-item">'+
                    '<label for="" class="layui-form-label"><strong class="item-required">*</strong>banner</label>'+
                    '<div class="layui-input-block">'+
                    '<div class="layui-upload">'+
                    '<button type="button" class="layui-btn" id="new_upload'+index+'"><i class="layui-icon">&#xe67c;</i>图片上传</button>'+
                    '<span class="help">请上传1M以内的png、jpg格式的图片 建议尺寸：750*300px</span><span><a class="layui-btn layui-btn-danger delete" href="javascript:;"   id="delete">移除</a></span>'+
                    '<div class="layui-upload-list" >'+
                    '<ul id="new-layui-upload-box'+index+'" class="layui-clear image-style layui-upload-box">'+

                    '<li style="display: none"><img class="images" src="" /><p>待上传</p></li>'+
                    '</ul>'+
                    '<input type="hidden" name="new_data['+index+'][url]"  lay-verify="my_pic" id="new_url'+index+'" value="" class="my_pic">'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>' +
                    ' <div class="layui-form-item" >' +
                    ' <label class="layui-form-label" style="width: 100px">链接类型</label>' +
                    '<div class="layui-input-block">' +
                    ' <input type="radio" name="new_data['+index+'][redirect_type]" lay-filter="new_redirect_type'+index+'" data-value="outside'+index+'" value="outside" title="外链" checked>' +
                    '<input type="radio" name="new_data['+index+'][redirect_type]" lay-filter="new_redirect_type'+index+'" data-value="inside'+index+'" value="inside" title="内链" >' +
                    '</div>' +
                    '</div>' +
                    '<div class="layui-form-item new_redirect_url'+index+' init_show"  >' +
                    '<label for="" class="layui-form-label" style="width: 100px">跳转链接</label>' +
                    '<div class="layui-input-block">' +
                    '<input type="text" name="new_data['+index+'][redirect_url]"   placeholder="请输入跳转链接(必填) 例子：http://www.baidu.com" class="layui-input my_url redirect_url" onkeyup="myurl(this)">' +
                    '</div>' +
                    '</div>' +
                    ' <div class="layui-form-item new_mynode'+index+' isnone" >' +
                    '<label for="" class="layui-form-label " style="width: 100px;margin-right: 10px;">跳转位置 </label>' +
                    '<input type="radio" name="new_data['+index+'][node]" lay-filter="new_mynode'+index+'" data-value="product'+index+'" value="product" title="贷款"   checked>' +
                    '<input type="radio" name="new_data['+index+'][node]" lay-filter="new_mynode'+index+'" data-value="credit'+index+'" value="credit" title="信用卡"   >' +
                    '<input type="radio" name="new_data['+index+'][node]" lay-filter="new_mynode'+index+'" data-value="article'+index+'" value="article" title="发现"   >' +
                    '<input type="radio" name="new_data['+index+'][node]" lay-filter="new_mynode'+index+'" data-value="help'+index+'" value="help" title="新手帮助"   >' +
                    '<input type="radio" name="new_data['+index+'][node]" lay-filter="new_mynode'+index+'" data-value="about'+index+'" value="about" title="关于我们"   >' +
                    '</div>' +
                    '<div class="layui-form-item new_product_id'+index+' isnone" >' +
                    '<label for="" class="layui-form-label" style="width: 100px">贷款详情</label>' +
                    '<div class="layui-input-block">' +
                    '<select name="new_data['+index+'][product_id]" lay-verify="" lay-search="">' +
                    ' <option value="0">请选择一个贷款详情(不选跳转列表)</option>'
                @foreach($products as $product)
                    recoder +='<option value="{{$product['id']}}">{{$product['name']}}</option>'
                @endforeach
                    recoder +='</select>' +
                    ' </div>' +
                    ' </div>' +
                    ' <div class="layui-form-item new_credit_id'+index+' isnone" >' +
                    '<label for="" class="layui-form-label" style="width: 110px">信用卡详情</label>' +
                    '<div class="layui-input-block">' +
                    ' <select name="new_data['+index+'][credit_id]" lay-verify="" lay-search="">' +
                    '<option value="0">请选择一个信用卡详情(不选跳转列表)</option>'
                @foreach($credits as $credit)
                    recoder +='<option value="{{$credit['id']}}">{{$credit['name']}}</option>'
                @endforeach
                    recoder += '</select>' +
                    ' </div>' +
                    ' </div>' +
                    '<div class="layui-form-item new_article_id'+index+' isnone" >' +
                    ' <label for="" class="layui-form-label" style="width: 100px">发现详情</label>' +
                    ' <div class="layui-input-block">' +
                    '<select name="new_data['+index+'][article_id]" lay-verify="" lay-search="">' +
                    '<option value="0">请选择一个发现详情(不选跳转列表)</option>'
                @foreach($articles as $article)
                    recoder +='<option value="{{$article['id']}}">{{$article['title']}}</option>'
                @endforeach
                    recoder +='</select>' +
                    ' </div>' +
                    ' </div>' +
                    '<div class="layui-form-item">'+
                    '<label for="" class="layui-form-label"><strong class="item-required">*</strong>排序值</label>'+
                    '<div class="layui-input-block">'+
                    '<input type="number" name="new_data['+index+'][sort]"   value="" lay-verify="my_sort" placeholder="请输入排序值(必填)" class="layui-input my_sort" >'+
                    '</div>'+
                    '</div>'+
                    '</div>';

                // recoder.find(".layui-btn").attr("id", "new_upload" + index + "");
                // recoder.find(".layui-upload-list").attr("id", "new-layui-upload-box" + index + "");
                // recoder.find(".layui-upload-list").empty();
                $(".mytable").append(recoder);

                picupload("#new_upload" + index + "", "#new-layui-upload-box" + index + "", "#new_url"+index+"")
                picOther(index)

                index++;
                form.render();

            }





            @if($data)
            @foreach($data as $k=>$item)
            //普通图片上传
            upload.render({
                elem: '#upload{{$item['id']}}'
                ,url: '{{ route("uploadImage") }}'
                ,multiple: false
                ,data:{"_token":"{{ csrf_token() }}"}
                // ,method:'post'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    /*obj.preview(function(index, file, result){
                     $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                     });*/
                    obj.preview(function(index, file, result){
                        $('#layui-upload-box{{ $k }}').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                    });

                }
                ,done: function(res){
                    //如果上传失败
                    if(res.code == 0){
                        $("#url{{ $item['id'] }}").val(res.url);
                        $('#layui-upload-box1 li p').text('上传成功');
                        return layer.msg(res.msg,{icon:6});
                    }
                    return layer.msg(res.msg,{icon:5});
                }
                ,size:1024
            });

            @endforeach
            @endif



            form.verify({

                my_pic: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(value == ''){
                        return 'banner图片不能为空！';
                    }

                },
                my_url: function (value, item) {

                    if(value == ''){

                        return '跳转链接不能为空';
                    }

                    if(!new RegExp("^(http|https|ftp)\\://[a-zA-Z0-9\\-\\.]+\\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\\-\\._\\?\\,\\'/\\\\\\+&%\\$#\\=~])*$").test(value)){
                        return '跳转链接不能格式不对 例子：http://www.baidu.com 或者 https://www.baidu.com';
                    }



                },
                my_sort: function (value, item) {
                    if(value <-999 || value >999){
                        return '排序请输入-999~999之间的值';

                    }
                    if(value == ''){
                        return '排序不能为空';
                    }
                },
                my_product_id: function (value, item) {
                    console.log(value)
                    if(value == ''){
                        return '贷款详情不能为空';
                    }
                },
                my_credit_id: function (value, item) {

                    if(value == ''){
                        return '信用卡详情不能为空';
                    }
                },
                my_article_id: function (value, item) {

                    if(value == ''){
                        return '发现详情不能为空';
                    }
                },



                //我们既支持上述函数式的方式，也支持下述数组的形式
                //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]

            });



            form.render();



        });
    </script>
@endsection