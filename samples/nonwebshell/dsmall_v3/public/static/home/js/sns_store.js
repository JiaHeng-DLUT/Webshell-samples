$(function(){
    //展示和隐藏评论列表
    $(document).on('click',"[ds_type='sd_commentbtn']", function() {
        var $this = $(this);
        $.get(HOMESITEURL + '/Index/login.html', function(result) {
            if (result == '0') {
                login_dialog();
            } else {
                var data = $this.attr('data-param');
                eval("data = " + data);
                //隐藏转发模块
                $('#forward_' + data.txtid).hide();
                if ($('#tracereply_' + data.txtid).css("display") == 'none') {
                    //加载评论列表
                    $("#tracereply_" + data.txtid).load(HOMESITEURL + '/Storesnshome/commenttop.html?id=' + data.txtid);
                    $('#tracereply_' + data.txtid).show();
                } else {
                    $('#tracereply_' + data.txtid).hide();
                }
                return false;
            }
        });
    });
	//评论提交
    $(document).on('click',"[ds_type='scommentbtn']", function() {
        var data = $(this).attr('data-param');
        eval("data = " + data);
        if ($("#commentform_" + data.txtid).valid()) {
            var cookienum = $.cookie('commentnum');
            cookienum = parseInt(cookienum);
            if (cookienum >= MAX_RECORDNUM && $("#commentseccode" + data.txtid).css('display') == "none") {
                //显示验证码
                $("#commentseccode" + data.txtid).show();
                $("#commentseccode" + data.txtid).find("[name='codeimage']").attr('src', HOMESITEURL + '/Seccode/makecode.html?t=' + Math.random());
            } else if (cookienum >= MAX_RECORDNUM && $("#commentseccode" + data.txtid).find("[name='captcha']").val() == '') {
                layer.msg('请填写验证码');
            } else {
                var _form = $("#commentform_" + data.txtid);
                $.ajax({
                    type: "POST",
                    url: _form.attr('action'),
                    data: _form.serialize(),
                    dataType: "json",
                    success: function (res) {
                        layer.msg(res.message, {time: 1000}, function () {
                            if (res.code == 10000) {
                                $('#content_comment' + res.result).html('');
                                $('#tracereply_' + res.result).load(HOMESITEURL + '/Storesnshome/commentlist?id=' + res.result);
                            }
                        });
                    }
                });
                //隐藏验证码
                $("#commentseccode" + data.txtid).hide();
                $("#commentseccode" + data.txtid).find("[name='codeimage']").attr('src', '');
                $("#commentseccode" + data.txtid).find("[name='captcha']").val('');
            }
        }
        return false;
    });

    //删除评论
    $(document).on('click',"[ds_type='scomment_del']", function() {
        var obj = $(this);
        var data_str = $(obj).attr('data-param');
        eval("data_str = " + data_str);
        ds_ajaxget_confirm(HOMESITEURL + '/Storesnshome/delcomment.html?scid=' + data_str.scid + '&stid=' + data_str.stid,'您确定要删除该信息吗？');
    });
	

    //展示和隐藏转发表单
    $(document).on('click',"[ds_type='sd_forwardbtn']", function() {
        var $this = $(this);
        $.get(HOMESITEURL + '/Index/login.html', function(result) {
            if (result == '0') {
                login_dialog();
            } else {
                var data = $this.attr('data-param');
                eval("data = " + data);
                //隐藏评论模块
                $('#tracereply_' + data.txtid).hide();
                if ($('#forward_' + data.txtid).css("display") == 'none') {
                    $('#forward_' + data.txtid).show();
                    //添加字数提示
                    if ($("#forwardcharcount" + data.txtid).html() == '') {
                        $("#content_forward" + data.txtid).charCount({
                            allowed: 140,
                            warning: 10,
                            counterContainerID: 'forwardcharcount' + data.txtid,
                            firstCounterText: '还可以输入',
                            endCounterText: '字',
                            errorCounterText: '已经超出'
                        });
                    }
                    //绑定表单验证
                    $('#forwardform_' + data.txtid).validate({
                        errorPlacement: function(error, element) {
                            element.next('.error').append(error);
                        },
                        rules: {
                            forwardcontent: {
                                maxlength: 140
                            }
                        },
                        messages: {
                            forwardcontent: {
                                maxlength: '不能超过140字'
                            }
                        }
                    });
                } else {
                    $('#forward_' + data.txtid).hide();
                }
                return false;
            }
        });
    });


    //转发提交
    $(document).on('click',"[ds_type='s_forwardbtn']", function() {
        var data = $(this).attr('data-param');
        var form = $(this).parents('form:first');
        var seccode = $("#forwardseccode" + data.txtid);
        eval("data = " + data);
        if (form.valid()) {
            var cookienum = $.cookie('forwardnum');
            cookienum = parseInt(cookienum);
            if (!isNaN(cookienum) && cookienum >= MAX_RECORDNUM) {
                if (seccode.css('display') == 'none') {
                    //显示验证码
                    seccode.show();
                    seccode.find("[name='codeimage']").attr('src', HOMESITEURL + '/Seccode/makecode.html?t=' + Math.random());
                } else if (seccode.find("[name='captcha']").val() == '') {
                    layer.msg('请填写验证码');
                }
            } else {
                ds_ajaxpost('forwardform_' + data.txtid);
                //隐藏验证码
                seccode.hide().find("[name='codeimage']").attr('src', '').end().find("[name='captcha']").val('');
                //隐藏表单
                $('#forward_' + data.txtid).hide();
                $('#content_forward' + data.txtid).val('');
            }
        }
        return false;
    });

    //删除动态
    $(document).on('click',"[ds_type='sd_del']", function() {
        var data_str = $(this).attr('data-param');
        eval("data_str = " + data_str);
        var url = HOMESITEURL + "/Storesnshome/deltrace.html?id=" + data_str.txtid;
        ds_ajaxget_confirm(url,'您确定要删除该信息吗？','remove',data_str)
    });

    // 查看大图
    $('[ds_type="thumb-image"]').on('click', function() {
        src = $(this).find('img').attr('src');
        max_src = src.replace('_240.', '_1280.');
        $(this).parent().hide().next().children('[ds_type="origin-image"]').append('<img src="' + max_src + '" />').end().show();
    });
    $('[ds_type="origin-image"]').on('click', function() {
        $(this).html('').parent().hide().prev().show();
    });
});