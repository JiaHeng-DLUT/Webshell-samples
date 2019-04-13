/**
 * Created by A.J on 2016/10/6.
 */
$(document).ready(function(){
    var ind = new Array(), stt = false, wz = 0, yc = '', nyc = '';
    //去子分类
    $("#shangji option").each(function(index,element){
        if($("#cid").val() == $(this).val()){
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
            $("#shangji option:eq("+value+")").remove();
        });
    }
});