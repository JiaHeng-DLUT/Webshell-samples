function buy(str,path) {
    if (check() == false) {} else {
        $('#goodcover').show();
        $.ajax({
            type: 'post',
            url: path+'buy.php?action=buy',
            data: str,
            success: function(data) {
                $('#frm').attr('src', data + '&url=' + encodeURIComponent(document.URL));
                $('#code').fadeIn();
                $('#code').center();
            }
        })
    }
};

function addcart(str,path) {
    if (check() == false) {} else {
        $.ajax({
            type: 'post',
            url: path+'buy.php?action=addcart',
            data: str,
            success: function(data) {
                alert(data.split('|')[1]);
                if(data.split('|')[0]=="error1"){
                     window.location = path+'member';
                }
            }
        })
    }
};

$(function() {

$("body").append($("#7pay").html());
$("#7pay").html("");
	$('#goodcover').click(function() {
        $('#code').hide();
        $('#goodcover').hide();
        $('#frm').attr('src', '//7-pay.cn/code/code.asp?key=xxx');
    });


    $.fn.center = function(loaded) {
        var obj = this;
        body_width = parseInt($(window).width());
        body_height = parseInt($(window).height());
        block_width = parseInt(obj.width());
        block_height = parseInt(obj.height());

        left_position = parseInt((body_width / 2) - (block_width / 2) + $(window).scrollLeft());
        if (body_width < block_width) {
            left_position = 0 + $(window).scrollLeft();
        };

        top_position = parseInt((body_height / 2) - (block_height / 2) + $(window).scrollTop());
        if (body_height < block_height) {
            top_position = 0 + $(window).scrollTop();
        };

        if (!loaded) {

            obj.css({
                'position': 'fixed'
            });
            obj.css({
                'top': ($(window).height() - $('#code').height()) * 0.5,
                'left': left_position
            });
            $(window).bind('resize', function() {
                obj.center(!loaded);
            });
            

        } else {
            obj.stop();
            obj.css({
                'position': 'fixed'
            });
            obj.animate({
                'top': top_position
            }, 200, 'linear');
        }
    }

})