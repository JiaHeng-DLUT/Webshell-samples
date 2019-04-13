/**
 * Created by A.J on 2016/10/8.
 */
$(document).ready(function(){
    $('table a.twitter').confirm({
        title: $('#quedingshanchu').text(),
        content: $('#bukehuifu').text(),
        confirmButton: $('#jixu').text(),
        cancelButton: $('#quxiao').text(),
        confirm: function(){
            var obj = this.$target;
            $.post("removemanagemc", { id: this.$target.parent().parent().children(":eq(0)").text(), verification: $("#verification").text()},
                function(data){
                    obj.parent().parent().remove();
                });
        }
    });
});