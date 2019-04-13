/**
 * Created by A.J on 2016/10/16.
 */
$(document).ready(function(){
    $(".shanchu").click(function(){
        if($.catfish()){
            var obj = $(this);
            $.post("removepinglun", { id: $(this).prev().val()},
                function(data){
                    obj.parent().parent().remove();
                });
        }
    });
});