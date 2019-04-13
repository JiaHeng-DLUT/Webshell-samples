$.fn.placeholder = function(){
    $(this).each(function() {
        var thisVal = $(this).val();
        if (thisVal != "") {
            $(this).siblings("label").hide();
        } else {
            $(this).siblings("label").show();
        }
        $(this).keyup(function() {
            var val = $(this).val();
            $(this).siblings("label").hide();
        }).blur(function() {
            var val = $(this).val();
            if (val != "") {
                $(this).siblings("label").hide();
            } else {
                $(this).siblings("label").show();
            }
        });
    });
}
