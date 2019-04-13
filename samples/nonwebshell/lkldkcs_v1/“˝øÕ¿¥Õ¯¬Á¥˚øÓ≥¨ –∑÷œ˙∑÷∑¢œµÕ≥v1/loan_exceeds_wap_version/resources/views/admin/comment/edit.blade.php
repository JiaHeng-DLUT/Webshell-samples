@extends('admin.layouts.base')
@section('content')
    <style>
        .count{
            position: absolute;
            color: #ccc;
            top: 270px;
            left: 520px;
        }
    </style>
    <div class="layui-col-md12" id="LAY-app-message-detail">
        <div class="layui-card layuiAdmin-msg-detail">
            <div class="layui-card-header" style="background: #fafafa">
                <h1>
                   处理评论
                </h1>
            </div>
            <div style="margin-left: 60px;width: 80%;">
                <div class="layui-card-body layui-text" >
                    <div>
                        <h5><b>评论内容:</b></h5>
                    </div>
                    <div class="layadmin-text" style="text-indent: 2em; margin-top: 2em;">
                        {{ $info->content }}
                    </div>
                </div>
                <p style="margin-top:30px;"></p>
                <div style="margin-bottom:50px;">
                    <span style="margin-left: 40px;">用户号码：<span style="margin-left: 10px;">{{$info->phone}}</span></span>
                    <span style="margin-left: 40px;">评论时间：<span style="margin-left: 10px;">{{$info->created_at}}</span></span>
                    <span style="margin-left: 40px;">评价分数：<span style="margin-left: 10px;">{{$info->star}}</span></span>
                </div>
                <hr style="background-color:black;height: 1px;width:100%;border: none;"/>
                <div class="layui-card-header">
                    <span style="size: 14px;color:#666"><strong><b><span style="color: red">*</span>处理结果:</b></strong></span>
                    <input name="status" type="radio" value="1"  style="margin-left: 30px;"  id="checkPass" @if($info->status == 1)   checked @endif/>审核通过
                    <input name="status" type="radio" value="-1"  style="margin-left: 30px;" id="notcheckPass" @if($info->status == '-1') checked @endif/>不予展示<br>
                    <br>
                    <span id="hideTheDiv" style="@if($info->status != 1) display: none; @endif">
                         <input name="is_wonderful" type="checkbox" value="1" style="margin-left: 100px;" @if($info->is_wonderful == 1) checked   @endif/>设置为精彩评论
                    </span>
                </div>
                <input type="hidden" name="countReply" value="{{count($info->reply)}}">
                @if(count($info->reply) > 0)
                    <hr style="background-color:black;height: 1px;width:100%;border: none;"/>
                    @foreach($info->reply as $item)
                        <div class="layui-card-header" style="width:85%">
                            <span style="size: 14px;color:#666"><strong><b>回复内容:</b></strong></span>
                            <br>
                                <span >&nbsp;&nbsp;{{$item->content}} </span>
                                <br>
                                <span style="font-size: 14px;"><font color="black">回复时间： {{$item->created_at}}</font></span>
                                <span style="margin-left: 30px"><font color="black">回复人：   {{$item->user_name}}</font></span>
                        </div>
                    @endforeach
                @endif
                <hr style="background-color:black;height: 1px;width:100%;border: none;"/>
                <div class="layui-card-body layui-text">
                    {{--<form class="layui-form">--}}
                    <span style="size: 14px;color:#666"><strong><b>回复内容:</b></strong></span>
                    <div class="layui-form-item layui-form-text">
                        <input type="hidden" name="id" value="{{$info->id}}">
                        <div class="layui-input-block">
                            <textarea    style="width: 50%;height: 300px;resize:none;" name="desc"  id="replyContent" placeholder="请输入内容" class="layui-textarea" maxlength="500"></textarea>
                            <span class="count" ><span id="count">0</span> /100</span>
                        </div>
                    </div>
                    <div class="layui-form-item" style="overflow: hidden;">
                        <div class="layui-input-block layui-input-right">
                            <button class="layui-btn" onclick="backSubmit()">确定</button>
                        </div>
                    </div>
                    {{--</form>--}}
                </div>
            </div>
        </div>
    <hr>
    </div>

@endsection
@section('script')
    <script>
        $("#replyContent").on("input propertychange", function () {
            var $this = $(this),
                _val = $this.val(),
                count = "";
            if (_val.length > 100) {
                $this.val(_val.substring(0, 100));
            }
            count = $this.val().length;
            $("#count").text(count);
        });
        function backSubmit() {
            var status = $("input[type='radio']:checked").val();
            var is_wonderful = $("input[type='checkbox']:checked").val();
            var content = $("#replyContent").val();
            var countReply = $("input[name='countReply']").val();

            if (!is_wonderful) {
                is_wonderful = 0;
            }
            if (!status)
            {
                layer.msg('请选择处理结果', {'icon': 2, 'time': 2000});
                return false;
            }

            if(countReply > 0)
            {
                layer.msg('同一条评论允许回复一次', {'icon': 2, 'time': 2000});
                return false;
            }

            $.post('{{route('admin.comment.update')}}',
                {id:$("input[name='id']").val(),
                 content:content,
                 status : status,
                 is_wonderful:is_wonderful
                },
                function(data){
                if(data.code==0){
                    layer.msg(data.info,{'icon':1,'time':2000});
                    window.setTimeout(function(){
                        window.location.href='/admin/comment'
                    },2000)
                }else{
                    layer.msg(data.info,{'icon':2,'time':2000});
                }
            })
        }
        $('#checkPass').change(function(){
            if($(this).is(":checked")){
                $('#hideTheDiv').show();
            }
        });
        $('#notcheckPass').change(function(){
            if($(this).is(":checked")){
                $('#hideTheDiv').hide();
                $("input[type='checkbox']").removeAttr("checked");
            }
        });
    </script>
@endsection