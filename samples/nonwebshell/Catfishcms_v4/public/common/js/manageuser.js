/**
 * Created by A.J on 2016/10/9.
 */
$(document).ready(function(){
    $(".lahei").click(function(){
        var obj = $(this);
        obj.children("span").removeClass("hidden");
        $.post("lahei_qiyong_bu", { id: obj.parent().siblings(":first").text(), zt: obj.siblings(":first").val(), verification: $("#verification").text()},
            function(data){
                obj.siblings(":first").val(0);
                obj.parent().prev().html('<h5 class="text-muted">'+$('#jinyong').text()+'</h5>');
                obj.children("span").addClass("hidden");
                obj.addClass("hidden").next().removeClass("hidden");
            });
    });
    $(".qiyong").click(function(){
        var obj = $(this);
        obj.children("span").removeClass("hidden");
        $.post("lahei_qiyong_bu", { id: obj.parent().siblings(":first").text(), zt: obj.siblings(":first").val(), verification: $("#verification").text()},
            function(data){
                obj.siblings(":first").val(1);
                obj.parent().prev().html('<h5 class="text-success"><span class="glyphicon glyphicon-ok"></span> '+$('#zhengchang').text()+'</h5>');
                obj.children("span").addClass("hidden");
                obj.addClass("hidden").prev().removeClass("hidden");
            });
    });
});