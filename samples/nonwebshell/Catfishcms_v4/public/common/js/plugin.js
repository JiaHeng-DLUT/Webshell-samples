/**
 * Created by A.J on 2016/11/5.
 */
$(document).ready(function(){
    $(".yincang").click(function(){
        var obj = $(this);
        obj.children("span").removeClass("hidden");
        var pn = obj.parent().siblings(":eq(0)").text();
        $.post("pluginkaiguan", { pn: pn, verification: $("#verification").text()},
            function(data){
                obj.siblings(":first").val(0);
                obj.parent().prev().html('<h5 class="text-muted">'+$('#weikaiqi').text()+'</h5>');
                obj.children("span").addClass("hidden");
                obj.addClass("hidden").next().removeClass("hidden");
                $("#kz_plugin_"+pn).remove();
            });
    });
    $(".qiyong").click(function(){
        var obj = $(this);
        obj.children("span").removeClass("hidden");
        $.post("pluginkaiguan", { pn: obj.parent().siblings(":eq(0)").text(), verification: $("#verification").text()},
            function(data){
                obj.siblings(":first").val(1);
                obj.parent().prev().html('<h5 class="text-success"><span class="glyphicon glyphicon-ok"></span> '+$('#yikaiqi').text()+'</h5>');
                obj.children("span").addClass("hidden");
                obj.addClass("hidden").prev().removeClass("hidden");
            });
    });
});