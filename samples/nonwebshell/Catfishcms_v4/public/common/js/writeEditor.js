/**
 * Created by A.J on 2017/7/13.
 */
$(document).ready(function(){
    var um = UM.getEditor('editor',{
        autoFloatEnabled:false
    });
    //保存
    $("#baocun").click(function(){
        if($.catfish()){
            $("#zhengwen").text(um.getContent());
            if($("#zhaiyao").val() == ''){
                if(um.getContentTxt().length > 500){
                    $("#zhaiyao").val(um.getContentTxt().substr(0,500)+'...');
                }
                else{
                    $("#zhaiyao").val(um.getContentTxt());
                }
            }
        }
    });
});