function commonHight() {
    var t = $(window).height(), a = $(".main_header").height(), n = t - a - 1;
    $(".sider_bar").css("height", n), $(".content_wrapper").css("height", n)
}

function showDefault(t, a) {
    showTip(t, "default", a)
}

function showInfo(t, a) {
    showTip(t, "info", a)
}

function showSuccess(t, a) {
    showTip(t, "success", a)
}

function showFailure(t, a) {
    showTip(t, "danger", a)
}

function showTip(t, a, n) {
    var n = n || 2e3, e = parent || window, o = $("#tip", e.document), i = -o.outerWidth() / 2,
        r = -o.outerHeight() / 2;
    o.attr("class", "alert alert-" + a).text(t).css({
        "margin-left": i,
        "margin-top": r
    }).fadeIn(500).delay(n).fadeOut(500)
}

function dateTime(t, a) {
    return a = a || "YYYY-MM-DD HH:MM:SS", t ? ("number" == typeof t && (t *= 1e3), console.log("time", t), moment(t).format(a)) : ""
}

function getSelected(t) {
    var a = [];
    return t = t || "value", $(".table input[name='check[]']:checked").each(function () {
        a.push($(this).attr(t))
    }), a
}

function getDataParam(t, a) {
    var n, e = {}, o = t.data();
    a = a || "param";
    for (n in o) if (0 === n.indexOf(a) && n.length > a.length) {
        var i = n.replace(a, "").toLowerCase();
        e[i] = o[n]
    }
    return $.isEmptyObject(e) && (e = o[a] || {}), e
}

function admin_confirm(t) {
    return new Promise(function (a, n) {
        if (!t) return void a();
        layer.confirm(t, {icon: 3, button: ["确定", "取消"],cancel:function () {
                n("已取消")
            }}, function () {
            a()
        }, function () {
            n("已取消")
        })
    })
}

function upload(t, a) {
    a || (a = new FormData, a.append("file", $(t)[0].files[0])), a.append("_token", window._token);
    var n = $(t).data("upload-url") || "/image/upload";
    return new Promise(function (t, e) {
        $.ajax({
            url: n,
            type: "POST",
            data: a,
            processData: !1,
            contentType: !1,
            dataType: "json",
            success: function (a) {
                t(a)
            },
            error: function (t) {
                e(t)
            }
        })
    })
}

function httpGet(t, a) {
    return a = a || {}, new Promise(function (n, e) {
        $.get(t, a, function (t) {
            n(t)
        }, "json")
    })
}

function httpPost(t, a) {
    return a = a || {}, a._token = window._token, new Promise(function (n, e) {
        $.ajax({
            type: "post", url: t, data: a, dataType: "json", success: function (t) {
                1 === t.status ? n(t) : e(t.info)
            }, error: function () {
                e("网络错误请重试")
            }
        })
    })
}

function httpDelete(t, a) {
    return a = a || {}, a._token = window._token, a._method = 'DELETE', new Promise(function (n, e) {
        $.ajax({
            type: "post", url: t, data: a, dataType: "json", success: function (t) {
                1 === t.status ? n(t) : e(t.info)
            }, error: function () {
                e("网络错误请重试")
            }
        })
    })
}

function httpUpload(t, a) {
    return a.append("_token", window._token), new Promise(function (n, e) {
        $.ajax({
            url: t,
            type: "POST",
            data: a,
            processData: !1,
            contentType: !1,
            dataType: "json",
            success: function (t) {
                n(t)
            },
            error: function (t) {
                e(t)
            }
        })
    })
}

