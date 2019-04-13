@extends('admin.layouts.base')
@section('content')
    <style type="text/css">
        form {
            width: 500px;
            margin: 10px auto;
        }
        .right-from{
            width: 800px;
            margin: 10px auto;
            height: 600px;
        }
        .xtree_contianer {
            width: 493px;
            border: 1px solid #fafafa;
            overflow: auto;
            margin-bottom: 30px;
            background-color: #fff;
            padding: 10px 0 25px 5px;
        }
        .fl{
            float: left;
            margin-top: 50px;
        }
        .wbr-head{
            background: #fafafa;
            height: 50px;
            line-height: 50px;
        }
        .span{
            margin-left: 20px;
            font-size: 16px;
        }
        .right-div{
            margin-left: 40px;
            margin-top: 40px;
        }
    </style>
    <div class="layui-card fl" style="margin-left: 30px;">
        <div class="wbr-head" style="width: 500px">
           <span class="span">选择评论产品</span>
        </div>
        <form class="layui-form" style="margin-top: 40px;">
            <div id="xtree1" class="xtree_contianer"></div>
        </form>
    </div>
    <div class="layui-card fl" style="margin-left: 80px">
        <div class="wbr-head">
            <span class="span">虚拟评论设置</span>
        </div>
        <div class="right-from">
            <div class="right-div">
                <label for="">评论日期设置：</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" placeholder="开始日期" name="date_start"   id="date_start" autocomplete="off">
                </div>
                <div class="layui-form-mid layui-word-aux" style="float:none;display: inline;margin-right: 0">~</div>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" placeholder="结束日期" name="date_end"  id="date_end"  autocomplete="off">
                </div>
            </div>
            <div class="right-div">
                <label for="">评论时间设置：</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" placeholder="开始时间" name="time_start"  id="time_start" autocomplete="off">
                </div>
                <div class="layui-form-mid layui-word-aux" style="float:none;display: inline;margin-right: 0">~</div>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" placeholder="结束时间" name="time_end" id="time_end" autocomplete="off">
                </div>
            </div>
            <div class="right-div">
                <label for="">单次投放总量(条)：</label>
                <div class="layui-input-inline">
                    <input type="number" class="layui-input" oninput="checkNumber(this,1,9999)"  id="number"  placeholder="投放总量" name="number" >
                </div>
            </div>
            <div class="right-div" >
                <div class="layui-input-inline" >
                    <button class="layui-btn layui-btn-sm" id="insertBtn" >  确  认  添  加  </button>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script src="{{asset('js/layui-xtree/layui-xtree.js') }}"></script>
    <script type="text/javascript">
        $.get("{{ route('admin.virtual.comment.product.data') }}",function (result) {
        var json = [{
                title: "全部产品", value: "", data: [
                    { title: "贷款产品", checked: true, value: "", data: [
                        ] }
                    , { title: "信用卡产品", value: "", checked: true, data: [
                        ] }
                ]
            } ];
            //贷款产品初始化
            if(result.products.length > 0){
                for (var i = 0; i< result.products.length;i++){
                    var pro = result.products
                    json[0].data[0].data.push({ title: pro[i].name, value: 'pro,'+pro[i].id,data: [] })
                }
            }
            //信用卡产品初始化
            if(result.credits.length > 0){
                for (var i = 0; i< result.credits.length;i++){
                    var cre = result.credits
                    json[0].data[1].data.push({ title: cre[i].name, value: 'cre,'+cre[i].id, data: [] })
                }
            }
            //执行tree
            layui.use(['form','laydate'], function () {
                var form = layui.form;
                var laydate = layui.laydate;
                //3、最完整的参数用法
                //1、最基础的用法 - 直接绑定json
                var xtree1 = new layuiXtree({
                    elem: 'xtree1'   //(必填) 放置xtree的容器，样式参照 .xtree_contianer
                    , form: form     //(必填) layui 的 from
                    , data: json     //(必填) json数据
                });
                laydate.render({
                    elem: '#date_start' //指定元素
                    ,type: 'date'
                    , max: getNowFormatDate()
                });
                laydate.render({
                    elem: '#date_end' //指定元素
                    ,type: 'date'
                    , max: getNowFormatDate()
                });
                laydate.render({
                    elem: '#time_start' //指定元素
                    ,type: 'time'
                });
                laydate.render({
                    elem: '#time_end' //指定元素
                    ,type: 'time'
                });
            });
        });
        //虚拟评论提交
        $("#insertBtn").click(function () {
            var nowDate = new Date();
            //当前时间戳
            var timestamp = Math.floor((new Date()).getTime() /1000);
            //选中产品的时间
            var arr = [];
            //评论起始日期
            var date_start = $("#date_start").val()
            var date_end = $("#date_end").val()
            //评论起始时间
            var time_start = $("#time_start").val()
            var time_end = $("#time_end").val()
            //投放数量
            var number = $("#number").val()
            //评论起始时间转成时间戳
            var start_string = dataToUninx( date_start+" " +  time_start);
            var end_string =   dataToUninx( date_end+" " +  time_end);


            /* console.log(start_string,end_string);
             return false;*/
            if(!date_start)
            {
                layer.msg('请选择评论开始日期', {icon: 2, time: 2000});
                return false;
            }else if(!date_end){
                layer.msg('请选择评论结束日期', {icon: 2, time: 2000});
                return false;
            }else if(dataToUninx(date_start+" 00:00:00") > dataToUninx(date_end+" 00:00:00")){
                layer.msg('评论开始日期不能大于结束日期', {icon: 2, time: 2000});
                return false;
            }else if(!time_start){
                layer.msg('请选择评论开始时间', {icon: 2, time: 2000});
                return false;
            }else if(!time_end){
                layer.msg('请选择评论结束时间', {icon: 2, time: 2000});
                return false;
            }else if(start_string > timestamp){
                layer.msg('评论开始时间不能大于当前时间', {icon: 2, time: 2000});
                return false;
            } /*else if(end_string > timestamp){
                layer.msg('评论结束时间不能大于当前时间', {icon: 2, time: 2000});
                return false;
            }*/else if(start_string >= end_string){
                layer.msg('评论开始时间不能大于或等于结束时间', {icon: 2, time: 2000});
                return false;
            }else if(number <1 || number > 9999 )
            {
                layer.msg('单次投放量在：1~9999之间', {icon: 2, time: 2000});
                return false;
            }
            //获取选中的产品
            $("input:checkbox[type='checkbox']:checked").each(function(i,e){
                var str =$(e).val();
                if(str.length > 3){
                    arr.push($(e).val());
                }
            });
            if(arr.length == 0)
            {
                layer.msg('请选择需要评论的产品', {icon: 2, time: 2000});
                return false;
            }else if(number <  arr.length)
            {
                layer.msg('投放数量不能小于产品数', {icon: 2, time: 2000});
                return false;
            }else{

                var index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
                $('#insertBtn').attr('disabled',"true");
                $.post("{{ route('admin.virtual.comment.post.data') }}"
                    ,{date_start:date_start,date_end:date_end,time_start:time_start,time_end:time_end,data:arr,number:number}
                    ,function (result) {
                        layer.close(index);
                        $('#insertBtn').removeAttr("disabled");
                        if (result.code==0){
                            layer.msg(result.info, {icon: 1, time: 2000});
                            setTimeout(function(){
                                location.href ="/admin/comment";
                            },2000);
                        }else{
                            layer.msg(result.info, {icon: 2, time: 2000});
                        }
                    });
            }
        });
        function checkNumber(obj,min,max){
            var v = $(obj).val();
            if(v < min){
                layer.msg('最小不能低于：'+min, {icon: 2, time: 2000});
                $(obj).val(min)
            }
            if(v > max){
                layer.msg('最大不能超过：'+max, {icon: 2, time: 2000});
                $(obj).val(max)
            }
        }
        function dataToUninx(string) {
            var f = string.split(' ', 2);
            var d = (f[0] ? f[0] : '').split('-', 3);
            var t = (f[1] ? f[1] : '').split(':', 3);
            return (new Date(
                parseInt(d[0], 10) || null,
                (parseInt(d[1], 10) || 1) - 1,
                parseInt(d[2], 10) || null,
                parseInt(t[0], 10) || null,
                parseInt(t[1], 10) || null,
                parseInt(t[2], 10) || null
            )).getTime() / 1000;
        }
        
        
        function getNowFormatDate() {
            var date = new Date();
            var seperator1 = "-";
            var seperator2 = ":";
            var month = date.getMonth() + 1;
            var strDate = date.getDate();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
                + " " + date.getHours() + seperator2 + date.getMinutes()
                + seperator2 + date.getSeconds();
            return currentdate;
        }
    </script>
@endsection


