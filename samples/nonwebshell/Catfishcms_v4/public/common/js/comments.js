/**
 * Created by A.J on 2016/10/15.
 */
$(document).ready(function(){
    $(".yincang").click(function(){
        var obj = $(this);
        obj.children("span").removeClass("hidden");
        $.post("shenhepinglun", { id: obj.parent().siblings(":eq(0)").children("input").val(), zt: obj.siblings(":first").val(), verification: $("#verification").text()},
            function(data){
                obj.siblings(":first").val(0);
                obj.parent().prev().html('<h5 class="text-muted">'+$('#meishenhe').text()+'</h5>');
                obj.children("span").addClass("hidden");
                obj.addClass("hidden").next().removeClass("hidden");
            });
    });
    $(".qiyong").click(function(){
        var obj = $(this);
        obj.children("span").removeClass("hidden");
        $.post("shenhepinglun", { id: obj.parent().siblings(":eq(0)").children("input").val(), zt: obj.siblings(":first").val(), verification: $("#verification").text()},
            function(data){
                obj.siblings(":first").val(1);
                obj.parent().prev().html('<h5 class="text-success"><span class="glyphicon glyphicon-ok"></span> '+$('#yishenhe').text()+'</h5>');
                obj.children("span").addClass("hidden");
                obj.addClass("hidden").prev().removeClass("hidden");
            });
    });
    $('table a.twitter').confirm({
        title: $('#quedingshanchu').text(),
        content: $('#bukehuifu').text(),
        confirmButton: $('#jixu').text(),
        cancelButton: $('#quxiao').text(),
        confirm: function(){
            var obj = this.$target;
            $.post("removeComment", { id: this.$target.parent().siblings(":eq(0)").children("input").val(), verification: $("#verification").text()},
                function(data){
                    obj.parent().parent().remove();
                });
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
        $.post("commentbatch", { zcuan: zcuan, cz: cz, verification: $("#verification").text()},
            function(data){
                obj.children("span").addClass("hidden");
                $.each(ind, function(i, value) {
                    switch(cz){
                        case 'shenhe':
                            $(".gouxuan:eq("+value+")").parent().parent().children(":eq(6)").children(":eq(0)").html('<h5 class="text-success"><span class="glyphicon glyphicon-ok"></span> '+$('#yishenhe').text()+'</h5>');
                            $(".gouxuan:eq("+value+")").parent().siblings(":last").children("a:eq(1)").removeClass("hidden");
                            $(".gouxuan:eq("+value+")").parent().siblings(":last").children("a:eq(2)").addClass("hidden");
                            break;
                        case 'weishenhe':
                            $(".gouxuan:eq("+value+")").parent().parent().children(":eq(6)").children(":eq(0)").html('<h5 class="text-muted">'+$('#meishenhe').text()+'</h5>');
                            $(".gouxuan:eq("+value+")").parent().siblings(":last").children("a:eq(2)").removeClass("hidden");
                            $(".gouxuan:eq("+value+")").parent().siblings(":last").children("a:eq(1)").addClass("hidden");
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