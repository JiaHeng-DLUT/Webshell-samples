/**
 * Created by A.J on 2017/7/14.
 */
$(document).ready(function(){
    var um = UM.getEditor('editor',{
        autoFloatEnabled:false
    });
    //保存
    $("#baocun").click(function(){
        if($.catfish()){
            $("#zhengwen").text(um.getContent());
        }
    });
});
