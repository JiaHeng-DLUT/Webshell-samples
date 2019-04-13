@extends('admin.layouts.base')

{{--@section('title', $title = $user->id ? '编辑发现分类' : '添加发现分类' )--}}


@section('content')


    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>门户设置</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.website.update')}}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>公司名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="company_name" value="{{ $website->company_name??old('company_name') }}" lay-verify="my_company_name" placeholder="请输入公司名称(必填)" class="layui-input" maxlength="10">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>联系电话</label>
                    <div class="layui-input-block">
                        <input type="text" name="phone" value="{{ $website->phone??old('phone') }}" lay-verify="my_phone" placeholder="请输入联系电话(必填 例子：028-7777777 或者 028-88888888)" class="layui-input" maxlength="20">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>备案号</label>
                    <div class="layui-input-block">
                        <input type="text" name="record_num" value="{{ $website->record_num??old('record_num') }}" lay-verify="my_record_num" placeholder="请输入备案号(必填)" class="layui-input" maxlength="30">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label" style="width: 90px"><strong class="item-required">*</strong>累计借款基数</label>
                    <div class="layui-input-block" >
                        <input type="number" min="0" max="999999" name="base_loan" value="{{ $website->base_loan??old('base_loan') }}" lay-verify="my_base_loan" placeholder="请输入累计借款基数(必填)" class="layui-input" style="width: 99%">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label" style="width: 90px"><strong class="item-required">*</strong>今日借款基数</label>
                    <div class="layui-input-block" >
                        <input type="number" min="0" max="999999" name="base_today_loan" value="{{ $website->base_today_loan??old('base_today_loan') }}" lay-verify="my_base_today_loan" placeholder="请输入今日借款基数(必填)" class="layui-input" style="width: 99%">
                    </div>
                </div>
                {{--<div class="layui-form-item">
                    <label for="" class="layui-form-label">微信二维码</label>
                    <div class="layui-input-block">

                            --}}{{--<button type="button" class="layui-btn layui-btn-danger" id="qrcode_weixin">
                                <i class="layui-icon"></i>上传图片
                            </button><input class="layui-upload-file" type="file" accept="undefined" name="qrcode_weixin">--}}{{--
                        <input type="hidden" name="qrcode_weixin1" id="" value="{{ $website->qrcode_weixin }}">
                        <input type="file" name="qrcode_weixin">
                            <div class="layui-inline layui-word-aux">
                                请上传1Mb以内，png、jpg的格式图片，建议200*200
                            </div>
                        @if($website->qrcode_weixin)
                            <img src="{{ env('IMG_URL').$website->qrcode_weixin }}" alt="" width="300px" height="300px">
                        @endif
                    </div>
                </div>--}}
                {{--<div class="layui-form-item">
                    <label for="" class="layui-form-label">微信二维码</label>
                    <button type="button" class="layui-btn" id="test1">上传图片</button>
                    <div class="layui-upload-list">
                        <img width="300px" height="300px" class="layui-upload-img" id="demo1">
                        <p id="demoText"></p>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">app二维码</label>
                    <div class="layui-input-block">
                       --}}{{-- <button type="button" class="layui-btn layui-btn-danger" id="qrcode_app">
                            <i class="layui-icon"></i>上传图片
                        </button><input class="layui-upload-file" type="file" accept="undefined" name="qrcode_app">--}}{{--
                        <input type="hidden" name="qrcode_app1" id="" value="{{ $website->qrcode_app }}">
                        <input type="file" name="qrcode_app">
                        <div class="layui-inline layui-word-aux">
                            请上传1Mb以内，png、jpg的格式图片，建议200*200
                        </div>
                        @if($website->qrcode_app)
                            <img src="{{ env('IMG_URL').$website->qrcode_app }}" alt="" width="300px" height="300px">
                        @endif
                    </div>
                </div>--}}

                <div class="layui-form-item">
                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>微信二维码</label>
                    <div class="layui-input-block">
                        <div class="layui-upload">
                            <button type="button" class="layui-btn" id="weixin"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                            <span class="help">请上传1M以内的png、jpg格式的图片,尺寸建议200*200</span>
                            <div class="layui-upload-list" >
                                <ul id="layui-upload-box1" class="layui-clear">
                                    @if(isset($website->qrcode_weixin))
                                        <li><img src="{{ env('IMG_URL').$website->qrcode_weixin }}" /><p>上传成功</p></li>
                                    @endif
                                        @if(old('qrcode_weixin'))
                                            <li><img src="{{ env('IMG_URL').old('qrcode_weixin') }}" /><p>上传成功</p></li>
                                        @endif
                                </ul>
                                <input type="hidden" name="qrcode_weixin" id="qrcode_weixin" lay-verify="my_qrcode_weixin"  value="{{ $website->qrcode_weixin??old('qrcode_weixin') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>app二维码</label>
                    <div class="layui-input-block">
                        <div class="layui-upload">
                            <button type="button" class="layui-btn" id="app"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                            <span class="help">请上传1M以内的png、jpg格式的图片,尺寸建议200*200</span>
                            <div class="layui-upload-list" >
                                <ul id="layui-upload-box2" class="layui-clear">
                                    @if(isset($website->qrcode_app))
                                        <li><img src="{{ env('IMG_URL').$website->qrcode_app }}" /><p>上传成功</p></li>
                                    @endif
                                        @if(old('qrcode_app'))
                                            <li><img src="{{ env('IMG_URL').old('qrcode_app') }}" /><p>上传成功</p></li>
                                        @endif
                                </ul>
                                <input type="hidden" name="qrcode_app" id="qrcode_app" lay-verify="my_qrcode_app" value="{{ $website->qrcode_app??old('qrcode_app') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>微博二维码</label>
                    <div class="layui-input-block">
                        <div class="layui-upload">
                            <button type="button" class="layui-btn" id="sina"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                            <span class="help">请上传1M以内的png、jpg格式的图片,尺寸建议200*200</span>
                            <div class="layui-upload-list" >
                                <ul id="layui-upload-box3" class="layui-clear">
                                    @if(isset($website->qrcode_app))
                                        <li><img src="{{ env('IMG_URL').$website->qrcode_sina }}" /><p>上传成功</p></li>
                                    @endif
                                    @if(old('qrcode_sina'))
                                        <li><img src="{{ env('IMG_URL').old('qrcode_sina') }}" /><p>上传成功</p></li>
                                    @endif
                                </ul>
                                <input type="hidden" name="qrcode_sina" id="qrcode_sina" lay-verify="my_qrcode_sina" value="{{ $website->qrcode_sina??old('qrcode_sina') }}">
                            </div>
                        </div>
                    </div>
                </div>




                <div class="layui-form-item">
                    <div class="layui-input-block">
                        @can('admin.website.update')
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                        @endcan
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <style>
        #layui-upload-box1 li{
            width: 120px;
            height: 100px;
            float: left;
            position: relative;
            overflow: hidden;
            margin-right: 10px;
            border:1px solid #ddd;
        }
        #layui-upload-box1 li img{
            width: 100%;
        }
        #layui-upload-box1 li p{
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
        #layui-upload-box1 li i{
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
        #layui-upload-box2 li{
            width: 120px;
            height: 100px;
            float: left;
            position: relative;
            overflow: hidden;
            margin-right: 10px;
            border:1px solid #ddd;
        }
        #layui-upload-box2 li img{
            width: 100%;
        }
        #layui-upload-box2 li p{
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
        #layui-upload-box2 li i{
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
    </style>
    @can('admin.website.website')
    <script>
        layui.use(['upload','form'],function () {
            var upload = layui.upload
            var form = layui.form

            @if(session('success'))
            {{--{{ dd(session('success')) }}--}}
            layer.msg('{{session('success')}}',{icon:6});
            {{--{{session('success')}}--}}
            @endif
            //普通图片上传
            upload.render({
                elem: '#weixin'
                ,url: '{{ route("uploadImage") }}'
                ,multiple: false
                ,data:{"_token":"{{ csrf_token() }}",maxSize:1,filename:'weixin'}
                // ,method:'post'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    /*obj.preview(function(index, file, result){
                     $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                     });*/
                    obj.preview(function(index, file, result){
                        $('#layui-upload-box1').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                    });

                }
                ,done: function(res){
                    //如果上传失败
                    if(res.code == 0){
                        $("#qrcode_weixin").val(res.url);
                        $('#layui-upload-box1 li p').text('上传成功');
                        return layer.msg(res.msg,{icon:6});
                    }
                    return layer.msg(res.msg,{icon:5});
                }
                ,size:1024
            });
            //微信app上传
            upload.render({
                elem: '#app'
                ,url: '{{ route("uploadImage") }}'
                ,multiple: false
                ,data:{"_token":"{{ csrf_token() }}",maxSize:1,filename:'app'}
                // ,method:'post'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    /*obj.preview(function(index, file, result){
                     $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                     });*/
                    obj.preview(function(index, file, result){
                        $('#layui-upload-box2').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                    });

                }
                ,done: function(res){
                    //如果上传失败
                    if(res.code == 0){
                        $("#qrcode_app").val(res.url);
                        $('#layui-upload-box2 li p').text('上传成功');
                        return layer.msg(res.msg,{icon:6});
                    }
                    return layer.msg(res.msg,{icon:5});
                }
                ,size:1024
            });
            //微博上传
            upload.render({
                elem: '#sina'
                ,url: '{{ route("uploadImage") }}'
                ,multiple: false
                ,data:{"_token":"{{ csrf_token() }}",maxSize:1,filename:'app'}
                // ,method:'post'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    /*obj.preview(function(index, file, result){
                     $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                     });*/
                    obj.preview(function(index, file, result){
                        $('#layui-upload-box3').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                    });

                }
                ,done: function(res){
                    //如果上传失败
                    if(res.code == 0){
                        $("#qrcode_sina").val(res.url);
                        $('#layui-upload-box3 li p').text('上传成功');
                        return layer.msg(res.msg,{icon:6});
                    }
                    return layer.msg(res.msg,{icon:5});
                }
                ,size:1024
            });

            form.verify({
                my_company_name: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(value == ''){
                        return '公司名称不能为空！';
                    }
                    if(value.length >11){
                        return '公司名称最多10个字';
                    }
                    if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                        return '公司名称不能有特殊字符';
                    }

                },
                my_phone: function (value, item) {


                    if(value == ''){
                        return '联系电话不能为空';
                    }

                    if (value.length > 21) {
                        return '联系电话最多20个字符';
                    }

                },
                my_record_num: function (value, item) {

                    if (value == '') {
                        return '备案号不能为空';
                    }

                    if (value.length > 31) {
                        return '备案号最多30个字';
                    }
                },
                my_base_loan: function (value, item) {
                    if(!new RegExp("^[0-9]\\d*$").test(value)){
                        return '累计借款基数为0~999999整数';
                    }
                    if (value == '') {
                        return '累计借款基数不能为空';
                    }

                    if (value < 0 || value > 999999 ) {
                        return '累计借款基数请输入0~999999的数字';
                    }


                },
                my_base_today_loan: function (value, item) {

                    if(!new RegExp("^[0-9]\\d*$").test(value)){
                        return '今日借款基数只能输入0~999999整数';
                    }

                    if (value == '') {
                        return '今日借款基数不能为空';
                    }

                    if (value < 0 || value > 999999 ) {
                        return '今日借款基数请输入0~999999的数字';
                    }
                },
                my_qrcode_weixin: function (value, item) {
                    if (value == '') {
                        return '微信二维码不能为空';
                    }

                },
                my_qrcode_app: function (value, item) {

                    if (value == '') {
                        return 'app二维码不能为空';
                    }
                },
                my_qrcode_app: function (value, item) {

                    if (value == '') {
                        return '微博二维码不能为空';
                    }
                },
                

            });

        });

    </script>
    @endcan
@endsection