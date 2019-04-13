/**
 * Created by A.J on 2016/10/17.
 */
$(document).ready(function(){
    $("#captcha").click(function(){
        $("#captcha").attr("src",$("#captcha").attr("src")+"?"+Math.random());
    });
});