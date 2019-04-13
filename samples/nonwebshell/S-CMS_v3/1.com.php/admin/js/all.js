function refresh1(){ var vcode=document.getElementById('vcode'); vcode.src ="../conn/code_1."+langcode+"?nocache="+new Date().getTime();}
function translatex(id){
if($("#"+id+"x").val()==""){
$.ajax({  
         url: "ajax."+langcode+"?type=translate&from="+$("#"+id).val(),
         type: 'POST',  
        success: function (msg) {
        $("#"+id+"x").val(msg);
         },  
         error: function (msg) {  
            console.log(msg);
         }  
    }); 
}
}

function glcode(str){
    if(str!="" && typeof(str)!="undefined"){
    str=ReplaceAll(str,"script","$cript")
    return str;
}else{
    return "";
}
}

function glcode2(str){
    if(str!="" && typeof(str)!="undefined"){
    str=ReplaceAll(str,"$cript","script")
    return str;
}else{
    return "";
}
}

function playSound(){
        var strAudio = "<audio id='audioPlay' src='http://fjdx.sc.chinaz.com/files/download/sound/huang/cd9/wav/131.wav' hidden='true'>";
        if ( $( "body" ).find( "audio" ).length <= 0 )
          $( "body" ).append( strAudio );
        var audio = document.getElementById( "audioPlay" );
        audio.play();
    }

function getorder(id1,id2,typex,id){
if($("#"+id).val()=="" || id==""){
$.ajax({  
         url: "ajax."+langcode+"?type=getorder&typex="+typex+"&idx="+$("#"+id1).val(),
         type: 'POST',  
        success: function (msg) {
        $("#"+id2).val(msg);
         },  
         error: function (msg) {  
            console.log(msg);
         }  
    }); 
}
}

function ReplaceAll(str, sptr, sptr1){
                    while (str.indexOf(sptr) >= 0){
                       str = str.replace(sptr, sptr1);
                    }
                    return str;
             }


function showUpload(a,b){
            if(b==undefined || b=="undefined"){
                b="../media"
            }
            if(!isNaN(a)){
            tid="#pic_"+a
            }else{
            tid="#"+a
            }
            processid=getID();
            $(tid).parent().append("<input type='file' id='testFile"+a+"' style='display:none;' onchange='aaa(\""+a+"\",\""+b+"\")'/>");
            $("#testFile"+a).trigger("click");
}


function aaa(a,b){
    var fileObj = document.getElementById("testFile"+a).files[0];
        var form = new FormData();
        form.append("file"+processid, fileObj);
        filename=fileObj.name;
        filesize=fileObj.size;

        var index = filename.lastIndexOf(".");
    	var suffix = filename.substr(index+1).toLowerCase();

if(filesize>1024*1024*2 && (suffix=="jpg" || suffix=="png" ||suffix=="jpeg" ||suffix=="gif" ||suffix=="bmp" ||suffix=="ico")){
        alert("上传图片文件["+filename+"]不可超过2M，请先压缩");
    }else{
        $.ajax({  
         url: "../upload/upload."+langcode+"?path="+b.replace("..","@@")+"&processid=AN"+processid+"&id="+a,
         type: 'POST',  
         data: form,  
         async: false,
        cache: false,
        contentType: false,
        processData: false,
         success: function (msg) {
        console.log(msg);

        if(msg.substr(0,4)=="http"){
                $(tid+"x").attr("src",msg);
                $(tid+"x").attr("alt","<img src='"+msg+"' width=400");
                $(tid).val(msg);
        }else{
                $(tid+"x").attr("src",b+"/"+msg);
                $(tid+"x").attr("alt","<img src='"+b+"/"+msg+"' width=400");
                if(b=="../media"){
                $(tid).val("media/"+msg);
            }else{
                $(tid).val(msg);
            }
        }

        $("#testFile"+a).remove();
         },  
         error: function (msg) {  
            console.log(msg);
         }  
    });    
}
}




function getID(){var mydt=new Date();with(mydt){var y=getYear();if(y<10){y='0'+y}var m=getMonth()+1;if(m<10){m='0'+m}var d=getDate();if(d<10){d='0'+d}var h=getHours();if(h<10){h='0'+h}var mm=getMinutes();if(mm<10){mm='0'+mm}var s=getSeconds();if(s<10){s='0'+s}}var r="000" + Math.floor(Math.random() * 1000);r=r.substr(r.length-4);return y + m + d + h + mm + s + r;};
function getCookie(a) {
    var b, c = new RegExp("(^| )" + a + "=([^;]*)(;|$)");
    return (b = document.cookie.match(c)) ? unescape(b[2]) :null;
}

function delCookie(a) {
    var c, b = new Date();
    b.setTime(b.getTime() - 1), c = getCookie(a), null != c && (document.cookie = a + "=" + c + ";expires=" + b.toGMTString());
}

function setCookie(a, b, c) {
    var d = getsec(c), e = new Date();
    e.setTime(e.getTime() + 1 * d), document.cookie = a + "=" + escape(b) + ";expires=" + e.toGMTString();
}

function getsec(a) {
    var b = 1 * a.substring(1, a.length), c = a.substring(0, 1);
    return "s" == c ? 1e3 * b :"h" == c ? 1e3 * 60 * 60 * b :"d" == c ? 1e3 * 60 * 60 * 24 * b :void 0;
}

function pltsinits() {
    document.onmouseover = plts, document.onmousemove = moveToMouseLoc;
}