commonHight(), $(window).resize(function () {
    commonHight()
}), $(function () {
    $(".sider_menu>li>a").on("click", function () {
        var t = $(this).parent();
        t.addClass("active").siblings("li").removeClass("active"), t.find(".sub_menu").slideToggle(), t.siblings("li").find(".sub_menu").slideUp()
    }), $(".sider_nav li>a").on("click", function () {
        var t = $(this).parent();
        t.addClass("active").siblings("li").removeClass("active"), t.siblings("li").find("ul").slideUp(), $(this).next("ul").slideToggle()
    }), $("table tr[data-group]").hover(function () {
        var t = $(this).data("group");
        $("table tr[data-group='" + t + "']").css("backgroundColor", "rgb(247,247,250)")
    }, function () {
        var t = $(this).data("group");
        $("table tr[data-group='" + t + "']").css("backgroundColor", "#fff")
    })
}), function (t) {
    t.fn.serializeJson = function () {
        var a = {}, n = this.serializeArray();
        return t(n).each(function () {
            "[]" === this.name.substr(-2) ? (this.name = this.name.replace("[]", ""), t.isArray(a[this.name]) ? a[this.name].push(this.value) : a[this.name] = [this.value]) : a[this.name] = this.value
        }), a
    }
}(jQuery), $(function () {
    var t = $("body");
    $("select.select2").select2(), $("form.validator").bootstrapValidator({}), $(".datepicker").length > 0 && $.fn.datepicker && $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
        autoclose: !0
    }), t.on("change", "input:file[data-action='upload']", function () {
        var t = $(this), a = t.data("slug"), n = t.data("upload-url") || "/image/upload";
        $(this.files).each(function () {
            var e = new FormData;
            e.append("slug", a || ""), e.append("file", this), httpUpload(n, e).then(function (a) {
                console.log("上传结果", a), t.triggerHandler("uploadComplete", [a.status, a.data])
            })
        })
    }), t.on("click", "a[data-action='ajax'],button[data-action='ajax']", function (t) {
        t.preventDefault();
        var a = $(this), n = a.data("href") || a.attr("href"), e = a.data("method") || "GET",
            o = a.data("callback") || "", i = a.data("redirect") || "", r = {_token: window._token, _method: e};
        a.button("loading"), admin_confirm(a.data("confirm")).then(function () {
            return layer.closeAll(), r = $.extend(r, getDataParam(a) || {}), Promise.resolve($["GET" !== e ? "post" : "get"](n, r))
        }).then(function (t) {
            if (a.button("reset"), showTip(t.info, 1 === t.status ? "success" : "danger"), o) return a.trigger(o, [t.status, t.data]), !1;
            1 === t.status && setTimeout(function () {
                i ? window.location.href = i : window.location.reload(!0)
            }, 1500)
        }).catch(function (t) {
            console.log(t), a.button("reset")
        })
    }), t.on("click", "button[data-action='refresh']", function (t) {
        t.preventDefault(), window.location.reload(!0)
    }), t.on("click", "button[data-action='jump']", function (t) {
        t.preventDefault();
        var a = $(this).data("url");
        a ? window.location.href = a : window.location.reload(!0)
    }), t.on("click", "button[data-action='back']", function (t) {
        t.preventDefault(), window.history.back()
    }), t.on("click", "button[data-action='batch']", function () {
        var t = $(this), a = t.data("url"), n = t.data("confirm") || "", e = getSelected();
        if (0 === e.length) return showInfo("请选择要操作的数据"), !1;
        admin_confirm(n).then(function () {
            return layer.closeAll(), httpPost(a, {_token: window._token, _method: "POST", ids: e.join(",")})
        }).then(function (a) {
            var n = t.triggerHandler("batchComplete");
            showSuccess(a.info), n || setTimeout(function () {
                a.url ? window.location.href = a.url : window.location.reload(!0)
            }, 400)
        }).catch(function (t) {
            showFailure(t)
        })
    }), t.on("change", "select[data-action='refresh']", function () {
        var t = ($(this), $(this).data("url")), a = $(this).data("parameter"), n = $(this).val();
        t ? window.location.href = t + "?" + a + "=" + n : window.location.reload(!0)
    }), t.on("click", "select[data-action='batch']", function () {
        var t = $(this), a = t.val(), n = t.find("option:selected"), e = n.data("confirm") || "",
            o = n.data("href") || "", i = getSelected();
        if (0 === i.length) return showInfo("请选择要操作的数据"), t.val("normal"), t.hasClass("select2") && t.select2(), !1;
        switch (a) {
            case"delete":
                admin_confirm(e).then(function () {
                    return showInfo("数据删除中..."), httpDelete(o, {ids: i.join(",")})
                }).then(function (t) {
                    console.log(t), window.location.reload(!0)
                })
        }
    }), t.on("change", "input[name='checkall']", function () {
        $(".table input[name='check[]']").prop("checked", $(this).prop("checked"))
    }),t.on('change',"input[name='check[]']",function () {
        if($(".table input[name='check[]']").length===$(".table input[name='check[]']:checked").length){
            $("input[name='checkall']").prop('checked',true)
        }else {
            $("input[name='checkall']").prop('checked',false)
        }
    }), t.on("click", "[data-action='popup']", function (t) {
        function a() {
            "T" === n.data("reset") && $(e).find("form").get(0).reset(), $(e).modal("show"), n.button("reset"), layer.closeAll()
        }

        t.preventDefault();
        var n = $(this), e = n.data("popup"), o = n.data("urls");
        if (!e) return console.log("需要data-popup"), !1;
        n.button("loading"), layer.msg("加载中...");
        var i = function (t) {
            var a = [];
            return $(t).each(function () {
                console.log(this);
                var t, e = this.url, o = this.callback;
                void 0 !== (t = e ? httpGet(e).then(function (t) {
                    console.log("调用回调 >>>", o), n.triggerHandler(o, [t.status, t.data])
                }) : n.triggerHandler(o, [n])) && a.push(t)
            }), Promise.all(a)
        }(o);
        try {
            i.then(a)
        } catch (t) {
            console.log("无 Promise")
        } finally {
            a()
        }
    }), t.on("click", "button[data-action='submit']", function (t) {
        var a = $(this), n = $(this).data("form"), e = $("#" + n), o = a.data("mode") || "redirect",
            i = a.data("callback") || "";
        a.button("loading");
        var r = e.data("bootstrapValidator");
        if (r && (r.validate(), !r.isValid())) return a.button("reset"), !1;
        httpPost(e.attr("action"), e.serialize()).then(function (t) {
            if (a.button("reset"), i) return console.log("触发回调", i, t), e.trigger(i, [t.status, t.data]), !1;
            switch (o) {
                case"tip":
                    showTip(t.info, 1 === t.status ? "success" : "danger");
                    break;
                case"tip-close":
                default:
                    t.url ? window.location.href = t.url : window.location.reload(!0)
            }
        }).catch(function (t) {
            showInfo(t), a.button("reset")
        })
    }), t.on("click", "button[data-action='change-data']", function () {
        var t = $(this), a = t.data("form"), n = t.data("callback");
        a = $("#" + a), t.trigger(n, [1, a.serializeJson()]), t.parents(".modal").modal("hide")
    }), t.on("click", "[data-action='data-search']", function () {
        var t = $(this), a = t.data("form"), n = t.data("callback");
        a = $("#" + a), httpGet(a.attr("action"), a.serialize()).then(function (t) {
            a.trigger(n, [t.status, t.data])
        })
    }), t.on("click", ".pagination a[data-href]", function (t) {
        t.preventDefault();
        var a = $(this), n = a.data("href"), e = a.data("callback");
        httpGet(n).then(function (t) {
            a.trigger(e, [t.status, t.data])
        })
    })
});