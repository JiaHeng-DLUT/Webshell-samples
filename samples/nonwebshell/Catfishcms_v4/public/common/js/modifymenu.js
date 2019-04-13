/**
 * Created by A.J on 2016/10/8.
 */
$(document).ready(function(){
    $("#lianjie").val($("#href").text());
    if($("#lianjie").val() == null || $("#lianjie").val() == ''){
        $("#lianjie").val('index');
    }
    $("#caidanfenlei").val($("#caidanfenleis").val());
    var ind = new Array(), stt = false, wz = 0, yc = '', nyc = '';
    //去子父级
    $("#fuji option").each(function(index,element){
        if($("#caidanId").val() == $(this).val()){
            stt =true;
            ind.unshift(index);
            wz = $(this).text().indexOf('└');
            yc = $(this).text().substr(0,wz);
            return true;
        }
        if(stt == true){
            wz = $(this).text().indexOf('└');
            nyc = $(this).text().substr(0,wz);
            if(nyc.length > yc.length){
                ind.unshift(index);
                return true;
            }
            else{
                return false;
            }
        }
    });
    if(ind.length > 0){
        $.each(ind, function(i, value) {
            $("#fuji option:eq("+value+")").remove();
        });
    }
});