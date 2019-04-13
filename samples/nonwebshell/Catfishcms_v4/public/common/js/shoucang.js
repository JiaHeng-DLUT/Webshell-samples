/**
 * Created by A.J on 2017/8/27.
 */
$(document).ready(function(){
    $(".shanchu").click(function(){
        if($.catfish()){
            var obj = $(this);
            obj.children("span").removeClass("hidden");
            $.post("removeshoucang", { id: $(this).prev().val(), verification: $("#verification").text()},
                function(data){
                    obj.children("span").addClass("hidden");
                    obj.parent().parent().remove();
                });
        }
    });
});