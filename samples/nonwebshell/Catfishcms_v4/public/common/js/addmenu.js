/**
 * Created by A.J on 2016/10/12.
 */
$(document).ready(function(){
    $("#caidanfenlei").change(function(){
        $("#carriedout").removeClass("hidden");
        $("#fuji").html('<option value="0">'+$('#yijicaidan').text()+'</option>');
        $.post("changeParent", { id: $(this).val(), fj: $("#fj").text()},
            function(data){
                $("#fuji").html(data);
                $("#carriedout").addClass("hidden");
            });
    });
});