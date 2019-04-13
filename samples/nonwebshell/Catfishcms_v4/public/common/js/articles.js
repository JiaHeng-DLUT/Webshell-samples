/**
 * Created by A.J on 2016/10/4.
 */
$(document).ready(function(){
    $("#fromdatetime, #todatetime").datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});
    $('table a.twitter').confirm({
        title: $('#quedingshanchu').text(),
        content: $('#fangruhuishouzhan').text(),
        confirmButton: $('#jixu').text(),
        cancelButton: $('#quxiao').text(),
        onAction: function(action){
            // action is either 'confirm', 'cancel' or 'close'
            if(action == 'confirm'){
                //删除
                var obj = this.$target;
                $.post("recycleArticle", { id: this.$target.parent().parent().children(":eq(0)").children("input").val(), verification: $("#verification").text()},
                    function(data){
                        obj.parent().parent().remove();
                    });
            }
        }
    });
    $("#zxuan").click(function(){
        if($(this).prop("checked")){
            $(".gouxuan").prop("checked",true);
        }
        else{
            $(".gouxuan").prop("checked",false);
        }
    });
    $("#shenhe").click(function(){
        $.caozuo($(this),'shenhe');
    });
    $("#weishenhe").click(function(){
        $.caozuo($(this),'weishenhe');
    });
    $("#zhiding").click(function(){
        $.caozuo($(this),'zhiding');
    });
    $("#weizhiding").click(function(){
        $.caozuo($(this),'weizhiding');
    });
    $("#tuijian").click(function(){
        $.caozuo($(this),'tuijian');
    });
    $("#weituijian").click(function(){
        $.caozuo($(this),'weituijian');
    });
    $("#pshanchu").click(function(){
        $.confirm({
            title: $('#quedingshanchu').text(),
            content: $('#wenzhanghuishou').text(),
            confirmButton: $('#jixu').text(),
            cancelButton: $('#quxiao').text(),
            confirm: function(){
                $.caozuo($(this),'pshanchu');
            }
        });
    });
});
$.extend({'caozuo':function(obj,cz){
    var zcuan = '',ind = new Array();
    //获取选中项和序号
    $(".gouxuan").each(function(index,element){
        if($(this).prop("checked")){
            ind.unshift(index);
            if(zcuan == ''){
                zcuan = $(this).val();
            }
            else{
                zcuan += ',' + $(this).val();
            }
        }
    });
    if(zcuan != ''){
        obj.children("span").removeClass("hidden");
        $.post("modify", { zcuan: zcuan, cz: cz, verification: $("#verification").text()},
            function(data){
                obj.children("span").addClass("hidden");
                $.each(ind, function(i, value) {
                    switch(cz){
                        case 'shenhe':
                            $(".gouxuan:eq("+value+")").parent().parent().children(":eq(6)").children(":eq(0)").html('<h5 class="text-success"><span class="glyphicon glyphicon-ok"></span> '+$('#yishenhe').text()+'</h5>');
                            break;
                        case 'weishenhe':
                            $(".gouxuan:eq("+value+")").parent().parent().children(":eq(6)").children(":eq(0)").html('<h5 class="text-muted">'+$('#meishenhe').text()+'</h5>');
                            break;
                        case 'zhiding':
                            $(".gouxuan:eq("+value+")").parent().parent().children(":eq(6)").children(":eq(1)").html('<h5 class="text-success"><span class="glyphicon glyphicon-ok"></span> '+$('#yizhiding').text()+'</h5>');
                            break;
                        case 'weizhiding':
                            $(".gouxuan:eq("+value+")").parent().parent().children(":eq(6)").children(":eq(1)").html('<h5 class="text-muted">'+$('#meizhiding').text()+'</h5>');
                            break;
                        case 'tuijian':
                            $(".gouxuan:eq("+value+")").parent().parent().children(":eq(6)").children(":eq(2)").html('<h5 class="text-success"><span class="glyphicon glyphicon-ok"></span> '+$('#yituijian').text()+'</h5>');
                            break;
                        case 'weituijian':
                            $(".gouxuan:eq("+value+")").parent().parent().children(":eq(6)").children(":eq(2)").html('<h5 class="text-muted">'+$('#meituijian').text()+'</h5>');
                            break;
                        case 'pshanchu':
                            $(".gouxuan:eq("+value+")").parent().parent().remove();
                            break;
                    }
                });
            });
    }
    else{
        $.alert({
            title: $('#jinggao').text(),
            content: $('#zhishaoxuanyixiang').text(),
            confirmButton: $('#queding').text()
        });
    }
}});