function plts(a) {
    var b, c, d;
    return a ? (o = a.target, MouseX = a.pageX, MouseY = a.pageY) :(o = event.srcElement, 
    MouseX = event.x, MouseY = event.y), null != o.alt && "" != o.alt && (o.dypop = o.alt, 
    o.alt = ""), null != o.title && "" != o.title && (o.dypop = o.title, o.title = ""), 
    pltsPop = o.dypop, null != pltsPop && "" != pltsPop && "undefined" != typeof pltsPop ? (pltsTipLayer.style.left = -1e3, 
    pltsTipLayer.style.display = "", b = pltsPop.replace(/\n/g, "<br>"), b = b.replace(/\0x13/g, "<br>"), 
    c = /\{(.[^\{]*)\}/gi, c.test(b) ? (c = /\{(.[^\{]*)\}(.*)/gi, pltsTitle = b.replace(c, "$1") + "&nbsp;", 
    c = /\{(.[^\{]*)\}/gi, b = b.replace(c, ""), b = b.replace("<br>", "")) :pltsTitle = pltsTitle, 
    b.indexOf("img src=") < 0 && (b = "<ul>" + b + "</ul>"), d = '<table border=0 cellspacing=0 cellpadding=0 id=toolTipTalbe ><tr><td><span id=pltsPoptop><span id=topleft style="float:left">' + pltsTitle + '</span><span id=topright style="display:none;float:right;">' + pltsTitle + "</span></td></tr>" + '<tr><td class="Bttd"><div>' + b + "</div></td></tr>" + '<tr><td><span id=pltsPopbot style="display:none"><b><span id=botleft align=left>' + pltsTitle + '</span><span id=botright align=right style="display:none;float:right;">' + pltsTitle + "</span></td></tr></table>", 
    pltsTipLayer.innerHTML = d, document.getElementById("toolTipTalbe").style.width = Math.min(pltsTipLayer.clientWidth - 10, document.body.clientWidth / 2.2) + "px", 
    moveToMouseLoc(a), !0) :(pltsTipLayer.innerHTML = "", pltsTipLayer.style.display = "none", 
    !0);
}

function moveToMouseLoc(a) {
    var b, c;
    return a ? (MouseX = a.pageX, MouseY = a.pageY) :(MouseX = event.clientX, MouseY = event.clientY), 
    "" == pltsTipLayer.innerHTML ? !0 :(b = pltsTipLayer.clientHeight, c = pltsTipLayer.clientWidth, 
    MouseY + pltsoffsetY + b > document.body.clientHeight ? (popTopAdjust = -b - 1.5 * pltsoffsetY, 
    document.getElementById("pltsPoptop").style.display = "none", document.getElementById("pltsPopbot").style.display = "") :(popTopAdjust = 0, 
    document.getElementById("pltsPoptop").style.display = "", document.getElementById("pltsPopbot").style.display = "none"), 
    MouseX + pltsoffsetX + c > document.body.clientWidth ? (popLeftAdjust = -c - 2 * pltsoffsetX, 
    document.getElementById("topleft").style.display = "none", document.getElementById("botleft").style.display = "none", 
    document.getElementById("topright").style.display = "", document.getElementById("botright").style.display = "") :(popLeftAdjust = 0, 
    document.getElementById("topleft").style.display = "", document.getElementById("botleft").style.display = "", 
    document.getElementById("topright").style.display = "none", document.getElementById("botright").style.display = "none"), 
    pltsTipLayer.style.left = MouseX + pltsoffsetX + document.body.scrollLeft + popLeftAdjust + "px", 
    pltsTipLayer.style.top = navigator.userAgent.indexOf("MSIE") <= 0 ? MouseY + pltsoffsetY + popTopAdjust + "px" :MouseY + pltsoffsetY + document.body.scrollTop + popTopAdjust + "px", 
    !0);
}

function delHtmlTag(a) {
    return a.replace(/<[^>]+>/g, "");
}

function lastIndexDemo(a) {
    var g, h, i, j, k, m, n, b = a, c = new Array(), d = new Array(), e = new Array();
    return new Array(), g = new Array(), h = new Array(), i = new Array(), j = new Array(), 
    k = new Array(), new Array(), n = b.length, getkeywords(c, d), getkey(b, m, n, c, e, g, h, k), 
    timesn(i, h), gettfx(i, j), toobject(e, h, i, j, k, g), outresult(e, h, i, j, k, g, b);
}

function getkeywords(a) {
    var c = 1, d = keylis.length, e = keydrop.length;
    for (i = 0; d > i; i++) a[i] = keylis[i];
    for (i = 0; e > i; i++) a[i + d] = keydrop[i].childNodes[0].nodeValue;
    for (i = 0; c > i; i++) ;
}

function timesn(a, b) {
    var c = 0;
    for (i = 0; i < b.length; i++) {
        for (j = 0; j < b.length; j++) b[i] == b[j] && (c += 1);
        a.push(c), c = 0;
    }
}

function gettfx(a, b) {
    var d, e, g;
    for (Math.log(10), i = 0; i < a.length; i++) d = a[i] / 1, e = Math.log(d), g = a[i] * e, 
    b.push(g.toFixed(3));
}

function toobject(a, b, c, d, e, f) {
    new Array(), a["name"] = f, a["address"] = b, a["tfx"] = d, a["stopkey"] = e, a["times"] = c;
}

function getkey(a, b, c, d, e, f, g, h) {
    for (k = c; k > 0; k--) a:for (j = 6; j > 0; j--) {
        var b = a.substr(k - j, j);
        for (i = 0; i < d.length; i++) if (d[i] == b) {
            f.push(b), g.push(i), i > keylis.length ? h.push(!1) :h.push(!0), k -= j, k++;
            break a;
        }
    }
}

function outresult(a, b, c, d, e, f) {
    var n, o, p, q, r, s, h = "6", k = "0", l = new Array();
    for (new Array(), n = new Array(), o = new Array(), p = new Array(), q = new Array(), 
    i = 0; i < f.length; i++) 1 == a["stopkey"][i] && (l.push(a["name"][i]), p.push(a["tfx"][i]));
    for (i = 0; i < l.length; i++) for (j = l.length; j > i; j--) l[i] == l[j] && (l = l.slice(0, j).concat(l.slice(j + 1, l.length)), 
    p = p.slice(0, j).concat(p.slice(j + 1, p.length)));
    for (i = 0; i < f.length; i++) 0 == a["stopkey"][i] && n.push(a["name"][i]);
    for (i = 0; i < l.length; i++) p[i] > k && (o.push(l[i]), q.push(p[i]));
    for (i = 0; i < o.length; i++) for (j = i + 1; j < o.length; j++) q[i] < q[j] && (r = q[i], 
    q[i] = q[j], q[j] = r, s = o[i], o[i] = o[j], o[j] = s);
    return o = o.slice(0, h), o.join(",");
}

function ajaxx(a, b, c, d, e) {
    toastr.warning("请耐心等待，不要关闭页面", "", {
        timeOut:60000
    }), $.ajax({
        type:"post",
        url:a,
        data:c,
        success:function(a) {

            switch (d) {
              case 1:
                a.indexOf("success") >= 0 ? (toastr.clear(), toastr.success(a.split("|")[1]), redirect(b)) :(toastr.clear(), 
                toastr.error(a.split("|")[1]));
                break;
              case 2:
                a.indexOf("success") >= 0 ? (toastr.clear(), toastr.success(a.split("|")[1])) :(toastr.clear(), 
                toastr.error(a.split("|")[1]));
                break;
              case 3:
                a.indexOf("success") >= 0 ? (toastr.clear(), swal({
                    title:"",
                    text:a.split("|")[1],
                    type:"success",
                    html:!0
                }, function() {
                    redirect(b);
                })) :(toastr.clear(), toastr.error(a.split("|")[1]));
                break;
              case 4:
                if (a.indexOf("success") >= 0) for (toastr.clear(), toastr.success(a.split("|")[1]), 
                strs = a.split("|")[2].split(","), i = 0; i < strs.length; i++) $("#item_" + strs[i]).hide(); else toastr.clear(), 
                toastr.error(a.split("|")[1]);
            }
            return e();
        }
    });
}

function redirect(a) {
    switch (a) {
      case "reload":
        location.reload();
        break;

      case "":
        break;

      default:
        window.location.href = a;
    }
}

var app, pltsPop, pltsoffsetX, pltsoffsetY, pltsPopbg, pltsPopfg, pltsTitle, pltsTipLayer;

!function(a, b, c) {
    b.module("ngAnimate", [ "ng" ]).directive("ngAnimateChildren", function() {
        var a = "$$ngAnimateChildren";
        return function(c, d, e) {
            var f = e.ngAnimateChildren;
            b.isString(f) && 0 === f.length ? d.data(a, !0) :c.$watch(f, function(b) {
                d.data(a, !!b);
            });
        };
    }).factory("$$animateReflow", [ "$$rAF", "$document", function(a, b) {
        var c = b[0].body;
        return function(b) {
            return a(function() {
                c.offsetWidth + 1, b();
            });
        };
    } ]).config([ "$provide", "$animateProvider", function(d, e) {
        function q(a) {
            var b, c;
            for (b = 0; b < a.length; b++) if (c = a[b], c.nodeType == l) return c;
        }
        function r(a) {
            return a && b.element(a);
        }
        function s(a) {
            return b.element(q(a));
        }
        function t(a, b) {
            return q(a) == q(b);
        }
        var f = b.noop, g = b.forEach, h = e.$$selectors, i = b.isArray, j = b.isString, k = b.isObject, l = 1, m = "$$ngAnimateState", n = "$$ngAnimateChildren", o = "ng-animate", p = {
            running:!0
        };
        d.decorator("$animate", [ "$delegate", "$$q", "$injector", "$sniffer", "$rootElement", "$$asyncCallback", "$rootScope", "$document", "$templateRequest", function(a, c, d, l, u, v, w, x, y) {
            function D(a, b) {
                var c = a.data(m) || {};
                return b && (c.running = !0, c.structural = !0, a.data(m, c)), c.disabled || c.running && c.structural;
            }
            function E(a) {
                var b, d = c.defer();
                return d.promise.$$cancelFn = function() {
                    b && b();
                }, w.$$postDigest(function() {
                    b = a(function() {
                        d.resolve();
                    });
                }), d.promise;
            }
            function F(a) {
                return k(a) ? (a.tempClasses && j(a.tempClasses) && (a.tempClasses = a.tempClasses.split(/\s+/)), 
                a) :void 0;
            }
            function G(a, b, c) {
                var d, e, f, h;
                return c = c || {}, d = {}, g(c, function(a, b) {
                    g(b.split(" "), function(b) {
                        d[b] = a;
                    });
                }), e = Object.create(null), g((a.attr("class") || "").split(/\s+/), function(a) {
                    e[a] = !0;
                }), f = [], h = [], g(b && b.classes || [], function(a, b) {
                    var c = e[b], g = d[b] || {};
                    a === !1 ? (c || "addClass" == g.event) && h.push(b) :a === !0 && (c && "removeClass" != g.event || f.push(b));
                }), f.length + h.length > 0 && [ f.join(" "), h.join(" ") ];
            }
            function H(a) {
                var b, c, e, f, g, i;
                if (a) {
                    for (b = [], c = {}, e = a.substr(1).split("."), (l.transitions || l.animations) && b.push(d.get(h[""])), 
                    f = 0; f < e.length; f++) g = e[f], i = h[g], i && !c[g] && (b.push(d.get(i)), c[g] = !0);
                    return b;
                }
            }
            function I(a, c, d, e) {
                function w(a, b) {
                    var c = a[b], d = a["before" + b.charAt(0).toUpperCase() + b.substr(1)];
                    return c || d ? ("leave" == b && (d = c, c = null), u.push({
                        event:b,
                        fn:c
                    }), r.push({
                        event:b,
                        fn:d
                    }), !0) :void 0;
                }
                function x(b, c, h) {
                    function m(a) {
                        if (c) {
                            if ((c[a] || f)(), ++l < i.length) return;
                            c = null;
                        }
                        h();
                    }
                    var l, i = [];
                    g(b, function(a) {
                        a.fn && i.push(a);
                    }), l = 0, g(i, function(b, f) {
                        var g = function() {
                            m(f);
                        };
                        switch (b.event) {
                          case "setClass":
                            c.push(b.fn(a, j, k, g, e));
                            break;

                          case "animate":
                            c.push(b.fn(a, d, e.from, e.to, g));
                            break;

                          case "addClass":
                            c.push(b.fn(a, j || d, g, e));
                            break;

                          case "removeClass":
                            c.push(b.fn(a, k || d, g, e));
                            break;

                          default:
                            c.push(b.fn(a, g, e));
                        }
                    }), c && 0 === c.length && h();
                }
                var j, k, l, m, n, o, p, q, r, s, t, u, v, h = a[0];
                if (h && (e && (e.to = e.to || {}, e.from = e.from || {}), i(d) && (j = d[0], k = d[1], 
                j ? k ? d = j + " " + k :(d = j, c = "addClass") :(d = k, c = "removeClass")), l = "setClass" == c, 
                m = l || "addClass" == c || "removeClass" == c || "animate" == c, n = a.attr("class"), 
                o = n + " " + d, C(o))) return p = f, q = [], r = [], s = f, t = [], u = [], v = (" " + o).replace(/\s+/g, "."), 
                g(H(v), function(a) {
                    var b = w(a, c);
                    !b && l && (w(a, "addClass"), w(a, "removeClass"));
                }), {
                    node:h,
                    event:c,
                    className:d,
                    isClassBased:m,
                    isSetClassOperation:l,
                    applyStyles:function() {
                        e && a.css(b.extend(e.from || {}, e.to || {}));
                    },
                    before:function(a) {
                        p = a, x(r, q, function() {
                            p = f, a();
                        });
                    },
                    after:function(a) {
                        s = a, x(u, t, function() {
                            s = f, a();
                        });
                    },
                    cancel:function() {
                        q && (g(q, function(a) {
                            (a || f)(!0);
                        }), p(!0)), t && (g(t, function(a) {
                            (a || f)(!0);
                        }), s(!0));
                    }
                };
            }
            function J(a, c, d, e, h, i, j, k) {
                function B(b) {
                    var e = "$animate:" + b;
                    p && p[e] && p[e].length > 0 && v(function() {
                        d.triggerHandler(e, {
                            event:a,
                            className:c
                        });
                    });
                }
                function C() {
                    B("before");
                }
                function D() {
                    B("after");
                }
                function E() {
                    B("close"), k();
                }
                function F() {
                    F.hasBeenRun || (F.hasBeenRun = !0, i());
                }
                function G() {
                    if (!G.hasBeenRun) {
                        n && n.applyStyles(), G.hasBeenRun = !0, j && j.tempClasses && g(j.tempClasses, function(a) {
                            d.removeClass(a);
                        });
                        var b = d.data(m);
                        b && (n && n.isClassBased ? L(d, c) :(v(function() {
                            var b = d.data(m) || {};
                            z == b.index && L(d, c, a);
                        }), d.data(m, b))), E();
                    }
                }
                var p, q, r, s, t, u, w, x, y, z, l = f, n = I(d, a, c, j);
                if (!n) return F(), C(), D(), G(), l;
                if (a = n.event, c = n.className, p = b.element._data(n.node), p = p && p.events, 
                e || (e = h ? h.parent() :d.parent()), M(d, e)) return F(), C(), D(), G(), l;
                if (q = d.data(m) || {}, r = q.active || {}, s = q.totalActive || 0, t = q.last, 
                u = !1, s > 0) {
                    if (w = [], n.isClassBased) "setClass" == t.event ? (w.push(t), L(d, c)) :r[c] && (y = r[c], 
                    y.event == a ? u = !0 :(w.push(y), L(d, c))); else if ("leave" == a && r["ng-leave"]) u = !0; else {
                        for (x in r) w.push(r[x]);
                        q = {}, L(d, !0);
                    }
                    w.length > 0 && g(w, function(a) {
                        a.cancel();
                    });
                }
                return !n.isClassBased || n.isSetClassOperation || "animate" == a || u || (u = "addClass" == a == d.hasClass(c)), 
                u ? (F(), C(), D(), E(), l) :(r = q.active || {}, s = q.totalActive || 0, "leave" == a && d.one("$destroy", function() {
                    var e, c = b.element(this), d = c.data(m);
                    d && (e = d.active["ng-leave"], e && (e.cancel(), L(c, "ng-leave")));
                }), d.addClass(o), j && j.tempClasses && g(j.tempClasses, function(a) {
                    d.addClass(a);
                }), z = A++, s++, r[c] = n, d.data(m, {
                    last:n,
                    active:r,
                    index:z,
                    totalActive:s
                }), C(), n.before(function(b) {
                    var e = d.data(m);
                    b = b || !e || !e.active[c] || n.isClassBased && e.active[c].event != a, F(), b === !0 ? G() :(D(), 
                    n.after(G));
                }), n.cancel);
            }
            function K(a) {
                var d, c = q(a);
                c && (d = b.isFunction(c.getElementsByClassName) ? c.getElementsByClassName(o) :c.querySelectorAll("." + o), 
                g(d, function(a) {
                    a = b.element(a);
                    var c = a.data(m);
                    c && c.active && g(c.active, function(a) {
                        a.cancel();
                    });
                }));
            }
            function L(a, b) {
                var c, d;
                t(a, u) ? p.disabled || (p.running = !1, p.structural = !1) :b && (c = a.data(m) || {}, 
                d = b === !0, !d && c.active && c.active[b] && (c.totalActive--, delete c.active[b]), 
                (d || !c.totalActive) && (a.removeClass(o), a.removeData(m)));
            }
            function M(a, c) {
                var d, e, f, g, h, i;
                if (p.disabled) return !0;
                if (t(a, u)) return p.running;
                do {
                    if (0 === c.length) break;
                    if (g = t(c, u), h = g ? p :c.data(m) || {}, h.disabled) return !0;
                    g && (f = !0), d !== !1 && (i = c.data(n), b.isDefined(i) && (d = i)), e = e || h.running || h.last && !h.last.isClassBased;
                } while (c = c.parent());
                return !f || !d && e;
            }
            var z, A, B, C;
            return u.data(m, p), z = w.$watch(function() {
                return y.totalPendingRequests;
            }, function(a) {
                0 === a && (z(), w.$$postDigest(function() {
                    w.$$postDigest(function() {
                        p.running = !1;
                    });
                }));
            }), A = 0, B = e.classNameFilter(), C = B ? function(a) {
                return B.test(a);
            } :function() {
                return !0;
            }, {
                animate:function(a, b, c, d, e) {
                    return d = d || "ng-inline-animate", e = F(e) || {}, e.from = c ? b :null, e.to = c ? c :b, 
                    E(function(b) {
                        return J("animate", d, s(a), null, null, f, e, b);
                    });
                },
                enter:function(c, d, e, g) {
                    return g = F(g), c = b.element(c), d = r(d), e = r(e), D(c, !0), a.enter(c, d, e), 
                    E(function(a) {
                        return J("enter", "ng-enter", s(c), d, e, f, g, a);
                    });
                },
                leave:function(c, d) {
                    return d = F(d), c = b.element(c), K(c), D(c, !0), E(function(b) {
                        return J("leave", "ng-leave", s(c), null, null, function() {
                            a.leave(c);
                        }, d, b);
                    });
                },
                move:function(c, d, e, g) {
                    return g = F(g), c = b.element(c), d = r(d), e = r(e), K(c), D(c, !0), a.move(c, d, e), 
                    E(function(a) {
                        return J("move", "ng-move", s(c), d, e, f, g, a);
                    });
                },
                addClass:function(a, b, c) {
                    return this.setClass(a, b, [], c);
                },
                removeClass:function(a, b, c) {
                    return this.setClass(a, [], b, c);
                },
                setClass:function(c, d, e, f) {
                    var h, j, k, l;
                    return f = F(f), h = "$$animateClasses", c = b.element(c), c = s(c), D(c) ? a.$$setClassImmediately(c, d, e, f) :(k = c.data(h), 
                    l = !!k, k || (k = {}, k.classes = {}), j = k.classes, d = i(d) ? d :d.split(" "), 
                    g(d, function(a) {
                        a && a.length && (j[a] = !0);
                    }), e = i(e) ? e :e.split(" "), g(e, function(a) {
                        a && a.length && (j[a] = !1);
                    }), l ? (f && k.options && (k.options = b.extend(k.options || {}, f)), k.promise) :(c.data(h, k = {
                        classes:j,
                        options:f
                    }), k.promise = E(function(b) {
                        var g, i, j, d = c.parent(), e = q(c), f = e.parentNode;
                        return !f || f["$$NG_REMOVED"] || e["$$NG_REMOVED"] ? (b(), void 0) :(g = c.data(h), 
                        c.removeData(h), i = c.data(m) || {}, j = G(c, g, i.active), j ? J("setClass", j, c, d, null, function() {
                            j[0] && a.$$addClassImmediately(c, j[0]), j[1] && a.$$removeClassImmediately(c, j[1]);
                        }, g.options, b) :b());
                    })));
                },
                cancel:function(a) {
                    a.$$cancelFn();
                },
                enabled:function(a, b) {
                    switch (arguments.length) {
                      case 2:
                        if (a) L(b); else {
                            var c = b.data(m) || {};
                            c.disabled = !0, b.data(m, c);
                        }
                        break;

                      case 1:
                        p.disabled = !a;
                        break;

                      default:
                        a = !p.disabled;
                    }
                    return !!a;
                }
            };
        } ]), e.register("", [ "$window", "$sniffer", "$timeout", "$$animateReflow", function(d, e, h, k) {
            function G() {
                F || (F = k(function() {
                    E = [], F = null, C = {};
                }));
            }
            function H(a, b) {
                F && F(), E.push(b), F = k(function() {
                    g(E, function(a) {
                        a();
                    }), E = [], F = null, C = {};
                });
            }
            function L(a, c) {
                var e, d = q(a);
                a = b.element(d), K.push(a), e = Date.now() + c, J >= e || (h.cancel(I), J = e, 
                I = h(function() {
                    M(K), K = [];
                }, c, !1));
            }
            function M(a) {
                g(a, function(a) {
                    var b = a.data(y);
                    b && g(b.closeAnimationFns, function(a) {
                        a();
                    });
                });
            }
            function N(a, b) {
                var e, f, h, i, c = b ? C[b] :null;
                return c || (e = 0, f = 0, h = 0, i = 0, g(a, function(a) {
                    var b, c, g, k;
                    a.nodeType == l && (b = d.getComputedStyle(a) || {}, c = b[n + s], e = Math.max(O(c), e), 
                    g = b[n + u], f = Math.max(O(g), f), b[p + u], i = Math.max(O(b[p + u]), i), k = O(b[p + s]), 
                    k > 0 && (k *= parseInt(b[p + v], 10) || 1), h = Math.max(k, h));
                }), c = {
                    total:0,
                    transitionDelay:f,
                    transitionDuration:e,
                    animationDelay:i,
                    animationDuration:h
                }, b && (C[b] = c)), c;
            }
            function O(a) {
                var b = 0, c = j(a) ? a.split(/\s*,\s*/) :[];
                return g(c, function(a) {
                    b = Math.max(parseFloat(a) || 0, b);
                }), b;
            }
            function P(a) {
                var b = a.parent(), c = b.data(x);
                return c || (b.data(x, ++D), c = D), c + "-" + q(a).getAttribute("class");
            }
            function Q(a, b, c, d) {
                var j, k, l, m, n, o, p, r, s, t, u, e = [ "ng-enter", "ng-leave", "ng-move" ].indexOf(c) >= 0, f = P(b), g = f + " " + c, h = C[g] ? ++C[g].total :0, i = {};
                return h > 0 && (j = c + "-stagger", k = f + " " + j, l = !C[k], l && b.addClass(j), 
                i = N(b, k), l && b.removeClass(j)), b.addClass(c), m = b.data(y) || {}, n = N(b, g), 
                o = n.transitionDuration, p = n.animationDuration, e && 0 === o && 0 === p ? (b.removeClass(c), 
                !1) :(r = d || e && o > 0, s = p > 0 && i.animationDelay > 0 && 0 === i.animationDuration, 
                t = m.closeAnimationFns || [], b.data(y, {
                    stagger:i,
                    cacheKey:g,
                    running:m.running || 0,
                    itemIndex:h,
                    blockTransition:r,
                    closeAnimationFns:t
                }), u = q(b), r && (S(u, !0), d && b.css(d)), s && T(u, !0), !0);
            }
            function R(a, b, c, d, e) {
                function M() {
                    var a, d;
                    b.off(H, O), b.removeClass(j), b.removeClass(k), K && h.cancel(K), X(b, c), a = q(b);
                    for (d in n) a.style.removeProperty(n[d]);
                }
                function O(a) {
                    var b, c, e;
                    a.stopPropagation(), b = a.originalEvent || a, c = b.$manualTimeStamp || b.timeStamp || Date.now(), 
                    e = parseFloat(b.elapsedTime.toFixed(z)), Math.max(c - G, 0) >= E && e >= C && d();
                }
                var j, k, l, n, p, s, t, u, v, w, x, C, D, E, F, G, H, I, J, K, f = q(b), i = b.data(y);
                return -1 != f.getAttribute("class").indexOf(c) && i ? (j = "", k = "", g(c.split(" "), function(a, b) {
                    var c = (b > 0 ? " " :"") + a;
                    j += c + "-active", k += c + "-pending";
                }), l = "", n = [], p = i.itemIndex, s = i.stagger, t = 0, p > 0 && (u = 0, s.transitionDelay > 0 && 0 === s.transitionDuration && (u = s.transitionDelay * p), 
                v = 0, s.animationDelay > 0 && 0 === s.animationDuration && (v = s.animationDelay * p, 
                n.push(m + "animation-play-state")), t = Math.round(100 * Math.max(u, v)) / 100), 
                t || (b.addClass(j), i.blockTransition && S(f, !1)), w = i.cacheKey + " " + j, x = N(b, w), 
                C = Math.max(x.transitionDuration, x.animationDuration), 0 === C ? (b.removeClass(j), 
                X(b, c), d(), void 0) :(!t && e && (x.transitionDuration || (b.css("transition", x.animationDuration + "s linear all"), 
                n.push("transition")), b.css(e)), D = Math.max(x.transitionDelay, x.animationDelay), 
                E = D * B, n.length > 0 && (F = f.getAttribute("style") || "", ";" !== F.charAt(F.length - 1) && (F += ";"), 
                f.setAttribute("style", F + " " + l)), G = Date.now(), H = r + " " + o, I = (D + C) * A, 
                J = (t + I) * B, t > 0 && (b.addClass(k), K = h(function() {
                    K = null, x.transitionDuration > 0 && S(f, !1), x.animationDuration > 0 && T(f, !1), 
                    b.addClass(j), b.removeClass(k), e && (0 === x.transitionDuration && b.css("transition", x.animationDuration + "s linear all"), 
                    b.css(e), n.push("transition"));
                }, t * B, !1)), b.on(H, O), i.closeAnimationFns.push(function() {
                    M(), d();
                }), i.running++, L(b, J), M)) :(d(), void 0);
            }
            function S(a, b) {
                a.style[n + t] = b ? "none" :"";
            }
            function T(a, b) {
                a.style[p + w] = b ? "paused" :"";
            }
            function U(a, b, c, d) {
                return Q(a, b, c, d) ? function(a) {
                    a && X(b, c);
                } :void 0;
            }
            function V(a, b, c, d, e) {
                return b.data(y) ? R(a, b, c, d, e) :(X(b, c), d(), void 0);
            }
            function W(a, b, c, d, e) {
                var h, g = U(a, b, c, e.from);
                return g ? (h = g, H(b, function() {
                    h = V(a, b, c, d, e.to);
                }), function(a) {
                    (h || f)(a);
                }) :(G(), d(), void 0);
            }
            function X(a, b) {
                a.removeClass(b);
                var c = a.data(y);
                c && (c.running && c.running--, c.running && 0 !== c.running || a.removeData(y));
            }
            function Y(a, b) {
                var c = "";
                return a = i(a) ? a :a.split(/\s+/), g(a, function(a, d) {
                    a && a.length > 0 && (c += (d > 0 ? " " :"") + a + b);
                }), c;
            }
            var n, o, p, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, I, J, K, m = "";
            return a.ontransitionend === c && a.onwebkittransitionend !== c ? (m = "-webkit-", 
            n = "WebkitTransition", o = "webkitTransitionEnd transitionend") :(n = "transition", 
            o = "transitionend"), a.onanimationend === c && a.onwebkitanimationend !== c ? (m = "-webkit-", 
            p = "WebkitAnimation", r = "webkitAnimationEnd animationend") :(p = "animation", 
            r = "animationend"), s = "Duration", t = "Property", u = "Delay", v = "IterationCount", 
            w = "PlayState", x = "$$ngAnimateKey", y = "$$ngAnimateCSS3Data", z = 3, A = 1.5, 
            B = 1e3, C = {}, D = 0, E = [], I = null, J = 0, K = [], {
                animate:function(a, b, c, d, e, f) {
                    return f = f || {}, f.from = c, f.to = d, W("animate", a, b, e, f);
                },
                enter:function(a, b, c) {
                    return c = c || {}, W("enter", a, "ng-enter", b, c);
                },
                leave:function(a, b, c) {
                    return c = c || {}, W("leave", a, "ng-leave", b, c);
                },
                move:function(a, b, c) {
                    return c = c || {}, W("move", a, "ng-move", b, c);
                },
                beforeSetClass:function(a, b, c, d, e) {
                    var f, g;
                    return e = e || {}, f = Y(c, "-remove") + " " + Y(b, "-add"), (g = U("setClass", a, f, e.from)) ? (H(a, d), 
                    g) :(G(), d(), void 0);
                },
                beforeAddClass:function(a, b, c, d) {
                    d = d || {};
                    var e = U("addClass", a, Y(b, "-add"), d.from);
                    return e ? (H(a, c), e) :(G(), c(), void 0);
                },
                beforeRemoveClass:function(a, b, c, d) {
                    d = d || {};
                    var e = U("removeClass", a, Y(b, "-remove"), d.from);
                    return e ? (H(a, c), e) :(G(), c(), void 0);
                },
                setClass:function(a, b, c, d, e) {
                    e = e || {}, c = Y(c, "-remove"), b = Y(b, "-add");
                    var f = c + " " + b;
                    return V("setClass", a, f, d, e.to);
                },
                addClass:function(a, b, c, d) {
                    return d = d || {}, V("addClass", a, Y(b, "-add"), c, d.to);
                },
                removeClass:function(a, b, c, d) {
                    return d = d || {}, V("removeClass", a, Y(b, "-remove"), c, d.to);
                }
            };
        } ]);
    } ]);
}(window, window.angular), function(a, b) {
    function e() {
        this.$get = [ "$$sanitizeUri", function(a) {
            return function(b) {
                var c = [];
                return E(b, J(c, function(b, c) {
                    return !/^unsafe/.test(a(b, c));
                })), c.join("");
            };
        } ];
    }
    function f(a) {
        var c = [], d = J(c, b.noop);
        return d.chars(a), c.join("");
    }
    function D(a) {
        var d, b = {}, c = a.split(",");
        for (d = 0; d < c.length; d++) b[c[d]] = !0;
        return b;
    }
    function E(a, c) {
        function w(a, d, e, f) {
            if (d = b.lowercase(d), u[d]) for (;p.last() && v[p.last()]; ) y("", p.last());
            t[d] && p.last() == d && y("", d), f = q[d] || !!f, f || p.push(d);
            var g = {};
            e.replace(i, function(a, b, c, d, e) {
                var f = c || d || e || "";
                g[b] = H(f);
            }), c.start && c.start(d, g, f);
        }
        function y(a, d) {
            var f, e = 0;
            if (d = b.lowercase(d)) for (e = p.length - 1; e >= 0 && p[e] != d; e--) ;
            if (e >= 0) {
                for (f = p.length - 1; f >= e; f--) c.end && c.end(p[f]);
                p.length = e;
            }
        }
        "string" != typeof a && (a = null === a || "undefined" == typeof a ? "" :"" + a);
        var e, f, o, s, p = [], r = a;
        for (p.last = function() {
            return p[p.length - 1];
        }; a; ) {
            if (s = "", f = !0, p.last() && x[p.last()] ? (a = a.replace(new RegExp("(.*)<\\s*\\/\\s*" + p.last() + "[^>]*>", "i"), function(a, b) {
                return b = b.replace(l, "$1").replace(n, "$1"), c.chars && c.chars(H(b)), "";
            }), y("", p.last())) :(0 === a.indexOf("<!--") ? (e = a.indexOf("--", 4), e >= 0 && a.lastIndexOf("-->", e) === e && (c.comment && c.comment(a.substring(4, e)), 
            a = a.substring(e + 3), f = !1)) :m.test(a) ? (o = a.match(m), o && (a = a.replace(o[0], ""), 
            f = !1)) :k.test(a) ? (o = a.match(h), o && (a = a.substring(o[0].length), o[0].replace(h, y), 
            f = !1)) :j.test(a) && (o = a.match(g), o ? (o[4] && (a = a.substring(o[0].length), 
            o[0].replace(g, w)), f = !1) :(s += "<", a = a.substring(1))), f && (e = a.indexOf("<"), 
            s += 0 > e ? a :a.substring(0, e), a = 0 > e ? "" :a.substring(e), c.chars && c.chars(H(s)))), 
            a == r) throw d("badparse", "The sanitizer was unable to parse the following block of html: {0}", a);
            r = a;
        }
        y();
    }
    function H(a) {
        var b, c, d, e;
        return a ? (b = G.exec(a), c = b[1], d = b[3], e = b[2], e && (F.innerHTML = e.replace(/</g, "&lt;"), 
        e = "textContent" in F ? F.textContent :F.innerText), c + e + d) :"";
    }
    function I(a) {
        return a.replace(/&/g, "&amp;").replace(o, function(a) {
            var b = a.charCodeAt(0), c = a.charCodeAt(1);
            return "&#" + (1024 * (b - 55296) + (c - 56320) + 65536) + ";";
        }).replace(p, function(a) {
            return "&#" + a.charCodeAt(0) + ";";
        }).replace(/</g, "&lt;").replace(/>/g, "&gt;");
    }
    function J(a, c) {
        var d = !1, e = b.bind(a, a.push);
        return {
            start:function(a, f, g) {
                a = b.lowercase(a), !d && x[a] && (d = a), d || y[a] !== !0 || (e("<"), e(a), b.forEach(f, function(d, f) {
                    var g = b.lowercase(f), h = "img" === a && "src" === g || "background" === g;
                    C[g] !== !0 || z[g] === !0 && !c(d, h) || (e(" "), e(f), e('="'), e(I(d)), e('"'));
                }), e(g ? "/>" :">"));
            },
            end:function(a) {
                a = b.lowercase(a), d || y[a] !== !0 || (e("</"), e(a), e(">")), a == d && (d = !1);
            },
            chars:function(a) {
                d || e(I(a));
            }
        };
    }
    var d = b.$$minErr("$sanitize"), g = /^<((?:[a-zA-Z])[\w:-]*)((?:\s+[\w:-]+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)\s*(>?)/, h = /^<\/\s*([\w:-]+)[^>]*>/, i = /([\w:-]+)(?:\s*=\s*(?:(?:"((?:[^"])*)")|(?:'((?:[^'])*)')|([^>\s]+)))?/g, j = /^</, k = /^<\//, l = /<!--(.*?)-->/g, m = /<!DOCTYPE([^>]*?)>/i, n = /<!\[CDATA\[(.*?)]]>/g, o = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g, p = /([^\#-~| |!])/g, q = D("area,br,col,hr,img,wbr"), r = D("colgroup,dd,dt,li,p,tbody,td,tfoot,th,thead,tr"), s = D("rp,rt"), t = b.extend({}, s, r), u = b.extend({}, r, D("address,article,aside,blockquote,caption,center,del,dir,div,dl,figure,figcaption,footer,h1,h2,h3,h4,h5,h6,header,hgroup,hr,ins,map,menu,nav,ol,pre,script,section,table,ul")), v = b.extend({}, s, D("a,abbr,acronym,b,bdi,bdo,big,br,cite,code,del,dfn,em,font,i,img,ins,kbd,label,map,mark,q,ruby,rp,rt,s,samp,small,span,strike,strong,sub,sup,time,tt,u,var")), w = D("animate,animateColor,animateMotion,animateTransform,circle,defs,desc,ellipse,font-face,font-face-name,font-face-src,g,glyph,hkern,image,linearGradient,line,marker,metadata,missing-glyph,mpath,path,polygon,polyline,radialGradient,rect,set,stop,svg,switch,text,title,tspan,use"), x = D("script,style"), y = b.extend({}, q, u, v, t, w), z = D("background,cite,href,longdesc,src,usemap,xlink:href"), A = D("abbr,align,alt,axis,bgcolor,border,cellpadding,cellspacing,class,clear,color,cols,colspan,compact,coords,dir,face,headers,height,hreflang,hspace,ismap,lang,language,nohref,nowrap,rel,rev,rows,rowspan,rules,scope,scrolling,shape,size,span,start,summary,target,title,type,valign,value,vspace,width"), B = D("accent-height,accumulate,additive,alphabetic,arabic-form,ascent,attributeName,attributeType,baseProfile,bbox,begin,by,calcMode,cap-height,class,color,color-rendering,content,cx,cy,d,dx,dy,descent,display,dur,end,fill,fill-rule,font-family,font-size,font-stretch,font-style,font-variant,font-weight,from,fx,fy,g1,g2,glyph-name,gradientUnits,hanging,height,horiz-adv-x,horiz-origin-x,ideographic,k,keyPoints,keySplines,keyTimes,lang,marker-end,marker-mid,marker-start,markerHeight,markerUnits,markerWidth,mathematical,max,min,offset,opacity,orient,origin,overline-position,overline-thickness,panose-1,path,pathLength,points,preserveAspectRatio,r,refX,refY,repeatCount,repeatDur,requiredExtensions,requiredFeatures,restart,rotate,rx,ry,slope,stemh,stemv,stop-color,stop-opacity,strikethrough-position,strikethrough-thickness,stroke,stroke-dasharray,stroke-dashoffset,stroke-linecap,stroke-linejoin,stroke-miterlimit,stroke-opacity,stroke-width,systemLanguage,target,text-anchor,to,transform,type,u1,u2,underline-position,underline-thickness,unicode,unicode-range,units-per-em,values,version,viewBox,visibility,width,widths,x,x-height,x1,x2,xlink:actuate,xlink:arcrole,xlink:role,xlink:show,xlink:title,xlink:type,xml:base,xml:lang,xml:space,xmlns,xmlns:xlink,y,y1,y2,zoomAndPan"), C = b.extend({}, z, B, A), F = document.createElement("pre"), G = /^(\s*)([\s\S]*?)(\s*)$/;
    b.module("ngSanitize", []).provider("$sanitize", e), b.module("ngSanitize").filter("linky", [ "$sanitize", function(a) {
        var c = /((ftp|https?):\/\/|(mailto:)?[A-Za-z0-9._%+-]+@)\S*[^\s.;,(){}<>"]/, d = /^mailto:/;
        return function(e, g) {
            function m(a) {
                a && j.push(f(a));
            }
            function n(a, c) {
                j.push("<a "), b.isDefined(g) && (j.push('target="'), j.push(g), j.push('" ')), 
                j.push('href="'), j.push(a), j.push('">'), m(c), j.push("</a>");
            }
            var h, i, j, k, l;
            if (!e) return e;
            for (i = e, j = []; h = i.match(c); ) k = h[0], h[2] == h[3] && (k = "mailto:" + k), 
            l = h.index, m(i.substr(0, l)), n(k, h[0].replace(d, "")), i = i.substring(l + h[0].length);
            return m(i), a(j.join(""));
        };
    } ]);
}(window, window.angular), angular.module("app", [ "ngAnimate", "ngSanitize", "ui.router", "ui.bootstrap", "ui.jq", "oc.lazyLoad" ]), 
app = angular.module("app").config([ "$controllerProvider", "$compileProvider", "$filterProvider", "$provide","$httpProvider", function(a, b, c, d,$httpProvider) {
    if (!$httpProvider.defaults.headers.get) {
    $httpProvider.defaults.headers.get = {};
  }
  // Enables Request.IsAjaxRequest() in ASP.NET MVC
  $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
  //禁用IE对ajax的缓存
  $httpProvider.defaults.headers.get['Cache-Control'] = 'no-cache';
  $httpProvider.defaults.headers.get['Pragma'] = 'no-cache';

    app.controller = a.register, app.directive = b.directive, app.filter = c.register, 
    app.factory = d.factory, app.service = d.service, app.constant = d.constant, app.value = d.value;
} ]).filter("trustHtml", function(a) {
    return function(b) {
        return a.trustAsHtml(b);
    };
}), angular.module("app").run([ "$rootScope", "$state", "$stateParams", function(a, b, c) {
    function d() {
        "access.forgotpwd" !== b.current.name && (null == getCookie("user") || null == getCookie("pass") || "" == getCookie("user") || "" == getCookie("pass")) && b.go("access.signin");
    }
    a.$state = b, a.$stateParams = c;
    var d = a.$on("$stateChangeSuccess", d);
} ]).config([ "$stateProvider", "$urlRouterProvider", function(a, b) {
    b.otherwise("/app/index"), a.state("app", {
        "abstract":!0,
        url:"/app",
        templateUrl:"tpl."+langcode+"?page=2",
        resolve:{
            deps:[ "$ocLazyLoad", function(a) {
                return a.load([ "js/controller.min.js?v="+Math.random() ]);
            } ]
        }
    }).state("app.index", {
        url:"/index",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[0] ? "tpl."+langcode+"?page=12" :"tpl."+langcode+"?page=7";
        }
    }).state("app.config", {
        url:"/config/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=3" :"tpl."+langcode+"?page=7";
        }
    }).state("app.text_list", {
        url:"/text_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[2] ? "tpl."+langcode+"?page=52" :"tpl."+langcode+"?page=7";
        }
    }).state("app.text_add", {
        url:"/text_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[2] ? "tpl."+langcode+"?page=51" :"tpl."+langcode+"?page=7";
        }
    }).state("app.slide_list", {
        url:"/slide_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=45" :"tpl."+langcode+"?page=7";
        }
    }).state("app.slide_add", {
        url:"/slide_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=44" :"tpl."+langcode+"?page=7";
        }
    }).state("app.m_slide_list", {
        url:"/m_slide_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[10] ? "tpl."+langcode+"?page=20" :"tpl."+langcode+"?page=7";
        }
    }).state("app.m_slide_add", {
        url:"/m_slide_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[10] ? "tpl."+langcode+"?page=19" :"tpl."+langcode+"?page=7";
        }
    }).state("app.link_list", {
        url:"/link_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=14" :"tpl."+langcode+"?page=7";
        }
    }).state("app.link_add", {
        url:"/link_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=13" :"tpl."+langcode+"?page=7";
        }
    }).state("app.lsort_list", {
        url:"/lsort_list/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=71" :"tpl."+langcode+"?page=7";
        }
    }).state("app.lsort_add", {
        url:"/lsort_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=72" :"tpl."+langcode+"?page=7";
        }
    }).state("app.news_list", {
        url:"/news_list/:id/:page/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[3] ? "tpl."+langcode+"?page=26" :"tpl."+langcode+"?page=7";
        }
    }).state("app.news_add", {
        url:"/news_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[3] ? "tpl."+langcode+"?page=25" :"tpl."+langcode+"?page=7";
        }
    }).state("app.collection", {
        url:"/collection/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[3] ? "tpl."+langcode+"?page=79" :"tpl."+langcode+"?page=7";
        }
    }).state("app.collection_add", {
        url:"/collection_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[3] ? "tpl."+langcode+"?page=80" :"tpl."+langcode+"?page=7";
        }
    }).state("app.product_list", {
        url:"/product_list/:id/:page/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=35" :"tpl."+langcode+"?page=7";
        }
    }).state("app.product_add", {
        url:"/product_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=33" :"tpl."+langcode+"?page=7";
        }
    }).state("app.product_excel", {
        url:"/product_excel/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=69" :"tpl."+langcode+"?page=7";
        }
    }).state("app.product_add2", {
        url:"/product_add2",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=34" :"tpl."+langcode+"?page=7";
        }
    }).state("app.nsort_list", {
        url:"/nsort_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[3] ? "tpl."+langcode+"?page=28" :"tpl."+langcode+"?page=7";
        }
    }).state("app.tag", {
        url:"/tag/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[3] ? "tpl."+langcode+"?page=73" :"tpl."+langcode+"?page=7";
        }
    }).state("app.comment", {
        url:"/comment/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[8] ? "tpl."+langcode+"?page=74" :"tpl."+langcode+"?page=7";
        }
    }).state("app.nsort_add", {
        url:"/nsort_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[3] ? "tpl."+langcode+"?page=27" :"tpl."+langcode+"?page=7";
        }
    }).state("app.psort_list", {
        url:"/psort_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=37" :"tpl."+langcode+"?page=7";
        }
    }).state("app.psort_add", {
        url:"/psort_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=36" :"tpl."+langcode+"?page=7";
        }
    }).state("app.order_list", {
        url:"/order_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=29" :"tpl."+langcode+"?page=7";
        }
    }).state("app.send", {
        url:"/send/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=42" :"tpl."+langcode+"?page=7";
        }
    }).state("app.wuliu", {
        url:"/wuliu/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=64" :"tpl."+langcode+"?page=7";
        }
    }).state("app.tk", {
        url:"/tk/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=53" :"tpl."+langcode+"?page=7";
        }
    }).state("app.sitemap", {
        url:"/sitemap",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=43" :"tpl."+langcode+"?page=7";
        }
    }).state("app.log", {
        url:"/log/:page",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[11] ? "tpl."+langcode+"?page=81" :"tpl."+langcode+"?page=7";
        }
    }).state("app.form_list", {
        url:"/form_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[5] ? "tpl."+langcode+"?page=10" :"tpl."+langcode+"?page=7";
        }
    }).state("app.form_add", {
        url:"/form_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[5] ? "tpl."+langcode+"?page=9" :"tpl."+langcode+"?page=7";
        }
    }).state("app.content_add", {
        url:"/content_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[5] ? "tpl."+langcode+"?page=6" :"tpl."+langcode+"?page=7";
        }
    }).state("app.response_list", {
        url:"/response_list/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[5] ? "tpl."+langcode+"?page=39" :"tpl."+langcode+"?page=7";
        }
    }).state("app.query_list", {
        url:"/query_list/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[5] ? "tpl."+langcode+"?page=75" :"tpl."+langcode+"?page=7";
        }
    }).state("app.query_add", {
        url:"/query_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[5] ? "tpl."+langcode+"?page=76" :"tpl."+langcode+"?page=7";
        }
    }).state("app.query_add2", {
        url:"/query_add2/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[5] ? "tpl."+langcode+"?page=83" :"tpl."+langcode+"?page=7";
        }
    }).state("app.qsort_list", {
        url:"/qsort_list/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[5] ? "tpl."+langcode+"?page=77" :"tpl."+langcode+"?page=7";
        }
    }).state("app.qsort_add", {
        url:"/qsort_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[5] ? "tpl."+langcode+"?page=78" :"tpl."+langcode+"?page=7";
        }
    }).state("app.template_list", {
        url:"/template_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[6] ? "tpl."+langcode+"?page=50" :"tpl."+langcode+"?page=7";
        }
    }).state("app.wxapp", {
        url:"/wxapp/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[6] ? "tpl."+langcode+"?page=84" :"tpl."+langcode+"?page=7";
        }
    }).state("app.app", {
        url:"/app/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[6] ? "tpl."+langcode+"?page=85" :"tpl."+langcode+"?page=7";
        }
    }).state("app.bbs_list", {
        url:"/bbs_list/:id/:page/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[3] ? "tpl."+langcode+"?page=86" :"tpl."+langcode+"?page=7";
        }
    }).state("app.bbs_add", {
        url:"/bbs_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=87" :"tpl."+langcode+"?page=7";
        }
    }).state("app.bsort_list", {
        url:"/bsort_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=88" :"tpl."+langcode+"?page=7";
        }
    }).state("app.bsort_add", {
        url:"/bsort_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[4] ? "tpl."+langcode+"?page=89" :"tpl."+langcode+"?page=7";
        }
    }).state("app.template_all", {
        url:"/template_all/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[6] ? "tpl."+langcode+"?page=47" :"tpl."+langcode+"?page=7";
        }
    }).state("app.plug", {
        url:"/plug/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[6] ? "tpl."+langcode+"?page=32" :"tpl."+langcode+"?page=7";
        }
    }).state("app.tohtml", {
        url:"/tohtml/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[6] ? "tpl."+langcode+"?page=54" :"tpl."+langcode+"?page=7";
        }
    }).state("app.contact", {
        url:"/contact/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[8] ? "tpl."+langcode+"?page=5" :"tpl."+langcode+"?page=7";
        }
    }).state("app.guestbook", {
        url:"/guestbook/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[8] ? "tpl."+langcode+"?page=11" :"tpl."+langcode+"?page=7";
        }
    }).state("app.reply", {
        url:"/reply/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[8] ? "tpl."+langcode+"?page=38" :"tpl."+langcode+"?page=7";
        }
    }).state("app.m_config", {
        url:"/m_config/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[10] ? "tpl."+langcode+"?page=17" :"tpl."+langcode+"?page=7";
        }
    }).state("app.config2", {
        url:"/config2/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=4" :"tpl."+langcode+"?page=7";
        }
    }).state("app.m_config2", {
        url:"/m_config2/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[10] ? "tpl."+langcode+"?page=18" :"tpl."+langcode+"?page=7";
        }
    }).state("app.menu_list", {
        url:"/menu_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[7] ? "tpl."+langcode+"?page=24" :"tpl."+langcode+"?page=7";
        }
    }).state("app.menu_add", {
        url:"/menu_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[7] ? "tpl."+langcode+"?page=23" :"tpl."+langcode+"?page=7";
        }
    }).state("app.admin_list", {
        url:"/admin_list/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[9] ? "tpl."+langcode+"?page=1" :"tpl."+langcode+"?page=7";
        }
    }).state("app.admin_add", {
        url:"/admin_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[9] ? "tpl."+langcode+"?page=0" :"tpl."+langcode+"?page=7";
        }
    }).state("app.member_list", {
        url:"/member_list/:page",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[9] ? "tpl."+langcode+"?page=22" :"tpl."+langcode+"?page=7";
        }
    }).state("app.need", {
        url:"/need/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[9] ? "tpl."+langcode+"?page=82" :"tpl."+langcode+"?page=7";
        }
    }).state("app.agreement", {
        url:"/agreement/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[9] ? "tpl."+langcode+"?page=90" :"tpl."+langcode+"?page=7";
        }
    }).state("app.member_add", {
        url:"/member_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[9] ? "tpl."+langcode+"?page=21" :"tpl."+langcode+"?page=7";
        }
    }).state("app.safe", {
        url:"/safe/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[11] ? "tpl."+langcode+"?page=40" :"tpl."+langcode+"?page=7";
        }
    }).state("app.space", {
        url:"/space/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[11] ? "tpl."+langcode+"?page=46" :"tpl."+langcode+"?page=7";
        }
    }).state("app.lv", {
        url:"/lv/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[9] ? "tpl."+langcode+"?page=15" :"tpl."+langcode+"?page=7";
        }
    }).state("app.lv_add", {
        url:"/lv_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[9] ? "tpl."+langcode+"?page=16" :"tpl."+langcode+"?page=7";
        }
    }).state("app.file", {
        url:"/file/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[11] ? "tpl."+langcode+"?page=8" :"tpl."+langcode+"?page=7";
        }
    }).state("app.data", {
        url:"/data/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[11] ? "tpl."+langcode+"?page=70" :"tpl."+langcode+"?page=7";
        }
    }).state("app.search", {
        url:"/search/:key",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=41" :"tpl."+langcode+"?page=7";
        }
    }).state("app.template_html", {
        url:"/template_html/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[6] ? "tpl."+langcode+"?page=49" :"tpl."+langcode+"?page=7";
        }
    }).state("app.template_edit", {
        url:"/template_edit/:id/:name",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[6] ? "tpl."+langcode+"?page=48" :"tpl."+langcode+"?page=7";
        }
    }).state("app.w_config", {
        url:"/w_config",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=55" :"tpl."+langcode+"?page=7";
        }
    }).state("app.w_menu", {
        url:"/w_menu",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=59" :"tpl."+langcode+"?page=7";
        }
    }).state("app.w_menu_add", {
        url:"/w_menu_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=60" :"tpl."+langcode+"?page=7";
        }
    }).state("app.w_msg", {
        url:"/w_msg",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=61" :"tpl."+langcode+"?page=7";
        }
    }).state("app.w_reply", {
        url:"/w_reply",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=62" :"tpl."+langcode+"?page=7";
        }
    }).state("app.w_reply_add", {
        url:"/w_reply_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=63" :"tpl."+langcode+"?page=7";
        }
    }).state("app.w_event", {
        url:"/w_event",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=56" :"tpl."+langcode+"?page=7";
        }
    }).state("app.w_event_add", {
        url:"/w_event_add/:id",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=57" :"tpl."+langcode+"?page=7";
        }
    }).state("app.w_member", {
        url:"/w_member/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[1] ? "tpl."+langcode+"?page=58" :"tpl."+langcode+"?page=7";
        }
    }).state("app.recycle", {
        url:"/recycle/:x",
        templateUrl:function() {
            return null !== getCookie("auth") && 1 == getCookie("auth").split("|")[11] ? "tpl."+langcode+"?page=91" :"tpl."+langcode+"?page=7";
        }
    }).state("app.sql", {
        url:"/sql",
        templateUrl:"tpl."+langcode+"?page=68"
    }).state("access", {
        url:"/access",
        template:'<div ui-view class="fade-in-right-big smooth"></div>',
        resolve:{
            deps:[ "uiLoad", function(a) {
                return a.load([ "js/controller.min.js?v="+Math.random() ]);
            } ]
        }
    }).state("access.signin", {
        url:"/signin",
        templateUrl:"tpl."+langcode+"?page=31"
    }).state("access.forgotpwd", {
        url:"/forgotpwd",
        templateUrl:"tpl."+langcode+"?page=30"
    });
} ]), angular.module("app").controller("AppCtrl", [ "$scope", "$state", "$modal", "$window", "$sce", "$http","$interval" ,function(a, b, c, d, e, f, $interval) {

    a.$on('auth', function(event, data) {  
            a.auth0 = data.split("|")[0];
            a.auth1 = data.split("|")[1];
            a.auth2 = data.split("|")[2];
            a.auth3 = data.split("|")[3];
            a.auth4 = data.split("|")[4];
            a.auth5 = data.split("|")[5];
            a.auth6 = data.split("|")[6];
            a.auth7 = data.split("|")[7];
            a.auth8 = data.split("|")[8];
            a.auth9 = data.split("|")[9];
            a.auth10 = data.split("|")[10];
            a.auth11 = data.split("|")[11];
        });  

    function k(a) {
        var b = a["navigator"]["userAgent"] || a["navigator"]["vendor"] || a["opera"];
        return /iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/.test(b);
    }
    var h, i, j, g = !!navigator.userAgent.match(/MSIE/i);
    g && angular.element(d.document.body).addClass("ie"), k(d) && angular.element(d.document.body).addClass("smart"), 
    a.app = {
        name:"后台管理",
        version:"1.3.3",
        color:{
            primary:"#7266ba",
            info:"#23b7e5",
            success:"#27c24c",
            warning:"#fad733",
            danger:"#f05050",
            light:"#e8eff0",
            dark:"#3a3f51",
            black:"#1c2b36"
        },
        settings:{
            themeID:1,
            navbarHeaderColor:"bg-black",
            navbarCollapseColor:"bg-white-only",
            asideColor:"bg-black",
            headerFixed:!0,
            asideFixed:!0,
            asideFolded:!1,
            asideDock:!1,
            container:!1
        }
    }, a.alerthide = !0, f.get("data."+langcode+"?action=configx").success(function(d) {
        a.c = d;
        h = d.lang;
        i = d.C_delang;
        j = d.C_lang;
        a.onum = d.onum;
        a.fnum = d.fnum;
        a.fen_num = d.fen_num;
        a.money_num = d.money_num;
        a.C_dir = d.C_dir;
        a.domain = d.domain;
        a.C_template = d.C_template;
        a.$on('template', function(e, data) {a.C_template = data;});
        a.C_db = d.C_db;
        a.$on('db', function(e, data) {a.C_db = data;});
        a.C_wap = d.C_wap;
        a.$on('wap', function(e, data) {a.C_wap = data;});
        a.C_tag = d.C_tag;
        a.$on('tag', function(e, data) {a.C_tag = data;});
        a.C_ico = d.C_ico;
        a.gnum = d.gnum;
        a.pnum = d.pnum;
        a.nnum = d.nnum;
        a.anum = d.anum;
        a.auth = d.auth;
        a.lang = d.lang;
        a.langcode = langcode;
        a.wxapp = d.wxapp;
        a.ktapp = d.app;
        a.https = d.https;
        
        if(document.cookie.indexOf("auth")!=-1){
            a.auth0 = getCookie("auth").split("|")[0];
            a.auth1 = getCookie("auth").split("|")[1];
            a.auth2 = getCookie("auth").split("|")[2];
            a.auth3 = getCookie("auth").split("|")[3];
            a.auth4 = getCookie("auth").split("|")[4];
            a.auth5 = getCookie("auth").split("|")[5];
            a.auth6 = getCookie("auth").split("|")[6];
            a.auth7 = getCookie("auth").split("|")[7];
            a.auth8 = getCookie("auth").split("|")[8];
            a.auth9 = getCookie("auth").split("|")[9];
            a.auth10 = getCookie("auth").split("|")[10];
            a.auth11 = getCookie("auth").split("|")[11];
        }

        a.C_langtitle0 = d.C_langtitle0;
        a.C_langtitle1 = d.C_langtitle1;
        a.C_langtitle2 = d.C_langtitle2;

        a.C_version = d.C_version;
        a.C_lang = d.C_lang;
        a.C_auth_close = d.C_auth_close;
        a.C_from = d.C_from;
        a.C_t_show = d.C_t_show;
        a.C_sort = d.C_sort;
        a.$on('sort', function(e, data) {a.C_sort = data;});
        a.C_x_show = d.C_x_show;
        $("#ico").attr("href","../"+d.C_ico);
        (j+"").indexOf(",")<0 ? (a.selectLang = "<i class='fa fa-times-circle'></i> 关闭多语言", 
        a.lcss = "", a.alerthide = !0) :(a.alerthide = !1, "0" == h && (a.selectLang = "<img src='../images/0.png'> "+a.C_langtitle0, 
        a.lcss = "cn"), "1" == h && (a.selectLang = "<img src='../images/1.png'> "+a.C_langtitle2, 
        a.lcss = "en")), a.alerts = [ {
            type:"warning",
            msg:'带 <img src="img/' + h + '.png"> 标志的输入框需单独设置。'
        } ]
         a.closeAlert = function(b) {
            a.alerts.splice(b, 1);
        }
         a.update = function(a) {
        c.open({
            template:'<div class="modal-header"><span style="font-size:14px;">检测更新</span> <button class="btn btn-info btn-xs pull-right" ng-click="cancel()">×</button></div><iframe src="update2.'+langcode+'" type="1" frameborder="0" height="600" width="100%"></iframe>',controller:"ModalInstanceCtrl",size:"lg"});
        }
        a.checkmm = function(a) {
        c.open({
            template:'<div class="modal-header"><span style="font-size:14px;">检测木马</span> <button class="btn btn-info btn-xs pull-right" ng-click="cancel()">×</button></div><iframe src="../checkmm.'+langcode+'" type="1" frameborder="0" height="610" width="100%"></iframe>',controller:"ModalInstanceCtrl",size:"lg"});
        }
        a.tophp = function(a) {
        c.open({
            template:'<div class="modal-header"><span style="font-size:14px;">ASP版转PHP版</span> <button class="btn btn-info btn-xs pull-right" ng-click="cancel()">×</button></div><iframe src="tophp.'+langcode+'" type="1" frameborder="0" height="610" width="100%"></iframe>',controller:"ModalInstanceCtrl",size:"lg"});
        }

/*
$interval(function(){  
f.get("data."+langcode+"?action=configx").success(function(response) {
if(response.anum!==a.anum){
if(response.anum>a.anum){
playSound()
}
a.gnum = response.gnum;
a.pnum = response.pnum;
a.nnum = response.nnum;
a.anum = response.anum;
a.fnum = response.fnum;
a.fen_num = response.fen_num;
a.money_num = response.money_num;
}
    });
},10000);  
*/

    a.getauth = function() {

            c.open({
                template:'<div class="modal-header"><span style="font-size:14px;">购买授权</span> <button class="btn btn-info btn-xs pull-right" ng-click="cancel()">×</button></div><iframe src="https://www.s-cms.cn/payx/?domain=' + d.domain + "&product=auth&url=" + d.url + '" type="1" frameborder="0" height="600" width="100%"></iframe>',
                controller:"ModalInstanceCtrl",
                size:"lg"
            });
        }


        a.bug = function() {
            c.open({
                template:'<div class="modal-header"><span style="font-size:14px;">BUG反馈</span> </div><div style="padding:10px;"><form style="padding:10px;" id="bug"><textarea name="bug" placeholder="BUG详细描述" class="form-control" style="margin-bottom:10px;"></textarea><input type="text" name="page" placeholder="出现页面" class="form-control" style="margin-bottom:10px;"><select name="times"  class="form-control" style="margin-bottom:10px;"><option value="持续出现">持续出现</option><option value="间歇出现">间歇出现</option></select><input type="text" name="email" placeholder="电子邮箱" class="form-control" style="margin-bottom:10px;"><div class="input-group" style="margin-bottom:10px;"><input type="text" name="code" placeholder="验证码" class="form-control"><span class="input-group-addon" style="padding:0px;"><img onclick="refresh1()" id="vcode" src="../conn/code_1.'+langcode+'"></span></div><button class="btn btn-info" ng-click="sendbug()">确定提交</button></form></div>',
                controller:"ModalInstanceCtrl",
                size:"lg"
            });
        }


        a.getcode = function() {
            c.open({
                template:'<div class="modal-header"><span style="font-size:14px;">填写授权码</span> </div><div style="padding:10px;">如果您已经获得授权码，请在左侧填写并验证<br>如果您还没有授权码，请点击 <a ng-click="getauth()" class="btn btn-xs btn-info">购买</a></div>',
                controller:"AppCtrl",
                size:"lg"
            });
        }

        a.choose=function(a,b){
            if(b==undefined || b=="undefined"){
                b="../media"
            }
            c.open({
                template:'<style>.box{margin:2px;padding:5px;display: inline-block;cursor:pointer;width: 50px;height: 50px;border-radius: 10px; vertical-align:top;border:solid 1px #EEEEEE;text-align: center;}.box:hover{background: #EEEEEE;}</style><div class="modal-header"><span style="font-size:14px;">选择图片素材</span> <button class="btn btn-info btn-xs pull-right" ng-click="managepic()">管理素材</button></div><div><img alt="<img src={{x.filepic}} width=400>" ng-repeat="x in file_list" ng-src="{{x.filepic}}" ng-click="choosepic(\''+a+'\',x.filename)" class="box"><div></iframe>',
                controller:"file_Ctrlx",
                size:"lg"
            });
        }
        
         a.showUpload=function(a,b){
            if(b==undefined || b=="undefined"){
                b="../media"
            }
            if(!isNaN(a)){
            tid="#pic_"+a
            }else{
            tid="#"+a
            }
            processid=getID();
            $(tid).parent().append("<input type='file' id='testFile"+a+"' style='display:none;' onchange='aaa(\""+a+"\",\""+b+"\")'/>");
            $("#testFile"+a).trigger("click");
        }, 
        a.setLang = function(a) {
            1 == d.x7 ? (ajaxx("ajax."+langcode+"?type=setlang&setlang=" + a, "reload", "", 1, "")) :(toastr.error("请先购买插件后再使用双语功能！"), 
            b.go("app.plug"));
        };
    }), a.alerts = [ {
        type:"success",
        msg:'带 <img src="img/' + a.C_lang + '.png"> 标志的输入框需单独设置。'
    } ], a.closeAlert = function(b) {
        a.alerts.splice(b, 1);
    }, a.trust = function(a) {
        return e.trustAsHtml(a);
    }, a.istrue = function(a) {
        return "" == a || null == a ? !1 :!0;
    },a.ptitle = function(a) {
        if(a==1){
            return "产品"
        }
        if(a==2){
            return "相册"
        }
        if(a==3){
            return "相册"
        }
        if(a==4){
            return "相册"
        }
        if(a==5){
            return "科室/医生"
        }
        if(a==6){
            return "相册"
        }
    },a.ptitle2 = function(a) {
        if(a==1){
            return "/案例"
        }
        if(a==2){
            return "管理"
        }
        if(a==3){
            return "管理"
        }
        if(a==4){
            return "管理"
        }
        if(a==5){
            return ""
        }
        if(a==6){
            return "管理"
        }
    },a.ttitle = function(a) {
        if(a==1){
            return "简介"
        }
        if(a==2){
            return "公告"
        }
        if(a==3){
            return "专题"
        }
        if(a==4){
            return "简介"
        }
        if(a==5){
            return "简介"
        }
        if(a==6){
            return "简介"
        }
    },a.ntitle = function(a) {
        if(a==1){
            return "新闻"
        }
        if(a==2){
            return "文章"
        }
        if(a==3){
            return "新闻"
        }
        if(a==4){
            return "新闻"
        }
        if(a==5){
            return "新闻"
        }
        if(a==6){
            return "文章"
        }
    },a.ntitle2 = function(a) {
        if(a==1){
            return "/下载"
        }
        if(a==2){
            return "管理"
        }
        if(a==3){
            return "管理"
        }
        if(a==4){
            return "管理"
        }
        if(a==5){
            return "管理"
        }
        if(a==6){
            return "管理"
        }
    }, a.isSelected = function(a) {
        return a >= 1 ? !0 :!1;
    }, a.isSelected2 = function(a, b) {
        return a == b ? !0 :!1;
    }, a.ishave = function(x, y) {
        if((x+"").indexOf(y)>=0){
            return true;
         }else{
            return false;
         }
    }, a.istrue2 = function(a) {
        if(a=="true" || a=="True"){
            return true;
        }
        if(a=="false" || a=="False"){
            return false;
        }
    }, a.isfrom = function(a) {
        if(a=="free2"){
            return true;
        }else{
            return false;
        }
    };
} ]), app.controller("ModalInstanceCtrl", [ "$scope", "$modalInstance", "$state",function(a, b,c) {
    a.tosqll=function(){
        ajaxx("ajax."+langcode+"?type=tosqll", "reload", $("#sql").serialize(), 1, "");
        a.$emit('db', 'mssql');
    }
    a.editadmin=function(){
        ajaxx("ajax."+langcode+"?type=editadmin", "../"+$("#adminpath").val(), $("#editadmin").serialize(), 3, "");
    }

    a.sendbug=function(){
        ajaxx("ajax."+langcode+"?type=bug", "", $("#bug").serialize(), 2, "");
    }

    a.mail=function(){
        ajaxx("ajax."+langcode+"?type=testmail", "", $("#mail").serialize(), 2, "");
    }
    a.mobile=function(){
        ajaxx("ajax."+langcode+"?type=testmobile", "", $("#mobile").serialize(), 2, "");
    }
    a.savetxt=function(a){
        ajaxx("ajax."+langcode+"?type=savetxt&path="+a, "", $("#txt").serialize(), 2, "");
        b.dismiss("cancel");
    }
    a.savetag=function(){
        ajaxx("ajax."+langcode+"?type=savetag", "", $("#txt").serialize(), 2, "");
        b.dismiss("cancel");
    }
    a.cancel = function() {
        b.dismiss("cancel");
    };
    a.goto = function(str) {
        c.go("app."+str);
        b.dismiss("cancel");
    };
} ]), 


