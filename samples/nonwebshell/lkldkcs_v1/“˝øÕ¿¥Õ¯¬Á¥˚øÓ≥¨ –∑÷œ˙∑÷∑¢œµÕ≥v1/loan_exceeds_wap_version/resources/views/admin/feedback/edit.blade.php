@extends('admin.layouts.base')

@section('content')
    <div class="layui-col-md12" id="LAY-app-message-detail">
        <div class="layui-card layuiAdmin-msg-detail">
            <div class="layui-card-header">
                <h1>
                    <a href="{{route('admin.feedback')}}">建议反馈</a>
                    <span> > </span>
                    <span href="">回复</span>
                </h1>
            </div>
            <div class="layui-card-body layui-text">
                <div>
                    <p style="font-weight: bolder;">反馈内容:</p>
                </div>
                <div class="layadmin-text" style="text-indent: 2em; margin-top: 2em;">
                    {{ $info->content }}
                </div>
                <div>
                    反馈人：{{ $info->phone }}   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 反馈时间：{{ $info->created_at }}
                </div>
            </div>
        </div>
    </div>
    <hr>
    @if($info->reply)
    <div class="layui-fluid layadmin-message-fluid">
        <p>回复内容：</p>
        <div class="layui-row" style="margin-top: 2em;">
            @foreach($info->reply as $item)
            <div class="layui-col-md12 layadmin-homepage-list-imgtxt message-content">
                <div class="media-body">
                    <p class="message-text" style="margin-left: 2em;text-indent: 2em;">
                        {{ $item->content }}
                    </p>
                    <div class="pad-btm" style="margin-left: 2em;">
                        <p class="min-font">
                          <span class="layui-breadcrumb" lay-separator="-" style="visibility: visible;">
                            <a href="javascript:;">回复人：{{ $item->user_name }}</a><span lay-separator="">&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                            <a href="javascript:;">回复时间：{{ $item->created_at }}</a>
                          </span>
                        </p>
                    </div>
                </div>
            </div>
            <hr>
            @endforeach
        </div>
    </div>
    @endif
    <div class="layui-col-md12">
        {{--<form class="layui-form">--}}
            <div class="layui-form-item layui-form-text">
                <input type="hidden" name="id" value="{{$info->id}}">
                <div class="layui-input-block">
                    <p>回复内容：</p>
                    <textarea name="desc" id="replyContent" placeholder="请输入回复内容" class="layui-textarea" maxlength="500"></textarea>
                    <span class="count" ><span id="count">@if(isset($info)) {{strlen($info->introduce)}} @else 0 @endif</span>/500</span>
                </div>
            </div>
            <div class="layui-form-item" style="overflow: hidden;">
                <div class="layui-input-block layui-input-right">
                    <button class="layui-btn" onclick="backSubmit()">发表</button>
                </div>
            </div>
        {{--</form>--}}
    </div>
@endsection
@section('script')
    <script>
        $("#replyContent").on("input propertychange", function () {
            var $this = $(this),
                    _val = $this.val(),
                    count = "";
            if (_val.length > 500) {
                $this.val(_val.substring(0, 500));
            }
            count = $this.val().length;
            $("#count").text(count);
        });
        function backSubmit(){
            if($("#replyContent").val()==''){
                layer.msg('回复内容不能为空',{'icon':2,'time':2000});
            }else{
                $.post('{{route('admin.feedback')}}',{id:$("input[name='id']").val(),Content:$("#replyContent").val()},function(data){
                    if(data.code==0){
                        layer.msg(data.info,{'icon':1,'time':2000});
                        window.setTimeout(function(){
                            window.location.href='/admin/feedback'
                        },2000)
                    }else{
                        layer.msg(data.info,{'icon':2,'time':2000});
                    }
                })
            }
        }
    </script>
@endsection