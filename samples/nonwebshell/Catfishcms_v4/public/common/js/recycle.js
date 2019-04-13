/**
 * Created by A.J on 2016/10/4.
 */
$(document).ready(function(){
    $('table a.twitter').confirm({
        title: $('#quedingshanchu').text(),
        content: $('#bukehuifu').text(),
        confirmButton: $('#jixu').text(),
        cancelButton: $('#quxiao').text(),
        onAction: function(action){
            // action is either 'confirm', 'cancel' or 'close'
            if(action == 'confirm'){
                //删除
                var obj = this.$target;
                $.post("removeArticle", { id: this.$target.parent().parent().children(":eq(0)").children("input").val(), verification: $("#verification").text()},
                    function(data){
                        obj.parent().parent().remove();
                    });
            }
        }
    });
    $('table a.twhy').confirm({
        title: $('#quedinghuanyuan').text(),
        content: $('#huanyuan').text(),
        confirmButton: $('#jixu').text(),
        cancelButton: $('#quxiao').text(),
        onAction: function(action){
            // action is either 'confirm', 'cancel' or 'close'
            if(action == 'confirm'){
                //还原
                var obj = this.$target;
                $.post("reductionArticle", { id: this.$target.parent().parent().children(":eq(0)").children("input").val(), verification: $("#verification").text()},
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
    $("#phuanyuan").click(function(){
        $.confirm({
            title: $('#quedinghuanyuan').text(),
            content: $('#huanyuanxuanzhong').text(),
            confirmButton: $('#jixu').text(),
            cancelButton: $('#quxiao').text(),
            confirm: function(){
                $.caozuo($(this),'phuanyuan');
            }
        });
    });
    $("#pshanchu").click(function(){
        $.confirm({
            title: $('#quedingshanchu').text(),
            content: $('#shanchuxuanzhong').text(),
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
        $.post("recycleBatch", { zcuan: zcuan, cz: cz, verification: $("#verification").text()},
            function(data){
                obj.children("span").addClass("hidden");
                $.each(ind, function(i, value) {
                    switch(cz){
                        case 'phuanyuan':
                            $(".gouxuan:eq("+value+")").parent().parent().remove();
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