app.controller("file_Ctrlx", [ "$scope", "$modalInstance", "$state","$http",function($scope, $modalInstance,$state,$http) {
$http.get("data."+langcode+"?action=file"+"&lang="+$scope.lang).success(function(response) {
        $scope.file_list = response.file_list;
    });

$scope.choosepic=function(a,b){
            $("#"+a).val("media/"+b);
            $("#"+a+"x").attr("src","../media/"+b);
            $modalInstance.dismiss("cancel");
        }

$scope.managepic=function(){
            window.location="#/app/file/";
            $modalInstance.dismiss("cancel");
        }
} ]), 

app.controller("TypeaheadDemoCtrl", [ "$scope", "$http", function(a, b) {
    a.selected = void 0, a.states = [ "Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Dakota", "North Carolina", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming" ], 
    a.getLocation = function(a) {
        return b.get("http://maps.googleapis.com/maps/api/geocode/json", {
            params:{
                address:a,
                sensor:!1
            }
        }).then(function(a) {
            var b = [];
            return angular.forEach(a.data.results, function(a) {
                b.push(a.formatted_address);
            }), b;
        });
    };
} ]), angular.module("ui.load", []).service("uiLoad", [ "$document", "$q", "$timeout", function(a, b, c) {
    var d = [], e = !1, f = b.defer();
    this.load = function(a) {
        a = angular.isArray(a) ? a :a.split(/\s+/);
        var b = this;
        return e || (e = f.promise), angular.forEach(a, function(a) {
            e = e.then(function() {
                return a.indexOf(".css") >= 0 ? b.loadCSS(a) :b.loadScript(a);
            });
        }), f.resolve(), e;
    }, this.loadScript = function(e) {
        var f, g;
        return d[e] ? d[e].promise :(f = b.defer(), g = a[0].createElement("script"), g.src = e, 
        g.onload = function(a) {
            c(function() {
                f.resolve(a);
            });
        }, g.onerror = function(a) {
            c(function() {
                f.reject(a);
            });
        }, a[0].body.appendChild(g), d[e] = f, f.promise);
    }, this.loadCSS = function(e) {
        var f, g;
        return d[e] ? d[e].promise :(f = b.defer(), g = a[0].createElement("link"), g.rel = "stylesheet", 
        g.type = "text/css", g.href = e, g.onload = function(a) {
            c(function() {
                f.resolve(a);
            });
        }, g.onerror = function(a) {
            c(function() {
                f.reject(a);
            });
        }, a[0].head.appendChild(g), d[e] = f, f.promise);
    };
} ]), angular.module("ui.jq", [ "ui.load" ]).value("uiJqConfig", {}).directive("uiJq", [ "uiJqConfig", "JQ_CONFIG", "uiLoad", "$timeout", function(a, b, c, d) {
    return {
        restrict:"A",
        compile:function(e, f) {
            if (!angular.isFunction(e[f.uiJq]) && !b[f.uiJq]) throw new Error('ui-jq: The "' + f.uiJq + '" function does not exist');
            var g = a && a[f.uiJq];
            return function(a, e, f) {
                function h() {
                    var b = [];
                    return f.uiOptions ? (b = a.$eval("[" + f.uiOptions + "]"), angular.isObject(g) && angular.isObject(b[0]) && (b[0] = angular.extend({}, g, b[0]))) :g && (b = [ g ]), 
                    b;
                }
                function i() {
                    d(function() {
                        e[f.uiJq].apply(e, h());
                    }, 0, !1);
                }
                function j() {
                    f.uiRefresh && a.$watch(f.uiRefresh, function() {
                        i();
                    });
                }
                f.ngModel && e.is("select,input,textarea") && e.bind("change", function() {
                    e.trigger("input");
                }), b[f.uiJq] ? c.load(b[f.uiJq]).then(function() {
                    i(), j();
                }).catch(function() {}) :(i(), j());
            };
        }
    };
} ]), angular.module("app").directive("uiNav", [ "$timeout", function() {
    return {
        restrict:"AC",
        link:function(a, b) {
            var g, d = $(window), e = 768, f = $(".app-aside"), h = ".dropdown-backdrop";
            b.on("click", "a", function(a) {
                g && g.trigger("mouseleave.nav");
                var b = $(this);
                b.parent().siblings(".active").toggleClass("active"), b.next().is("ul") && b.parent().toggleClass("active") && a.preventDefault(), 
                b.next().is("ul") || d.width() < e && $(".app-aside").removeClass("show off-screen");
            }), b.on("mouseenter", "a", function(a) {
                if (g && g.trigger("mouseleave.nav"), $("> .nav", f).remove(), !(!$(".app-aside-fixed.app-aside-folded").length || d.width() < e || $(".app-aside-dock").length)) {
                    var c, b = $(a.target), i = $(window).height(), j = 50, k = 150;
                    !b.is("a") && (b = b.closest("a")), b.next().is("ul") && (g = b.next(), b.parent().addClass("active"), 
                    c = b.parent().position().top + j, g.css("top", c), c + g.height() > i && g.css("bottom", 0), 
                    c + k > i && g.css("bottom", i - c - j).css("top", "auto"), g.appendTo(f), g.on("mouseleave.nav", function() {
                        $(h).remove(), g.appendTo(b.parent()), g.off("mouseleave.nav").css("top", "auto").css("bottom", "auto"), 
                        b.parent().removeClass("active");
                    }), $(".smart").length && $('<div class="dropdown-backdrop"/>').insertAfter(".app-aside").on("click", function(a) {
                        a && a.trigger("mouseleave.nav");
                    }));
                }
            }), f.on("mouseleave", function() {
                g && g.trigger("mouseleave.nav"), $("> .nav", f).remove();
            });
        }
    };
} ]), pltsPop = null, pltsoffsetX = 3, pltsoffsetY = 5, pltsPopbg = "#F6FDDC", pltsPopfg = "#DEDBDE", 
pltsTitle = "", document.write('<div id="pltsTipLayer" style="display: none;position: absolute; z-index:10001;background:#FFFFFF; padding:5px; border:#DDDDDD solid 1px;"></div>'), 
pltsTipLayer = document.getElementById("pltsTipLayer"), pltsinits(), function(a) {
    a([ "jquery" ], function(a) {
        return function() {
            function g(a, b, c) {
                return t({
                    type:e.error,
                    iconClass:u().iconClasses.error,
                    message:a,
                    optionsOverride:c,
                    title:b
                });
            }
            function h(c, d) {
                return c || (c = u()), b = a("#" + c.containerId), b.length ? b :(d && (b = q(c)), 
                b);
            }
            function i(a, b, c) {
                return t({
                    type:e.info,
                    iconClass:u().iconClasses.info,
                    message:a,
                    optionsOverride:c,
                    title:b
                });
            }
            function j(a) {
                c = a;
            }
            function k(a, b, c) {
                return t({
                    type:e.success,
                    iconClass:u().iconClasses.success,
                    message:a,
                    optionsOverride:c,
                    title:b
                });
            }
            function l(a, b, c) {
                return t({
                    type:e.warning,
                    iconClass:u().iconClasses.warning,
                    message:a,
                    optionsOverride:c,
                    title:b
                });
            }
            function m(a) {
                var c = u();
                b || h(c), p(a, c) || o(c);
            }
            function n(c) {
                var d = u();
                return b || h(d), c && 0 === a(":focus", c).length ? (v(c), void 0) :(b.children().length && b.remove(), 
                void 0);
            }
            function o(c) {
                var e, d = b.children();
                for (e = d.length - 1; e >= 0; e--) p(a(d[e]), c);
            }
            function p(b, c) {
                return b && 0 === a(":focus", b).length ? (b[c.hideMethod]({
                    duration:c.hideDuration,
                    easing:c.hideEasing,
                    complete:function() {
                        v(b);
                    }
                }), !0) :!1;
            }
            function q(c) {
                return b = a("<div/>").attr("id", c.containerId).addClass(c.positionClass).attr("aria-live", "polite").attr("role", "alert"), 
                b.appendTo(a(c.target)), b;
            }
            function r() {
                return {
                    tapToDismiss:!0,
                    toastClass:"toast",
                    containerId:"toast-container",
                    debug:!1,
                    showMethod:"fadeIn",
                    showDuration:300,
                    showEasing:"swing",
                    onShown:void 0,
                    hideMethod:"fadeOut",
                    hideDuration:1e3,
                    hideEasing:"swing",
                    onHidden:void 0,
                    extendedTimeOut:1e3,
                    iconClasses:{
                        error:"toast-error",
                        info:"toast-info",
                        success:"toast-success",
                        warning:"toast-warning"
                    },
                    iconClass:"toast-info",
                    positionClass:"toast-top-right",
                    timeOut:5e3,
                    titleClass:"toast-title",
                    messageClass:"toast-message",
                    target:"body",
                    closeHtml:"<button>&times;</button>",
                    newestOnTop:!0
                };
            }
            function s(a) {
                c && c(a);
            }
            function t(c) {
                function n(b) {
                    return !a(":focus", i).length || b ? i[e.hideMethod]({
                        duration:e.hideDuration,
                        easing:e.hideEasing,
                        complete:function() {
                            v(i), e.onHidden && "hidden" !== m.state && e.onHidden(), m.state = "hidden", m.endTime = new Date(), 
                            s(m);
                        }
                    }) :void 0;
                }
                function o() {
                    (e.timeOut > 0 || e.extendedTimeOut > 0) && (g = setTimeout(n, e.extendedTimeOut));
                }
                function p() {
                    clearTimeout(g), i.stop(!0, !0)[e.showMethod]({
                        duration:e.showDuration,
                        easing:e.showEasing
                    });
                }
                var g, i, j, k, l, m, e = u(), f = c.iconClass || e.iconClass;
                return "undefined" != typeof c.optionsOverride && (e = a.extend(e, c.optionsOverride), 
                f = c.optionsOverride.iconClass || f), d++, b = h(e, !0), g = null, i = a("<div/>"), 
                j = a("<div/>"), k = a("<div/>"), l = a(e.closeHtml), m = {
                    toastId:d,
                    state:"visible",
                    startTime:new Date(),
                    options:e,
                    map:c
                }, c.iconClass && i.addClass(e.toastClass).addClass(f), c.title && (j.append(c.title).addClass(e.titleClass), 
                i.append(j)), c.message && (k.append(c.message).addClass(e.messageClass), i.append(k)), 
                e.closeButton && (l.addClass("toast-close-button").attr("role", "button"), i.prepend(l)), 
                i.hide(), e.newestOnTop ? b.prepend(i) :b.append(i), i[e.showMethod]({
                    duration:e.showDuration,
                    easing:e.showEasing,
                    complete:e.onShown
                }), e.timeOut > 0 && (g = setTimeout(n, e.timeOut)), i.hover(p, o), !e.onclick && e.tapToDismiss && i.click(n), 
                e.closeButton && l && l.click(function(a) {
                    a.stopPropagation ? a.stopPropagation() :void 0 !== a.cancelBubble && a.cancelBubble !== !0 && (a.cancelBubble = !0), 
                    n(!0);
                }), e.onclick && i.click(function() {
                    e.onclick(), n();
                }), s(m), e.debug && console && console.log(m), i;
            }
            function u() {
                return a.extend({}, r(), f.options);
            }
            function v(a) {
                b || (b = h()), a.is(":visible") || (a.remove(), a = null, 0 === b.children().length && b.remove());
            }
            var b, c, d = 0, e = {
                error:"error",
                info:"info",
                success:"success",
                warning:"warning"
            }, f = {
                clear:m,
                remove:n,
                error:g,
                getContainer:h,
                info:i,
                options:{},
                subscribe:j,
                success:k,
                version:"2.0.3",
                warning:l
            };
            return f;
        }();
    });
}("function" == typeof define && define.amd ? define :function(a, b) {
    "undefined" != typeof module && module.exports ? module.exports = b(require("jquery")) :window["toastr"] = b(window["jQuery"]);
}), toastr.options = {
    closeButton:!0,
    debug:!1,
    positionClass:"toast-bottom-right",
    onclick:null,
    showDuration:"300",
    hideDuration:"1000",
    timeOut:"3000",
    extendedTimeOut:"1000",
    showEasing:"swing",
    hideEasing:"linear",
    showMethod:"fadeIn",
    hideMethod:"fadeOut"
};
angular.module('app')
  .directive('uiToggleClass', ['$timeout', '$document', function($timeout, $document) {
    return {
      restrict: 'AC',
      link: function(scope, el, attr) {
        el.on('click', function(e) {
          e.preventDefault();
          var classes = attr.uiToggleClass.split(','),
              targets = (attr.target && attr.target.split(',')) || Array(el),
              key = 0;
          angular.forEach(classes, function( _class ) {
            var target = targets[(targets.length && key)];            
            ( _class.indexOf( '*' ) !== -1 ) && magic(_class, target);
            $( target ).toggleClass(_class);
            key ++;
          });
          $(el).toggleClass('active');

          function magic(_class, target){
            var patt = new RegExp( '\\s' + 
                _class.
                  replace( /\*/g, '[A-Za-z0-9-_]+' ).
                  split( ' ' ).
                  join( '\\s|\\s' ) + 
                '\\s', 'g' );
            var cn = ' ' + $(target)[0].className + ' ';
            while ( patt.test( cn ) ) {
              cn = cn.replace( patt, ' ' );
            }
            $(target)[0].className = $.trim( cn );
          }
        });
      }
    };
  }]);
  

  jQuery&&function(e){function t(t,n){var r=e('<div class="minicolors" />'),i=e.minicolors.defaults;if(t.data("minicolors-initialized"))return;n=e.extend(!0,{},i,n);r.addClass("minicolors-theme-"+n.theme).toggleClass("minicolors-with-opacity",n.opacity);n.position!==undefined&&e.each(n.position.split(" "),function(){r.addClass("minicolors-position-"+this)});t.addClass("minicolors-input").data("minicolors-initialized",!1).data("minicolors-settings",n).prop("size",7).wrap(r).after('<div class="minicolors-panel minicolors-slider-'+n.control+'">'+'<div class="minicolors-slider">'+'<div class="minicolors-picker"></div>'+"</div>"+'<div class="minicolors-opacity-slider">'+'<div class="minicolors-picker"></div>'+"</div>"+'<div class="minicolors-grid">'+'<div class="minicolors-grid-inner"></div>'+'<div class="minicolors-picker"><div></div></div>'+"</div>"+"</div>");if(!n.inline){t.after('<span class="minicolors-swatch"><span class="minicolors-swatch-color"></span></span>');t.next(".minicolors-swatch").on("click",function(e){e.preventDefault();t.focus()})}t.parent().find(".minicolors-panel").on("selectstart",function(){return!1}).end();n.inline&&t.parent().addClass("minicolors-inline");u(t,!1);t.data("minicolors-initialized",!0)}function n(e){var t=e.parent();e.removeData("minicolors-initialized").removeData("minicolors-settings").removeProp("size").removeClass("minicolors-input");t.before(e).remove()}function r(e){var t=e.parent(),n=t.find(".minicolors-panel"),r=e.data("minicolors-settings");if(!e.data("minicolors-initialized")||e.prop("disabled")||t.hasClass("minicolors-inline")||t.hasClass("minicolors-focus"))return;i();t.addClass("minicolors-focus");n.stop(!0,!0).fadeIn(r.showSpeed,function(){r.show&&r.show.call(e.get(0))})}function i(){e(".minicolors-input").each(function(){var t=e(this),n=t.data("minicolors-settings"),r=t.parent();if(n.inline)return;r.find(".minicolors-panel").fadeOut(n.hideSpeed,function(){r.hasClass("minicolors-focus")&&n.hide&&n.hide.call(t.get(0));r.removeClass("minicolors-focus")})})}function s(e,t,n){var r=e.parents(".minicolors").find(".minicolors-input"),i=r.data("minicolors-settings"),s=e.find("[class$=-picker]"),u=e.offset().left,a=e.offset().top,f=Math.round(t.pageX-u),l=Math.round(t.pageY-a),c=n?i.animationSpeed:0,h,p,d,v;if(t.originalEvent.changedTouches){f=t.originalEvent.changedTouches[0].pageX-u;l=t.originalEvent.changedTouches[0].pageY-a}f<0&&(f=0);l<0&&(l=0);f>e.width()&&(f=e.width());l>e.height()&&(l=e.height());if(e.parent().is(".minicolors-slider-wheel")&&s.parent().is(".minicolors-grid")){h=75-f;p=75-l;d=Math.sqrt(h*h+p*p);v=Math.atan2(p,h);v<0&&(v+=Math.PI*2);if(d>75){d=75;f=75-75*Math.cos(v);l=75-75*Math.sin(v)}f=Math.round(f);l=Math.round(l)}e.is(".minicolors-grid")?s.stop(!0).animate({top:l+"px",left:f+"px"},c,i.animationEasing,function(){o(r,e)}):s.stop(!0).animate({top:l+"px"},c,i.animationEasing,function(){o(r,e)})}function o(e,t){function n(e,t){var n,r;if(!e.length||!t)return null;n=e.offset().left;r=e.offset().top;return{x:n-t.offset().left+e.outerWidth()/2,y:r-t.offset().top+e.outerHeight()/2}}var r,i,s,o,u,f,l,h=e.val(),d=e.attr("data-opacity"),v=e.parent(),g=e.data("minicolors-settings"),y=v.find(".minicolors-swatch"),b=v.find(".minicolors-grid"),w=v.find(".minicolors-slider"),E=v.find(".minicolors-opacity-slider"),S=b.find("[class$=-picker]"),x=w.find("[class$=-picker]"),T=E.find("[class$=-picker]"),N=n(S,b),C=n(x,w),k=n(T,E);if(t.is(".minicolors-grid, .minicolors-slider")){switch(g.control){case"wheel":o=b.width()/2-N.x;u=b.height()/2-N.y;f=Math.sqrt(o*o+u*u);l=Math.atan2(u,o);l<0&&(l+=Math.PI*2);if(f>75){f=75;N.x=69-75*Math.cos(l);N.y=69-75*Math.sin(l)}i=p(f/.75,0,100);r=p(l*180/Math.PI,0,360);s=p(100-Math.floor(C.y*(100/w.height())),0,100);h=m({h:r,s:i,b:s});w.css("backgroundColor",m({h:r,s:i,b:100}));break;case"saturation":r=p(parseInt(N.x*(360/b.width()),10),0,360);i=p(100-Math.floor(C.y*(100/w.height())),0,100);s=p(100-Math.floor(N.y*(100/b.height())),0,100);h=m({h:r,s:i,b:s});w.css("backgroundColor",m({h:r,s:100,b:s}));v.find(".minicolors-grid-inner").css("opacity",i/100);break;case"brightness":r=p(parseInt(N.x*(360/b.width()),10),0,360);i=p(100-Math.floor(N.y*(100/b.height())),0,100);s=p(100-Math.floor(C.y*(100/w.height())),0,100);h=m({h:r,s:i,b:s});w.css("backgroundColor",m({h:r,s:i,b:100}));v.find(".minicolors-grid-inner").css("opacity",1-s/100);break;default:r=p(360-parseInt(C.y*(360/w.height()),10),0,360);i=p(Math.floor(N.x*(100/b.width())),0,100);s=p(100-Math.floor(N.y*(100/b.height())),0,100);h=m({h:r,s:i,b:s});b.css("backgroundColor",m({h:r,s:100,b:100}))}e.val(c(h,g.letterCase))}if(t.is(".minicolors-opacity-slider")){g.opacity?d=parseFloat(1-k.y/E.height()).toFixed(2):d=1;g.opacity&&e.attr("data-opacity",d)}y.find("SPAN").css({backgroundColor:h,opacity:d});a(e,h,d)}function u(e,t){var n,r,i,s,o,u,f,l=e.parent(),d=e.data("minicolors-settings"),v=l.find(".minicolors-swatch"),y=l.find(".minicolors-grid"),b=l.find(".minicolors-slider"),w=l.find(".minicolors-opacity-slider"),E=y.find("[class$=-picker]"),S=b.find("[class$=-picker]"),x=w.find("[class$=-picker]");n=c(h(e.val(),!0),d.letterCase);n||(n=c(h(d.defaultValue,!0),d.letterCase));r=g(n);t||e.val(n);if(d.opacity){i=e.attr("data-opacity")===""?1:p(parseFloat(e.attr("data-opacity")).toFixed(2),0,1);isNaN(i)&&(i=1);e.attr("data-opacity",i);v.find("SPAN").css("opacity",i);o=p(w.height()-w.height()*i,0,w.height());x.css("top",o+"px")}v.find("SPAN").css("backgroundColor",n);switch(d.control){case"wheel":u=p(Math.ceil(r.s*.75),0,y.height()/2);f=r.h*Math.PI/180;s=p(75-Math.cos(f)*u,0,y.width());o=p(75-Math.sin(f)*u,0,y.height());E.css({top:o+"px",left:s+"px"});o=150-r.b/(100/y.height());n===""&&(o=0);S.css("top",o+"px");b.css("backgroundColor",m({h:r.h,s:r.s,b:100}));break;case"saturation":s=p(5*r.h/12,0,150);o=p(y.height()-Math.ceil(r.b/(100/y.height())),0,y.height());E.css({top:o+"px",left:s+"px"});o=p(b.height()-r.s*(b.height()/100),0,b.height());S.css("top",o+"px");b.css("backgroundColor",m({h:r.h,s:100,b:r.b}));l.find(".minicolors-grid-inner").css("opacity",r.s/100);break;case"brightness":s=p(5*r.h/12,0,150);o=p(y.height()-Math.ceil(r.s/(100/y.height())),0,y.height());E.css({top:o+"px",left:s+"px"});o=p(b.height()-r.b*(b.height()/100),0,b.height());S.css("top",o+"px");b.css("backgroundColor",m({h:r.h,s:r.s,b:100}));l.find(".minicolors-grid-inner").css("opacity",1-r.b/100);break;default:s=p(Math.ceil(r.s/(100/y.width())),0,y.width());o=p(y.height()-Math.ceil(r.b/(100/y.height())),0,y.height());E.css({top:o+"px",left:s+"px"});o=p(b.height()-r.h/(360/b.height()),0,b.height());S.css("top",o+"px");y.css("backgroundColor",m({h:r.h,s:100,b:100}))}e.data("minicolors-initialized")&&a(e,n,i)}function a(e,t,n){var r=e.data("minicolors-settings"),i=e.data("minicolors-lastChange");if(!i||i.hex!==t||i.opacity!==n){e.data("minicolors-lastChange",{hex:t,opacity:n});if(r.change)if(r.changeDelay){clearTimeout(e.data("minicolors-changeTimeout"));e.data("minicolors-changeTimeout",setTimeout(function(){r.change.call(e.get(0),t,n)},r.changeDelay))}else r.change.call(e.get(0),t,n);e.trigger("change").trigger("input")}}function f(t){var n=h(e(t).val(),!0),r=b(n),i=e(t).attr("data-opacity");if(!r)return null;i!==undefined&&e.extend(r,{a:parseFloat(i)});return r}function l(t,n){var r=h(e(t).val(),!0),i=b(r),s=e(t).attr("data-opacity");if(!i)return null;s===undefined&&(s=1);return n?"rgba("+i.r+", "+i.g+", "+i.b+", "+parseFloat(s)+")":"rgb("+i.r+", "+i.g+", "+i.b+")"}function c(e,t){return t==="uppercase"?e.toUpperCase():e.toLowerCase()}function h(e,t){e=e.replace(/[^A-F0-9]/ig,"");if(e.length!==3&&e.length!==6)return"";e.length===3&&t&&(e=e[0]+e[0]+e[1]+e[1]+e[2]+e[2]);return"#"+e}function p(e,t,n){e<t&&(e=t);e>n&&(e=n);return e}function d(e){var t={},n=Math.round(e.h),r=Math.round(e.s*255/100),i=Math.round(e.b*255/100);if(r===0)t.r=t.g=t.b=i;else{var s=i,o=(255-r)*i/255,u=(s-o)*(n%60)/60;n===360&&(n=0);if(n<60){t.r=s;t.b=o;t.g=o+u}else if(n<120){t.g=s;t.b=o;t.r=s-u}else if(n<180){t.g=s;t.r=o;t.b=o+u}else if(n<240){t.b=s;t.r=o;t.g=s-u}else if(n<300){t.b=s;t.g=o;t.r=o+u}else if(n<360){t.r=s;t.g=o;t.b=s-u}else{t.r=0;t.g=0;t.b=0}}return{r:Math.round(t.r),g:Math.round(t.g),b:Math.round(t.b)}}function v(t){var n=[t.r.toString(16),t.g.toString(16),t.b.toString(16)];e.each(n,function(e,t){t.length===1&&(n[e]="0"+t)});return"#"+n.join("")}function m(e){return v(d(e))}function g(e){var t=y(b(e));t.s===0&&(t.h=360);return t}function y(e){var t={h:0,s:0,b:0},n=Math.min(e.r,e.g,e.b),r=Math.max(e.r,e.g,e.b),i=r-n;t.b=r;t.s=r!==0?255*i/r:0;t.s!==0?e.r===r?t.h=(e.g-e.b)/i:e.g===r?t.h=2+(e.b-e.r)/i:t.h=4+(e.r-e.g)/i:t.h=-1;t.h*=60;t.h<0&&(t.h+=360);t.s*=100/255;t.b*=100/255;return t}function b(e){e=parseInt(e.indexOf("#")>-1?e.substring(1):e,16);return{r:e>>16,g:(e&65280)>>8,b:e&255}}e.minicolors={defaults:{animationSpeed:50,animationEasing:"swing",change:null,changeDelay:0,control:"hue",defaultValue:"",hide:null,hideSpeed:100,inline:!1,letterCase:"lowercase",opacity:!1,position:"bottom left",show:null,showSpeed:100,theme:"default"}};e.extend(e.fn,{minicolors:function(s,o){switch(s){case"destroy":e(this).each(function(){n(e(this))});return e(this);case"hide":i();return e(this);case"opacity":if(o===undefined)return e(this).attr("data-opacity");e(this).each(function(){u(e(this).attr("data-opacity",o))});return e(this);case"rgbObject":return f(e(this),s==="rgbaObject");case"rgbString":case"rgbaString":return l(e(this),s==="rgbaString");case"settings":if(o===undefined)return e(this).data("minicolors-settings");e(this).each(function(){var t=e(this).data("minicolors-settings")||{};n(e(this));e(this).minicolors(e.extend(!0,t,o))});return e(this);case"show":r(e(this).eq(0));return e(this);case"value":if(o===undefined)return e(this).val();e(this).each(function(){u(e(this).val(o))});return e(this);default:s!=="create"&&(o=s);e(this).each(function(){t(e(this),o)});return e(this)}}});e(document).on("mousedown.minicolors touchstart.minicolors",function(t){e(t.target).parents().add(t.target).hasClass("minicolors")||i()}).on("mousedown.minicolors touchstart.minicolors",".minicolors-grid, .minicolors-slider, .minicolors-opacity-slider",function(t){var n=e(this);t.preventDefault();e(document).data("minicolors-target",n);s(n,t,!0)}).on("mousemove.minicolors touchmove.minicolors",function(t){var n=e(document).data("minicolors-target");n&&s(n,t)}).on("mouseup.minicolors touchend.minicolors",function(){e(this).removeData("minicolors-target")}).on("mousedown.minicolors touchstart.minicolors",".minicolors-swatch",function(t){var n=e(this).parent().find(".minicolors-input");t.preventDefault();r(n)}).on("focus.minicolors",".minicolors-input",function(){var t=e(this);if(!t.data("minicolors-initialized"))return;r(t)}).on("blur.minicolors",".minicolors-input",function(){var t=e(this),n=t.data("minicolors-settings");if(!t.data("minicolors-initialized"))return;t.val(h(t.val(),!0));t.val()===""&&t.val(h(n.defaultValue,!0));t.val(c(t.val(),n.letterCase))}).on("keydown.minicolors",".minicolors-input",function(t){var n=e(this);if(!n.data("minicolors-initialized"))return;switch(t.keyCode){case 9:i();break;case 13:case 27:i();n.blur()}}).on("keyup.minicolors",".minicolors-input",function(){var t=e(this);if(!t.data("minicolors-initialized"))return;u(t,!0)}).on("paste.minicolors",".minicolors-input",function(){var t=e(this);if(!t.data("minicolors-initialized"))return;setTimeout(function(){u(t,!0)},1)})}(jQuery);