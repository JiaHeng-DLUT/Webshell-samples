if (function (t, e) {
    "object" == typeof module && "object" == typeof module.exports ? module.exports = t.document ? e(t, !0) : function (t) {
        if (!t.document) throw new Error("jQuery requires a window with a document");
        return e(t)
    } : e(t)
}("undefined" != typeof window ? window : this, function (t, e) {
    function i(t) {
        var e = !!t && "length" in t && t.length, i = rt.type(t);
        return "function" !== i && !rt.isWindow(t) && ("array" === i || 0 === e || "number" == typeof e && e > 0 && e - 1 in t)
    }

    function n(t, e, i) {
        if (rt.isFunction(e)) return rt.grep(t, function (t, n) {
            return !!e.call(t, n, t) !== i
        });
        if (e.nodeType) return rt.grep(t, function (t) {
            return t === e !== i
        });
        if ("string" == typeof e) {
            if (dt.test(e)) return rt.filter(e, t, i);
            e = rt.filter(e, t)
        }
        return rt.grep(t, function (t) {
            return J.call(e, t) > -1 !== i
        })
    }

    function s(t, e) {
        for (; (t = t[e]) && 1 !== t.nodeType;) ;
        return t
    }

    function r(t) {
        var e = {};
        return rt.each(t.match(vt) || [], function (t, i) {
            e[i] = !0
        }), e
    }

    function o() {
        Y.removeEventListener("DOMContentLoaded", o), t.removeEventListener("load", o), rt.ready()
    }

    function a() {
        this.expando = rt.expando + a.uid++
    }

    function l(t, e, i) {
        var n;
        if (void 0 === i && 1 === t.nodeType) if (n = "data-" + e.replace(Ct, "-$&").toLowerCase(), "string" == typeof(i = t.getAttribute(n))) {
            try {
                i = "true" === i || "false" !== i && ("null" === i ? null : +i + "" === i ? +i : At.test(i) ? rt.parseJSON(i) : i)
            } catch (t) {
            }
            _t.set(t, e, i)
        } else i = void 0;
        return i
    }

    function c(t, e, i, n) {
        var s, r = 1, o = 20, a = n ? function () {
                return n.cur()
            } : function () {
                return rt.css(t, e, "")
            }, l = a(), c = i && i[3] || (rt.cssNumber[e] ? "" : "px"),
            u = (rt.cssNumber[e] || "px" !== c && +l) && St.exec(rt.css(t, e));
        if (u && u[3] !== c) {
            c = c || u[3], i = i || [], u = +l || 1;
            do {
                r = r || ".5", u /= r, rt.style(t, e, u + c)
            } while (r !== (r = a() / l) && 1 !== r && --o)
        }
        return i && (u = +u || +l || 0, s = i[1] ? u + (i[1] + 1) * i[2] : +i[2], n && (n.unit = c, n.start = u, n.end = s)), s
    }

    function u(t, e) {
        var i = void 0 !== t.getElementsByTagName ? t.getElementsByTagName(e || "*") : void 0 !== t.querySelectorAll ? t.querySelectorAll(e || "*") : [];
        return void 0 === e || e && rt.nodeName(t, e) ? rt.merge([t], i) : i
    }

    function h(t, e) {
        for (var i = 0, n = t.length; n > i; i++) xt.set(t[i], "globalEval", !e || xt.get(e[i], "globalEval"))
    }

    function d(t, e, i, n, s) {
        for (var r, o, a, l, c, d, p = e.createDocumentFragment(), f = [], g = 0, m = t.length; m > g; g++) if ((r = t[g]) || 0 === r) if ("object" === rt.type(r)) rt.merge(f, r.nodeType ? [r] : r); else if (Nt.test(r)) {
            for (o = o || p.appendChild(e.createElement("div")), a = (Dt.exec(r) || ["", ""])[1].toLowerCase(), l = kt[a] || kt._default, o.innerHTML = l[1] + rt.htmlPrefilter(r) + l[2], d = l[0]; d--;) o = o.lastChild;
            rt.merge(f, o.childNodes), o = p.firstChild, o.textContent = ""
        } else f.push(e.createTextNode(r));
        for (p.textContent = "", g = 0; r = f[g++];) if (n && rt.inArray(r, n) > -1) s && s.push(r); else if (c = rt.contains(r.ownerDocument, r), o = u(p.appendChild(r), "script"), c && h(o), i) for (d = 0; r = o[d++];) Pt.test(r.type || "") && i.push(r);
        return p
    }

    function p() {
        return !0
    }

    function f() {
        return !1
    }

    function g() {
        try {
            return Y.activeElement
        } catch (t) {
        }
    }

    function m(t, e, i, n, s, r) {
        var o, a;
        if ("object" == typeof e) {
            "string" != typeof i && (n = n || i, i = void 0);
            for (a in e) m(t, a, i, n, e[a], r);
            return t
        }
        if (null == n && null == s ? (s = i, n = i = void 0) : null == s && ("string" == typeof i ? (s = n, n = void 0) : (s = n, n = i, i = void 0)), !1 === s) s = f; else if (!s) return t;
        return 1 === r && (o = s, s = function (t) {
            return rt().off(t), o.apply(this, arguments)
        }, s.guid = o.guid || (o.guid = rt.guid++)), t.each(function () {
            rt.event.add(this, e, s, n, i)
        })
    }

    function v(t, e) {
        return rt.nodeName(t, "table") && rt.nodeName(11 !== e.nodeType ? e : e.firstChild, "tr") ? t.getElementsByTagName("tbody")[0] || t.appendChild(t.ownerDocument.createElement("tbody")) : t
    }

    function b(t) {
        return t.type = (null !== t.getAttribute("type")) + "/" + t.type, t
    }

    function y(t) {
        var e = Ft.exec(t.type);
        return e ? t.type = e[1] : t.removeAttribute("type"), t
    }

    function w(t, e) {
        var i, n, s, r, o, a, l, c;
        if (1 === e.nodeType) {
            if (xt.hasData(t) && (r = xt.access(t), o = xt.set(e, r), c = r.events)) {
                delete o.handle, o.events = {};
                for (s in c) for (i = 0, n = c[s].length; n > i; i++) rt.event.add(e, s, c[s][i])
            }
            _t.hasData(t) && (a = _t.access(t), l = rt.extend({}, a), _t.set(e, l))
        }
    }

    function x(t, e) {
        var i = e.nodeName.toLowerCase();
        "input" === i && $t.test(t.type) ? e.checked = t.checked : "input" !== i && "textarea" !== i || (e.defaultValue = t.defaultValue)
    }

    function _(t, e, i, n) {
        e = X.apply([], e);
        var s, r, o, a, l, c, h = 0, p = t.length, f = p - 1, g = e[0], m = rt.isFunction(g);
        if (m || p > 1 && "string" == typeof g && !nt.checkClone && Ht.test(g)) return t.each(function (s) {
            var r = t.eq(s);
            m && (e[0] = g.call(this, s, r.html())), _(r, e, i, n)
        });
        if (p && (s = d(e, t[0].ownerDocument, !1, t, n), r = s.firstChild, 1 === s.childNodes.length && (s = r), r || n)) {
            for (o = rt.map(u(s, "script"), b), a = o.length; p > h; h++) l = s, h !== f && (l = rt.clone(l, !0, !0), a && rt.merge(o, u(l, "script"))), i.call(t[h], l, h);
            if (a) for (c = o[o.length - 1].ownerDocument, rt.map(o, y), h = 0; a > h; h++) l = o[h], Pt.test(l.type || "") && !xt.access(l, "globalEval") && rt.contains(c, l) && (l.src ? rt._evalUrl && rt._evalUrl(l.src) : rt.globalEval(l.textContent.replace(Mt, "")))
        }
        return t
    }

    function A(t, e, i) {
        for (var n, s = e ? rt.filter(e, t) : t, r = 0; null != (n = s[r]); r++) i || 1 !== n.nodeType || rt.cleanData(u(n)), n.parentNode && (i && rt.contains(n.ownerDocument, n) && h(u(n, "script")), n.parentNode.removeChild(n));
        return t
    }

    function C(t, e) {
        var i = rt(e.createElement(t)).appendTo(e.body), n = rt.css(i[0], "display");
        return i.detach(), n
    }

    function T(t) {
        var e = Y, i = jt[t];
        return i || (i = C(t, e), "none" !== i && i || (zt = (zt || rt("<iframe frameborder='0' width='0' height='0'/>")).appendTo(e.documentElement), e = zt[0].contentDocument, e.write(), e.close(), i = C(t, e), zt.detach()), jt[t] = i), i
    }

    function S(t, e, i) {
        var n, s, r, o, a = t.style;
        return i = i || Wt(t), o = i ? i.getPropertyValue(e) || i[e] : void 0, "" !== o && void 0 !== o || rt.contains(t.ownerDocument, t) || (o = rt.style(t, e)), i && !nt.pixelMarginRight() && Ut.test(o) && Bt.test(e) && (n = a.width, s = a.minWidth, r = a.maxWidth, a.minWidth = a.maxWidth = a.width = o, o = i.width, a.width = n, a.minWidth = s, a.maxWidth = r), void 0 !== o ? o + "" : o
    }

    function I(t, e) {
        return {
            get: function () {
                return t() ? void delete this.get : (this.get = e).apply(this, arguments)
            }
        }
    }

    function E(t) {
        if (t in Qt) return t;
        for (var e = t[0].toUpperCase() + t.slice(1), i = Xt.length; i--;) if ((t = Xt[i] + e) in Qt) return t
    }

    function $(t, e, i) {
        var n = St.exec(e);
        return n ? Math.max(0, n[2] - (i || 0)) + (n[3] || "px") : e
    }

    function D(t, e, i, n, s) {
        for (var r = i === (n ? "border" : "content") ? 4 : "width" === e ? 1 : 0, o = 0; 4 > r; r += 2) "margin" === i && (o += rt.css(t, i + It[r], !0, s)), n ? ("content" === i && (o -= rt.css(t, "padding" + It[r], !0, s)), "margin" !== i && (o -= rt.css(t, "border" + It[r] + "Width", !0, s))) : (o += rt.css(t, "padding" + It[r], !0, s), "padding" !== i && (o += rt.css(t, "border" + It[r] + "Width", !0, s)));
        return o
    }

    function P(e, i, n) {
        var s = !0, r = "width" === i ? e.offsetWidth : e.offsetHeight, o = Wt(e),
            a = "border-box" === rt.css(e, "boxSizing", !1, o);
        if (Y.msFullscreenElement && t.top !== t && e.getClientRects().length && (r = Math.round(100 * e.getBoundingClientRect()[i])), 0 >= r || null == r) {
            if (r = S(e, i, o), (0 > r || null == r) && (r = e.style[i]), Ut.test(r)) return r;
            s = a && (nt.boxSizingReliable() || r === e.style[i]), r = parseFloat(r) || 0
        }
        return r + D(e, i, n || (a ? "border" : "content"), s, o) + "px"
    }

    function k(t, e) {
        for (var i, n, s, r = [], o = 0, a = t.length; a > o; o++) n = t[o], n.style && (r[o] = xt.get(n, "olddisplay"), i = n.style.display, e ? (r[o] || "none" !== i || (n.style.display = ""), "" === n.style.display && Et(n) && (r[o] = xt.access(n, "olddisplay", T(n.nodeName)))) : (s = Et(n), "none" === i && s || xt.set(n, "olddisplay", s ? i : rt.css(n, "display"))));
        for (o = 0; a > o; o++) n = t[o], n.style && (e && "none" !== n.style.display && "" !== n.style.display || (n.style.display = e ? r[o] || "" : "none"));
        return t
    }

    function N(t, e, i, n, s) {
        return new N.prototype.init(t, e, i, n, s)
    }

    function L() {
        return t.setTimeout(function () {
            Jt = void 0
        }), Jt = rt.now()
    }

    function O(t, e) {
        var i, n = 0, s = {height: t};
        for (e = e ? 1 : 0; 4 > n; n += 2 - e) i = It[n], s["margin" + i] = s["padding" + i] = t;
        return e && (s.opacity = s.width = t), s
    }

    function R(t, e, i) {
        for (var n, s = (F.tweeners[e] || []).concat(F.tweeners["*"]), r = 0, o = s.length; o > r; r++) if (n = s[r].call(i, e, t)) return n
    }

    function V(t, e, i) {
        var n, s, r, o, a, l, c, u = this, h = {}, d = t.style, p = t.nodeType && Et(t), f = xt.get(t, "fxshow");
        i.queue || (a = rt._queueHooks(t, "fx"), null == a.unqueued && (a.unqueued = 0, l = a.empty.fire, a.empty.fire = function () {
            a.unqueued || l()
        }), a.unqueued++, u.always(function () {
            u.always(function () {
                a.unqueued--, rt.queue(t, "fx").length || a.empty.fire()
            })
        })), 1 === t.nodeType && ("height" in e || "width" in e) && (i.overflow = [d.overflow, d.overflowX, d.overflowY], c = rt.css(t, "display"), "inline" === ("none" === c ? xt.get(t, "olddisplay") || T(t.nodeName) : c) && "none" === rt.css(t, "float") && (d.display = "inline-block")), i.overflow && (d.overflow = "hidden", u.always(function () {
            d.overflow = i.overflow[0], d.overflowX = i.overflow[1], d.overflowY = i.overflow[2]
        }));
        for (n in e) if (s = e[n], ee.exec(s)) {
            if (delete e[n], r = r || "toggle" === s, s === (p ? "hide" : "show")) {
                if ("show" !== s || !f || void 0 === f[n]) continue;
                p = !0
            }
            h[n] = f && f[n] || rt.style(t, n)
        } else c = void 0;
        if (rt.isEmptyObject(h)) "inline" === ("none" === c ? T(t.nodeName) : c) && (d.display = c); else {
            f ? "hidden" in f && (p = f.hidden) : f = xt.access(t, "fxshow", {}), r && (f.hidden = !p), p ? rt(t).show() : u.done(function () {
                rt(t).hide()
            }), u.done(function () {
                var e;
                xt.remove(t, "fxshow");
                for (e in h) rt.style(t, e, h[e])
            });
            for (n in h) o = R(p ? f[n] : 0, n, u), n in f || (f[n] = o.start, p && (o.end = o.start, o.start = "width" === n || "height" === n ? 1 : 0))
        }
    }

    function H(t, e) {
        var i, n, s, r, o;
        for (i in t) if (n = rt.camelCase(i), s = e[n], r = t[i], rt.isArray(r) && (s = r[1], r = t[i] = r[0]), i !== n && (t[n] = r, delete t[i]), (o = rt.cssHooks[n]) && "expand" in o) {
            r = o.expand(r), delete t[n];
            for (i in r) i in t || (t[i] = r[i], e[i] = s)
        } else e[n] = s
    }

    function F(t, e, i) {
        var n, s, r = 0, o = F.prefilters.length, a = rt.Deferred().always(function () {
            delete l.elem
        }), l = function () {
            if (s) return !1;
            for (var e = Jt || L(), i = Math.max(0, c.startTime + c.duration - e), n = i / c.duration || 0, r = 1 - n, o = 0, l = c.tweens.length; l > o; o++) c.tweens[o].run(r);
            return a.notifyWith(t, [c, r, i]), 1 > r && l ? i : (a.resolveWith(t, [c]), !1)
        }, c = a.promise({
            elem: t,
            props: rt.extend({}, e),
            opts: rt.extend(!0, {specialEasing: {}, easing: rt.easing._default}, i),
            originalProperties: e,
            originalOptions: i,
            startTime: Jt || L(),
            duration: i.duration,
            tweens: [],
            createTween: function (e, i) {
                var n = rt.Tween(t, c.opts, e, i, c.opts.specialEasing[e] || c.opts.easing);
                return c.tweens.push(n), n
            },
            stop: function (e) {
                var i = 0, n = e ? c.tweens.length : 0;
                if (s) return this;
                for (s = !0; n > i; i++) c.tweens[i].run(1);
                return e ? (a.notifyWith(t, [c, 1, 0]), a.resolveWith(t, [c, e])) : a.rejectWith(t, [c, e]), this
            }
        }), u = c.props;
        for (H(u, c.opts.specialEasing); o > r; r++) if (n = F.prefilters[r].call(c, t, u, c.opts)) return rt.isFunction(n.stop) && (rt._queueHooks(c.elem, c.opts.queue).stop = rt.proxy(n.stop, n)), n;
        return rt.map(u, R, c), rt.isFunction(c.opts.start) && c.opts.start.call(t, c), rt.fx.timer(rt.extend(l, {
            elem: t,
            anim: c,
            queue: c.opts.queue
        })), c.progress(c.opts.progress).done(c.opts.done, c.opts.complete).fail(c.opts.fail).always(c.opts.always)
    }

    function M(t) {
        return t.getAttribute && t.getAttribute("class") || ""
    }

    function z(t) {
        return function (e, i) {
            "string" != typeof e && (i = e, e = "*");
            var n, s = 0, r = e.toLowerCase().match(vt) || [];
            if (rt.isFunction(i)) for (; n = r[s++];) "+" === n[0] ? (n = n.slice(1) || "*", (t[n] = t[n] || []).unshift(i)) : (t[n] = t[n] || []).push(i)
        }
    }

    function j(t, e, i, n) {
        function s(a) {
            var l;
            return r[a] = !0, rt.each(t[a] || [], function (t, a) {
                var c = a(e, i, n);
                return "string" != typeof c || o || r[c] ? o ? !(l = c) : void 0 : (e.dataTypes.unshift(c), s(c), !1)
            }), l
        }

        var r = {}, o = t === ve;
        return s(e.dataTypes[0]) || !r["*"] && s("*")
    }

    function B(t, e) {
        var i, n, s = rt.ajaxSettings.flatOptions || {};
        for (i in e) void 0 !== e[i] && ((s[i] ? t : n || (n = {}))[i] = e[i]);
        return n && rt.extend(!0, t, n), t
    }

    function U(t, e, i) {
        for (var n, s, r, o, a = t.contents, l = t.dataTypes; "*" === l[0];) l.shift(), void 0 === n && (n = t.mimeType || e.getResponseHeader("Content-Type"));
        if (n) for (s in a) if (a[s] && a[s].test(n)) {
            l.unshift(s);
            break
        }
        if (l[0] in i) r = l[0]; else {
            for (s in i) {
                if (!l[0] || t.converters[s + " " + l[0]]) {
                    r = s;
                    break
                }
                o || (o = s)
            }
            r = r || o
        }
        return r ? (r !== l[0] && l.unshift(r), i[r]) : void 0
    }

    function W(t, e, i, n) {
        var s, r, o, a, l, c = {}, u = t.dataTypes.slice();
        if (u[1]) for (o in t.converters) c[o.toLowerCase()] = t.converters[o];
        for (r = u.shift(); r;) if (t.responseFields[r] && (i[t.responseFields[r]] = e), !l && n && t.dataFilter && (e = t.dataFilter(e, t.dataType)), l = r, r = u.shift()) if ("*" === r) r = l; else if ("*" !== l && l !== r) {
            if (!(o = c[l + " " + r] || c["* " + r])) for (s in c) if (a = s.split(" "), a[1] === r && (o = c[l + " " + a[0]] || c["* " + a[0]])) {
                !0 === o ? o = c[s] : !0 !== c[s] && (r = a[0], u.unshift(a[1]));
                break
            }
            if (!0 !== o) if (o && t.throws) e = o(e); else try {
                e = o(e)
            } catch (t) {
                return {state: "parsererror", error: o ? t : "No conversion from " + l + " to " + r}
            }
        }
        return {state: "success", data: e}
    }

    function q(t, e, i, n) {
        var s;
        if (rt.isArray(e)) rt.each(e, function (e, s) {
            i || we.test(t) ? n(t, s) : q(t + "[" + ("object" == typeof s && null != s ? e : "") + "]", s, i, n)
        }); else if (i || "object" !== rt.type(e)) n(t, e); else for (s in e) q(t + "[" + s + "]", e[s], i, n)
    }

    function G(t) {
        return rt.isWindow(t) ? t : 9 === t.nodeType && t.defaultView
    }

    var Z = [], Y = t.document, K = Z.slice, X = Z.concat, Q = Z.push, J = Z.indexOf, tt = {}, et = tt.toString,
        it = tt.hasOwnProperty, nt = {}, st = "2.2.3", rt = function (t, e) {
            return new rt.fn.init(t, e)
        }, ot = function (t, e) {
            return e.toUpperCase()
        };
    rt.fn = rt.prototype = {
        jquery: st, constructor: rt, selector: "", length: 0, toArray: function () {
            return K.call(this)
        }, get: function (t) {
            return null != t ? 0 > t ? this[t + this.length] : this[t] : K.call(this)
        }, pushStack: function (t) {
            var e = rt.merge(this.constructor(), t);
            return e.prevObject = this, e.context = this.context, e
        }, each: function (t) {
            return rt.each(this, t)
        }, map: function (t) {
            return this.pushStack(rt.map(this, function (e, i) {
                return t.call(e, i, e)
            }))
        }, slice: function () {
            return this.pushStack(K.apply(this, arguments))
        }, first: function () {
            return this.eq(0)
        }, last: function () {
            return this.eq(-1)
        }, eq: function (t) {
            var e = this.length, i = +t + (0 > t ? e : 0);
            return this.pushStack(i >= 0 && e > i ? [this[i]] : [])
        }, end: function () {
            return this.prevObject || this.constructor()
        }, push: Q, sort: Z.sort, splice: Z.splice
    }, rt.extend = rt.fn.extend = function () {
        var t, e, i, n, s, r, o = arguments[0] || {}, a = 1, l = arguments.length, c = !1;
        for ("boolean" == typeof o && (c = o, o = arguments[a] || {}, a++), "object" == typeof o || rt.isFunction(o) || (o = {}), a === l && (o = this, a--); l > a; a++) if (null != (t = arguments[a])) for (e in t) i = o[e], n = t[e], o !== n && (c && n && (rt.isPlainObject(n) || (s = rt.isArray(n))) ? (s ? (s = !1, r = i && rt.isArray(i) ? i : []) : r = i && rt.isPlainObject(i) ? i : {}, o[e] = rt.extend(c, r, n)) : void 0 !== n && (o[e] = n));
        return o
    }, rt.extend({
        expando: "jQuery" + (st + Math.random()).replace(/\D/g, ""), isReady: !0, error: function (t) {
            throw new Error(t)
        }, noop: function () {
        }, isFunction: function (t) {
            return "function" === rt.type(t)
        }, isArray: Array.isArray, isWindow: function (t) {
            return null != t && t === t.window
        }, isNumeric: function (t) {
            var e = t && t.toString();
            return !rt.isArray(t) && e - parseFloat(e) + 1 >= 0
        }, isPlainObject: function (t) {
            var e;
            if ("object" !== rt.type(t) || t.nodeType || rt.isWindow(t)) return !1;
            if (t.constructor && !it.call(t, "constructor") && !it.call(t.constructor.prototype || {}, "isPrototypeOf")) return !1;
            for (e in t) ;
            return void 0 === e || it.call(t, e)
        }, isEmptyObject: function (t) {
            var e;
            for (e in t) return !1;
            return !0
        }, type: function (t) {
            return null == t ? t + "" : "object" == typeof t || "function" == typeof t ? tt[et.call(t)] || "object" : typeof t
        }, globalEval: function (t) {
            var e, i = eval;
            (t = rt.trim(t)) && (1 === t.indexOf("use strict") ? (e = Y.createElement("script"), e.text = t, Y.head.appendChild(e).parentNode.removeChild(e)) : i(t))
        }, camelCase: function (t) {
            return t.replace(/^-ms-/, "ms-").replace(/-([\da-z])/gi, ot)
        }, nodeName: function (t, e) {
            return t.nodeName && t.nodeName.toLowerCase() === e.toLowerCase()
        }, each: function (t, e) {
            var n, s = 0;
            if (i(t)) for (n = t.length; n > s && !1 !== e.call(t[s], s, t[s]); s++) ; else for (s in t) if (!1 === e.call(t[s], s, t[s])) break;
            return t
        }, trim: function (t) {
            return null == t ? "" : (t + "").replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "")
        }, makeArray: function (t, e) {
            var n = e || [];
            return null != t && (i(Object(t)) ? rt.merge(n, "string" == typeof t ? [t] : t) : Q.call(n, t)), n
        }, inArray: function (t, e, i) {
            return null == e ? -1 : J.call(e, t, i)
        }, merge: function (t, e) {
            for (var i = +e.length, n = 0, s = t.length; i > n; n++) t[s++] = e[n];
            return t.length = s, t
        }, grep: function (t, e, i) {
            for (var n = [], s = 0, r = t.length, o = !i; r > s; s++) !e(t[s], s) !== o && n.push(t[s]);
            return n
        }, map: function (t, e, n) {
            var s, r, o = 0, a = [];
            if (i(t)) for (s = t.length; s > o; o++) null != (r = e(t[o], o, n)) && a.push(r); else for (o in t) null != (r = e(t[o], o, n)) && a.push(r);
            return X.apply([], a)
        }, guid: 1, proxy: function (t, e) {
            var i, n, s;
            return "string" == typeof e && (i = t[e], e = t, t = i), rt.isFunction(t) ? (n = K.call(arguments, 2), s = function () {
                return t.apply(e || this, n.concat(K.call(arguments)))
            }, s.guid = t.guid = t.guid || rt.guid++, s) : void 0
        }, now: Date.now, support: nt
    }), "function" == typeof Symbol && (rt.fn[Symbol.iterator] = Z[Symbol.iterator]), rt.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function (t, e) {
        tt["[object " + e + "]"] = e.toLowerCase()
    });
    var at = function (t) {
        function e(t, e, i, n) {
            var s, r, o, a, c, h, d, p, f = e && e.ownerDocument, g = e ? e.nodeType : 9;
            if (i = i || [], "string" != typeof t || !t || 1 !== g && 9 !== g && 11 !== g) return i;
            if (!n && ((e ? e.ownerDocument || e : H) !== D && $(e), e = e || D, k)) {
                if (11 !== g && (h = gt.exec(t))) if (s = h[1]) {
                    if (9 === g) {
                        if (!(o = e.getElementById(s))) return i;
                        if (o.id === s) return i.push(o), i
                    } else if (f && (o = f.getElementById(s)) && R(e, o) && o.id === s) return i.push(o), i
                } else {
                    if (h[2]) return K.apply(i, e.getElementsByTagName(t)), i;
                    if ((s = h[3]) && y.getElementsByClassName && e.getElementsByClassName) return K.apply(i, e.getElementsByClassName(s)), i
                }
                if (y.qsa && !B[t + " "] && (!N || !N.test(t))) {
                    if (1 !== g) f = e, p = t; else if ("object" !== e.nodeName.toLowerCase()) {
                        for ((a = e.getAttribute("id")) ? a = a.replace(vt, "\\$&") : e.setAttribute("id", a = V), d = A(t), r = d.length, c = ut.test(a) ? "#" + a : "[id='" + a + "']"; r--;) d[r] = c + " " + u(d[r]);
                        p = d.join(","), f = mt.test(t) && l(e.parentNode) || e
                    }
                    if (p) try {
                        return K.apply(i, f.querySelectorAll(p)), i
                    } catch (t) {
                    } finally {
                        a === V && e.removeAttribute("id")
                    }
                }
            }
            return T(t.replace(rt, "$1"), e, i, n)
        }

        function i() {
            function t(i, n) {
                return e.push(i + " ") > w.cacheLength && delete t[e.shift()], t[i + " "] = n
            }

            var e = [];
            return t
        }

        function n(t) {
            return t[V] = !0, t
        }

        function s(t) {
            var e = D.createElement("div");
            try {
                return !!t(e)
            } catch (t) {
                return !1
            } finally {
                e.parentNode && e.parentNode.removeChild(e), e = null
            }
        }

        function r(t, e) {
            for (var i = t.split("|"), n = i.length; n--;) w.attrHandle[i[n]] = e
        }

        function o(t, e) {
            var i = e && t,
                n = i && 1 === t.nodeType && 1 === e.nodeType && (~e.sourceIndex || W) - (~t.sourceIndex || W);
            if (n) return n;
            if (i) for (; i = i.nextSibling;) if (i === e) return -1;
            return t ? 1 : -1
        }

        function a(t) {
            return n(function (e) {
                return e = +e, n(function (i, n) {
                    for (var s, r = t([], i.length, e), o = r.length; o--;) i[s = r[o]] && (i[s] = !(n[s] = i[s]))
                })
            })
        }

        function l(t) {
            return t && void 0 !== t.getElementsByTagName && t
        }

        function c() {
        }

        function u(t) {
            for (var e = 0, i = t.length, n = ""; i > e; e++) n += t[e].value;
            return n
        }

        function h(t, e, i) {
            var n = e.dir, s = i && "parentNode" === n, r = M++;
            return e.first ? function (e, i, r) {
                for (; e = e[n];) if (1 === e.nodeType || s) return t(e, i, r)
            } : function (e, i, o) {
                var a, l, c, u = [F, r];
                if (o) {
                    for (; e = e[n];) if ((1 === e.nodeType || s) && t(e, i, o)) return !0
                } else for (; e = e[n];) if (1 === e.nodeType || s) {
                    if (c = e[V] || (e[V] = {}), l = c[e.uniqueID] || (c[e.uniqueID] = {}), (a = l[n]) && a[0] === F && a[1] === r) return u[2] = a[2];
                    if (l[n] = u, u[2] = t(e, i, o)) return !0
                }
            }
        }

        function d(t) {
            return t.length > 1 ? function (e, i, n) {
                for (var s = t.length; s--;) if (!t[s](e, i, n)) return !1;
                return !0
            } : t[0]
        }

        function p(t, i, n) {
            for (var s = 0, r = i.length; r > s; s++) e(t, i[s], n);
            return n
        }

        function f(t, e, i, n, s) {
            for (var r, o = [], a = 0, l = t.length, c = null != e; l > a; a++) (r = t[a]) && (i && !i(r, n, s) || (o.push(r), c && e.push(a)));
            return o
        }

        function g(t, e, i, s, r, o) {
            return s && !s[V] && (s = g(s)), r && !r[V] && (r = g(r, o)), n(function (n, o, a, l) {
                var c, u, h, d = [], g = [], m = o.length, v = n || p(e || "*", a.nodeType ? [a] : a, []),
                    b = !t || !n && e ? v : f(v, d, t, a, l), y = i ? r || (n ? t : m || s) ? [] : o : b;
                if (i && i(b, y, a, l), s) for (c = f(y, g), s(c, [], a, l), u = c.length; u--;) (h = c[u]) && (y[g[u]] = !(b[g[u]] = h));
                if (n) {
                    if (r || t) {
                        if (r) {
                            for (c = [], u = y.length; u--;) (h = y[u]) && c.push(b[u] = h);
                            r(null, y = [], c, l)
                        }
                        for (u = y.length; u--;) (h = y[u]) && (c = r ? Q(n, h) : d[u]) > -1 && (n[c] = !(o[c] = h))
                    }
                } else y = f(y === o ? y.splice(m, y.length) : y), r ? r(null, o, y, l) : K.apply(o, y)
            })
        }

        function m(t) {
            for (var e, i, n, s = t.length, r = w.relative[t[0].type], o = r || w.relative[" "], a = r ? 1 : 0, l = h(function (t) {
                return t === e
            }, o, !0), c = h(function (t) {
                return Q(e, t) > -1
            }, o, !0), p = [function (t, i, n) {
                var s = !r && (n || i !== S) || ((e = i).nodeType ? l(t, i, n) : c(t, i, n));
                return e = null, s
            }]; s > a; a++) if (i = w.relative[t[a].type]) p = [h(d(p), i)]; else {
                if (i = w.filter[t[a].type].apply(null, t[a].matches), i[V]) {
                    for (n = ++a; s > n && !w.relative[t[n].type]; n++) ;
                    return g(a > 1 && d(p), a > 1 && u(t.slice(0, a - 1).concat({value: " " === t[a - 2].type ? "*" : ""})).replace(rt, "$1"), i, n > a && m(t.slice(a, n)), s > n && m(t = t.slice(n)), s > n && u(t))
                }
                p.push(i)
            }
            return d(p)
        }

        function v(t, i) {
            var s = i.length > 0, r = t.length > 0, o = function (n, o, a, l, c) {
                var u, h, d, p = 0, g = "0", m = n && [], v = [], b = S, y = n || r && w.find.TAG("*", c),
                    x = F += null == b ? 1 : Math.random() || .1, _ = y.length;
                for (c && (S = o === D || o || c); g !== _ && null != (u = y[g]); g++) {
                    if (r && u) {
                        for (h = 0, o || u.ownerDocument === D || ($(u), a = !k); d = t[h++];) if (d(u, o || D, a)) {
                            l.push(u);
                            break
                        }
                        c && (F = x)
                    }
                    s && ((u = !d && u) && p--, n && m.push(u))
                }
                if (p += g, s && g !== p) {
                    for (h = 0; d = i[h++];) d(m, v, o, a);
                    if (n) {
                        if (p > 0) for (; g--;) m[g] || v[g] || (v[g] = Z.call(l));
                        v = f(v)
                    }
                    K.apply(l, v), c && !n && v.length > 0 && p + i.length > 1 && e.uniqueSort(l)
                }
                return c && (F = x, S = b), m
            };
            return s ? n(o) : o
        }

        var b, y, w, x, _, A, C, T, S, I, E, $, D, P, k, N, L, O, R, V = "sizzle" + 1 * new Date, H = t.document, F = 0,
            M = 0, z = i(), j = i(), B = i(), U = function (t, e) {
                return t === e && (E = !0), 0
            }, W = 1 << 31, q = {}.hasOwnProperty, G = [], Z = G.pop, Y = G.push, K = G.push, X = G.slice,
            Q = function (t, e) {
                for (var i = 0, n = t.length; n > i; i++) if (t[i] === e) return i;
                return -1
            },
            J = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            tt = "[\\x20\\t\\r\\n\\f]", et = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
            it = "\\[" + tt + "*(" + et + ")(?:" + tt + "*([*^$|!~]?=)" + tt + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + et + "))|)" + tt + "*\\]",
            nt = ":(" + et + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + it + ")*)|.*)\\)|)",
            st = new RegExp(tt + "+", "g"), rt = new RegExp("^" + tt + "+|((?:^|[^\\\\])(?:\\\\.)*)" + tt + "+$", "g"),
            ot = new RegExp("^" + tt + "*," + tt + "*"), at = new RegExp("^" + tt + "*([>+~]|" + tt + ")" + tt + "*"),
            lt = new RegExp("=" + tt + "*([^\\]'\"]*?)" + tt + "*\\]", "g"), ct = new RegExp(nt),
            ut = new RegExp("^" + et + "$"), ht = {
                ID: new RegExp("^#(" + et + ")"),
                CLASS: new RegExp("^\\.(" + et + ")"),
                TAG: new RegExp("^(" + et + "|[*])"),
                ATTR: new RegExp("^" + it),
                PSEUDO: new RegExp("^" + nt),
                CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + tt + "*(even|odd|(([+-]|)(\\d*)n|)" + tt + "*(?:([+-]|)" + tt + "*(\\d+)|))" + tt + "*\\)|)", "i"),
                bool: new RegExp("^(?:" + J + ")$", "i"),
                needsContext: new RegExp("^" + tt + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + tt + "*((?:-\\d)?\\d*)" + tt + "*\\)|)(?=[^-]|$)", "i")
            }, dt = /^(?:input|select|textarea|button)$/i, pt = /^h\d$/i, ft = /^[^{]+\{\s*\[native \w/,
            gt = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, mt = /[+~]/, vt = /'|\\/g,
            bt = new RegExp("\\\\([\\da-f]{1,6}" + tt + "?|(" + tt + ")|.)", "ig"), yt = function (t, e, i) {
                var n = "0x" + e - 65536;
                return n !== n || i ? e : 0 > n ? String.fromCharCode(n + 65536) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320)
            }, wt = function () {
                $()
            };
        try {
            K.apply(G = X.call(H.childNodes), H.childNodes), G[H.childNodes.length].nodeType
        } catch (t) {
            K = {
                apply: G.length ? function (t, e) {
                    Y.apply(t, X.call(e))
                } : function (t, e) {
                    for (var i = t.length, n = 0; t[i++] = e[n++];) ;
                    t.length = i - 1
                }
            }
        }
        y = e.support = {}, _ = e.isXML = function (t) {
            var e = t && (t.ownerDocument || t).documentElement;
            return !!e && "HTML" !== e.nodeName
        }, $ = e.setDocument = function (t) {
            var e, i, n = t ? t.ownerDocument || t : H;
            return n !== D && 9 === n.nodeType && n.documentElement ? (D = n, P = D.documentElement, k = !_(D), (i = D.defaultView) && i.top !== i && (i.addEventListener ? i.addEventListener("unload", wt, !1) : i.attachEvent && i.attachEvent("onunload", wt)), y.attributes = s(function (t) {
                return t.className = "i", !t.getAttribute("className")
            }), y.getElementsByTagName = s(function (t) {
                return t.appendChild(D.createComment("")), !t.getElementsByTagName("*").length
            }), y.getElementsByClassName = ft.test(D.getElementsByClassName), y.getById = s(function (t) {
                return P.appendChild(t).id = V, !D.getElementsByName || !D.getElementsByName(V).length
            }), y.getById ? (w.find.ID = function (t, e) {
                if (void 0 !== e.getElementById && k) {
                    var i = e.getElementById(t);
                    return i ? [i] : []
                }
            }, w.filter.ID = function (t) {
                var e = t.replace(bt, yt);
                return function (t) {
                    return t.getAttribute("id") === e
                }
            }) : (delete w.find.ID, w.filter.ID = function (t) {
                var e = t.replace(bt, yt);
                return function (t) {
                    var i = void 0 !== t.getAttributeNode && t.getAttributeNode("id");
                    return i && i.value === e
                }
            }), w.find.TAG = y.getElementsByTagName ? function (t, e) {
                return void 0 !== e.getElementsByTagName ? e.getElementsByTagName(t) : y.qsa ? e.querySelectorAll(t) : void 0
            } : function (t, e) {
                var i, n = [], s = 0, r = e.getElementsByTagName(t);
                if ("*" === t) {
                    for (; i = r[s++];) 1 === i.nodeType && n.push(i);
                    return n
                }
                return r
            }, w.find.CLASS = y.getElementsByClassName && function (t, e) {
                return void 0 !== e.getElementsByClassName && k ? e.getElementsByClassName(t) : void 0
            }, L = [], N = [], (y.qsa = ft.test(D.querySelectorAll)) && (s(function (t) {
                P.appendChild(t).innerHTML = "<a id='" + V + "'></a><select id='" + V + "-\r\\' msallowcapture=''><option selected=''></option></select>", t.querySelectorAll("[msallowcapture^='']").length && N.push("[*^$]=" + tt + "*(?:''|\"\")"), t.querySelectorAll("[selected]").length || N.push("\\[" + tt + "*(?:value|" + J + ")"), t.querySelectorAll("[id~=" + V + "-]").length || N.push("~="), t.querySelectorAll(":checked").length || N.push(":checked"), t.querySelectorAll("a#" + V + "+*").length || N.push(".#.+[+~]")
            }), s(function (t) {
                var e = D.createElement("input");
                e.setAttribute("type", "hidden"), t.appendChild(e).setAttribute("name", "D"), t.querySelectorAll("[name=d]").length && N.push("name" + tt + "*[*^$|!~]?="), t.querySelectorAll(":enabled").length || N.push(":enabled", ":disabled"), t.querySelectorAll("*,:x"), N.push(",.*:")
            })), (y.matchesSelector = ft.test(O = P.matches || P.webkitMatchesSelector || P.mozMatchesSelector || P.oMatchesSelector || P.msMatchesSelector)) && s(function (t) {
                y.disconnectedMatch = O.call(t, "div"), O.call(t, "[s!='']:x"), L.push("!=", nt)
            }), N = N.length && new RegExp(N.join("|")), L = L.length && new RegExp(L.join("|")), e = ft.test(P.compareDocumentPosition), R = e || ft.test(P.contains) ? function (t, e) {
                var i = 9 === t.nodeType ? t.documentElement : t, n = e && e.parentNode;
                return t === n || !(!n || 1 !== n.nodeType || !(i.contains ? i.contains(n) : t.compareDocumentPosition && 16 & t.compareDocumentPosition(n)))
            } : function (t, e) {
                if (e) for (; e = e.parentNode;) if (e === t) return !0;
                return !1
            }, U = e ? function (t, e) {
                if (t === e) return E = !0, 0;
                var i = !t.compareDocumentPosition - !e.compareDocumentPosition;
                return i || (i = (t.ownerDocument || t) === (e.ownerDocument || e) ? t.compareDocumentPosition(e) : 1, 1 & i || !y.sortDetached && e.compareDocumentPosition(t) === i ? t === D || t.ownerDocument === H && R(H, t) ? -1 : e === D || e.ownerDocument === H && R(H, e) ? 1 : I ? Q(I, t) - Q(I, e) : 0 : 4 & i ? -1 : 1)
            } : function (t, e) {
                if (t === e) return E = !0, 0;
                var i, n = 0, s = t.parentNode, r = e.parentNode, a = [t], l = [e];
                if (!s || !r) return t === D ? -1 : e === D ? 1 : s ? -1 : r ? 1 : I ? Q(I, t) - Q(I, e) : 0;
                if (s === r) return o(t, e);
                for (i = t; i = i.parentNode;) a.unshift(i);
                for (i = e; i = i.parentNode;) l.unshift(i);
                for (; a[n] === l[n];) n++;
                return n ? o(a[n], l[n]) : a[n] === H ? -1 : l[n] === H ? 1 : 0
            }, D) : D
        }, e.matches = function (t, i) {
            return e(t, null, null, i)
        }, e.matchesSelector = function (t, i) {
            if ((t.ownerDocument || t) !== D && $(t), i = i.replace(lt, "='$1']"), y.matchesSelector && k && !B[i + " "] && (!L || !L.test(i)) && (!N || !N.test(i))) try {
                var n = O.call(t, i);
                if (n || y.disconnectedMatch || t.document && 11 !== t.document.nodeType) return n
            } catch (t) {
            }
            return e(i, D, null, [t]).length > 0
        }, e.contains = function (t, e) {
            return (t.ownerDocument || t) !== D && $(t), R(t, e)
        }, e.attr = function (t, e) {
            (t.ownerDocument || t) !== D && $(t);
            var i = w.attrHandle[e.toLowerCase()],
                n = i && q.call(w.attrHandle, e.toLowerCase()) ? i(t, e, !k) : void 0;
            return void 0 !== n ? n : y.attributes || !k ? t.getAttribute(e) : (n = t.getAttributeNode(e)) && n.specified ? n.value : null
        }, e.error = function (t) {
            throw new Error("Syntax error, unrecognized expression: " + t)
        }, e.uniqueSort = function (t) {
            var e, i = [], n = 0, s = 0;
            if (E = !y.detectDuplicates, I = !y.sortStable && t.slice(0), t.sort(U), E) {
                for (; e = t[s++];) e === t[s] && (n = i.push(s));
                for (; n--;) t.splice(i[n], 1)
            }
            return I = null, t
        }, x = e.getText = function (t) {
            var e, i = "", n = 0, s = t.nodeType;
            if (s) {
                if (1 === s || 9 === s || 11 === s) {
                    if ("string" == typeof t.textContent) return t.textContent;
                    for (t = t.firstChild; t; t = t.nextSibling) i += x(t)
                } else if (3 === s || 4 === s) return t.nodeValue
            } else for (; e = t[n++];) i += x(e);
            return i
        }, w = e.selectors = {
            cacheLength: 50,
            createPseudo: n,
            match: ht,
            attrHandle: {},
            find: {},
            relative: {
                ">": {dir: "parentNode", first: !0},
                " ": {dir: "parentNode"},
                "+": {dir: "previousSibling", first: !0},
                "~": {dir: "previousSibling"}
            },
            preFilter: {
                ATTR: function (t) {
                    return t[1] = t[1].replace(bt, yt), t[3] = (t[3] || t[4] || t[5] || "").replace(bt, yt), "~=" === t[2] && (t[3] = " " + t[3] + " "), t.slice(0, 4)
                }, CHILD: function (t) {
                    return t[1] = t[1].toLowerCase(), "nth" === t[1].slice(0, 3) ? (t[3] || e.error(t[0]), t[4] = +(t[4] ? t[5] + (t[6] || 1) : 2 * ("even" === t[3] || "odd" === t[3])), t[5] = +(t[7] + t[8] || "odd" === t[3])) : t[3] && e.error(t[0]), t
                }, PSEUDO: function (t) {
                    var e, i = !t[6] && t[2];
                    return ht.CHILD.test(t[0]) ? null : (t[3] ? t[2] = t[4] || t[5] || "" : i && ct.test(i) && (e = A(i, !0)) && (e = i.indexOf(")", i.length - e) - i.length) && (t[0] = t[0].slice(0, e), t[2] = i.slice(0, e)), t.slice(0, 3))
                }
            },
            filter: {
                TAG: function (t) {
                    var e = t.replace(bt, yt).toLowerCase();
                    return "*" === t ? function () {
                        return !0
                    } : function (t) {
                        return t.nodeName && t.nodeName.toLowerCase() === e
                    }
                }, CLASS: function (t) {
                    var e = z[t + " "];
                    return e || (e = new RegExp("(^|" + tt + ")" + t + "(" + tt + "|$)")) && z(t, function (t) {
                        return e.test("string" == typeof t.className && t.className || void 0 !== t.getAttribute && t.getAttribute("class") || "")
                    })
                }, ATTR: function (t, i, n) {
                    return function (s) {
                        var r = e.attr(s, t);
                        return null == r ? "!=" === i : !i || (r += "", "=" === i ? r === n : "!=" === i ? r !== n : "^=" === i ? n && 0 === r.indexOf(n) : "*=" === i ? n && r.indexOf(n) > -1 : "$=" === i ? n && r.slice(-n.length) === n : "~=" === i ? (" " + r.replace(st, " ") + " ").indexOf(n) > -1 : "|=" === i && (r === n || r.slice(0, n.length + 1) === n + "-"))
                    }
                }, CHILD: function (t, e, i, n, s) {
                    var r = "nth" !== t.slice(0, 3), o = "last" !== t.slice(-4), a = "of-type" === e;
                    return 1 === n && 0 === s ? function (t) {
                        return !!t.parentNode
                    } : function (e, i, l) {
                        var c, u, h, d, p, f, g = r !== o ? "nextSibling" : "previousSibling", m = e.parentNode,
                            v = a && e.nodeName.toLowerCase(), b = !l && !a, y = !1;
                        if (m) {
                            if (r) {
                                for (; g;) {
                                    for (d = e; d = d[g];) if (a ? d.nodeName.toLowerCase() === v : 1 === d.nodeType) return !1;
                                    f = g = "only" === t && !f && "nextSibling"
                                }
                                return !0
                            }
                            if (f = [o ? m.firstChild : m.lastChild], o && b) {
                                for (d = m, h = d[V] || (d[V] = {}), u = h[d.uniqueID] || (h[d.uniqueID] = {}), c = u[t] || [], p = c[0] === F && c[1], y = p && c[2], d = p && m.childNodes[p]; d = ++p && d && d[g] || (y = p = 0) || f.pop();) if (1 === d.nodeType && ++y && d === e) {
                                    u[t] = [F, p, y];
                                    break
                                }
                            } else if (b && (d = e, h = d[V] || (d[V] = {}), u = h[d.uniqueID] || (h[d.uniqueID] = {}), c = u[t] || [], p = c[0] === F && c[1], y = p), !1 === y) for (; (d = ++p && d && d[g] || (y = p = 0) || f.pop()) && ((a ? d.nodeName.toLowerCase() !== v : 1 !== d.nodeType) || !++y || (b && (h = d[V] || (d[V] = {}), u = h[d.uniqueID] || (h[d.uniqueID] = {}), u[t] = [F, y]), d !== e));) ;
                            return (y -= s) === n || y % n == 0 && y / n >= 0
                        }
                    }
                }, PSEUDO: function (t, i) {
                    var s, r = w.pseudos[t] || w.setFilters[t.toLowerCase()] || e.error("unsupported pseudo: " + t);
                    return r[V] ? r(i) : r.length > 1 ? (s = [t, t, "", i], w.setFilters.hasOwnProperty(t.toLowerCase()) ? n(function (t, e) {
                        for (var n, s = r(t, i), o = s.length; o--;) n = Q(t, s[o]), t[n] = !(e[n] = s[o])
                    }) : function (t) {
                        return r(t, 0, s)
                    }) : r
                }
            },
            pseudos: {
                not: n(function (t) {
                    var e = [], i = [], s = C(t.replace(rt, "$1"));
                    return s[V] ? n(function (t, e, i, n) {
                        for (var r, o = s(t, null, n, []), a = t.length; a--;) (r = o[a]) && (t[a] = !(e[a] = r))
                    }) : function (t, n, r) {
                        return e[0] = t, s(e, null, r, i), e[0] = null, !i.pop()
                    }
                }), has: n(function (t) {
                    return function (i) {
                        return e(t, i).length > 0
                    }
                }), contains: n(function (t) {
                    return t = t.replace(bt, yt), function (e) {
                        return (e.textContent || e.innerText || x(e)).indexOf(t) > -1
                    }
                }), lang: n(function (t) {
                    return ut.test(t || "") || e.error("unsupported lang: " + t), t = t.replace(bt, yt).toLowerCase(), function (e) {
                        var i;
                        do {
                            if (i = k ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (i = i.toLowerCase()) === t || 0 === i.indexOf(t + "-")
                        } while ((e = e.parentNode) && 1 === e.nodeType);
                        return !1
                    }
                }), target: function (e) {
                    var i = t.location && t.location.hash;
                    return i && i.slice(1) === e.id
                }, root: function (t) {
                    return t === P
                }, focus: function (t) {
                    return t === D.activeElement && (!D.hasFocus || D.hasFocus()) && !!(t.type || t.href || ~t.tabIndex)
                }, enabled: function (t) {
                    return !1 === t.disabled
                }, disabled: function (t) {
                    return !0 === t.disabled
                }, checked: function (t) {
                    var e = t.nodeName.toLowerCase();
                    return "input" === e && !!t.checked || "option" === e && !!t.selected
                }, selected: function (t) {
                    return t.parentNode && t.parentNode.selectedIndex, !0 === t.selected
                }, empty: function (t) {
                    for (t = t.firstChild; t; t = t.nextSibling) if (t.nodeType < 6) return !1;
                    return !0
                }, parent: function (t) {
                    return !w.pseudos.empty(t)
                }, header: function (t) {
                    return pt.test(t.nodeName)
                }, input: function (t) {
                    return dt.test(t.nodeName)
                }, button: function (t) {
                    var e = t.nodeName.toLowerCase();
                    return "input" === e && "button" === t.type || "button" === e
                }, text: function (t) {
                    var e;
                    return "input" === t.nodeName.toLowerCase() && "text" === t.type && (null == (e = t.getAttribute("type")) || "text" === e.toLowerCase())
                }, first: a(function () {
                    return [0]
                }), last: a(function (t, e) {
                    return [e - 1]
                }), eq: a(function (t, e, i) {
                    return [0 > i ? i + e : i]
                }), even: a(function (t, e) {
                    for (var i = 0; e > i; i += 2) t.push(i);
                    return t
                }), odd: a(function (t, e) {
                    for (var i = 1; e > i; i += 2) t.push(i);
                    return t
                }), lt: a(function (t, e, i) {
                    for (var n = 0 > i ? i + e : i; --n >= 0;) t.push(n);
                    return t
                }), gt: a(function (t, e, i) {
                    for (var n = 0 > i ? i + e : i; ++n < e;) t.push(n);
                    return t
                })
            }
        }, w.pseudos.nth = w.pseudos.eq;
        for (b in{
            radio: !0, checkbox: !0, file: !0, password: !0, image: !0
        }) w.pseudos[b] = function (t) {
            return function (e) {
                return "input" === e.nodeName.toLowerCase() && e.type === t
            }
        }(b);
        for (b in{submit: !0, reset: !0}) w.pseudos[b] = function (t) {
            return function (e) {
                var i = e.nodeName.toLowerCase();
                return ("input" === i || "button" === i) && e.type === t
            }
        }(b);
        return c.prototype = w.filters = w.pseudos, w.setFilters = new c, A = e.tokenize = function (t, i) {
            var n, s, r, o, a, l, c, u = j[t + " "];
            if (u) return i ? 0 : u.slice(0);
            for (a = t, l = [], c = w.preFilter; a;) {
                n && !(s = ot.exec(a)) || (s && (a = a.slice(s[0].length) || a), l.push(r = [])), n = !1, (s = at.exec(a)) && (n = s.shift(), r.push({
                    value: n,
                    type: s[0].replace(rt, " ")
                }), a = a.slice(n.length));
                for (o in w.filter) !(s = ht[o].exec(a)) || c[o] && !(s = c[o](s)) || (n = s.shift(), r.push({
                    value: n,
                    type: o,
                    matches: s
                }), a = a.slice(n.length));
                if (!n) break
            }
            return i ? a.length : a ? e.error(t) : j(t, l).slice(0)
        }, C = e.compile = function (t, e) {
            var i, n = [], s = [], r = B[t + " "];
            if (!r) {
                for (e || (e = A(t)), i = e.length; i--;) r = m(e[i]), r[V] ? n.push(r) : s.push(r);
                r = B(t, v(s, n)), r.selector = t
            }
            return r
        }, T = e.select = function (t, e, i, n) {
            var s, r, o, a, c, h = "function" == typeof t && t, d = !n && A(t = h.selector || t);
            if (i = i || [], 1 === d.length) {
                if (r = d[0] = d[0].slice(0), r.length > 2 && "ID" === (o = r[0]).type && y.getById && 9 === e.nodeType && k && w.relative[r[1].type]) {
                    if (!(e = (w.find.ID(o.matches[0].replace(bt, yt), e) || [])[0])) return i;
                    h && (e = e.parentNode), t = t.slice(r.shift().value.length)
                }
                for (s = ht.needsContext.test(t) ? 0 : r.length; s-- && (o = r[s], !w.relative[a = o.type]);) if ((c = w.find[a]) && (n = c(o.matches[0].replace(bt, yt), mt.test(r[0].type) && l(e.parentNode) || e))) {
                    if (r.splice(s, 1), !(t = n.length && u(r))) return K.apply(i, n), i;
                    break
                }
            }
            return (h || C(t, d))(n, e, !k, i, !e || mt.test(t) && l(e.parentNode) || e), i
        }, y.sortStable = V.split("").sort(U).join("") === V, y.detectDuplicates = !!E, $(), y.sortDetached = s(function (t) {
            return 1 & t.compareDocumentPosition(D.createElement("div"))
        }), s(function (t) {
            return t.innerHTML = "<a href='#'></a>", "#" === t.firstChild.getAttribute("href")
        }) || r("type|href|height|width", function (t, e, i) {
            return i ? void 0 : t.getAttribute(e, "type" === e.toLowerCase() ? 1 : 2)
        }), y.attributes && s(function (t) {
            return t.innerHTML = "<input/>", t.firstChild.setAttribute("value", ""), "" === t.firstChild.getAttribute("value")
        }) || r("value", function (t, e, i) {
            return i || "input" !== t.nodeName.toLowerCase() ? void 0 : t.defaultValue
        }), s(function (t) {
            return null == t.getAttribute("disabled")
        }) || r(J, function (t, e, i) {
            var n;
            return i ? void 0 : !0 === t[e] ? e.toLowerCase() : (n = t.getAttributeNode(e)) && n.specified ? n.value : null
        }), e
    }(t);
    rt.find = at, rt.expr = at.selectors, rt.expr[":"] = rt.expr.pseudos, rt.uniqueSort = rt.unique = at.uniqueSort, rt.text = at.getText, rt.isXMLDoc = at.isXML, rt.contains = at.contains;
    var lt = function (t, e, i) {
        for (var n = [], s = void 0 !== i; (t = t[e]) && 9 !== t.nodeType;) if (1 === t.nodeType) {
            if (s && rt(t).is(i)) break;
            n.push(t)
        }
        return n
    }, ct = function (t, e) {
        for (var i = []; t; t = t.nextSibling) 1 === t.nodeType && t !== e && i.push(t);
        return i
    }, ut = rt.expr.match.needsContext, ht = /^<([\w-]+)\s*\/?>(?:<\/\1>|)$/, dt = /^.[^:#\[\.,]*$/;
    rt.filter = function (t, e, i) {
        var n = e[0];
        return i && (t = ":not(" + t + ")"), 1 === e.length && 1 === n.nodeType ? rt.find.matchesSelector(n, t) ? [n] : [] : rt.find.matches(t, rt.grep(e, function (t) {
            return 1 === t.nodeType
        }))
    }, rt.fn.extend({
        find: function (t) {
            var e, i = this.length, n = [], s = this;
            if ("string" != typeof t) return this.pushStack(rt(t).filter(function () {
                for (e = 0; i > e; e++) if (rt.contains(s[e], this)) return !0
            }));
            for (e = 0; i > e; e++) rt.find(t, s[e], n);
            return n = this.pushStack(i > 1 ? rt.unique(n) : n), n.selector = this.selector ? this.selector + " " + t : t, n
        }, filter: function (t) {
            return this.pushStack(n(this, t || [], !1))
        }, not: function (t) {
            return this.pushStack(n(this, t || [], !0))
        }, is: function (t) {
            return !!n(this, "string" == typeof t && ut.test(t) ? rt(t) : t || [], !1).length
        }
    });
    var pt, ft = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/;
    (rt.fn.init = function (t, e, i) {
        var n, s;
        if (!t) return this;
        if (i = i || pt, "string" == typeof t) {
            if (!(n = "<" === t[0] && ">" === t[t.length - 1] && t.length >= 3 ? [null, t, null] : ft.exec(t)) || !n[1] && e) return !e || e.jquery ? (e || i).find(t) : this.constructor(e).find(t);
            if (n[1]) {
                if (e = e instanceof rt ? e[0] : e, rt.merge(this, rt.parseHTML(n[1], e && e.nodeType ? e.ownerDocument || e : Y, !0)), ht.test(n[1]) && rt.isPlainObject(e)) for (n in e) rt.isFunction(this[n]) ? this[n](e[n]) : this.attr(n, e[n]);
                return this
            }
            return s = Y.getElementById(n[2]), s && s.parentNode && (this.length = 1, this[0] = s), this.context = Y, this.selector = t, this
        }
        return t.nodeType ? (this.context = this[0] = t, this.length = 1, this) : rt.isFunction(t) ? void 0 !== i.ready ? i.ready(t) : t(rt) : (void 0 !== t.selector && (this.selector = t.selector, this.context = t.context), rt.makeArray(t, this))
    }).prototype = rt.fn, pt = rt(Y);
    var gt = /^(?:parents|prev(?:Until|All))/, mt = {children: !0, contents: !0, next: !0, prev: !0};
    rt.fn.extend({
        has: function (t) {
            var e = rt(t, this), i = e.length;
            return this.filter(function () {
                for (var t = 0; i > t; t++) if (rt.contains(this, e[t])) return !0
            })
        }, closest: function (t, e) {
            for (var i, n = 0, s = this.length, r = [], o = ut.test(t) || "string" != typeof t ? rt(t, e || this.context) : 0; s > n; n++) for (i = this[n]; i && i !== e; i = i.parentNode) if (i.nodeType < 11 && (o ? o.index(i) > -1 : 1 === i.nodeType && rt.find.matchesSelector(i, t))) {
                r.push(i);
                break
            }
            return this.pushStack(r.length > 1 ? rt.uniqueSort(r) : r)
        }, index: function (t) {
            return t ? "string" == typeof t ? J.call(rt(t), this[0]) : J.call(this, t.jquery ? t[0] : t) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        }, add: function (t, e) {
            return this.pushStack(rt.uniqueSort(rt.merge(this.get(), rt(t, e))))
        }, addBack: function (t) {
            return this.add(null == t ? this.prevObject : this.prevObject.filter(t))
        }
    }), rt.each({
        parent: function (t) {
            var e = t.parentNode;
            return e && 11 !== e.nodeType ? e : null
        }, parents: function (t) {
            return lt(t, "parentNode")
        }, parentsUntil: function (t, e, i) {
            return lt(t, "parentNode", i)
        }, next: function (t) {
            return s(t, "nextSibling")
        }, prev: function (t) {
            return s(t, "previousSibling")
        }, nextAll: function (t) {
            return lt(t, "nextSibling")
        }, prevAll: function (t) {
            return lt(t, "previousSibling")
        }, nextUntil: function (t, e, i) {
            return lt(t, "nextSibling", i)
        }, prevUntil: function (t, e, i) {
            return lt(t, "previousSibling", i)
        }, siblings: function (t) {
            return ct((t.parentNode || {}).firstChild, t)
        }, children: function (t) {
            return ct(t.firstChild)
        }, contents: function (t) {
            return t.contentDocument || rt.merge([], t.childNodes)
        }
    }, function (t, e) {
        rt.fn[t] = function (i, n) {
            var s = rt.map(this, e, i);
            return "Until" !== t.slice(-5) && (n = i), n && "string" == typeof n && (s = rt.filter(n, s)), this.length > 1 && (mt[t] || rt.uniqueSort(s), gt.test(t) && s.reverse()), this.pushStack(s)
        }
    });
    var vt = /\S+/g;
    rt.Callbacks = function (t) {
        t = "string" == typeof t ? r(t) : rt.extend({}, t);
        var e, i, n, s, o = [], a = [], l = -1, c = function () {
            for (s = t.once, n = e = !0; a.length; l = -1) for (i = a.shift(); ++l < o.length;) !1 === o[l].apply(i[0], i[1]) && t.stopOnFalse && (l = o.length, i = !1);
            t.memory || (i = !1), e = !1, s && (o = i ? [] : "")
        }, u = {
            add: function () {
                return o && (i && !e && (l = o.length - 1, a.push(i)), function e(i) {
                    rt.each(i, function (i, n) {
                        rt.isFunction(n) ? t.unique && u.has(n) || o.push(n) : n && n.length && "string" !== rt.type(n) && e(n)
                    })
                }(arguments), i && !e && c()), this
            }, remove: function () {
                return rt.each(arguments, function (t, e) {
                    for (var i; (i = rt.inArray(e, o, i)) > -1;) o.splice(i, 1), l >= i && l--
                }), this
            }, has: function (t) {
                return t ? rt.inArray(t, o) > -1 : o.length > 0
            }, empty: function () {
                return o && (o = []), this
            }, disable: function () {
                return s = a = [], o = i = "", this
            }, disabled: function () {
                return !o
            }, lock: function () {
                return s = a = [], i || (o = i = ""), this
            }, locked: function () {
                return !!s
            }, fireWith: function (t, i) {
                return s || (i = i || [], i = [t, i.slice ? i.slice() : i], a.push(i), e || c()), this
            }, fire: function () {
                return u.fireWith(this, arguments), this
            }, fired: function () {
                return !!n
            }
        };
        return u
    }, rt.extend({
        Deferred: function (t) {
            var e = [["resolve", "done", rt.Callbacks("once memory"), "resolved"], ["reject", "fail", rt.Callbacks("once memory"), "rejected"], ["notify", "progress", rt.Callbacks("memory")]],
                i = "pending", n = {
                    state: function () {
                        return i
                    }, always: function () {
                        return s.done(arguments).fail(arguments), this
                    }, then: function () {
                        var t = arguments;
                        return rt.Deferred(function (i) {
                            rt.each(e, function (e, r) {
                                var o = rt.isFunction(t[e]) && t[e];
                                s[r[1]](function () {
                                    var t = o && o.apply(this, arguments);
                                    t && rt.isFunction(t.promise) ? t.promise().progress(i.notify).done(i.resolve).fail(i.reject) : i[r[0] + "With"](this === n ? i.promise() : this, o ? [t] : arguments)
                                })
                            }), t = null
                        }).promise()
                    }, promise: function (t) {
                        return null != t ? rt.extend(t, n) : n
                    }
                }, s = {};
            return n.pipe = n.then, rt.each(e, function (t, r) {
                var o = r[2], a = r[3];
                n[r[1]] = o.add, a && o.add(function () {
                    i = a
                }, e[1 ^ t][2].disable, e[2][2].lock), s[r[0]] = function () {
                    return s[r[0] + "With"](this === s ? n : this, arguments), this
                }, s[r[0] + "With"] = o.fireWith
            }), n.promise(s), t && t.call(s, s), s
        }, when: function (t) {
            var e, i, n, s = 0, r = K.call(arguments), o = r.length,
                a = 1 !== o || t && rt.isFunction(t.promise) ? o : 0, l = 1 === a ? t : rt.Deferred(),
                c = function (t, i, n) {
                    return function (s) {
                        i[t] = this, n[t] = arguments.length > 1 ? K.call(arguments) : s, n === e ? l.notifyWith(i, n) : --a || l.resolveWith(i, n)
                    }
                };
            if (o > 1) for (e = new Array(o), i = new Array(o), n = new Array(o); o > s; s++) r[s] && rt.isFunction(r[s].promise) ? r[s].promise().progress(c(s, i, e)).done(c(s, n, r)).fail(l.reject) : --a;
            return a || l.resolveWith(n, r), l.promise()
        }
    });
    var bt;
    rt.fn.ready = function (t) {
        return rt.ready.promise().done(t), this
    }, rt.extend({
        isReady: !1, readyWait: 1, holdReady: function (t) {
            t ? rt.readyWait++ : rt.ready(!0)
        }, ready: function (t) {
            (!0 === t ? --rt.readyWait : rt.isReady) || (rt.isReady = !0, !0 !== t && --rt.readyWait > 0 || (bt.resolveWith(Y, [rt]), rt.fn.triggerHandler && (rt(Y).triggerHandler("ready"), rt(Y).off("ready"))))
        }
    }), rt.ready.promise = function (e) {
        return bt || (bt = rt.Deferred(), "complete" === Y.readyState || "loading" !== Y.readyState && !Y.documentElement.doScroll ? t.setTimeout(rt.ready) : (Y.addEventListener("DOMContentLoaded", o), t.addEventListener("load", o))), bt.promise(e)
    }, rt.ready.promise();
    var yt = function (t, e, i, n, s, r, o) {
        var a = 0, l = t.length, c = null == i;
        if ("object" === rt.type(i)) {
            s = !0;
            for (a in i) yt(t, e, a, i[a], !0, r, o)
        } else if (void 0 !== n && (s = !0, rt.isFunction(n) || (o = !0), c && (o ? (e.call(t, n), e = null) : (c = e, e = function (t, e, i) {
            return c.call(rt(t), i)
        })), e)) for (; l > a; a++) e(t[a], i, o ? n : n.call(t[a], a, e(t[a], i)));
        return s ? t : c ? e.call(t) : l ? e(t[0], i) : r
    }, wt = function (t) {
        return 1 === t.nodeType || 9 === t.nodeType || !+t.nodeType
    };
    a.uid = 1, a.prototype = {
        register: function (t, e) {
            var i = e || {};
            return t.nodeType ? t[this.expando] = i : Object.defineProperty(t, this.expando, {
                value: i,
                writable: !0,
                configurable: !0
            }), t[this.expando]
        }, cache: function (t) {
            if (!wt(t)) return {};
            var e = t[this.expando];
            return e || (e = {}, wt(t) && (t.nodeType ? t[this.expando] = e : Object.defineProperty(t, this.expando, {
                value: e,
                configurable: !0
            }))), e
        }, set: function (t, e, i) {
            var n, s = this.cache(t);
            if ("string" == typeof e) s[e] = i; else for (n in e) s[n] = e[n];
            return s
        }, get: function (t, e) {
            return void 0 === e ? this.cache(t) : t[this.expando] && t[this.expando][e]
        }, access: function (t, e, i) {
            var n;
            return void 0 === e || e && "string" == typeof e && void 0 === i ? (n = this.get(t, e), void 0 !== n ? n : this.get(t, rt.camelCase(e))) : (this.set(t, e, i), void 0 !== i ? i : e)
        }, remove: function (t, e) {
            var i, n, s, r = t[this.expando];
            if (void 0 !== r) {
                if (void 0 === e) this.register(t); else {
                    rt.isArray(e) ? n = e.concat(e.map(rt.camelCase)) : (s = rt.camelCase(e), e in r ? n = [e, s] : (n = s, n = n in r ? [n] : n.match(vt) || [])), i = n.length;
                    for (; i--;) delete r[n[i]]
                }
                (void 0 === e || rt.isEmptyObject(r)) && (t.nodeType ? t[this.expando] = void 0 : delete t[this.expando])
            }
        }, hasData: function (t) {
            var e = t[this.expando];
            return void 0 !== e && !rt.isEmptyObject(e)
        }
    };
    var xt = new a, _t = new a, At = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, Ct = /[A-Z]/g;
    rt.extend({
        hasData: function (t) {
            return _t.hasData(t) || xt.hasData(t)
        }, data: function (t, e, i) {
            return _t.access(t, e, i)
        }, removeData: function (t, e) {
            _t.remove(t, e)
        }, _data: function (t, e, i) {
            return xt.access(t, e, i)
        }, _removeData: function (t, e) {
            xt.remove(t, e)
        }
    }), rt.fn.extend({
        data: function (t, e) {
            var i, n, s, r = this[0], o = r && r.attributes;
            if (void 0 === t) {
                if (this.length && (s = _t.get(r), 1 === r.nodeType && !xt.get(r, "hasDataAttrs"))) {
                    for (i = o.length; i--;) o[i] && (n = o[i].name, 0 === n.indexOf("data-") && (n = rt.camelCase(n.slice(5)), l(r, n, s[n])));
                    xt.set(r, "hasDataAttrs", !0)
                }
                return s
            }
            return "object" == typeof t ? this.each(function () {
                _t.set(this, t)
            }) : yt(this, function (e) {
                var i, n;
                if (r && void 0 === e) {
                    if (void 0 !== (i = _t.get(r, t) || _t.get(r, t.replace(Ct, "-$&").toLowerCase()))) return i;
                    if (n = rt.camelCase(t), void 0 !== (i = _t.get(r, n))) return i;
                    if (void 0 !== (i = l(r, n, void 0))) return i
                } else n = rt.camelCase(t), this.each(function () {
                    var i = _t.get(this, n);
                    _t.set(this, n, e), t.indexOf("-") > -1 && void 0 !== i && _t.set(this, t, e)
                })
            }, null, e, arguments.length > 1, null, !0)
        }, removeData: function (t) {
            return this.each(function () {
                _t.remove(this, t)
            })
        }
    }), rt.extend({
        queue: function (t, e, i) {
            var n;
            return t ? (e = (e || "fx") + "queue", n = xt.get(t, e), i && (!n || rt.isArray(i) ? n = xt.access(t, e, rt.makeArray(i)) : n.push(i)), n || []) : void 0
        }, dequeue: function (t, e) {
            e = e || "fx";
            var i = rt.queue(t, e), n = i.length, s = i.shift(), r = rt._queueHooks(t, e), o = function () {
                rt.dequeue(t, e)
            };
            "inprogress" === s && (s = i.shift(), n--), s && ("fx" === e && i.unshift("inprogress"), delete r.stop, s.call(t, o, r)), !n && r && r.empty.fire()
        }, _queueHooks: function (t, e) {
            var i = e + "queueHooks";
            return xt.get(t, i) || xt.access(t, i, {
                empty: rt.Callbacks("once memory").add(function () {
                    xt.remove(t, [e + "queue", i])
                })
            })
        }
    }), rt.fn.extend({
        queue: function (t, e) {
            var i = 2;
            return "string" != typeof t && (e = t, t = "fx", i--), arguments.length < i ? rt.queue(this[0], t) : void 0 === e ? this : this.each(function () {
                var i = rt.queue(this, t, e);
                rt._queueHooks(this, t), "fx" === t && "inprogress" !== i[0] && rt.dequeue(this, t)
            })
        }, dequeue: function (t) {
            return this.each(function () {
                rt.dequeue(this, t)
            })
        }, clearQueue: function (t) {
            return this.queue(t || "fx", [])
        }, promise: function (t, e) {
            var i, n = 1, s = rt.Deferred(), r = this, o = this.length, a = function () {
                --n || s.resolveWith(r, [r])
            };
            for ("string" != typeof t && (e = t, t = void 0), t = t || "fx"; o--;) (i = xt.get(r[o], t + "queueHooks")) && i.empty && (n++, i.empty.add(a));
            return a(), s.promise(e)
        }
    });
    var Tt = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, St = new RegExp("^(?:([+-])=|)(" + Tt + ")([a-z%]*)$", "i"),
        It = ["Top", "Right", "Bottom", "Left"], Et = function (t, e) {
            return t = e || t, "none" === rt.css(t, "display") || !rt.contains(t.ownerDocument, t)
        }, $t = /^(?:checkbox|radio)$/i, Dt = /<([\w:-]+)/, Pt = /^$|\/(?:java|ecma)script/i, kt = {
            option: [1, "<select multiple='multiple'>", "</select>"],
            thead: [1, "<table>", "</table>"],
            col: [2, "<table><colgroup>", "</colgroup></table>"],
            tr: [2, "<table><tbody>", "</tbody></table>"],
            td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
            _default: [0, "", ""]
        };
    kt.optgroup = kt.option, kt.tbody = kt.tfoot = kt.colgroup = kt.caption = kt.thead, kt.th = kt.td;
    var Nt = /<|&#?\w+;/;
    !function () {
        var t = Y.createDocumentFragment(), e = t.appendChild(Y.createElement("div")), i = Y.createElement("input");
        i.setAttribute("type", "radio"), i.setAttribute("checked", "checked"), i.setAttribute("name", "t"), e.appendChild(i), nt.checkClone = e.cloneNode(!0).cloneNode(!0).lastChild.checked, e.innerHTML = "<textarea>x</textarea>", nt.noCloneChecked = !!e.cloneNode(!0).lastChild.defaultValue
    }();
    var Lt = /^key/, Ot = /^(?:mouse|pointer|contextmenu|drag|drop)|click/, Rt = /^([^.]*)(?:\.(.+)|)/;
    rt.event = {
        global: {},
        add: function (t, e, i, n, s) {
            var r, o, a, l, c, u, h, d, p, f, g, m = xt.get(t);
            if (m) for (i.handler && (r = i, i = r.handler, s = r.selector), i.guid || (i.guid = rt.guid++), (l = m.events) || (l = m.events = {}), (o = m.handle) || (o = m.handle = function (e) {
                return void 0 !== rt && rt.event.triggered !== e.type ? rt.event.dispatch.apply(t, arguments) : void 0
            }), e = (e || "").match(vt) || [""], c = e.length; c--;) a = Rt.exec(e[c]) || [], p = g = a[1], f = (a[2] || "").split(".").sort(), p && (h = rt.event.special[p] || {}, p = (s ? h.delegateType : h.bindType) || p, h = rt.event.special[p] || {}, u = rt.extend({
                type: p,
                origType: g,
                data: n,
                handler: i,
                guid: i.guid,
                selector: s,
                needsContext: s && rt.expr.match.needsContext.test(s),
                namespace: f.join(".")
            }, r), (d = l[p]) || (d = l[p] = [], d.delegateCount = 0, h.setup && !1 !== h.setup.call(t, n, f, o) || t.addEventListener && t.addEventListener(p, o)), h.add && (h.add.call(t, u), u.handler.guid || (u.handler.guid = i.guid)), s ? d.splice(d.delegateCount++, 0, u) : d.push(u), rt.event.global[p] = !0)
        },
        remove: function (t, e, i, n, s) {
            var r, o, a, l, c, u, h, d, p, f, g, m = xt.hasData(t) && xt.get(t);
            if (m && (l = m.events)) {
                for (e = (e || "").match(vt) || [""], c = e.length; c--;) if (a = Rt.exec(e[c]) || [], p = g = a[1], f = (a[2] || "").split(".").sort(), p) {
                    for (h = rt.event.special[p] || {}, p = (n ? h.delegateType : h.bindType) || p, d = l[p] || [], a = a[2] && new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)"), o = r = d.length; r--;) u = d[r], !s && g !== u.origType || i && i.guid !== u.guid || a && !a.test(u.namespace) || n && n !== u.selector && ("**" !== n || !u.selector) || (d.splice(r, 1), u.selector && d.delegateCount--, h.remove && h.remove.call(t, u));
                    o && !d.length && (h.teardown && !1 !== h.teardown.call(t, f, m.handle) || rt.removeEvent(t, p, m.handle), delete l[p])
                } else for (p in l) rt.event.remove(t, p + e[c], i, n, !0);
                rt.isEmptyObject(l) && xt.remove(t, "handle events")
            }
        },
        dispatch: function (t) {
            t = rt.event.fix(t);
            var e, i, n, s, r, o = [], a = K.call(arguments), l = (xt.get(this, "events") || {})[t.type] || [],
                c = rt.event.special[t.type] || {};
            if (a[0] = t, t.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, t)) {
                for (o = rt.event.handlers.call(this, t, l), e = 0; (s = o[e++]) && !t.isPropagationStopped();) for (t.currentTarget = s.elem, i = 0; (r = s.handlers[i++]) && !t.isImmediatePropagationStopped();) t.rnamespace && !t.rnamespace.test(r.namespace) || (t.handleObj = r, t.data = r.data, void 0 !== (n = ((rt.event.special[r.origType] || {}).handle || r.handler).apply(s.elem, a)) && !1 === (t.result = n) && (t.preventDefault(), t.stopPropagation()));
                return c.postDispatch && c.postDispatch.call(this, t), t.result
            }
        },
        handlers: function (t, e) {
            var i, n, s, r, o = [], a = e.delegateCount, l = t.target;
            if (a && l.nodeType && ("click" !== t.type || isNaN(t.button) || t.button < 1)) for (; l !== this; l = l.parentNode || this) if (1 === l.nodeType && (!0 !== l.disabled || "click" !== t.type)) {
                for (n = [], i = 0; a > i; i++) r = e[i], s = r.selector + " ", void 0 === n[s] && (n[s] = r.needsContext ? rt(s, this).index(l) > -1 : rt.find(s, this, null, [l]).length), n[s] && n.push(r);
                n.length && o.push({elem: l, handlers: n})
            }
            return a < e.length && o.push({elem: this, handlers: e.slice(a)}), o
        },
        props: "altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "), filter: function (t, e) {
                return null == t.which && (t.which = null != e.charCode ? e.charCode : e.keyCode), t
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function (t, e) {
                var i, n, s, r = e.button;
                return null == t.pageX && null != e.clientX && (i = t.target.ownerDocument || Y, n = i.documentElement, s = i.body, t.pageX = e.clientX + (n && n.scrollLeft || s && s.scrollLeft || 0) - (n && n.clientLeft || s && s.clientLeft || 0), t.pageY = e.clientY + (n && n.scrollTop || s && s.scrollTop || 0) - (n && n.clientTop || s && s.clientTop || 0)), t.which || void 0 === r || (t.which = 1 & r ? 1 : 2 & r ? 3 : 4 & r ? 2 : 0), t
            }
        },
        fix: function (t) {
            if (t[rt.expando]) return t;
            var e, i, n, s = t.type, r = t, o = this.fixHooks[s];
            for (o || (this.fixHooks[s] = o = Ot.test(s) ? this.mouseHooks : Lt.test(s) ? this.keyHooks : {}), n = o.props ? this.props.concat(o.props) : this.props, t = new rt.Event(r), e = n.length; e--;) i = n[e], t[i] = r[i];
            return t.target || (t.target = Y), 3 === t.target.nodeType && (t.target = t.target.parentNode), o.filter ? o.filter(t, r) : t
        },
        special: {
            load: {noBubble: !0}, focus: {
                trigger: function () {
                    return this !== g() && this.focus ? (this.focus(), !1) : void 0
                }, delegateType: "focusin"
            }, blur: {
                trigger: function () {
                    return this === g() && this.blur ? (this.blur(), !1) : void 0
                }, delegateType: "focusout"
            }, click: {
                trigger: function () {
                    return "checkbox" === this.type && this.click && rt.nodeName(this, "input") ? (this.click(), !1) : void 0
                }, _default: function (t) {
                    return rt.nodeName(t.target, "a")
                }
            }, beforeunload: {
                postDispatch: function (t) {
                    void 0 !== t.result && t.originalEvent && (t.originalEvent.returnValue = t.result)
                }
            }
        }
    }, rt.removeEvent = function (t, e, i) {
        t.removeEventListener && t.removeEventListener(e, i)
    }, rt.Event = function (t, e) {
        return this instanceof rt.Event ? (t && t.type ? (this.originalEvent = t, this.type = t.type, this.isDefaultPrevented = t.defaultPrevented || void 0 === t.defaultPrevented && !1 === t.returnValue ? p : f) : this.type = t, e && rt.extend(this, e), this.timeStamp = t && t.timeStamp || rt.now(), void(this[rt.expando] = !0)) : new rt.Event(t, e)
    }, rt.Event.prototype = {
        constructor: rt.Event,
        isDefaultPrevented: f,
        isPropagationStopped: f,
        isImmediatePropagationStopped: f,
        preventDefault: function () {
            var t = this.originalEvent;
            this.isDefaultPrevented = p, t && t.preventDefault()
        },
        stopPropagation: function () {
            var t = this.originalEvent;
            this.isPropagationStopped = p, t && t.stopPropagation()
        },
        stopImmediatePropagation: function () {
            var t = this.originalEvent;
            this.isImmediatePropagationStopped = p, t && t.stopImmediatePropagation(), this.stopPropagation()
        }
    }, rt.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function (t, e) {
        rt.event.special[t] = {
            delegateType: e, bindType: e, handle: function (t) {
                var i, n = this, s = t.relatedTarget, r = t.handleObj;
                return s && (s === n || rt.contains(n, s)) || (t.type = r.origType, i = r.handler.apply(this, arguments), t.type = e), i
            }
        }
    }), rt.fn.extend({
        on: function (t, e, i, n) {
            return m(this, t, e, i, n)
        }, one: function (t, e, i, n) {
            return m(this, t, e, i, n, 1)
        }, off: function (t, e, i) {
            var n, s;
            if (t && t.preventDefault && t.handleObj) return n = t.handleObj, rt(t.delegateTarget).off(n.namespace ? n.origType + "." + n.namespace : n.origType, n.selector, n.handler), this;
            if ("object" == typeof t) {
                for (s in t) this.off(s, e, t[s]);
                return this
            }
            return !1 !== e && "function" != typeof e || (i = e, e = void 0), !1 === i && (i = f), this.each(function () {
                rt.event.remove(this, t, i, e)
            })
        }
    });
    var Vt = /<script|<style|<link/i, Ht = /checked\s*(?:[^=]|=\s*.checked.)/i, Ft = /^true\/(.*)/,
        Mt = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;
    rt.extend({
        htmlPrefilter: function (t) {
            return t.replace(/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:-]+)[^>]*)\/>/gi, "<$1></$2>")
        }, clone: function (t, e, i) {
            var n, s, r, o, a = t.cloneNode(!0), l = rt.contains(t.ownerDocument, t);
            if (!(nt.noCloneChecked || 1 !== t.nodeType && 11 !== t.nodeType || rt.isXMLDoc(t))) for (o = u(a), r = u(t), n = 0, s = r.length; s > n; n++) x(r[n], o[n]);
            if (e) if (i) for (r = r || u(t), o = o || u(a), n = 0, s = r.length; s > n; n++) w(r[n], o[n]); else w(t, a);
            return o = u(a, "script"), o.length > 0 && h(o, !l && u(t, "script")), a
        }, cleanData: function (t) {
            for (var e, i, n, s = rt.event.special, r = 0; void 0 !== (i = t[r]); r++) if (wt(i)) {
                if (e = i[xt.expando]) {
                    if (e.events) for (n in e.events) s[n] ? rt.event.remove(i, n) : rt.removeEvent(i, n, e.handle);
                    i[xt.expando] = void 0
                }
                i[_t.expando] && (i[_t.expando] = void 0)
            }
        }
    }), rt.fn.extend({
        domManip: _, detach: function (t) {
            return A(this, t, !0)
        }, remove: function (t) {
            return A(this, t)
        }, text: function (t) {
            return yt(this, function (t) {
                return void 0 === t ? rt.text(this) : this.empty().each(function () {
                    1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = t)
                })
            }, null, t, arguments.length)
        }, append: function () {
            return _(this, arguments, function (t) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    v(this, t).appendChild(t)
                }
            })
        }, prepend: function () {
            return _(this, arguments, function (t) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var e = v(this, t);
                    e.insertBefore(t, e.firstChild)
                }
            })
        }, before: function () {
            return _(this, arguments, function (t) {
                this.parentNode && this.parentNode.insertBefore(t, this)
            })
        }, after: function () {
            return _(this, arguments, function (t) {
                this.parentNode && this.parentNode.insertBefore(t, this.nextSibling)
            })
        }, empty: function () {
            for (var t, e = 0; null != (t = this[e]); e++) 1 === t.nodeType && (rt.cleanData(u(t, !1)), t.textContent = "");
            return this
        }, clone: function (t, e) {
            return t = null != t && t, e = null == e ? t : e, this.map(function () {
                return rt.clone(this, t, e)
            })
        }, html: function (t) {
            return yt(this, function (t) {
                var e = this[0] || {}, i = 0, n = this.length;
                if (void 0 === t && 1 === e.nodeType) return e.innerHTML;
                if ("string" == typeof t && !Vt.test(t) && !kt[(Dt.exec(t) || ["", ""])[1].toLowerCase()]) {
                    t = rt.htmlPrefilter(t);
                    try {
                        for (; n > i; i++) e = this[i] || {}, 1 === e.nodeType && (rt.cleanData(u(e, !1)), e.innerHTML = t);
                        e = 0
                    } catch (t) {
                    }
                }
                e && this.empty().append(t)
            }, null, t, arguments.length)
        }, replaceWith: function () {
            var t = [];
            return _(this, arguments, function (e) {
                var i = this.parentNode;
                rt.inArray(this, t) < 0 && (rt.cleanData(u(this)), i && i.replaceChild(e, this))
            }, t)
        }
    }), rt.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function (t, e) {
        rt.fn[t] = function (t) {
            for (var i, n = [], s = rt(t), r = s.length - 1, o = 0; r >= o; o++) i = o === r ? this : this.clone(!0), rt(s[o])[e](i), Q.apply(n, i.get());
            return this.pushStack(n)
        }
    });
    var zt, jt = {HTML: "block", BODY: "block"}, Bt = /^margin/, Ut = new RegExp("^(" + Tt + ")(?!px)[a-z%]+$", "i"),
        Wt = function (e) {
            var i = e.ownerDocument.defaultView;
            return i && i.opener || (i = t), i.getComputedStyle(e)
        }, qt = function (t, e, i, n) {
            var s, r, o = {};
            for (r in e) o[r] = t.style[r], t.style[r] = e[r];
            s = i.apply(t, n || []);
            for (r in e) t.style[r] = o[r];
            return s
        }, Gt = Y.documentElement;
    !function () {
        function e() {
            a.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:relative;display:block;margin:auto;border:1px;padding:1px;top:1%;width:50%", a.innerHTML = "", Gt.appendChild(o);
            var e = t.getComputedStyle(a);
            i = "1%" !== e.top, r = "2px" === e.marginLeft, n = "4px" === e.width, a.style.marginRight = "50%", s = "4px" === e.marginRight, Gt.removeChild(o)
        }

        var i, n, s, r, o = Y.createElement("div"), a = Y.createElement("div");
        a.style && (a.style.backgroundClip = "content-box", a.cloneNode(!0).style.backgroundClip = "", nt.clearCloneStyle = "content-box" === a.style.backgroundClip, o.style.cssText = "border:0;width:8px;height:0;top:0;left:-9999px;padding:0;margin-top:1px;position:absolute", o.appendChild(a), rt.extend(nt, {
            pixelPosition: function () {
                return e(), i
            }, boxSizingReliable: function () {
                return null == n && e(), n
            }, pixelMarginRight: function () {
                return null == n && e(), s
            }, reliableMarginLeft: function () {
                return null == n && e(), r
            }, reliableMarginRight: function () {
                var e, i = a.appendChild(Y.createElement("div"));
                return i.style.cssText = a.style.cssText = "-webkit-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", i.style.marginRight = i.style.width = "0", a.style.width = "1px", Gt.appendChild(o), e = !parseFloat(t.getComputedStyle(i).marginRight), Gt.removeChild(o), a.removeChild(i), e
            }
        }))
    }();
    var Zt = /^(none|table(?!-c[ea]).+)/, Yt = {position: "absolute", visibility: "hidden", display: "block"},
        Kt = {letterSpacing: "0", fontWeight: "400"}, Xt = ["Webkit", "O", "Moz", "ms"],
        Qt = Y.createElement("div").style;
    rt.extend({
        cssHooks: {
            opacity: {
                get: function (t, e) {
                    if (e) {
                        var i = S(t, "opacity");
                        return "" === i ? "1" : i
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {float: "cssFloat"},
        style: function (t, e, i, n) {
            if (t && 3 !== t.nodeType && 8 !== t.nodeType && t.style) {
                var s, r, o, a = rt.camelCase(e), l = t.style;
                return e = rt.cssProps[a] || (rt.cssProps[a] = E(a) || a), o = rt.cssHooks[e] || rt.cssHooks[a], void 0 === i ? o && "get" in o && void 0 !== (s = o.get(t, !1, n)) ? s : l[e] : (r = typeof i, "string" === r && (s = St.exec(i)) && s[1] && (i = c(t, e, s), r = "number"), void(null != i && i === i && ("number" === r && (i += s && s[3] || (rt.cssNumber[a] ? "" : "px")), nt.clearCloneStyle || "" !== i || 0 !== e.indexOf("background") || (l[e] = "inherit"), o && "set" in o && void 0 === (i = o.set(t, i, n)) || (l[e] = i))))
            }
        },
        css: function (t, e, i, n) {
            var s, r, o, a = rt.camelCase(e);
            return e = rt.cssProps[a] || (rt.cssProps[a] = E(a) || a), o = rt.cssHooks[e] || rt.cssHooks[a], o && "get" in o && (s = o.get(t, !0, i)), void 0 === s && (s = S(t, e, n)), "normal" === s && e in Kt && (s = Kt[e]), "" === i || i ? (r = parseFloat(s), !0 === i || isFinite(r) ? r || 0 : s) : s
        }
    }), rt.each(["height", "width"], function (t, e) {
        rt.cssHooks[e] = {
            get: function (t, i, n) {
                return i ? Zt.test(rt.css(t, "display")) && 0 === t.offsetWidth ? qt(t, Yt, function () {
                    return P(t, e, n)
                }) : P(t, e, n) : void 0
            }, set: function (t, i, n) {
                var s, r = n && Wt(t), o = n && D(t, e, n, "border-box" === rt.css(t, "boxSizing", !1, r), r);
                return o && (s = St.exec(i)) && "px" !== (s[3] || "px") && (t.style[e] = i, i = rt.css(t, e)), $(t, i, o)
            }
        }
    }), rt.cssHooks.marginLeft = I(nt.reliableMarginLeft, function (t, e) {
        return e ? (parseFloat(S(t, "marginLeft")) || t.getBoundingClientRect().left - qt(t, {marginLeft: 0}, function () {
            return t.getBoundingClientRect().left
        })) + "px" : void 0
    }), rt.cssHooks.marginRight = I(nt.reliableMarginRight, function (t, e) {
        return e ? qt(t, {display: "inline-block"}, S, [t, "marginRight"]) : void 0
    }), rt.each({margin: "", padding: "", border: "Width"}, function (t, e) {
        rt.cssHooks[t + e] = {
            expand: function (i) {
                for (var n = 0, s = {}, r = "string" == typeof i ? i.split(" ") : [i]; 4 > n; n++) s[t + It[n] + e] = r[n] || r[n - 2] || r[0];
                return s
            }
        }, Bt.test(t) || (rt.cssHooks[t + e].set = $)
    }), rt.fn.extend({
        css: function (t, e) {
            return yt(this, function (t, e, i) {
                var n, s, r = {}, o = 0;
                if (rt.isArray(e)) {
                    for (n = Wt(t), s = e.length; s > o; o++) r[e[o]] = rt.css(t, e[o], !1, n);
                    return r
                }
                return void 0 !== i ? rt.style(t, e, i) : rt.css(t, e)
            }, t, e, arguments.length > 1)
        }, show: function () {
            return k(this, !0)
        }, hide: function () {
            return k(this)
        }, toggle: function (t) {
            return "boolean" == typeof t ? t ? this.show() : this.hide() : this.each(function () {
                Et(this) ? rt(this).show() : rt(this).hide()
            })
        }
    }), rt.Tween = N, N.prototype = {
        constructor: N, init: function (t, e, i, n, s, r) {
            this.elem = t, this.prop = i, this.easing = s || rt.easing._default, this.options = e, this.start = this.now = this.cur(), this.end = n, this.unit = r || (rt.cssNumber[i] ? "" : "px")
        }, cur: function () {
            var t = N.propHooks[this.prop];
            return t && t.get ? t.get(this) : N.propHooks._default.get(this)
        }, run: function (t) {
            var e, i = N.propHooks[this.prop];
            return this.options.duration ? this.pos = e = rt.easing[this.easing](t, this.options.duration * t, 0, 1, this.options.duration) : this.pos = e = t, this.now = (this.end - this.start) * e + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), i && i.set ? i.set(this) : N.propHooks._default.set(this), this
        }
    }, N.prototype.init.prototype = N.prototype, N.propHooks = {
        _default: {
            get: function (t) {
                var e;
                return 1 !== t.elem.nodeType || null != t.elem[t.prop] && null == t.elem.style[t.prop] ? t.elem[t.prop] : (e = rt.css(t.elem, t.prop, ""), e && "auto" !== e ? e : 0)
            }, set: function (t) {
                rt.fx.step[t.prop] ? rt.fx.step[t.prop](t) : 1 !== t.elem.nodeType || null == t.elem.style[rt.cssProps[t.prop]] && !rt.cssHooks[t.prop] ? t.elem[t.prop] = t.now : rt.style(t.elem, t.prop, t.now + t.unit)
            }
        }
    }, N.propHooks.scrollTop = N.propHooks.scrollLeft = {
        set: function (t) {
            t.elem.nodeType && t.elem.parentNode && (t.elem[t.prop] = t.now)
        }
    }, rt.easing = {
        linear: function (t) {
            return t
        }, swing: function (t) {
            return .5 - Math.cos(t * Math.PI) / 2
        }, _default: "swing"
    }, rt.fx = N.prototype.init, rt.fx.step = {};
    var Jt, te, ee = /^(?:toggle|show|hide)$/, ie = /queueHooks$/;
    rt.Animation = rt.extend(F, {
        tweeners: {
            "*": [function (t, e) {
                var i = this.createTween(t, e);
                return c(i.elem, t, St.exec(e), i), i
            }]
        }, tweener: function (t, e) {
            rt.isFunction(t) ? (e = t, t = ["*"]) : t = t.match(vt);
            for (var i, n = 0, s = t.length; s > n; n++) i = t[n], F.tweeners[i] = F.tweeners[i] || [], F.tweeners[i].unshift(e)
        }, prefilters: [V], prefilter: function (t, e) {
            e ? F.prefilters.unshift(t) : F.prefilters.push(t)
        }
    }), rt.speed = function (t, e, i) {
        var n = t && "object" == typeof t ? rt.extend({}, t) : {
            complete: i || !i && e || rt.isFunction(t) && t,
            duration: t,
            easing: i && e || e && !rt.isFunction(e) && e
        };
        return n.duration = rt.fx.off ? 0 : "number" == typeof n.duration ? n.duration : n.duration in rt.fx.speeds ? rt.fx.speeds[n.duration] : rt.fx.speeds._default, null != n.queue && !0 !== n.queue || (n.queue = "fx"), n.old = n.complete, n.complete = function () {
            rt.isFunction(n.old) && n.old.call(this), n.queue && rt.dequeue(this, n.queue)
        }, n
    }, rt.fn.extend({
        fadeTo: function (t, e, i, n) {
            return this.filter(Et).css("opacity", 0).show().end().animate({opacity: e}, t, i, n)
        }, animate: function (t, e, i, n) {
            var s = rt.isEmptyObject(t), r = rt.speed(e, i, n), o = function () {
                var e = F(this, rt.extend({}, t), r);
                (s || xt.get(this, "finish")) && e.stop(!0)
            };
            return o.finish = o, s || !1 === r.queue ? this.each(o) : this.queue(r.queue, o)
        }, stop: function (t, e, i) {
            var n = function (t) {
                var e = t.stop;
                delete t.stop, e(i)
            };
            return "string" != typeof t && (i = e, e = t, t = void 0), e && !1 !== t && this.queue(t || "fx", []), this.each(function () {
                var e = !0, s = null != t && t + "queueHooks", r = rt.timers, o = xt.get(this);
                if (s) o[s] && o[s].stop && n(o[s]); else for (s in o) o[s] && o[s].stop && ie.test(s) && n(o[s]);
                for (s = r.length; s--;) r[s].elem !== this || null != t && r[s].queue !== t || (r[s].anim.stop(i), e = !1, r.splice(s, 1));
                !e && i || rt.dequeue(this, t)
            })
        }, finish: function (t) {
            return !1 !== t && (t = t || "fx"), this.each(function () {
                var e, i = xt.get(this), n = i[t + "queue"], s = i[t + "queueHooks"], r = rt.timers,
                    o = n ? n.length : 0;
                for (i.finish = !0, rt.queue(this, t, []), s && s.stop && s.stop.call(this, !0), e = r.length; e--;) r[e].elem === this && r[e].queue === t && (r[e].anim.stop(!0), r.splice(e, 1));
                for (e = 0; o > e; e++) n[e] && n[e].finish && n[e].finish.call(this);
                delete i.finish
            })
        }
    }), rt.each(["toggle", "show", "hide"], function (t, e) {
        var i = rt.fn[e];
        rt.fn[e] = function (t, n, s) {
            return null == t || "boolean" == typeof t ? i.apply(this, arguments) : this.animate(O(e, !0), t, n, s)
        }
    }), rt.each({
        slideDown: O("show"),
        slideUp: O("hide"),
        slideToggle: O("toggle"),
        fadeIn: {opacity: "show"},
        fadeOut: {opacity: "hide"},
        fadeToggle: {opacity: "toggle"}
    }, function (t, e) {
        rt.fn[t] = function (t, i, n) {
            return this.animate(e, t, i, n)
        }
    }), rt.timers = [], rt.fx.tick = function () {
        var t, e = 0, i = rt.timers;
        for (Jt = rt.now(); e < i.length; e++) (t = i[e])() || i[e] !== t || i.splice(e--, 1);
        i.length || rt.fx.stop(), Jt = void 0
    }, rt.fx.timer = function (t) {
        rt.timers.push(t),
            t() ? rt.fx.start() : rt.timers.pop()
    }, rt.fx.interval = 13, rt.fx.start = function () {
        te || (te = t.setInterval(rt.fx.tick, rt.fx.interval))
    }, rt.fx.stop = function () {
        t.clearInterval(te), te = null
    }, rt.fx.speeds = {slow: 600, fast: 200, _default: 400}, rt.fn.delay = function (e, i) {
        return e = rt.fx ? rt.fx.speeds[e] || e : e, i = i || "fx", this.queue(i, function (i, n) {
            var s = t.setTimeout(i, e);
            n.stop = function () {
                t.clearTimeout(s)
            }
        })
    }, function () {
        var t = Y.createElement("input"), e = Y.createElement("select"), i = e.appendChild(Y.createElement("option"));
        t.type = "checkbox", nt.checkOn = "" !== t.value, nt.optSelected = i.selected, e.disabled = !0, nt.optDisabled = !i.disabled, t = Y.createElement("input"), t.value = "t", t.type = "radio", nt.radioValue = "t" === t.value
    }();
    var ne, se = rt.expr.attrHandle;
    rt.fn.extend({
        attr: function (t, e) {
            return yt(this, rt.attr, t, e, arguments.length > 1)
        }, removeAttr: function (t) {
            return this.each(function () {
                rt.removeAttr(this, t)
            })
        }
    }), rt.extend({
        attr: function (t, e, i) {
            var n, s, r = t.nodeType;
            if (3 !== r && 8 !== r && 2 !== r) return void 0 === t.getAttribute ? rt.prop(t, e, i) : (1 === r && rt.isXMLDoc(t) || (e = e.toLowerCase(), s = rt.attrHooks[e] || (rt.expr.match.bool.test(e) ? ne : void 0)), void 0 !== i ? null === i ? void rt.removeAttr(t, e) : s && "set" in s && void 0 !== (n = s.set(t, i, e)) ? n : (t.setAttribute(e, i + ""), i) : s && "get" in s && null !== (n = s.get(t, e)) ? n : (n = rt.find.attr(t, e), null == n ? void 0 : n))
        }, attrHooks: {
            type: {
                set: function (t, e) {
                    if (!nt.radioValue && "radio" === e && rt.nodeName(t, "input")) {
                        var i = t.value;
                        return t.setAttribute("type", e), i && (t.value = i), e
                    }
                }
            }
        }, removeAttr: function (t, e) {
            var i, n, s = 0, r = e && e.match(vt);
            if (r && 1 === t.nodeType) for (; i = r[s++];) n = rt.propFix[i] || i, rt.expr.match.bool.test(i) && (t[n] = !1), t.removeAttribute(i)
        }
    }), ne = {
        set: function (t, e, i) {
            return !1 === e ? rt.removeAttr(t, i) : t.setAttribute(i, i), i
        }
    }, rt.each(rt.expr.match.bool.source.match(/\w+/g), function (t, e) {
        var i = se[e] || rt.find.attr;
        se[e] = function (t, e, n) {
            var s, r;
            return n || (r = se[e], se[e] = s, s = null != i(t, e, n) ? e.toLowerCase() : null, se[e] = r), s
        }
    });
    var re = /^(?:input|select|textarea|button)$/i, oe = /^(?:a|area)$/i;
    rt.fn.extend({
        prop: function (t, e) {
            return yt(this, rt.prop, t, e, arguments.length > 1)
        }, removeProp: function (t) {
            return this.each(function () {
                delete this[rt.propFix[t] || t]
            })
        }
    }), rt.extend({
        prop: function (t, e, i) {
            var n, s, r = t.nodeType;
            if (3 !== r && 8 !== r && 2 !== r) return 1 === r && rt.isXMLDoc(t) || (e = rt.propFix[e] || e, s = rt.propHooks[e]), void 0 !== i ? s && "set" in s && void 0 !== (n = s.set(t, i, e)) ? n : t[e] = i : s && "get" in s && null !== (n = s.get(t, e)) ? n : t[e]
        }, propHooks: {
            tabIndex: {
                get: function (t) {
                    var e = rt.find.attr(t, "tabindex");
                    return e ? parseInt(e, 10) : re.test(t.nodeName) || oe.test(t.nodeName) && t.href ? 0 : -1
                }
            }
        }, propFix: {for: "htmlFor", class: "className"}
    }), nt.optSelected || (rt.propHooks.selected = {
        get: function (t) {
            var e = t.parentNode;
            return e && e.parentNode && e.parentNode.selectedIndex, null
        }, set: function (t) {
            var e = t.parentNode;
            e && (e.selectedIndex, e.parentNode && e.parentNode.selectedIndex)
        }
    }), rt.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
        rt.propFix[this.toLowerCase()] = this
    });
    var ae = /[\t\r\n\f]/g;
    rt.fn.extend({
        addClass: function (t) {
            var e, i, n, s, r, o, a, l = 0;
            if (rt.isFunction(t)) return this.each(function (e) {
                rt(this).addClass(t.call(this, e, M(this)))
            });
            if ("string" == typeof t && t) for (e = t.match(vt) || []; i = this[l++];) if (s = M(i), n = 1 === i.nodeType && (" " + s + " ").replace(ae, " ")) {
                for (o = 0; r = e[o++];) n.indexOf(" " + r + " ") < 0 && (n += r + " ");
                a = rt.trim(n), s !== a && i.setAttribute("class", a)
            }
            return this
        }, removeClass: function (t) {
            var e, i, n, s, r, o, a, l = 0;
            if (rt.isFunction(t)) return this.each(function (e) {
                rt(this).removeClass(t.call(this, e, M(this)))
            });
            if (!arguments.length) return this.attr("class", "");
            if ("string" == typeof t && t) for (e = t.match(vt) || []; i = this[l++];) if (s = M(i), n = 1 === i.nodeType && (" " + s + " ").replace(ae, " ")) {
                for (o = 0; r = e[o++];) for (; n.indexOf(" " + r + " ") > -1;) n = n.replace(" " + r + " ", " ");
                a = rt.trim(n), s !== a && i.setAttribute("class", a)
            }
            return this
        }, toggleClass: function (t, e) {
            var i = typeof t;
            return "boolean" == typeof e && "string" === i ? e ? this.addClass(t) : this.removeClass(t) : rt.isFunction(t) ? this.each(function (i) {
                rt(this).toggleClass(t.call(this, i, M(this), e), e)
            }) : this.each(function () {
                var e, n, s, r;
                if ("string" === i) for (n = 0, s = rt(this), r = t.match(vt) || []; e = r[n++];) s.hasClass(e) ? s.removeClass(e) : s.addClass(e); else void 0 !== t && "boolean" !== i || (e = M(this), e && xt.set(this, "__className__", e), this.setAttribute && this.setAttribute("class", e || !1 === t ? "" : xt.get(this, "__className__") || ""))
            })
        }, hasClass: function (t) {
            var e, i, n = 0;
            for (e = " " + t + " "; i = this[n++];) if (1 === i.nodeType && (" " + M(i) + " ").replace(ae, " ").indexOf(e) > -1) return !0;
            return !1
        }
    });
    rt.fn.extend({
        val: function (t) {
            var e, i, n, s = this[0];
            return arguments.length ? (n = rt.isFunction(t), this.each(function (i) {
                var s;
                1 === this.nodeType && (s = n ? t.call(this, i, rt(this).val()) : t, null == s ? s = "" : "number" == typeof s ? s += "" : rt.isArray(s) && (s = rt.map(s, function (t) {
                    return null == t ? "" : t + ""
                })), (e = rt.valHooks[this.type] || rt.valHooks[this.nodeName.toLowerCase()]) && "set" in e && void 0 !== e.set(this, s, "value") || (this.value = s))
            })) : s ? (e = rt.valHooks[s.type] || rt.valHooks[s.nodeName.toLowerCase()], e && "get" in e && void 0 !== (i = e.get(s, "value")) ? i : (i = s.value, "string" == typeof i ? i.replace(/\r/g, "") : null == i ? "" : i)) : void 0
        }
    }), rt.extend({
        valHooks: {
            option: {
                get: function (t) {
                    var e = rt.find.attr(t, "value");
                    return null != e ? e : rt.trim(rt.text(t)).replace(/[\x20\t\r\n\f]+/g, " ")
                }
            }, select: {
                get: function (t) {
                    for (var e, i, n = t.options, s = t.selectedIndex, r = "select-one" === t.type || 0 > s, o = r ? null : [], a = r ? s + 1 : n.length, l = 0 > s ? a : r ? s : 0; a > l; l++) if (i = n[l], (i.selected || l === s) && (nt.optDisabled ? !i.disabled : null === i.getAttribute("disabled")) && (!i.parentNode.disabled || !rt.nodeName(i.parentNode, "optgroup"))) {
                        if (e = rt(i).val(), r) return e;
                        o.push(e)
                    }
                    return o
                }, set: function (t, e) {
                    for (var i, n, s = t.options, r = rt.makeArray(e), o = s.length; o--;) n = s[o], (n.selected = rt.inArray(rt.valHooks.option.get(n), r) > -1) && (i = !0);
                    return i || (t.selectedIndex = -1), r
                }
            }
        }
    }), rt.each(["radio", "checkbox"], function () {
        rt.valHooks[this] = {
            set: function (t, e) {
                return rt.isArray(e) ? t.checked = rt.inArray(rt(t).val(), e) > -1 : void 0
            }
        }, nt.checkOn || (rt.valHooks[this].get = function (t) {
            return null === t.getAttribute("value") ? "on" : t.value
        })
    });
    var le = /^(?:focusinfocus|focusoutblur)$/;
    rt.extend(rt.event, {
        trigger: function (e, i, n, s) {
            var r, o, a, l, c, u, h, d = [n || Y], p = it.call(e, "type") ? e.type : e,
                f = it.call(e, "namespace") ? e.namespace.split(".") : [];
            if (o = a = n = n || Y, 3 !== n.nodeType && 8 !== n.nodeType && !le.test(p + rt.event.triggered) && (p.indexOf(".") > -1 && (f = p.split("."), p = f.shift(), f.sort()), c = p.indexOf(":") < 0 && "on" + p, e = e[rt.expando] ? e : new rt.Event(p, "object" == typeof e && e), e.isTrigger = s ? 2 : 3, e.namespace = f.join("."), e.rnamespace = e.namespace ? new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = void 0, e.target || (e.target = n), i = null == i ? [e] : rt.makeArray(i, [e]), h = rt.event.special[p] || {}, s || !h.trigger || !1 !== h.trigger.apply(n, i))) {
                if (!s && !h.noBubble && !rt.isWindow(n)) {
                    for (l = h.delegateType || p, le.test(l + p) || (o = o.parentNode); o; o = o.parentNode) d.push(o), a = o;
                    a === (n.ownerDocument || Y) && d.push(a.defaultView || a.parentWindow || t)
                }
                for (r = 0; (o = d[r++]) && !e.isPropagationStopped();) e.type = r > 1 ? l : h.bindType || p, u = (xt.get(o, "events") || {})[e.type] && xt.get(o, "handle"), u && u.apply(o, i), (u = c && o[c]) && u.apply && wt(o) && (e.result = u.apply(o, i), !1 === e.result && e.preventDefault());
                return e.type = p, s || e.isDefaultPrevented() || h._default && !1 !== h._default.apply(d.pop(), i) || !wt(n) || c && rt.isFunction(n[p]) && !rt.isWindow(n) && (a = n[c], a && (n[c] = null), rt.event.triggered = p, n[p](), rt.event.triggered = void 0, a && (n[c] = a)), e.result
            }
        }, simulate: function (t, e, i) {
            var n = rt.extend(new rt.Event, i, {type: t, isSimulated: !0});
            rt.event.trigger(n, null, e), n.isDefaultPrevented() && i.preventDefault()
        }
    }), rt.fn.extend({
        trigger: function (t, e) {
            return this.each(function () {
                rt.event.trigger(t, e, this)
            })
        }, triggerHandler: function (t, e) {
            var i = this[0];
            return i ? rt.event.trigger(t, e, i, !0) : void 0
        }
    }), rt.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (t, e) {
        rt.fn[e] = function (t, i) {
            return arguments.length > 0 ? this.on(e, null, t, i) : this.trigger(e)
        }
    }), rt.fn.extend({
        hover: function (t, e) {
            return this.mouseenter(t).mouseleave(e || t)
        }
    }), nt.focusin = "onfocusin" in t, nt.focusin || rt.each({focus: "focusin", blur: "focusout"}, function (t, e) {
        var i = function (t) {
            rt.event.simulate(e, t.target, rt.event.fix(t))
        };
        rt.event.special[e] = {
            setup: function () {
                var n = this.ownerDocument || this, s = xt.access(n, e);
                s || n.addEventListener(t, i, !0), xt.access(n, e, (s || 0) + 1)
            }, teardown: function () {
                var n = this.ownerDocument || this, s = xt.access(n, e) - 1;
                s ? xt.access(n, e, s) : (n.removeEventListener(t, i, !0), xt.remove(n, e))
            }
        }
    });
    var ce = t.location, ue = rt.now(), he = /\?/;
    rt.parseJSON = function (t) {
        return JSON.parse(t + "")
    }, rt.parseXML = function (e) {
        var i;
        if (!e || "string" != typeof e) return null;
        try {
            i = (new t.DOMParser).parseFromString(e, "text/xml")
        } catch (t) {
            i = void 0
        }
        return i && !i.getElementsByTagName("parsererror").length || rt.error("Invalid XML: " + e), i
    };
    var de = /([?&])_=[^&]*/, pe = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        fe = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/, ge = /^(?:GET|HEAD)$/, me = {}, ve = {},
        be = "*/".concat("*"), ye = Y.createElement("a");
    ye.href = ce.href, rt.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: ce.href,
            type: "GET",
            isLocal: fe.test(ce.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": be,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {xml: /\bxml\b/, html: /\bhtml/, json: /\bjson\b/},
            responseFields: {xml: "responseXML", text: "responseText", json: "responseJSON"},
            converters: {"* text": String, "text html": !0, "text json": rt.parseJSON, "text xml": rt.parseXML},
            flatOptions: {url: !0, context: !0}
        },
        ajaxSetup: function (t, e) {
            return e ? B(B(t, rt.ajaxSettings), e) : B(rt.ajaxSettings, t)
        },
        ajaxPrefilter: z(me),
        ajaxTransport: z(ve),
        ajax: function (e, i) {
            function n(e, i, n, a) {
                var c, h, b, y, x, A = i;
                2 !== w && (w = 2, l && t.clearTimeout(l), s = void 0, o = a || "", _.readyState = e > 0 ? 4 : 0, c = e >= 200 && 300 > e || 304 === e, n && (y = U(d, _, n)), y = W(d, y, _, c), c ? (d.ifModified && (x = _.getResponseHeader("Last-Modified"), x && (rt.lastModified[r] = x), (x = _.getResponseHeader("etag")) && (rt.etag[r] = x)), 204 === e || "HEAD" === d.type ? A = "nocontent" : 304 === e ? A = "notmodified" : (A = y.state, h = y.data, b = y.error, c = !b)) : (b = A, !e && A || (A = "error", 0 > e && (e = 0))), _.status = e, _.statusText = (i || A) + "", c ? g.resolveWith(p, [h, A, _]) : g.rejectWith(p, [_, A, b]), _.statusCode(v), v = void 0, u && f.trigger(c ? "ajaxSuccess" : "ajaxError", [_, d, c ? h : b]), m.fireWith(p, [_, A]), u && (f.trigger("ajaxComplete", [_, d]), --rt.active || rt.event.trigger("ajaxStop")))
            }

            "object" == typeof e && (i = e, e = void 0), i = i || {};
            var s, r, o, a, l, c, u, h, d = rt.ajaxSetup({}, i), p = d.context || d,
                f = d.context && (p.nodeType || p.jquery) ? rt(p) : rt.event, g = rt.Deferred(),
                m = rt.Callbacks("once memory"), v = d.statusCode || {}, b = {}, y = {}, w = 0, x = "canceled", _ = {
                    readyState: 0, getResponseHeader: function (t) {
                        var e;
                        if (2 === w) {
                            if (!a) for (a = {}; e = pe.exec(o);) a[e[1].toLowerCase()] = e[2];
                            e = a[t.toLowerCase()]
                        }
                        return null == e ? null : e
                    }, getAllResponseHeaders: function () {
                        return 2 === w ? o : null
                    }, setRequestHeader: function (t, e) {
                        var i = t.toLowerCase();
                        return w || (t = y[i] = y[i] || t, b[t] = e), this
                    }, overrideMimeType: function (t) {
                        return w || (d.mimeType = t), this
                    }, statusCode: function (t) {
                        var e;
                        if (t) if (2 > w) for (e in t) v[e] = [v[e], t[e]]; else _.always(t[_.status]);
                        return this
                    }, abort: function (t) {
                        var e = t || x;
                        return s && s.abort(e), n(0, e), this
                    }
                };
            if (g.promise(_).complete = m.add, _.success = _.done, _.error = _.fail, d.url = ((e || d.url || ce.href) + "").replace(/#.*$/, "").replace(/^\/\//, ce.protocol + "//"), d.type = i.method || i.type || d.method || d.type, d.dataTypes = rt.trim(d.dataType || "*").toLowerCase().match(vt) || [""], null == d.crossDomain) {
                c = Y.createElement("a");
                try {
                    c.href = d.url, c.href = c.href, d.crossDomain = ye.protocol + "//" + ye.host != c.protocol + "//" + c.host
                } catch (t) {
                    d.crossDomain = !0
                }
            }
            if (d.data && d.processData && "string" != typeof d.data && (d.data = rt.param(d.data, d.traditional)), j(me, d, i, _), 2 === w) return _;
            u = rt.event && d.global, u && 0 == rt.active++ && rt.event.trigger("ajaxStart"), d.type = d.type.toUpperCase(), d.hasContent = !ge.test(d.type), r = d.url, d.hasContent || (d.data && (r = d.url += (he.test(r) ? "&" : "?") + d.data, delete d.data), !1 === d.cache && (d.url = de.test(r) ? r.replace(de, "$1_=" + ue++) : r + (he.test(r) ? "&" : "?") + "_=" + ue++)), d.ifModified && (rt.lastModified[r] && _.setRequestHeader("If-Modified-Since", rt.lastModified[r]), rt.etag[r] && _.setRequestHeader("If-None-Match", rt.etag[r])), (d.data && d.hasContent && !1 !== d.contentType || i.contentType) && _.setRequestHeader("Content-Type", d.contentType), _.setRequestHeader("Accept", d.dataTypes[0] && d.accepts[d.dataTypes[0]] ? d.accepts[d.dataTypes[0]] + ("*" !== d.dataTypes[0] ? ", " + be + "; q=0.01" : "") : d.accepts["*"]);
            for (h in d.headers) _.setRequestHeader(h, d.headers[h]);
            if (d.beforeSend && (!1 === d.beforeSend.call(p, _, d) || 2 === w)) return _.abort();
            x = "abort";
            for (h in{success: 1, error: 1, complete: 1}) _[h](d[h]);
            if (s = j(ve, d, i, _)) {
                if (_.readyState = 1, u && f.trigger("ajaxSend", [_, d]), 2 === w) return _;
                d.async && d.timeout > 0 && (l = t.setTimeout(function () {
                    _.abort("timeout")
                }, d.timeout));
                try {
                    w = 1, s.send(b, n)
                } catch (t) {
                    if (!(2 > w)) throw t;
                    n(-1, t)
                }
            } else n(-1, "No Transport");
            return _
        },
        getJSON: function (t, e, i) {
            return rt.get(t, e, i, "json")
        },
        getScript: function (t, e) {
            return rt.get(t, void 0, e, "script")
        }
    }), rt.each(["get", "post"], function (t, e) {
        rt[e] = function (t, i, n, s) {
            return rt.isFunction(i) && (s = s || n, n = i, i = void 0), rt.ajax(rt.extend({
                url: t,
                type: e,
                dataType: s,
                data: i,
                success: n
            }, rt.isPlainObject(t) && t))
        }
    }), rt._evalUrl = function (t) {
        return rt.ajax({url: t, type: "GET", dataType: "script", async: !1, global: !1, throws: !0})
    }, rt.fn.extend({
        wrapAll: function (t) {
            var e;
            return rt.isFunction(t) ? this.each(function (e) {
                rt(this).wrapAll(t.call(this, e))
            }) : (this[0] && (e = rt(t, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && e.insertBefore(this[0]), e.map(function () {
                for (var t = this; t.firstElementChild;) t = t.firstElementChild;
                return t
            }).append(this)), this)
        }, wrapInner: function (t) {
            return rt.isFunction(t) ? this.each(function (e) {
                rt(this).wrapInner(t.call(this, e))
            }) : this.each(function () {
                var e = rt(this), i = e.contents();
                i.length ? i.wrapAll(t) : e.append(t)
            })
        }, wrap: function (t) {
            var e = rt.isFunction(t);
            return this.each(function (i) {
                rt(this).wrapAll(e ? t.call(this, i) : t)
            })
        }, unwrap: function () {
            return this.parent().each(function () {
                rt.nodeName(this, "body") || rt(this).replaceWith(this.childNodes)
            }).end()
        }
    }), rt.expr.filters.hidden = function (t) {
        return !rt.expr.filters.visible(t)
    }, rt.expr.filters.visible = function (t) {
        return t.offsetWidth > 0 || t.offsetHeight > 0 || t.getClientRects().length > 0
    };
    var we = /\[\]$/, xe = /^(?:submit|button|image|reset|file)$/i, _e = /^(?:input|select|textarea|keygen)/i;
    rt.param = function (t, e) {
        var i, n = [], s = function (t, e) {
            e = rt.isFunction(e) ? e() : null == e ? "" : e, n[n.length] = encodeURIComponent(t) + "=" + encodeURIComponent(e)
        };
        if (void 0 === e && (e = rt.ajaxSettings && rt.ajaxSettings.traditional), rt.isArray(t) || t.jquery && !rt.isPlainObject(t)) rt.each(t, function () {
            s(this.name, this.value)
        }); else for (i in t) q(i, t[i], e, s);
        return n.join("&").replace(/%20/g, "+")
    }, rt.fn.extend({
        serialize: function () {
            return rt.param(this.serializeArray())
        }, serializeArray: function () {
            return this.map(function () {
                var t = rt.prop(this, "elements");
                return t ? rt.makeArray(t) : this
            }).filter(function () {
                var t = this.type;
                return this.name && !rt(this).is(":disabled") && _e.test(this.nodeName) && !xe.test(t) && (this.checked || !$t.test(t))
            }).map(function (t, e) {
                var i = rt(this).val();
                return null == i ? null : rt.isArray(i) ? rt.map(i, function (t) {
                    return {name: e.name, value: t.replace(/\r?\n/g, "\r\n")}
                }) : {name: e.name, value: i.replace(/\r?\n/g, "\r\n")}
            }).get()
        }
    }), rt.ajaxSettings.xhr = function () {
        try {
            return new t.XMLHttpRequest
        } catch (t) {
        }
    };
    var Ae = {0: 200, 1223: 204}, Ce = rt.ajaxSettings.xhr();
    nt.cors = !!Ce && "withCredentials" in Ce, nt.ajax = Ce = !!Ce, rt.ajaxTransport(function (e) {
        var i, n;
        return nt.cors || Ce && !e.crossDomain ? {
            send: function (s, r) {
                var o, a = e.xhr();
                if (a.open(e.type, e.url, e.async, e.username, e.password), e.xhrFields) for (o in e.xhrFields) a[o] = e.xhrFields[o];
                e.mimeType && a.overrideMimeType && a.overrideMimeType(e.mimeType), e.crossDomain || s["X-Requested-With"] || (s["X-Requested-With"] = "XMLHttpRequest");
                for (o in s) a.setRequestHeader(o, s[o]);
                i = function (t) {
                    return function () {
                        i && (i = n = a.onload = a.onerror = a.onabort = a.onreadystatechange = null, "abort" === t ? a.abort() : "error" === t ? "number" != typeof a.status ? r(0, "error") : r(a.status, a.statusText) : r(Ae[a.status] || a.status, a.statusText, "text" !== (a.responseType || "text") || "string" != typeof a.responseText ? {binary: a.response} : {text: a.responseText}, a.getAllResponseHeaders()))
                    }
                }, a.onload = i(), n = a.onerror = i("error"), void 0 !== a.onabort ? a.onabort = n : a.onreadystatechange = function () {
                    4 === a.readyState && t.setTimeout(function () {
                        i && n()
                    })
                }, i = i("abort");
                try {
                    a.send(e.hasContent && e.data || null)
                } catch (t) {
                    if (i) throw t
                }
            }, abort: function () {
                i && i()
            }
        } : void 0
    }), rt.ajaxSetup({
        accepts: {script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},
        contents: {script: /\b(?:java|ecma)script\b/},
        converters: {
            "text script": function (t) {
                return rt.globalEval(t), t
            }
        }
    }), rt.ajaxPrefilter("script", function (t) {
        void 0 === t.cache && (t.cache = !1), t.crossDomain && (t.type = "GET")
    }), rt.ajaxTransport("script", function (t) {
        if (t.crossDomain) {
            var e, i;
            return {
                send: function (n, s) {
                    e = rt("<script>").prop({charset: t.scriptCharset, src: t.url}).on("load error", i = function (t) {
                        e.remove(), i = null, t && s("error" === t.type ? 404 : 200, t.type)
                    }), Y.head.appendChild(e[0])
                }, abort: function () {
                    i && i()
                }
            }
        }
    });
    var Te = [], Se = /(=)\?(?=&|$)|\?\?/;
    rt.ajaxSetup({
        jsonp: "callback", jsonpCallback: function () {
            var t = Te.pop() || rt.expando + "_" + ue++;
            return this[t] = !0, t
        }
    }), rt.ajaxPrefilter("json jsonp", function (e, i, n) {
        var s, r, o,
            a = !1 !== e.jsonp && (Se.test(e.url) ? "url" : "string" == typeof e.data && 0 === (e.contentType || "").indexOf("application/x-www-form-urlencoded") && Se.test(e.data) && "data");
        return a || "jsonp" === e.dataTypes[0] ? (s = e.jsonpCallback = rt.isFunction(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, a ? e[a] = e[a].replace(Se, "$1" + s) : !1 !== e.jsonp && (e.url += (he.test(e.url) ? "&" : "?") + e.jsonp + "=" + s), e.converters["script json"] = function () {
            return o || rt.error(s + " was not called"), o[0]
        }, e.dataTypes[0] = "json", r = t[s], t[s] = function () {
            o = arguments
        }, n.always(function () {
            void 0 === r ? rt(t).removeProp(s) : t[s] = r, e[s] && (e.jsonpCallback = i.jsonpCallback, Te.push(s)), o && rt.isFunction(r) && r(o[0]), o = r = void 0
        }), "script") : void 0
    }), rt.parseHTML = function (t, e, i) {
        if (!t || "string" != typeof t) return null;
        "boolean" == typeof e && (i = e, e = !1), e = e || Y;
        var n = ht.exec(t), s = !i && [];
        return n ? [e.createElement(n[1])] : (n = d([t], e, s), s && s.length && rt(s).remove(), rt.merge([], n.childNodes))
    };
    var Ie = rt.fn.load;
    rt.fn.load = function (t, e, i) {
        if ("string" != typeof t && Ie) return Ie.apply(this, arguments);
        var n, s, r, o = this, a = t.indexOf(" ");
        return a > -1 && (n = rt.trim(t.slice(a)), t = t.slice(0, a)), rt.isFunction(e) ? (i = e, e = void 0) : e && "object" == typeof e && (s = "POST"), o.length > 0 && rt.ajax({
            url: t,
            type: s || "GET",
            dataType: "html",
            data: e
        }).done(function (t) {
            r = arguments, o.html(n ? rt("<div>").append(rt.parseHTML(t)).find(n) : t)
        }).always(i && function (t, e) {
            o.each(function () {
                i.apply(this, r || [t.responseText, e, t])
            })
        }), this
    }, rt.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (t, e) {
        rt.fn[e] = function (t) {
            return this.on(e, t)
        }
    }), rt.expr.filters.animated = function (t) {
        return rt.grep(rt.timers, function (e) {
            return t === e.elem
        }).length
    }, rt.offset = {
        setOffset: function (t, e, i) {
            var n, s, r, o, a, l, c, u = rt.css(t, "position"), h = rt(t), d = {};
            "static" === u && (t.style.position = "relative"), a = h.offset(), r = rt.css(t, "top"), l = rt.css(t, "left"), c = ("absolute" === u || "fixed" === u) && (r + l).indexOf("auto") > -1, c ? (n = h.position(), o = n.top, s = n.left) : (o = parseFloat(r) || 0, s = parseFloat(l) || 0), rt.isFunction(e) && (e = e.call(t, i, rt.extend({}, a))), null != e.top && (d.top = e.top - a.top + o), null != e.left && (d.left = e.left - a.left + s), "using" in e ? e.using.call(t, d) : h.css(d)
        }
    }, rt.fn.extend({
        offset: function (t) {
            if (arguments.length) return void 0 === t ? this : this.each(function (e) {
                rt.offset.setOffset(this, t, e)
            });
            var e, i, n = this[0], s = {top: 0, left: 0}, r = n && n.ownerDocument;
            return r ? (e = r.documentElement, rt.contains(e, n) ? (s = n.getBoundingClientRect(), i = G(r), {
                top: s.top + i.pageYOffset - e.clientTop,
                left: s.left + i.pageXOffset - e.clientLeft
            }) : s) : void 0
        }, position: function () {
            if (this[0]) {
                var t, e, i = this[0], n = {top: 0, left: 0};
                return "fixed" === rt.css(i, "position") ? e = i.getBoundingClientRect() : (t = this.offsetParent(), e = this.offset(), rt.nodeName(t[0], "html") || (n = t.offset()), n.top += rt.css(t[0], "borderTopWidth", !0), n.left += rt.css(t[0], "borderLeftWidth", !0)), {
                    top: e.top - n.top - rt.css(i, "marginTop", !0),
                    left: e.left - n.left - rt.css(i, "marginLeft", !0)
                }
            }
        }, offsetParent: function () {
            return this.map(function () {
                for (var t = this.offsetParent; t && "static" === rt.css(t, "position");) t = t.offsetParent;
                return t || Gt
            })
        }
    }), rt.each({scrollLeft: "pageXOffset", scrollTop: "pageYOffset"}, function (t, e) {
        var i = "pageYOffset" === e;
        rt.fn[t] = function (n) {
            return yt(this, function (t, n, s) {
                var r = G(t);
                return void 0 === s ? r ? r[e] : t[n] : void(r ? r.scrollTo(i ? r.pageXOffset : s, i ? s : r.pageYOffset) : t[n] = s)
            }, t, n, arguments.length)
        }
    }), rt.each(["top", "left"], function (t, e) {
        rt.cssHooks[e] = I(nt.pixelPosition, function (t, i) {
            return i ? (i = S(t, e), Ut.test(i) ? rt(t).position()[e] + "px" : i) : void 0
        })
    }), rt.each({Height: "height", Width: "width"}, function (t, e) {
        rt.each({padding: "inner" + t, content: e, "": "outer" + t}, function (i, n) {
            rt.fn[n] = function (n, s) {
                var r = arguments.length && (i || "boolean" != typeof n),
                    o = i || (!0 === n || !0 === s ? "margin" : "border");
                return yt(this, function (e, i, n) {
                    var s;
                    return rt.isWindow(e) ? e.document.documentElement["client" + t] : 9 === e.nodeType ? (s = e.documentElement, Math.max(e.body["scroll" + t], s["scroll" + t], e.body["offset" + t], s["offset" + t], s["client" + t])) : void 0 === n ? rt.css(e, i, o) : rt.style(e, i, n, o)
                }, e, r ? n : void 0, r, null)
            }
        })
    }), rt.fn.extend({
        bind: function (t, e, i) {
            return this.on(t, null, e, i)
        }, unbind: function (t, e) {
            return this.off(t, null, e)
        }, delegate: function (t, e, i, n) {
            return this.on(e, t, i, n)
        }, undelegate: function (t, e, i) {
            return 1 === arguments.length ? this.off(t, "**") : this.off(e, t || "**", i)
        }, size: function () {
            return this.length
        }
    }), rt.fn.andSelf = rt.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function () {
        return rt
    });
    var Ee = t.jQuery, $e = t.$;
    return rt.noConflict = function (e) {
        return t.$ === rt && (t.$ = $e), e && t.jQuery === rt && (t.jQuery = Ee), rt
    }, e || (t.jQuery = t.$ = rt), rt
}), function (t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : t(jQuery)
}(function (t) {
    function e(t) {
        for (var e = t.css("visibility"); "inherit" === e;) t = t.parent(), e = t.css("visibility");
        return "hidden" !== e
    }

    t.ui = t.ui || {}, t.ui.version = "1.12.1";
    var i = 0, n = Array.prototype.slice;
    t.cleanData = function (e) {
        return function (i) {
            var n, s, r;
            for (r = 0; null != (s = i[r]); r++) try {
                (n = t._data(s, "events")) && n.remove && t(s).triggerHandler("remove")
            } catch (t) {
            }
            e(i)
        }
    }(t.cleanData), t.widget = function (e, i, n) {
        var s, r, o, a = {}, l = e.split(".")[0];
        e = e.split(".")[1];
        var c = l + "-" + e;
        return n || (n = i, i = t.Widget), t.isArray(n) && (n = t.extend.apply(null, [{}].concat(n))), t.expr[":"][c.toLowerCase()] = function (e) {
            return !!t.data(e, c)
        }, t[l] = t[l] || {}, s = t[l][e], r = t[l][e] = function (t, e) {
            return this._createWidget ? void(arguments.length && this._createWidget(t, e)) : new r(t, e)
        }, t.extend(r, s, {
            version: n.version,
            _proto: t.extend({}, n),
            _childConstructors: []
        }), o = new i, o.options = t.widget.extend({}, o.options), t.each(n, function (e, n) {
            return t.isFunction(n) ? void(a[e] = function () {
                function t() {
                    return i.prototype[e].apply(this, arguments)
                }

                function s(t) {
                    return i.prototype[e].apply(this, t)
                }

                return function () {
                    var e, i = this._super, r = this._superApply;
                    return this._super = t, this._superApply = s, e = n.apply(this, arguments), this._super = i, this._superApply = r, e
                }
            }()) : void(a[e] = n)
        }), r.prototype = t.widget.extend(o, {widgetEventPrefix: s ? o.widgetEventPrefix || e : e}, a, {
            constructor: r,
            namespace: l,
            widgetName: e,
            widgetFullName: c
        }), s ? (t.each(s._childConstructors, function (e, i) {
            var n = i.prototype;
            t.widget(n.namespace + "." + n.widgetName, r, i._proto)
        }), delete s._childConstructors) : i._childConstructors.push(r), t.widget.bridge(e, r), r
    }, t.widget.extend = function (e) {
        for (var i, s, r = n.call(arguments, 1), o = 0, a = r.length; a > o; o++) for (i in r[o]) s = r[o][i], r[o].hasOwnProperty(i) && void 0 !== s && (e[i] = t.isPlainObject(s) ? t.isPlainObject(e[i]) ? t.widget.extend({}, e[i], s) : t.widget.extend({}, s) : s);
        return e
    }, t.widget.bridge = function (e, i) {
        var s = i.prototype.widgetFullName || e;
        t.fn[e] = function (r) {
            var o = "string" == typeof r, a = n.call(arguments, 1), l = this;
            return o ? this.length || "instance" !== r ? this.each(function () {
                var i, n = t.data(this, s);
                return "instance" === r ? (l = n, !1) : n ? t.isFunction(n[r]) && "_" !== r.charAt(0) ? (i = n[r].apply(n, a), i !== n && void 0 !== i ? (l = i && i.jquery ? l.pushStack(i.get()) : i, !1) : void 0) : t.error("no such method '" + r + "' for " + e + " widget instance") : t.error("cannot call methods on " + e + " prior to initialization; attempted to call method '" + r + "'")
            }) : l = void 0 : (a.length && (r = t.widget.extend.apply(null, [r].concat(a))), this.each(function () {
                var e = t.data(this, s);
                e ? (e.option(r || {}), e._init && e._init()) : t.data(this, s, new i(r, this))
            })), l
        }
    }, t.Widget = function () {
    }, t.Widget._childConstructors = [], t.Widget.prototype = {
        widgetName: "widget",
        widgetEventPrefix: "",
        defaultElement: "<div>",
        options: {classes: {}, disabled: !1, create: null},
        _createWidget: function (e, n) {
            n = t(n || this.defaultElement || this)[0], this.element = t(n), this.uuid = i++, this.eventNamespace = "." + this.widgetName + this.uuid, this.bindings = t(), this.hoverable = t(), this.focusable = t(), this.classesElementLookup = {}, n !== this && (t.data(n, this.widgetFullName, this), this._on(!0, this.element, {
                remove: function (t) {
                    t.target === n && this.destroy()
                }
            }), this.document = t(n.style ? n.ownerDocument : n.document || n), this.window = t(this.document[0].defaultView || this.document[0].parentWindow)), this.options = t.widget.extend({}, this.options, this._getCreateOptions(), e), this._create(), this.options.disabled && this._setOptionDisabled(this.options.disabled), this._trigger("create", null, this._getCreateEventData()), this._init()
        },
        _getCreateOptions: function () {
            return {}
        },
        _getCreateEventData: t.noop,
        _create: t.noop,
        _init: t.noop,
        destroy: function () {
            var e = this;
            this._destroy(), t.each(this.classesElementLookup, function (t, i) {
                e._removeClass(i, t)
            }), this.element.off(this.eventNamespace).removeData(this.widgetFullName), this.widget().off(this.eventNamespace).removeAttr("aria-disabled"), this.bindings.off(this.eventNamespace)
        },
        _destroy: t.noop,
        widget: function () {
            return this.element
        },
        option: function (e, i) {
            var n, s, r, o = e;
            if (0 === arguments.length) return t.widget.extend({}, this.options);
            if ("string" == typeof e) if (o = {}, n = e.split("."), e = n.shift(), n.length) {
                for (s = o[e] = t.widget.extend({}, this.options[e]), r = 0; n.length - 1 > r; r++) s[n[r]] = s[n[r]] || {}, s = s[n[r]];
                if (e = n.pop(), 1 === arguments.length) return void 0 === s[e] ? null : s[e];
                s[e] = i
            } else {
                if (1 === arguments.length) return void 0 === this.options[e] ? null : this.options[e];
                o[e] = i
            }
            return this._setOptions(o), this
        },
        _setOptions: function (t) {
            var e;
            for (e in t) this._setOption(e, t[e]);
            return this
        },
        _setOption: function (t, e) {
            return "classes" === t && this._setOptionClasses(e), this.options[t] = e, "disabled" === t && this._setOptionDisabled(e), this
        },
        _setOptionClasses: function (e) {
            var i, n, s;
            for (i in e) s = this.classesElementLookup[i], e[i] !== this.options.classes[i] && s && s.length && (n = t(s.get()), this._removeClass(s, i), n.addClass(this._classes({
                element: n,
                keys: i,
                classes: e,
                add: !0
            })))
        },
        _setOptionDisabled: function (t) {
            this._toggleClass(this.widget(), this.widgetFullName + "-disabled", null, !!t), t && (this._removeClass(this.hoverable, null, "ui-state-hover"), this._removeClass(this.focusable, null, "ui-state-focus"))
        },
        enable: function () {
            return this._setOptions({disabled: !1})
        },
        disable: function () {
            return this._setOptions({disabled: !0})
        },
        _classes: function (e) {
            function i(i, r) {
                var o, a;
                for (a = 0; i.length > a; a++) o = s.classesElementLookup[i[a]] || t(), o = t(e.add ? t.unique(o.get().concat(e.element.get())) : o.not(e.element).get()), s.classesElementLookup[i[a]] = o, n.push(i[a]), r && e.classes[i[a]] && n.push(e.classes[i[a]])
            }

            var n = [], s = this;
            return e = t.extend({
                element: this.element,
                classes: this.options.classes || {}
            }, e), this._on(e.element, {remove: "_untrackClassesElement"}), e.keys && i(e.keys.match(/\S+/g) || [], !0), e.extra && i(e.extra.match(/\S+/g) || []), n.join(" ")
        },
        _untrackClassesElement: function (e) {
            var i = this;
            t.each(i.classesElementLookup, function (n, s) {
                -1 !== t.inArray(e.target, s) && (i.classesElementLookup[n] = t(s.not(e.target).get()))
            })
        },
        _removeClass: function (t, e, i) {
            return this._toggleClass(t, e, i, !1)
        },
        _addClass: function (t, e, i) {
            return this._toggleClass(t, e, i, !0)
        },
        _toggleClass: function (t, e, i, n) {
            n = "boolean" == typeof n ? n : i;
            var s = "string" == typeof t || null === t,
                r = {extra: s ? e : i, keys: s ? t : e, element: s ? this.element : t, add: n};
            return r.element.toggleClass(this._classes(r), n), this
        },
        _on: function (e, i, n) {
            var s, r = this;
            "boolean" != typeof e && (n = i, i = e, e = !1), n ? (i = s = t(i), this.bindings = this.bindings.add(i)) : (n = i, i = this.element, s = this.widget()), t.each(n, function (n, o) {
                function a() {
                    return e || !0 !== r.options.disabled && !t(this).hasClass("ui-state-disabled") ? ("string" == typeof o ? r[o] : o).apply(r, arguments) : void 0
                }

                "string" != typeof o && (a.guid = o.guid = o.guid || a.guid || t.guid++);
                var l = n.match(/^([\w:-]*)\s*(.*)$/), c = l[1] + r.eventNamespace, u = l[2];
                u ? s.on(c, u, a) : i.on(c, a)
            })
        },
        _off: function (e, i) {
            i = (i || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace, e.off(i).off(i), this.bindings = t(this.bindings.not(e).get()), this.focusable = t(this.focusable.not(e).get()), this.hoverable = t(this.hoverable.not(e).get())
        },
        _delay: function (t, e) {
            function i() {
                return ("string" == typeof t ? n[t] : t).apply(n, arguments)
            }

            var n = this;
            return setTimeout(i, e || 0)
        },
        _hoverable: function (e) {
            this.hoverable = this.hoverable.add(e), this._on(e, {
                mouseenter: function (e) {
                    this._addClass(t(e.currentTarget), null, "ui-state-hover")
                }, mouseleave: function (e) {
                    this._removeClass(t(e.currentTarget), null, "ui-state-hover")
                }
            })
        },
        _focusable: function (e) {
            this.focusable = this.focusable.add(e), this._on(e, {
                focusin: function (e) {
                    this._addClass(t(e.currentTarget), null, "ui-state-focus")
                }, focusout: function (e) {
                    this._removeClass(t(e.currentTarget), null, "ui-state-focus")
                }
            })
        },
        _trigger: function (e, i, n) {
            var s, r, o = this.options[e];
            if (n = n || {}, i = t.Event(i), i.type = (e === this.widgetEventPrefix ? e : this.widgetEventPrefix + e).toLowerCase(), i.target = this.element[0], r = i.originalEvent) for (s in r) s in i || (i[s] = r[s]);
            return this.element.trigger(i, n), !(t.isFunction(o) && !1 === o.apply(this.element[0], [i].concat(n)) || i.isDefaultPrevented())
        }
    }, t.each({show: "fadeIn", hide: "fadeOut"}, function (e, i) {
        t.Widget.prototype["_" + e] = function (n, s, r) {
            "string" == typeof s && (s = {effect: s});
            var o, a = s ? !0 === s || "number" == typeof s ? i : s.effect || i : e;
            s = s || {}, "number" == typeof s && (s = {duration: s}), o = !t.isEmptyObject(s), s.complete = r, s.delay && n.delay(s.delay), o && t.effects && t.effects.effect[a] ? n[e](s) : a !== e && n[a] ? n[a](s.duration, s.easing, r) : n.queue(function (i) {
                t(this)[e](), r && r.call(n[0]), i()
            })
        }
    }), t.widget, function () {
        function e(t, e, i) {
            return [parseFloat(t[0]) * (h.test(t[0]) ? e / 100 : 1), parseFloat(t[1]) * (h.test(t[1]) ? i / 100 : 1)]
        }

        function i(e, i) {
            return parseInt(t.css(e, i), 10) || 0
        }

        function n(e) {
            var i = e[0];
            return 9 === i.nodeType ? {
                width: e.width(),
                height: e.height(),
                offset: {top: 0, left: 0}
            } : t.isWindow(i) ? {
                width: e.width(),
                height: e.height(),
                offset: {top: e.scrollTop(), left: e.scrollLeft()}
            } : i.preventDefault ? {
                width: 0,
                height: 0,
                offset: {top: i.pageY, left: i.pageX}
            } : {width: e.outerWidth(), height: e.outerHeight(), offset: e.offset()}
        }

        var s, r = Math.max, o = Math.abs, a = /left|center|right/, l = /top|center|bottom/,
            c = /[\+\-]\d+(\.[\d]+)?%?/, u = /^\w+/, h = /%$/, d = t.fn.position;
        t.position = {
            scrollbarWidth: function () {
                if (void 0 !== s) return s;
                var e, i,
                    n = t("<div style='display:block;position:absolute;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>"),
                    r = n.children()[0];
                return t("body").append(n), e = r.offsetWidth, n.css("overflow", "scroll"), i = r.offsetWidth, e === i && (i = n[0].clientWidth), n.remove(), s = e - i
            }, getScrollInfo: function (e) {
                var i = e.isWindow || e.isDocument ? "" : e.element.css("overflow-x"),
                    n = e.isWindow || e.isDocument ? "" : e.element.css("overflow-y"),
                    s = "scroll" === i || "auto" === i && e.width < e.element[0].scrollWidth;
                return {
                    width: "scroll" === n || "auto" === n && e.height < e.element[0].scrollHeight ? t.position.scrollbarWidth() : 0,
                    height: s ? t.position.scrollbarWidth() : 0
                }
            }, getWithinInfo: function (e) {
                var i = t(e || window), n = t.isWindow(i[0]), s = !!i[0] && 9 === i[0].nodeType;
                return {
                    element: i,
                    isWindow: n,
                    isDocument: s,
                    offset: n || s ? {left: 0, top: 0} : t(e).offset(),
                    scrollLeft: i.scrollLeft(),
                    scrollTop: i.scrollTop(),
                    width: i.outerWidth(),
                    height: i.outerHeight()
                }
            }
        }, t.fn.position = function (s) {
            if (!s || !s.of) return d.apply(this, arguments);
            s = t.extend({}, s)
            ;var h, p, f, g, m, v, b = t(s.of), y = t.position.getWithinInfo(s.within), w = t.position.getScrollInfo(y),
                x = (s.collision || "flip").split(" "), _ = {};
            return v = n(b), b[0].preventDefault && (s.at = "left top"), p = v.width, f = v.height, g = v.offset, m = t.extend({}, g), t.each(["my", "at"], function () {
                var t, e, i = (s[this] || "").split(" ");
                1 === i.length && (i = a.test(i[0]) ? i.concat(["center"]) : l.test(i[0]) ? ["center"].concat(i) : ["center", "center"]), i[0] = a.test(i[0]) ? i[0] : "center", i[1] = l.test(i[1]) ? i[1] : "center", t = c.exec(i[0]), e = c.exec(i[1]), _[this] = [t ? t[0] : 0, e ? e[0] : 0], s[this] = [u.exec(i[0])[0], u.exec(i[1])[0]]
            }), 1 === x.length && (x[1] = x[0]), "right" === s.at[0] ? m.left += p : "center" === s.at[0] && (m.left += p / 2), "bottom" === s.at[1] ? m.top += f : "center" === s.at[1] && (m.top += f / 2), h = e(_.at, p, f), m.left += h[0], m.top += h[1], this.each(function () {
                var n, a, l = t(this), c = l.outerWidth(), u = l.outerHeight(), d = i(this, "marginLeft"),
                    v = i(this, "marginTop"), A = c + d + i(this, "marginRight") + w.width,
                    C = u + v + i(this, "marginBottom") + w.height, T = t.extend({}, m),
                    S = e(_.my, l.outerWidth(), l.outerHeight());
                "right" === s.my[0] ? T.left -= c : "center" === s.my[0] && (T.left -= c / 2), "bottom" === s.my[1] ? T.top -= u : "center" === s.my[1] && (T.top -= u / 2), T.left += S[0], T.top += S[1], n = {
                    marginLeft: d,
                    marginTop: v
                }, t.each(["left", "top"], function (e, i) {
                    t.ui.position[x[e]] && t.ui.position[x[e]][i](T, {
                        targetWidth: p,
                        targetHeight: f,
                        elemWidth: c,
                        elemHeight: u,
                        collisionPosition: n,
                        collisionWidth: A,
                        collisionHeight: C,
                        offset: [h[0] + S[0], h[1] + S[1]],
                        my: s.my,
                        at: s.at,
                        within: y,
                        elem: l
                    })
                }), s.using && (a = function (t) {
                    var e = g.left - T.left, i = e + p - c, n = g.top - T.top, a = n + f - u, h = {
                        target: {element: b, left: g.left, top: g.top, width: p, height: f},
                        element: {element: l, left: T.left, top: T.top, width: c, height: u},
                        horizontal: 0 > i ? "left" : e > 0 ? "right" : "center",
                        vertical: 0 > a ? "top" : n > 0 ? "bottom" : "middle"
                    };
                    c > p && p > o(e + i) && (h.horizontal = "center"), u > f && f > o(n + a) && (h.vertical = "middle"), h.important = r(o(e), o(i)) > r(o(n), o(a)) ? "horizontal" : "vertical", s.using.call(this, t, h)
                }), l.offset(t.extend(T, {using: a}))
            })
        }, t.ui.position = {
            fit: {
                left: function (t, e) {
                    var i, n = e.within, s = n.isWindow ? n.scrollLeft : n.offset.left, o = n.width,
                        a = t.left - e.collisionPosition.marginLeft, l = s - a, c = a + e.collisionWidth - o - s;
                    e.collisionWidth > o ? l > 0 && 0 >= c ? (i = t.left + l + e.collisionWidth - o - s, t.left += l - i) : t.left = c > 0 && 0 >= l ? s : l > c ? s + o - e.collisionWidth : s : l > 0 ? t.left += l : c > 0 ? t.left -= c : t.left = r(t.left - a, t.left)
                }, top: function (t, e) {
                    var i, n = e.within, s = n.isWindow ? n.scrollTop : n.offset.top, o = e.within.height,
                        a = t.top - e.collisionPosition.marginTop, l = s - a, c = a + e.collisionHeight - o - s;
                    e.collisionHeight > o ? l > 0 && 0 >= c ? (i = t.top + l + e.collisionHeight - o - s, t.top += l - i) : t.top = c > 0 && 0 >= l ? s : l > c ? s + o - e.collisionHeight : s : l > 0 ? t.top += l : c > 0 ? t.top -= c : t.top = r(t.top - a, t.top)
                }
            }, flip: {
                left: function (t, e) {
                    var i, n, s = e.within, r = s.offset.left + s.scrollLeft, a = s.width,
                        l = s.isWindow ? s.scrollLeft : s.offset.left, c = t.left - e.collisionPosition.marginLeft,
                        u = c - l, h = c + e.collisionWidth - a - l,
                        d = "left" === e.my[0] ? -e.elemWidth : "right" === e.my[0] ? e.elemWidth : 0,
                        p = "left" === e.at[0] ? e.targetWidth : "right" === e.at[0] ? -e.targetWidth : 0,
                        f = -2 * e.offset[0];
                    0 > u ? (0 > (i = t.left + d + p + f + e.collisionWidth - a - r) || o(u) > i) && (t.left += d + p + f) : h > 0 && ((n = t.left - e.collisionPosition.marginLeft + d + p + f - l) > 0 || h > o(n)) && (t.left += d + p + f)
                }, top: function (t, e) {
                    var i, n, s = e.within, r = s.offset.top + s.scrollTop, a = s.height,
                        l = s.isWindow ? s.scrollTop : s.offset.top, c = t.top - e.collisionPosition.marginTop,
                        u = c - l, h = c + e.collisionHeight - a - l, d = "top" === e.my[1],
                        p = d ? -e.elemHeight : "bottom" === e.my[1] ? e.elemHeight : 0,
                        f = "top" === e.at[1] ? e.targetHeight : "bottom" === e.at[1] ? -e.targetHeight : 0,
                        g = -2 * e.offset[1];
                    0 > u ? (0 > (n = t.top + p + f + g + e.collisionHeight - a - r) || o(u) > n) && (t.top += p + f + g) : h > 0 && ((i = t.top - e.collisionPosition.marginTop + p + f + g - l) > 0 || h > o(i)) && (t.top += p + f + g)
                }
            }, flipfit: {
                left: function () {
                    t.ui.position.flip.left.apply(this, arguments), t.ui.position.fit.left.apply(this, arguments)
                }, top: function () {
                    t.ui.position.flip.top.apply(this, arguments), t.ui.position.fit.top.apply(this, arguments)
                }
            }
        }
    }(), t.ui.position, t.extend(t.expr[":"], {
        data: t.expr.createPseudo ? t.expr.createPseudo(function (e) {
            return function (i) {
                return !!t.data(i, e)
            }
        }) : function (e, i, n) {
            return !!t.data(e, n[3])
        }
    }), t.fn.extend({
        disableSelection: function () {
            var t = "onselectstart" in document.createElement("div") ? "selectstart" : "mousedown";
            return function () {
                return this.on(t + ".ui-disableSelection", function (t) {
                    t.preventDefault()
                })
            }
        }(), enableSelection: function () {
            return this.off(".ui-disableSelection")
        }
    }), t.ui.focusable = function (i, n) {
        var s, r, o, a, l, c = i.nodeName.toLowerCase();
        return "area" === c ? (s = i.parentNode, r = s.name, !(!i.href || !r || "map" !== s.nodeName.toLowerCase()) && (o = t("img[usemap='#" + r + "']"), o.length > 0 && o.is(":visible"))) : (/^(input|select|textarea|button|object)$/.test(c) ? (a = !i.disabled) && (l = t(i).closest("fieldset")[0]) && (a = !l.disabled) : a = "a" === c ? i.href || n : n, a && t(i).is(":visible") && e(t(i)))
    }, t.extend(t.expr[":"], {
        focusable: function (e) {
            return t.ui.focusable(e, null != t.attr(e, "tabindex"))
        }
    }), t.ui.focusable, t.fn.form = function () {
        return "string" == typeof this[0].form ? this.closest("form") : t(this[0].form)
    }, t.ui.formResetMixin = {
        _formResetHandler: function () {
            var e = t(this);
            setTimeout(function () {
                var i = e.data("ui-form-reset-instances");
                t.each(i, function () {
                    this.refresh()
                })
            })
        }, _bindFormResetHandler: function () {
            if (this.form = this.element.form(), this.form.length) {
                var t = this.form.data("ui-form-reset-instances") || [];
                t.length || this.form.on("reset.ui-form-reset", this._formResetHandler), t.push(this), this.form.data("ui-form-reset-instances", t)
            }
        }, _unbindFormResetHandler: function () {
            if (this.form.length) {
                var e = this.form.data("ui-form-reset-instances");
                e.splice(t.inArray(this, e), 1), e.length ? this.form.data("ui-form-reset-instances", e) : this.form.removeData("ui-form-reset-instances").off("reset.ui-form-reset")
            }
        }
    }, "1.7" === t.fn.jquery.substring(0, 3) && (t.each(["Width", "Height"], function (e, i) {
        function n(e, i, n, r) {
            return t.each(s, function () {
                i -= parseFloat(t.css(e, "padding" + this)) || 0, n && (i -= parseFloat(t.css(e, "border" + this + "Width")) || 0), r && (i -= parseFloat(t.css(e, "margin" + this)) || 0)
            }), i
        }

        var s = "Width" === i ? ["Left", "Right"] : ["Top", "Bottom"], r = i.toLowerCase(), o = {
            innerWidth: t.fn.innerWidth,
            innerHeight: t.fn.innerHeight,
            outerWidth: t.fn.outerWidth,
            outerHeight: t.fn.outerHeight
        };
        t.fn["inner" + i] = function (e) {
            return void 0 === e ? o["inner" + i].call(this) : this.each(function () {
                t(this).css(r, n(this, e) + "px")
            })
        }, t.fn["outer" + i] = function (e, s) {
            return "number" != typeof e ? o["outer" + i].call(this, e) : this.each(function () {
                t(this).css(r, n(this, e, !0, s) + "px")
            })
        }
    }), t.fn.addBack = function (t) {
        return this.add(null == t ? this.prevObject : this.prevObject.filter(t))
    }), t.ui.keyCode = {
        BACKSPACE: 8,
        COMMA: 188,
        DELETE: 46,
        DOWN: 40,
        END: 35,
        ENTER: 13,
        ESCAPE: 27,
        HOME: 36,
        LEFT: 37,
        PAGE_DOWN: 34,
        PAGE_UP: 33,
        PERIOD: 190,
        RIGHT: 39,
        SPACE: 32,
        TAB: 9,
        UP: 38
    }, t.ui.escapeSelector = function () {
        return function (t) {
            return t.replace(/([!"#$%&'()*+,.\/:;<=>?@[\]^`{|}~])/g, "\\$1")
        }
    }(), t.fn.labels = function () {
        var e, i, n, s, r;
        return this[0].labels && this[0].labels.length ? this.pushStack(this[0].labels) : (s = this.eq(0).parents("label"), n = this.attr("id"), n && (e = this.eq(0).parents().last(), r = e.add(e.length ? e.siblings() : this.siblings()), i = "label[for='" + t.ui.escapeSelector(n) + "']", s = s.add(r.find(i).addBack(i))), this.pushStack(s))
    }, t.fn.scrollParent = function (e) {
        var i = this.css("position"), n = "absolute" === i, s = e ? /(auto|scroll|hidden)/ : /(auto|scroll)/,
            r = this.parents().filter(function () {
                var e = t(this);
                return (!n || "static" !== e.css("position")) && s.test(e.css("overflow") + e.css("overflow-y") + e.css("overflow-x"))
            }).eq(0);
        return "fixed" !== i && r.length ? r : t(this[0].ownerDocument || document)
    }, t.extend(t.expr[":"], {
        tabbable: function (e) {
            var i = t.attr(e, "tabindex"), n = null != i;
            return (!n || i >= 0) && t.ui.focusable(e, n)
        }
    }), t.fn.extend({
        uniqueId: function () {
            var t = 0;
            return function () {
                return this.each(function () {
                    this.id || (this.id = "ui-id-" + ++t)
                })
            }
        }(), removeUniqueId: function () {
            return this.each(function () {
                /^ui-id-\d+$/.test(this.id) && t(this).removeAttr("id")
            })
        }
    }), t.ui.ie = !!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase());
    var s = !1;
    t(document).on("mouseup", function () {
        s = !1
    }), t.widget("ui.mouse", {
        version: "1.12.1",
        options: {cancel: "input, textarea, button, select, option", distance: 1, delay: 0},
        _mouseInit: function () {
            var e = this;
            this.element.on("mousedown." + this.widgetName, function (t) {
                return e._mouseDown(t)
            }).on("click." + this.widgetName, function (i) {
                return !0 === t.data(i.target, e.widgetName + ".preventClickEvent") ? (t.removeData(i.target, e.widgetName + ".preventClickEvent"), i.stopImmediatePropagation(), !1) : void 0
            }), this.started = !1
        },
        _mouseDestroy: function () {
            this.element.off("." + this.widgetName), this._mouseMoveDelegate && this.document.off("mousemove." + this.widgetName, this._mouseMoveDelegate).off("mouseup." + this.widgetName, this._mouseUpDelegate)
        },
        _mouseDown: function (e) {
            if (!s) {
                this._mouseMoved = !1, this._mouseStarted && this._mouseUp(e), this._mouseDownEvent = e;
                var i = this, n = 1 === e.which,
                    r = !("string" != typeof this.options.cancel || !e.target.nodeName) && t(e.target).closest(this.options.cancel).length;
                return !(n && !r && this._mouseCapture(e)) || (this.mouseDelayMet = !this.options.delay, this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function () {
                    i.mouseDelayMet = !0
                }, this.options.delay)), this._mouseDistanceMet(e) && this._mouseDelayMet(e) && (this._mouseStarted = !1 !== this._mouseStart(e), !this._mouseStarted) ? (e.preventDefault(), !0) : (!0 === t.data(e.target, this.widgetName + ".preventClickEvent") && t.removeData(e.target, this.widgetName + ".preventClickEvent"), this._mouseMoveDelegate = function (t) {
                    return i._mouseMove(t)
                }, this._mouseUpDelegate = function (t) {
                    return i._mouseUp(t)
                }, this.document.on("mousemove." + this.widgetName, this._mouseMoveDelegate).on("mouseup." + this.widgetName, this._mouseUpDelegate), e.preventDefault(), s = !0, !0))
            }
        },
        _mouseMove: function (e) {
            if (this._mouseMoved) {
                if (t.ui.ie && (!document.documentMode || 9 > document.documentMode) && !e.button) return this._mouseUp(e);
                if (!e.which) if (e.originalEvent.altKey || e.originalEvent.ctrlKey || e.originalEvent.metaKey || e.originalEvent.shiftKey) this.ignoreMissingWhich = !0; else if (!this.ignoreMissingWhich) return this._mouseUp(e)
            }
            return (e.which || e.button) && (this._mouseMoved = !0), this._mouseStarted ? (this._mouseDrag(e), e.preventDefault()) : (this._mouseDistanceMet(e) && this._mouseDelayMet(e) && (this._mouseStarted = !1 !== this._mouseStart(this._mouseDownEvent, e), this._mouseStarted ? this._mouseDrag(e) : this._mouseUp(e)), !this._mouseStarted)
        },
        _mouseUp: function (e) {
            this.document.off("mousemove." + this.widgetName, this._mouseMoveDelegate).off("mouseup." + this.widgetName, this._mouseUpDelegate), this._mouseStarted && (this._mouseStarted = !1, e.target === this._mouseDownEvent.target && t.data(e.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(e)), this._mouseDelayTimer && (clearTimeout(this._mouseDelayTimer), delete this._mouseDelayTimer), this.ignoreMissingWhich = !1, s = !1, e.preventDefault()
        },
        _mouseDistanceMet: function (t) {
            return Math.max(Math.abs(this._mouseDownEvent.pageX - t.pageX), Math.abs(this._mouseDownEvent.pageY - t.pageY)) >= this.options.distance
        },
        _mouseDelayMet: function () {
            return this.mouseDelayMet
        },
        _mouseStart: function () {
        },
        _mouseDrag: function () {
        },
        _mouseStop: function () {
        },
        _mouseCapture: function () {
            return !0
        }
    }), t.ui.plugin = {
        add: function (e, i, n) {
            var s, r = t.ui[e].prototype;
            for (s in n) r.plugins[s] = r.plugins[s] || [], r.plugins[s].push([i, n[s]])
        }, call: function (t, e, i, n) {
            var s, r = t.plugins[e];
            if (r && (n || t.element[0].parentNode && 11 !== t.element[0].parentNode.nodeType)) for (s = 0; r.length > s; s++) t.options[r[s][0]] && r[s][1].apply(t.element, i)
        }
    }, t.ui.safeActiveElement = function (t) {
        var e;
        try {
            e = t.activeElement
        } catch (i) {
            e = t.body
        }
        return e || (e = t.body), e.nodeName || (e = t.body), e
    }, t.ui.safeBlur = function (e) {
        e && "body" !== e.nodeName.toLowerCase() && t(e).trigger("blur")
    }, t.widget("ui.draggable", t.ui.mouse, {
        version: "1.12.1",
        widgetEventPrefix: "drag",
        options: {
            addClasses: !0,
            appendTo: "parent",
            axis: !1,
            connectToSortable: !1,
            containment: !1,
            cursor: "auto",
            cursorAt: !1,
            grid: !1,
            handle: !1,
            helper: "original",
            iframeFix: !1,
            opacity: !1,
            refreshPositions: !1,
            revert: !1,
            revertDuration: 500,
            scope: "default",
            scroll: !0,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            snap: !1,
            snapMode: "both",
            snapTolerance: 20,
            stack: !1,
            zIndex: !1,
            drag: null,
            start: null,
            stop: null
        },
        _create: function () {
            "original" === this.options.helper && this._setPositionRelative(), this.options.addClasses && this._addClass("ui-draggable"), this._setHandleClassName(), this._mouseInit()
        },
        _setOption: function (t, e) {
            this._super(t, e), "handle" === t && (this._removeHandleClassName(), this._setHandleClassName())
        },
        _destroy: function () {
            return (this.helper || this.element).is(".ui-draggable-dragging") ? void(this.destroyOnClear = !0) : (this._removeHandleClassName(), void this._mouseDestroy())
        },
        _mouseCapture: function (e) {
            var i = this.options;
            return !(this.helper || i.disabled || t(e.target).closest(".ui-resizable-handle").length > 0) && (this.handle = this._getHandle(e), !!this.handle && (this._blurActiveElement(e), this._blockFrames(!0 === i.iframeFix ? "iframe" : i.iframeFix), !0))
        },
        _blockFrames: function (e) {
            this.iframeBlocks = this.document.find(e).map(function () {
                var e = t(this);
                return t("<div>").css("position", "absolute").appendTo(e.parent()).outerWidth(e.outerWidth()).outerHeight(e.outerHeight()).offset(e.offset())[0]
            })
        },
        _unblockFrames: function () {
            this.iframeBlocks && (this.iframeBlocks.remove(), delete this.iframeBlocks)
        },
        _blurActiveElement: function (e) {
            var i = t.ui.safeActiveElement(this.document[0]);
            t(e.target).closest(i).length || t.ui.safeBlur(i)
        },
        _mouseStart: function (e) {
            var i = this.options;
            return this.helper = this._createHelper(e), this._addClass(this.helper, "ui-draggable-dragging"), this._cacheHelperProportions(), t.ui.ddmanager && (t.ui.ddmanager.current = this), this._cacheMargins(), this.cssPosition = this.helper.css("position"), this.scrollParent = this.helper.scrollParent(!0), this.offsetParent = this.helper.offsetParent(), this.hasFixedAncestor = this.helper.parents().filter(function () {
                return "fixed" === t(this).css("position")
            }).length > 0, this.positionAbs = this.element.offset(), this._refreshOffsets(e), this.originalPosition = this.position = this._generatePosition(e, !1), this.originalPageX = e.pageX, this.originalPageY = e.pageY, i.cursorAt && this._adjustOffsetFromHelper(i.cursorAt), this._setContainment(), !1 === this._trigger("start", e) ? (this._clear(), !1) : (this._cacheHelperProportions(), t.ui.ddmanager && !i.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e), this._mouseDrag(e, !0), t.ui.ddmanager && t.ui.ddmanager.dragStart(this, e), !0)
        },
        _refreshOffsets: function (t) {
            this.offset = {
                top: this.positionAbs.top - this.margins.top,
                left: this.positionAbs.left - this.margins.left,
                scroll: !1,
                parent: this._getParentOffset(),
                relative: this._getRelativeOffset()
            }, this.offset.click = {left: t.pageX - this.offset.left, top: t.pageY - this.offset.top}
        },
        _mouseDrag: function (e, i) {
            if (this.hasFixedAncestor && (this.offset.parent = this._getParentOffset()), this.position = this._generatePosition(e, !0), this.positionAbs = this._convertPositionTo("absolute"), !i) {
                var n = this._uiHash();
                if (!1 === this._trigger("drag", e, n)) return this._mouseUp(new t.Event("mouseup", e)), !1;
                this.position = n.position
            }
            return this.helper[0].style.left = this.position.left + "px", this.helper[0].style.top = this.position.top + "px", t.ui.ddmanager && t.ui.ddmanager.drag(this, e), !1
        },
        _mouseStop: function (e) {
            var i = this, n = !1;
            return t.ui.ddmanager && !this.options.dropBehaviour && (n = t.ui.ddmanager.drop(this, e)), this.dropped && (n = this.dropped, this.dropped = !1), "invalid" === this.options.revert && !n || "valid" === this.options.revert && n || !0 === this.options.revert || t.isFunction(this.options.revert) && this.options.revert.call(this.element, n) ? t(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), function () {
                !1 !== i._trigger("stop", e) && i._clear()
            }) : !1 !== this._trigger("stop", e) && this._clear(), !1
        },
        _mouseUp: function (e) {
            return this._unblockFrames(), t.ui.ddmanager && t.ui.ddmanager.dragStop(this, e), this.handleElement.is(e.target) && this.element.trigger("focus"), t.ui.mouse.prototype._mouseUp.call(this, e)
        },
        cancel: function () {
            return this.helper.is(".ui-draggable-dragging") ? this._mouseUp(new t.Event("mouseup", {target: this.element[0]})) : this._clear(), this
        },
        _getHandle: function (e) {
            return !this.options.handle || !!t(e.target).closest(this.element.find(this.options.handle)).length
        },
        _setHandleClassName: function () {
            this.handleElement = this.options.handle ? this.element.find(this.options.handle) : this.element, this._addClass(this.handleElement, "ui-draggable-handle")
        },
        _removeHandleClassName: function () {
            this._removeClass(this.handleElement, "ui-draggable-handle")
        },
        _createHelper: function (e) {
            var i = this.options, n = t.isFunction(i.helper),
                s = n ? t(i.helper.apply(this.element[0], [e])) : "clone" === i.helper ? this.element.clone().removeAttr("id") : this.element;
            return s.parents("body").length || s.appendTo("parent" === i.appendTo ? this.element[0].parentNode : i.appendTo), n && s[0] === this.element[0] && this._setPositionRelative(), s[0] === this.element[0] || /(fixed|absolute)/.test(s.css("position")) || s.css("position", "absolute"), s
        },
        _setPositionRelative: function () {
            /^(?:r|a|f)/.test(this.element.css("position")) || (this.element[0].style.position = "relative")
        },
        _adjustOffsetFromHelper: function (e) {
            "string" == typeof e && (e = e.split(" ")), t.isArray(e) && (e = {
                left: +e[0],
                top: +e[1] || 0
            }), "left" in e && (this.offset.click.left = e.left + this.margins.left), "right" in e && (this.offset.click.left = this.helperProportions.width - e.right + this.margins.left), "top" in e && (this.offset.click.top = e.top + this.margins.top), "bottom" in e && (this.offset.click.top = this.helperProportions.height - e.bottom + this.margins.top)
        },
        _isRootNode: function (t) {
            return /(html|body)/i.test(t.tagName) || t === this.document[0]
        },
        _getParentOffset: function () {
            var e = this.offsetParent.offset(), i = this.document[0];
            return "absolute" === this.cssPosition && this.scrollParent[0] !== i && t.contains(this.scrollParent[0], this.offsetParent[0]) && (e.left += this.scrollParent.scrollLeft(), e.top += this.scrollParent.scrollTop()), this._isRootNode(this.offsetParent[0]) && (e = {
                top: 0,
                left: 0
            }), {
                top: e.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: e.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function () {
            if ("relative" !== this.cssPosition) return {top: 0, left: 0};
            var t = this.element.position(), e = this._isRootNode(this.scrollParent[0]);
            return {
                top: t.top - (parseInt(this.helper.css("top"), 10) || 0) + (e ? 0 : this.scrollParent.scrollTop()),
                left: t.left - (parseInt(this.helper.css("left"), 10) || 0) + (e ? 0 : this.scrollParent.scrollLeft())
            }
        },
        _cacheMargins: function () {
            this.margins = {
                left: parseInt(this.element.css("marginLeft"), 10) || 0,
                top: parseInt(this.element.css("marginTop"), 10) || 0,
                right: parseInt(this.element.css("marginRight"), 10) || 0,
                bottom: parseInt(this.element.css("marginBottom"), 10) || 0
            }
        },
        _cacheHelperProportions: function () {
            this.helperProportions = {width: this.helper.outerWidth(), height: this.helper.outerHeight()}
        },
        _setContainment: function () {
            var e, i, n, s = this.options, r = this.document[0];
            return this.relativeContainer = null, s.containment ? "window" === s.containment ? void(this.containment = [t(window).scrollLeft() - this.offset.relative.left - this.offset.parent.left, t(window).scrollTop() - this.offset.relative.top - this.offset.parent.top, t(window).scrollLeft() + t(window).width() - this.helperProportions.width - this.margins.left, t(window).scrollTop() + (t(window).height() || r.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]) : "document" === s.containment ? void(this.containment = [0, 0, t(r).width() - this.helperProportions.width - this.margins.left, (t(r).height() || r.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]) : s.containment.constructor === Array ? void(this.containment = s.containment) : ("parent" === s.containment && (s.containment = this.helper[0].parentNode), i = t(s.containment), void((n = i[0]) && (e = /(scroll|auto)/.test(i.css("overflow")), this.containment = [(parseInt(i.css("borderLeftWidth"), 10) || 0) + (parseInt(i.css("paddingLeft"), 10) || 0), (parseInt(i.css("borderTopWidth"), 10) || 0) + (parseInt(i.css("paddingTop"), 10) || 0), (e ? Math.max(n.scrollWidth, n.offsetWidth) : n.offsetWidth) - (parseInt(i.css("borderRightWidth"), 10) || 0) - (parseInt(i.css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left - this.margins.right, (e ? Math.max(n.scrollHeight, n.offsetHeight) : n.offsetHeight) - (parseInt(i.css("borderBottomWidth"), 10) || 0) - (parseInt(i.css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top - this.margins.bottom], this.relativeContainer = i))) : void(this.containment = null)
        },
        _convertPositionTo: function (t, e) {
            e || (e = this.position);
            var i = "absolute" === t ? 1 : -1, n = this._isRootNode(this.scrollParent[0]);
            return {
                top: e.top + this.offset.relative.top * i + this.offset.parent.top * i - ("fixed" === this.cssPosition ? -this.offset.scroll.top : n ? 0 : this.offset.scroll.top) * i,
                left: e.left + this.offset.relative.left * i + this.offset.parent.left * i - ("fixed" === this.cssPosition ? -this.offset.scroll.left : n ? 0 : this.offset.scroll.left) * i
            }
        },
        _generatePosition: function (t, e) {
            var i, n, s, r, o = this.options, a = this._isRootNode(this.scrollParent[0]), l = t.pageX, c = t.pageY;
            return a && this.offset.scroll || (this.offset.scroll = {
                top: this.scrollParent.scrollTop(),
                left: this.scrollParent.scrollLeft()
            }), e && (this.containment && (this.relativeContainer ? (n = this.relativeContainer.offset(), i = [this.containment[0] + n.left, this.containment[1] + n.top, this.containment[2] + n.left, this.containment[3] + n.top]) : i = this.containment, t.pageX - this.offset.click.left < i[0] && (l = i[0] + this.offset.click.left), t.pageY - this.offset.click.top < i[1] && (c = i[1] + this.offset.click.top), t.pageX - this.offset.click.left > i[2] && (l = i[2] + this.offset.click.left), t.pageY - this.offset.click.top > i[3] && (c = i[3] + this.offset.click.top)), o.grid && (s = o.grid[1] ? this.originalPageY + Math.round((c - this.originalPageY) / o.grid[1]) * o.grid[1] : this.originalPageY, c = i ? s - this.offset.click.top >= i[1] || s - this.offset.click.top > i[3] ? s : s - this.offset.click.top >= i[1] ? s - o.grid[1] : s + o.grid[1] : s, r = o.grid[0] ? this.originalPageX + Math.round((l - this.originalPageX) / o.grid[0]) * o.grid[0] : this.originalPageX, l = i ? r - this.offset.click.left >= i[0] || r - this.offset.click.left > i[2] ? r : r - this.offset.click.left >= i[0] ? r - o.grid[0] : r + o.grid[0] : r), "y" === o.axis && (l = this.originalPageX), "x" === o.axis && (c = this.originalPageY)), {
                top: c - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" === this.cssPosition ? -this.offset.scroll.top : a ? 0 : this.offset.scroll.top),
                left: l - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" === this.cssPosition ? -this.offset.scroll.left : a ? 0 : this.offset.scroll.left)
            }
        },
        _clear: function () {
            this._removeClass(this.helper, "ui-draggable-dragging"), this.helper[0] === this.element[0] || this.cancelHelperRemoval || this.helper.remove(), this.helper = null, this.cancelHelperRemoval = !1, this.destroyOnClear && this.destroy()
        },
        _trigger: function (e, i, n) {
            return n = n || this._uiHash(), t.ui.plugin.call(this, e, [i, n, this], !0), /^(drag|start|stop)/.test(e) && (this.positionAbs = this._convertPositionTo("absolute"), n.offset = this.positionAbs), t.Widget.prototype._trigger.call(this, e, i, n)
        },
        plugins: {},
        _uiHash: function () {
            return {
                helper: this.helper,
                position: this.position,
                originalPosition: this.originalPosition,
                offset: this.positionAbs
            }
        }
    }), t.ui.plugin.add("draggable", "connectToSortable", {
        start: function (e, i, n) {
            var s = t.extend({}, i, {item: n.element});
            n.sortables = [], t(n.options.connectToSortable).each(function () {
                var i = t(this).sortable("instance");
                i && !i.options.disabled && (n.sortables.push(i), i.refreshPositions(), i._trigger("activate", e, s))
            })
        }, stop: function (e, i, n) {
            var s = t.extend({}, i, {item: n.element});
            n.cancelHelperRemoval = !1, t.each(n.sortables, function () {
                var t = this;
                t.isOver ? (t.isOver = 0, n.cancelHelperRemoval = !0, t.cancelHelperRemoval = !1, t._storedCSS = {
                    position: t.placeholder.css("position"),
                    top: t.placeholder.css("top"),
                    left: t.placeholder.css("left")
                }, t._mouseStop(e), t.options.helper = t.options._helper) : (t.cancelHelperRemoval = !0, t._trigger("deactivate", e, s))
            })
        }, drag: function (e, i, n) {
            t.each(n.sortables, function () {
                var s = !1, r = this;
                r.positionAbs = n.positionAbs, r.helperProportions = n.helperProportions, r.offset.click = n.offset.click, r._intersectsWith(r.containerCache) && (s = !0, t.each(n.sortables, function () {
                    return this.positionAbs = n.positionAbs, this.helperProportions = n.helperProportions, this.offset.click = n.offset.click, this !== r && this._intersectsWith(this.containerCache) && t.contains(r.element[0], this.element[0]) && (s = !1), s
                })), s ? (r.isOver || (r.isOver = 1, n._parent = i.helper.parent(), r.currentItem = i.helper.appendTo(r.element).data("ui-sortable-item", !0), r.options._helper = r.options.helper, r.options.helper = function () {
                    return i.helper[0]
                }, e.target = r.currentItem[0], r._mouseCapture(e, !0), r._mouseStart(e, !0, !0), r.offset.click.top = n.offset.click.top, r.offset.click.left = n.offset.click.left, r.offset.parent.left -= n.offset.parent.left - r.offset.parent.left, r.offset.parent.top -= n.offset.parent.top - r.offset.parent.top, n._trigger("toSortable", e), n.dropped = r.element, t.each(n.sortables, function () {
                    this.refreshPositions()
                }), n.currentItem = n.element, r.fromOutside = n), r.currentItem && (r._mouseDrag(e), i.position = r.position)) : r.isOver && (r.isOver = 0, r.cancelHelperRemoval = !0, r.options._revert = r.options.revert, r.options.revert = !1, r._trigger("out", e, r._uiHash(r)), r._mouseStop(e, !0), r.options.revert = r.options._revert, r.options.helper = r.options._helper, r.placeholder && r.placeholder.remove(), i.helper.appendTo(n._parent), n._refreshOffsets(e), i.position = n._generatePosition(e, !0), n._trigger("fromSortable", e), n.dropped = !1, t.each(n.sortables, function () {
                    this.refreshPositions()
                }))
            })
        }
    }), t.ui.plugin.add("draggable", "cursor", {
        start: function (e, i, n) {
            var s = t("body"), r = n.options;
            s.css("cursor") && (r._cursor = s.css("cursor")), s.css("cursor", r.cursor)
        }, stop: function (e, i, n) {
            var s = n.options;
            s._cursor && t("body").css("cursor", s._cursor)
        }
    }), t.ui.plugin.add("draggable", "opacity", {
        start: function (e, i, n) {
            var s = t(i.helper), r = n.options;
            s.css("opacity") && (r._opacity = s.css("opacity")), s.css("opacity", r.opacity)
        }, stop: function (e, i, n) {
            var s = n.options;
            s._opacity && t(i.helper).css("opacity", s._opacity)
        }
    }), t.ui.plugin.add("draggable", "scroll", {
        start: function (t, e, i) {
            i.scrollParentNotHidden || (i.scrollParentNotHidden = i.helper.scrollParent(!1)), i.scrollParentNotHidden[0] !== i.document[0] && "HTML" !== i.scrollParentNotHidden[0].tagName && (i.overflowOffset = i.scrollParentNotHidden.offset())
        }, drag: function (e, i, n) {
            var s = n.options, r = !1, o = n.scrollParentNotHidden[0], a = n.document[0];
            o !== a && "HTML" !== o.tagName ? (s.axis && "x" === s.axis || (n.overflowOffset.top + o.offsetHeight - e.pageY < s.scrollSensitivity ? o.scrollTop = r = o.scrollTop + s.scrollSpeed : e.pageY - n.overflowOffset.top < s.scrollSensitivity && (o.scrollTop = r = o.scrollTop - s.scrollSpeed)), s.axis && "y" === s.axis || (n.overflowOffset.left + o.offsetWidth - e.pageX < s.scrollSensitivity ? o.scrollLeft = r = o.scrollLeft + s.scrollSpeed : e.pageX - n.overflowOffset.left < s.scrollSensitivity && (o.scrollLeft = r = o.scrollLeft - s.scrollSpeed))) : (s.axis && "x" === s.axis || (e.pageY - t(a).scrollTop() < s.scrollSensitivity ? r = t(a).scrollTop(t(a).scrollTop() - s.scrollSpeed) : t(window).height() - (e.pageY - t(a).scrollTop()) < s.scrollSensitivity && (r = t(a).scrollTop(t(a).scrollTop() + s.scrollSpeed))), s.axis && "y" === s.axis || (e.pageX - t(a).scrollLeft() < s.scrollSensitivity ? r = t(a).scrollLeft(t(a).scrollLeft() - s.scrollSpeed) : t(window).width() - (e.pageX - t(a).scrollLeft()) < s.scrollSensitivity && (r = t(a).scrollLeft(t(a).scrollLeft() + s.scrollSpeed)))), !1 !== r && t.ui.ddmanager && !s.dropBehaviour && t.ui.ddmanager.prepareOffsets(n, e)
        }
    }), t.ui.plugin.add("draggable", "snap", {
        start: function (e, i, n) {
            var s = n.options;
            n.snapElements = [], t(s.snap.constructor !== String ? s.snap.items || ":data(ui-draggable)" : s.snap).each(function () {
                var e = t(this), i = e.offset();
                this !== n.element[0] && n.snapElements.push({
                    item: this,
                    width: e.outerWidth(),
                    height: e.outerHeight(),
                    top: i.top,
                    left: i.left
                })
            })
        }, drag: function (e, i, n) {
            var s, r, o, a, l, c, u, h, d, p, f = n.options, g = f.snapTolerance, m = i.offset.left,
                v = m + n.helperProportions.width, b = i.offset.top, y = b + n.helperProportions.height;
            for (d = n.snapElements.length - 1; d >= 0; d--) l = n.snapElements[d].left - n.margins.left, c = l + n.snapElements[d].width, u = n.snapElements[d].top - n.margins.top, h = u + n.snapElements[d].height, l - g > v || m > c + g || u - g > y || b > h + g || !t.contains(n.snapElements[d].item.ownerDocument, n.snapElements[d].item) ? (n.snapElements[d].snapping && n.options.snap.release && n.options.snap.release.call(n.element, e, t.extend(n._uiHash(), {snapItem: n.snapElements[d].item})), n.snapElements[d].snapping = !1) : ("inner" !== f.snapMode && (s = g >= Math.abs(u - y), r = g >= Math.abs(h - b), o = g >= Math.abs(l - v), a = g >= Math.abs(c - m), s && (i.position.top = n._convertPositionTo("relative", {
                top: u - n.helperProportions.height,
                left: 0
            }).top), r && (i.position.top = n._convertPositionTo("relative", {
                top: h,
                left: 0
            }).top), o && (i.position.left = n._convertPositionTo("relative", {
                top: 0,
                left: l - n.helperProportions.width
            }).left), a && (i.position.left = n._convertPositionTo("relative", {
                top: 0,
                left: c
            }).left)), p = s || r || o || a, "outer" !== f.snapMode && (s = g >= Math.abs(u - b), r = g >= Math.abs(h - y), o = g >= Math.abs(l - m), a = g >= Math.abs(c - v), s && (i.position.top = n._convertPositionTo("relative", {
                top: u,
                left: 0
            }).top), r && (i.position.top = n._convertPositionTo("relative", {
                top: h - n.helperProportions.height,
                left: 0
            }).top), o && (i.position.left = n._convertPositionTo("relative", {
                top: 0,
                left: l
            }).left), a && (i.position.left = n._convertPositionTo("relative", {
                top: 0,
                left: c - n.helperProportions.width
            }).left)), !n.snapElements[d].snapping && (s || r || o || a || p) && n.options.snap.snap && n.options.snap.snap.call(n.element, e, t.extend(n._uiHash(), {snapItem: n.snapElements[d].item})), n.snapElements[d].snapping = s || r || o || a || p)
        }
    }), t.ui.plugin.add("draggable", "stack", {
        start: function (e, i, n) {
            var s, r = n.options, o = t.makeArray(t(r.stack)).sort(function (e, i) {
                return (parseInt(t(e).css("zIndex"), 10) || 0) - (parseInt(t(i).css("zIndex"), 10) || 0)
            });
            o.length && (s = parseInt(t(o[0]).css("zIndex"), 10) || 0, t(o).each(function (e) {
                t(this).css("zIndex", s + e)
            }), this.css("zIndex", s + o.length))
        }
    }), t.ui.plugin.add("draggable", "zIndex", {
        start: function (e, i, n) {
            var s = t(i.helper), r = n.options;
            s.css("zIndex") && (r._zIndex = s.css("zIndex")), s.css("zIndex", r.zIndex)
        }, stop: function (e, i, n) {
            var s = n.options;
            s._zIndex && t(i.helper).css("zIndex", s._zIndex)
        }
    }), t.ui.draggable, t.widget("ui.droppable", {
        version: "1.12.1",
        widgetEventPrefix: "drop",
        options: {
            accept: "*",
            addClasses: !0,
            greedy: !1,
            scope: "default",
            tolerance: "intersect",
            activate: null,
            deactivate: null,
            drop: null,
            out: null,
            over: null
        },
        _create: function () {
            var e, i = this.options, n = i.accept;
            this.isover = !1, this.isout = !0, this.accept = t.isFunction(n) ? n : function (t) {
                return t.is(n)
            }, this.proportions = function () {
                return arguments.length ? void(e = arguments[0]) : e || (e = {
                    width: this.element[0].offsetWidth,
                    height: this.element[0].offsetHeight
                })
            }, this._addToManager(i.scope), i.addClasses && this._addClass("ui-droppable")
        },
        _addToManager: function (e) {
            t.ui.ddmanager.droppables[e] = t.ui.ddmanager.droppables[e] || [], t.ui.ddmanager.droppables[e].push(this)
        },
        _splice: function (t) {
            for (var e = 0; t.length > e; e++) t[e] === this && t.splice(e, 1)
        },
        _destroy: function () {
            var e = t.ui.ddmanager.droppables[this.options.scope];
            this._splice(e)
        },
        _setOption: function (e, i) {
            if ("accept" === e) this.accept = t.isFunction(i) ? i : function (t) {
                return t.is(i)
            }; else if ("scope" === e) {
                var n = t.ui.ddmanager.droppables[this.options.scope];
                this._splice(n), this._addToManager(i)
            }
            this._super(e, i)
        },
        _activate: function (e) {
            var i = t.ui.ddmanager.current;
            this._addActiveClass(), i && this._trigger("activate", e, this.ui(i))
        },
        _deactivate: function (e) {
            var i = t.ui.ddmanager.current;
            this._removeActiveClass(), i && this._trigger("deactivate", e, this.ui(i))
        },
        _over: function (e) {
            var i = t.ui.ddmanager.current;
            i && (i.currentItem || i.element)[0] !== this.element[0] && this.accept.call(this.element[0], i.currentItem || i.element) && (this._addHoverClass(), this._trigger("over", e, this.ui(i)))
        },
        _out: function (e) {
            var i = t.ui.ddmanager.current;
            i && (i.currentItem || i.element)[0] !== this.element[0] && this.accept.call(this.element[0], i.currentItem || i.element) && (this._removeHoverClass(), this._trigger("out", e, this.ui(i)))
        },
        _drop: function (e, i) {
            var n = i || t.ui.ddmanager.current, s = !1;
            return !(!n || (n.currentItem || n.element)[0] === this.element[0]) && (this.element.find(":data(ui-droppable)").not(".ui-draggable-dragging").each(function () {
                var i = t(this).droppable("instance");
                return i.options.greedy && !i.options.disabled && i.options.scope === n.options.scope && i.accept.call(i.element[0], n.currentItem || n.element) && r(n, t.extend(i, {offset: i.element.offset()}), i.options.tolerance, e) ? (s = !0, !1) : void 0
            }), !s && (!!this.accept.call(this.element[0], n.currentItem || n.element) && (this._removeActiveClass(), this._removeHoverClass(), this._trigger("drop", e, this.ui(n)), this.element)))
        },
        ui: function (t) {
            return {
                draggable: t.currentItem || t.element, helper: t.helper,
                position: t.position, offset: t.positionAbs
            }
        },
        _addHoverClass: function () {
            this._addClass("ui-droppable-hover")
        },
        _removeHoverClass: function () {
            this._removeClass("ui-droppable-hover")
        },
        _addActiveClass: function () {
            this._addClass("ui-droppable-active")
        },
        _removeActiveClass: function () {
            this._removeClass("ui-droppable-active")
        }
    });
    var r = t.ui.intersect = function () {
        function t(t, e, i) {
            return t >= e && e + i > t
        }

        return function (e, i, n, s) {
            if (!i.offset) return !1;
            var r = (e.positionAbs || e.position.absolute).left + e.margins.left,
                o = (e.positionAbs || e.position.absolute).top + e.margins.top, a = r + e.helperProportions.width,
                l = o + e.helperProportions.height, c = i.offset.left, u = i.offset.top, h = c + i.proportions().width,
                d = u + i.proportions().height;
            switch (n) {
                case"fit":
                    return r >= c && h >= a && o >= u && d >= l;
                case"intersect":
                    return r + e.helperProportions.width / 2 > c && h > a - e.helperProportions.width / 2 && o + e.helperProportions.height / 2 > u && d > l - e.helperProportions.height / 2;
                case"pointer":
                    return t(s.pageY, u, i.proportions().height) && t(s.pageX, c, i.proportions().width);
                case"touch":
                    return (o >= u && d >= o || l >= u && d >= l || u > o && l > d) && (r >= c && h >= r || a >= c && h >= a || c > r && a > h);
                default:
                    return !1
            }
        }
    }();
    t.ui.ddmanager = {
        current: null, droppables: {default: []}, prepareOffsets: function (e, i) {
            var n, s, r = t.ui.ddmanager.droppables[e.options.scope] || [], o = i ? i.type : null,
                a = (e.currentItem || e.element).find(":data(ui-droppable)").addBack();
            t:for (n = 0; r.length > n; n++) if (!(r[n].options.disabled || e && !r[n].accept.call(r[n].element[0], e.currentItem || e.element))) {
                for (s = 0; a.length > s; s++) if (a[s] === r[n].element[0]) {
                    r[n].proportions().height = 0;
                    continue t
                }
                r[n].visible = "none" !== r[n].element.css("display"), r[n].visible && ("mousedown" === o && r[n]._activate.call(r[n], i), r[n].offset = r[n].element.offset(), r[n].proportions({
                    width: r[n].element[0].offsetWidth,
                    height: r[n].element[0].offsetHeight
                }))
            }
        }, drop: function (e, i) {
            var n = !1;
            return t.each((t.ui.ddmanager.droppables[e.options.scope] || []).slice(), function () {
                this.options && (!this.options.disabled && this.visible && r(e, this, this.options.tolerance, i) && (n = this._drop.call(this, i) || n), !this.options.disabled && this.visible && this.accept.call(this.element[0], e.currentItem || e.element) && (this.isout = !0, this.isover = !1, this._deactivate.call(this, i)))
            }), n
        }, dragStart: function (e, i) {
            e.element.parentsUntil("body").on("scroll.droppable", function () {
                e.options.refreshPositions || t.ui.ddmanager.prepareOffsets(e, i)
            })
        }, drag: function (e, i) {
            e.options.refreshPositions && t.ui.ddmanager.prepareOffsets(e, i), t.each(t.ui.ddmanager.droppables[e.options.scope] || [], function () {
                if (!this.options.disabled && !this.greedyChild && this.visible) {
                    var n, s, o, a = r(e, this, this.options.tolerance, i),
                        l = !a && this.isover ? "isout" : a && !this.isover ? "isover" : null;
                    l && (this.options.greedy && (s = this.options.scope, o = this.element.parents(":data(ui-droppable)").filter(function () {
                        return t(this).droppable("instance").options.scope === s
                    }), o.length && (n = t(o[0]).droppable("instance"), n.greedyChild = "isover" === l)), n && "isover" === l && (n.isover = !1, n.isout = !0, n._out.call(n, i)), this[l] = !0, this["isout" === l ? "isover" : "isout"] = !1, this["isover" === l ? "_over" : "_out"].call(this, i), n && "isout" === l && (n.isout = !1, n.isover = !0, n._over.call(n, i)))
                }
            })
        }, dragStop: function (e, i) {
            e.element.parentsUntil("body").off("scroll.droppable"), e.options.refreshPositions || t.ui.ddmanager.prepareOffsets(e, i)
        }
    }, !1 !== t.uiBackCompat && t.widget("ui.droppable", t.ui.droppable, {
        options: {hoverClass: !1, activeClass: !1},
        _addActiveClass: function () {
            this._super(), this.options.activeClass && this.element.addClass(this.options.activeClass)
        },
        _removeActiveClass: function () {
            this._super(), this.options.activeClass && this.element.removeClass(this.options.activeClass)
        },
        _addHoverClass: function () {
            this._super(), this.options.hoverClass && this.element.addClass(this.options.hoverClass)
        },
        _removeHoverClass: function () {
            this._super(), this.options.hoverClass && this.element.removeClass(this.options.hoverClass)
        }
    }), t.ui.droppable, t.widget("ui.resizable", t.ui.mouse, {
        version: "1.12.1",
        widgetEventPrefix: "resize",
        options: {
            alsoResize: !1,
            animate: !1,
            animateDuration: "slow",
            animateEasing: "swing",
            aspectRatio: !1,
            autoHide: !1,
            classes: {"ui-resizable-se": "ui-icon ui-icon-gripsmall-diagonal-se"},
            containment: !1,
            ghost: !1,
            grid: !1,
            handles: "e,s,se",
            helper: !1,
            maxHeight: null,
            maxWidth: null,
            minHeight: 10,
            minWidth: 10,
            zIndex: 90,
            resize: null,
            start: null,
            stop: null
        },
        _num: function (t) {
            return parseFloat(t) || 0
        },
        _isNumber: function (t) {
            return !isNaN(parseFloat(t))
        },
        _hasScroll: function (e, i) {
            if ("hidden" === t(e).css("overflow")) return !1;
            var n = i && "left" === i ? "scrollLeft" : "scrollTop", s = !1;
            return e[n] > 0 || (e[n] = 1, s = e[n] > 0, e[n] = 0, s)
        },
        _create: function () {
            var e, i = this.options, n = this;
            this._addClass("ui-resizable"), t.extend(this, {
                _aspectRatio: !!i.aspectRatio,
                aspectRatio: i.aspectRatio,
                originalElement: this.element,
                _proportionallyResizeElements: [],
                _helper: i.helper || i.ghost || i.animate ? i.helper || "ui-resizable-helper" : null
            }), this.element[0].nodeName.match(/^(canvas|textarea|input|select|button|img)$/i) && (this.element.wrap(t("<div class='ui-wrapper' style='overflow: hidden;'></div>").css({
                position: this.element.css("position"),
                width: this.element.outerWidth(),
                height: this.element.outerHeight(),
                top: this.element.css("top"),
                left: this.element.css("left")
            })), this.element = this.element.parent().data("ui-resizable", this.element.resizable("instance")), this.elementIsWrapper = !0, e = {
                marginTop: this.originalElement.css("marginTop"),
                marginRight: this.originalElement.css("marginRight"),
                marginBottom: this.originalElement.css("marginBottom"),
                marginLeft: this.originalElement.css("marginLeft")
            }, this.element.css(e), this.originalElement.css("margin", 0), this.originalResizeStyle = this.originalElement.css("resize"), this.originalElement.css("resize", "none"), this._proportionallyResizeElements.push(this.originalElement.css({
                position: "static",
                zoom: 1,
                display: "block"
            })), this.originalElement.css(e), this._proportionallyResize()), this._setupHandles(), i.autoHide && t(this.element).on("mouseenter", function () {
                i.disabled || (n._removeClass("ui-resizable-autohide"), n._handles.show())
            }).on("mouseleave", function () {
                i.disabled || n.resizing || (n._addClass("ui-resizable-autohide"), n._handles.hide())
            }), this._mouseInit()
        },
        _destroy: function () {
            this._mouseDestroy();
            var e, i = function (e) {
                t(e).removeData("resizable").removeData("ui-resizable").off(".resizable").find(".ui-resizable-handle").remove()
            };
            return this.elementIsWrapper && (i(this.element), e = this.element, this.originalElement.css({
                position: e.css("position"),
                width: e.outerWidth(),
                height: e.outerHeight(),
                top: e.css("top"),
                left: e.css("left")
            }).insertAfter(e), e.remove()), this.originalElement.css("resize", this.originalResizeStyle), i(this.originalElement), this
        },
        _setOption: function (t, e) {
            switch (this._super(t, e), t) {
                case"handles":
                    this._removeHandles(), this._setupHandles()
            }
        },
        _setupHandles: function () {
            var e, i, n, s, r, o = this.options, a = this;
            if (this.handles = o.handles || (t(".ui-resizable-handle", this.element).length ? {
                n: ".ui-resizable-n",
                e: ".ui-resizable-e",
                s: ".ui-resizable-s",
                w: ".ui-resizable-w",
                se: ".ui-resizable-se",
                sw: ".ui-resizable-sw",
                ne: ".ui-resizable-ne",
                nw: ".ui-resizable-nw"
            } : "e,s,se"), this._handles = t(), this.handles.constructor === String) for ("all" === this.handles && (this.handles = "n,e,s,w,se,sw,ne,nw"), n = this.handles.split(","), this.handles = {}, i = 0; n.length > i; i++) e = t.trim(n[i]), s = "ui-resizable-" + e, r = t("<div>"), this._addClass(r, "ui-resizable-handle " + s), r.css({zIndex: o.zIndex}), this.handles[e] = ".ui-resizable-" + e, this.element.append(r);
            this._renderAxis = function (e) {
                var i, n, s, r;
                e = e || this.element;
                for (i in this.handles) this.handles[i].constructor === String ? this.handles[i] = this.element.children(this.handles[i]).first().show() : (this.handles[i].jquery || this.handles[i].nodeType) && (this.handles[i] = t(this.handles[i]), this._on(this.handles[i], {mousedown: a._mouseDown})), this.elementIsWrapper && this.originalElement[0].nodeName.match(/^(textarea|input|select|button)$/i) && (n = t(this.handles[i], this.element), r = /sw|ne|nw|se|n|s/.test(i) ? n.outerHeight() : n.outerWidth(), s = ["padding", /ne|nw|n/.test(i) ? "Top" : /se|sw|s/.test(i) ? "Bottom" : /^e$/.test(i) ? "Right" : "Left"].join(""), e.css(s, r), this._proportionallyResize()), this._handles = this._handles.add(this.handles[i])
            }, this._renderAxis(this.element), this._handles = this._handles.add(this.element.find(".ui-resizable-handle")), this._handles.disableSelection(), this._handles.on("mouseover", function () {
                a.resizing || (this.className && (r = this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i)), a.axis = r && r[1] ? r[1] : "se")
            }), o.autoHide && (this._handles.hide(), this._addClass("ui-resizable-autohide"))
        },
        _removeHandles: function () {
            this._handles.remove()
        },
        _mouseCapture: function (e) {
            var i, n, s = !1;
            for (i in this.handles) ((n = t(this.handles[i])[0]) === e.target || t.contains(n, e.target)) && (s = !0);
            return !this.options.disabled && s
        },
        _mouseStart: function (e) {
            var i, n, s, r = this.options, o = this.element;
            return this.resizing = !0, this._renderProxy(), i = this._num(this.helper.css("left")), n = this._num(this.helper.css("top")), r.containment && (i += t(r.containment).scrollLeft() || 0, n += t(r.containment).scrollTop() || 0), this.offset = this.helper.offset(), this.position = {
                left: i,
                top: n
            }, this.size = this._helper ? {
                width: this.helper.width(),
                height: this.helper.height()
            } : {width: o.width(), height: o.height()}, this.originalSize = this._helper ? {
                width: o.outerWidth(),
                height: o.outerHeight()
            } : {width: o.width(), height: o.height()}, this.sizeDiff = {
                width: o.outerWidth() - o.width(),
                height: o.outerHeight() - o.height()
            }, this.originalPosition = {left: i, top: n}, this.originalMousePosition = {
                left: e.pageX,
                top: e.pageY
            }, this.aspectRatio = "number" == typeof r.aspectRatio ? r.aspectRatio : this.originalSize.width / this.originalSize.height || 1, s = t(".ui-resizable-" + this.axis).css("cursor"), t("body").css("cursor", "auto" === s ? this.axis + "-resize" : s), this._addClass("ui-resizable-resizing"), this._propagate("start", e), !0
        },
        _mouseDrag: function (e) {
            var i, n, s = this.originalMousePosition, r = this.axis, o = e.pageX - s.left || 0,
                a = e.pageY - s.top || 0, l = this._change[r];
            return this._updatePrevProperties(), !!l && (i = l.apply(this, [e, o, a]), this._updateVirtualBoundaries(e.shiftKey), (this._aspectRatio || e.shiftKey) && (i = this._updateRatio(i, e)), i = this._respectSize(i, e), this._updateCache(i), this._propagate("resize", e), n = this._applyChanges(), !this._helper && this._proportionallyResizeElements.length && this._proportionallyResize(), t.isEmptyObject(n) || (this._updatePrevProperties(), this._trigger("resize", e, this.ui()), this._applyChanges()), !1)
        },
        _mouseStop: function (e) {
            this.resizing = !1;
            var i, n, s, r, o, a, l, c = this.options, u = this;
            return this._helper && (i = this._proportionallyResizeElements, n = i.length && /textarea/i.test(i[0].nodeName), s = n && this._hasScroll(i[0], "left") ? 0 : u.sizeDiff.height, r = n ? 0 : u.sizeDiff.width, o = {
                width: u.helper.width() - r,
                height: u.helper.height() - s
            }, a = parseFloat(u.element.css("left")) + (u.position.left - u.originalPosition.left) || null, l = parseFloat(u.element.css("top")) + (u.position.top - u.originalPosition.top) || null, c.animate || this.element.css(t.extend(o, {
                top: l,
                left: a
            })), u.helper.height(u.size.height), u.helper.width(u.size.width), this._helper && !c.animate && this._proportionallyResize()), t("body").css("cursor", "auto"), this._removeClass("ui-resizable-resizing"), this._propagate("stop", e), this._helper && this.helper.remove(), !1
        },
        _updatePrevProperties: function () {
            this.prevPosition = {
                top: this.position.top,
                left: this.position.left
            }, this.prevSize = {width: this.size.width, height: this.size.height}
        },
        _applyChanges: function () {
            var t = {};
            return this.position.top !== this.prevPosition.top && (t.top = this.position.top + "px"), this.position.left !== this.prevPosition.left && (t.left = this.position.left + "px"), this.size.width !== this.prevSize.width && (t.width = this.size.width + "px"), this.size.height !== this.prevSize.height && (t.height = this.size.height + "px"), this.helper.css(t), t
        },
        _updateVirtualBoundaries: function (t) {
            var e, i, n, s, r, o = this.options;
            r = {
                minWidth: this._isNumber(o.minWidth) ? o.minWidth : 0,
                maxWidth: this._isNumber(o.maxWidth) ? o.maxWidth : 1 / 0,
                minHeight: this._isNumber(o.minHeight) ? o.minHeight : 0,
                maxHeight: this._isNumber(o.maxHeight) ? o.maxHeight : 1 / 0
            }, (this._aspectRatio || t) && (e = r.minHeight * this.aspectRatio, n = r.minWidth / this.aspectRatio, i = r.maxHeight * this.aspectRatio, s = r.maxWidth / this.aspectRatio, e > r.minWidth && (r.minWidth = e), n > r.minHeight && (r.minHeight = n), r.maxWidth > i && (r.maxWidth = i), r.maxHeight > s && (r.maxHeight = s)), this._vBoundaries = r
        },
        _updateCache: function (t) {
            this.offset = this.helper.offset(), this._isNumber(t.left) && (this.position.left = t.left), this._isNumber(t.top) && (this.position.top = t.top), this._isNumber(t.height) && (this.size.height = t.height), this._isNumber(t.width) && (this.size.width = t.width)
        },
        _updateRatio: function (t) {
            var e = this.position, i = this.size, n = this.axis;
            return this._isNumber(t.height) ? t.width = t.height * this.aspectRatio : this._isNumber(t.width) && (t.height = t.width / this.aspectRatio), "sw" === n && (t.left = e.left + (i.width - t.width), t.top = null), "nw" === n && (t.top = e.top + (i.height - t.height), t.left = e.left + (i.width - t.width)), t
        },
        _respectSize: function (t) {
            var e = this._vBoundaries, i = this.axis, n = this._isNumber(t.width) && e.maxWidth && e.maxWidth < t.width,
                s = this._isNumber(t.height) && e.maxHeight && e.maxHeight < t.height,
                r = this._isNumber(t.width) && e.minWidth && e.minWidth > t.width,
                o = this._isNumber(t.height) && e.minHeight && e.minHeight > t.height,
                a = this.originalPosition.left + this.originalSize.width,
                l = this.originalPosition.top + this.originalSize.height, c = /sw|nw|w/.test(i), u = /nw|ne|n/.test(i);
            return r && (t.width = e.minWidth), o && (t.height = e.minHeight), n && (t.width = e.maxWidth), s && (t.height = e.maxHeight), r && c && (t.left = a - e.minWidth), n && c && (t.left = a - e.maxWidth), o && u && (t.top = l - e.minHeight), s && u && (t.top = l - e.maxHeight), t.width || t.height || t.left || !t.top ? t.width || t.height || t.top || !t.left || (t.left = null) : t.top = null, t
        },
        _getPaddingPlusBorderDimensions: function (t) {
            for (var e = 0, i = [], n = [t.css("borderTopWidth"), t.css("borderRightWidth"), t.css("borderBottomWidth"), t.css("borderLeftWidth")], s = [t.css("paddingTop"), t.css("paddingRight"), t.css("paddingBottom"), t.css("paddingLeft")]; 4 > e; e++) i[e] = parseFloat(n[e]) || 0, i[e] += parseFloat(s[e]) || 0;
            return {height: i[0] + i[2], width: i[1] + i[3]}
        },
        _proportionallyResize: function () {
            if (this._proportionallyResizeElements.length) for (var t, e = 0, i = this.helper || this.element; this._proportionallyResizeElements.length > e; e++) t = this._proportionallyResizeElements[e], this.outerDimensions || (this.outerDimensions = this._getPaddingPlusBorderDimensions(t)), t.css({
                height: i.height() - this.outerDimensions.height || 0,
                width: i.width() - this.outerDimensions.width || 0
            })
        },
        _renderProxy: function () {
            var e = this.element, i = this.options;
            this.elementOffset = e.offset(), this._helper ? (this.helper = this.helper || t("<div style='overflow:hidden;'></div>"), this._addClass(this.helper, this._helper), this.helper.css({
                width: this.element.outerWidth(),
                height: this.element.outerHeight(),
                position: "absolute",
                left: this.elementOffset.left + "px",
                top: this.elementOffset.top + "px",
                zIndex: ++i.zIndex
            }), this.helper.appendTo("body").disableSelection()) : this.helper = this.element
        },
        _change: {
            e: function (t, e) {
                return {width: this.originalSize.width + e}
            }, w: function (t, e) {
                var i = this.originalSize;
                return {left: this.originalPosition.left + e, width: i.width - e}
            }, n: function (t, e, i) {
                var n = this.originalSize;
                return {top: this.originalPosition.top + i, height: n.height - i}
            }, s: function (t, e, i) {
                return {height: this.originalSize.height + i}
            }, se: function (e, i, n) {
                return t.extend(this._change.s.apply(this, arguments), this._change.e.apply(this, [e, i, n]))
            }, sw: function (e, i, n) {
                return t.extend(this._change.s.apply(this, arguments), this._change.w.apply(this, [e, i, n]))
            }, ne: function (e, i, n) {
                return t.extend(this._change.n.apply(this, arguments), this._change.e.apply(this, [e, i, n]))
            }, nw: function (e, i, n) {
                return t.extend(this._change.n.apply(this, arguments), this._change.w.apply(this, [e, i, n]))
            }
        },
        _propagate: function (e, i) {
            t.ui.plugin.call(this, e, [i, this.ui()]), "resize" !== e && this._trigger(e, i, this.ui())
        },
        plugins: {},
        ui: function () {
            return {
                originalElement: this.originalElement,
                element: this.element,
                helper: this.helper,
                position: this.position,
                size: this.size,
                originalSize: this.originalSize,
                originalPosition: this.originalPosition
            }
        }
    }), t.ui.plugin.add("resizable", "animate", {
        stop: function (e) {
            var i = t(this).resizable("instance"), n = i.options, s = i._proportionallyResizeElements,
                r = s.length && /textarea/i.test(s[0].nodeName),
                o = r && i._hasScroll(s[0], "left") ? 0 : i.sizeDiff.height, a = r ? 0 : i.sizeDiff.width,
                l = {width: i.size.width - a, height: i.size.height - o},
                c = parseFloat(i.element.css("left")) + (i.position.left - i.originalPosition.left) || null,
                u = parseFloat(i.element.css("top")) + (i.position.top - i.originalPosition.top) || null;
            i.element.animate(t.extend(l, u && c ? {top: u, left: c} : {}), {
                duration: n.animateDuration,
                easing: n.animateEasing,
                step: function () {
                    var n = {
                        width: parseFloat(i.element.css("width")),
                        height: parseFloat(i.element.css("height")),
                        top: parseFloat(i.element.css("top")),
                        left: parseFloat(i.element.css("left"))
                    };
                    s && s.length && t(s[0]).css({
                        width: n.width,
                        height: n.height
                    }), i._updateCache(n), i._propagate("resize", e)
                }
            })
        }
    }), t.ui.plugin.add("resizable", "containment", {
        start: function () {
            var e, i, n, s, r, o, a, l = t(this).resizable("instance"), c = l.options, u = l.element, h = c.containment,
                d = h instanceof t ? h.get(0) : /parent/.test(h) ? u.parent().get(0) : h;
            d && (l.containerElement = t(d), /document/.test(h) || h === document ? (l.containerOffset = {
                left: 0,
                top: 0
            }, l.containerPosition = {left: 0, top: 0}, l.parentData = {
                element: t(document),
                left: 0,
                top: 0,
                width: t(document).width(),
                height: t(document).height() || document.body.parentNode.scrollHeight
            }) : (e = t(d), i = [], t(["Top", "Right", "Left", "Bottom"]).each(function (t, n) {
                i[t] = l._num(e.css("padding" + n))
            }), l.containerOffset = e.offset(), l.containerPosition = e.position(), l.containerSize = {
                height: e.innerHeight() - i[3],
                width: e.innerWidth() - i[1]
            }, n = l.containerOffset, s = l.containerSize.height, r = l.containerSize.width, o = l._hasScroll(d, "left") ? d.scrollWidth : r, a = l._hasScroll(d) ? d.scrollHeight : s, l.parentData = {
                element: d,
                left: n.left,
                top: n.top,
                width: o,
                height: a
            }))
        }, resize: function (e) {
            var i, n, s, r, o = t(this).resizable("instance"), a = o.options, l = o.containerOffset, c = o.position,
                u = o._aspectRatio || e.shiftKey, h = {top: 0, left: 0}, d = o.containerElement, p = !0;
            d[0] !== document && /static/.test(d.css("position")) && (h = l), c.left < (o._helper ? l.left : 0) && (o.size.width = o.size.width + (o._helper ? o.position.left - l.left : o.position.left - h.left), u && (o.size.height = o.size.width / o.aspectRatio, p = !1), o.position.left = a.helper ? l.left : 0), c.top < (o._helper ? l.top : 0) && (o.size.height = o.size.height + (o._helper ? o.position.top - l.top : o.position.top), u && (o.size.width = o.size.height * o.aspectRatio, p = !1), o.position.top = o._helper ? l.top : 0), s = o.containerElement.get(0) === o.element.parent().get(0), r = /relative|absolute/.test(o.containerElement.css("position")), s && r ? (o.offset.left = o.parentData.left + o.position.left, o.offset.top = o.parentData.top + o.position.top) : (o.offset.left = o.element.offset().left, o.offset.top = o.element.offset().top), i = Math.abs(o.sizeDiff.width + (o._helper ? o.offset.left - h.left : o.offset.left - l.left)), n = Math.abs(o.sizeDiff.height + (o._helper ? o.offset.top - h.top : o.offset.top - l.top)), i + o.size.width >= o.parentData.width && (o.size.width = o.parentData.width - i, u && (o.size.height = o.size.width / o.aspectRatio, p = !1)), n + o.size.height >= o.parentData.height && (o.size.height = o.parentData.height - n, u && (o.size.width = o.size.height * o.aspectRatio, p = !1)), p || (o.position.left = o.prevPosition.left, o.position.top = o.prevPosition.top, o.size.width = o.prevSize.width, o.size.height = o.prevSize.height)
        }, stop: function () {
            var e = t(this).resizable("instance"), i = e.options, n = e.containerOffset, s = e.containerPosition,
                r = e.containerElement, o = t(e.helper), a = o.offset(), l = o.outerWidth() - e.sizeDiff.width,
                c = o.outerHeight() - e.sizeDiff.height;
            e._helper && !i.animate && /relative/.test(r.css("position")) && t(this).css({
                left: a.left - s.left - n.left,
                width: l,
                height: c
            }), e._helper && !i.animate && /static/.test(r.css("position")) && t(this).css({
                left: a.left - s.left - n.left,
                width: l,
                height: c
            })
        }
    }), t.ui.plugin.add("resizable", "alsoResize", {
        start: function () {
            var e = t(this).resizable("instance"), i = e.options;
            t(i.alsoResize).each(function () {
                var e = t(this);
                e.data("ui-resizable-alsoresize", {
                    width: parseFloat(e.width()),
                    height: parseFloat(e.height()),
                    left: parseFloat(e.css("left")),
                    top: parseFloat(e.css("top"))
                })
            })
        }, resize: function (e, i) {
            var n = t(this).resizable("instance"), s = n.options, r = n.originalSize, o = n.originalPosition, a = {
                height: n.size.height - r.height || 0,
                width: n.size.width - r.width || 0,
                top: n.position.top - o.top || 0,
                left: n.position.left - o.left || 0
            };
            t(s.alsoResize).each(function () {
                var e = t(this), n = t(this).data("ui-resizable-alsoresize"), s = {},
                    r = e.parents(i.originalElement[0]).length ? ["width", "height"] : ["width", "height", "top", "left"];
                t.each(r, function (t, e) {
                    var i = (n[e] || 0) + (a[e] || 0);
                    i && i >= 0 && (s[e] = i || null)
                }), e.css(s)
            })
        }, stop: function () {
            t(this).removeData("ui-resizable-alsoresize")
        }
    }), t.ui.plugin.add("resizable", "ghost", {
        start: function () {
            var e = t(this).resizable("instance"), i = e.size;
            e.ghost = e.originalElement.clone(), e.ghost.css({
                opacity: .25,
                display: "block",
                position: "relative",
                height: i.height,
                width: i.width,
                margin: 0,
                left: 0,
                top: 0
            }), e._addClass(e.ghost, "ui-resizable-ghost"), !1 !== t.uiBackCompat && "string" == typeof e.options.ghost && e.ghost.addClass(this.options.ghost), e.ghost.appendTo(e.helper)
        }, resize: function () {
            var e = t(this).resizable("instance");
            e.ghost && e.ghost.css({position: "relative", height: e.size.height, width: e.size.width})
        }, stop: function () {
            var e = t(this).resizable("instance");
            e.ghost && e.helper && e.helper.get(0).removeChild(e.ghost.get(0))
        }
    }), t.ui.plugin.add("resizable", "grid", {
        resize: function () {
            var e, i = t(this).resizable("instance"), n = i.options, s = i.size, r = i.originalSize,
                o = i.originalPosition, a = i.axis, l = "number" == typeof n.grid ? [n.grid, n.grid] : n.grid,
                c = l[0] || 1, u = l[1] || 1, h = Math.round((s.width - r.width) / c) * c,
                d = Math.round((s.height - r.height) / u) * u, p = r.width + h, f = r.height + d,
                g = n.maxWidth && p > n.maxWidth, m = n.maxHeight && f > n.maxHeight, v = n.minWidth && n.minWidth > p,
                b = n.minHeight && n.minHeight > f;
            n.grid = l, v && (p += c), b && (f += u), g && (p -= c), m && (f -= u), /^(se|s|e)$/.test(a) ? (i.size.width = p, i.size.height = f) : /^(ne)$/.test(a) ? (i.size.width = p, i.size.height = f, i.position.top = o.top - d) : /^(sw)$/.test(a) ? (i.size.width = p, i.size.height = f, i.position.left = o.left - h) : ((0 >= f - u || 0 >= p - c) && (e = i._getPaddingPlusBorderDimensions(this)), f - u > 0 ? (i.size.height = f, i.position.top = o.top - d) : (f = u - e.height, i.size.height = f, i.position.top = o.top + r.height - f), p - c > 0 ? (i.size.width = p, i.position.left = o.left - h) : (p = c - e.width, i.size.width = p, i.position.left = o.left + r.width - p))
        }
    }), t.ui.resizable, t.widget("ui.selectable", t.ui.mouse, {
        version: "1.12.1",
        options: {
            appendTo: "body",
            autoRefresh: !0,
            distance: 0,
            filter: "*",
            tolerance: "touch",
            selected: null,
            selecting: null,
            start: null,
            stop: null,
            unselected: null,
            unselecting: null
        },
        _create: function () {
            var e = this;
            this._addClass("ui-selectable"), this.dragged = !1, this.refresh = function () {
                e.elementPos = t(e.element[0]).offset(), e.selectees = t(e.options.filter, e.element[0]), e._addClass(e.selectees, "ui-selectee"), e.selectees.each(function () {
                    var i = t(this), n = i.offset(),
                        s = {left: n.left - e.elementPos.left, top: n.top - e.elementPos.top};
                    t.data(this, "selectable-item", {
                        element: this,
                        $element: i,
                        left: s.left,
                        top: s.top,
                        right: s.left + i.outerWidth(),
                        bottom: s.top + i.outerHeight(),
                        startselected: !1,
                        selected: i.hasClass("ui-selected"),
                        selecting: i.hasClass("ui-selecting"),
                        unselecting: i.hasClass("ui-unselecting")
                    })
                })
            }, this.refresh(), this._mouseInit(), this.helper = t("<div>"), this._addClass(this.helper, "ui-selectable-helper")
        },
        _destroy: function () {
            this.selectees.removeData("selectable-item"), this._mouseDestroy()
        },
        _mouseStart: function (e) {
            var i = this, n = this.options;
            this.opos = [e.pageX, e.pageY], this.elementPos = t(this.element[0]).offset(), this.options.disabled || (this.selectees = t(n.filter, this.element[0]), this._trigger("start", e), t(n.appendTo).append(this.helper), this.helper.css({
                left: e.pageX,
                top: e.pageY,
                width: 0,
                height: 0
            }), n.autoRefresh && this.refresh(), this.selectees.filter(".ui-selected").each(function () {
                var n = t.data(this, "selectable-item");
                n.startselected = !0, e.metaKey || e.ctrlKey || (i._removeClass(n.$element, "ui-selected"), n.selected = !1, i._addClass(n.$element, "ui-unselecting"), n.unselecting = !0, i._trigger("unselecting", e, {unselecting: n.element}))
            }), t(e.target).parents().addBack().each(function () {
                var n, s = t.data(this, "selectable-item");
                return s ? (n = !e.metaKey && !e.ctrlKey || !s.$element.hasClass("ui-selected"), i._removeClass(s.$element, n ? "ui-unselecting" : "ui-selected")._addClass(s.$element, n ? "ui-selecting" : "ui-unselecting"), s.unselecting = !n, s.selecting = n, s.selected = n, n ? i._trigger("selecting", e, {selecting: s.element}) : i._trigger("unselecting", e, {unselecting: s.element}), !1) : void 0
            }))
        },
        _mouseDrag: function (e) {
            if (this.dragged = !0, !this.options.disabled) {
                var i, n = this, s = this.options, r = this.opos[0], o = this.opos[1], a = e.pageX, l = e.pageY;
                return r > a && (i = a, a = r, r = i), o > l && (i = l, l = o, o = i), this.helper.css({
                    left: r,
                    top: o,
                    width: a - r,
                    height: l - o
                }), this.selectees.each(function () {
                    var i = t.data(this, "selectable-item"), c = !1, u = {};
                    i && i.element !== n.element[0] && (u.left = i.left + n.elementPos.left, u.right = i.right + n.elementPos.left, u.top = i.top + n.elementPos.top, u.bottom = i.bottom + n.elementPos.top, "touch" === s.tolerance ? c = !(u.left > a || r > u.right || u.top > l || o > u.bottom) : "fit" === s.tolerance && (c = u.left > r && a > u.right && u.top > o && l > u.bottom), c ? (i.selected && (n._removeClass(i.$element, "ui-selected"), i.selected = !1), i.unselecting && (n._removeClass(i.$element, "ui-unselecting"), i.unselecting = !1), i.selecting || (n._addClass(i.$element, "ui-selecting"), i.selecting = !0, n._trigger("selecting", e, {selecting: i.element}))) : (i.selecting && ((e.metaKey || e.ctrlKey) && i.startselected ? (n._removeClass(i.$element, "ui-selecting"), i.selecting = !1, n._addClass(i.$element, "ui-selected"), i.selected = !0) : (n._removeClass(i.$element, "ui-selecting"), i.selecting = !1, i.startselected && (n._addClass(i.$element, "ui-unselecting"), i.unselecting = !0), n._trigger("unselecting", e, {unselecting: i.element}))), i.selected && (e.metaKey || e.ctrlKey || i.startselected || (n._removeClass(i.$element, "ui-selected"), i.selected = !1, n._addClass(i.$element, "ui-unselecting"), i.unselecting = !0, n._trigger("unselecting", e, {unselecting: i.element})))))
                }), !1
            }
        },
        _mouseStop: function (e) {
            var i = this;
            return this.dragged = !1, t(".ui-unselecting", this.element[0]).each(function () {
                var n = t.data(this, "selectable-item");
                i._removeClass(n.$element, "ui-unselecting"), n.unselecting = !1, n.startselected = !1, i._trigger("unselected", e, {unselected: n.element})
            }), t(".ui-selecting", this.element[0]).each(function () {
                var n = t.data(this, "selectable-item");
                i._removeClass(n.$element, "ui-selecting")._addClass(n.$element, "ui-selected"), n.selecting = !1, n.selected = !0, n.startselected = !0, i._trigger("selected", e, {selected: n.element})
            }), this._trigger("stop", e), this.helper.remove(), !1
        }
    }), t.widget("ui.sortable", t.ui.mouse, {
        version: "1.12.1",
        widgetEventPrefix: "sort",
        ready: !1,
        options: {
            appendTo: "parent",
            axis: !1,
            connectWith: !1,
            containment: !1,
            cursor: "auto",
            cursorAt: !1,
            dropOnEmpty: !0,
            forcePlaceholderSize: !1,
            forceHelperSize: !1,
            grid: !1,
            handle: !1,
            helper: "original",
            items: "> *",
            opacity: !1,
            placeholder: !1,
            revert: !1,
            scroll: !0,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            scope: "default",
            tolerance: "intersect",
            zIndex: 1e3,
            activate: null,
            beforeStop: null,
            change: null,
            deactivate: null,
            out: null,
            over: null,
            receive: null,
            remove: null,
            sort: null,
            start: null,
            stop: null,
            update: null
        },
        _isOverAxis: function (t, e, i) {
            return t >= e && e + i > t
        },
        _isFloating: function (t) {
            return /left|right/.test(t.css("float")) || /inline|table-cell/.test(t.css("display"))
        },
        _create: function () {
            this.containerCache = {}, this._addClass("ui-sortable"), this.refresh(), this.offset = this.element.offset(), this._mouseInit(), this._setHandleClassName(), this.ready = !0
        },
        _setOption: function (t, e) {
            this._super(t, e), "handle" === t && this._setHandleClassName()
        },
        _setHandleClassName: function () {
            var e = this;
            this._removeClass(this.element.find(".ui-sortable-handle"), "ui-sortable-handle"), t.each(this.items, function () {
                e._addClass(this.instance.options.handle ? this.item.find(this.instance.options.handle) : this.item, "ui-sortable-handle")
            })
        },
        _destroy: function () {
            this._mouseDestroy();
            for (var t = this.items.length - 1; t >= 0; t--) this.items[t].item.removeData(this.widgetName + "-item");
            return this
        },
        _mouseCapture: function (e, i) {
            var n = null, s = !1, r = this;
            return !this.reverting && (!this.options.disabled && "static" !== this.options.type && (this._refreshItems(e), t(e.target).parents().each(function () {
                return t.data(this, r.widgetName + "-item") === r ? (n = t(this), !1) : void 0
            }), t.data(e.target, r.widgetName + "-item") === r && (n = t(e.target)), !!n && (!(this.options.handle && !i && (t(this.options.handle, n).find("*").addBack().each(function () {
                this === e.target && (s = !0)
            }), !s)) && (this.currentItem = n, this._removeCurrentsFromItems(), !0))))
        },
        _mouseStart: function (e, i, n) {
            var s, r, o = this.options;
            if (this.currentContainer = this, this.refreshPositions(), this.helper = this._createHelper(e), this._cacheHelperProportions(), this._cacheMargins(), this.scrollParent = this.helper.scrollParent(), this.offset = this.currentItem.offset(), this.offset = {
                top: this.offset.top - this.margins.top,
                left: this.offset.left - this.margins.left
            }, t.extend(this.offset, {
                click: {left: e.pageX - this.offset.left, top: e.pageY - this.offset.top},
                parent: this._getParentOffset(),
                relative: this._getRelativeOffset()
            }), this.helper.css("position", "absolute"), this.cssPosition = this.helper.css("position"), this.originalPosition = this._generatePosition(e), this.originalPageX = e.pageX, this.originalPageY = e.pageY, o.cursorAt && this._adjustOffsetFromHelper(o.cursorAt), this.domPosition = {
                prev: this.currentItem.prev()[0],
                parent: this.currentItem.parent()[0]
            }, this.helper[0] !== this.currentItem[0] && this.currentItem.hide(), this._createPlaceholder(), o.containment && this._setContainment(), o.cursor && "auto" !== o.cursor && (r = this.document.find("body"), this.storedCursor = r.css("cursor"), r.css("cursor", o.cursor), this.storedStylesheet = t("<style>*{ cursor: " + o.cursor + " !important; }</style>").appendTo(r)), o.opacity && (this.helper.css("opacity") && (this._storedOpacity = this.helper.css("opacity")), this.helper.css("opacity", o.opacity)), o.zIndex && (this.helper.css("zIndex") && (this._storedZIndex = this.helper.css("zIndex")), this.helper.css("zIndex", o.zIndex)), this.scrollParent[0] !== this.document[0] && "HTML" !== this.scrollParent[0].tagName && (this.overflowOffset = this.scrollParent.offset()), this._trigger("start", e, this._uiHash()), this._preserveHelperProportions || this._cacheHelperProportions(), !n) for (s = this.containers.length - 1; s >= 0; s--) this.containers[s]._trigger("activate", e, this._uiHash(this));
            return t.ui.ddmanager && (t.ui.ddmanager.current = this), t.ui.ddmanager && !o.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e), this.dragging = !0, this._addClass(this.helper, "ui-sortable-helper"), this._mouseDrag(e), !0
        },
        _mouseDrag: function (e) {
            var i, n, s, r, o = this.options, a = !1;
            for (this.position = this._generatePosition(e), this.positionAbs = this._convertPositionTo("absolute"), this.lastPositionAbs || (this.lastPositionAbs = this.positionAbs), this.options.scroll && (this.scrollParent[0] !== this.document[0] && "HTML" !== this.scrollParent[0].tagName ? (this.overflowOffset.top + this.scrollParent[0].offsetHeight - e.pageY < o.scrollSensitivity ? this.scrollParent[0].scrollTop = a = this.scrollParent[0].scrollTop + o.scrollSpeed : e.pageY - this.overflowOffset.top < o.scrollSensitivity && (this.scrollParent[0].scrollTop = a = this.scrollParent[0].scrollTop - o.scrollSpeed), this.overflowOffset.left + this.scrollParent[0].offsetWidth - e.pageX < o.scrollSensitivity ? this.scrollParent[0].scrollLeft = a = this.scrollParent[0].scrollLeft + o.scrollSpeed : e.pageX - this.overflowOffset.left < o.scrollSensitivity && (this.scrollParent[0].scrollLeft = a = this.scrollParent[0].scrollLeft - o.scrollSpeed)) : (e.pageY - this.document.scrollTop() < o.scrollSensitivity ? a = this.document.scrollTop(this.document.scrollTop() - o.scrollSpeed) : this.window.height() - (e.pageY - this.document.scrollTop()) < o.scrollSensitivity && (a = this.document.scrollTop(this.document.scrollTop() + o.scrollSpeed)), e.pageX - this.document.scrollLeft() < o.scrollSensitivity ? a = this.document.scrollLeft(this.document.scrollLeft() - o.scrollSpeed) : this.window.width() - (e.pageX - this.document.scrollLeft()) < o.scrollSensitivity && (a = this.document.scrollLeft(this.document.scrollLeft() + o.scrollSpeed))), !1 !== a && t.ui.ddmanager && !o.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e)), this.positionAbs = this._convertPositionTo("absolute"), this.options.axis && "y" === this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" === this.options.axis || (this.helper[0].style.top = this.position.top + "px"), i = this.items.length - 1; i >= 0; i--) if (n = this.items[i], s = n.item[0],
            (r = this._intersectsWithPointer(n)) && n.instance === this.currentContainer && s !== this.currentItem[0] && this.placeholder[1 === r ? "next" : "prev"]()[0] !== s && !t.contains(this.placeholder[0], s) && ("semi-dynamic" !== this.options.type || !t.contains(this.element[0], s))) {
                if (this.direction = 1 === r ? "down" : "up", "pointer" !== this.options.tolerance && !this._intersectsWithSides(n)) break;
                this._rearrange(e, n), this._trigger("change", e, this._uiHash());
                break
            }
            return this._contactContainers(e), t.ui.ddmanager && t.ui.ddmanager.drag(this, e), this._trigger("sort", e, this._uiHash()), this.lastPositionAbs = this.positionAbs, !1
        },
        _mouseStop: function (e, i) {
            if (e) {
                if (t.ui.ddmanager && !this.options.dropBehaviour && t.ui.ddmanager.drop(this, e), this.options.revert) {
                    var n = this, s = this.placeholder.offset(), r = this.options.axis, o = {};
                    r && "x" !== r || (o.left = s.left - this.offset.parent.left - this.margins.left + (this.offsetParent[0] === this.document[0].body ? 0 : this.offsetParent[0].scrollLeft)), r && "y" !== r || (o.top = s.top - this.offset.parent.top - this.margins.top + (this.offsetParent[0] === this.document[0].body ? 0 : this.offsetParent[0].scrollTop)), this.reverting = !0, t(this.helper).animate(o, parseInt(this.options.revert, 10) || 500, function () {
                        n._clear(e)
                    })
                } else this._clear(e, i);
                return !1
            }
        },
        cancel: function () {
            if (this.dragging) {
                this._mouseUp(new t.Event("mouseup", {target: null})), "original" === this.options.helper ? (this.currentItem.css(this._storedCSS), this._removeClass(this.currentItem, "ui-sortable-helper")) : this.currentItem.show();
                for (var e = this.containers.length - 1; e >= 0; e--) this.containers[e]._trigger("deactivate", null, this._uiHash(this)), this.containers[e].containerCache.over && (this.containers[e]._trigger("out", null, this._uiHash(this)), this.containers[e].containerCache.over = 0)
            }
            return this.placeholder && (this.placeholder[0].parentNode && this.placeholder[0].parentNode.removeChild(this.placeholder[0]), "original" !== this.options.helper && this.helper && this.helper[0].parentNode && this.helper.remove(), t.extend(this, {
                helper: null,
                dragging: !1,
                reverting: !1,
                _noFinalSort: null
            }), this.domPosition.prev ? t(this.domPosition.prev).after(this.currentItem) : t(this.domPosition.parent).prepend(this.currentItem)), this
        },
        serialize: function (e) {
            var i = this._getItemsAsjQuery(e && e.connected), n = [];
            return e = e || {}, t(i).each(function () {
                var i = (t(e.item || this).attr(e.attribute || "id") || "").match(e.expression || /(.+)[\-=_](.+)/);
                i && n.push((e.key || i[1] + "[]") + "=" + (e.key && e.expression ? i[1] : i[2]))
            }), !n.length && e.key && n.push(e.key + "="), n.join("&")
        },
        toArray: function (e) {
            var i = this._getItemsAsjQuery(e && e.connected), n = [];
            return e = e || {}, i.each(function () {
                n.push(t(e.item || this).attr(e.attribute || "id") || "")
            }), n
        },
        _intersectsWith: function (t) {
            var e = this.positionAbs.left, i = e + this.helperProportions.width, n = this.positionAbs.top,
                s = n + this.helperProportions.height, r = t.left, o = r + t.width, a = t.top, l = a + t.height,
                c = this.offset.click.top, u = this.offset.click.left,
                h = "x" === this.options.axis || n + c > a && l > n + c,
                d = "y" === this.options.axis || e + u > r && o > e + u, p = h && d;
            return "pointer" === this.options.tolerance || this.options.forcePointerForContainers || "pointer" !== this.options.tolerance && this.helperProportions[this.floating ? "width" : "height"] > t[this.floating ? "width" : "height"] ? p : e + this.helperProportions.width / 2 > r && o > i - this.helperProportions.width / 2 && n + this.helperProportions.height / 2 > a && l > s - this.helperProportions.height / 2
        },
        _intersectsWithPointer: function (t) {
            var e, i,
                n = "x" === this.options.axis || this._isOverAxis(this.positionAbs.top + this.offset.click.top, t.top, t.height),
                s = "y" === this.options.axis || this._isOverAxis(this.positionAbs.left + this.offset.click.left, t.left, t.width);
            return !(!n || !s) && (e = this._getDragVerticalDirection(), i = this._getDragHorizontalDirection(), this.floating ? "right" === i || "down" === e ? 2 : 1 : e && ("down" === e ? 2 : 1))
        },
        _intersectsWithSides: function (t) {
            var e = this._isOverAxis(this.positionAbs.top + this.offset.click.top, t.top + t.height / 2, t.height),
                i = this._isOverAxis(this.positionAbs.left + this.offset.click.left, t.left + t.width / 2, t.width),
                n = this._getDragVerticalDirection(), s = this._getDragHorizontalDirection();
            return this.floating && s ? "right" === s && i || "left" === s && !i : n && ("down" === n && e || "up" === n && !e)
        },
        _getDragVerticalDirection: function () {
            var t = this.positionAbs.top - this.lastPositionAbs.top;
            return 0 !== t && (t > 0 ? "down" : "up")
        },
        _getDragHorizontalDirection: function () {
            var t = this.positionAbs.left - this.lastPositionAbs.left;
            return 0 !== t && (t > 0 ? "right" : "left")
        },
        refresh: function (t) {
            return this._refreshItems(t), this._setHandleClassName(), this.refreshPositions(), this
        },
        _connectWith: function () {
            var t = this.options;
            return t.connectWith.constructor === String ? [t.connectWith] : t.connectWith
        },
        _getItemsAsjQuery: function (e) {
            function i() {
                a.push(this)
            }

            var n, s, r, o, a = [], l = [], c = this._connectWith();
            if (c && e) for (n = c.length - 1; n >= 0; n--) for (r = t(c[n], this.document[0]), s = r.length - 1; s >= 0; s--) (o = t.data(r[s], this.widgetFullName)) && o !== this && !o.options.disabled && l.push([t.isFunction(o.options.items) ? o.options.items.call(o.element) : t(o.options.items, o.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), o]);
            for (l.push([t.isFunction(this.options.items) ? this.options.items.call(this.element, null, {
                options: this.options,
                item: this.currentItem
            }) : t(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]), n = l.length - 1; n >= 0; n--) l[n][0].each(i);
            return t(a)
        },
        _removeCurrentsFromItems: function () {
            var e = this.currentItem.find(":data(" + this.widgetName + "-item)");
            this.items = t.grep(this.items, function (t) {
                for (var i = 0; e.length > i; i++) if (e[i] === t.item[0]) return !1;
                return !0
            })
        },
        _refreshItems: function (e) {
            this.items = [], this.containers = [this];
            var i, n, s, r, o, a, l, c, u = this.items,
                h = [[t.isFunction(this.options.items) ? this.options.items.call(this.element[0], e, {item: this.currentItem}) : t(this.options.items, this.element), this]],
                d = this._connectWith();
            if (d && this.ready) for (i = d.length - 1; i >= 0; i--) for (s = t(d[i], this.document[0]), n = s.length - 1; n >= 0; n--) (r = t.data(s[n], this.widgetFullName)) && r !== this && !r.options.disabled && (h.push([t.isFunction(r.options.items) ? r.options.items.call(r.element[0], e, {item: this.currentItem}) : t(r.options.items, r.element), r]), this.containers.push(r));
            for (i = h.length - 1; i >= 0; i--) for (o = h[i][1], a = h[i][0], n = 0, c = a.length; c > n; n++) l = t(a[n]), l.data(this.widgetName + "-item", o), u.push({
                item: l,
                instance: o,
                width: 0,
                height: 0,
                left: 0,
                top: 0
            })
        },
        refreshPositions: function (e) {
            this.floating = !!this.items.length && ("x" === this.options.axis || this._isFloating(this.items[0].item)), this.offsetParent && this.helper && (this.offset.parent = this._getParentOffset());
            var i, n, s, r;
            for (i = this.items.length - 1; i >= 0; i--) n = this.items[i], n.instance !== this.currentContainer && this.currentContainer && n.item[0] !== this.currentItem[0] || (s = this.options.toleranceElement ? t(this.options.toleranceElement, n.item) : n.item, e || (n.width = s.outerWidth(), n.height = s.outerHeight()), r = s.offset(), n.left = r.left, n.top = r.top);
            if (this.options.custom && this.options.custom.refreshContainers) this.options.custom.refreshContainers.call(this); else for (i = this.containers.length - 1; i >= 0; i--) r = this.containers[i].element.offset(), this.containers[i].containerCache.left = r.left, this.containers[i].containerCache.top = r.top, this.containers[i].containerCache.width = this.containers[i].element.outerWidth(), this.containers[i].containerCache.height = this.containers[i].element.outerHeight();
            return this
        },
        _createPlaceholder: function (e) {
            e = e || this;
            var i, n = e.options;
            n.placeholder && n.placeholder.constructor !== String || (i = n.placeholder, n.placeholder = {
                element: function () {
                    var n = e.currentItem[0].nodeName.toLowerCase(), s = t("<" + n + ">", e.document[0]);
                    return e._addClass(s, "ui-sortable-placeholder", i || e.currentItem[0].className)._removeClass(s, "ui-sortable-helper"), "tbody" === n ? e._createTrPlaceholder(e.currentItem.find("tr").eq(0), t("<tr>", e.document[0]).appendTo(s)) : "tr" === n ? e._createTrPlaceholder(e.currentItem, s) : "img" === n && s.attr("src", e.currentItem.attr("src")), i || s.css("visibility", "hidden"), s
                }, update: function (t, s) {
                    (!i || n.forcePlaceholderSize) && (s.height() || s.height(e.currentItem.innerHeight() - parseInt(e.currentItem.css("paddingTop") || 0, 10) - parseInt(e.currentItem.css("paddingBottom") || 0, 10)), s.width() || s.width(e.currentItem.innerWidth() - parseInt(e.currentItem.css("paddingLeft") || 0, 10) - parseInt(e.currentItem.css("paddingRight") || 0, 10)))
                }
            }), e.placeholder = t(n.placeholder.element.call(e.element, e.currentItem)), e.currentItem.after(e.placeholder), n.placeholder.update(e, e.placeholder)
        },
        _createTrPlaceholder: function (e, i) {
            var n = this;
            e.children().each(function () {
                t("<td>&#160;</td>", n.document[0]).attr("colspan", t(this).attr("colspan") || 1).appendTo(i)
            })
        },
        _contactContainers: function (e) {
            var i, n, s, r, o, a, l, c, u, h, d = null, p = null;
            for (i = this.containers.length - 1; i >= 0; i--) if (!t.contains(this.currentItem[0], this.containers[i].element[0])) if (this._intersectsWith(this.containers[i].containerCache)) {
                if (d && t.contains(this.containers[i].element[0], d.element[0])) continue;
                d = this.containers[i], p = i
            } else this.containers[i].containerCache.over && (this.containers[i]._trigger("out", e, this._uiHash(this)), this.containers[i].containerCache.over = 0);
            if (d) if (1 === this.containers.length) this.containers[p].containerCache.over || (this.containers[p]._trigger("over", e, this._uiHash(this)), this.containers[p].containerCache.over = 1); else {
                for (s = 1e4, r = null, u = d.floating || this._isFloating(this.currentItem), o = u ? "left" : "top", a = u ? "width" : "height", h = u ? "pageX" : "pageY", n = this.items.length - 1; n >= 0; n--) t.contains(this.containers[p].element[0], this.items[n].item[0]) && this.items[n].item[0] !== this.currentItem[0] && (l = this.items[n].item.offset()[o], c = !1, e[h] - l > this.items[n][a] / 2 && (c = !0), s > Math.abs(e[h] - l) && (s = Math.abs(e[h] - l), r = this.items[n], this.direction = c ? "up" : "down"));
                if (!r && !this.options.dropOnEmpty) return;
                if (this.currentContainer === this.containers[p]) return void(this.currentContainer.containerCache.over || (this.containers[p]._trigger("over", e, this._uiHash()), this.currentContainer.containerCache.over = 1));
                r ? this._rearrange(e, r, null, !0) : this._rearrange(e, null, this.containers[p].element, !0), this._trigger("change", e, this._uiHash()), this.containers[p]._trigger("change", e, this._uiHash(this)), this.currentContainer = this.containers[p], this.options.placeholder.update(this.currentContainer, this.placeholder), this.containers[p]._trigger("over", e, this._uiHash(this)), this.containers[p].containerCache.over = 1
            }
        },
        _createHelper: function (e) {
            var i = this.options,
                n = t.isFunction(i.helper) ? t(i.helper.apply(this.element[0], [e, this.currentItem])) : "clone" === i.helper ? this.currentItem.clone() : this.currentItem;
            return n.parents("body").length || t("parent" !== i.appendTo ? i.appendTo : this.currentItem[0].parentNode)[0].appendChild(n[0]), n[0] === this.currentItem[0] && (this._storedCSS = {
                width: this.currentItem[0].style.width,
                height: this.currentItem[0].style.height,
                position: this.currentItem.css("position"),
                top: this.currentItem.css("top"),
                left: this.currentItem.css("left")
            }), (!n[0].style.width || i.forceHelperSize) && n.width(this.currentItem.width()), (!n[0].style.height || i.forceHelperSize) && n.height(this.currentItem.height()), n
        },
        _adjustOffsetFromHelper: function (e) {
            "string" == typeof e && (e = e.split(" ")), t.isArray(e) && (e = {
                left: +e[0],
                top: +e[1] || 0
            }), "left" in e && (this.offset.click.left = e.left + this.margins.left), "right" in e && (this.offset.click.left = this.helperProportions.width - e.right + this.margins.left), "top" in e && (this.offset.click.top = e.top + this.margins.top), "bottom" in e && (this.offset.click.top = this.helperProportions.height - e.bottom + this.margins.top)
        },
        _getParentOffset: function () {
            this.offsetParent = this.helper.offsetParent();
            var e = this.offsetParent.offset();
            return "absolute" === this.cssPosition && this.scrollParent[0] !== this.document[0] && t.contains(this.scrollParent[0], this.offsetParent[0]) && (e.left += this.scrollParent.scrollLeft(), e.top += this.scrollParent.scrollTop()), (this.offsetParent[0] === this.document[0].body || this.offsetParent[0].tagName && "html" === this.offsetParent[0].tagName.toLowerCase() && t.ui.ie) && (e = {
                top: 0,
                left: 0
            }), {
                top: e.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: e.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function () {
            if ("relative" === this.cssPosition) {
                var t = this.currentItem.position();
                return {
                    top: t.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                    left: t.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                }
            }
            return {top: 0, left: 0}
        },
        _cacheMargins: function () {
            this.margins = {
                left: parseInt(this.currentItem.css("marginLeft"), 10) || 0,
                top: parseInt(this.currentItem.css("marginTop"), 10) || 0
            }
        },
        _cacheHelperProportions: function () {
            this.helperProportions = {width: this.helper.outerWidth(), height: this.helper.outerHeight()}
        },
        _setContainment: function () {
            var e, i, n, s = this.options;
            "parent" === s.containment && (s.containment = this.helper[0].parentNode), ("document" === s.containment || "window" === s.containment) && (this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, "document" === s.containment ? this.document.width() : this.window.width() - this.helperProportions.width - this.margins.left, ("document" === s.containment ? this.document.height() || document.body.parentNode.scrollHeight : this.window.height() || this.document[0].body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]), /^(document|window|parent)$/.test(s.containment) || (e = t(s.containment)[0], i = t(s.containment).offset(), n = "hidden" !== t(e).css("overflow"), this.containment = [i.left + (parseInt(t(e).css("borderLeftWidth"), 10) || 0) + (parseInt(t(e).css("paddingLeft"), 10) || 0) - this.margins.left, i.top + (parseInt(t(e).css("borderTopWidth"), 10) || 0) + (parseInt(t(e).css("paddingTop"), 10) || 0) - this.margins.top, i.left + (n ? Math.max(e.scrollWidth, e.offsetWidth) : e.offsetWidth) - (parseInt(t(e).css("borderLeftWidth"), 10) || 0) - (parseInt(t(e).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, i.top + (n ? Math.max(e.scrollHeight, e.offsetHeight) : e.offsetHeight) - (parseInt(t(e).css("borderTopWidth"), 10) || 0) - (parseInt(t(e).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top])
        },
        _convertPositionTo: function (e, i) {
            i || (i = this.position);
            var n = "absolute" === e ? 1 : -1,
                s = "absolute" !== this.cssPosition || this.scrollParent[0] !== this.document[0] && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                r = /(html|body)/i.test(s[0].tagName);
            return {
                top: i.top + this.offset.relative.top * n + this.offset.parent.top * n - ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : r ? 0 : s.scrollTop()) * n,
                left: i.left + this.offset.relative.left * n + this.offset.parent.left * n - ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : r ? 0 : s.scrollLeft()) * n
            }
        },
        _generatePosition: function (e) {
            var i, n, s = this.options, r = e.pageX, o = e.pageY,
                a = "absolute" !== this.cssPosition || this.scrollParent[0] !== this.document[0] && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                l = /(html|body)/i.test(a[0].tagName);
            return "relative" !== this.cssPosition || this.scrollParent[0] !== this.document[0] && this.scrollParent[0] !== this.offsetParent[0] || (this.offset.relative = this._getRelativeOffset()), this.originalPosition && (this.containment && (e.pageX - this.offset.click.left < this.containment[0] && (r = this.containment[0] + this.offset.click.left), e.pageY - this.offset.click.top < this.containment[1] && (o = this.containment[1] + this.offset.click.top), e.pageX - this.offset.click.left > this.containment[2] && (r = this.containment[2] + this.offset.click.left), e.pageY - this.offset.click.top > this.containment[3] && (o = this.containment[3] + this.offset.click.top)), s.grid && (i = this.originalPageY + Math.round((o - this.originalPageY) / s.grid[1]) * s.grid[1], o = this.containment ? i - this.offset.click.top >= this.containment[1] && i - this.offset.click.top <= this.containment[3] ? i : i - this.offset.click.top >= this.containment[1] ? i - s.grid[1] : i + s.grid[1] : i, n = this.originalPageX + Math.round((r - this.originalPageX) / s.grid[0]) * s.grid[0], r = this.containment ? n - this.offset.click.left >= this.containment[0] && n - this.offset.click.left <= this.containment[2] ? n : n - this.offset.click.left >= this.containment[0] ? n - s.grid[0] : n + s.grid[0] : n)), {
                top: o - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : l ? 0 : a.scrollTop()),
                left: r - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : l ? 0 : a.scrollLeft())
            }
        },
        _rearrange: function (t, e, i, n) {
            i ? i[0].appendChild(this.placeholder[0]) : e.item[0].parentNode.insertBefore(this.placeholder[0], "down" === this.direction ? e.item[0] : e.item[0].nextSibling), this.counter = this.counter ? ++this.counter : 1;
            var s = this.counter;
            this._delay(function () {
                s === this.counter && this.refreshPositions(!n)
            })
        },
        _clear: function (t, e) {
            function i(t, e, i) {
                return function (n) {
                    i._trigger(t, n, e._uiHash(e))
                }
            }

            this.reverting = !1;
            var n, s = [];
            if (!this._noFinalSort && this.currentItem.parent().length && this.placeholder.before(this.currentItem), this._noFinalSort = null, this.helper[0] === this.currentItem[0]) {
                for (n in this._storedCSS) ("auto" === this._storedCSS[n] || "static" === this._storedCSS[n]) && (this._storedCSS[n] = "");
                this.currentItem.css(this._storedCSS), this._removeClass(this.currentItem, "ui-sortable-helper")
            } else this.currentItem.show();
            for (this.fromOutside && !e && s.push(function (t) {
                this._trigger("receive", t, this._uiHash(this.fromOutside))
            }), !this.fromOutside && this.domPosition.prev === this.currentItem.prev().not(".ui-sortable-helper")[0] && this.domPosition.parent === this.currentItem.parent()[0] || e || s.push(function (t) {
                this._trigger("update", t, this._uiHash())
            }), this !== this.currentContainer && (e || (s.push(function (t) {
                this._trigger("remove", t, this._uiHash())
            }), s.push(function (t) {
                return function (e) {
                    t._trigger("receive", e, this._uiHash(this))
                }
            }.call(this, this.currentContainer)), s.push(function (t) {
                return function (e) {
                    t._trigger("update", e, this._uiHash(this))
                }
            }.call(this, this.currentContainer)))), n = this.containers.length - 1; n >= 0; n--) e || s.push(i("deactivate", this, this.containers[n])), this.containers[n].containerCache.over && (s.push(i("out", this, this.containers[n])), this.containers[n].containerCache.over = 0);
            if (this.storedCursor && (this.document.find("body").css("cursor", this.storedCursor), this.storedStylesheet.remove()), this._storedOpacity && this.helper.css("opacity", this._storedOpacity), this._storedZIndex && this.helper.css("zIndex", "auto" === this._storedZIndex ? "" : this._storedZIndex), this.dragging = !1, e || this._trigger("beforeStop", t, this._uiHash()), this.placeholder[0].parentNode.removeChild(this.placeholder[0]), this.cancelHelperRemoval || (this.helper[0] !== this.currentItem[0] && this.helper.remove(), this.helper = null), !e) {
                for (n = 0; s.length > n; n++) s[n].call(this, t);
                this._trigger("stop", t, this._uiHash())
            }
            return this.fromOutside = !1, !this.cancelHelperRemoval
        },
        _trigger: function () {
            !1 === t.Widget.prototype._trigger.apply(this, arguments) && this.cancel()
        },
        _uiHash: function (e) {
            var i = e || this;
            return {
                helper: i.helper,
                placeholder: i.placeholder || t([]),
                position: i.position,
                originalPosition: i.originalPosition,
                offset: i.positionAbs,
                item: i.currentItem,
                sender: e ? e.element : null
            }
        }
    })
}), "undefined" == typeof jQuery) throw new Error("Bootstrap's JavaScript requires jQuery");
if (function (t) {
    "use strict";
    var e = t.fn.jquery.split(" ")[0].split(".");
    if (e[0] < 2 && e[1] < 9 || 1 == e[0] && 9 == e[1] && e[2] < 1 || e[0] > 3) throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4")
}(jQuery), function (t) {
    "use strict";

    function e() {
        var t = document.createElement("bootstrap"), e = {
            WebkitTransition: "webkitTransitionEnd",
            MozTransition: "transitionend",
            OTransition: "oTransitionEnd otransitionend",
            transition: "transitionend"
        };
        for (var i in e) if (void 0 !== t.style[i]) return {end: e[i]};
        return !1
    }

    t.fn.emulateTransitionEnd = function (e) {
        var i = !1, n = this;
        t(this).one("bsTransitionEnd", function () {
            i = !0
        });
        var s = function () {
            i || t(n).trigger(t.support.transition.end)
        };
        return setTimeout(s, e), this
    }, t(function () {
        t.support.transition = e(), t.support.transition && (t.event.special.bsTransitionEnd = {
            bindType: t.support.transition.end,
            delegateType: t.support.transition.end,
            handle: function (e) {
                if (t(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
            }
        })
    })
}(jQuery), function (t) {
    "use strict";

    function e(e) {
        return this.each(function () {
            var i = t(this), s = i.data("bs.alert");
            s || i.data("bs.alert", s = new n(this)), "string" == typeof e && s[e].call(i)
        })
    }

    var i = '[data-dismiss="alert"]', n = function (e) {
        t(e).on("click", i, this.close)
    };
    n.VERSION = "3.3.7", n.TRANSITION_DURATION = 150, n.prototype.close = function (e) {
        function i() {
            o.detach().trigger("closed.bs.alert").remove()
        }

        var s = t(this), r = s.attr("data-target");
        r || (r = s.attr("href"), r = r && r.replace(/.*(?=#[^\s]*$)/, ""));
        var o = t("#" === r ? [] : r);
        e && e.preventDefault(), o.length || (o = s.closest(".alert")), o.trigger(e = t.Event("close.bs.alert")), e.isDefaultPrevented() || (o.removeClass("in"), t.support.transition && o.hasClass("fade") ? o.one("bsTransitionEnd", i).emulateTransitionEnd(n.TRANSITION_DURATION) : i())
    };
    var s = t.fn.alert;
    t.fn.alert = e, t.fn.alert.Constructor = n, t.fn.alert.noConflict = function () {
        return t.fn.alert = s, this
    }, t(document).on("click.bs.alert.data-api", i, n.prototype.close)
}(jQuery), function (t) {
    "use strict";

    function e(e) {
        return this.each(function () {
            var n = t(this), s = n.data("bs.button"), r = "object" == typeof e && e;
            s || n.data("bs.button", s = new i(this, r)), "toggle" == e ? s.toggle() : e && s.setState(e)
        })
    }

    var i = function (e, n) {
        this.$element = t(e), this.options = t.extend({}, i.DEFAULTS, n), this.isLoading = !1
    };
    i.VERSION = "3.3.7", i.DEFAULTS = {loadingText: "loading..."}, i.prototype.setState = function (e) {
        var i = "disabled", n = this.$element, s = n.is("input") ? "val" : "html", r = n.data();
        e += "Text", null == r.resetText && n.data("resetText", n[s]()), setTimeout(t.proxy(function () {
            n[s](null == r[e] ? this.options[e] : r[e]), "loadingText" == e ? (this.isLoading = !0, n.addClass(i).attr(i, i).prop(i, !0)) : this.isLoading && (this.isLoading = !1, n.removeClass(i).removeAttr(i).prop(i, !1))
        }, this), 0)
    }, i.prototype.toggle = function () {
        var t = !0, e = this.$element.closest('[data-toggle="buttons"]');
        if (e.length) {
            var i = this.$element.find("input");
            "radio" == i.prop("type") ? (i.prop("checked") && (t = !1), e.find(".active").removeClass("active"), this.$element.addClass("active")) : "checkbox" == i.prop("type") && (i.prop("checked") !== this.$element.hasClass("active") && (t = !1), this.$element.toggleClass("active")), i.prop("checked", this.$element.hasClass("active")), t && i.trigger("change")
        } else this.$element.attr("aria-pressed", !this.$element.hasClass("active")), this.$element.toggleClass("active")
    };
    var n = t.fn.button;
    t.fn.button = e, t.fn.button.Constructor = i, t.fn.button.noConflict = function () {
        return t.fn.button = n, this
    }, t(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function (i) {
        var n = t(i.target).closest(".btn");
        e.call(n, "toggle"), t(i.target).is('input[type="radio"], input[type="checkbox"]') || (i.preventDefault(), n.is("input,button") ? n.trigger("focus") : n.find("input:visible,button:visible").first().trigger("focus"))
    }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function (e) {
        t(e.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(e.type))
    })
}(jQuery), function (t) {
    "use strict";

    function e(e) {
        return this.each(function () {
            var n = t(this), s = n.data("bs.carousel"),
                r = t.extend({}, i.DEFAULTS, n.data(), "object" == typeof e && e),
                o = "string" == typeof e ? e : r.slide;
            s || n.data("bs.carousel", s = new i(this, r)), "number" == typeof e ? s.to(e) : o ? s[o]() : r.interval && s.pause().cycle()
        })
    }

    var i = function (e, i) {
        this.$element = t(e), this.$indicators = this.$element.find(".carousel-indicators"), this.options = i, this.paused = null, this.sliding = null, this.interval = null, this.$active = null, this.$items = null, this.options.keyboard && this.$element.on("keydown.bs.carousel", t.proxy(this.keydown, this)), "hover" == this.options.pause && !("ontouchstart" in document.documentElement) && this.$element.on("mouseenter.bs.carousel", t.proxy(this.pause, this)).on("mouseleave.bs.carousel", t.proxy(this.cycle, this))
    };
    i.VERSION = "3.3.7", i.TRANSITION_DURATION = 600, i.DEFAULTS = {
        interval: 5e3,
        pause: "hover",
        wrap: !0,
        keyboard: !0
    }, i.prototype.keydown = function (t) {
        if (!/input|textarea/i.test(t.target.tagName)) {
            switch (t.which) {
                case 37:
                    this.prev();
                    break;
                case 39:
                    this.next();
                    break;
                default:
                    return
            }
            t.preventDefault()
        }
    }, i.prototype.cycle = function (e) {
        return e || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(t.proxy(this.next, this), this.options.interval)), this
    }, i.prototype.getItemIndex = function (t) {
        return this.$items = t.parent().children(".item"), this.$items.index(t || this.$active)
    }, i.prototype.getItemForDirection = function (t, e) {
        var i = this.getItemIndex(e);
        if (("prev" == t && 0 === i || "next" == t && i == this.$items.length - 1) && !this.options.wrap) return e;
        var n = "prev" == t ? -1 : 1, s = (i + n) % this.$items.length;
        return this.$items.eq(s)
    }, i.prototype.to = function (t) {
        var e = this, i = this.getItemIndex(this.$active = this.$element.find(".item.active"));
        if (!(t > this.$items.length - 1 || t < 0)) return this.sliding ? this.$element.one("slid.bs.carousel", function () {
            e.to(t)
        }) : i == t ? this.pause().cycle() : this.slide(t > i ? "next" : "prev", this.$items.eq(t))
    }, i.prototype.pause = function (e) {
        return e || (this.paused = !0), this.$element.find(".next, .prev").length && t.support.transition && (this.$element.trigger(t.support.transition.end), this.cycle(!0)), this.interval = clearInterval(this.interval), this
    }, i.prototype.next = function () {
        if (!this.sliding) return this.slide("next")
    }, i.prototype.prev = function () {
        if (!this.sliding) return this.slide("prev")
    }, i.prototype.slide = function (e, n) {
        var s = this.$element.find(".item.active"), r = n || this.getItemForDirection(e, s), o = this.interval,
            a = "next" == e ? "left" : "right", l = this;
        if (r.hasClass("active")) return this.sliding = !1;
        var c = r[0], u = t.Event("slide.bs.carousel", {relatedTarget: c, direction: a});
        if (this.$element.trigger(u), !u.isDefaultPrevented()) {
            if (this.sliding = !0, o && this.pause(), this.$indicators.length) {
                this.$indicators.find(".active").removeClass("active");
                var h = t(this.$indicators.children()[this.getItemIndex(r)]);
                h && h.addClass("active")
            }
            var d = t.Event("slid.bs.carousel", {relatedTarget: c, direction: a});
            return t.support.transition && this.$element.hasClass("slide") ? (r.addClass(e), r[0].offsetWidth, s.addClass(a), r.addClass(a), s.one("bsTransitionEnd", function () {
                r.removeClass([e, a].join(" ")).addClass("active"), s.removeClass(["active", a].join(" ")), l.sliding = !1, setTimeout(function () {
                    l.$element.trigger(d)
                }, 0)
            }).emulateTransitionEnd(i.TRANSITION_DURATION)) : (s.removeClass("active"), r.addClass("active"), this.sliding = !1, this.$element.trigger(d)), o && this.cycle(), this
        }
    };
    var n = t.fn.carousel;
    t.fn.carousel = e, t.fn.carousel.Constructor = i, t.fn.carousel.noConflict = function () {
        return t.fn.carousel = n, this
    };
    var s = function (i) {
        var n, s = t(this), r = t(s.attr("data-target") || (n = s.attr("href")) && n.replace(/.*(?=#[^\s]+$)/, ""));
        if (r.hasClass("carousel")) {
            var o = t.extend({}, r.data(), s.data()), a = s.attr("data-slide-to");
            a && (o.interval = !1), e.call(r, o), a && r.data("bs.carousel").to(a), i.preventDefault()
        }
    };
    t(document).on("click.bs.carousel.data-api", "[data-slide]", s).on("click.bs.carousel.data-api", "[data-slide-to]", s), t(window).on("load", function () {
        t('[data-ride="carousel"]').each(function () {
            var i = t(this);
            e.call(i, i.data())
        })
    })
}(jQuery), function (t) {
    "use strict";

    function e(e) {
        var i, n = e.attr("data-target") || (i = e.attr("href")) && i.replace(/.*(?=#[^\s]+$)/, "");
        return t(n)
    }

    function i(e) {
        return this.each(function () {
            var i = t(this), s = i.data("bs.collapse"),
                r = t.extend({}, n.DEFAULTS, i.data(), "object" == typeof e && e);
            !s && r.toggle && /show|hide/.test(e) && (r.toggle = !1), s || i.data("bs.collapse", s = new n(this, r)), "string" == typeof e && s[e]()
        })
    }

    var n = function (e, i) {
        this.$element = t(e), this.options = t.extend({}, n.DEFAULTS, i), this.$trigger = t('[data-toggle="collapse"][href="#' + e.id + '"],[data-toggle="collapse"][data-target="#' + e.id + '"]'), this.transitioning = null, this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger), this.options.toggle && this.toggle()
    };
    n.VERSION = "3.3.7", n.TRANSITION_DURATION = 350, n.DEFAULTS = {toggle: !0}, n.prototype.dimension = function () {
        return this.$element.hasClass("width") ? "width" : "height"
    }, n.prototype.show = function () {
        if (!this.transitioning && !this.$element.hasClass("in")) {
            var e, s = this.$parent && this.$parent.children(".panel").children(".in, .collapsing");
            if (!(s && s.length && (e = s.data("bs.collapse")) && e.transitioning)) {
                var r = t.Event("show.bs.collapse");
                if (this.$element.trigger(r), !r.isDefaultPrevented()) {
                    s && s.length && (i.call(s, "hide"), e || s.data("bs.collapse", null));
                    var o = this.dimension();
                    this.$element.removeClass("collapse").addClass("collapsing")[o](0).attr("aria-expanded", !0), this.$trigger.removeClass("collapsed").attr("aria-expanded", !0), this.transitioning = 1;
                    var a = function () {
                        this.$element.removeClass("collapsing").addClass("collapse in")[o](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse")
                    };
                    if (!t.support.transition) return a.call(this);
                    var l = t.camelCase(["scroll", o].join("-"));
                    this.$element.one("bsTransitionEnd", t.proxy(a, this)).emulateTransitionEnd(n.TRANSITION_DURATION)[o](this.$element[0][l])
                }
            }
        }
    }, n.prototype.hide = function () {
        if (!this.transitioning && this.$element.hasClass("in")) {
            var e = t.Event("hide.bs.collapse");
            if (this.$element.trigger(e), !e.isDefaultPrevented()) {
                var i = this.dimension();
                this.$element[i](this.$element[i]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1), this.$trigger.addClass("collapsed").attr("aria-expanded", !1), this.transitioning = 1;
                var s = function () {
                    this.transitioning = 0, this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")
                };
                return t.support.transition ? void this.$element[i](0).one("bsTransitionEnd", t.proxy(s, this)).emulateTransitionEnd(n.TRANSITION_DURATION) : s.call(this)
            }
        }
    }, n.prototype.toggle = function () {
        this[this.$element.hasClass("in") ? "hide" : "show"]()
    }, n.prototype.getParent = function () {
        return t(this.options.parent).find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]').each(t.proxy(function (i, n) {
            var s = t(n);
            this.addAriaAndCollapsedClass(e(s), s)
        }, this)).end()
    }, n.prototype.addAriaAndCollapsedClass = function (t, e) {
        var i = t.hasClass("in");
        t.attr("aria-expanded", i), e.toggleClass("collapsed", !i).attr("aria-expanded", i)
    };
    var s = t.fn.collapse;
    t.fn.collapse = i, t.fn.collapse.Constructor = n, t.fn.collapse.noConflict = function () {
        return t.fn.collapse = s, this
    }, t(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function (n) {
        var s = t(this);
        s.attr("data-target") || n.preventDefault();
        var r = e(s), o = r.data("bs.collapse"), a = o ? "toggle" : s.data();
        i.call(r, a)
    })
}(jQuery), function (t) {
    "use strict";

    function e(e) {
        var i = e.attr("data-target");
        i || (i = e.attr("href"), i = i && /#[A-Za-z]/.test(i) && i.replace(/.*(?=#[^\s]*$)/, ""));
        var n = i && t(i);
        return n && n.length ? n : e.parent()
    }

    function i(i) {
        i && 3 === i.which || (t(s).remove(), t(r).each(function () {
            var n = t(this), s = e(n), r = {relatedTarget: this};
            s.hasClass("open") && (i && "click" == i.type && /input|textarea/i.test(i.target.tagName) && t.contains(s[0], i.target) || (s.trigger(i = t.Event("hide.bs.dropdown", r)), i.isDefaultPrevented() || (n.attr("aria-expanded", "false"), s.removeClass("open").trigger(t.Event("hidden.bs.dropdown", r)))))
        }))
    }

    function n(e) {
        return this.each(function () {
            var i = t(this), n = i.data("bs.dropdown");
            n || i.data("bs.dropdown", n = new o(this)), "string" == typeof e && n[e].call(i)
        })
    }

    var s = ".dropdown-backdrop", r = '[data-toggle="dropdown"]', o = function (e) {
        t(e).on("click.bs.dropdown", this.toggle)
    };
    o.VERSION = "3.3.7", o.prototype.toggle = function (n) {
        var s = t(this);
        if (!s.is(".disabled, :disabled")) {
            var r = e(s), o = r.hasClass("open");
            if (i(), !o) {
                "ontouchstart" in document.documentElement && !r.closest(".navbar-nav").length && t(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(t(this)).on("click", i);
                var a = {relatedTarget: this};
                if (r.trigger(n = t.Event("show.bs.dropdown", a)), n.isDefaultPrevented()) return;
                s.trigger("focus").attr("aria-expanded", "true"), r.toggleClass("open").trigger(t.Event("shown.bs.dropdown", a))
            }
            return !1
        }
    }, o.prototype.keydown = function (i) {
        if (/(38|40|27|32)/.test(i.which) && !/input|textarea/i.test(i.target.tagName)) {
            var n = t(this);
            if (i.preventDefault(), i.stopPropagation(), !n.is(".disabled, :disabled")) {
                var s = e(n), o = s.hasClass("open");
                if (!o && 27 != i.which || o && 27 == i.which) return 27 == i.which && s.find(r).trigger("focus"), n.trigger("click");
                var a = s.find(".dropdown-menu li:not(.disabled):visible a");
                if (a.length) {
                    var l = a.index(i.target);
                    38 == i.which && l > 0 && l--, 40 == i.which && l < a.length - 1 && l++, ~l || (l = 0), a.eq(l).trigger("focus")
                }
            }
        }
    };
    var a = t.fn.dropdown;
    t.fn.dropdown = n, t.fn.dropdown.Constructor = o, t.fn.dropdown.noConflict = function () {
        return t.fn.dropdown = a, this
    }, t(document).on("click.bs.dropdown.data-api", i).on("click.bs.dropdown.data-api", ".dropdown form", function (t) {
        t.stopPropagation()
    }).on("click.bs.dropdown.data-api", r, o.prototype.toggle).on("keydown.bs.dropdown.data-api", r, o.prototype.keydown).on("keydown.bs.dropdown.data-api", ".dropdown-menu", o.prototype.keydown)
}(jQuery), function (t) {
    "use strict";

    function e(e, n) {
        return this.each(function () {
            var s = t(this), r = s.data("bs.modal"), o = t.extend({}, i.DEFAULTS, s.data(), "object" == typeof e && e);
            r || s.data("bs.modal", r = new i(this, o)), "string" == typeof e ? r[e](n) : o.show && r.show(n)
        })
    }

    var i = function (e, i) {
        this.options = i, this.$body = t(document.body), this.$element = t(e), this.$dialog = this.$element.find(".modal-dialog"), this.$backdrop = null, this.isShown = null, this.originalBodyPad = null, this.scrollbarWidth = 0, this.ignoreBackdropClick = !1, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, t.proxy(function () {
            this.$element.trigger("loaded.bs.modal")
        }, this))
    };
    i.VERSION = "3.3.7", i.TRANSITION_DURATION = 300, i.BACKDROP_TRANSITION_DURATION = 150, i.DEFAULTS = {
        backdrop: !0,
        keyboard: !0,
        show: !0
    }, i.prototype.toggle = function (t) {
        return this.isShown ? this.hide() : this.show(t)
    }, i.prototype.show = function (e) {
        var n = this, s = t.Event("show.bs.modal", {relatedTarget: e});
        this.$element.trigger(s), this.isShown || s.isDefaultPrevented() || (this.isShown = !0, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("modal-open"), this.escape(), this.resize(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', t.proxy(this.hide, this)), this.$dialog.on("mousedown.dismiss.bs.modal", function () {
            n.$element.one("mouseup.dismiss.bs.modal", function (e) {
                t(e.target).is(n.$element) && (n.ignoreBackdropClick = !0)
            })
        }), this.backdrop(function () {
            var s = t.support.transition && n.$element.hasClass("fade");
            n.$element.parent().length || n.$element.appendTo(n.$body), n.$element.show().scrollTop(0), n.adjustDialog(), s && n.$element[0].offsetWidth, n.$element.addClass("in"), n.enforceFocus();
            var r = t.Event("shown.bs.modal", {relatedTarget: e});
            s ? n.$dialog.one("bsTransitionEnd", function () {
                n.$element.trigger("focus").trigger(r)
            }).emulateTransitionEnd(i.TRANSITION_DURATION) : n.$element.trigger("focus").trigger(r)
        }))
    }, i.prototype.hide = function (e) {
        e && e.preventDefault(), e = t.Event("hide.bs.modal"), this.$element.trigger(e), this.isShown && !e.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.resize(), t(document).off("focusin.bs.modal"), this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"), this.$dialog.off("mousedown.dismiss.bs.modal"), t.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", t.proxy(this.hideModal, this)).emulateTransitionEnd(i.TRANSITION_DURATION) : this.hideModal())
    }, i.prototype.enforceFocus = function () {
        t(document).off("focusin.bs.modal").on("focusin.bs.modal", t.proxy(function (t) {
            document === t.target || this.$element[0] === t.target || this.$element.has(t.target).length || this.$element.trigger("focus")
        }, this))
    }, i.prototype.escape = function () {
        this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", t.proxy(function (t) {
            27 == t.which && this.hide()
        }, this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal")
    }, i.prototype.resize = function () {
        this.isShown ? t(window).on("resize.bs.modal", t.proxy(this.handleUpdate, this)) : t(window).off("resize.bs.modal")
    }, i.prototype.hideModal = function () {
        var t = this;
        this.$element.hide(), this.backdrop(function () {
            t.$body.removeClass("modal-open"), t.resetAdjustments(), t.resetScrollbar(), t.$element.trigger("hidden.bs.modal")
        })
    }, i.prototype.removeBackdrop = function () {
        this.$backdrop && this.$backdrop.remove(), this.$backdrop = null
    }, i.prototype.backdrop = function (e) {
        var n = this, s = this.$element.hasClass("fade") ? "fade" : "";
        if (this.isShown && this.options.backdrop) {
            var r = t.support.transition && s;
            if (this.$backdrop = t(document.createElement("div")).addClass("modal-backdrop " + s).appendTo(this.$body), this.$element.on("click.dismiss.bs.modal", t.proxy(function (t) {
                return this.ignoreBackdropClick ? void(this.ignoreBackdropClick = !1) : void(t.target === t.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus() : this.hide()))
            }, this)), r && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !e) return;
            r ? this.$backdrop.one("bsTransitionEnd", e).emulateTransitionEnd(i.BACKDROP_TRANSITION_DURATION) : e()
        } else if (!this.isShown && this.$backdrop) {
            this.$backdrop.removeClass("in");
            var o = function () {
                n.removeBackdrop(), e && e()
            };
            t.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", o).emulateTransitionEnd(i.BACKDROP_TRANSITION_DURATION) : o()
        } else e && e()
    }, i.prototype.handleUpdate = function () {
        this.adjustDialog()
    }, i.prototype.adjustDialog = function () {
        var t = this.$element[0].scrollHeight > document.documentElement.clientHeight;
        this.$element.css({
            paddingLeft: !this.bodyIsOverflowing && t ? this.scrollbarWidth : "",
            paddingRight: this.bodyIsOverflowing && !t ? this.scrollbarWidth : ""
        })
    }, i.prototype.resetAdjustments = function () {
        this.$element.css({paddingLeft: "", paddingRight: ""})
    }, i.prototype.checkScrollbar = function () {
        var t = window.innerWidth;
        if (!t) {
            var e = document.documentElement.getBoundingClientRect();
            t = e.right - Math.abs(e.left)
        }
        this.bodyIsOverflowing = document.body.clientWidth < t, this.scrollbarWidth = this.measureScrollbar()
    }, i.prototype.setScrollbar = function () {
        var t = parseInt(this.$body.css("padding-right") || 0, 10);
        this.originalBodyPad = document.body.style.paddingRight || "", this.bodyIsOverflowing && this.$body.css("padding-right", t + this.scrollbarWidth)
    }, i.prototype.resetScrollbar = function () {
        this.$body.css("padding-right", this.originalBodyPad)
    }, i.prototype.measureScrollbar = function () {
        var t = document.createElement("div");
        t.className = "modal-scrollbar-measure", this.$body.append(t);
        var e = t.offsetWidth - t.clientWidth;
        return this.$body[0].removeChild(t), e
    };
    var n = t.fn.modal;
    t.fn.modal = e, t.fn.modal.Constructor = i, t.fn.modal.noConflict = function () {
        return t.fn.modal = n, this
    }, t(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function (i) {
        var n = t(this), s = n.attr("href"), r = t(n.attr("data-target") || s && s.replace(/.*(?=#[^\s]+$)/, "")),
            o = r.data("bs.modal") ? "toggle" : t.extend({remote: !/#/.test(s) && s}, r.data(), n.data());
        n.is("a") && i.preventDefault(), r.one("show.bs.modal", function (t) {
            t.isDefaultPrevented() || r.one("hidden.bs.modal", function () {
                n.is(":visible") && n.trigger("focus")
            })
        }), e.call(r, o, this)
    })
}(jQuery), function (t) {
    "use strict";

    function e(e) {
        return this.each(function () {
            var n = t(this), s = n.data("bs.tooltip"), r = "object" == typeof e && e;
            !s && /destroy|hide/.test(e) || (s || n.data("bs.tooltip", s = new i(this, r)), "string" == typeof e && s[e]())
        })
    }

    var i = function (t, e) {
        this.type = null, this.options = null, this.enabled = null, this.timeout = null, this.hoverState = null, this.$element = null, this.inState = null, this.init("tooltip", t, e)
    };
    i.VERSION = "3.3.7", i.TRANSITION_DURATION = 150, i.DEFAULTS = {
        animation: !0,
        placement: "top",
        selector: !1,
        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: "hover focus",
        title: "",
        delay: 0,
        html: !1,
        container: !1,
        viewport: {selector: "body", padding: 0}
    }, i.prototype.init = function (e, i, n) {
        if (this.enabled = !0, this.type = e, this.$element = t(i), this.options = this.getOptions(n), this.$viewport = this.options.viewport && t(t.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : this.options.viewport.selector || this.options.viewport), this.inState = {
            click: !1,
            hover: !1,
            focus: !1
        }, this.$element[0] instanceof document.constructor && !this.options.selector) throw new Error("`selector` option must be specified when initializing " + this.type + " on the window.document object!");
        for (var s = this.options.trigger.split(" "), r = s.length; r--;) {
            var o = s[r];
            if ("click" == o) this.$element.on("click." + this.type, this.options.selector, t.proxy(this.toggle, this)); else if ("manual" != o) {
                var a = "hover" == o ? "mouseenter" : "focusin", l = "hover" == o ? "mouseleave" : "focusout";
                this.$element.on(a + "." + this.type, this.options.selector, t.proxy(this.enter, this)), this.$element.on(l + "." + this.type, this.options.selector, t.proxy(this.leave, this))
            }
        }
        this.options.selector ? this._options = t.extend({}, this.options, {
            trigger: "manual",
            selector: ""
        }) : this.fixTitle()
    }, i.prototype.getDefaults = function () {
        return i.DEFAULTS
    }, i.prototype.getOptions = function (e) {
        return e = t.extend({}, this.getDefaults(), this.$element.data(), e), e.delay && "number" == typeof e.delay && (e.delay = {
            show: e.delay,
            hide: e.delay
        }), e
    }, i.prototype.getDelegateOptions = function () {
        var e = {}, i = this.getDefaults();
        return this._options && t.each(this._options, function (t, n) {
            i[t] != n && (e[t] = n)
        }), e
    }, i.prototype.enter = function (e) {
        var i = e instanceof this.constructor ? e : t(e.currentTarget).data("bs." + this.type);
        return i || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i)), e instanceof t.Event && (i.inState["focusin" == e.type ? "focus" : "hover"] = !0), i.tip().hasClass("in") || "in" == i.hoverState ? void(i.hoverState = "in") : (clearTimeout(i.timeout), i.hoverState = "in", i.options.delay && i.options.delay.show ? void(i.timeout = setTimeout(function () {
            "in" == i.hoverState && i.show()
        }, i.options.delay.show)) : i.show())
    }, i.prototype.isInStateTrue = function () {
        for (var t in this.inState) if (this.inState[t]) return !0;
        return !1
    }, i.prototype.leave = function (e) {
        var i = e instanceof this.constructor ? e : t(e.currentTarget).data("bs." + this.type);
        if (i || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i)), e instanceof t.Event && (i.inState["focusout" == e.type ? "focus" : "hover"] = !1), !i.isInStateTrue()) return clearTimeout(i.timeout), i.hoverState = "out", i.options.delay && i.options.delay.hide ? void(i.timeout = setTimeout(function () {
            "out" == i.hoverState && i.hide()
        }, i.options.delay.hide)) : i.hide()
    }, i.prototype.show = function () {
        var e = t.Event("show.bs." + this.type);
        if (this.hasContent() && this.enabled) {
            this.$element.trigger(e);
            var n = t.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
            if (e.isDefaultPrevented() || !n) return;
            var s = this, r = this.tip(), o = this.getUID(this.type);
            this.setContent(), r.attr("id", o), this.$element.attr("aria-describedby", o), this.options.animation && r.addClass("fade");
            var a = "function" == typeof this.options.placement ? this.options.placement.call(this, r[0], this.$element[0]) : this.options.placement,
                l = /\s?auto?\s?/i, c = l.test(a);
            c && (a = a.replace(l, "") || "top"), r.detach().css({
                top: 0,
                left: 0,
                display: "block"
            }).addClass(a).data("bs." + this.type, this), this.options.container ? r.appendTo(this.options.container) : r.insertAfter(this.$element), this.$element.trigger("inserted.bs." + this.type);
            var u = this.getPosition(), h = r[0].offsetWidth, d = r[0].offsetHeight;
            if (c) {
                var p = a, f = this.getPosition(this.$viewport);
                a = "bottom" == a && u.bottom + d > f.bottom ? "top" : "top" == a && u.top - d < f.top ? "bottom" : "right" == a && u.right + h > f.width ? "left" : "left" == a && u.left - h < f.left ? "right" : a, r.removeClass(p).addClass(a)
            }
            var g = this.getCalculatedOffset(a, u, h, d);
            this.applyPlacement(g, a);
            var m = function () {
                var t = s.hoverState;
                s.$element.trigger("shown.bs." + s.type), s.hoverState = null, "out" == t && s.leave(s)
            };
            t.support.transition && this.$tip.hasClass("fade") ? r.one("bsTransitionEnd", m).emulateTransitionEnd(i.TRANSITION_DURATION) : m()
        }
    }, i.prototype.applyPlacement = function (e, i) {
        var n = this.tip(), s = n[0].offsetWidth, r = n[0].offsetHeight, o = parseInt(n.css("margin-top"), 10),
            a = parseInt(n.css("margin-left"), 10);
        isNaN(o) && (o = 0), isNaN(a) && (a = 0), e.top += o, e.left += a, t.offset.setOffset(n[0], t.extend({
            using: function (t) {
                n.css({top: Math.round(t.top), left: Math.round(t.left)})
            }
        }, e), 0), n.addClass("in");
        var l = n[0].offsetWidth, c = n[0].offsetHeight;
        "top" == i && c != r && (e.top = e.top + r - c);
        var u = this.getViewportAdjustedDelta(i, e, l, c);
        u.left ? e.left += u.left : e.top += u.top;
        var h = /top|bottom/.test(i), d = h ? 2 * u.left - s + l : 2 * u.top - r + c,
            p = h ? "offsetWidth" : "offsetHeight";
        n.offset(e), this.replaceArrow(d, n[0][p], h)
    }, i.prototype.replaceArrow = function (t, e, i) {
        this.arrow().css(i ? "left" : "top", 50 * (1 - t / e) + "%").css(i ? "top" : "left", "")
    }, i.prototype.setContent = function () {
        var t = this.tip(), e = this.getTitle();
        t.find(".tooltip-inner")[this.options.html ? "html" : "text"](e), t.removeClass("fade in top bottom left right")
    }, i.prototype.hide = function (e) {
        function n() {
            "in" != s.hoverState && r.detach(), s.$element && s.$element.removeAttr("aria-describedby").trigger("hidden.bs." + s.type), e && e()
        }

        var s = this, r = t(this.$tip), o = t.Event("hide.bs." + this.type);
        if (this.$element.trigger(o), !o.isDefaultPrevented()) return r.removeClass("in"), t.support.transition && r.hasClass("fade") ? r.one("bsTransitionEnd", n).emulateTransitionEnd(i.TRANSITION_DURATION) : n(), this.hoverState = null, this
    }, i.prototype.fixTitle = function () {
        var t = this.$element;
        (t.attr("title") || "string" != typeof t.attr("data-original-title")) && t.attr("data-original-title", t.attr("title") || "").attr("title", "")
    }, i.prototype.hasContent = function () {
        return this.getTitle()
    }, i.prototype.getPosition = function (e) {
        e = e || this.$element;
        var i = e[0], n = "BODY" == i.tagName, s = i.getBoundingClientRect();
        null == s.width && (s = t.extend({}, s, {width: s.right - s.left, height: s.bottom - s.top}));
        var r = window.SVGElement && i instanceof window.SVGElement, o = n ? {top: 0, left: 0} : r ? null : e.offset(),
            a = {scroll: n ? document.documentElement.scrollTop || document.body.scrollTop : e.scrollTop()},
            l = n ? {width: t(window).width(), height: t(window).height()} : null;
        return t.extend({}, s, a, l, o)
    }, i.prototype.getCalculatedOffset = function (t, e, i, n) {
        return "bottom" == t ? {
            top: e.top + e.height,
            left: e.left + e.width / 2 - i / 2
        } : "top" == t ? {
            top: e.top - n,
            left: e.left + e.width / 2 - i / 2
        } : "left" == t ? {top: e.top + e.height / 2 - n / 2, left: e.left - i} : {
            top: e.top + e.height / 2 - n / 2,
            left: e.left + e.width
        }
    }, i.prototype.getViewportAdjustedDelta = function (t, e, i, n) {
        var s = {top: 0, left: 0};
        if (!this.$viewport) return s;
        var r = this.options.viewport && this.options.viewport.padding || 0, o = this.getPosition(this.$viewport);
        if (/right|left/.test(t)) {
            var a = e.top - r - o.scroll, l = e.top + r - o.scroll + n;
            a < o.top ? s.top = o.top - a : l > o.top + o.height && (s.top = o.top + o.height - l)
        } else {
            var c = e.left - r, u = e.left + r + i;
            c < o.left ? s.left = o.left - c : u > o.right && (s.left = o.left + o.width - u)
        }
        return s
    }, i.prototype.getTitle = function () {
        var t = this.$element, e = this.options;
        return t.attr("data-original-title") || ("function" == typeof e.title ? e.title.call(t[0]) : e.title)
    }, i.prototype.getUID = function (t) {
        do {
            t += ~~(1e6 * Math.random())
        } while (document.getElementById(t));
        return t
    }, i.prototype.tip = function () {
        if (!this.$tip && (this.$tip = t(this.options.template), 1 != this.$tip.length)) throw new Error(this.type + " `template` option must consist of exactly 1 top-level element!");
        return this.$tip
    }, i.prototype.arrow = function () {
        return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
    }, i.prototype.enable = function () {
        this.enabled = !0
    }, i.prototype.disable = function () {
        this.enabled = !1
    }, i.prototype.toggleEnabled = function () {
        this.enabled = !this.enabled
    }, i.prototype.toggle = function (e) {
        var i = this;
        e && ((i = t(e.currentTarget).data("bs." + this.type)) || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i))), e ? (i.inState.click = !i.inState.click, i.isInStateTrue() ? i.enter(i) : i.leave(i)) : i.tip().hasClass("in") ? i.leave(i) : i.enter(i)
    }, i.prototype.destroy = function () {
        var t = this;
        clearTimeout(this.timeout), this.hide(function () {
            t.$element.off("." + t.type).removeData("bs." + t.type), t.$tip && t.$tip.detach(), t.$tip = null, t.$arrow = null, t.$viewport = null, t.$element = null
        })
    };
    var n = t.fn.tooltip;
    t.fn.tooltip = e, t.fn.tooltip.Constructor = i, t.fn.tooltip.noConflict = function () {
        return t.fn.tooltip = n, this
    }
}(jQuery), function (t) {
    "use strict";

    function e(e) {
        return this.each(function () {
            var n = t(this), s = n.data("bs.popover"), r = "object" == typeof e && e;
            !s && /destroy|hide/.test(e) || (s || n.data("bs.popover", s = new i(this, r)), "string" == typeof e && s[e]())
        })
    }

    var i = function (t, e) {
        this.init("popover", t, e)
    };
    if (!t.fn.tooltip) throw new Error("Popover requires tooltip.js");
    i.VERSION = "3.3.7", i.DEFAULTS = t.extend({}, t.fn.tooltip.Constructor.DEFAULTS, {
        placement: "right",
        trigger: "click",
        content: "",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }), i.prototype = t.extend({}, t.fn.tooltip.Constructor.prototype), i.prototype.constructor = i, i.prototype.getDefaults = function () {
        return i.DEFAULTS
    }, i.prototype.setContent = function () {
        var t = this.tip(), e = this.getTitle(), i = this.getContent();
        t.find(".popover-title")[this.options.html ? "html" : "text"](e), t.find(".popover-content").children().detach().end()[this.options.html ? "string" == typeof i ? "html" : "append" : "text"](i), t.removeClass("fade top bottom left right in"), t.find(".popover-title").html() || t.find(".popover-title").hide()
    }, i.prototype.hasContent = function () {
        return this.getTitle() || this.getContent()
    }, i.prototype.getContent = function () {
        var t = this.$element, e = this.options;
        return t.attr("data-content") || ("function" == typeof e.content ? e.content.call(t[0]) : e.content)
    }, i.prototype.arrow = function () {
        return this.$arrow = this.$arrow || this.tip().find(".arrow")
    };
    var n = t.fn.popover;
    t.fn.popover = e, t.fn.popover.Constructor = i, t.fn.popover.noConflict = function () {
        return t.fn.popover = n, this
    }
}(jQuery), function (t) {
    "use strict";

    function e(i, n) {
        this.$body = t(document.body), this.$scrollElement = t(t(i).is(document.body) ? window : i), this.options = t.extend({}, e.DEFAULTS, n), this.selector = (this.options.target || "") + " .nav li > a", this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, this.$scrollElement.on("scroll.bs.scrollspy", t.proxy(this.process, this)), this.refresh(), this.process()
    }

    function i(i) {
        return this.each(function () {
            var n = t(this), s = n.data("bs.scrollspy"), r = "object" == typeof i && i;
            s || n.data("bs.scrollspy", s = new e(this, r)), "string" == typeof i && s[i]()
        })
    }

    e.VERSION = "3.3.7", e.DEFAULTS = {offset: 10}, e.prototype.getScrollHeight = function () {
        return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
    }, e.prototype.refresh = function () {
        var e = this, i = "offset", n = 0;
        this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight(), t.isWindow(this.$scrollElement[0]) || (i = "position", n = this.$scrollElement.scrollTop()), this.$body.find(this.selector).map(function () {
            var e = t(this), s = e.data("target") || e.attr("href"), r = /^#./.test(s) && t(s);
            return r && r.length && r.is(":visible") && [[r[i]().top + n, s]] || null
        }).sort(function (t, e) {
            return t[0] - e[0]
        }).each(function () {
            e.offsets.push(this[0]), e.targets.push(this[1])
        })
    }, e.prototype.process = function () {
        var t, e = this.$scrollElement.scrollTop() + this.options.offset, i = this.getScrollHeight(),
            n = this.options.offset + i - this.$scrollElement.height(), s = this.offsets, r = this.targets,
            o = this.activeTarget;
        if (this.scrollHeight != i && this.refresh(), e >= n) return o != (t = r[r.length - 1]) && this.activate(t);
        if (o && e < s[0]) return this.activeTarget = null, this.clear();
        for (t = s.length; t--;) o != r[t] && e >= s[t] && (void 0 === s[t + 1] || e < s[t + 1]) && this.activate(r[t])
    }, e.prototype.activate = function (e) {
        this.activeTarget = e, this.clear();
        var i = this.selector + '[data-target="' + e + '"],' + this.selector + '[href="' + e + '"]',
            n = t(i).parents("li").addClass("active");
        n.parent(".dropdown-menu").length && (n = n.closest("li.dropdown").addClass("active")), n.trigger("activate.bs.scrollspy")
    }, e.prototype.clear = function () {
        t(this.selector).parentsUntil(this.options.target, ".active").removeClass("active")
    };
    var n = t.fn.scrollspy;
    t.fn.scrollspy = i, t.fn.scrollspy.Constructor = e, t.fn.scrollspy.noConflict = function () {
        return t.fn.scrollspy = n, this
    }, t(window).on("load.bs.scrollspy.data-api", function () {
        t('[data-spy="scroll"]').each(function () {
            var e = t(this);
            i.call(e, e.data())
        })
    })
}(jQuery), function (t) {
    "use strict";

    function e(e) {
        return this.each(function () {
            var n = t(this), s = n.data("bs.tab");
            s || n.data("bs.tab", s = new i(this)), "string" == typeof e && s[e]()
        })
    }

    var i = function (e) {
        this.element = t(e)
    };
    i.VERSION = "3.3.7", i.TRANSITION_DURATION = 150, i.prototype.show = function () {
        var e = this.element, i = e.closest("ul:not(.dropdown-menu)"), n = e.data("target");
        if (n || (n = e.attr("href"), n = n && n.replace(/.*(?=#[^\s]*$)/, "")), !e.parent("li").hasClass("active")) {
            var s = i.find(".active:last a"), r = t.Event("hide.bs.tab", {relatedTarget: e[0]}),
                o = t.Event("show.bs.tab", {relatedTarget: s[0]});
            if (s.trigger(r), e.trigger(o), !o.isDefaultPrevented() && !r.isDefaultPrevented()) {
                var a = t(n);
                this.activate(e.closest("li"), i), this.activate(a, a.parent(), function () {
                    s.trigger({type: "hidden.bs.tab", relatedTarget: e[0]}), e.trigger({
                        type: "shown.bs.tab",
                        relatedTarget: s[0]
                    })
                })
            }
        }
    }, i.prototype.activate = function (e, n, s) {
        function r() {
            o.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !1), e.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0), a ? (e[0].offsetWidth, e.addClass("in")) : e.removeClass("fade"), e.parent(".dropdown-menu").length && e.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0), s && s()
        }

        var o = n.find("> .active"),
            a = s && t.support.transition && (o.length && o.hasClass("fade") || !!n.find("> .fade").length);
        o.length && a ? o.one("bsTransitionEnd", r).emulateTransitionEnd(i.TRANSITION_DURATION) : r(), o.removeClass("in")
    };
    var n = t.fn.tab;
    t.fn.tab = e, t.fn.tab.Constructor = i, t.fn.tab.noConflict = function () {
        return t.fn.tab = n, this
    };
    var s = function (i) {
        i.preventDefault(), e.call(t(this), "show")
    };
    t(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', s).on("click.bs.tab.data-api", '[data-toggle="pill"]', s)
}(jQuery), function (t) {
    "use strict";

    function e(e) {
        return this.each(function () {
            var n = t(this), s = n.data("bs.affix"), r = "object" == typeof e && e;
            s || n.data("bs.affix", s = new i(this, r)), "string" == typeof e && s[e]()
        })
    }

    var i = function (e, n) {
        this.options = t.extend({}, i.DEFAULTS, n), this.$target = t(this.options.target).on("scroll.bs.affix.data-api", t.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", t.proxy(this.checkPositionWithEventLoop, this)), this.$element = t(e), this.affixed = null, this.unpin = null, this.pinnedOffset = null, this.checkPosition()
    };
    i.VERSION = "3.3.7", i.RESET = "affix affix-top affix-bottom", i.DEFAULTS = {
        offset: 0,
        target: window
    }, i.prototype.getState = function (t, e, i, n) {
        var s = this.$target.scrollTop(), r = this.$element.offset(), o = this.$target.height();
        if (null != i && "top" == this.affixed) return s < i && "top";
        if ("bottom" == this.affixed) return null != i ? !(s + this.unpin <= r.top) && "bottom" : !(s + o <= t - n) && "bottom";
        var a = null == this.affixed, l = a ? s : r.top, c = a ? o : e;
        return null != i && s <= i ? "top" : null != n && l + c >= t - n && "bottom"
    }, i.prototype.getPinnedOffset = function () {
        if (this.pinnedOffset) return this.pinnedOffset;
        this.$element.removeClass(i.RESET).addClass("affix");
        var t = this.$target.scrollTop(), e = this.$element.offset();
        return this.pinnedOffset = e.top - t
    }, i.prototype.checkPositionWithEventLoop = function () {
        setTimeout(t.proxy(this.checkPosition, this), 1)
    }, i.prototype.checkPosition = function () {
        if (this.$element.is(":visible")) {
            var e = this.$element.height(), n = this.options.offset, s = n.top, r = n.bottom,
                o = Math.max(t(document).height(), t(document.body).height());
            "object" != typeof n && (r = s = n), "function" == typeof s && (s = n.top(this.$element)), "function" == typeof r && (r = n.bottom(this.$element));
            var a = this.getState(o, e, s, r);
            if (this.affixed != a) {
                null != this.unpin && this.$element.css("top", "");
                var l = "affix" + (a ? "-" + a : ""), c = t.Event(l + ".bs.affix");
                if (this.$element.trigger(c), c.isDefaultPrevented()) return;
                this.affixed = a, this.unpin = "bottom" == a ? this.getPinnedOffset() : null, this.$element.removeClass(i.RESET).addClass(l).trigger(l.replace("affix", "affixed") + ".bs.affix")
            }
            "bottom" == a && this.$element.offset({top: o - e - r})
        }
    };
    var n = t.fn.affix;
    t.fn.affix = e, t.fn.affix.Constructor = i, t.fn.affix.noConflict = function () {
        return t.fn.affix = n, this
    }, t(window).on("load", function () {
        t('[data-spy="affix"]').each(function () {
            var i = t(this), n = i.data();
            n.offset = n.offset || {}, null != n.offsetBottom && (n.offset.bottom = n.offsetBottom), null != n.offsetTop && (n.offset.top = n.offsetTop), e.call(i, n)
        })
    })
}(jQuery), "undefined" == typeof jQuery) throw new Error("BootstrapValidator requires jQuery");
!function (t) {
    var e = t.fn.jquery.split(" ")[0].split(".");
    if (+e[0] < 2 && +e[1] < 9 || 1 == +e[0] && 9 == +e[1] && +e[2] < 1) throw new Error("BootstrapValidator requires jQuery version 1.9.1 or higher")
}(window.jQuery), function (t) {
    var e = function (e, i) {
        this.$form = t(e), this.options = t.extend({}, t.fn.bootstrapValidator.DEFAULT_OPTIONS, i), this.$invalidFields = t([]), this.$submitButton = null, this.$hiddenButton = null, this.STATUS_NOT_VALIDATED = "NOT_VALIDATED", this.STATUS_VALIDATING = "VALIDATING", this.STATUS_INVALID = "INVALID", this.STATUS_VALID = "VALID";
        var n = function () {
            for (var t = 3, e = document.createElement("div"), i = e.all || []; e.innerHTML = "\x3c!--[if gt IE " + ++t + "]><br><![endif]--\x3e", i[0];) ;
            return t > 4 ? t : !t
        }(), s = document.createElement("div");
        this._changeEvent = 9 !== n && "oninput" in s ? "input" : "keyup", this._submitIfValid = null, this._cacheFields = {}, this._init()
    };
    e.prototype = {
        constructor: e, _init: function () {
            var e = this, i = {
                autoFocus: this.$form.attr("data-bv-autofocus"),
                container: this.$form.attr("data-bv-container"),
                events: {
                    formInit: this.$form.attr("data-bv-events-form-init"),
                    formError: this.$form.attr("data-bv-events-form-error"),
                    formSuccess: this.$form.attr("data-bv-events-form-success"),
                    fieldAdded: this.$form.attr("data-bv-events-field-added"),
                    fieldRemoved: this.$form.attr("data-bv-events-field-removed"),
                    fieldInit: this.$form.attr("data-bv-events-field-init"),
                    fieldError: this.$form.attr("data-bv-events-field-error"),
                    fieldSuccess: this.$form.attr("data-bv-events-field-success"),
                    fieldStatus: this.$form.attr("data-bv-events-field-status"),
                    validatorError: this.$form.attr("data-bv-events-validator-error"),
                    validatorSuccess: this.$form.attr("data-bv-events-validator-success")
                },
                excluded: this.$form.attr("data-bv-excluded"),
                feedbackIcons: {
                    valid: this.$form.attr("data-bv-feedbackicons-valid"),
                    invalid: this.$form.attr("data-bv-feedbackicons-invalid"),
                    validating: this.$form.attr("data-bv-feedbackicons-validating")
                },
                group: this.$form.attr("data-bv-group"),
                live: this.$form.attr("data-bv-live"),
                message: this.$form.attr("data-bv-message"),
                onError: this.$form.attr("data-bv-onerror"),
                onSuccess: this.$form.attr("data-bv-onsuccess"),
                submitButtons: this.$form.attr("data-bv-submitbuttons"),
                threshold: this.$form.attr("data-bv-threshold"),
                trigger: this.$form.attr("data-bv-trigger"),
                verbose: this.$form.attr("data-bv-verbose"),
                fields: {}
            };
            this.$form.attr("novalidate", "novalidate").addClass(this.options.elementClass).on("submit.bv", function (t) {
                t.preventDefault(), e.validate()
            }).on("click.bv", this.options.submitButtons, function () {
                e.$submitButton = t(this), e._submitIfValid = !0
            }).find("[name], [data-bv-field]").each(function () {
                var n = t(this), s = n.attr("name") || n.attr("data-bv-field"), r = e._parseOptions(n);
                r && (n.attr("data-bv-field", s), i.fields[s] = t.extend({}, r, i.fields[s]))
            }), this.options = t.extend(!0, this.options, i), this.$hiddenButton = t("<button/>").attr("type", "submit").prependTo(this.$form).addClass("bv-hidden-submit").css({
                display: "none",
                width: 0,
                height: 0
            }), this.$form.on("click.bv", '[type="submit"]', function (i) {
                if (!i.isDefaultPrevented()) {
                    var n = t(i.target), s = n.is('[type="submit"]') ? n.eq(0) : n.parent('[type="submit"]').eq(0);
                    !e.options.submitButtons || s.is(e.options.submitButtons) || s.is(e.$hiddenButton) || e.$form.off("submit.bv").submit()
                }
            });
            for (var n in this.options.fields) this._initField(n);
            this.$form.trigger(t.Event(this.options.events.formInit), {
                bv: this,
                options: this.options
            }), this.options.onSuccess && this.$form.on(this.options.events.formSuccess, function (i) {
                t.fn.bootstrapValidator.helpers.call(e.options.onSuccess, [i])
            }), this.options.onError && this.$form.on(this.options.events.formError, function (i) {
                t.fn.bootstrapValidator.helpers.call(e.options.onError, [i])
            })
        }, _parseOptions: function (e) {
            var i, n, s, r, o, a, l, c, u, h = e.attr("name") || e.attr("data-bv-field"), d = {};
            for (n in t.fn.bootstrapValidator.validators) if (i = t.fn.bootstrapValidator.validators[n], s = "data-bv-" + n.toLowerCase(), r = e.attr(s) + "", (u = "function" == typeof i.enableByHtml5 ? i.enableByHtml5(e) : null) && "false" !== r || !0 !== u && ("" === r || "true" === r || s === r.toLowerCase())) {
                i.html5Attributes = t.extend({}, {
                    message: "message",
                    onerror: "onError",
                    onsuccess: "onSuccess"
                }, i.html5Attributes), d[n] = t.extend({}, !0 === u ? {} : u, d[n]);
                for (c in i.html5Attributes) o = i.html5Attributes[c], a = "data-bv-" + n.toLowerCase() + "-" + c, l = e.attr(a), l && ("true" === l || a === l.toLowerCase() ? l = !0 : "false" === l && (l = !1), d[n][o] = l)
            }
            var p = {
                autoFocus: e.attr("data-bv-autofocus"),
                container: e.attr("data-bv-container"),
                excluded: e.attr("data-bv-excluded"),
                feedbackIcons: e.attr("data-bv-feedbackicons"),
                group: e.attr("data-bv-group"),
                message: e.attr("data-bv-message"),
                onError: e.attr("data-bv-onerror"),
                onStatus: e.attr("data-bv-onstatus"),
                onSuccess: e.attr("data-bv-onsuccess"),
                selector: e.attr("data-bv-selector"),
                threshold: e.attr("data-bv-threshold"),
                trigger: e.attr("data-bv-trigger"),
                verbose: e.attr("data-bv-verbose"),
                validators: d
            }, f = t.isEmptyObject(p);
            return !t.isEmptyObject(d) || !f && this.options.fields && this.options.fields[h] ? (p.validators = d, p) : null
        }, _initField: function (e) {
            var i = t([]);
            switch (typeof e) {
                case"object":
                    i = e, e = e.attr("data-bv-field");
                    break;
                case"string":
                    i = this.getFieldElements(e), i.attr("data-bv-field", e)
            }
            if (0 !== i.length && null !== this.options.fields[e] && null !== this.options.fields[e].validators) {
                var n;
                for (n in this.options.fields[e].validators) t.fn.bootstrapValidator.validators[n] || delete this.options.fields[e].validators[n];
                null === this.options.fields[e].enabled && (this.options.fields[e].enabled = !0);
                for (var s = this, r = i.length, o = i.attr("type"), a = 1 === r || "radio" === o || "checkbox" === o, l = "radio" === o || "checkbox" === o || "file" === o || "SELECT" === i.eq(0).get(0).tagName ? "change" : this._changeEvent, c = (this.options.fields[e].trigger || this.options.trigger || l).split(" "), u = t.map(c, function (t) {
                    return t + ".update.bv"
                }).join(" "), h = 0; h < r; h++) {
                    var d = i.eq(h), p = this.options.fields[e].group || this.options.group, f = d.parents(p),
                        g = "function" == typeof(this.options.fields[e].container || this.options.container) ? (this.options.fields[e].container || this.options.container).call(this, d, this) : this.options.fields[e].container || this.options.container,
                        m = g && "tooltip" !== g && "popover" !== g ? t(g) : this._getMessageContainer(d, p);
                    g && "tooltip" !== g && "popover" !== g && m.addClass("has-error"), m.find('.help-block[data-bv-validator][data-bv-for="' + e + '"]').remove(), f.find('i[data-bv-icon-for="' + e + '"]').remove(), d.off(u).on(u, function () {
                        s.updateStatus(t(this), s.STATUS_NOT_VALIDATED)
                    }), d.data("bv.messages", m);
                    for (n in this.options.fields[e].validators) d.data("bv.result." + n, this.STATUS_NOT_VALIDATED), a && h !== r - 1 || t("<small/>").css("display", "none").addClass("help-block").attr("data-bv-validator", n).attr("data-bv-for", e).attr("data-bv-result", this.STATUS_NOT_VALIDATED).html(this._getMessage(e, n)).appendTo(m), "function" == typeof t.fn.bootstrapValidator.validators[n].init && t.fn.bootstrapValidator.validators[n].init(this, d, this.options.fields[e].validators[n]);
                    if (!1 !== this.options.fields[e].feedbackIcons && "false" !== this.options.fields[e].feedbackIcons && this.options.feedbackIcons && this.options.feedbackIcons.validating && this.options.feedbackIcons.invalid && this.options.feedbackIcons.valid && (!a || h === r - 1)) {
                        f.addClass("has-feedback");
                        var v = t("<i/>").css("display", "none").addClass("form-control-feedback").attr("data-bv-icon-for", e).insertAfter(d);
                        if ("checkbox" === o || "radio" === o) {
                            var b = d.parent();
                            b.hasClass(o) ? v.insertAfter(b) : b.parent().hasClass(o) && v.insertAfter(b.parent())
                        }
                        0 === f.find("label").length && v.addClass("bv-no-label"), 0 !== f.find(".input-group").length && v.addClass("bv-icon-input-group").insertAfter(f.find(".input-group").eq(0)), a ? h === r - 1 && i.data("bv.icon", v) : d.data("bv.icon", v), g && d.off("focus.container.bv").on("focus.container.bv", function () {
                            switch (g) {
                                case"tooltip":
                                    t(this).data("bv.icon").tooltip("show");
                                    break;
                                case"popover":
                                    t(this).data("bv.icon").popover("show")
                            }
                        }).off("blur.container.bv").on("blur.container.bv", function () {
                            switch (g) {
                                case"tooltip":
                                    t(this).data("bv.icon").tooltip("hide");
                                    break;
                                case"popover":
                                    t(this).data("bv.icon").popover("hide")
                            }
                        })
                    }
                }
                switch (i.on(this.options.events.fieldSuccess, function (e, i) {
                    var n = s.getOptions(i.field, null, "onSuccess");
                    n && t.fn.bootstrapValidator.helpers.call(n, [e, i])
                }).on(this.options.events.fieldError, function (e, i) {
                    var n = s.getOptions(i.field, null, "onError")
                    ;n && t.fn.bootstrapValidator.helpers.call(n, [e, i])
                }).on(this.options.events.fieldStatus, function (e, i) {
                    var n = s.getOptions(i.field, null, "onStatus");
                    n && t.fn.bootstrapValidator.helpers.call(n, [e, i])
                }).on(this.options.events.validatorError, function (e, i) {
                    var n = s.getOptions(i.field, i.validator, "onError");
                    n && t.fn.bootstrapValidator.helpers.call(n, [e, i])
                }).on(this.options.events.validatorSuccess, function (e, i) {
                    var n = s.getOptions(i.field, i.validator, "onSuccess");
                    n && t.fn.bootstrapValidator.helpers.call(n, [e, i])
                }), u = t.map(c, function (t) {
                    return t + ".live.bv"
                }).join(" "), this.options.live) {
                    case"submitted":
                        break;
                    case"disabled":
                        i.off(u);
                        break;
                    case"enabled":
                    default:
                        i.off(u).on(u, function () {
                            s._exceedThreshold(t(this)) && s.validateField(t(this))
                        })
                }
                i.trigger(t.Event(this.options.events.fieldInit), {bv: this, field: e, element: i})
            }
        }, _getMessage: function (e, i) {
            if (!(this.options.fields[e] && t.fn.bootstrapValidator.validators[i] && this.options.fields[e].validators && this.options.fields[e].validators[i])) return "";
            var n = this.options.fields[e].validators[i];
            switch (!0) {
                case!!n.message:
                    return n.message;
                case!!this.options.fields[e].message:
                    return this.options.fields[e].message;
                case!!t.fn.bootstrapValidator.i18n[i]:
                    return t.fn.bootstrapValidator.i18n[i].default;
                default:
                    return this.options.message
            }
        }, _getMessageContainer: function (t, e) {
            var i = t.parent();
            if (i.is(e)) return i;
            var n = i.attr("class");
            if (!n) return this._getMessageContainer(i, e);
            n = n.split(" ");
            for (var s = n.length, r = 0; r < s; r++) if (/^col-(xs|sm|md|lg)-\d+$/.test(n[r]) || /^col-(xs|sm|md|lg)-offset-\d+$/.test(n[r])) return i;
            return this._getMessageContainer(i, e)
        }, _submit: function () {
            var e = this.isValid(), i = e ? this.options.events.formSuccess : this.options.events.formError,
                n = t.Event(i);
            this.$form.trigger(n), this.$submitButton && (e ? this._onSuccess(n) : this._onError(n))
        }, _isExcluded: function (e) {
            var i = e.attr("data-bv-excluded"), n = e.attr("data-bv-field") || e.attr("name");
            switch (!0) {
                case!!n && this.options.fields && this.options.fields[n] && ("true" === this.options.fields[n].excluded || !0 === this.options.fields[n].excluded):
                case"true" === i:
                case"" === i:
                    return !0;
                case!!n && this.options.fields && this.options.fields[n] && ("false" === this.options.fields[n].excluded || !1 === this.options.fields[n].excluded):
                case"false" === i:
                    return !1;
                default:
                    if (this.options.excluded) {
                        "string" == typeof this.options.excluded && (this.options.excluded = t.map(this.options.excluded.split(","), function (e) {
                            return t.trim(e)
                        }));
                        for (var s = this.options.excluded.length, r = 0; r < s; r++) if ("string" == typeof this.options.excluded[r] && e.is(this.options.excluded[r]) || "function" == typeof this.options.excluded[r] && !0 === this.options.excluded[r].call(this, e, this)) return !0
                    }
                    return !1
            }
        }, _exceedThreshold: function (e) {
            var i = e.attr("data-bv-field"), n = this.options.fields[i].threshold || this.options.threshold;
            return !n || (-1 !== t.inArray(e.attr("type"), ["button", "checkbox", "file", "hidden", "image", "radio", "reset", "submit"]) || e.val().length >= n)
        }, _onError: function (e) {
            if (!e.isDefaultPrevented()) {
                if ("submitted" === this.options.live) {
                    this.options.live = "enabled";
                    var i = this;
                    for (var n in this.options.fields) !function (e) {
                        var s = i.getFieldElements(e);
                        if (s.length) {
                            var r = t(s[0]).attr("type"),
                                o = "radio" === r || "checkbox" === r || "file" === r || "SELECT" === t(s[0]).get(0).tagName ? "change" : i._changeEvent,
                                a = i.options.fields[n].trigger || i.options.trigger || o,
                                l = t.map(a.split(" "), function (t) {
                                    return t + ".live.bv"
                                }).join(" ");
                            s.off(l).on(l, function () {
                                i._exceedThreshold(t(this)) && i.validateField(t(this))
                            })
                        }
                    }(n)
                }
                for (var s = 0; s < this.$invalidFields.length; s++) {
                    var r = this.$invalidFields.eq(s);
                    if (this._isOptionEnabled(r.attr("data-bv-field"), "autoFocus")) {
                        var o, a = r.parents(".tab-pane");
                        a && (o = a.attr("id")) && t('a[href="#' + o + '"][data-toggle="tab"]').tab("show"), r.focus();
                        break
                    }
                }
            }
        }, _onSuccess: function (t) {
            t.isDefaultPrevented() || this.disableSubmitButtons(!0).defaultSubmit()
        }, _onFieldValidated: function (e, i) {
            var n = e.attr("data-bv-field"), s = this.options.fields[n].validators, r = {}, o = 0,
                a = {bv: this, field: n, element: e, validator: i, result: e.data("bv.response." + i)};
            if (i) switch (e.data("bv.result." + i)) {
                case this.STATUS_INVALID:
                    e.trigger(t.Event(this.options.events.validatorError), a);
                    break;
                case this.STATUS_VALID:
                    e.trigger(t.Event(this.options.events.validatorSuccess), a)
            }
            r[this.STATUS_NOT_VALIDATED] = 0, r[this.STATUS_VALIDATING] = 0, r[this.STATUS_INVALID] = 0, r[this.STATUS_VALID] = 0;
            for (var l in s) if (!1 !== s[l].enabled) {
                o++;
                var c = e.data("bv.result." + l);
                c && r[c]++
            }
            r[this.STATUS_VALID] === o ? (this.$invalidFields = this.$invalidFields.not(e), e.trigger(t.Event(this.options.events.fieldSuccess), a)) : (0 === r[this.STATUS_NOT_VALIDATED] || !this._isOptionEnabled(n, "verbose")) && 0 === r[this.STATUS_VALIDATING] && r[this.STATUS_INVALID] > 0 && (this.$invalidFields = this.$invalidFields.add(e), e.trigger(t.Event(this.options.events.fieldError), a))
        }, _isOptionEnabled: function (t, e) {
            return !(!this.options.fields[t] || "true" !== this.options.fields[t][e] && !0 !== this.options.fields[t][e]) || (!this.options.fields[t] || "false" !== this.options.fields[t][e] && !1 !== this.options.fields[t][e]) && ("true" === this.options[e] || !0 === this.options[e])
        }, getFieldElements: function (e) {
            return this._cacheFields[e] || (this._cacheFields[e] = this.options.fields[e] && this.options.fields[e].selector ? t(this.options.fields[e].selector) : this.$form.find('[name="' + e + '"]')), this._cacheFields[e]
        }, getOptions: function (t, e, i) {
            if (!t) return i ? this.options[i] : this.options;
            if ("object" == typeof t && (t = t.attr("data-bv-field")), !this.options.fields[t]) return null;
            var n = this.options.fields[t];
            return e ? n.validators && n.validators[e] ? i ? n.validators[e][i] : n.validators[e] : null : i ? n[i] : n
        }, disableSubmitButtons: function (t) {
            return t ? "disabled" !== this.options.live && this.$form.find(this.options.submitButtons).attr("disabled", "disabled") : this.$form.find(this.options.submitButtons).removeAttr("disabled"), this
        }, validate: function () {
            if (!this.options.fields) return this;
            this.disableSubmitButtons(!0), this._submitIfValid = !1;
            for (var t in this.options.fields) this.validateField(t);
            return this._submit(), this._submitIfValid = !0, this
        }, validateField: function (e) {
            var i = t([]);
            switch (typeof e) {
                case"object":
                    i = e, e = e.attr("data-bv-field");
                    break;
                case"string":
                    i = this.getFieldElements(e)
            }
            if (0 === i.length || !this.options.fields[e] || !1 === this.options.fields[e].enabled) return this;
            for (var n, s, r = this, o = i.attr("type"), a = "radio" === o || "checkbox" === o ? 1 : i.length, l = "radio" === o || "checkbox" === o, c = this.options.fields[e].validators, u = this._isOptionEnabled(e, "verbose"), h = 0; h < a; h++) {
                var d = i.eq(h);
                if (!this._isExcluded(d)) {
                    var p = !1;
                    for (n in c) {
                        if (d.data("bv.dfs." + n) && d.data("bv.dfs." + n).reject(), p) break;
                        var f = d.data("bv.result." + n);
                        if (f !== this.STATUS_VALID && f !== this.STATUS_INVALID) if (!1 !== c[n].enabled) {
                            if (d.data("bv.result." + n, this.STATUS_VALIDATING), "object" == typeof(s = t.fn.bootstrapValidator.validators[n].validate(this, d, c[n])) && s.resolve) this.updateStatus(l ? e : d, this.STATUS_VALIDATING, n), d.data("bv.dfs." + n, s), s.done(function (t, e, i) {
                                t.removeData("bv.dfs." + e).data("bv.response." + e, i), i.message && r.updateMessage(t, e, i.message), r.updateStatus(l ? t.attr("data-bv-field") : t, i.valid ? r.STATUS_VALID : r.STATUS_INVALID, e), i.valid && !0 === r._submitIfValid ? r._submit() : i.valid || u || (p = !0)
                            }); else if ("object" == typeof s && void 0 !== s.valid && void 0 !== s.message) {
                                if (d.data("bv.response." + n, s), this.updateMessage(l ? e : d, n, s.message), this.updateStatus(l ? e : d, s.valid ? this.STATUS_VALID : this.STATUS_INVALID, n), !s.valid && !u) break
                            } else if ("boolean" == typeof s && (d.data("bv.response." + n, s), this.updateStatus(l ? e : d, s ? this.STATUS_VALID : this.STATUS_INVALID, n), !s && !u)) break
                        } else this.updateStatus(l ? e : d, this.STATUS_VALID, n); else this._onFieldValidated(d, n)
                    }
                }
            }
            return this
        }, updateMessage: function (e, i, n) {
            var s = t([]);
            switch (typeof e) {
                case"object":
                    s = e, e = e.attr("data-bv-field");
                    break;
                case"string":
                    s = this.getFieldElements(e)
            }
            s.each(function () {
                t(this).data("bv.messages").find('.help-block[data-bv-validator="' + i + '"][data-bv-for="' + e + '"]').html(n)
            })
        }, updateStatus: function (e, i, n) {
            var s = t([]);
            switch (typeof e) {
                case"object":
                    s = e, e = e.attr("data-bv-field");
                    break;
                case"string":
                    s = this.getFieldElements(e)
            }
            i === this.STATUS_NOT_VALIDATED && (this._submitIfValid = !1);
            for (var r = this, o = s.attr("type"), a = this.options.fields[e].group || this.options.group, l = "radio" === o || "checkbox" === o ? 1 : s.length, c = 0; c < l; c++) {
                var u = s.eq(c);
                if (!this._isExcluded(u)) {
                    var h = u.parents(a), d = u.data("bv.messages"),
                        p = d.find('.help-block[data-bv-validator][data-bv-for="' + e + '"]'),
                        f = n ? p.filter('[data-bv-validator="' + n + '"]') : p, g = u.data("bv.icon"),
                        m = "function" == typeof(this.options.fields[e].container || this.options.container) ? (this.options.fields[e].container || this.options.container).call(this, u, this) : this.options.fields[e].container || this.options.container,
                        v = null;
                    if (n) u.data("bv.result." + n, i); else for (var b in this.options.fields[e].validators) u.data("bv.result." + b, i);
                    f.attr("data-bv-result", i);
                    var y, w, x = u.parents(".tab-pane");
                    switch (x && (y = x.attr("id")) && (w = t('a[href="#' + y + '"][data-toggle="tab"]').parent()), i) {
                        case this.STATUS_VALIDATING:
                            v = null, this.disableSubmitButtons(!0), h.removeClass("has-success").removeClass("has-error"), g && g.removeClass(this.options.feedbackIcons.valid).removeClass(this.options.feedbackIcons.invalid).addClass(this.options.feedbackIcons.validating).show(), w && w.removeClass("bv-tab-success").removeClass("bv-tab-error");
                            break;
                        case this.STATUS_INVALID:
                            v = !1, this.disableSubmitButtons(!0), h.removeClass("has-success").addClass("has-error"), g && g.removeClass(this.options.feedbackIcons.valid).removeClass(this.options.feedbackIcons.validating).addClass(this.options.feedbackIcons.invalid).show(), w && w.removeClass("bv-tab-success").addClass("bv-tab-error");
                            break;
                        case this.STATUS_VALID:
                            v = 0 === p.filter('[data-bv-result="' + this.STATUS_NOT_VALIDATED + '"]').length ? p.filter('[data-bv-result="' + this.STATUS_VALID + '"]').length === p.length : null, null !== v && (this.disableSubmitButtons(this.$submitButton ? !this.isValid() : !v), g && g.removeClass(this.options.feedbackIcons.invalid).removeClass(this.options.feedbackIcons.validating).removeClass(this.options.feedbackIcons.valid).addClass(v ? this.options.feedbackIcons.valid : this.options.feedbackIcons.invalid).show()), h.removeClass("has-error has-success").addClass(this.isValidContainer(h) ? "has-success" : "has-error"), w && w.removeClass("bv-tab-success").removeClass("bv-tab-error").addClass(this.isValidContainer(x) ? "bv-tab-success" : "bv-tab-error");
                            break;
                        case this.STATUS_NOT_VALIDATED:
                        default:
                            v = null, this.disableSubmitButtons(!1), h.removeClass("has-success").removeClass("has-error"), g && g.removeClass(this.options.feedbackIcons.valid).removeClass(this.options.feedbackIcons.invalid).removeClass(this.options.feedbackIcons.validating).hide(), w && w.removeClass("bv-tab-success").removeClass("bv-tab-error")
                    }
                    switch (!0) {
                        case g && "tooltip" === m:
                            !1 === v ? g.css("cursor", "pointer").tooltip("destroy").tooltip({
                                container: "body",
                                html: !0,
                                placement: "auto top",
                                title: p.filter('[data-bv-result="' + r.STATUS_INVALID + '"]').eq(0).html()
                            }) : g.css("cursor", "").tooltip("destroy");
                            break;
                        case g && "popover" === m:
                            !1 === v ? g.css("cursor", "pointer").popover("destroy").popover({
                                container: "body",
                                content: p.filter('[data-bv-result="' + r.STATUS_INVALID + '"]').eq(0).html(),
                                html: !0,
                                placement: "auto top",
                                trigger: "hover click"
                            }) : g.css("cursor", "").popover("destroy");
                            break;
                        default:
                            i === this.STATUS_INVALID ? f.show() : f.hide()
                    }
                    u.trigger(t.Event(this.options.events.fieldStatus), {
                        bv: this,
                        field: e,
                        element: u,
                        status: i
                    }), this._onFieldValidated(u, n)
                }
            }
            return this
        }, isValid: function () {
            for (var t in this.options.fields) if (!this.isValidField(t)) return !1;
            return !0
        }, isValidField: function (e) {
            var i = t([]);
            switch (typeof e) {
                case"object":
                    i = e, e = e.attr("data-bv-field");
                    break;
                case"string":
                    i = this.getFieldElements(e)
            }
            if (0 === i.length || !this.options.fields[e] || !1 === this.options.fields[e].enabled) return !0;
            for (var n, s, r = i.attr("type"), o = "radio" === r || "checkbox" === r ? 1 : i.length, a = 0; a < o; a++) if (n = i.eq(a), !this._isExcluded(n)) for (s in this.options.fields[e].validators) if (!1 !== this.options.fields[e].validators[s].enabled && n.data("bv.result." + s) !== this.STATUS_VALID) return !1;
            return !0
        }, isValidContainer: function (e) {
            var i = this, n = {}, s = "string" == typeof e ? t(e) : e;
            if (0 === s.length) return !0;
            s.find("[data-bv-field]").each(function () {
                var e = t(this), s = e.attr("data-bv-field");
                i._isExcluded(e) || n[s] || (n[s] = e)
            });
            for (var r in n) {
                if (n[r].data("bv.messages").find('.help-block[data-bv-validator][data-bv-for="' + r + '"]').filter('[data-bv-result="' + this.STATUS_INVALID + '"]').length > 0) return !1
            }
            return !0
        }, defaultSubmit: function () {
            this.$submitButton && t("<input/>").attr("type", "hidden").attr("data-bv-submit-hidden", "").attr("name", this.$submitButton.attr("name")).val(this.$submitButton.val()).appendTo(this.$form), this.$form.off("submit.bv").submit()
        }, getInvalidFields: function () {
            return this.$invalidFields
        }, getSubmitButton: function () {
            return this.$submitButton
        }, getMessages: function (e, i) {
            var n = this, s = [], r = t([]);
            switch (!0) {
                case e && "object" == typeof e:
                    r = e;
                    break;
                case e && "string" == typeof e:
                    var o = this.getFieldElements(e);
                    if (o.length > 0) {
                        var a = o.attr("type");
                        r = "radio" === a || "checkbox" === a ? o.eq(0) : o
                    }
                    break;
                default:
                    r = this.$invalidFields
            }
            var l = i ? '[data-bv-validator="' + i + '"]' : "";
            return r.each(function () {
                s = s.concat(t(this).data("bv.messages").find('.help-block[data-bv-for="' + t(this).attr("data-bv-field") + '"][data-bv-result="' + n.STATUS_INVALID + '"]' + l).map(function () {
                    var e = t(this).attr("data-bv-validator"), i = t(this).attr("data-bv-for");
                    return !1 === n.options.fields[i].validators[e].enabled ? "" : t(this).html()
                }).get())
            }), s
        }, updateOption: function (t, e, i, n) {
            return "object" == typeof t && (t = t.attr("data-bv-field")), this.options.fields[t] && this.options.fields[t].validators[e] && (this.options.fields[t].validators[e][i] = n, this.updateStatus(t, this.STATUS_NOT_VALIDATED, e)), this
        }, addField: function (e, i) {
            var n = t([]);
            switch (typeof e) {
                case"object":
                    n = e, e = e.attr("data-bv-field") || e.attr("name");
                    break;
                case"string":
                    delete this._cacheFields[e], n = this.getFieldElements(e)
            }
            n.attr("data-bv-field", e);
            for (var s = n.attr("type"), r = "radio" === s || "checkbox" === s ? 1 : n.length, o = 0; o < r; o++) {
                var a = n.eq(o), l = this._parseOptions(a);
                l = null === l ? i : t.extend(!0, i, l), this.options.fields[e] = t.extend(!0, this.options.fields[e], l), this._cacheFields[e] = this._cacheFields[e] ? this._cacheFields[e].add(a) : a, this._initField("checkbox" === s || "radio" === s ? e : a)
            }
            return this.disableSubmitButtons(!1), this.$form.trigger(t.Event(this.options.events.fieldAdded), {
                field: e,
                element: n,
                options: this.options.fields[e]
            }), this
        }, removeField: function (e) {
            var i = t([]);
            switch (typeof e) {
                case"object":
                    i = e, e = e.attr("data-bv-field") || e.attr("name"), i.attr("data-bv-field", e);
                    break;
                case"string":
                    i = this.getFieldElements(e)
            }
            if (0 === i.length) return this;
            for (var n = i.attr("type"), s = "radio" === n || "checkbox" === n ? 1 : i.length, r = 0; r < s; r++) {
                var o = i.eq(r);
                this.$invalidFields = this.$invalidFields.not(o), this._cacheFields[e] = this._cacheFields[e].not(o)
            }
            return this._cacheFields[e] && 0 !== this._cacheFields[e].length || delete this.options.fields[e], "checkbox" !== n && "radio" !== n || this._initField(e), this.disableSubmitButtons(!1), this.$form.trigger(t.Event(this.options.events.fieldRemoved), {
                field: e,
                element: i
            }), this
        }, resetField: function (e, i) {
            var n = t([]);
            switch (typeof e) {
                case"object":
                    n = e, e = e.attr("data-bv-field");
                    break;
                case"string":
                    n = this.getFieldElements(e)
            }
            var s = n.length;
            if (this.options.fields[e]) for (var r = 0; r < s; r++) for (var o in this.options.fields[e].validators) n.eq(r).removeData("bv.dfs." + o);
            if (this.updateStatus(e, this.STATUS_NOT_VALIDATED), i) {
                var a = n.attr("type");
                "radio" === a || "checkbox" === a ? n.removeAttr("checked").removeAttr("selected") : n.val("")
            }
            return this
        }, resetForm: function (e) {
            for (var i in this.options.fields) this.resetField(i, e);
            return this.$invalidFields = t([]), this.$submitButton = null, this.disableSubmitButtons(!1), this
        }, revalidateField: function (t) {
            return this.updateStatus(t, this.STATUS_NOT_VALIDATED).validateField(t), this
        }, enableFieldValidators: function (t, e, i) {
            var n = this.options.fields[t].validators;
            if (i && n && n[i] && n[i].enabled !== e) this.options.fields[t].validators[i].enabled = e, this.updateStatus(t, this.STATUS_NOT_VALIDATED, i); else if (!i && this.options.fields[t].enabled !== e) {
                this.options.fields[t].enabled = e;
                for (var s in n) this.enableFieldValidators(t, e, s)
            }
            return this
        }, getDynamicOption: function (e, i) {
            var n = "string" == typeof e ? this.getFieldElements(e) : e, s = n.val();
            if ("function" == typeof i) return t.fn.bootstrapValidator.helpers.call(i, [s, this, n]);
            if ("string" == typeof i) {
                var r = this.getFieldElements(i);
                return r.length ? r.val() : t.fn.bootstrapValidator.helpers.call(i, [s, this, n]) || i
            }
            return null
        }, destroy: function () {
            var e, i, n, s, r, o;
            for (e in this.options.fields) {
                i = this.getFieldElements(e), o = this.options.fields[e].group || this.options.group;
                for (var a = 0; a < i.length; a++) {
                    if (n = i.eq(a), n.data("bv.messages").find('.help-block[data-bv-validator][data-bv-for="' + e + '"]').remove().end().end().removeData("bv.messages").parents(o).removeClass("has-feedback has-error has-success").end().off(".bv").removeAttr("data-bv-field"), r = n.data("bv.icon")) {
                        switch ("function" == typeof(this.options.fields[e].container || this.options.container) ? (this.options.fields[e].container || this.options.container).call(this, n, this) : this.options.fields[e].container || this.options.container) {
                            case"tooltip":
                                r.tooltip("destroy").remove();
                                break;
                            case"popover":
                                r.popover("destroy").remove();
                                break;
                            default:
                                r.remove()
                        }
                    }
                    n.removeData("bv.icon");
                    for (s in this.options.fields[e].validators) n.data("bv.dfs." + s) && n.data("bv.dfs." + s).reject(), n.removeData("bv.result." + s).removeData("bv.response." + s).removeData("bv.dfs." + s), "function" == typeof t.fn.bootstrapValidator.validators[s].destroy && t.fn.bootstrapValidator.validators[s].destroy(this, n, this.options.fields[e].validators[s])
                }
            }
            this.disableSubmitButtons(!1), this.$hiddenButton.remove(), this.$form.removeClass(this.options.elementClass).off(".bv").removeData("bootstrapValidator").find("[data-bv-submit-hidden]").remove().end().find('[type="submit"]').off("click.bv")
        }
    }, t.fn.bootstrapValidator = function (i) {
        var n = arguments;
        return this.each(function () {
            var s = t(this), r = s.data("bootstrapValidator"), o = "object" == typeof i && i;
            r || (r = new e(this, o), s.data("bootstrapValidator", r)), "string" == typeof i && r[i].apply(r, Array.prototype.slice.call(n, 1))
        })
    }, t.fn.bootstrapValidator.DEFAULT_OPTIONS = {
        autoFocus: !0,
        container: null,
        elementClass: "bv-form",
        events: {
            formInit: "init.form.bv",
            formError: "error.form.bv",
            formSuccess: "success.form.bv",
            fieldAdded: "added.field.bv",
            fieldRemoved: "removed.field.bv",
            fieldInit: "init.field.bv",
            fieldError: "error.field.bv",
            fieldSuccess: "success.field.bv",
            fieldStatus: "status.field.bv",
            validatorError: "error.validator.bv",
            validatorSuccess: "success.validator.bv"
        },
        excluded: [":disabled", ":hidden", ":not(:visible)"],
        feedbackIcons: {valid: null, invalid: null, validating: null},
        fields: null,
        group: ".form-group",
        live: "enabled",
        message: "This value is not valid",
        submitButtons: '[type="submit"]',
        threshold: null,
        verbose: !0
    }, t.fn.bootstrapValidator.validators = {}, t.fn.bootstrapValidator.i18n = {}, t.fn.bootstrapValidator.Constructor = e, t.fn.bootstrapValidator.helpers = {
        call: function (t, e) {
            if ("function" == typeof t) return t.apply(this, e);
            if ("string" == typeof t) {
                "()" === t.substring(t.length - 2) && (t = t.substring(0, t.length - 2));
                for (var i = t.split("."), n = i.pop(), s = window, r = 0; r < i.length; r++) s = s[i[r]];
                return void 0 === s[n] ? null : s[n].apply(this, e)
            }
        }, format: function (e, i) {
            t.isArray(i) || (i = [i]);
            for (var n in i) e = e.replace("%s", i[n]);
            return e
        }, date: function (t, e, i, n) {
            if (isNaN(t) || isNaN(e) || isNaN(i)) return !1;
            if (i.length > 2 || e.length > 2 || t.length > 4) return !1;
            if (i = parseInt(i, 10), e = parseInt(e, 10), (t = parseInt(t, 10)) < 1e3 || t > 9999 || e <= 0 || e > 12) return !1;
            var s = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            if ((t % 400 == 0 || t % 100 != 0 && t % 4 == 0) && (s[1] = 29), i <= 0 || i > s[e - 1]) return !1;
            if (!0 === n) {
                var r = new Date, o = r.getFullYear(), a = r.getMonth(), l = r.getDate();
                return t < o || t === o && e - 1 < a || t === o && e - 1 === a && i < l
            }
            return !0
        }, luhn: function (t) {
            for (var e = t.length, i = 0, n = [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9], [0, 2, 4, 6, 8, 1, 3, 5, 7, 9]], s = 0; e--;) s += n[i][parseInt(t.charAt(e), 10)], i ^= 1;
            return s % 10 == 0 && s > 0
        }, mod11And10: function (t) {
            for (var e = 5, i = t.length, n = 0; n < i; n++) e = (2 * (e || 10) % 11 + parseInt(t.charAt(n), 10)) % 10;
            return 1 === e
        }, mod37And36: function (t, e) {
            e = e || "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            for (var i = e.length, n = t.length, s = Math.floor(i / 2), r = 0; r < n; r++) s = (2 * (s || i) % (i + 1) + e.indexOf(t.charAt(r))) % i;
            return 1 === s
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.base64 = t.extend(t.fn.bootstrapValidator.i18n.base64 || {}, {default: "Please enter a valid base 64 encoded"}), t.fn.bootstrapValidator.validators.base64 = {
        validate: function (t, e, i) {
            var n = e.val();
            return "" === n || /^(?:[A-Za-z0-9+\/]{4})*(?:[A-Za-z0-9+\/]{2}==|[A-Za-z0-9+\/]{3}=|[A-Za-z0-9+\/]{4})$/.test(n)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.between = t.extend(t.fn.bootstrapValidator.i18n.between || {}, {
        default: "Please enter a value between %s and %s",
        notInclusive: "Please enter a value between %s and %s strictly"
    }), t.fn.bootstrapValidator.validators.between = {
        html5Attributes: {
            message: "message",
            min: "min",
            max: "max",
            inclusive: "inclusive"
        }, enableByHtml5: function (t) {
            return "range" === t.attr("type") && {min: t.attr("min"), max: t.attr("max")}
        }, validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            if (s = this._format(s), !t.isNumeric(s)) return !1;
            var r = t.isNumeric(n.min) ? n.min : e.getDynamicOption(i, n.min),
                o = t.isNumeric(n.max) ? n.max : e.getDynamicOption(i, n.max), a = this._format(r), l = this._format(o);
            return s = parseFloat(s), !0 === n.inclusive || void 0 === n.inclusive ? {
                valid: s >= a && s <= l,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.between.default, [r, o])
            } : {
                valid: s > a && s < l,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.between.notInclusive, [r, o])
            }
        }, _format: function (t) {
            return (t + "").replace(",", ".")
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.validators.blank = {
        validate: function (t, e, i) {
            return !0
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.callback = t.extend(t.fn.bootstrapValidator.i18n.callback || {}, {default: "Please enter a valid value"}), t.fn.bootstrapValidator.validators.callback = {
        html5Attributes: {
            message: "message",
            callback: "callback"
        }, validate: function (e, i, n) {
            var s = i.val(), r = new t.Deferred, o = {valid: !0};
            if (n.callback) {
                var a = t.fn.bootstrapValidator.helpers.call(n.callback, [s, e, i]);
                o = "boolean" == typeof a ? {valid: a} : a
            }
            return r.resolve(i, "callback", o), r
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.choice = t.extend(t.fn.bootstrapValidator.i18n.choice || {}, {
        default: "Please enter a valid value",
        less: "Please choose %s options at minimum",
        more: "Please choose %s options at maximum",
        between: "Please choose %s - %s options"
    }), t.fn.bootstrapValidator.validators.choice = {
        html5Attributes: {message: "message", min: "min", max: "max"},
        validate: function (e, i, n) {
            var s = i.is("select") ? e.getFieldElements(i.attr("data-bv-field")).find("option").filter(":selected").length : e.getFieldElements(i.attr("data-bv-field")).filter(":checked").length,
                r = n.min ? t.isNumeric(n.min) ? n.min : e.getDynamicOption(i, n.min) : null,
                o = n.max ? t.isNumeric(n.max) ? n.max : e.getDynamicOption(i, n.max) : null, a = !0,
                l = n.message || t.fn.bootstrapValidator.i18n.choice.default;
            switch ((r && s < parseInt(r, 10) || o && s > parseInt(o, 10)) && (a = !1), !0) {
                case!!r && !!o:
                    l = t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.choice.between, [parseInt(r, 10), parseInt(o, 10)]);
                    break;
                case!!r:
                    l = t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.choice.less, parseInt(r, 10));
                    break;
                case!!o:
                    l = t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.choice.more, parseInt(o, 10))
            }
            return {valid: a, message: l}
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.color = t.extend(t.fn.bootstrapValidator.i18n.color || {}, {default: "Please enter a valid color"}), t.fn.bootstrapValidator.validators.color = {
        SUPPORTED_TYPES: ["hex", "rgb", "rgba", "hsl", "hsla", "keyword"],
        KEYWORD_COLORS: ["aliceblue", "antiquewhite", "aqua", "aquamarine", "azure", "beige", "bisque", "black", "blanchedalmond", "blue", "blueviolet", "brown", "burlywood", "cadetblue", "chartreuse", "chocolate", "coral", "cornflowerblue", "cornsilk", "crimson", "cyan", "darkblue", "darkcyan", "darkgoldenrod", "darkgray", "darkgreen", "darkgrey", "darkkhaki", "darkmagenta", "darkolivegreen", "darkorange", "darkorchid", "darkred", "darksalmon", "darkseagreen", "darkslateblue", "darkslategray", "darkslategrey", "darkturquoise", "darkviolet", "deeppink", "deepskyblue", "dimgray", "dimgrey", "dodgerblue", "firebrick", "floralwhite", "forestgreen", "fuchsia", "gainsboro", "ghostwhite", "gold", "goldenrod", "gray", "green", "greenyellow", "grey", "honeydew", "hotpink", "indianred", "indigo", "ivory", "khaki", "lavender", "lavenderblush", "lawngreen", "lemonchiffon", "lightblue", "lightcoral", "lightcyan", "lightgoldenrodyellow", "lightgray", "lightgreen", "lightgrey", "lightpink", "lightsalmon", "lightseagreen", "lightskyblue", "lightslategray", "lightslategrey", "lightsteelblue", "lightyellow", "lime", "limegreen", "linen", "magenta", "maroon", "mediumaquamarine", "mediumblue", "mediumorchid", "mediumpurple", "mediumseagreen", "mediumslateblue", "mediumspringgreen", "mediumturquoise", "mediumvioletred", "midnightblue", "mintcream", "mistyrose", "moccasin", "navajowhite", "navy", "oldlace", "olive", "olivedrab", "orange", "orangered", "orchid", "palegoldenrod", "palegreen", "paleturquoise", "palevioletred", "papayawhip", "peachpuff", "peru", "pink", "plum", "powderblue", "purple", "red", "rosybrown", "royalblue", "saddlebrown", "salmon", "sandybrown", "seagreen", "seashell", "sienna", "silver", "skyblue", "slateblue", "slategray", "slategrey", "snow", "springgreen", "steelblue", "tan", "teal", "thistle", "tomato", "transparent", "turquoise", "violet", "wheat", "white", "whitesmoke", "yellow", "yellowgreen"],
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            var r = n.type || this.SUPPORTED_TYPES;
            t.isArray(r) || (r = r.replace(/s/g, "").split(","));
            for (var o, a, l = !1, c = 0; c < r.length; c++) if (a = r[c], o = "_" + a.toLowerCase(), l = l || this[o](s)) return !0;
            return !1
        },
        _hex: function (t) {
            return /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(t)
        },
        _hsl: function (t) {
            return /^hsl\((\s*(-?\d+)\s*,)(\s*(\b(0?\d{1,2}|100)\b%)\s*,)(\s*(\b(0?\d{1,2}|100)\b%)\s*)\)$/.test(t)
        },
        _hsla: function (t) {
            return /^hsla\((\s*(-?\d+)\s*,)(\s*(\b(0?\d{1,2}|100)\b%)\s*,){2}(\s*(0?(\.\d+)?|1(\.0+)?)\s*)\)$/.test(t)
        },
        _keyword: function (e) {
            return t.inArray(e, this.KEYWORD_COLORS) >= 0
        },
        _rgb: function (t) {
            var e = /^rgb\((\s*(\b([01]?\d{1,2}|2[0-4]\d|25[0-5])\b)\s*,){2}(\s*(\b([01]?\d{1,2}|2[0-4]\d|25[0-5])\b)\s*)\)$/,
                i = /^rgb\((\s*(\b(0?\d{1,2}|100)\b%)\s*,){2}(\s*(\b(0?\d{1,2}|100)\b%)\s*)\)$/;
            return e.test(t) || i.test(t)
        },
        _rgba: function (t) {
            var e = /^rgba\((\s*(\b([01]?\d{1,2}|2[0-4]\d|25[0-5])\b)\s*,){3}(\s*(0?(\.\d+)?|1(\.0+)?)\s*)\)$/,
                i = /^rgba\((\s*(\b(0?\d{1,2}|100)\b%)\s*,){3}(\s*(0?(\.\d+)?|1(\.0+)?)\s*)\)$/;
            return e.test(t) || i.test(t)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.creditCard = t.extend(t.fn.bootstrapValidator.i18n.creditCard || {}, {default: "Please enter a valid credit card number"}), t.fn.bootstrapValidator.validators.creditCard = {
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            if (/[^0-9-\s]+/.test(s)) return !1;
            if (s = s.replace(/\D/g, ""), !t.fn.bootstrapValidator.helpers.luhn(s)) return !1;
            var r, o, a = {
                AMERICAN_EXPRESS: {length: [15], prefix: ["34", "37"]},
                DINERS_CLUB: {length: [14], prefix: ["300", "301", "302", "303", "304", "305", "36"]},
                DINERS_CLUB_US: {length: [16], prefix: ["54", "55"]},
                DISCOVER: {
                    length: [16],
                    prefix: ["6011", "622126", "622127", "622128", "622129", "62213", "62214", "62215", "62216", "62217", "62218", "62219", "6222", "6223", "6224", "6225", "6226", "6227", "6228", "62290", "62291", "622920", "622921", "622922", "622923", "622924", "622925", "644", "645", "646", "647", "648", "649", "65"]
                },
                JCB: {length: [16], prefix: ["3528", "3529", "353", "354", "355", "356", "357", "358"]},
                LASER: {length: [16, 17, 18, 19], prefix: ["6304", "6706", "6771", "6709"]},
                MAESTRO: {
                    length: [12, 13, 14, 15, 16, 17, 18, 19],
                    prefix: ["5018", "5020", "5038", "6304", "6759", "6761", "6762", "6763", "6764", "6765", "6766"]
                },
                MASTERCARD: {length: [16], prefix: ["51", "52", "53", "54", "55"]},
                SOLO: {length: [16, 18, 19], prefix: ["6334", "6767"]},
                UNIONPAY: {
                    length: [16, 17, 18, 19],
                    prefix: ["622126", "622127", "622128", "622129", "62213", "62214", "62215", "62216", "62217", "62218", "62219", "6222", "6223", "6224", "6225", "6226", "6227", "6228", "62290", "62291", "622920", "622921", "622922", "622923", "622924", "622925"]
                },
                VISA: {length: [16], prefix: ["4"]}
            };
            for (r in a) for (o in a[r].prefix) if (s.substr(0, a[r].prefix[o].length) === a[r].prefix[o] && -1 !== t.inArray(s.length, a[r].length)) return !0;
            return !1
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.cusip = t.extend(t.fn.bootstrapValidator.i18n.cusip || {}, {default: "Please enter a valid CUSIP number"}), t.fn.bootstrapValidator.validators.cusip = {
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            if (s = s.toUpperCase(), !/^[0-9A-Z]{9}$/.test(s)) return !1;
            for (var r = t.map(s.split(""), function (t) {
                var e = t.charCodeAt(0);
                return e >= "A".charCodeAt(0) && e <= "Z".charCodeAt(0) ? e - "A".charCodeAt(0) + 10 : t
            }), o = r.length, a = 0, l = 0; l < o - 1; l++) {
                var c = parseInt(r[l], 10);
                l % 2 != 0 && (c *= 2), c > 9 && (c -= 9), a += c
            }
            return (a = (10 - a % 10) % 10) === r[o - 1]
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.cvv = t.extend(t.fn.bootstrapValidator.i18n.cvv || {}, {default: "Please enter a valid CVV number"}), t.fn.bootstrapValidator.validators.cvv = {
        html5Attributes: {
            message: "message",
            ccfield: "creditCardField"
        }, validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            if (!/^[0-9]{3,4}$/.test(s)) return !1;
            if (!n.creditCardField) return !0;
            var r = e.getFieldElements(n.creditCardField).val();
            if ("" === r) return !0;
            r = r.replace(/\D/g, "");
            var o, a, l = {
                AMERICAN_EXPRESS: {length: [15], prefix: ["34", "37"]},
                DINERS_CLUB: {length: [14], prefix: ["300", "301", "302", "303", "304", "305", "36"]},
                DINERS_CLUB_US: {length: [16], prefix: ["54", "55"]},
                DISCOVER: {
                    length: [16],
                    prefix: ["6011", "622126", "622127", "622128", "622129", "62213", "62214", "62215", "62216", "62217", "62218", "62219", "6222", "6223", "6224", "6225", "6226", "6227", "6228", "62290", "62291", "622920", "622921", "622922", "622923", "622924", "622925", "644", "645", "646", "647", "648", "649", "65"]
                },
                JCB: {length: [16], prefix: ["3528", "3529", "353", "354", "355", "356", "357", "358"]},
                LASER: {length: [16, 17, 18, 19], prefix: ["6304", "6706", "6771", "6709"]},
                MAESTRO: {
                    length: [12, 13, 14, 15, 16, 17, 18, 19],
                    prefix: ["5018", "5020", "5038", "6304", "6759", "6761", "6762", "6763", "6764", "6765", "6766"]
                },
                MASTERCARD: {length: [16], prefix: ["51", "52", "53", "54", "55"]},
                SOLO: {length: [16, 18, 19], prefix: ["6334", "6767"]},
                UNIONPAY: {
                    length: [16, 17, 18, 19],
                    prefix: ["622126", "622127", "622128", "622129", "62213", "62214", "62215", "62216", "62217", "62218", "62219", "6222", "6223", "6224", "6225", "6226", "6227", "6228", "62290", "62291", "622920", "622921", "622922", "622923", "622924", "622925"]
                },
                VISA: {length: [16], prefix: ["4"]}
            }, c = null;
            for (o in l) for (a in l[o].prefix) if (r.substr(0, l[o].prefix[a].length) === l[o].prefix[a] && -1 !== t.inArray(r.length, l[o].length)) {
                c = o;
                break
            }
            return null !== c && ("AMERICAN_EXPRESS" === c ? 4 === s.length : 3 === s.length)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.date = t.extend(t.fn.bootstrapValidator.i18n.date || {}, {
        default: "Please enter a valid date",
        min: "Please enter a date after %s",
        max: "Please enter a date before %s",
        range: "Please enter a date in the range %s - %s"
    }), t.fn.bootstrapValidator.validators.date = {
        html5Attributes: {message: "message", format: "format", min: "min", max: "max", separator: "separator"},
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            n.format = n.format || "MM/DD/YYYY", "date" === i.attr("type") && (n.format = "YYYY-MM-DD");
            var r = n.format.split(" "), o = r[0], a = r.length > 1 ? r[1] : null, l = r.length > 2 ? r[2] : null,
                c = s.split(" "), u = c[0], h = c.length > 1 ? c[1] : null;
            if (r.length !== c.length) return {
                valid: !1,
                message: n.message || t.fn.bootstrapValidator.i18n.date.default
            };
            var d = n.separator;
            if (d || (d = -1 !== u.indexOf("/") ? "/" : -1 !== u.indexOf("-") ? "-" : null), null === d || -1 === u.indexOf(d)) return {
                valid: !1,
                message: n.message || t.fn.bootstrapValidator.i18n.date.default
            };
            if (u = u.split(d), o = o.split(d), u.length !== o.length) return {
                valid: !1,
                message: n.message || t.fn.bootstrapValidator.i18n.date.default
            };
            var p = u[t.inArray("YYYY", o)], f = u[t.inArray("MM", o)], g = u[t.inArray("DD", o)];
            if (!p || !f || !g || 4 !== p.length) return {
                valid: !1,
                message: n.message || t.fn.bootstrapValidator.i18n.date.default
            };
            var m = null, v = null, b = null;
            if (a) {
                if (a = a.split(":"), h = h.split(":"), a.length !== h.length) return {
                    valid: !1,
                    message: n.message || t.fn.bootstrapValidator.i18n.date.default
                };
                if (v = h.length > 0 ? h[0] : null, m = h.length > 1 ? h[1] : null, b = h.length > 2 ? h[2] : null) {
                    if (isNaN(b) || b.length > 2) return {
                        valid: !1,
                        message: n.message || t.fn.bootstrapValidator.i18n.date.default
                    };
                    if ((b = parseInt(b, 10)) < 0 || b > 60) return {
                        valid: !1,
                        message: n.message || t.fn.bootstrapValidator.i18n.date.default
                    }
                }
                if (v) {
                    if (isNaN(v) || v.length > 2) return {
                        valid: !1,
                        message: n.message || t.fn.bootstrapValidator.i18n.date.default
                    };
                    if ((v = parseInt(v, 10)) < 0 || v >= 24 || l && v > 12) return {
                        valid: !1,
                        message: n.message || t.fn.bootstrapValidator.i18n.date.default
                    }
                }
                if (m) {
                    if (isNaN(m) || m.length > 2) return {
                        valid: !1,
                        message: n.message || t.fn.bootstrapValidator.i18n.date.default
                    };
                    if ((m = parseInt(m, 10)) < 0 || m > 59) return {
                        valid: !1,
                        message: n.message || t.fn.bootstrapValidator.i18n.date.default
                    }
                }
            }
            var y = t.fn.bootstrapValidator.helpers.date(p, f, g),
                w = n.message || t.fn.bootstrapValidator.i18n.date.default, x = null, _ = null, A = n.min, C = n.max;
            switch (A && (isNaN(Date.parse(A)) && (A = e.getDynamicOption(i, A)), x = this._parseDate(A, o, d)), C && (isNaN(Date.parse(C)) && (C = e.getDynamicOption(i, C)), _ = this._parseDate(C, o, d)), u = new Date(p, f, g, v, m, b), !0) {
                case A && !C && y:
                    y = u.getTime() >= x.getTime(), w = n.message || t.fn.bootstrapValidator.helpers.format(t.fn.bootstrapValidator.i18n.date.min, A);
                    break;
                case C && !A && y:
                    y = u.getTime() <= _.getTime(), w = n.message || t.fn.bootstrapValidator.helpers.format(t.fn.bootstrapValidator.i18n.date.max, C);
                    break;
                case C && A && y:
                    y = u.getTime() <= _.getTime() && u.getTime() >= x.getTime(), w = n.message || t.fn.bootstrapValidator.helpers.format(t.fn.bootstrapValidator.i18n.date.range, [A, C])
            }
            return {valid: y, message: w}
        },
        _parseDate: function (e, i, n) {
            var s = 0, r = 0, o = 0, a = e.split(" "), l = a[0], c = a.length > 1 ? a[1] : null;
            l = l.split(n);
            var u = l[t.inArray("YYYY", i)], h = l[t.inArray("MM", i)], d = l[t.inArray("DD", i)];
            return c && (c = c.split(":"), r = c.length > 0 ? c[0] : null, s = c.length > 1 ? c[1] : null, o = c.length > 2 ? c[2] : null), new Date(u, h, d, r, s, o)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.different = t.extend(t.fn.bootstrapValidator.i18n.different || {}, {default: "Please enter a different value"}), t.fn.bootstrapValidator.validators.different = {
        html5Attributes: {
            message: "message",
            field: "field"
        }, validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            for (var s = i.field.split(","), r = !0, o = 0; o < s.length; o++) {
                var a = t.getFieldElements(s[o]);
                if (null != a && 0 !== a.length) {
                    var l = a.val();
                    n === l ? r = !1 : "" !== l && t.updateStatus(a, t.STATUS_VALID, "different")
                }
            }
            return r
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.digits = t.extend(t.fn.bootstrapValidator.i18n.digits || {}, {default: "Please enter only digits"}), t.fn.bootstrapValidator.validators.digits = {
        validate: function (t, e, i) {
            var n = e.val();
            return "" === n || /^\d+$/.test(n)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.ean = t.extend(t.fn.bootstrapValidator.i18n.ean || {}, {default: "Please enter a valid EAN number"}), t.fn.bootstrapValidator.validators.ean = {
        validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            if (!/^(\d{8}|\d{12}|\d{13})$/.test(n)) return !1;
            for (var s = n.length, r = 0, o = 8 === s ? [3, 1] : [1, 3], a = 0; a < s - 1; a++) r += parseInt(n.charAt(a), 10) * o[a % 2];
            return (r = (10 - r % 10) % 10) + "" === n.charAt(s - 1)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.emailAddress = t.extend(t.fn.bootstrapValidator.i18n.emailAddress || {}, {default: "Please enter a valid email address"}), t.fn.bootstrapValidator.validators.emailAddress = {
        html5Attributes: {
            message: "message",
            multiple: "multiple",
            separator: "separator"
        }, enableByHtml5: function (t) {
            return "email" === t.attr("type")
        }, validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            var s = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
            if (!0 === i.multiple || "true" === i.multiple) {
                for (var r = i.separator || /[,;]/, o = this._splitEmailAddresses(n, r), a = 0; a < o.length; a++) if (!s.test(o[a])) return !1;
                return !0
            }
            return s.test(n)
        }, _splitEmailAddresses: function (t, e) {
            for (var i = t.split(/"/), n = i.length, s = [], r = "", o = 0; o < n; o++) if (o % 2 == 0) {
                var a = i[o].split(e), l = a.length;
                if (1 === l) r += a[0]; else {
                    s.push(r + a[0]);
                    for (var c = 1; c < l - 1; c++) s.push(a[c]);
                    r = a[l - 1]
                }
            } else r += '"' + i[o], o < n - 1 && (r += '"');
            return s.push(r), s
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.file = t.extend(t.fn.bootstrapValidator.i18n.file || {}, {default: "Please choose a valid file"}), t.fn.bootstrapValidator.validators.file = {
        html5Attributes: {
            extension: "extension",
            maxfiles: "maxFiles",
            minfiles: "minFiles",
            maxsize: "maxSize",
            minsize: "minSize",
            maxtotalsize: "maxTotalSize",
            mintotalsize: "minTotalSize",
            message: "message",
            type: "type"
        }, validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            var r, o = n.extension ? n.extension.toLowerCase().split(",") : null,
                a = n.type ? n.type.toLowerCase().split(",") : null;
            if (window.File && window.FileList && window.FileReader) {
                var l = i.get(0).files, c = l.length, u = 0;
                if (n.maxFiles && c > parseInt(n.maxFiles, 10) || n.minFiles && c < parseInt(n.minFiles, 10)) return !1;
                for (var h = 0; h < c; h++) if (u += l[h].size, r = l[h].name.substr(l[h].name.lastIndexOf(".") + 1), n.minSize && l[h].size < parseInt(n.minSize, 10) || n.maxSize && l[h].size > parseInt(n.maxSize, 10) || o && -1 === t.inArray(r.toLowerCase(), o) || l[h].type && a && -1 === t.inArray(l[h].type.toLowerCase(), a)) return !1;
                if (n.maxTotalSize && u > parseInt(n.maxTotalSize, 10) || n.minTotalSize && u < parseInt(n.minTotalSize, 10)) return !1
            } else if (r = s.substr(s.lastIndexOf(".") + 1), o && -1 === t.inArray(r.toLowerCase(), o)) return !1;
            return !0
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.greaterThan = t.extend(t.fn.bootstrapValidator.i18n.greaterThan || {}, {
        default: "Please enter a value greater than or equal to %s",
        notInclusive: "Please enter a value greater than %s"
    }), t.fn.bootstrapValidator.validators.greaterThan = {
        html5Attributes: {
            message: "message",
            value: "value",
            inclusive: "inclusive"
        }, enableByHtml5: function (t) {
            var e = t.attr("type"), i = t.attr("min");
            return !(!i || "date" === e) && {value: i}
        }, validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            if (s = this._format(s), !t.isNumeric(s)) return !1;
            var r = t.isNumeric(n.value) ? n.value : e.getDynamicOption(i, n.value), o = this._format(r);
            return s = parseFloat(s), !0 === n.inclusive || void 0 === n.inclusive ? {
                valid: s >= o,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.greaterThan.default, r)
            } : {
                valid: s > o,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.greaterThan.notInclusive, r)
            }
        }, _format: function (t) {
            return (t + "").replace(",", ".")
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.grid = t.extend(t.fn.bootstrapValidator.i18n.grid || {}, {default: "Please enter a valid GRId number"}), t.fn.bootstrapValidator.validators.grid = {
        validate: function (e, i, n) {
            var s = i.val();
            return "" === s || (s = s.toUpperCase(), !!/^[GRID:]*([0-9A-Z]{2})[-\s]*([0-9A-Z]{5})[-\s]*([0-9A-Z]{10})[-\s]*([0-9A-Z]{1})$/g.test(s) && (s = s.replace(/\s/g, "").replace(/-/g, ""), "GRID:" === s.substr(0, 5) && (s = s.substr(5)), t.fn.bootstrapValidator.helpers.mod37And36(s)))
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.hex = t.extend(t.fn.bootstrapValidator.i18n.hex || {}, {default: "Please enter a valid hexadecimal number"}), t.fn.bootstrapValidator.validators.hex = {
        validate: function (t, e, i) {
            var n = e.val();
            return "" === n || /^[0-9a-fA-F]+$/.test(n)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.hexColor = t.extend(t.fn.bootstrapValidator.i18n.hexColor || {}, {default: "Please enter a valid hex color"}), t.fn.bootstrapValidator.validators.hexColor = {
        enableByHtml5: function (t) {
            return "color" === t.attr("type")
        }, validate: function (t, e, i) {
            var n = e.val();
            return "" === n || ("color" === e.attr("type") ? /^#[0-9A-F]{6}$/i.test(n) : /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(n))
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.iban = t.extend(t.fn.bootstrapValidator.i18n.iban || {}, {
        default: "Please enter a valid IBAN number",
        countryNotSupported: "The country code %s is not supported",
        country: "Please enter a valid IBAN number in %s",
        countries: {
            AD: "Andorra",
            AE: "United Arab Emirates",
            AL: "Albania",
            AO: "Angola",
            AT: "Austria",
            AZ: "Azerbaijan",
            BA: "Bosnia and Herzegovina",
            BE: "Belgium",
            BF: "Burkina Faso",
            BG: "Bulgaria",
            BH: "Bahrain",
            BI: "Burundi",
            BJ: "Benin",
            BR: "Brazil",
            CH: "Switzerland",
            CI: "Ivory Coast",
            CM: "Cameroon",
            CR: "Costa Rica",
            CV: "Cape Verde",
            CY: "Cyprus",
            CZ: "Czech Republic",
            DE: "Germany",
            DK: "Denmark",
            DO: "Dominican Republic",
            DZ: "Algeria",
            EE: "Estonia",
            ES: "Spain",
            FI: "Finland",
            FO: "Faroe Islands",
            FR: "France",
            GB: "United Kingdom",
            GE: "Georgia",
            GI: "Gibraltar",
            GL: "Greenland",
            GR: "Greece",
            GT: "Guatemala",
            HR: "Croatia",
            HU: "Hungary",
            IE: "Ireland",
            IL: "Israel",
            IR: "Iran",
            IS: "Iceland",
            IT: "Italy",
            JO: "Jordan",
            KW: "Kuwait",
            KZ: "Kazakhstan",
            LB: "Lebanon",
            LI: "Liechtenstein",
            LT: "Lithuania",
            LU: "Luxembourg",
            LV: "Latvia",
            MC: "Monaco",
            MD: "Moldova",
            ME: "Montenegro",
            MG: "Madagascar",
            MK: "Macedonia",
            ML: "Mali",
            MR: "Mauritania",
            MT: "Malta",
            MU: "Mauritius",
            MZ: "Mozambique",
            NL: "Netherlands",
            NO: "Norway",
            PK: "Pakistan",
            PL: "Poland",
            PS: "Palestine",
            PT: "Portugal",
            QA: "Qatar",
            RO: "Romania",
            RS: "Serbia",
            SA: "Saudi Arabia",
            SE: "Sweden",
            SI: "Slovenia",
            SK: "Slovakia",
            SM: "San Marino",
            SN: "Senegal",
            TN: "Tunisia",
            TR: "Turkey",
            VG: "Virgin Islands, British"
        }
    }), t.fn.bootstrapValidator.validators.iban = {
        html5Attributes: {message: "message", country: "country"},
        REGEX: {
            AD: "AD[0-9]{2}[0-9]{4}[0-9]{4}[A-Z0-9]{12}",
            AE: "AE[0-9]{2}[0-9]{3}[0-9]{16}",
            AL: "AL[0-9]{2}[0-9]{8}[A-Z0-9]{16}",
            AO: "AO[0-9]{2}[0-9]{21}",
            AT: "AT[0-9]{2}[0-9]{5}[0-9]{11}",
            AZ: "AZ[0-9]{2}[A-Z]{4}[A-Z0-9]{20}",
            BA: "BA[0-9]{2}[0-9]{3}[0-9]{3}[0-9]{8}[0-9]{2}",
            BE: "BE[0-9]{2}[0-9]{3}[0-9]{7}[0-9]{2}",
            BF: "BF[0-9]{2}[0-9]{23}",
            BG: "BG[0-9]{2}[A-Z]{4}[0-9]{4}[0-9]{2}[A-Z0-9]{8}",
            BH: "BH[0-9]{2}[A-Z]{4}[A-Z0-9]{14}",
            BI: "BI[0-9]{2}[0-9]{12}",
            BJ: "BJ[0-9]{2}[A-Z]{1}[0-9]{23}",
            BR: "BR[0-9]{2}[0-9]{8}[0-9]{5}[0-9]{10}[A-Z][A-Z0-9]",
            CH: "CH[0-9]{2}[0-9]{5}[A-Z0-9]{12}",
            CI: "CI[0-9]{2}[A-Z]{1}[0-9]{23}",
            CM: "CM[0-9]{2}[0-9]{23}",
            CR: "CR[0-9]{2}[0-9]{3}[0-9]{14}",
            CV: "CV[0-9]{2}[0-9]{21}",
            CY: "CY[0-9]{2}[0-9]{3}[0-9]{5}[A-Z0-9]{16}",
            CZ: "CZ[0-9]{2}[0-9]{20}",
            DE: "DE[0-9]{2}[0-9]{8}[0-9]{10}",
            DK: "DK[0-9]{2}[0-9]{14}",
            DO: "DO[0-9]{2}[A-Z0-9]{4}[0-9]{20}",
            DZ: "DZ[0-9]{2}[0-9]{20}",
            EE: "EE[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{11}[0-9]{1}",
            ES: "ES[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{1}[0-9]{1}[0-9]{10}",
            FI: "FI[0-9]{2}[0-9]{6}[0-9]{7}[0-9]{1}",
            FO: "FO[0-9]{2}[0-9]{4}[0-9]{9}[0-9]{1}",
            FR: "FR[0-9]{2}[0-9]{5}[0-9]{5}[A-Z0-9]{11}[0-9]{2}",
            GB: "GB[0-9]{2}[A-Z]{4}[0-9]{6}[0-9]{8}",
            GE: "GE[0-9]{2}[A-Z]{2}[0-9]{16}",
            GI: "GI[0-9]{2}[A-Z]{4}[A-Z0-9]{15}",
            GL: "GL[0-9]{2}[0-9]{4}[0-9]{9}[0-9]{1}",
            GR: "GR[0-9]{2}[0-9]{3}[0-9]{4}[A-Z0-9]{16}",
            GT: "GT[0-9]{2}[A-Z0-9]{4}[A-Z0-9]{20}",
            HR: "HR[0-9]{2}[0-9]{7}[0-9]{10}",
            HU: "HU[0-9]{2}[0-9]{3}[0-9]{4}[0-9]{1}[0-9]{15}[0-9]{1}",
            IE: "IE[0-9]{2}[A-Z]{4}[0-9]{6}[0-9]{8}",
            IL: "IL[0-9]{2}[0-9]{3}[0-9]{3}[0-9]{13}",
            IR: "IR[0-9]{2}[0-9]{22}",
            IS: "IS[0-9]{2}[0-9]{4}[0-9]{2}[0-9]{6}[0-9]{10}",
            IT: "IT[0-9]{2}[A-Z]{1}[0-9]{5}[0-9]{5}[A-Z0-9]{12}",
            JO: "JO[0-9]{2}[A-Z]{4}[0-9]{4}[0]{8}[A-Z0-9]{10}",
            KW: "KW[0-9]{2}[A-Z]{4}[0-9]{22}",
            KZ: "KZ[0-9]{2}[0-9]{3}[A-Z0-9]{13}",
            LB: "LB[0-9]{2}[0-9]{4}[A-Z0-9]{20}",
            LI: "LI[0-9]{2}[0-9]{5}[A-Z0-9]{12}",
            LT: "LT[0-9]{2}[0-9]{5}[0-9]{11}",
            LU: "LU[0-9]{2}[0-9]{3}[A-Z0-9]{13}",
            LV: "LV[0-9]{2}[A-Z]{4}[A-Z0-9]{13}",
            MC: "MC[0-9]{2}[0-9]{5}[0-9]{5}[A-Z0-9]{11}[0-9]{2}",
            MD: "MD[0-9]{2}[A-Z0-9]{20}",
            ME: "ME[0-9]{2}[0-9]{3}[0-9]{13}[0-9]{2}",
            MG: "MG[0-9]{2}[0-9]{23}",
            MK: "MK[0-9]{2}[0-9]{3}[A-Z0-9]{10}[0-9]{2}",
            ML: "ML[0-9]{2}[A-Z]{1}[0-9]{23}",
            MR: "MR13[0-9]{5}[0-9]{5}[0-9]{11}[0-9]{2}",
            MT: "MT[0-9]{2}[A-Z]{4}[0-9]{5}[A-Z0-9]{18}",
            MU: "MU[0-9]{2}[A-Z]{4}[0-9]{2}[0-9]{2}[0-9]{12}[0-9]{3}[A-Z]{3}",
            MZ: "MZ[0-9]{2}[0-9]{21}",
            NL: "NL[0-9]{2}[A-Z]{4}[0-9]{10}",
            NO: "NO[0-9]{2}[0-9]{4}[0-9]{6}[0-9]{1}",
            PK: "PK[0-9]{2}[A-Z]{4}[A-Z0-9]{16}",
            PL: "PL[0-9]{2}[0-9]{8}[0-9]{16}",
            PS: "PS[0-9]{2}[A-Z]{4}[A-Z0-9]{21}",
            PT: "PT[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{11}[0-9]{2}",
            QA: "QA[0-9]{2}[A-Z]{4}[A-Z0-9]{21}",
            RO: "RO[0-9]{2}[A-Z]{4}[A-Z0-9]{16}",
            RS: "RS[0-9]{2}[0-9]{3}[0-9]{13}[0-9]{2}",
            SA: "SA[0-9]{2}[0-9]{2}[A-Z0-9]{18}",
            SE: "SE[0-9]{2}[0-9]{3}[0-9]{16}[0-9]{1}",
            SI: "SI[0-9]{2}[0-9]{5}[0-9]{8}[0-9]{2}",
            SK: "SK[0-9]{2}[0-9]{4}[0-9]{6}[0-9]{10}",
            SM: "SM[0-9]{2}[A-Z]{1}[0-9]{5}[0-9]{5}[A-Z0-9]{12}",
            SN: "SN[0-9]{2}[A-Z]{1}[0-9]{23}",
            TN: "TN59[0-9]{2}[0-9]{3}[0-9]{13}[0-9]{2}",
            TR: "TR[0-9]{2}[0-9]{5}[A-Z0-9]{1}[A-Z0-9]{16}",
            VG: "VG[0-9]{2}[A-Z]{4}[0-9]{16}"
        },
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            s = s.replace(/[^a-zA-Z0-9]/g, "").toUpperCase();
            var r = n.country;
            if (r ? "string" == typeof r && this.REGEX[r] || (r = e.getDynamicOption(i, r)) : r = s.substr(0, 2), !this.REGEX[r]) return {
                valid: !1,
                message: t.fn.bootstrapValidator.helpers.format(t.fn.bootstrapValidator.i18n.iban.countryNotSupported, r)
            };
            if (!new RegExp("^" + this.REGEX[r] + "$").test(s)) return {
                valid: !1,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.iban.country, t.fn.bootstrapValidator.i18n.iban.countries[r])
            };
            s = s.substr(4) + s.substr(0, 4), s = t.map(s.split(""), function (t) {
                var e = t.charCodeAt(0);
                return e >= "A".charCodeAt(0) && e <= "Z".charCodeAt(0) ? e - "A".charCodeAt(0) + 10 : t
            }), s = s.join("");
            for (var o = parseInt(s.substr(0, 1), 10), a = s.length, l = 1; l < a; ++l) o = (10 * o + parseInt(s.substr(l, 1), 10)) % 97;
            return {
                valid: 1 === o,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.iban.country, t.fn.bootstrapValidator.i18n.iban.countries[r])
            }
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.id = t.extend(t.fn.bootstrapValidator.i18n.id || {}, {
        default: "Please enter a valid identification number",
        countryNotSupported: "The country code %s is not supported",
        country: "Please enter a valid identification number in %s",
        countries: {
            BA: "Bosnia and Herzegovina",
            BG: "Bulgaria",
            BR: "Brazil",
            CH: "Switzerland",
            CL: "Chile",
            CN: "China",
            CZ: "Czech Republic",
            DK: "Denmark",
            EE: "Estonia",
            ES: "Spain",
            FI: "Finland",
            HR: "Croatia",
            IE: "Ireland",
            IS: "Iceland",
            LT: "Lithuania",
            LV: "Latvia",
            ME: "Montenegro",
            MK: "Macedonia",
            NL: "Netherlands",
            RO: "Romania",
            RS: "Serbia",
            SE: "Sweden",
            SI: "Slovenia",
            SK: "Slovakia",
            SM: "San Marino",
            TH: "Thailand",
            ZA: "South Africa"
        }
    }), t.fn.bootstrapValidator.validators.id = {
        html5Attributes: {message: "message", country: "country"},
        COUNTRY_CODES: ["BA", "BG", "BR", "CH", "CL", "CN", "CZ", "DK", "EE", "ES", "FI", "HR", "IE", "IS", "LT", "LV", "ME", "MK", "NL", "RO", "RS", "SE", "SI", "SK", "SM", "TH", "ZA"],
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            var r = n.country;
            return r ? "string" == typeof r && -1 !== t.inArray(r.toUpperCase(), this.COUNTRY_CODES) || (r = e.getDynamicOption(i, r)) : r = s.substr(0, 2), -1 === t.inArray(r, this.COUNTRY_CODES) ? {
                valid: !1,
                message: t.fn.bootstrapValidator.helpers.format(t.fn.bootstrapValidator.i18n.id.countryNotSupported, r)
            } : !!this[["_", r.toLowerCase()].join("")](s) || {
                valid: !1,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.id.country, t.fn.bootstrapValidator.i18n.id.countries[r.toUpperCase()])
            }
        },
        _validateJMBG: function (t, e) {
            if (!/^\d{13}$/.test(t)) return !1;
            var i = parseInt(t.substr(0, 2), 10), n = parseInt(t.substr(2, 2), 10),
                s = (parseInt(t.substr(4, 3), 10), parseInt(t.substr(7, 2), 10)), r = parseInt(t.substr(12, 1), 10);
            if (i > 31 || n > 12) return !1;
            for (var o = 0, a = 0; a < 6; a++) o += (7 - a) * (parseInt(t.charAt(a), 10) + parseInt(t.charAt(a + 6), 10));
            if (o = 11 - o % 11, 10 !== o && 11 !== o || (o = 0), o !== r) return !1;
            switch (e.toUpperCase()) {
                case"BA":
                    return 10 <= s && s <= 19;
                case"MK":
                    return 41 <= s && s <= 49;
                case"ME":
                    return 20 <= s && s <= 29;
                case"RS":
                    return 70 <= s && s <= 99;
                case"SI":
                    return 50 <= s && s <= 59;
                default:
                    return !0
            }
        },
        _ba: function (t) {
            return this._validateJMBG(t, "BA")
        },
        _mk: function (t) {
            return this._validateJMBG(t, "MK")
        },
        _me: function (t) {
            return this._validateJMBG(t, "ME")
        },
        _rs: function (t) {
            return this._validateJMBG(t, "RS")
        },
        _si: function (t) {
            return this._validateJMBG(t, "SI")
        },
        _bg: function (e) {
            if (!/^\d{10}$/.test(e) && !/^\d{6}\s\d{3}\s\d{1}$/.test(e)) return !1;
            e = e.replace(/\s/g, "");
            var i = parseInt(e.substr(0, 2), 10) + 1900, n = parseInt(e.substr(2, 2), 10),
                s = parseInt(e.substr(4, 2), 10);
            if (n > 40 ? (i += 100, n -= 40) : n > 20 && (i -= 100, n -= 20), !t.fn.bootstrapValidator.helpers.date(i, n, s)) return !1;
            for (var r = 0, o = [2, 4, 8, 5, 10, 9, 7, 3, 6], a = 0; a < 9; a++) r += parseInt(e.charAt(a), 10) * o[a];
            return (r = r % 11 % 10) + "" === e.substr(9, 1)
        },
        _br: function (t) {
            if (/^1{11}|2{11}|3{11}|4{11}|5{11}|6{11}|7{11}|8{11}|9{11}|0{11}$/.test(t)) return !1;
            if (!/^\d{11}$/.test(t) && !/^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(t)) return !1;
            t = t.replace(/\./g, "").replace(/-/g, "");
            for (var e = 0, i = 0; i < 9; i++) e += (10 - i) * parseInt(t.charAt(i), 10);
            if (e = 11 - e % 11, 10 !== e && 11 !== e || (e = 0), e + "" !== t.charAt(9)) return !1;
            var n = 0;
            for (i = 0; i < 10; i++) n += (11 - i) * parseInt(t.charAt(i), 10);
            return n = 11 - n % 11, 10 !== n && 11 !== n || (n = 0), n + "" === t.charAt(10)
        },
        _ch: function (t) {
            if (!/^756[\.]{0,1}[0-9]{4}[\.]{0,1}[0-9]{4}[\.]{0,1}[0-9]{2}$/.test(t)) return !1;
            t = t.replace(/\D/g, "").substr(3);
            for (var e = t.length, i = 0, n = 8 === e ? [3, 1] : [1, 3], s = 0; s < e - 1; s++) i += parseInt(t.charAt(s), 10) * n[s % 2];
            return (i = 10 - i % 10) + "" === t.charAt(e - 1)
        },
        _cl: function (t) {
            if (!/^\d{7,8}[-]{0,1}[0-9K]$/i.test(t)) return !1;
            for (t = t.replace(/\-/g, ""); t.length < 9;) t = "0" + t;
            for (var e = 0, i = [3, 2, 7, 6, 5, 4, 3, 2], n = 0; n < 8; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e = 11 - e % 11, 11 === e ? e = 0 : 10 === e && (e = "K"), e + "" === t.charAt(8).toUpperCase()
        },
        _cn: function (e) {
            if (e = e.trim(), !/^\d{15}$/.test(e) && !/^\d{17}[\dXx]{1}$/.test(e)) return !1;
            var i = {
                11: {0: [0], 1: [[0, 9], [11, 17]], 2: [0, 28, 29]},
                12: {0: [0], 1: [[0, 16]], 2: [0, 21, 23, 25]},
                13: {
                    0: [0],
                    1: [[0, 5], 7, 8, 21, [23, 33], [81, 85]],
                    2: [[0, 5], [7, 9], [23, 25], 27, 29, 30, 81, 83],
                    3: [[0, 4], [21, 24]],
                    4: [[0, 4], 6, 21, [23, 35], 81],
                    5: [[0, 3], [21, 35], 81, 82],
                    6: [[0, 4], [21, 38], [81, 84]],
                    7: [[0, 3], 5, 6, [21, 33]],
                    8: [[0, 4], [21, 28]],
                    9: [[0, 3], [21, 30], [81, 84]],
                    10: [[0, 3], [22, 26], 28, 81, 82],
                    11: [[0, 2], [21, 28], 81, 82]
                },
                14: {
                    0: [0],
                    1: [0, 1, [5, 10], [21, 23], 81],
                    2: [[0, 3], 11, 12, [21, 27]],
                    3: [[0, 3], 11, 21, 22],
                    4: [[0, 2], 11, 21, [23, 31], 81],
                    5: [[0, 2], 21, 22, 24, 25, 81],
                    6: [[0, 3], [21, 24]],
                    7: [[0, 2], [21, 29], 81],
                    8: [[0, 2], [21, 30], 81, 82],
                    9: [[0, 2], [21, 32], 81],
                    10: [[0, 2], [21, 34], 81, 82],
                    11: [[0, 2], [21, 30], 81, 82],
                    23: [[0, 3], 22, 23, [25, 30], 32, 33]
                },
                15: {
                    0: [0],
                    1: [[0, 5], [21, 25]],
                    2: [[0, 7], [21, 23]],
                    3: [[0, 4]],
                    4: [[0, 4], [21, 26], [28, 30]],
                    5: [[0, 2], [21, 26], 81],
                    6: [[0, 2], [21, 27]],
                    7: [[0, 3], [21, 27], [81, 85]],
                    8: [[0, 2], [21, 26]],
                    9: [[0, 2], [21, 29], 81],
                    22: [[0, 2], [21, 24]],
                    25: [[0, 2], [22, 31]],
                    26: [[0, 2], [24, 27], [29, 32], 34],
                    28: [0, 1, [22, 27]],
                    29: [0, [21, 23]]
                },
                21: {
                    0: [0],
                    1: [[0, 6], [11, 14], [22, 24], 81],
                    2: [[0, 4], [11, 13], 24, [81, 83]],
                    3: [[0, 4], 11, 21, 23, 81],
                    4: [[0, 4], 11, [21, 23]],
                    5: [[0, 5], 21, 22],
                    6: [[0, 4], 24, 81, 82],
                    7: [[0, 3], 11, 26, 27, 81, 82],
                    8: [[0, 4], 11, 81, 82],
                    9: [[0, 5], 11, 21, 22],
                    10: [[0, 5], 11, 21, 81],
                    11: [[0, 3], 21, 22],
                    12: [[0, 2], 4, 21, 23, 24, 81, 82],
                    13: [[0, 3], 21, 22, 24, 81, 82],
                    14: [[0, 4], 21, 22, 81]
                },
                22: {
                    0: [0],
                    1: [[0, 6], 12, 22, [81, 83]],
                    2: [[0, 4], 11, 21, [81, 84]],
                    3: [[0, 3], 22, 23, 81, 82],
                    4: [[0, 3], 21, 22],
                    5: [[0, 3], 21, 23, 24, 81, 82],
                    6: [[0, 2], 4, 5, [21, 23], 25, 81],
                    7: [[0, 2], [21, 24], 81],
                    8: [[0, 2], 21, 22, 81, 82],
                    24: [[0, 6], 24, 26]
                },
                23: {
                    0: [0],
                    1: [[0, 12], 21, [23, 29], [81, 84]],
                    2: [[0, 8], 21, [23, 25], 27, [29, 31], 81],
                    3: [[0, 7], 21, 81, 82],
                    4: [[0, 7], 21, 22],
                    5: [[0, 3], 5, 6, [21, 24]],
                    6: [[0, 6], [21, 24]],
                    7: [[0, 16], 22, 81],
                    8: [[0, 5], 11, 22, 26, 28, 33, 81, 82],
                    9: [[0, 4], 21],
                    10: [[0, 5], 24, 25, 81, [83, 85]],
                    11: [[0, 2], 21, 23, 24, 81, 82],
                    12: [[0, 2], [21, 26], [81, 83]],
                    27: [[0, 4], [21, 23]]
                },
                31: {0: [0], 1: [0, 1, [3, 10], [12, 20]], 2: [0, 30]},
                32: {
                    0: [0],
                    1: [[0, 7], 11, [13, 18], 24, 25],
                    2: [[0, 6], 11, 81, 82],
                    3: [[0, 5], 11, 12, [21, 24], 81, 82],
                    4: [[0, 2], 4, 5, 11, 12, 81, 82],
                    5: [[0, 9], [81, 85]],
                    6: [[0, 2], 11, 12, 21, 23, [81, 84]],
                    7: [0, 1, 3, 5, 6, [21, 24]],
                    8: [[0, 4], 11, 26, [29, 31]],
                    9: [[0, 3], [21, 25], 28, 81, 82],
                    10: [[0, 3], 11, 12, 23, 81, 84, 88],
                    11: [[0, 2], 11, 12, [81, 83]],
                    12: [[0, 4], [81, 84]],
                    13: [[0, 2], 11, [21, 24]]
                },
                33: {
                    0: [0],
                    1: [[0, 6], [8, 10], 22, 27, 82, 83, 85],
                    2: [0, 1, [3, 6], 11, 12, 25, 26, [81, 83]],
                    3: [[0, 4], 22, 24, [26, 29], 81, 82],
                    4: [[0, 2], 11, 21, 24, [81, 83]],
                    5: [[0, 3], [21, 23]],
                    6: [[0, 2], 21, 24, [81, 83]],
                    7: [[0, 3], 23, 26, 27, [81, 84]],
                    8: [[0, 3], 22, 24, 25, 81],
                    9: [[0, 3], 21, 22],
                    10: [[0, 4], [21, 24], 81, 82],
                    11: [[0, 2], [21, 27], 81]
                },
                34: {
                    0: [0],
                    1: [[0, 4], 11, [21, 24], 81],
                    2: [[0, 4], 7, 8, [21, 23], 25],
                    3: [[0, 4], 11, [21, 23]],
                    4: [[0, 6], 21],
                    5: [[0, 4], 6, [21, 23]],
                    6: [[0, 4], 21],
                    7: [[0, 3], 11, 21],
                    8: [[0, 3], 11, [22, 28], 81],
                    10: [[0, 4], [21, 24]],
                    11: [[0, 3], 22, [24, 26], 81, 82],
                    12: [[0, 4], 21, 22, 25, 26, 82],
                    13: [[0, 2], [21, 24]],
                    14: [[0, 2], [21, 24]],
                    15: [[0, 3], [21, 25]],
                    16: [[0, 2], [21, 23]],
                    17: [[0, 2], [21, 23]],
                    18: [[0, 2], [21, 25], 81]
                },
                35: {
                    0: [0],
                    1: [[0, 5], 11, [21, 25], 28, 81, 82],
                    2: [[0, 6], [11, 13]],
                    3: [[0, 5], 22],
                    4: [[0, 3], 21, [23, 30], 81],
                    5: [[0, 5], 21, [24, 27], [81, 83]],
                    6: [[0, 3], [22, 29], 81],
                    7: [[0, 2], [21, 25], [81, 84]],
                    8: [[0, 2], [21, 25], 81],
                    9: [[0, 2], [21, 26], 81, 82]
                },
                36: {
                    0: [0],
                    1: [[0, 5], 11, [21, 24]],
                    2: [[0, 3], 22, 81],
                    3: [[0, 2], 13, [21, 23]],
                    4: [[0, 3], 21, [23, 30], 81, 82],
                    5: [[0, 2], 21],
                    6: [[0, 2], 22, 81],
                    7: [[0, 2], [21, 35], 81, 82],
                    8: [[0, 3], [21, 30], 81],
                    9: [[0, 2], [21, 26], [81, 83]],
                    10: [[0, 2], [21, 30]],
                    11: [[0, 2], [21, 30], 81]
                },
                37: {
                    0: [0],
                    1: [[0, 5], 12, 13, [24, 26], 81],
                    2: [[0, 3], 5, [11, 14], [81, 85]],
                    3: [[0, 6], [21, 23]],
                    4: [[0, 6], 81],
                    5: [[0, 3], [21, 23]],
                    6: [[0, 2], [11, 13], 34, [81, 87]],
                    7: [[0, 5], 24, 25, [81, 86]],
                    8: [[0, 2], 11, [26, 32], [81, 83]],
                    9: [[0, 3], 11, 21, 23, 82, 83],
                    10: [[0, 2], [81, 83]],
                    11: [[0, 3], 21, 22],
                    12: [[0, 3]],
                    13: [[0, 2], 11, 12, [21, 29]],
                    14: [[0, 2], [21, 28], 81, 82],
                    15: [[0, 2], [21, 26], 81],
                    16: [[0, 2], [21, 26]],
                    17: [[0, 2], [21, 28]]
                },
                41: {
                    0: [0],
                    1: [[0, 6], 8, 22, [81, 85]],
                    2: [[0, 5], 11, [21, 25]],
                    3: [[0, 7], 11, [22, 29], 81],
                    4: [[0, 4], 11, [21, 23], 25, 81, 82],
                    5: [[0, 3], 5, 6, 22, 23, 26, 27, 81],
                    6: [[0, 3], 11, 21, 22],
                    7: [[0, 4], 11, 21, [24, 28], 81, 82],
                    8: [[0, 4], 11, [21, 23], 25, [81, 83]],
                    9: [[0, 2], 22, 23, [26, 28]],
                    10: [[0, 2], [23, 25], 81, 82],
                    11: [[0, 4], [21, 23]],
                    12: [[0, 2], 21, 22, 24, 81, 82],
                    13: [[0, 3], [21, 30], 81],
                    14: [[0, 3], [21, 26], 81],
                    15: [[0, 3], [21, 28]],
                    16: [[0, 2], [21, 28], 81],
                    17: [[0, 2], [21, 29]],
                    90: [0, 1]
                },
                42: {
                    0: [0],
                    1: [[0, 7], [11, 17]],
                    2: [[0, 5], 22, 81],
                    3: [[0, 3], [21, 25], 81],
                    5: [[0, 6], [25, 29], [81, 83]],
                    6: [[0, 2], 6, 7, [24, 26], [82, 84]],
                    7: [[0, 4]],
                    8: [[0, 2], 4, 21, 22, 81],
                    9: [[0, 2], [21, 23], 81, 82, 84],
                    10: [[0, 3], [22, 24], 81, 83, 87],
                    11: [[0, 2], [21, 27], 81, 82],
                    12: [[0, 2], [21, 24], 81],
                    13: [[0, 3], 21, 81],
                    28: [[0, 2], 22, 23, [25, 28]],
                    90: [0, [4, 6], 21]
                },
                43: {
                    0: [0],
                    1: [[0, 5], 11, 12, 21, 22, 24, 81],
                    2: [[0, 4], 11, 21, [23, 25], 81],
                    3: [[0, 2], 4, 21, 81, 82],
                    4: [0, 1, [5, 8], 12, [21, 24], 26, 81, 82],
                    5: [[0, 3], 11, [21, 25], [27, 29], 81],
                    6: [[0, 3], 11, 21, 23, 24, 26, 81, 82],
                    7: [[0, 3], [21, 26], 81],
                    8: [[0, 2], 11, 21, 22],
                    9: [[0, 3], [21, 23], 81],
                    10: [[0, 3], [21, 28], 81],
                    11: [[0, 3], [21, 29]],
                    12: [[0, 2], [21, 30], 81],
                    13: [[0, 2], 21, 22, 81, 82],
                    31: [0, 1, [22, 27], 30]
                },
                44: {
                    0: [0],
                    1: [[0, 7], [11, 16], 83, 84],
                    2: [[0, 5], 21, 22, 24, 29, 32, 33, 81, 82],
                    3: [0, 1, [3, 8]],
                    4: [[0, 4]],
                    5: [0, 1, [6, 15], 23, 82, 83],
                    6: [0, 1, [4, 8]],
                    7: [0, 1, [3, 5], 81, [83, 85]],
                    8: [[0, 4], 11, 23, 25, [81, 83]],
                    9: [[0, 3], 23, [81, 83]],
                    12: [[0, 3], [23, 26], 83, 84],
                    13: [[0, 3], [22, 24], 81],
                    14: [[0, 2], [21, 24], 26, 27, 81],
                    15: [[0, 2], 21, 23, 81],
                    16: [[0, 2], [21, 25]],
                    17: [[0, 2], 21, 23, 81],
                    18: [[0, 3], 21, 23, [25, 27], 81, 82],
                    19: [0],
                    20: [0],
                    51: [[0, 3], 21, 22],
                    52: [[0, 3], 21, 22, 24, 81],
                    53: [[0, 2], [21, 23], 81]
                },
                45: {
                    0: [0],
                    1: [[0, 9], [21, 27]],
                    2: [[0, 5], [21, 26]],
                    3: [[0, 5], 11, 12, [21, 32]],
                    4: [0, 1, [3, 6], 11, [21, 23], 81],
                    5: [[0, 3], 12, 21],
                    6: [[0, 3], 21, 81],
                    7: [[0, 3], 21, 22],
                    8: [[0, 4], 21, 81],
                    9: [[0, 3], [21, 24], 81],
                    10: [[0, 2], [21, 31]],
                    11: [[0, 2], [21, 23]],
                    12: [[0, 2], [21, 29], 81],
                    13: [[0, 2], [21, 24], 81],
                    14: [[0, 2], [21, 25], 81]
                },
                46: {0: [0], 1: [0, 1, [5, 8]], 2: [0, 1], 3: [0, [21, 23]], 90: [[0, 3], [5, 7], [21, 39]]},
                50: {0: [0], 1: [[0, 19]], 2: [0, [22, 38], [40, 43]], 3: [0, [81, 84]]},
                51: {
                    0: [0],
                    1: [0, 1, [4, 8], [12, 15], [21, 24], 29, 31, 32, [81, 84]],
                    3: [[0, 4], 11, 21, 22],
                    4: [[0, 3], 11, 21, 22],
                    5: [[0, 4], 21, 22, 24, 25],
                    6: [0, 1, 3, 23, 26, [81, 83]],
                    7: [0, 1, 3, 4, [22, 27], 81],
                    8: [[0, 2], 11, 12, [21, 24]],
                    9: [[0, 4], [21, 23]],
                    10: [[0, 2], 11, 24, 25, 28],
                    11: [[0, 2], [11, 13], 23, 24, 26, 29, 32, 33, 81],
                    13: [[0, 4], [21, 25], 81],
                    14: [[0, 2], [21, 25]],
                    15: [[0, 3], [21, 29]],
                    16: [[0, 3], [21, 23], 81],
                    17: [[0, 3], [21, 25], 81],
                    18: [[0, 3], [21, 27]],
                    19: [[0, 3], [21, 23]],
                    20: [[0, 2], 21, 22, 81],
                    32: [0, [21, 33]],
                    33: [0, [21, 38]],
                    34: [0, 1, [22, 37]]
                },
                52: {
                    0: [0],
                    1: [[0, 3], [11, 15], [21, 23], 81],
                    2: [0, 1, 3, 21, 22],
                    3: [[0, 3], [21, 30], 81, 82],
                    4: [[0, 2], [21, 25]],
                    5: [[0, 2], [21, 27]],
                    6: [[0, 3], [21, 28]],
                    22: [0, 1, [22, 30]],
                    23: [0, 1, [22, 28]],
                    24: [0, 1, [22, 28]],
                    26: [0, 1, [22, 36]],
                    27: [[0, 2], 22, 23, [25, 32]]
                },
                53: {
                    0: [0],
                    1: [[0, 3], [11, 14], 21, 22, [24, 29], 81],
                    3: [[0, 2], [21, 26], 28, 81],
                    4: [[0, 2], [21, 28]],
                    5: [[0, 2], [21, 24]],
                    6: [[0, 2], [21, 30]],
                    7: [[0, 2], [21, 24]],
                    8: [[0, 2], [21, 29]],
                    9: [[0, 2], [21, 27]],
                    23: [0, 1, [22, 29], 31],
                    25: [[0, 4], [22, 32]],
                    26: [0, 1, [21, 28]],
                    27: [0, 1, [22, 30]],
                    28: [0, 1, 22, 23],
                    29: [0, 1, [22, 32]],
                    31: [0, 2, 3, [22, 24]],
                    34: [0, [21, 23]],
                    33: [0, 21, [23, 25]],
                    35: [0, [21, 28]]
                },
                54: {
                    0: [0],
                    1: [[0, 2], [21, 27]],
                    21: [0, [21, 29], 32, 33],
                    22: [0, [21, 29], [31, 33]],
                    23: [0, 1, [22, 38]],
                    24: [0, [21, 31]],
                    25: [0, [21, 27]],
                    26: [0, [21, 27]]
                },
                61: {
                    0: [0],
                    1: [[0, 4], [11, 16], 22, [24, 26]],
                    2: [[0, 4], 22],
                    3: [[0, 4], [21, 24], [26, 31]],
                    4: [[0, 4], [22, 31], 81],
                    5: [[0, 2], [21, 28], 81, 82],
                    6: [[0, 2], [21, 32]],
                    7: [[0, 2], [21, 30]],
                    8: [[0, 2], [21, 31]],
                    9: [[0, 2], [21, 29]],
                    10: [[0, 2], [21, 26]]
                },
                62: {
                    0: [0],
                    1: [[0, 5], 11, [21, 23]],
                    2: [0, 1],
                    3: [[0, 2], 21],
                    4: [[0, 3], [21, 23]],
                    5: [[0, 3], [21, 25]],
                    6: [[0, 2], [21, 23]],
                    7: [[0, 2], [21, 25]],
                    8: [[0, 2], [21, 26]],
                    9: [[0, 2], [21, 24], 81, 82],
                    10: [[0, 2], [21, 27]],
                    11: [[0, 2], [21, 26]],
                    12: [[0, 2], [21, 28]],
                    24: [0, 21, [24, 29]],
                    26: [0, 21, [23, 30]],
                    29: [0, 1, [21, 27]],
                    30: [0, 1, [21, 27]]
                },
                63: {
                    0: [0],
                    1: [[0, 5], [21, 23]],
                    2: [0, 2, [21, 25]],
                    21: [0, [21, 23], [26, 28]],
                    22: [0, [21, 24]],
                    23: [0, [21, 24]],
                    25: [0, [21, 25]],
                    26: [0, [21, 26]],
                    27: [0, 1, [21, 26]],
                    28: [[0, 2], [21, 23]]
                },
                64: {
                    0: [0],
                    1: [0, 1, [4, 6], 21, 22, 81],
                    2: [[0, 3], 5, [21, 23]],
                    3: [[0, 3], [21, 24], 81],
                    4: [[0, 2], [21, 25]],
                    5: [[0, 2], 21, 22]
                },
                65: {
                    0: [0],
                    1: [[0, 9], 21],
                    2: [[0, 5]],
                    21: [0, 1, 22, 23],
                    22: [0, 1, 22, 23],
                    23: [[0, 3], [23, 25], 27, 28],
                    28: [0, 1, [22, 29]],
                    29: [0, 1, [22, 29]],
                    30: [0, 1, [22, 24]],
                    31: [0, 1, [21, 31]],
                    32: [0, 1, [21, 27]],
                    40: [0, 2, 3, [21, 28]],
                    42: [[0, 2], 21, [23, 26]],
                    43: [0, 1, [21, 26]],
                    90: [[0, 4]],
                    27: [[0, 2], 22, 23]
                },
                71: {0: [0]},
                81: {0: [0]},
                82: {0: [0]}
            }, n = parseInt(e.substr(0, 2), 10), s = parseInt(e.substr(2, 2), 10), r = parseInt(e.substr(4, 2), 10);
            if (!i[n] || !i[n][s]) return !1;
            for (var o = !1, a = i[n][s], l = 0; l < a.length; l++) if (t.isArray(a[l]) && a[l][0] <= r && r <= a[l][1] || !t.isArray(a[l]) && r === a[l]) {
                o = !0;
                break
            }
            if (!o) return !1;
            var c;
            c = 18 === e.length ? e.substr(6, 8) : "19" + e.substr(6, 6);
            var u = parseInt(c.substr(0, 4), 10), h = parseInt(c.substr(4, 2), 10), d = parseInt(c.substr(6, 2), 10);
            if (!t.fn.bootstrapValidator.helpers.date(u, h, d)) return !1;
            if (18 === e.length) {
                var p = 0, f = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
                for (l = 0; l < 17; l++) p += parseInt(e.charAt(l), 10) * f[l];
                p = (12 - p % 11) % 11;
                return ("X" !== e.charAt(17).toUpperCase() ? parseInt(e.charAt(17), 10) : 10) === p
            }
            return !0
        },
        _cz: function (e) {
            if (!/^\d{9,10}$/.test(e)) return !1;
            var i = 1900 + parseInt(e.substr(0, 2), 10), n = parseInt(e.substr(2, 2), 10) % 50 % 20,
                s = parseInt(e.substr(4, 2), 10);
            if (9 === e.length) {
                if (i >= 1980 && (i -= 100), i > 1953) return !1
            } else i < 1954 && (i += 100);
            if (!t.fn.bootstrapValidator.helpers.date(i, n, s)) return !1;
            if (10 === e.length) {
                var r = parseInt(e.substr(0, 9), 10) % 11;
                return i < 1985 && (r %= 10), r + "" === e.substr(9, 1)
            }
            return !0
        },
        _dk: function (e) {
            if (!/^[0-9]{6}[-]{0,1}[0-9]{4}$/.test(e)) return !1;
            e = e.replace(/-/g, "");
            var i = parseInt(e.substr(0, 2), 10), n = parseInt(e.substr(2, 2), 10), s = parseInt(e.substr(4, 2), 10);
            switch (!0) {
                case-1 !== "5678".indexOf(e.charAt(6)) && s >= 58:
                    s += 1800;
                    break;
                case-1 !== "0123".indexOf(e.charAt(6)):
                case-1 !== "49".indexOf(e.charAt(6)) && s >= 37:
                    s += 1900;
                    break;
                default:
                    s += 2e3
            }
            return t.fn.bootstrapValidator.helpers.date(s, n, i)
        },
        _ee: function (t) {
            return this._lt(t)
        },
        _es: function (t) {
            if (!/^[0-9A-Z]{8}[-]{0,1}[0-9A-Z]$/.test(t) && !/^[XYZ][-]{0,1}[0-9]{7}[-]{0,1}[0-9A-Z]$/.test(t)) return !1;
            t = t.replace(/-/g, "");
            var e = "XYZ".indexOf(t.charAt(0));
            -1 !== e && (t = e + t.substr(1) + "");
            var i = parseInt(t.substr(0, 8), 10);
            return (i = "TRWAGMYFPDXBNJZSQVHLCKE"[i % 23]) === t.substr(8, 1)
        },
        _fi: function (e) {
            if (!/^[0-9]{6}[-+A][0-9]{3}[0-9ABCDEFHJKLMNPRSTUVWXY]$/.test(e)) return !1;
            var i = parseInt(e.substr(0, 2), 10), n = parseInt(e.substr(2, 2), 10), s = parseInt(e.substr(4, 2), 10);
            if (s = {
                "+": 1800,
                "-": 1900,
                A: 2e3
            }[e.charAt(6)] + s, !t.fn.bootstrapValidator.helpers.date(s, n, i)) return !1;
            if (parseInt(e.substr(7, 3), 10) < 2) return !1;
            var r = e.substr(0, 6) + e.substr(7, 3) + "";
            return r = parseInt(r, 10), "0123456789ABCDEFHJKLMNPRSTUVWXY".charAt(r % 31) === e.charAt(10)
        },
        _hr: function (e) {
            return !!/^[0-9]{11}$/.test(e) && t.fn.bootstrapValidator.helpers.mod11And10(e)
        },
        _ie: function (t) {
            if (!/^\d{7}[A-W][AHWTX]?$/.test(t)) return !1;
            var e = function (t) {
                for (; t.length < 7;) t = "0" + t;
                for (var e = "WABCDEFGHIJKLMNOPQRSTUV", i = 0, n = 0; n < 7; n++) i += parseInt(t.charAt(n), 10) * (8 - n);
                return i += 9 * e.indexOf(t.substr(7)), e[i % 23]
            };
            return 9 !== t.length || "A" !== t.charAt(8) && "H" !== t.charAt(8) ? t.charAt(7) === e(t.substr(0, 7)) : t.charAt(7) === e(t.substr(0, 7) + t.substr(8) + "")
        },
        _is: function (e) {
            if (!/^[0-9]{6}[-]{0,1}[0-9]{4}$/.test(e)) return !1;
            e = e.replace(/-/g, "");
            var i = parseInt(e.substr(0, 2), 10), n = parseInt(e.substr(2, 2), 10), s = parseInt(e.substr(4, 2), 10),
                r = parseInt(e.charAt(9), 10);
            if (s = 9 === r ? 1900 + s : 100 * (20 + r) + s, !t.fn.bootstrapValidator.helpers.date(s, n, i, !0)) return !1;
            for (var o = 0, a = [3, 2, 7, 6, 5, 4, 3, 2], l = 0; l < 8; l++) o += parseInt(e.charAt(l), 10) * a[l];
            return (o = 11 - o % 11) + "" === e.charAt(8)
        },
        _lt: function (e) {
            if (!/^[0-9]{11}$/.test(e)) return !1;
            var i = parseInt(e.charAt(0), 10), n = parseInt(e.substr(1, 2), 10), s = parseInt(e.substr(3, 2), 10),
                r = parseInt(e.substr(5, 2), 10);
            if (n = 100 * (i % 2 == 0 ? 17 + i / 2 : 17 + (i + 1) / 2) + n, !t.fn.bootstrapValidator.helpers.date(n, s, r, !0)) return !1;
            for (var o = 0, a = [1, 2, 3, 4, 5, 6, 7, 8, 9, 1], l = 0; l < 10; l++) o += parseInt(e.charAt(l), 10) * a[l];
            if (10 !== (o %= 11)) return o + "" === e.charAt(10);
            for (o = 0, a = [3, 4, 5, 6, 7, 8, 9, 1, 2, 3], l = 0; l < 10; l++) o += parseInt(e.charAt(l), 10) * a[l];
            return o %= 11, 10 === o && (o = 0), o + "" === e.charAt(10)
        },
        _lv: function (e) {
            if (!/^[0-9]{6}[-]{0,1}[0-9]{5}$/.test(e)) return !1;
            e = e.replace(/\D/g, "");
            var i = parseInt(e.substr(0, 2), 10), n = parseInt(e.substr(2, 2), 10), s = parseInt(e.substr(4, 2), 10);
            if (s = s + 1800 + 100 * parseInt(e.charAt(6), 10), !t.fn.bootstrapValidator.helpers.date(s, n, i, !0)) return !1;
            for (var r = 0, o = [10, 5, 8, 4, 2, 1, 6, 3, 7, 9], a = 0; a < 10; a++) r += parseInt(e.charAt(a), 10) * o[a];
            return (r = (r + 1) % 11 % 10) + "" === e.charAt(10)
        },
        _nl: function (t) {
            for (; t.length < 9;) t = "0" + t;
            if (!/^[0-9]{4}[.]{0,1}[0-9]{2}[.]{0,1}[0-9]{3}$/.test(t)) return !1;
            if (t = t.replace(/\./g, ""), 0 === parseInt(t, 10)) return !1;
            for (var e = 0, i = t.length, n = 0; n < i - 1; n++) e += (9 - n) * parseInt(t.charAt(n), 10);
            return e %= 11, 10 === e && (e = 0), e + "" === t.charAt(i - 1)
        },
        _ro: function (e) {
            if (!/^[0-9]{13}$/.test(e)) return !1;
            var i = parseInt(e.charAt(0), 10);
            if (0 === i || 7 === i || 8 === i) return !1;
            var n = parseInt(e.substr(1, 2), 10), s = parseInt(e.substr(3, 2), 10), r = parseInt(e.substr(5, 2), 10),
                o = {1: 1900, 2: 1900, 3: 1800, 4: 1800, 5: 2e3, 6: 2e3};
            if (r > 31 && s > 12) return !1;
            if (9 !== i && (n = o[i + ""] + n, !t.fn.bootstrapValidator.helpers.date(n, s, r))) return !1;
            for (var a = 0, l = [2, 7, 9, 1, 4, 6, 3, 5, 8, 2, 7, 9], c = e.length, u = 0; u < c - 1; u++) a += parseInt(e.charAt(u), 10) * l[u];
            return a %= 11, 10 === a && (a = 1), a + "" === e.charAt(c - 1)
        },
        _se: function (e) {
            if (!/^[0-9]{10}$/.test(e) && !/^[0-9]{6}[-|+][0-9]{4}$/.test(e)) return !1;
            e = e.replace(/[^0-9]/g, "");
            var i = parseInt(e.substr(0, 2), 10) + 1900, n = parseInt(e.substr(2, 2), 10),
                s = parseInt(e.substr(4, 2), 10);
            return !!t.fn.bootstrapValidator.helpers.date(i, n, s) && t.fn.bootstrapValidator.helpers.luhn(e)
        },
        _sk: function (t) {
            return this._cz(t)
        },
        _sm: function (t) {
            return /^\d{5}$/.test(t)
        },
        _th: function (t) {
            if (13 !== t.length) return !1;
            for (var e = 0, i = 0; i < 12; i++) e += parseInt(t.charAt(i), 10) * (13 - i);
            return (11 - e % 11) % 10 === parseInt(t.charAt(12), 10)
        },
        _za: function (e) {
            if (!/^[0-9]{10}[0|1][8|9][0-9]$/.test(e)) return !1;
            var i = parseInt(e.substr(0, 2), 10), n = (new Date).getFullYear() % 100, s = parseInt(e.substr(2, 2), 10),
                r = parseInt(e.substr(4, 2), 10);
            return i = i >= n ? i + 1900 : i + 2e3, !!t.fn.bootstrapValidator.helpers.date(i, s, r) && t.fn.bootstrapValidator.helpers.luhn(e)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.identical = t.extend(t.fn.bootstrapValidator.i18n.identical || {}, {default: "Please enter the same value"}), t.fn.bootstrapValidator.validators.identical = {
        html5Attributes: {
            message: "message",
            field: "field"
        }, validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            var s = t.getFieldElements(i.field);
            return null === s || 0 === s.length || n === s.val() && (t.updateStatus(i.field, t.STATUS_VALID, "identical"), !0)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.imei = t.extend(t.fn.bootstrapValidator.i18n.imei || {}, {default: "Please enter a valid IMEI number"}), t.fn.bootstrapValidator.validators.imei = {
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            switch (!0) {
                case/^\d{15}$/.test(s):
                case/^\d{2}-\d{6}-\d{6}-\d{1}$/.test(s):
                case/^\d{2}\s\d{6}\s\d{6}\s\d{1}$/.test(s):
                    return s = s.replace(/[^0-9]/g, ""), t.fn.bootstrapValidator.helpers.luhn(s);
                case/^\d{14}$/.test(s):
                case/^\d{16}$/.test(s):
                case/^\d{2}-\d{6}-\d{6}(|-\d{2})$/.test(s):
                case/^\d{2}\s\d{6}\s\d{6}(|\s\d{2})$/.test(s):
                    return !0;
                default:
                    return !1
            }
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.imo = t.extend(t.fn.bootstrapValidator.i18n.imo || {}, {default: "Please enter a valid IMO number"}), t.fn.bootstrapValidator.validators.imo = {
        validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            if (!/^IMO \d{7}$/i.test(n)) return !1;
            for (var s = 0, r = n.replace(/^.*(\d{7})$/, "$1"), o = 6; o >= 1; o--) s += r.slice(6 - o, -o) * (o + 1);
            return s % 10 === parseInt(r.charAt(6), 10)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.integer = t.extend(t.fn.bootstrapValidator.i18n.integer || {}, {default: "Please enter a valid number"}), t.fn.bootstrapValidator.validators.integer = {
        enableByHtml5: function (t) {
            return "number" === t.attr("type") && (void 0 === t.attr("step") || t.attr("step") % 1 == 0)
        }, validate: function (t, e, i) {
            if (this.enableByHtml5(e) && e.get(0).validity && !0 === e.get(0).validity.badInput) return !1;
            var n = e.val();
            return "" === n || /^(?:-?(?:0|[1-9][0-9]*))$/.test(n)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.ip = t.extend(t.fn.bootstrapValidator.i18n.ip || {}, {
        default: "Please enter a valid IP address",
        ipv4: "Please enter a valid IPv4 address",
        ipv6: "Please enter a valid IPv6 address"
    }), t.fn.bootstrapValidator.validators.ip = {
        html5Attributes: {message: "message", ipv4: "ipv4", ipv6: "ipv6"},
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            n = t.extend({}, {ipv4: !0, ipv6: !0}, n);
            var r, o = /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/,
                a = /^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/,
                l = !1;
            switch (!0) {
                case n.ipv4 && !n.ipv6:
                    l = o.test(s), r = n.message || t.fn.bootstrapValidator.i18n.ip.ipv4;
                    break;
                case!n.ipv4 && n.ipv6:
                    l = a.test(s), r = n.message || t.fn.bootstrapValidator.i18n.ip.ipv6;
                    break;
                case n.ipv4 && n.ipv6:
                default:
                    l = o.test(s) || a.test(s), r = n.message || t.fn.bootstrapValidator.i18n.ip.default
            }
            return {valid: l, message: r}
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.isbn = t.extend(t.fn.bootstrapValidator.i18n.isbn || {}, {default: "Please enter a valid ISBN number"}), t.fn.bootstrapValidator.validators.isbn = {
        validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            var s;
            switch (!0) {
                case/^\d{9}[\dX]$/.test(n):
                case 13 === n.length && /^(\d+)-(\d+)-(\d+)-([\dX])$/.test(n):
                case 13 === n.length && /^(\d+)\s(\d+)\s(\d+)\s([\dX])$/.test(n):
                    s = "ISBN10";
                    break;
                case/^(978|979)\d{9}[\dX]$/.test(n):
                case 17 === n.length && /^(978|979)-(\d+)-(\d+)-(\d+)-([\dX])$/.test(n):
                case 17 === n.length && /^(978|979)\s(\d+)\s(\d+)\s(\d+)\s([\dX])$/.test(n):
                    s = "ISBN13";
                    break;
                default:
                    return !1
            }
            n = n.replace(/[^0-9X]/gi, "");
            var r, o, a = n.split(""), l = a.length, c = 0;
            switch (s) {
                case"ISBN10":
                    for (c = 0, r = 0; r < l - 1; r++) c += parseInt(a[r], 10) * (10 - r);
                    return o = 11 - c % 11, 11 === o ? o = 0 : 10 === o && (o = "X"), o + "" === a[l - 1];
                case"ISBN13":
                    for (c = 0, r = 0; r < l - 1; r++) c += r % 2 == 0 ? parseInt(a[r], 10) : 3 * parseInt(a[r], 10);
                    return o = 10 - c % 10, 10 === o && (o = "0"), o + "" === a[l - 1];
                default:
                    return !1
            }
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.isin = t.extend(t.fn.bootstrapValidator.i18n.isin || {}, {default: "Please enter a valid ISIN number"}), t.fn.bootstrapValidator.validators.isin = {
        COUNTRY_CODES: "AF|AX|AL|DZ|AS|AD|AO|AI|AQ|AG|AR|AM|AW|AU|AT|AZ|BS|BH|BD|BB|BY|BE|BZ|BJ|BM|BT|BO|BQ|BA|BW|BV|BR|IO|BN|BG|BF|BI|KH|CM|CA|CV|KY|CF|TD|CL|CN|CX|CC|CO|KM|CG|CD|CK|CR|CI|HR|CU|CW|CY|CZ|DK|DJ|DM|DO|EC|EG|SV|GQ|ER|EE|ET|FK|FO|FJ|FI|FR|GF|PF|TF|GA|GM|GE|DE|GH|GI|GR|GL|GD|GP|GU|GT|GG|GN|GW|GY|HT|HM|VA|HN|HK|HU|IS|IN|ID|IR|IQ|IE|IM|IL|IT|JM|JP|JE|JO|KZ|KE|KI|KP|KR|KW|KG|LA|LV|LB|LS|LR|LY|LI|LT|LU|MO|MK|MG|MW|MY|MV|ML|MT|MH|MQ|MR|MU|YT|MX|FM|MD|MC|MN|ME|MS|MA|MZ|MM|NA|NR|NP|NL|NC|NZ|NI|NE|NG|NU|NF|MP|NO|OM|PK|PW|PS|PA|PG|PY|PE|PH|PN|PL|PT|PR|QA|RE|RO|RU|RW|BL|SH|KN|LC|MF|PM|VC|WS|SM|ST|SA|SN|RS|SC|SL|SG|SX|SK|SI|SB|SO|ZA|GS|SS|ES|LK|SD|SR|SJ|SZ|SE|CH|SY|TW|TJ|TZ|TH|TL|TG|TK|TO|TT|TN|TR|TM|TC|TV|UG|UA|AE|GB|US|UM|UY|UZ|VU|VE|VN|VG|VI|WF|EH|YE|ZM|ZW",
        validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            if (n = n.toUpperCase(), !new RegExp("^(" + this.COUNTRY_CODES + ")[0-9A-Z]{10}$").test(n)) return !1;
            for (var s = "", r = n.length, o = 0; o < r - 1; o++) {
                var a = n.charCodeAt(o);
                s += a > 57 ? (a - 55).toString() : n.charAt(o)
            }
            var l = "", c = s.length, u = c % 2 != 0 ? 0 : 1;
            for (o = 0; o < c; o++) l += parseInt(s[o], 10) * (o % 2 === u ? 2 : 1) + "";
            var h = 0;
            for (o = 0; o < l.length; o++) h += parseInt(l.charAt(o), 10);
            return (h = (10 - h % 10) % 10) + "" === n.charAt(r - 1)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.ismn = t.extend(t.fn.bootstrapValidator.i18n.ismn || {}, {default: "Please enter a valid ISMN number"}), t.fn.bootstrapValidator.validators.ismn = {
        validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            var s;
            switch (!0) {
                case/^M\d{9}$/.test(n):
                case/^M-\d{4}-\d{4}-\d{1}$/.test(n):
                case/^M\s\d{4}\s\d{4}\s\d{1}$/.test(n):
                    s = "ISMN10";
                    break;
                case/^9790\d{9}$/.test(n):
                case/^979-0-\d{4}-\d{4}-\d{1}$/.test(n):
                case/^979\s0\s\d{4}\s\d{4}\s\d{1}$/.test(n):
                    s = "ISMN13";
                    break;
                default:
                    return !1
            }
            "ISMN10" === s && (n = "9790" + n.substr(1)), n = n.replace(/[^0-9]/gi, "");
            for (var r = n.length, o = 0, a = [1, 3], l = 0; l < r - 1; l++) o += parseInt(n.charAt(l), 10) * a[l % 2];
            return (o = 10 - o % 10) + "" === n.charAt(r - 1)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.issn = t.extend(t.fn.bootstrapValidator.i18n.issn || {}, {default: "Please enter a valid ISSN number"}), t.fn.bootstrapValidator.validators.issn = {
        validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            if (!/^\d{4}\-\d{3}[\dX]$/.test(n)) return !1;
            n = n.replace(/[^0-9X]/gi, "");
            var s = n.split(""), r = s.length, o = 0;
            "X" === s[7] && (s[7] = 10);
            for (var a = 0; a < r; a++) o += parseInt(s[a], 10) * (8 - a);
            return o % 11 == 0
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.lessThan = t.extend(t.fn.bootstrapValidator.i18n.lessThan || {}, {
        default: "Please enter a value less than or equal to %s",
        notInclusive: "Please enter a value less than %s"
    }), t.fn.bootstrapValidator.validators.lessThan = {
        html5Attributes: {
            message: "message",
            value: "value",
            inclusive: "inclusive"
        }, enableByHtml5: function (t) {
            var e = t.attr("type"), i = t.attr("max");
            return !(!i || "date" === e) && {value: i}
        }, validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            if (s = this._format(s), !t.isNumeric(s)) return !1;
            var r = t.isNumeric(n.value) ? n.value : e.getDynamicOption(i, n.value), o = this._format(r);
            return s = parseFloat(s), !0 === n.inclusive || void 0 === n.inclusive ? {
                valid: s <= o,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.lessThan.default, r)
            } : {
                valid: s < o,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.lessThan.notInclusive, r)
            }
        }, _format: function (t) {
            return (t + "").replace(",", ".")
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.mac = t.extend(t.fn.bootstrapValidator.i18n.mac || {}, {default: "Please enter a valid MAC address"}), t.fn.bootstrapValidator.validators.mac = {
        validate: function (t, e, i) {
            var n = e.val();
            return "" === n || /^([0-9A-F]{2}[:-]){5}([0-9A-F]{2})$/.test(n)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.meid = t.extend(t.fn.bootstrapValidator.i18n.meid || {}, {default: "Please enter a valid MEID number"}), t.fn.bootstrapValidator.validators.meid = {
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            switch (!0) {
                case/^[0-9A-F]{15}$/i.test(s):
                case/^[0-9A-F]{2}[- ][0-9A-F]{6}[- ][0-9A-F]{6}[- ][0-9A-F]$/i.test(s):
                case/^\d{19}$/.test(s):
                case/^\d{5}[- ]\d{5}[- ]\d{4}[- ]\d{4}[- ]\d$/.test(s):
                    var r = s.charAt(s.length - 1);
                    if (s = s.replace(/[- ]/g, ""), s.match(/^\d*$/i)) return t.fn.bootstrapValidator.helpers.luhn(s);
                    s = s.slice(0, -1);
                    for (var o = "", a = 1; a <= 13; a += 2) o += (2 * parseInt(s.charAt(a), 16)).toString(16);
                    var l = 0;
                    for (a = 0; a < o.length; a++) l += parseInt(o.charAt(a), 16);
                    return l % 10 == 0 ? "0" === r : r === (2 * (10 * Math.floor((l + 10) / 10) - l)).toString(16);
                case/^[0-9A-F]{14}$/i.test(s):
                case/^[0-9A-F]{2}[- ][0-9A-F]{6}[- ][0-9A-F]{6}$/i.test(s):
                case/^\d{18}$/.test(s):
                case/^\d{5}[- ]\d{5}[- ]\d{4}[- ]\d{4}$/.test(s):
                    return !0;
                default:
                    return !1
            }
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.notEmpty = t.extend(t.fn.bootstrapValidator.i18n.notEmpty || {}, {default: "Please enter a value"}), t.fn.bootstrapValidator.validators.notEmpty = {
        enableByHtml5: function (t) {
            var e = t.attr("required") + "";
            return "required" === e || "true" === e
        }, validate: function (e, i, n) {
            var s = i.attr("type");
            return "radio" === s || "checkbox" === s ? e.getFieldElements(i.attr("data-bv-field")).filter(":checked").length > 0 : !("number" !== s || !i.get(0).validity || !0 !== i.get(0).validity.badInput) || "" !== t.trim(i.val())
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.numeric = t.extend(t.fn.bootstrapValidator.i18n.numeric || {}, {default: "Please enter a valid float number"}), t.fn.bootstrapValidator.validators.numeric = {
        html5Attributes: {
            message: "message",
            separator: "separator"
        }, enableByHtml5: function (t) {
            return "number" === t.attr("type") && void 0 !== t.attr("step") && t.attr("step") % 1 != 0
        }, validate: function (t, e, i) {
            if (this.enableByHtml5(e) && e.get(0).validity && !0 === e.get(0).validity.badInput) return !1;
            var n = e.val();
            if ("" === n) return !0;
            var s = i.separator || ".";
            return "." !== s && (n = n.replace(s, ".")), !isNaN(parseFloat(n)) && isFinite(n)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.phone = t.extend(t.fn.bootstrapValidator.i18n.phone || {}, {
        default: "Please enter a valid phone number",
        countryNotSupported: "The country code %s is not supported",
        country: "Please enter a valid phone number in %s",
        countries: {
            BR: "Brazil",
            CN: "China",
            CZ: "Czech Republic",
            DE: "Germany",
            DK: "Denmark",
            ES: "Spain",
            FR: "France",
            GB: "United Kingdom",
            MA: "Morocco",
            PK: "Pakistan",
            RO: "Romania",
            RU: "Russia",
            SK: "Slovakia",
            TH: "Thailand",
            US: "USA",
            VE: "Venezuela"
        }
    }), t.fn.bootstrapValidator.validators.phone = {
        html5Attributes: {message: "message", country: "country"},
        COUNTRY_CODES: ["BR", "CN", "CZ", "DE", "DK", "ES", "FR", "GB", "MA", "PK", "RO", "RU", "SK", "TH", "US", "VE"],
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            var r = n.country;
            if ("string" == typeof r && -1 !== t.inArray(r, this.COUNTRY_CODES) || (r = e.getDynamicOption(i, r)), !r || -1 === t.inArray(r.toUpperCase(), this.COUNTRY_CODES)) return {
                valid: !1,
                message: t.fn.bootstrapValidator.helpers.format(t.fn.bootstrapValidator.i18n.phone.countryNotSupported, r)
            };
            var o = !0;
            switch (r.toUpperCase()) {
                case"BR":
                    s = t.trim(s), o = /^(([\d]{4}[-.\s]{1}[\d]{2,3}[-.\s]{1}[\d]{2}[-.\s]{1}[\d]{2})|([\d]{4}[-.\s]{1}[\d]{3}[-.\s]{1}[\d]{4})|((\(?\+?[0-9]{2}\)?\s?)?(\(?\d{2}\)?\s?)?\d{4,5}[-.\s]?\d{4}))$/.test(s);
                    break;
                case"CN":
                    s = t.trim(s), o = /^((00|\+)?(86(?:-| )))?((\d{11})|(\d{3}[- ]{1}\d{4}[- ]{1}\d{4})|((\d{2,4}[- ]){1}(\d{7,8}|(\d{3,4}[- ]{1}\d{4}))([- ]{1}\d{1,4})?))$/.test(s);
                    break;
                case"CZ":
                    o = /^(((00)([- ]?)|\+)(420)([- ]?))?((\d{3})([- ]?)){2}(\d{3})$/.test(s);
                    break;
                case"DE":
                    s = t.trim(s), o = /^(((((((00|\+)49[ \-\/]?)|0)[1-9][0-9]{1,4})[ \-\/]?)|((((00|\+)49\()|\(0)[1-9][0-9]{1,4}\)[ \-\/]?))[0-9]{1,7}([ \-\/]?[0-9]{1,5})?)$/.test(s);
                    break;
                case"DK":
                    s = t.trim(s), o = /^(\+45|0045|\(45\))?\s?[2-9](\s?\d){7}$/.test(s);
                    break;
                case"ES":
                    s = t.trim(s), o = /^(?:(?:(?:\+|00)34\D?))?(?:9|6)(?:\d\D?){8}$/.test(s);
                    break;
                case"FR":
                    s = t.trim(s), o = /^(?:(?:(?:\+|00)33[ ]?(?:\(0\)[ ]?)?)|0){1}[1-9]{1}([ .-]?)(?:\d{2}\1?){3}\d{2}$/.test(s);
                    break;
                case"GB":
                    s = t.trim(s), o = /^\(?(?:(?:0(?:0|11)\)?[\s-]?\(?|\+)44\)?[\s-]?\(?(?:0\)?[\s-]?\(?)?|0)(?:\d{2}\)?[\s-]?\d{4}[\s-]?\d{4}|\d{3}\)?[\s-]?\d{3}[\s-]?\d{3,4}|\d{4}\)?[\s-]?(?:\d{5}|\d{3}[\s-]?\d{3})|\d{5}\)?[\s-]?\d{4,5}|8(?:00[\s-]?11[\s-]?11|45[\s-]?46[\s-]?4\d))(?:(?:[\s-]?(?:x|ext\.?\s?|\#)\d+)?)$/.test(s);
                    break;
                case"MA":
                    s = t.trim(s), o = /^(?:(?:(?:\+|00)212[\s]?(?:[\s]?\(0\)[\s]?)?)|0){1}(?:5[\s.-]?[2-3]|6[\s.-]?[13-9]){1}[0-9]{1}(?:[\s.-]?\d{2}){3}$/.test(s);
                    break;
                case"PK":
                    s = t.trim(s), o = /^0?3[0-9]{2}[0-9]{7}$/.test(s);
                    break;
                case"RO":
                    o = /^(\+4|)?(07[0-8]{1}[0-9]{1}|02[0-9]{2}|03[0-9]{2}){1}?(\s|\.|\-)?([0-9]{3}(\s|\.|\-|)){2}$/g.test(s);
                    break;
                case"RU":
                    o = /^((8|\+7|007)[\-\.\/ ]?)?([\(\/\.]?\d{3}[\)\/\.]?[\-\.\/ ]?)?[\d\-\.\/ ]{7,10}$/g.test(s);
                    break;
                case"SK":
                    o = /^(((00)([- ]?)|\+)(420)([- ]?))?((\d{3})([- ]?)){2}(\d{3})$/.test(s);
                    break;
                case"TH":
                    o = /^0\(?([6|8-9]{2})*-([0-9]{3})*-([0-9]{4})$/.test(s);
                    break;
                case"VE":
                    s = t.trim(s), o = /^0(?:2(?:12|4[0-9]|5[1-9]|6[0-9]|7[0-8]|8[1-35-8]|9[1-5]|3[45789])|4(?:1[246]|2[46]))\d{7}$/.test(s);
                    break;
                case"US":
                default:
                    s = s.replace(/\D/g, ""), o = /^(?:(1\-?)|(\+1 ?))?\(?(\d{3})[\)\-\.]?(\d{3})[\-\.]?(\d{4})$/.test(s) && 10 === s.length
            }
            return {
                valid: o,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.phone.country, t.fn.bootstrapValidator.i18n.phone.countries[r])
            }
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.regexp = t.extend(t.fn.bootstrapValidator.i18n.regexp || {}, {default: "Please enter a value matching the pattern"}), t.fn.bootstrapValidator.validators.regexp = {
        html5Attributes: {
            message: "message",
            regexp: "regexp"
        }, enableByHtml5: function (t) {
            var e = t.attr("pattern");
            return !!e && {regexp: e}
        }, validate: function (t, e, i) {
            var n = e.val();
            return "" === n || ("string" == typeof i.regexp ? new RegExp(i.regexp) : i.regexp).test(n)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.remote = t.extend(t.fn.bootstrapValidator.i18n.remote || {}, {default: "Please enter a valid value"}), t.fn.bootstrapValidator.validators.remote = {
        html5Attributes: {
            message: "message",
            name: "name",
            type: "type",
            url: "url",
            data: "data",
            delay: "delay"
        }, destroy: function (t, e, i) {
            e.data("bv.remote.timer") && (clearTimeout(e.data("bv.remote.timer")), e.removeData("bv.remote.timer"))
        }, validate: function (e, i, n) {
            function s() {
                var e = t.ajax({type: u, headers: h, url: c, dataType: "json", data: l});
                return e.then(function (t) {
                    t.valid = !0 === t.valid || "true" === t.valid, o.resolve(i, "remote", t)
                }), o.fail(function () {
                    e.abort()
                }), o
            }

            var r = i.val(), o = new t.Deferred;
            if ("" === r) return o.resolve(i, "remote", {valid: !0}), o;
            var a = i.attr("data-bv-field"), l = n.data || {}, c = n.url, u = n.type || "GET", h = n.headers || {};
            return "function" == typeof l && (l = l.call(this, e)), "string" == typeof l && (l = JSON.parse(l)), "function" == typeof c && (c = c.call(this, e)), l[n.name || a] = r, n.delay ? (i.data("bv.remote.timer") && clearTimeout(i.data("bv.remote.timer")), i.data("bv.remote.timer", setTimeout(s, n.delay)), o) : s()
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.rtn = t.extend(t.fn.bootstrapValidator.i18n.rtn || {}, {default: "Please enter a valid RTN number"}), t.fn.bootstrapValidator.validators.rtn = {
        validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            if (!/^\d{9}$/.test(n)) return !1;
            for (var s = 0, r = 0; r < n.length; r += 3) s += 3 * parseInt(n.charAt(r), 10) + 7 * parseInt(n.charAt(r + 1), 10) + parseInt(n.charAt(r + 2), 10);
            return 0 !== s && s % 10 == 0
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.sedol = t.extend(t.fn.bootstrapValidator.i18n.sedol || {}, {default: "Please enter a valid SEDOL number"}), t.fn.bootstrapValidator.validators.sedol = {
        validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            if (n = n.toUpperCase(), !/^[0-9A-Z]{7}$/.test(n)) return !1;
            for (var s = 0, r = [1, 3, 1, 7, 3, 9, 1], o = n.length, a = 0; a < o - 1; a++) s += r[a] * parseInt(n.charAt(a), 36);
            return (s = (10 - s % 10) % 10) + "" === n.charAt(o - 1)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.siren = t.extend(t.fn.bootstrapValidator.i18n.siren || {}, {default: "Please enter a valid SIREN number"}), t.fn.bootstrapValidator.validators.siren = {
        validate: function (e, i, n) {
            var s = i.val();
            return "" === s || !!/^\d{9}$/.test(s) && t.fn.bootstrapValidator.helpers.luhn(s)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.siret = t.extend(t.fn.bootstrapValidator.i18n.siret || {}, {default: "Please enter a valid SIRET number"}), t.fn.bootstrapValidator.validators.siret = {
        validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            for (var s, r = 0, o = n.length, a = 0; a < o; a++) s = parseInt(n.charAt(a), 10), a % 2 == 0 && (s *= 2) > 9 && (s -= 9), r += s;
            return r % 10 == 0
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.step = t.extend(t.fn.bootstrapValidator.i18n.step || {}, {default: "Please enter a valid step of %s"}), t.fn.bootstrapValidator.validators.step = {
        html5Attributes: {
            message: "message",
            base: "baseValue",
            step: "step"
        }, validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            if (n = t.extend({}, {baseValue: 0, step: 1}, n), s = parseFloat(s), !t.isNumeric(s)) return !1;
            var r = function (t, e) {
                var i = Math.pow(10, e);
                t *= i;
                var n = t > 0 | -(t < 0);
                return t % 1 == .5 * n ? (Math.floor(t) + (n > 0)) / i : Math.round(t) / i
            }, o = function (t, e) {
                if (0 === e) return 1;
                var i = (t + "").split("."), n = (e + "").split("."),
                    s = (1 === i.length ? 0 : i[1].length) + (1 === n.length ? 0 : n[1].length);
                return r(t - e * Math.floor(t / e), s)
            }(s - n.baseValue, n.step);
            return {
                valid: 0 === o || o === n.step,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.step.default, [n.step])
            }
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.stringCase = t.extend(t.fn.bootstrapValidator.i18n.stringCase || {}, {
        default: "Please enter only lowercase characters",
        upper: "Please enter only uppercase characters"
    }), t.fn.bootstrapValidator.validators.stringCase = {
        html5Attributes: {message: "message", case: "case"},
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            var r = (n.case || "lower").toLowerCase();
            return {
                valid: "upper" === r ? s === s.toUpperCase() : s === s.toLowerCase(),
                message: n.message || ("upper" === r ? t.fn.bootstrapValidator.i18n.stringCase.upper : t.fn.bootstrapValidator.i18n.stringCase.default)
            }
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.stringLength = t.extend(t.fn.bootstrapValidator.i18n.stringLength || {}, {
        default: "Please enter a value with valid length",
        less: "Please enter less than %s characters",
        more: "Please enter more than %s characters",
        between: "Please enter value between %s and %s characters long"
    }), t.fn.bootstrapValidator.validators.stringLength = {
        html5Attributes: {
            message: "message",
            min: "min",
            max: "max",
            trim: "trim",
            utf8bytes: "utf8Bytes"
        }, enableByHtml5: function (e) {
            var i = {}, n = e.attr("maxlength"), s = e.attr("minlength");
            return n && (i.max = parseInt(n, 10)), s && (i.min = parseInt(s, 10)), !t.isEmptyObject(i) && i
        }, validate: function (e, i, n) {
            var s = i.val();
            if (!0 !== n.trim && "true" !== n.trim || (s = t.trim(s)), "" === s) return !0;
            var r = t.isNumeric(n.min) ? n.min : e.getDynamicOption(i, n.min),
                o = t.isNumeric(n.max) ? n.max : e.getDynamicOption(i, n.max), a = n.utf8Bytes ? function (t) {
                    for (var e = t.length, i = t.length - 1; i >= 0; i--) {
                        var n = t.charCodeAt(i);
                        n > 127 && n <= 2047 ? e++ : n > 2047 && n <= 65535 && (e += 2), n >= 56320 && n <= 57343 && i--
                    }
                    return e
                }(s) : s.length, l = !0, c = n.message || t.fn.bootstrapValidator.i18n.stringLength.default;
            switch ((r && a < parseInt(r, 10) || o && a > parseInt(o, 10)) && (l = !1), !0) {
                case!!r && !!o:
                    c = t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.stringLength.between, [parseInt(r, 10), parseInt(o, 10)]);
                    break;
                case!!r:
                    c = t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.stringLength.more, parseInt(r, 10));
                    break;
                case!!o:
                    c = t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.stringLength.less, parseInt(o, 10))
            }
            return {valid: l, message: c}
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.uri = t.extend(t.fn.bootstrapValidator.i18n.uri || {}, {default: "Please enter a valid URI"}), t.fn.bootstrapValidator.validators.uri = {
        html5Attributes: {
            message: "message",
            allowlocal: "allowLocal",
            protocol: "protocol"
        }, enableByHtml5: function (t) {
            return "url" === t.attr("type")
        }, validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            var s = !0 === i.allowLocal || "true" === i.allowLocal,
                r = (i.protocol || "http, https, ftp").split(",").join("|").replace(/\s/g, "");
            return new RegExp("^(?:(?:" + r + ")://)(?:\\S+(?::\\S*)?@)?(?:" + (s ? "" : "(?!(?:10|127)(?:\\.\\d{1,3}){3})(?!(?:169\\.254|192\\.168)(?:\\.\\d{1,3}){2})(?!172\\.(?:1[6-9]|2\\d|3[0-1])(?:\\.\\d{1,3}){2})") + "(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,}))" + (s ? "?" : "") + ")(?::\\d{2,5})?(?:/[^\\s]*)?$", "i").test(n)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.uuid = t.extend(t.fn.bootstrapValidator.i18n.uuid || {}, {
        default: "Please enter a valid UUID number",
        version: "Please enter a valid UUID version %s number"
    }), t.fn.bootstrapValidator.validators.uuid = {
        html5Attributes: {message: "message", version: "version"},
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            var r = {
                3: /^[0-9A-F]{8}-[0-9A-F]{4}-3[0-9A-F]{3}-[0-9A-F]{4}-[0-9A-F]{12}$/i,
                4: /^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i,
                5: /^[0-9A-F]{8}-[0-9A-F]{4}-5[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i,
                all: /^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/i
            }, o = n.version ? n.version + "" : "all";
            return {
                valid: null === r[o] || r[o].test(s),
                message: n.version ? t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.uuid.version, n.version) : n.message || t.fn.bootstrapValidator.i18n.uuid.default
            }
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.vat = t.extend(t.fn.bootstrapValidator.i18n.vat || {}, {
        default: "Please enter a valid VAT number",
        countryNotSupported: "The country code %s is not supported",
        country: "Please enter a valid VAT number in %s",
        countries: {
            AT: "Austria",
            BE: "Belgium",
            BG: "Bulgaria",
            BR: "Brazil",
            CH: "Switzerland",
            CY: "Cyprus",
            CZ: "Czech Republic",
            DE: "Germany",
            DK: "Denmark",
            EE: "Estonia",
            ES: "Spain",
            FI: "Finland",
            FR: "France",
            GB: "United Kingdom",
            GR: "Greek",
            EL: "Greek",
            HU: "Hungary",
            HR: "Croatia",
            IE: "Ireland",
            IS: "Iceland",
            IT: "Italy",
            LT: "Lithuania",
            LU: "Luxembourg",
            LV: "Latvia",
            MT: "Malta",
            NL: "Netherlands",
            NO: "Norway",
            PL: "Poland",
            PT: "Portugal",
            RO: "Romania",
            RU: "Russia",
            RS: "Serbia",
            SE: "Sweden",
            SI: "Slovenia",
            SK: "Slovakia",
            VE: "Venezuela",
            ZA: "South Africa"
        }
    }), t.fn.bootstrapValidator.validators.vat = {
        html5Attributes: {message: "message", country: "country"},
        COUNTRY_CODES: ["AT", "BE", "BG", "BR", "CH", "CY", "CZ", "DE", "DK", "EE", "EL", "ES", "FI", "FR", "GB", "GR", "HR", "HU", "IE", "IS", "IT", "LT", "LU", "LV", "MT", "NL", "NO", "PL", "PT", "RO", "RU", "RS", "SE", "SK", "SI", "VE", "ZA"],
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s) return !0;
            var r = n.country;
            return r ? "string" == typeof r && -1 !== t.inArray(r.toUpperCase(), this.COUNTRY_CODES) || (r = e.getDynamicOption(i, r)) : r = s.substr(0, 2), -1 === t.inArray(r, this.COUNTRY_CODES) ? {
                valid: !1,
                message: t.fn.bootstrapValidator.helpers.format(t.fn.bootstrapValidator.i18n.vat.countryNotSupported, r)
            } : !!this[["_", r.toLowerCase()].join("")](s) || {
                valid: !1,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.vat.country, t.fn.bootstrapValidator.i18n.vat.countries[r.toUpperCase()])
            }
        },
        _at: function (t) {
            if (/^ATU[0-9]{8}$/.test(t) && (t = t.substr(2)), !/^U[0-9]{8}$/.test(t)) return !1;
            t = t.substr(1);
            for (var e = 0, i = [1, 2, 1, 2, 1, 2, 1], n = 0, s = 0; s < 7; s++) n = parseInt(t.charAt(s), 10) * i[s], n > 9 && (n = Math.floor(n / 10) + n % 10), e += n;
            return e = 10 - (e + 4) % 10, 10 === e && (e = 0), e + "" === t.substr(7, 1)
        },
        _be: function (t) {
            return /^BE[0]{0,1}[0-9]{9}$/.test(t) && (t = t.substr(2)), !!/^[0]{0,1}[0-9]{9}$/.test(t) && (9 === t.length && (t = "0" + t), "0" !== t.substr(1, 1) && (parseInt(t.substr(0, 8), 10) + parseInt(t.substr(8, 2), 10)) % 97 == 0)
        },
        _bg: function (e) {
            if (/^BG[0-9]{9,10}$/.test(e) && (e = e.substr(2)), !/^[0-9]{9,10}$/.test(e)) return !1;
            var i = 0, n = 0;
            if (9 === e.length) {
                for (n = 0; n < 8; n++) i += parseInt(e.charAt(n), 10) * (n + 1);
                if (10 === (i %= 11)) for (i = 0, n = 0; n < 8; n++) i += parseInt(e.charAt(n), 10) * (n + 3);
                return (i %= 10) + "" === e.substr(8)
            }
            if (10 === e.length) {
                return function (e) {
                    var i = parseInt(e.substr(0, 2), 10) + 1900, n = parseInt(e.substr(2, 2), 10),
                        s = parseInt(e.substr(4, 2), 10);
                    if (n > 40 ? (i += 100, n -= 40) : n > 20 && (i -= 100, n -= 20), !t.fn.bootstrapValidator.helpers.date(i, n, s)) return !1;
                    for (var r = 0, o = [2, 4, 8, 5, 10, 9, 7, 3, 6], a = 0; a < 9; a++) r += parseInt(e.charAt(a), 10) * o[a];
                    return (r = r % 11 % 10) + "" === e.substr(9, 1)
                }(e) || function (t) {
                    for (var e = 0, i = [21, 19, 17, 13, 11, 9, 7, 3, 1], n = 0; n < 9; n++) e += parseInt(t.charAt(n), 10) * i[n];
                    return (e %= 10) + "" === t.substr(9, 1)
                }(e) || function (t) {
                    for (var e = 0, i = [4, 3, 2, 7, 6, 5, 4, 3, 2], n = 0; n < 9; n++) e += parseInt(t.charAt(n), 10) * i[n];
                    return 10 != (e = 11 - e % 11) && (11 === e && (e = 0), e + "" === t.substr(9, 1))
                }(e)
            }
            return !1
        },
        _br: function (t) {
            if ("" === t) return !0;
            var e = t.replace(/[^\d]+/g, "");
            if ("" === e || 14 !== e.length) return !1;
            if ("00000000000000" === e || "11111111111111" === e || "22222222222222" === e || "33333333333333" === e || "44444444444444" === e || "55555555555555" === e || "66666666666666" === e || "77777777777777" === e || "88888888888888" === e || "99999999999999" === e) return !1;
            for (var i = e.length - 2, n = e.substring(0, i), s = e.substring(i), r = 0, o = i - 7, a = i; a >= 1; a--) r += parseInt(n.charAt(i - a), 10) * o--, o < 2 && (o = 9);
            var l = r % 11 < 2 ? 0 : 11 - r % 11;
            if (l !== parseInt(s.charAt(0), 10)) return !1;
            for (i += 1, n = e.substring(0, i), r = 0, o = i - 7, a = i; a >= 1; a--) r += parseInt(n.charAt(i - a), 10) * o--, o < 2 && (o = 9);
            return (l = r % 11 < 2 ? 0 : 11 - r % 11) === parseInt(s.charAt(1), 10)
        },
        _ch: function (t) {
            if (/^CHE[0-9]{9}(MWST)?$/.test(t) && (t = t.substr(2)), !/^E[0-9]{9}(MWST)?$/.test(t)) return !1;
            t = t.substr(1);
            for (var e = 0, i = [5, 4, 3, 2, 7, 6, 5, 4], n = 0; n < 8; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return 10 != (e = 11 - e % 11) && (11 === e && (e = 0), e + "" === t.substr(8, 1))
        },
        _cy: function (t) {
            if (/^CY[0-5|9]{1}[0-9]{7}[A-Z]{1}$/.test(t) && (t = t.substr(2)), !/^[0-5|9]{1}[0-9]{7}[A-Z]{1}$/.test(t)) return !1;
            if ("12" === t.substr(0, 2)) return !1;
            for (var e = 0, i = {0: 1, 1: 0, 2: 5, 3: 7, 4: 9, 5: 13, 6: 15, 7: 17, 8: 19, 9: 21}, n = 0; n < 8; n++) {
                var s = parseInt(t.charAt(n), 10);
                n % 2 == 0 && (s = i[s + ""]), e += s
            }
            return (e = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"[e % 26]) + "" === t.substr(8, 1)
        },
        _cz: function (e) {
            if (/^CZ[0-9]{8,10}$/.test(e) && (e = e.substr(2)), !/^[0-9]{8,10}$/.test(e)) return !1;
            var i = 0, n = 0;
            if (8 === e.length) {
                if (e.charAt(0) + "" == "9") return !1;
                for (i = 0, n = 0; n < 7; n++) i += parseInt(e.charAt(n), 10) * (8 - n);
                return i = 11 - i % 11, 10 === i && (i = 0), 11 === i && (i = 1), i + "" === e.substr(7, 1)
            }
            if (9 === e.length && e.charAt(0) + "" == "6") {
                for (i = 0, n = 0; n < 7; n++) i += parseInt(e.charAt(n + 1), 10) * (8 - n);
                return i = 11 - i % 11, 10 === i && (i = 0), 11 === i && (i = 1), (i = [8, 7, 6, 5, 4, 3, 2, 1, 0, 9, 10][i - 1]) + "" === e.substr(8, 1)
            }
            if (9 === e.length || 10 === e.length) {
                var s = 1900 + parseInt(e.substr(0, 2), 10), r = parseInt(e.substr(2, 2), 10) % 50 % 20,
                    o = parseInt(e.substr(4, 2), 10);
                if (9 === e.length) {
                    if (s >= 1980 && (s -= 100), s > 1953) return !1
                } else s < 1954 && (s += 100);
                if (!t.fn.bootstrapValidator.helpers.date(s, r, o)) return !1;
                if (10 === e.length) {
                    var a = parseInt(e.substr(0, 9), 10) % 11;
                    return s < 1985 && (a %= 10), a + "" === e.substr(9, 1)
                }
                return !0
            }
            return !1
        },
        _de: function (e) {
            return /^DE[0-9]{9}$/.test(e) && (e = e.substr(2)), !!/^[0-9]{9}$/.test(e) && t.fn.bootstrapValidator.helpers.mod11And10(e)
        },
        _dk: function (t) {
            if (/^DK[0-9]{8}$/.test(t) && (t = t.substr(2)), !/^[0-9]{8}$/.test(t)) return !1;
            for (var e = 0, i = [2, 7, 6, 5, 4, 3, 2, 1], n = 0; n < 8; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e % 11 == 0
        },
        _ee: function (t) {
            if (/^EE[0-9]{9}$/.test(t) && (t = t.substr(2)), !/^[0-9]{9}$/.test(t)) return !1;
            for (var e = 0, i = [3, 7, 1, 3, 7, 1, 3, 7, 1], n = 0; n < 9; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e % 10 == 0
        },
        _es: function (t) {
            if (/^ES[0-9A-Z][0-9]{7}[0-9A-Z]$/.test(t) && (t = t.substr(2)), !/^[0-9A-Z][0-9]{7}[0-9A-Z]$/.test(t)) return !1;
            var e = t.charAt(0);
            return /^[0-9]$/.test(e) ? function (t) {
                var e = parseInt(t.substr(0, 8), 10);
                return (e = "TRWAGMYFPDXBNJZSQVHLCKE"[e % 23]) + "" === t.substr(8, 1)
            }(t) : /^[XYZ]$/.test(e) ? function (t) {
                var e = ["XYZ".indexOf(t.charAt(0)), t.substr(1)].join("");
                return e = parseInt(e, 10), (e = "TRWAGMYFPDXBNJZSQVHLCKE"[e % 23]) + "" === t.substr(8, 1)
            }(t) : function (t) {
                var e, i = t.charAt(0);
                if (-1 !== "KLM".indexOf(i)) return e = parseInt(t.substr(1, 8), 10), (e = "TRWAGMYFPDXBNJZSQVHLCKE"[e % 23]) + "" === t.substr(8, 1);
                if (-1 !== "ABCDEFGHJNPQRSUVW".indexOf(i)) {
                    for (var n = 0, s = [2, 1, 2, 1, 2, 1, 2], r = 0, o = 0; o < 7; o++) r = parseInt(t.charAt(o + 1), 10) * s[o], r > 9 && (r = Math.floor(r / 10) + r % 10), n += r;
                    return (n = 10 - n % 10) + "" === t.substr(8, 1) || "JABCDEFGHI"[n] === t.substr(8, 1)
                }
                return !1
            }(t)
        },
        _fi: function (t) {
            if (/^FI[0-9]{8}$/.test(t) && (t = t.substr(2)), !/^[0-9]{8}$/.test(t)) return !1;
            for (var e = 0, i = [7, 9, 10, 5, 8, 4, 2, 1], n = 0; n < 8; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e % 11 == 0
        },
        _fr: function (e) {
            if (/^FR[0-9A-Z]{2}[0-9]{9}$/.test(e) && (e = e.substr(2)), !/^[0-9A-Z]{2}[0-9]{9}$/.test(e)) return !1;
            if (!t.fn.bootstrapValidator.helpers.luhn(e.substr(2))) return !1;
            if (/^[0-9]{2}$/.test(e.substr(0, 2))) return e.substr(0, 2) === parseInt(e.substr(2) + "12", 10) % 97 + "";
            var i, n = "0123456789ABCDEFGHJKLMNPQRSTUVWXYZ";
            return i = /^[0-9]{1}$/.test(e.charAt(0)) ? 24 * n.indexOf(e.charAt(0)) + n.indexOf(e.charAt(1)) - 10 : 34 * n.indexOf(e.charAt(0)) + n.indexOf(e.charAt(1)) - 100, (parseInt(e.substr(2), 10) + 1 + Math.floor(i / 11)) % 11 == i % 11
        },
        _gb: function (t) {
            if ((/^GB[0-9]{9}$/.test(t) || /^GB[0-9]{12}$/.test(t) || /^GBGD[0-9]{3}$/.test(t) || /^GBHA[0-9]{3}$/.test(t) || /^GB(GD|HA)8888[0-9]{5}$/.test(t)) && (t = t.substr(2)), !(/^[0-9]{9}$/.test(t) || /^[0-9]{12}$/.test(t) || /^GD[0-9]{3}$/.test(t) || /^HA[0-9]{3}$/.test(t) || /^(GD|HA)8888[0-9]{5}$/.test(t))) return !1;
            var e = t.length;
            if (5 === e) {
                var i = t.substr(0, 2), n = parseInt(t.substr(2), 10);
                return "GD" === i && n < 500 || "HA" === i && n >= 500
            }
            if (11 === e && ("GD8888" === t.substr(0, 6) || "HA8888" === t.substr(0, 6))) return !("GD" === t.substr(0, 2) && parseInt(t.substr(6, 3), 10) >= 500 || "HA" === t.substr(0, 2) && parseInt(t.substr(6, 3), 10) < 500) && parseInt(t.substr(6, 3), 10) % 97 === parseInt(t.substr(9, 2), 10);
            if (9 === e || 12 === e) {
                for (var s = 0, r = [8, 7, 6, 5, 4, 3, 2, 10, 1], o = 0; o < 9; o++) s += parseInt(t.charAt(o), 10) * r[o];
                return s %= 97, parseInt(t.substr(0, 3), 10) >= 100 ? 0 === s || 42 === s || 55 === s : 0 === s
            }
            return !0
        },
        _gr: function (t) {
            if (/^(GR|EL)[0-9]{9}$/.test(t) && (t = t.substr(2)), !/^[0-9]{9}$/.test(t)) return !1;
            8 === t.length && (t = "0" + t);
            for (var e = 0, i = [256, 128, 64, 32, 16, 8, 4, 2], n = 0; n < 8; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return (e = e % 11 % 10) + "" === t.substr(8, 1)
        },
        _el: function (t) {
            return this._gr(t)
        },
        _hu: function (t) {
            if (/^HU[0-9]{8}$/.test(t) && (t = t.substr(2)), !/^[0-9]{8}$/.test(t)) return !1;
            for (var e = 0, i = [9, 7, 3, 1, 9, 7, 3, 1], n = 0; n < 8; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e % 10 == 0
        },
        _hr: function (e) {
            return /^HR[0-9]{11}$/.test(e) && (e = e.substr(2)), !!/^[0-9]{11}$/.test(e) && t.fn.bootstrapValidator.helpers.mod11And10(e)
        },
        _ie: function (t) {
            if (/^IE[0-9]{1}[0-9A-Z\*\+]{1}[0-9]{5}[A-Z]{1,2}$/.test(t) && (t = t.substr(2)), !/^[0-9]{1}[0-9A-Z\*\+]{1}[0-9]{5}[A-Z]{1,2}$/.test(t)) return !1;
            var e = function (t) {
                for (; t.length < 7;) t = "0" + t;
                for (var e = "WABCDEFGHIJKLMNOPQRSTUV", i = 0, n = 0; n < 7; n++) i += parseInt(t.charAt(n), 10) * (8 - n);
                return i += 9 * e.indexOf(t.substr(7)), e[i % 23]
            };
            return /^[0-9]+$/.test(t.substr(0, 7)) ? t.charAt(7) === e(t.substr(0, 7) + t.substr(8) + "") : -1 === "ABCDEFGHIJKLMNOPQRSTUVWXYZ+*".indexOf(t.charAt(1)) || t.charAt(7) === e(t.substr(2, 5) + t.substr(0, 1) + "")
        },
        _is: function (t) {
            return /^IS[0-9]{5,6}$/.test(t) && (t = t.substr(2)), /^[0-9]{5,6}$/.test(t)
        },
        _it: function (e) {
            if (/^IT[0-9]{11}$/.test(e) && (e = e.substr(2)), !/^[0-9]{11}$/.test(e)) return !1;
            if (0 === parseInt(e.substr(0, 7), 10)) return !1;
            var i = parseInt(e.substr(7, 3), 10);
            return !(i < 1 || i > 201 && 999 !== i && 888 !== i) && t.fn.bootstrapValidator.helpers.luhn(e)
        },
        _lt: function (t) {
            if (/^LT([0-9]{7}1[0-9]{1}|[0-9]{10}1[0-9]{1})$/.test(t) && (t = t.substr(2)), !/^([0-9]{7}1[0-9]{1}|[0-9]{10}1[0-9]{1})$/.test(t)) return !1;
            var e, i = t.length, n = 0;
            for (e = 0; e < i - 1; e++) n += parseInt(t.charAt(e), 10) * (1 + e % 9);
            var s = n % 11;
            if (10 === s) for (n = 0, e = 0; e < i - 1; e++) n += parseInt(t.charAt(e), 10) * (1 + (e + 2) % 9);
            return (s = s % 11 % 10) + "" === t.charAt(i - 1)
        },
        _lu: function (t) {
            return /^LU[0-9]{8}$/.test(t) && (t = t.substr(2)), !!/^[0-9]{8}$/.test(t) && parseInt(t.substr(0, 6), 10) % 89 + "" === t.substr(6, 2)
        },
        _lv: function (e) {
            if (/^LV[0-9]{11}$/.test(e) && (e = e.substr(2)), !/^[0-9]{11}$/.test(e)) return !1;
            var i, n = parseInt(e.charAt(0), 10), s = 0, r = [], o = e.length;
            if (n > 3) {
                for (s = 0, r = [9, 1, 4, 8, 3, 10, 2, 5, 7, 6, 1], i = 0; i < o; i++) s += parseInt(e.charAt(i), 10) * r[i];
                return 3 === (s %= 11)
            }
            var a = parseInt(e.substr(0, 2), 10), l = parseInt(e.substr(2, 2), 10), c = parseInt(e.substr(4, 2), 10);
            if (c = c + 1800 + 100 * parseInt(e.charAt(6), 10), !t.fn.bootstrapValidator.helpers.date(c, l, a)) return !1;
            for (s = 0, r = [10, 5, 8, 4, 2, 1, 6, 3, 7, 9], i = 0; i < o - 1; i++) s += parseInt(e.charAt(i), 10) * r[i];
            return (s = (s + 1) % 11 % 10) + "" === e.charAt(o - 1)
        },
        _mt: function (t) {
            if (/^MT[0-9]{8}$/.test(t) && (t = t.substr(2)), !/^[0-9]{8}$/.test(t)) return !1;
            for (var e = 0, i = [3, 4, 6, 7, 8, 9, 10, 1], n = 0; n < 8; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e % 37 == 0
        },
        _nl: function (t) {
            if (/^NL[0-9]{9}B[0-9]{2}$/.test(t) && (t = t.substr(2)), !/^[0-9]{9}B[0-9]{2}$/.test(t)) return !1;
            for (var e = 0, i = [9, 8, 7, 6, 5, 4, 3, 2], n = 0; n < 8; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e %= 11, e > 9 && (e = 0), e + "" === t.substr(8, 1)
        },
        _no: function (t) {
            if (/^NO[0-9]{9}$/.test(t) && (t = t.substr(2)), !/^[0-9]{9}$/.test(t)) return !1;
            for (var e = 0, i = [3, 2, 7, 6, 5, 4, 3, 2], n = 0; n < 8; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e = 11 - e % 11, 11 === e && (e = 0), e + "" === t.substr(8, 1)
        },
        _pl: function (t) {
            if (/^PL[0-9]{10}$/.test(t) && (t = t.substr(2)), !/^[0-9]{10}$/.test(t)) return !1;
            for (var e = 0, i = [6, 5, 7, 2, 3, 4, 5, 6, 7, -1], n = 0; n < 10; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e % 11 == 0
        },
        _pt: function (t) {
            if (/^PT[0-9]{9}$/.test(t) && (t = t.substr(2)),
                !/^[0-9]{9}$/.test(t)) return !1;
            for (var e = 0, i = [9, 8, 7, 6, 5, 4, 3, 2], n = 0; n < 8; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e = 11 - e % 11, e > 9 && (e = 0), e + "" === t.substr(8, 1)
        },
        _ro: function (t) {
            if (/^RO[1-9][0-9]{1,9}$/.test(t) && (t = t.substr(2)), !/^[1-9][0-9]{1,9}$/.test(t)) return !1;
            for (var e = t.length, i = [7, 5, 3, 2, 1, 7, 5, 3, 2].slice(10 - e), n = 0, s = 0; s < e - 1; s++) n += parseInt(t.charAt(s), 10) * i[s];
            return (n = 10 * n % 11 % 10) + "" === t.substr(e - 1, 1)
        },
        _ru: function (t) {
            if (/^RU([0-9]{10}|[0-9]{12})$/.test(t) && (t = t.substr(2)), !/^([0-9]{10}|[0-9]{12})$/.test(t)) return !1;
            var e = 0;
            if (10 === t.length) {
                var i = 0, n = [2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
                for (e = 0; e < 10; e++) i += parseInt(t.charAt(e), 10) * n[e];
                return i %= 11, i > 9 && (i %= 10), i + "" === t.substr(9, 1)
            }
            if (12 === t.length) {
                var s = 0, r = [7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0], o = 0, a = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
                for (e = 0; e < 11; e++) s += parseInt(t.charAt(e), 10) * r[e], o += parseInt(t.charAt(e), 10) * a[e];
                return s %= 11, s > 9 && (s %= 10), o %= 11, o > 9 && (o %= 10), s + "" === t.substr(10, 1) && o + "" === t.substr(11, 1)
            }
            return !1
        },
        _rs: function (t) {
            if (/^RS[0-9]{9}$/.test(t) && (t = t.substr(2)), !/^[0-9]{9}$/.test(t)) return !1;
            for (var e = 10, i = 0, n = 0; n < 8; n++) i = (parseInt(t.charAt(n), 10) + e) % 10, 0 === i && (i = 10), e = 2 * i % 11;
            return (e + parseInt(t.substr(8, 1), 10)) % 10 == 1
        },
        _se: function (e) {
            return /^SE[0-9]{10}01$/.test(e) && (e = e.substr(2)), !!/^[0-9]{10}01$/.test(e) && (e = e.substr(0, 10), t.fn.bootstrapValidator.helpers.luhn(e))
        },
        _si: function (t) {
            if (/^SI[0-9]{8}$/.test(t) && (t = t.substr(2)), !/^[0-9]{8}$/.test(t)) return !1;
            for (var e = 0, i = [8, 7, 6, 5, 4, 3, 2], n = 0; n < 7; n++) e += parseInt(t.charAt(n), 10) * i[n];
            return e = 11 - e % 11, 10 === e && (e = 0), e + "" === t.substr(7, 1)
        },
        _sk: function (t) {
            return /^SK[1-9][0-9][(2-4)|(6-9)][0-9]{7}$/.test(t) && (t = t.substr(2)), !!/^[1-9][0-9][(2-4)|(6-9)][0-9]{7}$/.test(t) && parseInt(t, 10) % 11 == 0
        },
        _ve: function (t) {
            if (/^VE[VEJPG][0-9]{9}$/.test(t) && (t = t.substr(2)), !/^[VEJPG][0-9]{9}$/.test(t)) return !1;
            for (var e = {
                V: 4,
                E: 8,
                J: 12,
                P: 16,
                G: 20
            }, i = e[t.charAt(0)], n = [3, 2, 7, 6, 5, 4, 3, 2], s = 0; s < 8; s++) i += parseInt(t.charAt(s + 1), 10) * n[s];
            return i = 11 - i % 11, 11 !== i && 10 !== i || (i = 0), i + "" === t.substr(9, 1)
        },
        _za: function (t) {
            return /^ZA4[0-9]{9}$/.test(t) && (t = t.substr(2)), /^4[0-9]{9}$/.test(t)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.vin = t.extend(t.fn.bootstrapValidator.i18n.vin || {}, {default: "Please enter a valid VIN number"}), t.fn.bootstrapValidator.validators.vin = {
        validate: function (t, e, i) {
            var n = e.val();
            if ("" === n) return !0;
            if (!/^[a-hj-npr-z0-9]{8}[0-9xX][a-hj-npr-z0-9]{8}$/i.test(n)) return !1;
            n = n.toUpperCase();
            for (var s = {
                A: 1,
                B: 2,
                C: 3,
                D: 4,
                E: 5,
                F: 6,
                G: 7,
                H: 8,
                J: 1,
                K: 2,
                L: 3,
                M: 4,
                N: 5,
                P: 7,
                R: 9,
                S: 2,
                T: 3,
                U: 4,
                V: 5,
                W: 6,
                X: 7,
                Y: 8,
                Z: 9,
                1: 1,
                2: 2,
                3: 3,
                4: 4,
                5: 5,
                6: 6,
                7: 7,
                8: 8,
                9: 9,
                0: 0
            }, r = [8, 7, 6, 5, 4, 3, 2, 10, 0, 9, 8, 7, 6, 5, 4, 3, 2], o = 0, a = n.length, l = 0; l < a; l++) o += s[n.charAt(l) + ""] * r[l];
            var c = o % 11;
            return 10 === c && (c = "X"), c + "" === n.charAt(8)
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n.zipCode = t.extend(t.fn.bootstrapValidator.i18n.zipCode || {}, {
        default: "Please enter a valid postal code",
        countryNotSupported: "The country code %s is not supported",
        country: "Please enter a valid postal code in %s",
        countries: {
            AT: "Austria",
            BR: "Brazil",
            CA: "Canada",
            CH: "Switzerland",
            CZ: "Czech Republic",
            DE: "Germany",
            DK: "Denmark",
            FR: "France",
            GB: "United Kingdom",
            IE: "Ireland",
            IT: "Italy",
            MA: "Morocco",
            NL: "Netherlands",
            PT: "Portugal",
            RO: "Romania",
            RU: "Russia",
            SE: "Sweden",
            SG: "Singapore",
            SK: "Slovakia",
            US: "USA"
        }
    }), t.fn.bootstrapValidator.validators.zipCode = {
        html5Attributes: {message: "message", country: "country"},
        COUNTRY_CODES: ["AT", "BR", "CA", "CH", "CZ", "DE", "DK", "FR", "GB", "IE", "IT", "MA", "NL", "PT", "RO", "RU", "SE", "SG", "SK", "US"],
        validate: function (e, i, n) {
            var s = i.val();
            if ("" === s || !n.country) return !0;
            var r = n.country;
            if ("string" == typeof r && -1 !== t.inArray(r, this.COUNTRY_CODES) || (r = e.getDynamicOption(i, r)), !r || -1 === t.inArray(r.toUpperCase(), this.COUNTRY_CODES)) return {
                valid: !1,
                message: t.fn.bootstrapValidator.helpers.format(t.fn.bootstrapValidator.i18n.zipCode.countryNotSupported, r)
            };
            var o = !1;
            switch (r = r.toUpperCase()) {
                case"AT":
                    o = /^([1-9]{1})(\d{3})$/.test(s);
                    break;
                case"BR":
                    o = /^(\d{2})([\.]?)(\d{3})([\-]?)(\d{3})$/.test(s);
                    break;
                case"CA":
                    o = /^(?:A|B|C|E|G|H|J|K|L|M|N|P|R|S|T|V|X|Y){1}[0-9]{1}(?:A|B|C|E|G|H|J|K|L|M|N|P|R|S|T|V|W|X|Y|Z){1}\s?[0-9]{1}(?:A|B|C|E|G|H|J|K|L|M|N|P|R|S|T|V|W|X|Y|Z){1}[0-9]{1}$/i.test(s);
                    break;
                case"CH":
                    o = /^([1-9]{1})(\d{3})$/.test(s);
                    break;
                case"CZ":
                    o = /^(\d{3})([ ]?)(\d{2})$/.test(s);
                    break;
                case"DE":
                    o = /^(?!01000|99999)(0[1-9]\d{3}|[1-9]\d{4})$/.test(s);
                    break;
                case"DK":
                    o = /^(DK(-|\s)?)?\d{4}$/i.test(s);
                    break;
                case"FR":
                    o = /^[0-9]{5}$/i.test(s);
                    break;
                case"GB":
                    o = this._gb(s);
                    break;
                case"IE":
                    o = /^(D6W|[ACDEFHKNPRTVWXY]\d{2})\s[0-9ACDEFHKNPRTVWXY]{4}$/.test(s);
                    break;
                case"IT":
                    o = /^(I-|IT-)?\d{5}$/i.test(s);
                    break;
                case"MA":
                    o = /^[1-9][0-9]{4}$/i.test(s);
                    break;
                case"NL":
                    o = /^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i.test(s);
                    break;
                case"PT":
                    o = /^[1-9]\d{3}-\d{3}$/.test(s);
                    break;
                case"RO":
                    o = /^(0[1-8]{1}|[1-9]{1}[0-5]{1})?[0-9]{4}$/i.test(s);
                    break;
                case"RU":
                    o = /^[0-9]{6}$/i.test(s);
                    break;
                case"SE":
                    o = /^(S-)?\d{3}\s?\d{2}$/i.test(s);
                    break;
                case"SG":
                    o = /^([0][1-9]|[1-6][0-9]|[7]([0-3]|[5-9])|[8][0-2])(\d{4})$/i.test(s);
                    break;
                case"SK":
                    o = /^(\d{3})([ ]?)(\d{2})$/.test(s);
                    break;
                case"US":
                default:
                    o = /^\d{4,5}([\-]?\d{4})?$/.test(s)
            }
            return {
                valid: o,
                message: t.fn.bootstrapValidator.helpers.format(n.message || t.fn.bootstrapValidator.i18n.zipCode.country, t.fn.bootstrapValidator.i18n.zipCode.countries[r])
            }
        },
        _gb: function (t) {
            for (var e = "[ABCDEFGHIJKLMNOPRSTUWYZ]", i = "[ABDEFGHJLNPQRSTUWXYZ]", n = [new RegExp("^(" + e + "{1}[ABCDEFGHKLMNOPQRSTUVWXY]?[0-9]{1,2})(\\s*)([0-9]{1}" + i + "{2})$", "i"), new RegExp("^(" + e + "{1}[0-9]{1}[ABCDEFGHJKPMNRSTUVWXY]{1})(\\s*)([0-9]{1}" + i + "{2})$", "i"), new RegExp("^(" + e + "{1}[ABCDEFGHKLMNOPQRSTUVWXY]{1}?[0-9]{1}[ABEHMNPRVWXY]{1})(\\s*)([0-9]{1}" + i + "{2})$", "i"), new RegExp("^(BF1)(\\s*)([0-6]{1}[ABDEFGHJLNPQRST]{1}[ABDEFGHJLNPQRSTUWZYZ]{1})$", "i"), /^(GIR)(\s*)(0AA)$/i, /^(BFPO)(\s*)([0-9]{1,4})$/i, /^(BFPO)(\s*)(c\/o\s*[0-9]{1,3})$/i, /^([A-Z]{4})(\s*)(1ZZ)$/i, /^(AI-2640)$/i], s = 0; s < n.length; s++) if (n[s].test(t)) return !0;
            return !1
        }
    }
}(window.jQuery), function (t) {
    t.fn.bootstrapValidator.i18n = t.extend(!0, t.fn.bootstrapValidator.i18n, {
        base64: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„Base64ç¼–ç "},
        between: {
            default: "è¯·è¾“å…¥åœ¨ %s å’Œ %s ä¹‹é—´çš„æ•°å€¼",
            notInclusive: "è¯·è¾“å…¥åœ¨ %s å’Œ %s ä¹‹é—´(ä¸å«ä¸¤ç«¯)çš„æ•°å€¼"
        },
        callback: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„å€¼"},
        choice: {
            default: "è¯·è¾“å…¥æœ‰æ•ˆçš„å€¼",
            less: "è¯·è‡³å°‘é€‰ä¸­ %s ä¸ªé€‰é¡¹",
            more: "æœ€å¤šåªèƒ½é€‰ä¸­ %s ä¸ªé€‰é¡¹",
            between: "è¯·é€‰æ‹© %s è‡³ %s ä¸ªé€‰é¡¹"
        },
        color: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„é¢œè‰²å€¼"},
        creditCard: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„ä¿¡ç”¨å¡å·ç "},
        cusip: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„ç¾Žå›½CUSIPä»£ç "},
        cvv: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„CVVä»£ç "},
        date: {
            default: "è¯·è¾“å…¥æœ‰æ•ˆçš„æ—¥æœŸ",
            min: "è¯·è¾“å…¥ %s æˆ–ä¹‹åŽçš„æ—¥æœŸ",
            max: "è¯·è¾“å…¥ %s æˆ–ä»¥å‰çš„æ—¥æœŸ",
            range: "è¯·è¾“å…¥ %s å’Œ %s ä¹‹é—´çš„æ—¥æœŸ"
        },
        different: {default: "è¯·è¾“å…¥ä¸åŒçš„å€¼"},
        digits: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„æ•°å­—"},
        ean: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„EANå•†å“ç¼–ç "},
        emailAddress: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„é‚®ä»¶åœ°å€"},
        file: {default: "è¯·é€‰æ‹©æœ‰æ•ˆçš„æ–‡ä»¶"},
        greaterThan: {default: "è¯·è¾“å…¥å¤§äºŽç­‰äºŽ %s çš„æ•°å€¼", notInclusive: "è¯·è¾“å…¥å¤§äºŽ %s çš„æ•°å€¼"},
        grid: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„GRIdç¼–ç "},
        hex: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„16è¿›åˆ¶æ•°"},
        hexColor: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„16è¿›åˆ¶é¢œè‰²å€¼"},
        iban: {
            default: "è¯·è¾“å…¥æœ‰æ•ˆçš„IBAN(å›½é™…é“¶è¡Œè´¦æˆ·)å·ç ",
            countryNotSupported: "ä¸æ”¯æŒ %s å›½å®¶æˆ–åœ°åŒº",
            country: "è¯·è¾“å…¥æœ‰æ•ˆçš„ %s å›½å®¶æˆ–åœ°åŒºçš„IBAN(å›½é™…é“¶è¡Œè´¦æˆ·)å·ç ",
            countries: {
                AD: "å®‰é“â€‹â€‹å°”",
                AE: "é˜¿è”é…‹",
                AL: "é˜¿å°”å·´å°¼äºš",
                AO: "å®‰å“¥æ‹‰",
                AT: "å¥¥åœ°åˆ©",
                AZ: "é˜¿å¡žæ‹œç–†",
                BA: "æ³¢æ–¯å°¼äºšå’Œé»‘å¡žå“¥ç»´é‚£",
                BE: "æ¯”åˆ©æ—¶",
                BF: "å¸ƒåŸºçº³æ³•ç´¢",
                BG: "ä¿åŠ åˆ©äºš",
                BH: "å·´æž—",
                BI: "å¸ƒéš†è¿ª",
                BJ: "è´å®",
                BR: "å·´è¥¿",
                CH: "ç‘žå£«",
                CI: "ç§‘ç‰¹è¿ªç“¦",
                CM: "å–€éº¦éš†",
                CR: "å“¥æ–¯è¾¾é»ŽåŠ ",
                CV: "ä½›å¾—è§’",
                CY: "å¡žæµ¦è·¯æ–¯",
                CZ: "æ·å…‹å…±å’Œå›½",
                DE: "å¾·å›½",
                DK: "ä¸¹éº¦",
                DO: "å¤šç±³å°¼åŠ å…±å’Œå›½",
                DZ: "é˜¿å°”åŠåˆ©äºš",
                EE: "çˆ±æ²™å°¼äºš",
                ES: "è¥¿ç­ç‰™",
                FI: "èŠ¬å…°",
                FO: "æ³•ç½—ç¾¤å²›",
                FR: "æ³•å›½",
                GB: "è‹±å›½",
                GE: "æ ¼é²å‰äºš",
                GI: "ç›´å¸ƒç½—é™€",
                GL: "æ ¼é™µå…°å²›",
                GR: "å¸Œè…Š",
                GT: "å±åœ°é©¬æ‹‰",
                HR: "å…‹ç½—åœ°äºš",
                HU: "åŒˆç‰™åˆ©",
                IE: "çˆ±å°”å…°",
                IL: "ä»¥è‰²åˆ—",
                IR: "ä¼Šæœ—",
                IS: "å†°å²›",
                IT: "æ„å¤§åˆ©",
                JO: "çº¦æ—¦",
                KW: "ç§‘å¨ç‰¹",
                KZ: "å“ˆè¨å…‹æ–¯å¦",
                LB: "é»Žå·´å«©",
                LI: "åˆ—æ”¯æ•¦å£«ç™»",
                LT: "ç«‹é™¶å®›",
                LU: "å¢æ£®å ¡",
                LV: "æ‹‰è„±ç»´äºš",
                MC: "æ‘©çº³å“¥",
                MD: "æ‘©å°”å¤šç“¦",
                ME: "é»‘å±±",
                MG: "é©¬è¾¾åŠ æ–¯åŠ ",
                MK: "é©¬å…¶é¡¿",
                ML: "é©¬é‡Œ",
                MR: "æ¯›é‡Œå¡”å°¼äºš",
                MT: "é©¬è€³ä»–",
                MU: "æ¯›é‡Œæ±‚æ–¯",
                MZ: "èŽ«æ¡‘æ¯”å…‹",
                NL: "è·å…°",
                NO: "æŒªå¨",
                PK: "å·´åŸºæ–¯å¦",
                PL: "æ³¢å…°",
                PS: "å·´å‹’æ–¯å¦",
                PT: "è‘¡è„ç‰™",
                QA: "å¡å¡”å°”",
                RO: "ç½—é©¬å°¼äºš",
                RS: "å¡žå°”ç»´äºš",
                SA: "æ²™ç‰¹é˜¿æ‹‰ä¼¯",
                SE: "ç‘žå…¸",
                SI: "æ–¯æ´›æ–‡å°¼äºš",
                SK: "æ–¯æ´›ä¼å…‹",
                SM: "åœ£é©¬åŠ›è¯º",
                SN: "å¡žå†…åŠ å°”",
                TN: "çªå°¼æ–¯",
                TR: "åœŸè€³å…¶",
                VG: "è‹±å±žç»´å°”äº¬ç¾¤å²›"
            }
        },
        id: {
            default: "è¯·è¾“å…¥æœ‰æ•ˆçš„èº«ä»½è¯ä»¶å·ç ",
            countryNotSupported: "ä¸æ”¯æŒ %s å›½å®¶æˆ–åœ°åŒº",
            country: "è¯·è¾“å…¥æœ‰æ•ˆçš„ %s å›½å®¶æˆ–åœ°åŒºçš„èº«ä»½è¯ä»¶å·ç ",
            countries: {
                BA: "æ³¢é»‘",
                BG: "ä¿åŠ åˆ©äºš",
                BR: "å·´è¥¿",
                CH: "ç‘žå£«",
                CL: "æ™ºåˆ©",
                CN: "ä¸­å›½",
                CZ: "æ·å…‹å…±å’Œå›½",
                DK: "ä¸¹éº¦",
                EE: "çˆ±æ²™å°¼äºš",
                ES: "è¥¿ç­ç‰™",
                FI: "èŠ¬å…°",
                HR: "å…‹ç½—åœ°äºš",
                IE: "çˆ±å°”å…°",
                IS: "å†°å²›",
                LT: "ç«‹é™¶å®›",
                LV: "æ‹‰è„±ç»´äºš",
                ME: "é»‘å±±",
                MK: "é©¬å…¶é¡¿",
                NL: "è·å…°",
                RO: "ç½—é©¬å°¼äºš",
                RS: "å¡žå°”ç»´äºš",
                SE: "ç‘žå…¸",
                SI: "æ–¯æ´›æ–‡å°¼äºš",
                SK: "æ–¯æ´›ä¼å…‹",
                SM: "åœ£é©¬åŠ›è¯º",
                TH: "æ³°å›½",
                ZA: "å—éž"
            }
        },
        identical: {default: "è¯·è¾“å…¥ç›¸åŒçš„å€¼"},
        imei: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„IMEI(æ‰‹æœºä¸²å·)"},
        imo: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„å›½é™…æµ·äº‹ç»„ç»‡(IMO)å·ç "},
        integer: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„æ•´æ•°å€¼"},
        ip: {
            default: "è¯·è¾“å…¥æœ‰æ•ˆçš„IPåœ°å€",
            ipv4: "è¯·è¾“å…¥æœ‰æ•ˆçš„IPv4åœ°å€",
            ipv6: "è¯·è¾“å…¥æœ‰æ•ˆçš„IPv6åœ°å€"
        },
        isbn: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„ISBN(å›½é™…æ ‡å‡†ä¹¦å·)"},
        isin: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„ISIN(å›½é™…è¯åˆ¸ç¼–ç )"},
        ismn: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„ISMN(å°åˆ·éŸ³ä¹ä½œå“ç¼–ç )"},
        issn: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„ISSN(å›½é™…æ ‡å‡†æ‚å¿—ä¹¦å·)"},
        lessThan: {default: "è¯·è¾“å…¥å°äºŽç­‰äºŽ %s çš„æ•°å€¼", notInclusive: "è¯·è¾“å…¥å°äºŽ %s çš„æ•°å€¼"},
        mac: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„MACç‰©ç†åœ°å€"},
        meid: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„MEID(ç§»åŠ¨è®¾å¤‡è¯†åˆ«ç )"},
        notEmpty: {default: "è¯·å¡«å†™å¿…å¡«é¡¹ç›®"},
        numeric: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„æ•°å€¼ï¼Œå…è®¸å°æ•°"},
        phone: {
            default: "è¯·è¾“å…¥æœ‰æ•ˆçš„ç”µè¯å·ç ",
            countryNotSupported: "ä¸æ”¯æŒ %s å›½å®¶æˆ–åœ°åŒº",
            country: "è¯·è¾“å…¥æœ‰æ•ˆçš„ %s å›½å®¶æˆ–åœ°åŒºçš„ç”µè¯å·ç ",
            countries: {
                BR: "å·´è¥¿",
                CN: "ä¸­å›½",
                CZ: "æ·å…‹å…±å’Œå›½",
                DE: "å¾·å›½",
                DK: "ä¸¹éº¦",
                ES: "è¥¿ç­ç‰™",
                FR: "æ³•å›½",
                GB: "è‹±å›½",
                MA: "æ‘©æ´›å“¥",
                PK: "å·´åŸºæ–¯å¦",
                RO: "ç½—é©¬å°¼äºš",
                RU: "ä¿„ç½—æ–¯",
                SK: "æ–¯æ´›ä¼å…‹",
                TH: "æ³°å›½",
                US: "ç¾Žå›½",
                VE: "å§”å†…ç‘žæ‹‰"
            }
        },
        regexp: {default: "è¯·è¾“å…¥ç¬¦åˆæ­£åˆ™è¡¨è¾¾å¼é™åˆ¶çš„å€¼"},
        remote: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„å€¼"},
        rtn: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„RTNå·ç "},
        sedol: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„SEDOLä»£ç "},
        siren: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„SIRENå·ç "},
        siret: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„SIRETå·ç "},
        step: {default: "è¯·è¾“å…¥åœ¨åŸºç¡€å€¼ä¸Šï¼Œå¢žåŠ  %s çš„æ•´æ•°å€çš„æ•°å€¼"},
        stringCase: {default: "åªèƒ½è¾“å…¥å°å†™å­—æ¯", upper: "åªèƒ½è¾“å…¥å¤§å†™å­—æ¯"},
        stringLength: {
            default: "è¯·è¾“å…¥ç¬¦åˆé•¿åº¦é™åˆ¶çš„å€¼",
            less: "æœ€å¤šåªèƒ½è¾“å…¥ %s ä¸ªå­—ç¬¦",
            more: "éœ€è¦è¾“å…¥è‡³å°‘ %s ä¸ªå­—ç¬¦",
            between: "è¯·è¾“å…¥ %s è‡³ %s ä¸ªå­—ç¬¦"
        },
        uri: {default: "è¯·è¾“å…¥ä¸€ä¸ªæœ‰æ•ˆçš„URLåœ°å€"},
        uuid: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„UUID", version: "è¯·è¾“å…¥ç‰ˆæœ¬ %s çš„UUID"},
        vat: {
            default: "è¯·è¾“å…¥æœ‰æ•ˆçš„VAT(ç¨Žå·)",
            countryNotSupported: "ä¸æ”¯æŒ %s å›½å®¶æˆ–åœ°åŒº",
            country: "è¯·è¾“å…¥æœ‰æ•ˆçš„ %s å›½å®¶æˆ–åœ°åŒºçš„VAT(ç¨Žå·)",
            countries: {
                AT: "å¥¥åœ°åˆ©",
                BE: "æ¯”åˆ©æ—¶",
                BG: "ä¿åŠ åˆ©äºš",
                BR: "å·´è¥¿",
                CH: "ç‘žå£«",
                CY: "å¡žæµ¦è·¯æ–¯",
                CZ: "æ·å…‹å…±å’Œå›½",
                DE: "å¾·å›½",
                DK: "ä¸¹éº¦",
                EE: "çˆ±æ²™å°¼äºš",
                ES: "è¥¿ç­ç‰™",
                FI: "èŠ¬å…°",
                FR: "æ³•è¯­",
                GB: "è‹±å›½",
                GR: "å¸Œè…Š",
                EL: "å¸Œè…Š",
                HU: "åŒˆç‰™åˆ©",
                HR: "å…‹ç½—åœ°äºš",
                IE: "çˆ±å°”å…°",
                IS: "å†°å²›",
                IT: "æ„å¤§åˆ©",
                LT: "ç«‹é™¶å®›",
                LU: "å¢æ£®å ¡",
                LV: "æ‹‰è„±ç»´äºš",
                MT: "é©¬è€³ä»–",
                NL: "è·å…°",
                NO: "æŒªå¨",
                PL: "æ³¢å…°",
                PT: "è‘¡è„ç‰™",
                RO: "ç½—é©¬å°¼äºš",
                RU: "ä¿„ç½—æ–¯",
                RS: "å¡žå°”ç»´äºš",
                SE: "ç‘žå…¸",
                SI: "æ–¯æ´›æ–‡å°¼äºš",
                SK: "æ–¯æ´›ä¼å…‹",
                VE: "å§”å†…ç‘žæ‹‰",
                ZA: "å—éž"
            }
        },
        vin: {default: "è¯·è¾“å…¥æœ‰æ•ˆçš„VIN(ç¾Žå›½è½¦è¾†è¯†åˆ«å·ç )"},
        zipCode: {
            default: "è¯·è¾“å…¥æœ‰æ•ˆçš„é‚®æ”¿ç¼–ç ",
            countryNotSupported: "ä¸æ”¯æŒ %s å›½å®¶æˆ–åœ°åŒº",
            country: "è¯·è¾“å…¥æœ‰æ•ˆçš„ %s å›½å®¶æˆ–åœ°åŒºçš„é‚®æ”¿ç¼–ç ",
            countries: {
                AT: "å¥¥åœ°åˆ©",
                BR: "å·´è¥¿",
                CA: "åŠ æ‹¿å¤§",
                CH: "ç‘žå£«",
                CZ: "æ·å…‹å…±å’Œå›½",
                DE: "å¾·å›½",
                DK: "ä¸¹éº¦",
                FR: "æ³•å›½",
                GB: "è‹±å›½",
                IE: "çˆ±å°”å…°",
                IT: "æ„å¤§åˆ©",
                MA: "æ‘©æ´›å“¥",
                NL: "è·å…°",
                PT: "è‘¡è„ç‰™",
                RO: "ç½—é©¬å°¼äºš",
                RU: "ä¿„ç½—æ–¯",
                SE: "ç‘žå…¸",
                SG: "æ–°åŠ å¡",
                SK: "æ–¯æ´›ä¼å…‹",
                US: "ç¾Žå›½"
            }
        }
    })
}(window.jQuery), function (t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : t("object" == typeof exports ? require("jquery") : jQuery)
}(function (t) {
    var e = function () {
        if (t && t.fn && t.fn.select2 && t.fn.select2.amd) var e = t.fn.select2.amd;
        var e;
        return function () {
            if (!e || !e.requirejs) {
                e ? i = e : e = {};
                var t, i, n;
                !function (e) {
                    function s(t, e) {
                        return w.call(t, e)
                    }

                    function r(t, e) {
                        var i, n, s, r, o, a, l, c, u, h, d, p = e && e.split("/"), f = b.map, g = f && f["*"] || {};
                        if (t && "." === t.charAt(0)) if (e) {
                            for (t = t.split("/"), o = t.length - 1, b.nodeIdCompat && _.test(t[o]) && (t[o] = t[o].replace(_, "")), t = p.slice(0, p.length - 1).concat(t), u = 0; u < t.length; u += 1) if ("." === (d = t[u])) t.splice(u, 1), u -= 1; else if (".." === d) {
                                if (1 === u && (".." === t[2] || ".." === t[0])) break;
                                u > 0 && (t.splice(u - 1, 2), u -= 2)
                            }
                            t = t.join("/")
                        } else 0 === t.indexOf("./") && (t = t.substring(2));
                        if ((p || g) && f) {
                            for (i = t.split("/"), u = i.length; u > 0; u -= 1) {
                                if (n = i.slice(0, u).join("/"), p) for (h = p.length; h > 0; h -= 1) if ((s = f[p.slice(0, h).join("/")]) && (s = s[n])) {
                                    r = s, a = u;
                                    break
                                }
                                if (r) break;
                                !l && g && g[n] && (l = g[n], c = u)
                            }
                            !r && l && (r = l, a = c), r && (i.splice(0, a, r), t = i.join("/"))
                        }
                        return t
                    }

                    function o(t, i) {
                        return function () {
                            var n = x.call(arguments, 0);
                            return "string" != typeof n[0] && 1 === n.length && n.push(null), p.apply(e, n.concat([t, i]))
                        }
                    }

                    function a(t) {
                        return function (e) {
                            return r(e, t)
                        }
                    }

                    function l(t) {
                        return function (e) {
                            m[t] = e
                        }
                    }

                    function c(t) {
                        if (s(v, t)) {
                            var i = v[t];
                            delete v[t], y[t] = !0, d.apply(e, i)
                        }
                        if (!s(m, t) && !s(y, t)) throw new Error("No " + t);
                        return m[t]
                    }

                    function u(t) {
                        var e, i = t ? t.indexOf("!") : -1;
                        return i > -1 && (e = t.substring(0, i), t = t.substring(i + 1, t.length)), [e, t]
                    }

                    function h(t) {
                        return function () {
                            return b && b.config && b.config[t] || {}
                        }
                    }

                    var d, p, f, g, m = {}, v = {}, b = {}, y = {}, w = Object.prototype.hasOwnProperty, x = [].slice,
                        _ = /\.js$/;
                    f = function (t, e) {
                        var i, n = u(t), s = n[0];
                        return t = n[1], s && (s = r(s, e), i = c(s)), s ? t = i && i.normalize ? i.normalize(t, a(e)) : r(t, e) : (t = r(t, e), n = u(t), s = n[0], t = n[1], s && (i = c(s))), {
                            f: s ? s + "!" + t : t,
                            n: t,
                            pr: s,
                            p: i
                        }
                    }, g = {
                        require: function (t) {
                            return o(t)
                        }, exports: function (t) {
                            var e = m[t];
                            return void 0 !== e ? e : m[t] = {}
                        }, module: function (t) {
                            return {id: t, uri: "", exports: m[t], config: h(t)}
                        }
                    }, d = function (t, i, n, r) {
                        var a, u, h, d, p, b, w = [], x = typeof n;
                        if (r = r || t, "undefined" === x || "function" === x) {
                            for (i = !i.length && n.length ? ["require", "exports", "module"] : i, p = 0; p < i.length; p += 1) if (d = f(i[p], r), "require" === (u = d.f)) w[p] = g.require(t); else if ("exports" === u) w[p] = g.exports(t), b = !0; else if ("module" === u) a = w[p] = g.module(t); else if (s(m, u) || s(v, u) || s(y, u)) w[p] = c(u); else {
                                if (!d.p) throw new Error(t + " missing " + u);
                                d.p.load(d.n, o(r, !0), l(u), {}), w[p] = m[u]
                            }
                            h = n ? n.apply(m[t], w) : void 0, t && (a && a.exports !== e && a.exports !== m[t] ? m[t] = a.exports : h === e && b || (m[t] = h))
                        } else t && (m[t] = n)
                    }, t = i = p = function (t, i, n, s, r) {
                        if ("string" == typeof t) return g[t] ? g[t](i) : c(f(t, i).f);
                        if (!t.splice) {
                            if (b = t, b.deps && p(b.deps, b.callback), !i) return;
                            i.splice ? (t = i, i = n, n = null) : t = e
                        }
                        return i = i || function () {
                        }, "function" == typeof n && (n = s, s = r), s ? d(e, t, i, n) : setTimeout(function () {
                            d(e, t, i, n)
                        }, 4), p
                    }, p.config = function (t) {
                        return p(t)
                    }, t._defined = m, n = function (t, e, i) {
                        if ("string" != typeof t) throw new Error("See almond README: incorrect module build, no module name");
                        e.splice || (i = e, e = []), s(m, t) || s(v, t) || (v[t] = [t, e, i])
                    }, n.amd = {jQuery: !0}
                }(), e.requirejs = t, e.require = i, e.define = n
            }
        }(), e.define("almond", function () {
        }), e.define("jquery", [], function () {
            var e = t || $;
            return null == e && console && console.error && console.error("Select2: An instance of jQuery or a jQuery-compatible library was not found. Make sure that you are including jQuery before Select2 on your web page."), e
        }), e.define("select2/utils", ["jquery"], function (t) {
            function e(t) {
                var e = t.prototype, i = [];
                for (var n in e) {
                    "function" == typeof e[n] && "constructor" !== n && i.push(n)
                }
                return i
            }

            var i = {};
            i.Extend = function (t, e) {
                function i() {
                    this.constructor = t
                }

                var n = {}.hasOwnProperty;
                for (var s in e) n.call(e, s) && (t[s] = e[s]);
                return i.prototype = e.prototype, t.prototype = new i, t.__super__ = e.prototype, t
            }, i.Decorate = function (t, i) {
                function n() {
                    var e = Array.prototype.unshift, n = i.prototype.constructor.length, s = t.prototype.constructor;
                    n > 0 && (e.call(arguments, t.prototype.constructor), s = i.prototype.constructor), s.apply(this, arguments)
                }

                function s() {
                    this.constructor = n
                }

                var r = e(i), o = e(t);
                i.displayName = t.displayName, n.prototype = new s;
                for (var a = 0; a < o.length; a++) {
                    var l = o[a];
                    n.prototype[l] = t.prototype[l]
                }
                for (var c = 0; c < r.length; c++) {
                    var u = r[c];
                    n.prototype[u] = function (t) {
                        var e = function () {
                        };
                        t in n.prototype && (e = n.prototype[t]);
                        var s = i.prototype[t];
                        return function () {
                            return Array.prototype.unshift.call(arguments, e), s.apply(this, arguments)
                        }
                    }(u)
                }
                return n
            };
            var n = function () {
                this.listeners = {}
            };
            return n.prototype.on = function (t, e) {
                this.listeners = this.listeners || {}, t in this.listeners ? this.listeners[t].push(e) : this.listeners[t] = [e]
            }, n.prototype.trigger = function (t) {
                var e = Array.prototype.slice, i = e.call(arguments, 1);
                this.listeners = this.listeners || {}, null == i && (i = []), 0 === i.length && i.push({}), i[0]._type = t, t in this.listeners && this.invoke(this.listeners[t], e.call(arguments, 1)), "*" in this.listeners && this.invoke(this.listeners["*"], arguments)
            }, n.prototype.invoke = function (t, e) {
                for (var i = 0, n = t.length; n > i; i++) t[i].apply(this, e)
            }, i.Observable = n, i.generateChars = function (t) {
                for (var e = "", i = 0; t > i; i++) {
                    e += Math.floor(36 * Math.random()).toString(36)
                }
                return e
            }, i.bind = function (t, e) {
                return function () {
                    t.apply(e, arguments)
                }
            }, i._convertData = function (t) {
                for (var e in t) {
                    var i = e.split("-"), n = t;
                    if (1 !== i.length) {
                        for (var s = 0; s < i.length; s++) {
                            var r = i[s];
                            r = r.substring(0, 1).toLowerCase() + r.substring(1), r in n || (n[r] = {}), s == i.length - 1 && (n[r] = t[e]), n = n[r]
                        }
                        delete t[e]
                    }
                }
                return t
            }, i.hasScroll = function (e, i) {
                var n = t(i), s = i.style.overflowX, r = i.style.overflowY;
                return (s !== r || "hidden" !== r && "visible" !== r) && ("scroll" === s || "scroll" === r || (n.innerHeight() < i.scrollHeight || n.innerWidth() < i.scrollWidth))
            }, i.escapeMarkup = function (t) {
                var e = {
                    "\\": "&#92;",
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#39;",
                    "/": "&#47;"
                };
                return "string" != typeof t ? t : String(t).replace(/[&<>"'\/\\]/g, function (t) {
                    return e[t]
                })
            }, i.appendMany = function (e, i) {
                if ("1.7" === t.fn.jquery.substr(0, 3)) {
                    var n = t();
                    t.map(i, function (t) {
                        n = n.add(t)
                    }), i = n
                }
                e.append(i)
            }, i
        }), e.define("select2/results", ["jquery", "./utils"], function (t, e) {
            function i(t, e, n) {
                this.$element = t, this.data = n, this.options = e, i.__super__.constructor.call(this)
            }

            return e.Extend(i, e.Observable), i.prototype.render = function () {
                var e = t('<ul class="select2-results__options" role="tree"></ul>');
                return this.options.get("multiple") && e.attr("aria-multiselectable", "true"), this.$results = e, e
            }, i.prototype.clear = function () {
                this.$results.empty()
            }, i.prototype.displayMessage = function (e) {
                var i = this.options.get("escapeMarkup");
                this.clear(), this.hideLoading();
                var n = t('<li role="treeitem" aria-live="assertive" class="select2-results__option"></li>'),
                    s = this.options.get("translations").get(e.message);
                n.append(i(s(e.args))), n[0].className += " select2-results__message", this.$results.append(n)
            }, i.prototype.hideMessages = function () {
                this.$results.find(".select2-results__message").remove()
            }, i.prototype.append = function (t) {
                this.hideLoading();
                var e = [];
                if (null == t.results || 0 === t.results.length) return void(0 === this.$results.children().length && this.trigger("results:message", {message: "noResults"}));
                t.results = this.sort(t.results);
                for (var i = 0; i < t.results.length; i++) {
                    var n = t.results[i], s = this.option(n);
                    e.push(s)
                }
                this.$results.append(e)
            }, i.prototype.position = function (t, e) {
                e.find(".select2-results").append(t)
            }, i.prototype.sort = function (t) {
                return this.options.get("sorter")(t)
            }, i.prototype.highlightFirstItem = function () {
                var t = this.$results.find(".select2-results__option[aria-selected]"),
                    e = t.filter("[aria-selected=true]");
                e.length > 0 ? e.first().trigger("mouseenter") : t.first().trigger("mouseenter"), this.ensureHighlightVisible()
            }, i.prototype.setClasses = function () {
                var e = this;
                this.data.current(function (i) {
                    var n = t.map(i, function (t) {
                        return t.id.toString()
                    });
                    e.$results.find(".select2-results__option[aria-selected]").each(function () {
                        var e = t(this), i = t.data(this, "data"), s = "" + i.id;
                        null != i.element && i.element.selected || null == i.element && t.inArray(s, n) > -1 ? e.attr("aria-selected", "true") : e.attr("aria-selected", "false")
                    })
                })
            }, i.prototype.showLoading = function (t) {
                this.hideLoading();
                var e = this.options.get("translations").get("searching"), i = {disabled: !0, loading: !0, text: e(t)},
                    n = this.option(i);
                n.className += " loading-results", this.$results.prepend(n)
            }, i.prototype.hideLoading = function () {
                this.$results.find(".loading-results").remove()
            }, i.prototype.option = function (e) {
                var i = document.createElement("li");
                i.className = "select2-results__option";
                var n = {role: "treeitem", "aria-selected": "false"};
                e.disabled && (delete n["aria-selected"], n["aria-disabled"] = "true"), null == e.id && delete n["aria-selected"], null != e._resultId && (i.id = e._resultId), e.title && (i.title = e.title), e.children && (n.role = "group", n["aria-label"] = e.text, delete n["aria-selected"]);
                for (var s in n) {
                    var r = n[s];
                    i.setAttribute(s, r)
                }
                if (e.children) {
                    var o = t(i), a = document.createElement("strong");
                    a.className = "select2-results__group", t(a), this.template(e, a);
                    for (var l = [], c = 0; c < e.children.length; c++) {
                        var u = e.children[c], h = this.option(u);
                        l.push(h)
                    }
                    var d = t("<ul></ul>", {class: "select2-results__options select2-results__options--nested"});
                    d.append(l), o.append(a), o.append(d)
                } else this.template(e, i);
                return t.data(i, "data", e), i
            }, i.prototype.bind = function (e, i) {
                var n = this, s = e.id + "-results";
                this.$results.attr("id", s), e.on("results:all", function (t) {
                    n.clear(), n.append(t.data), e.isOpen() && (n.setClasses(), n.highlightFirstItem())
                }), e.on("results:append", function (t) {
                    n.append(t.data), e.isOpen() && n.setClasses()
                }), e.on("query", function (t) {
                    n.hideMessages(), n.showLoading(t)
                }), e.on("select", function () {
                    e.isOpen() && (n.setClasses(), n.highlightFirstItem())
                }), e.on("unselect", function () {
                    e.isOpen() && (n.setClasses(), n.highlightFirstItem())
                }), e.on("open", function () {
                    n.$results.attr("aria-expanded", "true"), n.$results.attr("aria-hidden", "false"), n.setClasses(), n.ensureHighlightVisible()
                }), e.on("close", function () {
                    n.$results.attr("aria-expanded", "false"), n.$results.attr("aria-hidden", "true"), n.$results.removeAttr("aria-activedescendant")
                }), e.on("results:toggle", function () {
                    var t = n.getHighlightedResults();
                    0 !== t.length && t.trigger("mouseup")
                }), e.on("results:select", function () {
                    var t = n.getHighlightedResults();
                    if (0 !== t.length) {
                        var e = t.data("data");
                        "true" == t.attr("aria-selected") ? n.trigger("close", {}) : n.trigger("select", {data: e})
                    }
                }), e.on("results:previous", function () {
                    var t = n.getHighlightedResults(), e = n.$results.find("[aria-selected]"), i = e.index(t);
                    if (0 !== i) {
                        var s = i - 1;
                        0 === t.length && (s = 0);
                        var r = e.eq(s);
                        r.trigger("mouseenter");
                        var o = n.$results.offset().top, a = r.offset().top, l = n.$results.scrollTop() + (a - o);
                        0 === s ? n.$results.scrollTop(0) : 0 > a - o && n.$results.scrollTop(l)
                    }
                }), e.on("results:next", function () {
                    var t = n.getHighlightedResults(), e = n.$results.find("[aria-selected]"), i = e.index(t),
                        s = i + 1;
                    if (!(s >= e.length)) {
                        var r = e.eq(s);
                        r.trigger("mouseenter");
                        var o = n.$results.offset().top + n.$results.outerHeight(!1),
                            a = r.offset().top + r.outerHeight(!1), l = n.$results.scrollTop() + a - o;
                        0 === s ? n.$results.scrollTop(0) : a > o && n.$results.scrollTop(l)
                    }
                }), e.on("results:focus", function (t) {
                    t.element.addClass("select2-results__option--highlighted")
                }), e.on("results:message", function (t) {
                    n.displayMessage(t)
                }), t.fn.mousewheel && this.$results.on("mousewheel", function (t) {
                    var e = n.$results.scrollTop(), i = n.$results.get(0).scrollHeight - e + t.deltaY,
                        s = t.deltaY > 0 && e - t.deltaY <= 0, r = t.deltaY < 0 && i <= n.$results.height();
                    s ? (n.$results.scrollTop(0), t.preventDefault(), t.stopPropagation()) : r && (n.$results.scrollTop(n.$results.get(0).scrollHeight - n.$results.height()), t.preventDefault(), t.stopPropagation())
                }), this.$results.on("mouseup", ".select2-results__option[aria-selected]", function (e) {
                    var i = t(this), s = i.data("data");
                    return "true" === i.attr("aria-selected") ? void(n.options.get("multiple") ? n.trigger("unselect", {
                        originalEvent: e,
                        data: s
                    }) : n.trigger("close", {})) : void n.trigger("select", {originalEvent: e, data: s})
                }), this.$results.on("mouseenter", ".select2-results__option[aria-selected]", function (e) {
                    var i = t(this).data("data");
                    n.getHighlightedResults().removeClass("select2-results__option--highlighted"), n.trigger("results:focus", {
                        data: i,
                        element: t(this)
                    })
                })
            }, i.prototype.getHighlightedResults = function () {
                return this.$results.find(".select2-results__option--highlighted")
            }, i.prototype.destroy = function () {
                this.$results.remove()
            }, i.prototype.ensureHighlightVisible = function () {
                var t = this.getHighlightedResults();
                if (0 !== t.length) {
                    var e = this.$results.find("[aria-selected]"), i = e.index(t), n = this.$results.offset().top,
                        s = t.offset().top, r = this.$results.scrollTop() + (s - n), o = s - n;
                    r -= 2 * t.outerHeight(!1), 2 >= i ? this.$results.scrollTop(0) : (o > this.$results.outerHeight() || 0 > o) && this.$results.scrollTop(r)
                }
            }, i.prototype.template = function (e, i) {
                var n = this.options.get("templateResult"), s = this.options.get("escapeMarkup"), r = n(e, i);
                null == r ? i.style.display = "none" : "string" == typeof r ? i.innerHTML = s(r) : t(i).append(r)
            }, i
        }), e.define("select2/keys", [], function () {
            return {
                BACKSPACE: 8,
                TAB: 9,
                ENTER: 13,
                SHIFT: 16,
                CTRL: 17,
                ALT: 18,
                ESC: 27,
                SPACE: 32,
                PAGE_UP: 33,
                PAGE_DOWN: 34,
                END: 35,
                HOME: 36,
                LEFT: 37,
                UP: 38,
                RIGHT: 39,
                DOWN: 40,
                DELETE: 46
            }
        }), e.define("select2/selection/base", ["jquery", "../utils", "../keys"], function (t, e, i) {
            function n(t, e) {
                this.$element = t, this.options = e, n.__super__.constructor.call(this)
            }

            return e.Extend(n, e.Observable), n.prototype.render = function () {
                var e = t('<span class="select2-selection" role="combobox"  aria-haspopup="true" aria-expanded="false"></span>');
                return this._tabindex = 0, null != this.$element.data("old-tabindex") ? this._tabindex = this.$element.data("old-tabindex") : null != this.$element.attr("tabindex") && (this._tabindex = this.$element.attr("tabindex")), e.attr("title", this.$element.attr("title")), e.attr("tabindex", this._tabindex), this.$selection = e, e
            }, n.prototype.bind = function (t, e) {
                var n = this, s = (t.id, t.id + "-results");
                this.container = t, this.$selection.on("focus", function (t) {
                    n.trigger("focus", t)
                }), this.$selection.on("blur", function (t) {
                    n._handleBlur(t)
                }), this.$selection.on("keydown", function (t) {
                    n.trigger("keypress", t), t.which === i.SPACE && t.preventDefault()
                }), t.on("results:focus", function (t) {
                    n.$selection.attr("aria-activedescendant", t.data._resultId)
                }), t.on("selection:update", function (t) {
                    n.update(t.data)
                }), t.on("open", function () {
                    n.$selection.attr("aria-expanded", "true"), n.$selection.attr("aria-owns", s), n._attachCloseHandler(t)
                }), t.on("close", function () {
                    n.$selection.attr("aria-expanded", "false"), n.$selection.removeAttr("aria-activedescendant"), n.$selection.removeAttr("aria-owns"), n.$selection.focus(), n._detachCloseHandler(t)
                }), t.on("enable", function () {
                    n.$selection.attr("tabindex", n._tabindex)
                }), t.on("disable", function () {
                    n.$selection.attr("tabindex", "-1")
                })
            }, n.prototype._handleBlur = function (e) {
                var i = this;
                window.setTimeout(function () {
                    document.activeElement == i.$selection[0] || t.contains(i.$selection[0], document.activeElement) || i.trigger("blur", e)
                }, 1)
            }, n.prototype._attachCloseHandler = function (e) {
                t(document.body).on("mousedown.select2." + e.id, function (e) {
                    var i = t(e.target), n = i.closest(".select2");
                    t(".select2.select2-container--open").each(function () {
                        var e = t(this);
                        this != n[0] && e.data("element").select2("close")
                    })
                })
            }, n.prototype._detachCloseHandler = function (e) {
                t(document.body).off("mousedown.select2." + e.id)
            }, n.prototype.position = function (t, e) {
                e.find(".selection").append(t)
            }, n.prototype.destroy = function () {
                this._detachCloseHandler(this.container)
            }, n.prototype.update = function (t) {
                throw new Error("The `update` method must be defined in child classes.")
            }, n
        }), e.define("select2/selection/single", ["jquery", "./base", "../utils", "../keys"], function (t, e, i, n) {
            function s() {
                s.__super__.constructor.apply(this, arguments)
            }

            return i.Extend(s, e), s.prototype.render = function () {
                var t = s.__super__.render.call(this);
                return t.addClass("select2-selection--single"), t.html('<span class="select2-selection__rendered"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>'), t
            }, s.prototype.bind = function (t, e) {
                var i = this;
                s.__super__.bind.apply(this, arguments);
                var n = t.id + "-container";
                this.$selection.find(".select2-selection__rendered").attr("id", n), this.$selection.attr("aria-labelledby", n), this.$selection.on("mousedown", function (t) {
                    1 === t.which && i.trigger("toggle", {originalEvent: t})
                }), this.$selection.on("focus", function (t) {
                }), this.$selection.on("blur", function (t) {
                }), t.on("focus", function (e) {
                    t.isOpen() || i.$selection.focus()
                }), t.on("selection:update", function (t) {
                    i.update(t.data)
                })
            }, s.prototype.clear = function () {
                this.$selection.find(".select2-selection__rendered").empty()
            }, s.prototype.display = function (t, e) {
                var i = this.options.get("templateSelection");
                return this.options.get("escapeMarkup")(i(t, e))
            }, s.prototype.selectionContainer = function () {
                return t("<span></span>")
            }, s.prototype.update = function (t) {
                if (0 === t.length) return void this.clear();
                var e = t[0], i = this.$selection.find(".select2-selection__rendered"), n = this.display(e, i);
                i.empty().append(n), i.prop("title", e.title || e.text)
            }, s
        }), e.define("select2/selection/multiple", ["jquery", "./base", "../utils"], function (t, e, i) {
            function n(t, e) {
                n.__super__.constructor.apply(this, arguments)
            }

            return i.Extend(n, e), n.prototype.render = function () {
                var t = n.__super__.render.call(this);
                return t.addClass("select2-selection--multiple"), t.html('<ul class="select2-selection__rendered"></ul>'), t
            }, n.prototype.bind = function (e, i) {
                var s = this;
                n.__super__.bind.apply(this, arguments), this.$selection.on("click", function (t) {
                    s.trigger("toggle", {originalEvent: t})
                }), this.$selection.on("click", ".select2-selection__choice__remove", function (e) {
                    if (!s.options.get("disabled")) {
                        var i = t(this), n = i.parent(), r = n.data("data");
                        s.trigger("unselect", {originalEvent: e, data: r})
                    }
                })
            }, n.prototype.clear = function () {
                this.$selection.find(".select2-selection__rendered").empty()
            }, n.prototype.display = function (t, e) {
                var i = this.options.get("templateSelection");
                return this.options.get("escapeMarkup")(i(t, e))
            }, n.prototype.selectionContainer = function () {
                return t('<li class="select2-selection__choice"><span class="select2-selection__choice__remove" role="presentation">&times;</span></li>')
            }, n.prototype.update = function (t) {
                if (this.clear(), 0 !== t.length) {
                    for (var e = [], n = 0; n < t.length; n++) {
                        var s = t[n], r = this.selectionContainer(), o = this.display(s, r);
                        r.append(o), r.prop("title", s.title || s.text), r.data("data", s), e.push(r)
                    }
                    var a = this.$selection.find(".select2-selection__rendered");
                    i.appendMany(a, e)
                }
            }, n
        }), e.define("select2/selection/placeholder", ["../utils"], function (t) {
            function e(t, e, i) {
                this.placeholder = this.normalizePlaceholder(i.get("placeholder")), t.call(this, e, i)
            }

            return e.prototype.normalizePlaceholder = function (t, e) {
                return "string" == typeof e && (e = {id: "", text: e}), e
            }, e.prototype.createPlaceholder = function (t, e) {
                var i = this.selectionContainer();
                return i.html(this.display(e)), i.addClass("select2-selection__placeholder").removeClass("select2-selection__choice"), i
            }, e.prototype.update = function (t, e) {
                var i = 1 == e.length && e[0].id != this.placeholder.id;
                if (e.length > 1 || i) return t.call(this, e);
                this.clear();
                var n = this.createPlaceholder(this.placeholder);
                this.$selection.find(".select2-selection__rendered").append(n)
            }, e
        }), e.define("select2/selection/allowClear", ["jquery", "../keys"], function (t, e) {
            function i() {
            }

            return i.prototype.bind = function (t, e, i) {
                var n = this;
                t.call(this, e, i), null == this.placeholder && this.options.get("debug") && window.console && console.error && console.error("Select2: The `allowClear` option should be used in combination with the `placeholder` option."), this.$selection.on("mousedown", ".select2-selection__clear", function (t) {
                    n._handleClear(t)
                }), e.on("keypress", function (t) {
                    n._handleKeyboardClear(t, e)
                })
            }, i.prototype._handleClear = function (t, e) {
                if (!this.options.get("disabled")) {
                    var i = this.$selection.find(".select2-selection__clear");
                    if (0 !== i.length) {
                        e.stopPropagation();
                        for (var n = i.data("data"), s = 0; s < n.length; s++) {
                            var r = {data: n[s]};
                            if (this.trigger("unselect", r), r.prevented) return
                        }
                        this.$element.val(this.placeholder.id).trigger("change"), this.trigger("toggle", {})
                    }
                }
            }, i.prototype._handleKeyboardClear = function (t, i, n) {
                n.isOpen() || (i.which == e.DELETE || i.which == e.BACKSPACE) && this._handleClear(i)
            }, i.prototype.update = function (e, i) {
                if (e.call(this, i), !(this.$selection.find(".select2-selection__placeholder").length > 0 || 0 === i.length)) {
                    var n = t('<span class="select2-selection__clear">&times;</span>');
                    n.data("data", i), this.$selection.find(".select2-selection__rendered").prepend(n)
                }
            }, i
        }), e.define("select2/selection/search", ["jquery", "../utils", "../keys"], function (t, e, i) {
            function n(t, e, i) {
                t.call(this, e, i)
            }

            return n.prototype.render = function (e) {
                var i = t('<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" /></li>');
                this.$searchContainer = i, this.$search = i.find("input");
                var n = e.call(this);
                return this._transferTabIndex(), n
            }, n.prototype.bind = function (t, e, n) {
                var s = this;
                t.call(this, e, n), e.on("open", function () {
                    s.$search.trigger("focus")
                }), e.on("close", function () {
                    s.$search.val(""), s.$search.removeAttr("aria-activedescendant"), s.$search.trigger("focus")
                }), e.on("enable", function () {
                    s.$search.prop("disabled", !1), s._transferTabIndex()
                }), e.on("disable", function () {
                    s.$search.prop("disabled", !0)
                }), e.on("focus", function (t) {
                    s.$search.trigger("focus")
                }), e.on("results:focus", function (t) {
                    s.$search.attr("aria-activedescendant", t.id)
                }), this.$selection.on("focusin", ".select2-search--inline", function (t) {
                    s.trigger("focus", t)
                }), this.$selection.on("focusout", ".select2-search--inline", function (t) {
                    s._handleBlur(t)
                }), this.$selection.on("keydown", ".select2-search--inline", function (t) {
                    if (t.stopPropagation(), s.trigger("keypress", t), s._keyUpPrevented = t.isDefaultPrevented(), t.which === i.BACKSPACE && "" === s.$search.val()) {
                        var e = s.$searchContainer.prev(".select2-selection__choice");
                        if (e.length > 0) {
                            var n = e.data("data");
                            s.searchRemoveChoice(n), t.preventDefault()
                        }
                    }
                });
                var r = document.documentMode, o = r && 11 >= r;
                this.$selection.on("input.searchcheck", ".select2-search--inline", function (t) {
                    return o ? void s.$selection.off("input.search input.searchcheck") : void s.$selection.off("keyup.search")
                }), this.$selection.on("keyup.search input.search", ".select2-search--inline", function (t) {
                    if (o && "input" === t.type) return void s.$selection.off("input.search input.searchcheck");
                    var e = t.which;
                    e != i.SHIFT && e != i.CTRL && e != i.ALT && e != i.TAB && s.handleSearch(t)
                })
            }, n.prototype._transferTabIndex = function (t) {
                this.$search.attr("tabindex", this.$selection.attr("tabindex")), this.$selection.attr("tabindex", "-1")
            }, n.prototype.createPlaceholder = function (t, e) {
                this.$search.attr("placeholder", e.text)
            }, n.prototype.update = function (t, e) {
                var i = this.$search[0] == document.activeElement;
                this.$search.attr("placeholder", ""), t.call(this, e), this.$selection.find(".select2-selection__rendered").append(this.$searchContainer), this.resizeSearch(), i && this.$search.focus()
            }, n.prototype.handleSearch = function () {
                if (this.resizeSearch(), !this._keyUpPrevented) {
                    var t = this.$search.val();
                    this.trigger("query", {term: t})
                }
                this._keyUpPrevented = !1
            }, n.prototype.searchRemoveChoice = function (t, e) {
                this.trigger("unselect", {data: e}), this.$search.val(e.text), this.handleSearch()
            }, n.prototype.resizeSearch = function () {
                this.$search.css("width", "25px");
                var t = "";
                if ("" !== this.$search.attr("placeholder")) t = this.$selection.find(".select2-selection__rendered").innerWidth(); else {
                    t = .75 * (this.$search.val().length + 1) + "em"
                }
                this.$search.css("width", t)
            }, n
        }), e.define("select2/selection/eventRelay", ["jquery"], function (t) {
            function e() {
            }

            return e.prototype.bind = function (e, i, n) {
                var s = this,
                    r = ["open", "opening", "close", "closing", "select", "selecting", "unselect", "unselecting"],
                    o = ["opening", "closing", "selecting", "unselecting"];
                e.call(this, i, n), i.on("*", function (e, i) {
                    if (-1 !== t.inArray(e, r)) {
                        i = i || {};
                        var n = t.Event("select2:" + e, {params: i});
                        s.$element.trigger(n), -1 !== t.inArray(e, o) && (i.prevented = n.isDefaultPrevented())
                    }
                })
            }, e
        }), e.define("select2/translation", ["jquery", "require"], function (t, e) {
            function i(t) {
                this.dict = t || {}
            }

            return i.prototype.all = function () {
                return this.dict
            }, i.prototype.get = function (t) {
                return this.dict[t]
            }, i.prototype.extend = function (e) {
                this.dict = t.extend({}, e.all(), this.dict)
            }, i._cache = {}, i.loadPath = function (t) {
                if (!(t in i._cache)) {
                    var n = e(t);
                    i._cache[t] = n
                }
                return new i(i._cache[t])
            }, i
        }), e.define("select2/diacritics", [], function () {
            return {
                "â’¶": "A",
                "ï¼¡": "A",
                "Ã€": "A",
                "Ã": "A",
                "Ã‚": "A",
                "áº¦": "A",
                "áº¤": "A",
                "áºª": "A",
                "áº¨": "A",
                "Ãƒ": "A",
                "Ä€": "A",
                "Ä‚": "A",
                "áº°": "A",
                "áº®": "A",
                "áº´": "A",
                "áº²": "A",
                "È¦": "A",
                "Ç ": "A",
                "Ã„": "A",
                "Çž": "A",
                "áº¢": "A",
                "Ã…": "A",
                "Çº": "A",
                "Ç": "A",
                "È€": "A",
                "È‚": "A",
                "áº ": "A",
                "áº¬": "A",
                "áº¶": "A",
                "á¸€": "A",
                "Ä„": "A",
                "Èº": "A",
                "â±¯": "A",
                "êœ²": "AA",
                "Ã†": "AE",
                "Ç¼": "AE",
                "Ç¢": "AE",
                "êœ´": "AO",
                "êœ¶": "AU",
                "êœ¸": "AV",
                "êœº": "AV",
                "êœ¼": "AY",
                "â’·": "B",
                "ï¼¢": "B",
                "á¸‚": "B",
                "á¸„": "B",
                "á¸†": "B",
                "Éƒ": "B",
                "Æ‚": "B",
                "Æ": "B",
                "â’¸": "C",
                "ï¼£": "C",
                "Ä†": "C",
                "Äˆ": "C",
                "ÄŠ": "C",
                "ÄŒ": "C",
                "Ã‡": "C",
                "á¸ˆ": "C",
                "Æ‡": "C",
                "È»": "C",
                "êœ¾": "C",
                "â’¹": "D",
                "ï¼¤": "D",
                "á¸Š": "D",
                "ÄŽ": "D",
                "á¸Œ": "D",
                "á¸": "D",
                "á¸’": "D",
                "á¸Ž": "D",
                "Ä": "D",
                "Æ‹": "D",
                "ÆŠ": "D",
                "Æ‰": "D",
                "ê¹": "D",
                "Ç±": "DZ",
                "Ç„": "DZ",
                "Ç²": "Dz",
                "Ç…": "Dz",
                "â’º": "E",
                "ï¼¥": "E",
                "Ãˆ": "E",
                "Ã‰": "E",
                "ÃŠ": "E",
                "á»€": "E",
                "áº¾": "E",
                "á»„": "E",
                "á»‚": "E",
                "áº¼": "E",
                "Ä’": "E",
                "á¸”": "E",
                "á¸–": "E",
                "Ä”": "E",
                "Ä–": "E",
                "Ã‹": "E",
                "áºº": "E",
                "Äš": "E",
                "È„": "E",
                "È†": "E",
                "áº¸": "E",
                "á»†": "E",
                "È¨": "E",
                "á¸œ": "E",
                "Ä˜": "E",
                "á¸˜": "E",
                "á¸š": "E",
                "Æ": "E",
                "ÆŽ": "E",
                "â’»": "F",
                "ï¼¦": "F",
                "á¸ž": "F",
                "Æ‘": "F",
                "ê»": "F",
                "â’¼": "G",
                "ï¼§": "G",
                "Ç´": "G",
                "Äœ": "G",
                "á¸ ": "G",
                "Äž": "G",
                "Ä ": "G",
                "Ç¦": "G",
                "Ä¢": "G",
                "Ç¤": "G",
                "Æ“": "G",
                "êž ": "G",
                "ê½": "G",
                "ê¾": "G",
                "â’½": "H",
                "ï¼¨": "H",
                "Ä¤": "H",
                "á¸¢": "H",
                "á¸¦": "H",
                "Èž": "H",
                "á¸¤": "H",
                "á¸¨": "H",
                "á¸ª": "H",
                "Ä¦": "H",
                "â±§": "H",
                "â±µ": "H",
                "êž": "H",
                "â’¾": "I",
                "ï¼©": "I",
                "ÃŒ": "I",
                "Ã": "I",
                "ÃŽ": "I",
                "Ä¨": "I",
                "Äª": "I",
                "Ä¬": "I",
                "Ä°": "I",
                "Ã": "I",
                "á¸®": "I",
                "á»ˆ": "I",
                "Ç": "I",
                "Èˆ": "I",
                "ÈŠ": "I",
                "á»Š": "I",
                "Ä®": "I",
                "á¸¬": "I",
                "Æ—": "I",
                "â’¿": "J",
                "ï¼ª": "J",
                "Ä´": "J",
                "Éˆ": "J",
                "â“€": "K",
                "ï¼«": "K",
                "á¸°": "K",
                "Ç¨": "K",
                "á¸²": "K",
                "Ä¶": "K",
                "á¸´": "K",
                "Æ˜": "K",
                "â±©": "K",
                "ê€": "K",
                "ê‚": "K",
                "ê„": "K",
                "êž¢": "K",
                "â“": "L",
                "ï¼¬": "L",
                "Ä¿": "L",
                "Ä¹": "L",
                "Ä½": "L",
                "á¸¶": "L",
                "á¸¸": "L",
                "Ä»": "L",
                "á¸¼": "L",
                "á¸º": "L",
                "Å": "L",
                "È½": "L",
                "â±¢": "L",
                "â± ": "L",
                "êˆ": "L",
                "ê†": "L",
                "êž€": "L",
                "Ç‡": "LJ",
                "Çˆ": "Lj",
                "â“‚": "M",
                "ï¼­": "M",
                "á¸¾": "M",
                "á¹€": "M",
                "á¹‚": "M",
                "â±®": "M",
                "Æœ": "M",
                "â“ƒ": "N",
                "ï¼®": "N",
                "Ç¸": "N",
                "Åƒ": "N",
                "Ã‘": "N",
                "á¹„": "N",
                "Å‡": "N",
                "á¹†": "N",
                "Å…": "N",
                "á¹Š": "N",
                "á¹ˆ": "N",
                "È ": "N",
                "Æ": "N",
                "êž": "N",
                "êž¤": "N",
                "ÇŠ": "NJ",
                "Ç‹": "Nj",
                "â“„": "O",
                "ï¼¯": "O",
                "Ã’": "O",
                "Ã“": "O",
                "Ã”": "O",
                "á»’": "O",
                "á»": "O",
                "á»–": "O",
                "á»”": "O",
                "Ã•": "O",
                "á¹Œ": "O",
                "È¬": "O",
                "á¹Ž": "O",
                "ÅŒ": "O",
                "á¹": "O",
                "á¹’": "O",
                "ÅŽ": "O",
                "È®": "O",
                "È°": "O",
                "Ã–": "O",
                "Èª": "O",
                "á»Ž": "O",
                "Å": "O",
                "Ç‘": "O",
                "ÈŒ": "O",
                "ÈŽ": "O",
                "Æ ": "O",
                "á»œ": "O",
                "á»š": "O",
                "á» ": "O",
                "á»ž": "O",
                "á»¢": "O",
                "á»Œ": "O",
                "á»˜": "O",
                "Çª": "O",
                "Ç¬": "O",
                "Ã˜": "O",
                "Ç¾": "O",
                "Æ†": "O",
                "ÆŸ": "O",
                "êŠ": "O",
                "êŒ": "O",
                "Æ¢": "OI",
                "êŽ": "OO",
                "È¢": "OU",
                "â“…": "P",
                "ï¼°": "P",
                "á¹”": "P",
                "á¹–": "P",
                "Æ¤": "P",
                "â±£": "P",
                "ê": "P",
                "ê’": "P",
                "ê”": "P",
                "â“†": "Q",
                "ï¼±": "Q",
                "ê–": "Q",
                "ê˜": "Q",
                "ÉŠ": "Q",
                "â“‡": "R",
                "ï¼²": "R",
                "Å”": "R",
                "á¹˜": "R",
                "Å˜": "R",
                "È": "R",
                "È’": "R",
                "á¹š": "R",
                "á¹œ": "R",
                "Å–": "R",
                "á¹ž": "R",
                "ÉŒ": "R",
                "â±¤": "R",
                "êš": "R",
                "êž¦": "R",
                "êž‚": "R",
                "â“ˆ": "S",
                "ï¼³": "S",
                "áºž": "S",
                "Åš": "S",
                "á¹¤": "S",
                "Åœ": "S",
                "á¹ ": "S",
                "Å ": "S",
                "á¹¦": "S",
                "á¹¢": "S",
                "á¹¨": "S",
                "È˜": "S",
                "Åž": "S",
                "â±¾": "S",
                "êž¨": "S",
                "êž„": "S",
                "â“‰": "T",
                "ï¼´": "T",
                "á¹ª": "T",
                "Å¤": "T",
                "á¹¬": "T",
                "Èš": "T",
                "Å¢": "T",
                "á¹°": "T",
                "á¹®": "T",
                "Å¦": "T",
                "Æ¬": "T",
                "Æ®": "T",
                "È¾": "T",
                "êž†": "T",
                "êœ¨": "TZ",
                "â“Š": "U",
                "ï¼µ": "U",
                "Ã™": "U",
                "Ãš": "U",
                "Ã›": "U",
                "Å¨": "U",
                "á¹¸": "U",
                "Åª": "U",
                "á¹º": "U",
                "Å¬": "U",
                "Ãœ": "U",
                "Ç›": "U",
                "Ç—": "U",
                "Ç•": "U",
                "Ç™": "U",
                "á»¦": "U",
                "Å®": "U",
                "Å°": "U",
                "Ç“": "U",
                "È”": "U",
                "È–": "U",
                "Æ¯": "U",
                "á»ª": "U",
                "á»¨": "U",
                "á»®": "U",
                "á»¬": "U",
                "á»°": "U",
                "á»¤": "U",
                "á¹²": "U",
                "Å²": "U",
                "á¹¶": "U",
                "á¹´": "U",
                "É„": "U",
                "â“‹": "V",
                "ï¼¶": "V",
                "á¹¼": "V",
                "á¹¾": "V",
                "Æ²": "V",
                "êž": "V",
                "É…": "V",
                "ê ": "VY",
                "â“Œ": "W",
                "ï¼·": "W",
                "áº€": "W",
                "áº‚": "W",
                "Å´": "W",
                "áº†": "W",
                "áº„": "W",
                "áºˆ": "W",
                "â±²": "W",
                "â“": "X",
                "ï¼¸": "X",
                "áºŠ": "X",
                "áºŒ": "X",
                "â“Ž": "Y",
                "ï¼¹": "Y",
                "á»²": "Y",
                "Ã": "Y",
                "Å¶": "Y",
                "á»¸": "Y",
                "È²": "Y",
                "áºŽ": "Y",
                "Å¸": "Y",
                "á»¶": "Y",
                "á»´": "Y",
                "Æ³": "Y",
                "ÉŽ": "Y",
                "á»¾": "Y",
                "â“": "Z",
                "ï¼º": "Z",
                "Å¹": "Z",
                "áº": "Z",
                "Å»": "Z",
                "Å½": "Z",
                "áº’": "Z",
                "áº”": "Z",
                "Æµ": "Z",
                "È¤": "Z",
                "â±¿": "Z",
                "â±«": "Z",
                "ê¢": "Z",
                "â“": "a",
                "ï½": "a",
                "áºš": "a",
                "Ã ": "a",
                "Ã¡": "a",
                "Ã¢": "a",
                "áº§": "a",
                "áº¥": "a",
                "áº«": "a",
                "áº©": "a",
                "Ã£": "a",
                "Ä": "a",
                "Äƒ": "a",
                "áº±": "a",
                "áº¯": "a",
                "áºµ": "a",
                "áº³": "a",
                "È§": "a",
                "Ç¡": "a",
                "Ã¤": "a",
                "ÇŸ": "a",
                "áº£": "a",
                "Ã¥": "a",
                "Ç»": "a",
                "ÇŽ": "a",
                "È": "a",
                "Èƒ": "a",
                "áº¡": "a",
                "áº­": "a",
                "áº·": "a",
                "á¸": "a",
                "Ä…": "a",
                "â±¥": "a",
                "É": "a",
                "êœ³": "aa",
                "Ã¦": "ae",
                "Ç½": "ae",
                "Ç£": "ae",
                "êœµ": "ao",
                "êœ·": "au",
                "êœ¹": "av",
                "êœ»": "av",
                "êœ½": "ay",
                "â“‘": "b",
                "ï½‚": "b",
                "á¸ƒ": "b",
                "á¸…": "b",
                "á¸‡": "b",
                "Æ€": "b",
                "Æƒ": "b",
                "É“": "b",
                "â“’": "c",
                "ï½ƒ": "c",
                "Ä‡": "c",
                "Ä‰": "c",
                "Ä‹": "c",
                "Ä": "c",
                "Ã§": "c",
                "á¸‰": "c",
                "Æˆ": "c",
                "È¼": "c",
                "êœ¿": "c",
                "â†„": "c",
                "â““": "d",
                "ï½„": "d",
                "á¸‹": "d",
                "Ä": "d",
                "á¸": "d",
                "á¸‘": "d",
                "á¸“": "d",
                "á¸": "d",
                "Ä‘": "d",
                "ÆŒ": "d",
                "É–": "d",
                "É—": "d",
                "êº": "d",
                "Ç³": "dz",
                "Ç†": "dz",
                "â“”": "e",
                "ï½…": "e",
                "Ã¨": "e",
                "Ã©": "e",
                "Ãª": "e",
                "á»": "e",
                "áº¿": "e",
                "á»…": "e",
                "á»ƒ": "e",
                "áº½": "e",
                "Ä“": "e",
                "á¸•": "e",
                "á¸—": "e",
                "Ä•": "e",
                "Ä—": "e",
                "Ã«": "e",
                "áº»": "e",
                "Ä›": "e",
                "È…": "e",
                "È‡": "e",
                "áº¹": "e",
                "á»‡": "e",
                "È©": "e",
                "á¸": "e",
                "Ä™": "e",
                "á¸™": "e",
                "á¸›": "e",
                "É‡": "e",
                "É›": "e",
                "Ç": "e",
                "â“•": "f",
                "ï½†": "f",
                "á¸Ÿ": "f",
                "Æ’": "f",
                "ê¼": "f",
                "â“–": "g",
                "ï½‡": "g",
                "Çµ": "g",
                "Ä": "g",
                "á¸¡": "g",
                "ÄŸ": "g",
                "Ä¡": "g",
                "Ç§": "g",
                "Ä£": "g",
                "Ç¥": "g",
                "É ": "g",
                "êž¡": "g",
                "áµ¹": "g",
                "ê¿": "g",
                "â“—": "h",
                "ï½ˆ": "h",
                "Ä¥": "h",
                "á¸£": "h",
                "á¸§": "h",
                "ÈŸ": "h",
                "á¸¥": "h",
                "á¸©": "h",
                "á¸«": "h",
                "áº–": "h",
                "Ä§": "h",
                "â±¨": "h",
                "â±¶": "h",
                "É¥": "h",
                "Æ•": "hv",
                "â“˜": "i",
                "ï½‰": "i",
                "Ã¬": "i",
                "Ã­": "i",
                "Ã®": "i",
                "Ä©": "i",
                "Ä«": "i",
                "Ä­": "i",
                "Ã¯": "i",
                "á¸¯": "i",
                "á»‰": "i",
                "Ç": "i",
                "È‰": "i",
                "È‹": "i",
                "á»‹": "i",
                "Ä¯": "i",
                "á¸­": "i",
                "É¨": "i",
                "Ä±": "i",
                "â“™": "j",
                "ï½Š": "j",
                "Äµ": "j",
                "Ç°": "j",
                "É‰": "j",
                "â“š": "k",
                "ï½‹": "k",
                "á¸±": "k",
                "Ç©": "k",
                "á¸³": "k",
                "Ä·": "k",
                "á¸µ": "k",
                "Æ™": "k",
                "â±ª": "k",
                "ê": "k",
                "êƒ": "k",
                "ê…": "k",
                "êž£": "k",
                "â“›": "l",
                "ï½Œ": "l",
                "Å€": "l",
                "Äº": "l",
                "Ä¾": "l",
                "á¸·": "l",
                "á¸¹": "l",
                "Ä¼": "l",
                "á¸½": "l",
                "á¸»": "l",
                "Å¿": "l",
                "Å‚": "l",
                "Æš": "l",
                "É«": "l",
                "â±¡": "l",
                "ê‰": "l",
                "êž": "l",
                "ê‡": "l",
                "Ç‰": "lj",
                "â“œ": "m",
                "ï½": "m",
                "á¸¿": "m",
                "á¹": "m",
                "á¹ƒ": "m",
                "É±": "m",
                "É¯": "m",
                "â“": "n",
                "ï½Ž": "n",
                "Ç¹": "n",
                "Å„": "n",
                "Ã±": "n",
                "á¹…": "n",
                "Åˆ": "n",
                "á¹‡": "n",
                "Å†": "n",
                "á¹‹": "n",
                "á¹‰": "n",
                "Æž": "n",
                "É²": "n",
                "Å‰": "n",
                "êž‘": "n",
                "êž¥": "n",
                "ÇŒ": "nj",
                "â“ž": "o",
                "ï½": "o",
                "Ã²": "o",
                "Ã³": "o",
                "Ã´": "o",
                "á»“": "o",
                "á»‘": "o",
                "á»—": "o",
                "á»•": "o",
                "Ãµ": "o",
                "á¹": "o",
                "È­": "o",
                "á¹": "o",
                "Å": "o",
                "á¹‘": "o",
                "á¹“": "o",
                "Å": "o",
                "È¯": "o",
                "È±": "o",
                "Ã¶": "o",
                "È«": "o",
                "á»": "o",
                "Å‘": "o",
                "Ç’": "o",
                "È": "o",
                "È": "o",
                "Æ¡": "o",
                "á»": "o",
                "á»›": "o",
                "á»¡": "o",
                "á»Ÿ": "o",
                "á»£": "o",
                "á»": "o",
                "á»™": "o",
                "Ç«": "o",
                "Ç­": "o",
                "Ã¸": "o",
                "Ç¿": "o",
                "É”": "o",
                "ê‹": "o",
                "ê": "o",
                "Éµ": "o",
                "Æ£": "oi",
                "È£": "ou",
                "ê": "oo",
                "â“Ÿ": "p",
                "ï½": "p",
                "á¹•": "p",
                "á¹—": "p",
                "Æ¥": "p",
                "áµ½": "p",
                "ê‘": "p",
                "ê“": "p",
                "ê•": "p",
                "â“ ": "q",
                "ï½‘": "q",
                "É‹": "q",
                "ê—": "q",
                "ê™": "q",
                "â“¡": "r",
                "ï½’": "r",
                "Å•": "r",
                "á¹™": "r",
                "Å™": "r",
                "È‘": "r",
                "È“": "r",
                "á¹›": "r",
                "á¹": "r",
                "Å—": "r",
                "á¹Ÿ": "r",
                "É": "r",
                "É½": "r",
                "ê›": "r",
                "êž§": "r",
                "êžƒ": "r",
                "â“¢": "s",
                "ï½“": "s",
                "ÃŸ": "s",
                "Å›": "s",
                "á¹¥": "s",
                "Å": "s",
                "á¹¡": "s",
                "Å¡": "s",
                "á¹§": "s",
                "á¹£": "s",
                "á¹©": "s",
                "È™": "s",
                "ÅŸ": "s",
                "È¿": "s",
                "êž©": "s",
                "êž…": "s",
                "áº›": "s",
                "â“£": "t",
                "ï½”": "t",
                "á¹«": "t",
                "áº—": "t",
                "Å¥": "t",
                "á¹­": "t",
                "È›": "t",
                "Å£": "t",
                "á¹±": "t",
                "á¹¯": "t",
                "Å§": "t",
                "Æ­": "t",
                "Êˆ": "t",
                "â±¦": "t",
                "êž‡": "t",
                "êœ©": "tz",
                "â“¤": "u",
                "ï½•": "u",
                "Ã¹": "u",
                "Ãº": "u",
                "Ã»": "u",
                "Å©": "u",
                "á¹¹": "u",
                "Å«": "u",
                "á¹»": "u",
                "Å­": "u",
                "Ã¼": "u",
                "Çœ": "u",
                "Ç˜": "u",
                "Ç–": "u",
                "Çš": "u",
                "á»§": "u",
                "Å¯": "u",
                "Å±": "u",
                "Ç”": "u",
                "È•": "u",
                "È—": "u",
                "Æ°": "u",
                "á»«": "u",
                "á»©": "u",
                "á»¯": "u",
                "á»­": "u",
                "á»±": "u",
                "á»¥": "u",
                "á¹³": "u",
                "Å³": "u",
                "á¹·": "u",
                "á¹µ": "u",
                "Ê‰": "u",
                "â“¥": "v",
                "ï½–": "v",
                "á¹½": "v",
                "á¹¿": "v",
                "Ê‹": "v",
                "êŸ": "v",
                "ÊŒ": "v",
                "ê¡": "vy",
                "â“¦": "w",
                "ï½—": "w",
                "áº": "w",
                "áºƒ": "w",
                "Åµ": "w",
                "áº‡": "w",
                "áº…": "w",
                "áº˜": "w",
                "áº‰": "w",
                "â±³": "w",
                "â“§": "x",
                "ï½˜": "x",
                "áº‹": "x",
                "áº": "x",
                "â“¨": "y",
                "ï½™": "y",
                "á»³": "y",
                "Ã½": "y",
                "Å·": "y",
                "á»¹": "y",
                "È³": "y",
                "áº": "y",
                "Ã¿": "y",
                "á»·": "y",
                "áº™": "y",
                "á»µ": "y",
                "Æ´": "y",
                "É": "y",
                "á»¿": "y",
                "â“©": "z",
                "ï½š": "z",
                "Åº": "z",
                "áº‘": "z",
                "Å¼": "z",
                "Å¾": "z",
                "áº“": "z",
                "áº•": "z",
                "Æ¶": "z",
                "È¥": "z",
                "É€": "z",
                "â±¬": "z",
                "ê£": "z",
                "Î†": "Î‘",
                "Îˆ": "Î•",
                "Î‰": "Î—",
                "ÎŠ": "Î™",
                "Îª": "Î™",
                "ÎŒ": "ÎŸ",
                "ÎŽ": "Î¥",
                "Î«": "Î¥",
                "Î": "Î©",
                "Î¬": "Î±",
                "Î­": "Îµ",
                "Î®": "Î·",
                "Î¯": "Î¹",
                "ÏŠ": "Î¹",
                "Î": "Î¹",
                "ÏŒ": "Î¿",
                "Ï": "Ï…",
                "Ï‹": "Ï…",
                "Î°": "Ï…",
                "Ï‰": "Ï‰",
                "Ï‚": "Ïƒ"
            }
        }), e.define("select2/data/base", ["../utils"], function (t) {
            function e(t, i) {
                e.__super__.constructor.call(this)
            }

            return t.Extend(e, t.Observable), e.prototype.current = function (t) {
                throw new Error("The `current` method must be defined in child classes.")
            }, e.prototype.query = function (t, e) {
                throw new Error("The `query` method must be defined in child classes.")
            }, e.prototype.bind = function (t, e) {
            }, e.prototype.destroy = function () {
            }, e.prototype.generateResultId = function (e, i) {
                var n = e.id + "-result-";
                return n += t.generateChars(4), n += null != i.id ? "-" + i.id.toString() : "-" + t.generateChars(4)
            }, e
        }), e.define("select2/data/select", ["./base", "../utils", "jquery"], function (t, e, i) {
            function n(t, e) {
                this.$element = t, this.options = e, n.__super__.constructor.call(this)
            }

            return e.Extend(n, t), n.prototype.current = function (t) {
                var e = [], n = this;
                this.$element.find(":selected").each(function () {
                    var t = i(this), s = n.item(t);
                    e.push(s)
                }), t(e)
            }, n.prototype.select = function (t) {
                var e = this;
                if (t.selected = !0, i(t.element).is("option")) return t.element.selected = !0, void this.$element.trigger("change");
                if (this.$element.prop("multiple")) this.current(function (n) {
                    var s = [];
                    t = [t], t.push.apply(t, n);
                    for (var r = 0; r < t.length; r++) {
                        var o = t[r].id;
                        -1 === i.inArray(o, s) && s.push(o)
                    }
                    e.$element.val(s), e.$element.trigger("change")
                }); else {
                    var n = t.id;
                    this.$element.val(n), this.$element.trigger("change")
                }
            }, n.prototype.unselect = function (t) {
                var e = this;
                if (this.$element.prop("multiple")) return t.selected = !1, i(t.element).is("option") ? (t.element.selected = !1, void this.$element.trigger("change")) : void this.current(function (n) {
                    for (var s = [], r = 0; r < n.length; r++) {
                        var o = n[r].id;
                        o !== t.id && -1 === i.inArray(o, s) && s.push(o)
                    }
                    e.$element.val(s), e.$element.trigger("change")
                })
            }, n.prototype.bind = function (t, e) {
                var i = this;
                this.container = t, t.on("select", function (t) {
                    i.select(t.data)
                }), t.on("unselect", function (t) {
                    i.unselect(t.data)
                })
            }, n.prototype.destroy = function () {
                this.$element.find("*").each(function () {
                    i.removeData(this, "data")
                })
            }, n.prototype.query = function (t, e) {
                var n = [], s = this;
                this.$element.children().each(function () {
                    var e = i(this);
                    if (e.is("option") || e.is("optgroup")) {
                        var r = s.item(e), o = s.matches(t, r);
                        null !== o && n.push(o)
                    }
                }), e({results: n})
            }, n.prototype.addOptions = function (t) {
                e.appendMany(this.$element, t)
            }, n.prototype.option = function (t) {
                var e;
                t.children ? (e = document.createElement("optgroup"), e.label = t.text) : (e = document.createElement("option"), void 0 !== e.textContent ? e.textContent = t.text : e.innerText = t.text), t.id && (e.value = t.id), t.disabled && (e.disabled = !0), t.selected && (e.selected = !0), t.title && (e.title = t.title);
                var n = i(e), s = this._normalizeItem(t);
                return s.element = e, i.data(e, "data", s), n
            }, n.prototype.item = function (t) {
                var e = {};
                if (null != (e = i.data(t[0], "data"))) return e;
                if (t.is("option")) e = {
                    id: t.val(),
                    text: t.text(),
                    disabled: t.prop("disabled"),
                    selected: t.prop("selected"),
                    title: t.prop("title")
                }; else if (t.is("optgroup")) {
                    e = {text: t.prop("label"), children: [], title: t.prop("title")};
                    for (var n = t.children("option"), s = [], r = 0; r < n.length; r++) {
                        var o = i(n[r]), a = this.item(o);
                        s.push(a)
                    }
                    e.children = s
                }
                return e = this._normalizeItem(e), e.element = t[0], i.data(t[0], "data", e), e
            }, n.prototype._normalizeItem = function (t) {
                i.isPlainObject(t) || (t = {id: t, text: t}), t = i.extend({}, {text: ""}, t);
                var e = {selected: !1, disabled: !1};
                return null != t.id && (t.id = t.id.toString()), null != t.text && (t.text = t.text.toString()), null == t._resultId && t.id && null != this.container && (t._resultId = this.generateResultId(this.container, t)), i.extend({}, e, t)
            }, n.prototype.matches = function (t, e) {
                return this.options.get("matcher")(t, e)
            }, n
        }), e.define("select2/data/array", ["./select", "../utils", "jquery"], function (t, e, i) {
            function n(t, e) {
                var i = e.get("data") || [];
                n.__super__.constructor.call(this, t, e), this.addOptions(this.convertToOptions(i))
            }

            return e.Extend(n, t), n.prototype.select = function (t) {
                var e = this.$element.find("option").filter(function (e, i) {
                    return i.value == t.id.toString()
                });
                0 === e.length && (e = this.option(t), this.addOptions(e)), n.__super__.select.call(this, t)
            }, n.prototype.convertToOptions = function (t) {
                for (var n = this, s = this.$element.find("option"), r = s.map(function () {
                    return n.item(i(this)).id
                }).get(), o = [], a = 0; a < t.length; a++) {
                    var l = this._normalizeItem(t[a]);
                    if (i.inArray(l.id, r) >= 0) {
                        var c = s.filter(function (t) {
                            return function () {
                                return i(this).val() == t.id
                            }
                        }(l)), u = this.item(c), h = i.extend(!0, {}, l, u), d = this.option(h);
                        c.replaceWith(d)
                    } else {
                        var p = this.option(l);
                        if (l.children) {
                            var f = this.convertToOptions(l.children);
                            e.appendMany(p, f)
                        }
                        o.push(p)
                    }
                }
                return o
            }, n
        }), e.define("select2/data/ajax", ["./array", "../utils", "jquery"], function (t, e, i) {
            function n(t, e) {
                this.ajaxOptions = this._applyDefaults(e.get("ajax")), null != this.ajaxOptions.processResults && (this.processResults = this.ajaxOptions.processResults), n.__super__.constructor.call(this, t, e)
            }

            return e.Extend(n, t), n.prototype._applyDefaults = function (t) {
                var e = {
                    data: function (t) {
                        return i.extend({}, t, {q: t.term})
                    }, transport: function (t, e, n) {
                        var s = i.ajax(t);
                        return s.then(e), s.fail(n), s
                    }
                };
                return i.extend({}, e, t, !0)
            }, n.prototype.processResults = function (t) {
                return t
            }, n.prototype.query = function (t, e) {
                function n() {
                    var n = r.transport(r, function (n) {
                        var r = s.processResults(n, t);
                        s.options.get("debug") && window.console && console.error && (r && r.results && i.isArray(r.results) || console.error("Select2: The AJAX results did not return an array in the `results` key of the response.")), e(r)
                    }, function () {
                        n.status && "0" === n.status || s.trigger("results:message", {message: "errorLoading"})
                    });
                    s._request = n
                }

                var s = this;
                null != this._request && (i.isFunction(this._request.abort) && this._request.abort(), this._request = null);
                var r = i.extend({type: "GET"}, this.ajaxOptions);
                "function" == typeof r.url && (r.url = r.url.call(this.$element, t)), "function" == typeof r.data && (r.data = r.data.call(this.$element, t)), this.ajaxOptions.delay && null != t.term ? (this._queryTimeout && window.clearTimeout(this._queryTimeout), this._queryTimeout = window.setTimeout(n, this.ajaxOptions.delay)) : n()
            }, n
        }), e.define("select2/data/tags", ["jquery"], function (t) {
            function e(e, i, n) {
                var s = n.get("tags"), r = n.get("createTag");
                void 0 !== r && (this.createTag = r);
                var o = n.get("insertTag");
                if (void 0 !== o && (this.insertTag = o), e.call(this, i, n), t.isArray(s)) for (var a = 0; a < s.length; a++) {
                    var l = s[a], c = this._normalizeItem(l), u = this.option(c);
                    this.$element.append(u)
                }
            }

            return e.prototype.query = function (t, e, i) {
                function n(t, r) {
                    for (var o = t.results, a = 0; a < o.length; a++) {
                        var l = o[a], c = null != l.children && !n({results: l.children}, !0);
                        if (l.text === e.term || c) return !r && (t.data = o, void i(t))
                    }
                    if (r) return !0;
                    var u = s.createTag(e);
                    if (null != u) {
                        var h = s.option(u);
                        h.attr("data-select2-tag", !0), s.addOptions([h]), s.insertTag(o, u)
                    }
                    t.results = o, i(t)
                }

                var s = this;
                return this._removeOldTags(), null == e.term || null != e.page ? void t.call(this, e, i) : void t.call(this, e, n)
            }, e.prototype.createTag = function (e, i) {
                var n = t.trim(i.term);
                return "" === n ? null : {id: n, text: n}
            }, e.prototype.insertTag = function (t, e, i) {
                e.unshift(i)
            }, e.prototype._removeOldTags = function (e) {
                (this._lastTag, this.$element.find("option[data-select2-tag]")).each(function () {
                    this.selected || t(this).remove()
                })
            }, e
        }), e.define("select2/data/tokenizer", ["jquery"], function (t) {
            function e(t, e, i) {
                var n = i.get("tokenizer");
                void 0 !== n && (this.tokenizer = n), t.call(this, e, i)
            }

            return e.prototype.bind = function (t, e, i) {
                t.call(this, e, i), this.$search = e.dropdown.$search || e.selection.$search || i.find(".select2-search__field")
            }, e.prototype.query = function (e, i, n) {
                function s(e) {
                    var i = o._normalizeItem(e);
                    if (!o.$element.find("option").filter(function () {
                        return t(this).val() === i.id
                    }).length) {
                        var n = o.option(i);
                        n.attr("data-select2-tag", !0), o._removeOldTags(), o.addOptions([n])
                    }
                    r(i)
                }

                function r(t) {
                    o.trigger("select", {data: t})
                }

                var o = this;
                i.term = i.term || "";
                var a = this.tokenizer(i, this.options, s);
                a.term !== i.term && (this.$search.length && (this.$search.val(a.term), this.$search.focus()), i.term = a.term), e.call(this, i, n)
            }, e.prototype.tokenizer = function (e, i, n, s) {
                for (var r = n.get("tokenSeparators") || [], o = i.term, a = 0, l = this.createTag || function (t) {
                    return {id: t.term, text: t.term}
                }; a < o.length;) {
                    var c = o[a];
                    if (-1 !== t.inArray(c, r)) {
                        var u = o.substr(0, a), h = t.extend({}, i, {term: u}), d = l(h);
                        null != d ? (s(d), o = o.substr(a + 1) || "", a = 0) : a++
                    } else a++
                }
                return {term: o}
            }, e
        }), e.define("select2/data/minimumInputLength", [], function () {
            function t(t, e, i) {
                this.minimumInputLength = i.get("minimumInputLength"), t.call(this, e, i)
            }

            return t.prototype.query = function (t, e, i) {
                return e.term = e.term || "", e.term.length < this.minimumInputLength ? void this.trigger("results:message", {
                    message: "inputTooShort",
                    args: {minimum: this.minimumInputLength, input: e.term, params: e}
                }) : void t.call(this, e, i)
            }, t
        }), e.define("select2/data/maximumInputLength", [], function () {
            function t(t, e, i) {
                this.maximumInputLength = i.get("maximumInputLength"), t.call(this, e, i)
            }

            return t.prototype.query = function (t, e, i) {
                return e.term = e.term || "", this.maximumInputLength > 0 && e.term.length > this.maximumInputLength ? void this.trigger("results:message", {
                    message: "inputTooLong",
                    args: {maximum: this.maximumInputLength, input: e.term, params: e}
                }) : void t.call(this, e, i)
            }, t
        }), e.define("select2/data/maximumSelectionLength", [], function () {
            function t(t, e, i) {
                this.maximumSelectionLength = i.get("maximumSelectionLength"), t.call(this, e, i)
            }

            return t.prototype.query = function (t, e, i) {
                var n = this;
                this.current(function (s) {
                    var r = null != s ? s.length : 0;
                    return n.maximumSelectionLength > 0 && r >= n.maximumSelectionLength ? void n.trigger("results:message", {
                        message: "maximumSelected",
                        args: {maximum: n.maximumSelectionLength}
                    }) : void t.call(n, e, i)
                })
            }, t
        }), e.define("select2/dropdown", ["jquery", "./utils"], function (t, e) {
            function i(t, e) {
                this.$element = t, this.options = e, i.__super__.constructor.call(this)
            }

            return e.Extend(i, e.Observable), i.prototype.render = function () {
                var e = t('<span class="select2-dropdown"><span class="select2-results"></span></span>');
                return e.attr("dir", this.options.get("dir")), this.$dropdown = e, e
            }, i.prototype.bind = function () {
            }, i.prototype.position = function (t, e) {
            }, i.prototype.destroy = function () {
                this.$dropdown.remove()
            }, i
        }), e.define("select2/dropdown/search", ["jquery", "../utils"], function (t, e) {
            function i() {
            }

            return i.prototype.render = function (e) {
                var i = e.call(this),
                    n = t('<span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" /></span>');
                return this.$searchContainer = n, this.$search = n.find("input"), i.prepend(n), i
            }, i.prototype.bind = function (e, i, n) {
                var s = this;
                e.call(this, i, n), this.$search.on("keydown", function (t) {
                    s.trigger("keypress", t), s._keyUpPrevented = t.isDefaultPrevented()
                }), this.$search.on("input", function (e) {
                    t(this).off("keyup")
                }), this.$search.on("keyup input", function (t) {
                    s.handleSearch(t)
                }), i.on("open", function () {
                    s.$search.attr("tabindex", 0), s.$search.focus(), window.setTimeout(function () {
                        s.$search.focus()
                    }, 0)
                }), i.on("close", function () {
                    s.$search.attr("tabindex", -1), s.$search.val("")
                }), i.on("focus", function () {
                    i.isOpen() && s.$search.focus()
                }), i.on("results:all", function (t) {
                    if (null == t.query.term || "" === t.query.term) {
                        s.showSearch(t) ? s.$searchContainer.removeClass("select2-search--hide") : s.$searchContainer.addClass("select2-search--hide")
                    }
                })
            }, i.prototype.handleSearch = function (t) {
                if (!this._keyUpPrevented) {
                    var e = this.$search.val();
                    this.trigger("query", {term: e})
                }
                this._keyUpPrevented = !1
            }, i.prototype.showSearch = function (t, e) {
                return !0
            }, i
        }), e.define("select2/dropdown/hidePlaceholder", [], function () {
            function t(t, e, i, n) {
                this.placeholder = this.normalizePlaceholder(i.get("placeholder")), t.call(this, e, i, n)
            }

            return t.prototype.append = function (t, e) {
                e.results = this.removePlaceholder(e.results), t.call(this, e)
            }, t.prototype.normalizePlaceholder = function (t, e) {
                return "string" == typeof e && (e = {id: "", text: e}), e
            }, t.prototype.removePlaceholder = function (t, e) {
                for (var i = e.slice(0), n = e.length - 1; n >= 0; n--) {
                    var s = e[n];
                    this.placeholder.id === s.id && i.splice(n, 1)
                }
                return i
            }, t
        }), e.define("select2/dropdown/infiniteScroll", ["jquery"], function (t) {
            function e(t, e, i, n) {
                this.lastParams = {}, t.call(this, e, i, n), this.$loadingMore = this.createLoadingMore(), this.loading = !1
            }

            return e.prototype.append = function (t, e) {
                this.$loadingMore.remove(), this.loading = !1, t.call(this, e), this.showLoadingMore(e) && this.$results.append(this.$loadingMore)
            }, e.prototype.bind = function (e, i, n) {
                var s = this;
                e.call(this, i, n), i.on("query", function (t) {
                    s.lastParams = t, s.loading = !0
                }), i.on("query:append", function (t) {
                    s.lastParams = t, s.loading = !0
                }), this.$results.on("scroll", function () {
                    var e = t.contains(document.documentElement, s.$loadingMore[0]);
                    if (!s.loading && e) {
                        s.$results.offset().top + s.$results.outerHeight(!1) + 50 >= s.$loadingMore.offset().top + s.$loadingMore.outerHeight(!1) && s.loadMore()
                    }
                })
            }, e.prototype.loadMore = function () {
                this.loading = !0;
                var e = t.extend({}, {page: 1}, this.lastParams);
                e.page++, this.trigger("query:append", e)
            }, e.prototype.showLoadingMore = function (t, e) {
                return e.pagination && e.pagination.more
            }, e.prototype.createLoadingMore = function () {
                var e = t('<li class="select2-results__option select2-results__option--load-more"role="treeitem" aria-disabled="true"></li>'),
                    i = this.options.get("translations").get("loadingMore");
                return e.html(i(this.lastParams)), e
            }, e
        }), e.define("select2/dropdown/attachBody", ["jquery", "../utils"], function (t, e) {
            function i(e, i, n) {
                this.$dropdownParent = n.get("dropdownParent") || t(document.body), e.call(this, i, n)
            }

            return i.prototype.bind = function (t, e, i) {
                var n = this, s = !1;
                t.call(this, e, i), e.on("open", function () {
                    n._showDropdown(), n._attachPositioningHandler(e), s || (s = !0, e.on("results:all", function () {
                        n._positionDropdown(), n._resizeDropdown()
                    }), e.on("results:append", function () {
                        n._positionDropdown(), n._resizeDropdown()
                    }))
                }), e.on("close", function () {
                    n._hideDropdown(), n._detachPositioningHandler(e)
                }), this.$dropdownContainer.on("mousedown", function (t) {
                    t.stopPropagation()
                })
            }, i.prototype.destroy = function (t) {
                t.call(this), this.$dropdownContainer.remove()
            }, i.prototype.position = function (t, e, i) {
                e.attr("class", i.attr("class")), e.removeClass("select2"), e.addClass("select2-container--open"), e.css({
                    position: "absolute",
                    top: -999999
                }), this.$container = i
            }, i.prototype.render = function (e) {
                var i = t("<span></span>"), n = e.call(this);
                return i.append(n), this.$dropdownContainer = i, i
            }, i.prototype._hideDropdown = function (t) {
                this.$dropdownContainer.detach()
            }, i.prototype._attachPositioningHandler = function (i, n) {
                var s = this, r = "scroll.select2." + n.id, o = "resize.select2." + n.id,
                    a = "orientationchange.select2." + n.id, l = this.$container.parents().filter(e.hasScroll);
                l.each(function () {
                    t(this).data("select2-scroll-position", {x: t(this).scrollLeft(), y: t(this).scrollTop()})
                }), l.on(r, function (e) {
                    var i = t(this).data("select2-scroll-position");
                    t(this).scrollTop(i.y)
                }), t(window).on(r + " " + o + " " + a, function (t) {
                    s._positionDropdown(), s._resizeDropdown()
                })
            }, i.prototype._detachPositioningHandler = function (i, n) {
                var s = "scroll.select2." + n.id, r = "resize.select2." + n.id, o = "orientationchange.select2." + n.id;
                this.$container.parents().filter(e.hasScroll).off(s), t(window).off(s + " " + r + " " + o)
            }, i.prototype._positionDropdown = function () {
                var e = t(window), i = this.$dropdown.hasClass("select2-dropdown--above"),
                    n = this.$dropdown.hasClass("select2-dropdown--below"), s = null, r = this.$container.offset();
                r.bottom = r.top + this.$container.outerHeight(!1);
                var o = {height: this.$container.outerHeight(!1)};
                o.top = r.top, o.bottom = r.top + o.height;
                var a = {height: this.$dropdown.outerHeight(!1)},
                    l = {top: e.scrollTop(), bottom: e.scrollTop() + e.height()}, c = l.top < r.top - a.height,
                    u = l.bottom > r.bottom + a.height, h = {left: r.left, top: o.bottom}, d = this.$dropdownParent;
                "static" === d.css("position") && (d = d.offsetParent());
                var p = d.offset();
                h.top -= p.top, h.left -= p.left, i || n || (s = "below"), u || !c || i ? !c && u && i && (s = "below") : s = "above", ("above" == s || i && "below" !== s) && (h.top = o.top - p.top - a.height), null != s && (this.$dropdown.removeClass("select2-dropdown--below select2-dropdown--above").addClass("select2-dropdown--" + s), this.$container.removeClass("select2-container--below select2-container--above").addClass("select2-container--" + s)), this.$dropdownContainer.css(h)
            }, i.prototype._resizeDropdown = function () {
                var t = {width: this.$container.outerWidth(!1) + "px"};
                this.options.get("dropdownAutoWidth") && (t.minWidth = t.width, t.position = "relative", t.width = "auto"), this.$dropdown.css(t)
            }, i.prototype._showDropdown = function (t) {
                this.$dropdownContainer.appendTo(this.$dropdownParent), this._positionDropdown(), this._resizeDropdown()
            }, i
        }), e.define("select2/dropdown/minimumResultsForSearch", [], function () {
            function t(e) {
                for (var i = 0, n = 0; n < e.length; n++) {
                    var s = e[n];
                    s.children ? i += t(s.children) : i++
                }
                return i
            }

            function e(t, e, i, n) {
                this.minimumResultsForSearch = i.get("minimumResultsForSearch"), this.minimumResultsForSearch < 0 && (this.minimumResultsForSearch = 1 / 0), t.call(this, e, i, n)
            }

            return e.prototype.showSearch = function (e, i) {
                return !(t(i.data.results) < this.minimumResultsForSearch) && e.call(this, i)
            }, e
        }), e.define("select2/dropdown/selectOnClose", [], function () {
            function t() {
            }

            return t.prototype.bind = function (t, e, i) {
                var n = this;
                t.call(this, e, i), e.on("close", function (t) {
                    n._handleSelectOnClose(t)
                })
            }, t.prototype._handleSelectOnClose = function (t, e) {
                if (e && null != e.originalSelect2Event) {
                    var i = e.originalSelect2Event;
                    if ("select" === i._type || "unselect" === i._type) return
                }
                var n = this.getHighlightedResults();
                if (!(n.length < 1)) {
                    var s = n.data("data");
                    null != s.element && s.element.selected || null == s.element && s.selected || this.trigger("select", {data: s})
                }
            }, t
        }), e.define("select2/dropdown/closeOnSelect", [], function () {
            function t() {
            }

            return t.prototype.bind = function (t, e, i) {
                var n = this;
                t.call(this, e, i), e.on("select", function (t) {
                    n._selectTriggered(t)
                }), e.on("unselect", function (t) {
                    n._selectTriggered(t)
                })
            }, t.prototype._selectTriggered = function (t, e) {
                var i = e.originalEvent;
                i && i.ctrlKey || this.trigger("close", {originalEvent: i, originalSelect2Event: e})
            }, t
        }), e.define("select2/i18n/en", [], function () {
            return {
                errorLoading: function () {
                    return "The results could not be loaded."
                }, inputTooLong: function (t) {
                    var e = t.input.length - t.maximum, i = "Please delete " + e + " character";
                    return 1 != e && (i += "s"), i
                }, inputTooShort: function (t) {
                    return "Please enter " + (t.minimum - t.input.length) + " or more characters"
                }, loadingMore: function () {
                    return "Loading more resultsâ€¦"
                }, maximumSelected: function (t) {
                    var e = "You can only select " + t.maximum + " item";
                    return 1 != t.maximum && (e += "s"), e
                }, noResults: function () {
                    return "No results found"
                }, searching: function () {
                    return "Searchingâ€¦"
                }
            }
        }), e.define("select2/defaults", ["jquery", "require", "./results", "./selection/single", "./selection/multiple", "./selection/placeholder", "./selection/allowClear", "./selection/search", "./selection/eventRelay", "./utils", "./translation", "./diacritics", "./data/select", "./data/array", "./data/ajax", "./data/tags", "./data/tokenizer", "./data/minimumInputLength", "./data/maximumInputLength", "./data/maximumSelectionLength", "./dropdown", "./dropdown/search", "./dropdown/hidePlaceholder", "./dropdown/infiniteScroll", "./dropdown/attachBody", "./dropdown/minimumResultsForSearch", "./dropdown/selectOnClose", "./dropdown/closeOnSelect", "./i18n/en"], function (t, e, i, n, s, r, o, a, l, c, u, h, d, p, f, g, m, v, b, y, w, x, _, A, C, T, S, I, E) {
            function $() {
                this.reset()
            }

            return $.prototype.apply = function (h) {
                if (h = t.extend(!0, {}, this.defaults, h), null == h.dataAdapter) {
                    if (null != h.ajax ? h.dataAdapter = f : null != h.data ? h.dataAdapter = p : h.dataAdapter = d, h.minimumInputLength > 0 && (h.dataAdapter = c.Decorate(h.dataAdapter, v)), h.maximumInputLength > 0 && (h.dataAdapter = c.Decorate(h.dataAdapter, b)), h.maximumSelectionLength > 0 && (h.dataAdapter = c.Decorate(h.dataAdapter, y)), h.tags && (h.dataAdapter = c.Decorate(h.dataAdapter, g)), (null != h.tokenSeparators || null != h.tokenizer) && (h.dataAdapter = c.Decorate(h.dataAdapter, m)), null != h.query) {
                        var E = e(h.amdBase + "compat/query");
                        h.dataAdapter = c.Decorate(h.dataAdapter, E)
                    }
                    if (null != h.initSelection) {
                        var $ = e(h.amdBase + "compat/initSelection");
                        h.dataAdapter = c.Decorate(h.dataAdapter, $)
                    }
                }
                if (null == h.resultsAdapter && (h.resultsAdapter = i, null != h.ajax && (h.resultsAdapter = c.Decorate(h.resultsAdapter, A)), null != h.placeholder && (h.resultsAdapter = c.Decorate(h.resultsAdapter, _)), h.selectOnClose && (h.resultsAdapter = c.Decorate(h.resultsAdapter, S))), null == h.dropdownAdapter) {
                    if (h.multiple) h.dropdownAdapter = w; else {
                        var D = c.Decorate(w, x);
                        h.dropdownAdapter = D
                    }
                    if (0 !== h.minimumResultsForSearch && (h.dropdownAdapter = c.Decorate(h.dropdownAdapter, T)), h.closeOnSelect && (h.dropdownAdapter = c.Decorate(h.dropdownAdapter, I)), null != h.dropdownCssClass || null != h.dropdownCss || null != h.adaptDropdownCssClass) {
                        var P = e(h.amdBase + "compat/dropdownCss");
                        h.dropdownAdapter = c.Decorate(h.dropdownAdapter, P)
                    }
                    h.dropdownAdapter = c.Decorate(h.dropdownAdapter, C)
                }
                if (null == h.selectionAdapter) {
                    if (h.multiple ? h.selectionAdapter = s : h.selectionAdapter = n, null != h.placeholder && (h.selectionAdapter = c.Decorate(h.selectionAdapter, r)), h.allowClear && (h.selectionAdapter = c.Decorate(h.selectionAdapter, o)), h.multiple && (h.selectionAdapter = c.Decorate(h.selectionAdapter, a)), null != h.containerCssClass || null != h.containerCss || null != h.adaptContainerCssClass) {
                        var k = e(h.amdBase + "compat/containerCss");
                        h.selectionAdapter = c.Decorate(h.selectionAdapter, k)
                    }
                    h.selectionAdapter = c.Decorate(h.selectionAdapter, l)
                }
                if ("string" == typeof h.language) if (h.language.indexOf("-") > 0) {
                    var N = h.language.split("-"), L = N[0];
                    h.language = [h.language, L]
                } else h.language = [h.language];
                if (t.isArray(h.language)) {
                    var O = new u;
                    h.language.push("en");
                    for (var R = h.language, V = 0; V < R.length; V++) {
                        var H = R[V], F = {};
                        try {
                            F = u.loadPath(H)
                        } catch (t) {
                            try {
                                H = this.defaults.amdLanguageBase + H, F = u.loadPath(H)
                            } catch (t) {
                                h.debug && window.console && console.warn && console.warn('Select2: The language file for "' + H + '" could not be automatically loaded. A fallback will be used instead.');
                                continue
                            }
                        }
                        O.extend(F)
                    }
                    h.translations = O
                } else {
                    var M = u.loadPath(this.defaults.amdLanguageBase + "en"), z = new u(h.language);
                    z.extend(M), h.translations = z
                }
                return h
            }, $.prototype.reset = function () {
                function e(t) {
                    function e(t) {
                        return h[t] || t
                    }

                    return t.replace(/[^\u0000-\u007E]/g, e)
                }

                function i(n, s) {
                    if ("" === t.trim(n.term)) return s;
                    if (s.children && s.children.length > 0) {
                        for (var r = t.extend(!0, {}, s), o = s.children.length - 1; o >= 0; o--) {
                            null == i(n, s.children[o]) && r.children.splice(o, 1)
                        }
                        return r.children.length > 0 ? r : i(n, r)
                    }
                    var a = e(s.text).toUpperCase(), l = e(n.term).toUpperCase();
                    return a.indexOf(l) > -1 ? s : null
                }

                this.defaults = {
                    amdBase: "./",
                    amdLanguageBase: "./i18n/",
                    closeOnSelect: !0,
                    debug: !1,
                    dropdownAutoWidth: !1,
                    escapeMarkup: c.escapeMarkup,
                    language: E,
                    matcher: i,
                    minimumInputLength: 0,
                    maximumInputLength: 0,
                    maximumSelectionLength: 0,
                    minimumResultsForSearch: 0,
                    selectOnClose: !1,
                    sorter: function (t) {
                        return t
                    },
                    templateResult: function (t) {
                        return t.text
                    },
                    templateSelection: function (t) {
                        return t.text
                    },
                    theme: "default",
                    width: "resolve"
                }
            }, $.prototype.set = function (e, i) {
                var n = t.camelCase(e), s = {};
                s[n] = i;
                var r = c._convertData(s);
                t.extend(this.defaults, r)
            }, new $
        }), e.define("select2/options", ["require", "jquery", "./defaults", "./utils"], function (t, e, i, n) {
            function s(e, s) {
                if (this.options = e, null != s && this.fromElement(s), this.options = i.apply(this.options), s && s.is("input")) {
                    var r = t(this.get("amdBase") + "compat/inputData");
                    this.options.dataAdapter = n.Decorate(this.options.dataAdapter, r)
                }
            }

            return s.prototype.fromElement = function (t) {
                var i = ["select2"];
                null == this.options.multiple && (this.options.multiple = t.prop("multiple")), null == this.options.disabled && (this.options.disabled = t.prop("disabled")), null == this.options.language && (t.prop("lang") ? this.options.language = t.prop("lang").toLowerCase() : t.closest("[lang]").prop("lang") && (this.options.language = t.closest("[lang]").prop("lang"))),
                null == this.options.dir && (t.prop("dir") ? this.options.dir = t.prop("dir") : t.closest("[dir]").prop("dir") ? this.options.dir = t.closest("[dir]").prop("dir") : this.options.dir = "ltr"), t.prop("disabled", this.options.disabled), t.prop("multiple", this.options.multiple), t.data("select2Tags") && (this.options.debug && window.console && console.warn && console.warn('Select2: The `data-select2-tags` attribute has been changed to use the `data-data` and `data-tags="true"` attributes and will be removed in future versions of Select2.'), t.data("data", t.data("select2Tags")), t.data("tags", !0)), t.data("ajaxUrl") && (this.options.debug && window.console && console.warn && console.warn("Select2: The `data-ajax-url` attribute has been changed to `data-ajax--url` and support for the old attribute will be removed in future versions of Select2."), t.attr("ajax--url", t.data("ajaxUrl")), t.data("ajax--url", t.data("ajaxUrl")));
                var s = {};
                s = e.fn.jquery && "1." == e.fn.jquery.substr(0, 2) && t[0].dataset ? e.extend(!0, {}, t[0].dataset, t.data()) : t.data();
                var r = e.extend(!0, {}, s);
                r = n._convertData(r);
                for (var o in r) e.inArray(o, i) > -1 || (e.isPlainObject(this.options[o]) ? e.extend(this.options[o], r[o]) : this.options[o] = r[o]);
                return this
            }, s.prototype.get = function (t) {
                return this.options[t]
            }, s.prototype.set = function (t, e) {
                this.options[t] = e
            }, s
        }), e.define("select2/core", ["jquery", "./options", "./utils", "./keys"], function (t, e, i, n) {
            var s = function (t, i) {
                null != t.data("select2") && t.data("select2").destroy(), this.$element = t, this.id = this._generateId(t), i = i || {}, this.options = new e(i, t), s.__super__.constructor.call(this);
                var n = t.attr("tabindex") || 0;
                t.data("old-tabindex", n), t.attr("tabindex", "-1");
                var r = this.options.get("dataAdapter");
                this.dataAdapter = new r(t, this.options);
                var o = this.render();
                this._placeContainer(o);
                var a = this.options.get("selectionAdapter");
                this.selection = new a(t, this.options), this.$selection = this.selection.render(), this.selection.position(this.$selection, o);
                var l = this.options.get("dropdownAdapter");
                this.dropdown = new l(t, this.options), this.$dropdown = this.dropdown.render(), this.dropdown.position(this.$dropdown, o);
                var c = this.options.get("resultsAdapter");
                this.results = new c(t, this.options, this.dataAdapter), this.$results = this.results.render(), this.results.position(this.$results, this.$dropdown);
                var u = this;
                this._bindAdapters(), this._registerDomEvents(), this._registerDataEvents(), this._registerSelectionEvents(), this._registerDropdownEvents(), this._registerResultsEvents(), this._registerEvents(), this.dataAdapter.current(function (t) {
                    u.trigger("selection:update", {data: t})
                }), t.addClass("select2-hidden-accessible"), t.attr("aria-hidden", "true"), this._syncAttributes(), t.data("select2", this)
            };
            return i.Extend(s, i.Observable), s.prototype._generateId = function (t) {
                var e = "";
                return e = null != t.attr("id") ? t.attr("id") : null != t.attr("name") ? t.attr("name") + "-" + i.generateChars(2) : i.generateChars(4), e = e.replace(/(:|\.|\[|\]|,)/g, ""), e = "select2-" + e
            }, s.prototype._placeContainer = function (t) {
                t.insertAfter(this.$element);
                var e = this._resolveWidth(this.$element, this.options.get("width"));
                null != e && t.css("width", e)
            }, s.prototype._resolveWidth = function (t, e) {
                if ("resolve" == e) {
                    var i = this._resolveWidth(t, "style");
                    return null != i ? i : this._resolveWidth(t, "element")
                }
                if ("element" == e) {
                    var n = t.outerWidth(!1);
                    return 0 >= n ? "auto" : n + "px"
                }
                if ("style" == e) {
                    var s = t.attr("style");
                    if ("string" != typeof s) return null;
                    for (var r = s.split(";"), o = 0, a = r.length; a > o; o += 1) {
                        var l = r[o].replace(/\s/g, ""),
                            c = l.match(/^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i);
                        if (null !== c && c.length >= 1) return c[1]
                    }
                    return null
                }
                return e
            }, s.prototype._bindAdapters = function () {
                this.dataAdapter.bind(this, this.$container), this.selection.bind(this, this.$container), this.dropdown.bind(this, this.$container), this.results.bind(this, this.$container)
            }, s.prototype._registerDomEvents = function () {
                var e = this;
                this.$element.on("change.select2", function () {
                    e.dataAdapter.current(function (t) {
                        e.trigger("selection:update", {data: t})
                    })
                }), this.$element.on("focus.select2", function (t) {
                    e.trigger("focus", t)
                }), this._syncA = i.bind(this._syncAttributes, this), this._syncS = i.bind(this._syncSubtree, this), this.$element[0].attachEvent && this.$element[0].attachEvent("onpropertychange", this._syncA);
                var n = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;
                null != n ? (this._observer = new n(function (i) {
                    t.each(i, e._syncA), t.each(i, e._syncS)
                }), this._observer.observe(this.$element[0], {
                    attributes: !0,
                    childList: !0,
                    subtree: !1
                })) : this.$element[0].addEventListener && (this.$element[0].addEventListener("DOMAttrModified", e._syncA, !1), this.$element[0].addEventListener("DOMNodeInserted", e._syncS, !1), this.$element[0].addEventListener("DOMNodeRemoved", e._syncS, !1))
            }, s.prototype._registerDataEvents = function () {
                var t = this;
                this.dataAdapter.on("*", function (e, i) {
                    t.trigger(e, i)
                })
            }, s.prototype._registerSelectionEvents = function () {
                var e = this, i = ["toggle", "focus"];
                this.selection.on("toggle", function () {
                    e.toggleDropdown()
                }), this.selection.on("focus", function (t) {
                    e.focus(t)
                }), this.selection.on("*", function (n, s) {
                    -1 === t.inArray(n, i) && e.trigger(n, s)
                })
            }, s.prototype._registerDropdownEvents = function () {
                var t = this;
                this.dropdown.on("*", function (e, i) {
                    t.trigger(e, i)
                })
            }, s.prototype._registerResultsEvents = function () {
                var t = this;
                this.results.on("*", function (e, i) {
                    t.trigger(e, i)
                })
            }, s.prototype._registerEvents = function () {
                var t = this;
                this.on("open", function () {
                    t.$container.addClass("select2-container--open")
                }), this.on("close", function () {
                    t.$container.removeClass("select2-container--open")
                }), this.on("enable", function () {
                    t.$container.removeClass("select2-container--disabled")
                }), this.on("disable", function () {
                    t.$container.addClass("select2-container--disabled")
                }), this.on("blur", function () {
                    t.$container.removeClass("select2-container--focus")
                }), this.on("query", function (e) {
                    t.isOpen() || t.trigger("open", {}), this.dataAdapter.query(e, function (i) {
                        t.trigger("results:all", {data: i, query: e})
                    })
                }), this.on("query:append", function (e) {
                    this.dataAdapter.query(e, function (i) {
                        t.trigger("results:append", {data: i, query: e})
                    })
                }), this.on("keypress", function (e) {
                    var i = e.which;
                    t.isOpen() ? i === n.ESC || i === n.TAB || i === n.UP && e.altKey ? (t.close(), e.preventDefault()) : i === n.ENTER ? (t.trigger("results:select", {}), e.preventDefault()) : i === n.SPACE && e.ctrlKey ? (t.trigger("results:toggle", {}), e.preventDefault()) : i === n.UP ? (t.trigger("results:previous", {}), e.preventDefault()) : i === n.DOWN && (t.trigger("results:next", {}), e.preventDefault()) : (i === n.ENTER || i === n.SPACE || i === n.DOWN && e.altKey) && (t.open(), e.preventDefault())
                })
            }, s.prototype._syncAttributes = function () {
                this.options.set("disabled", this.$element.prop("disabled")), this.options.get("disabled") ? (this.isOpen() && this.close(), this.trigger("disable", {})) : this.trigger("enable", {})
            }, s.prototype._syncSubtree = function (t, e) {
                var i = !1, n = this;
                if (!t || !t.target || "OPTION" === t.target.nodeName || "OPTGROUP" === t.target.nodeName) {
                    if (e) if (e.addedNodes && e.addedNodes.length > 0) for (var s = 0; s < e.addedNodes.length; s++) {
                        var r = e.addedNodes[s];
                        r.selected && (i = !0)
                    } else e.removedNodes && e.removedNodes.length > 0 && (i = !0); else i = !0;
                    i && this.dataAdapter.current(function (t) {
                        n.trigger("selection:update", {data: t})
                    })
                }
            }, s.prototype.trigger = function (t, e) {
                var i = s.__super__.trigger,
                    n = {open: "opening", close: "closing", select: "selecting", unselect: "unselecting"};
                if (void 0 === e && (e = {}), t in n) {
                    var r = n[t], o = {prevented: !1, name: t, args: e};
                    if (i.call(this, r, o), o.prevented) return void(e.prevented = !0)
                }
                i.call(this, t, e)
            }, s.prototype.toggleDropdown = function () {
                this.options.get("disabled") || (this.isOpen() ? this.close() : this.open())
            }, s.prototype.open = function () {
                this.isOpen() || this.trigger("query", {})
            }, s.prototype.close = function () {
                this.isOpen() && this.trigger("close", {})
            }, s.prototype.isOpen = function () {
                return this.$container.hasClass("select2-container--open")
            }, s.prototype.hasFocus = function () {
                return this.$container.hasClass("select2-container--focus")
            }, s.prototype.focus = function (t) {
                this.hasFocus() || (this.$container.addClass("select2-container--focus"), this.trigger("focus", {}))
            }, s.prototype.enable = function (t) {
                this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("enable")` method has been deprecated and will be removed in later Select2 versions. Use $element.prop("disabled") instead.'), (null == t || 0 === t.length) && (t = [!0]);
                var e = !t[0];
                this.$element.prop("disabled", e)
            }, s.prototype.data = function () {
                this.options.get("debug") && arguments.length > 0 && window.console && console.warn && console.warn('Select2: Data can no longer be set using `select2("data")`. You should consider setting the value instead using `$element.val()`.');
                var t = [];
                return this.dataAdapter.current(function (e) {
                    t = e
                }), t
            }, s.prototype.val = function (e) {
                if (this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("val")` method has been deprecated and will be removed in later Select2 versions. Use $element.val() instead.'), null == e || 0 === e.length) return this.$element.val();
                var i = e[0];
                t.isArray(i) && (i = t.map(i, function (t) {
                    return t.toString()
                })), this.$element.val(i).trigger("change")
            }, s.prototype.destroy = function () {
                this.$container.remove(), this.$element[0].detachEvent && this.$element[0].detachEvent("onpropertychange", this._syncA), null != this._observer ? (this._observer.disconnect(), this._observer = null) : this.$element[0].removeEventListener && (this.$element[0].removeEventListener("DOMAttrModified", this._syncA, !1), this.$element[0].removeEventListener("DOMNodeInserted", this._syncS, !1), this.$element[0].removeEventListener("DOMNodeRemoved", this._syncS, !1)), this._syncA = null, this._syncS = null, this.$element.off(".select2"), this.$element.attr("tabindex", this.$element.data("old-tabindex")), this.$element.removeClass("select2-hidden-accessible"), this.$element.attr("aria-hidden", "false"), this.$element.removeData("select2"), this.dataAdapter.destroy(), this.selection.destroy(), this.dropdown.destroy(), this.results.destroy(), this.dataAdapter = null, this.selection = null, this.dropdown = null, this.results = null
            }, s.prototype.render = function () {
                var e = t('<span class="select2 select2-container"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>');
                return e.attr("dir", this.options.get("dir")), this.$container = e, this.$container.addClass("select2-container--" + this.options.get("theme")), e.data("element", this.$element), e
            }, s
        }), e.define("select2/compat/utils", ["jquery"], function (t) {
            function e(e, i, n) {
                var s, r, o = [];
                s = t.trim(e.attr("class")), s && (s = "" + s, t(s.split(/\s+/)).each(function () {
                    0 === this.indexOf("select2-") && o.push(this)
                })), s = t.trim(i.attr("class")), s && (s = "" + s, t(s.split(/\s+/)).each(function () {
                    0 !== this.indexOf("select2-") && null != (r = n(this)) && o.push(r)
                })), e.attr("class", o.join(" "))
            }

            return {syncCssClasses: e}
        }), e.define("select2/compat/containerCss", ["jquery", "./utils"], function (t, e) {
            function i(t) {
                return null
            }

            function n() {
            }

            return n.prototype.render = function (n) {
                var s = n.call(this), r = this.options.get("containerCssClass") || "";
                t.isFunction(r) && (r = r(this.$element));
                var o = this.options.get("adaptContainerCssClass");
                if (o = o || i, -1 !== r.indexOf(":all:")) {
                    r = r.replace(":all:", "");
                    var a = o;
                    o = function (t) {
                        var e = a(t);
                        return null != e ? e + " " + t : t
                    }
                }
                var l = this.options.get("containerCss") || {};
                return t.isFunction(l) && (l = l(this.$element)), e.syncCssClasses(s, this.$element, o), s.css(l), s.addClass(r), s
            }, n
        }), e.define("select2/compat/dropdownCss", ["jquery", "./utils"], function (t, e) {
            function i(t) {
                return null
            }

            function n() {
            }

            return n.prototype.render = function (n) {
                var s = n.call(this), r = this.options.get("dropdownCssClass") || "";
                t.isFunction(r) && (r = r(this.$element));
                var o = this.options.get("adaptDropdownCssClass");
                if (o = o || i, -1 !== r.indexOf(":all:")) {
                    r = r.replace(":all:", "");
                    var a = o;
                    o = function (t) {
                        var e = a(t);
                        return null != e ? e + " " + t : t
                    }
                }
                var l = this.options.get("dropdownCss") || {};
                return t.isFunction(l) && (l = l(this.$element)), e.syncCssClasses(s, this.$element, o), s.css(l), s.addClass(r), s
            }, n
        }), e.define("select2/compat/initSelection", ["jquery"], function (t) {
            function e(t, e, i) {
                i.get("debug") && window.console && console.warn && console.warn("Select2: The `initSelection` option has been deprecated in favor of a custom data adapter that overrides the `current` method. This method is now called multiple times instead of a single time when the instance is initialized. Support will be removed for the `initSelection` option in future versions of Select2"), this.initSelection = i.get("initSelection"), this._isInitialized = !1, t.call(this, e, i)
            }

            return e.prototype.current = function (e, i) {
                var n = this;
                return this._isInitialized ? void e.call(this, i) : void this.initSelection.call(null, this.$element, function (e) {
                    n._isInitialized = !0, t.isArray(e) || (e = [e]), i(e)
                })
            }, e
        }), e.define("select2/compat/inputData", ["jquery"], function (t) {
            function e(t, e, i) {
                this._currentData = [], this._valueSeparator = i.get("valueSeparator") || ",", "hidden" === e.prop("type") && i.get("debug") && console && console.warn && console.warn("Select2: Using a hidden input with Select2 is no longer supported and may stop working in the future. It is recommended to use a `<select>` element instead."), t.call(this, e, i)
            }

            return e.prototype.current = function (e, i) {
                function n(e, i) {
                    var s = [];
                    return e.selected || -1 !== t.inArray(e.id, i) ? (e.selected = !0, s.push(e)) : e.selected = !1, e.children && s.push.apply(s, n(e.children, i)), s
                }

                for (var s = [], r = 0; r < this._currentData.length; r++) {
                    var o = this._currentData[r];
                    s.push.apply(s, n(o, this.$element.val().split(this._valueSeparator)))
                }
                i(s)
            }, e.prototype.select = function (e, i) {
                if (this.options.get("multiple")) {
                    var n = this.$element.val();
                    n += this._valueSeparator + i.id, this.$element.val(n), this.$element.trigger("change")
                } else this.current(function (e) {
                    t.map(e, function (t) {
                        t.selected = !1
                    })
                }), this.$element.val(i.id), this.$element.trigger("change")
            }, e.prototype.unselect = function (t, e) {
                var i = this;
                e.selected = !1, this.current(function (t) {
                    for (var n = [], s = 0; s < t.length; s++) {
                        var r = t[s];
                        e.id != r.id && n.push(r.id)
                    }
                    i.$element.val(n.join(i._valueSeparator)), i.$element.trigger("change")
                })
            }, e.prototype.query = function (t, e, i) {
                for (var n = [], s = 0; s < this._currentData.length; s++) {
                    var r = this._currentData[s], o = this.matches(e, r);
                    null !== o && n.push(o)
                }
                i({results: n})
            }, e.prototype.addOptions = function (e, i) {
                var n = t.map(i, function (e) {
                    return t.data(e[0], "data")
                });
                this._currentData.push.apply(this._currentData, n)
            }, e
        }), e.define("select2/compat/matcher", ["jquery"], function (t) {
            function e(e) {
                function i(i, n) {
                    var s = t.extend(!0, {}, n);
                    if (null == i.term || "" === t.trim(i.term)) return s;
                    if (n.children) {
                        for (var r = n.children.length - 1; r >= 0; r--) {
                            var o = n.children[r];
                            e(i.term, o.text, o) || s.children.splice(r, 1)
                        }
                        if (s.children.length > 0) return s
                    }
                    return e(i.term, n.text, n) ? s : null
                }

                return i
            }

            return e
        }), e.define("select2/compat/query", [], function () {
            function t(t, e, i) {
                i.get("debug") && window.console && console.warn && console.warn("Select2: The `query` option has been deprecated in favor of a custom data adapter that overrides the `query` method. Support will be removed for the `query` option in future versions of Select2."), t.call(this, e, i)
            }

            return t.prototype.query = function (t, e, i) {
                e.callback = i, this.options.get("query").call(null, e)
            }, t
        }), e.define("select2/dropdown/attachContainer", [], function () {
            function t(t, e, i) {
                t.call(this, e, i)
            }

            return t.prototype.position = function (t, e, i) {
                i.find(".dropdown-wrapper").append(e), e.addClass("select2-dropdown--below"), i.addClass("select2-container--below")
            }, t
        }), e.define("select2/dropdown/stopPropagation", [], function () {
            function t() {
            }

            return t.prototype.bind = function (t, e, i) {
                t.call(this, e, i);
                var n = ["blur", "change", "click", "dblclick", "focus", "focusin", "focusout", "input", "keydown", "keyup", "keypress", "mousedown", "mouseenter", "mouseleave", "mousemove", "mouseover", "mouseup", "search", "touchend", "touchstart"];
                this.$dropdown.on(n.join(" "), function (t) {
                    t.stopPropagation()
                })
            }, t
        }), e.define("select2/selection/stopPropagation", [], function () {
            function t() {
            }

            return t.prototype.bind = function (t, e, i) {
                t.call(this, e, i);
                var n = ["blur", "change", "click", "dblclick", "focus", "focusin", "focusout", "input", "keydown", "keyup", "keypress", "mousedown", "mouseenter", "mouseleave", "mousemove", "mouseover", "mouseup", "search", "touchend", "touchstart"];
                this.$selection.on(n.join(" "), function (t) {
                    t.stopPropagation()
                })
            }, t
        }), function (i) {
            "function" == typeof e.define && e.define.amd ? e.define("jquery-mousewheel", ["jquery"], i) : "object" == typeof exports ? module.exports = i : i(t)
        }(function (t) {
            function e(e) {
                var o = e || window.event, a = l.call(arguments, 1), c = 0, h = 0, d = 0, p = 0, f = 0, g = 0;
                if (e = t.event.fix(o), e.type = "mousewheel", "detail" in o && (d = -1 * o.detail), "wheelDelta" in o && (d = o.wheelDelta), "wheelDeltaY" in o && (d = o.wheelDeltaY), "wheelDeltaX" in o && (h = -1 * o.wheelDeltaX), "axis" in o && o.axis === o.HORIZONTAL_AXIS && (h = -1 * d, d = 0), c = 0 === d ? h : d, "deltaY" in o && (d = -1 * o.deltaY, c = d), "deltaX" in o && (h = o.deltaX, 0 === d && (c = -1 * h)), 0 !== d || 0 !== h) {
                    if (1 === o.deltaMode) {
                        var m = t.data(this, "mousewheel-line-height");
                        c *= m, d *= m, h *= m
                    } else if (2 === o.deltaMode) {
                        var v = t.data(this, "mousewheel-page-height");
                        c *= v, d *= v, h *= v
                    }
                    if (p = Math.max(Math.abs(d), Math.abs(h)), (!r || r > p) && (r = p, n(o, p) && (r /= 40)), n(o, p) && (c /= 40, h /= 40, d /= 40), c = Math[c >= 1 ? "floor" : "ceil"](c / r), h = Math[h >= 1 ? "floor" : "ceil"](h / r), d = Math[d >= 1 ? "floor" : "ceil"](d / r), u.settings.normalizeOffset && this.getBoundingClientRect) {
                        var b = this.getBoundingClientRect();
                        f = e.clientX - b.left, g = e.clientY - b.top
                    }
                    return e.deltaX = h, e.deltaY = d, e.deltaFactor = r, e.offsetX = f, e.offsetY = g, e.deltaMode = 0, a.unshift(e, c, h, d), s && clearTimeout(s), s = setTimeout(i, 200), (t.event.dispatch || t.event.handle).apply(this, a)
                }
            }

            function i() {
                r = null
            }

            function n(t, e) {
                return u.settings.adjustOldDeltas && "mousewheel" === t.type && e % 120 == 0
            }

            var s, r, o = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
                a = "onwheel" in document || document.documentMode >= 9 ? ["wheel"] : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
                l = Array.prototype.slice;
            if (t.event.fixHooks) for (var c = o.length; c;) t.event.fixHooks[o[--c]] = t.event.mouseHooks;
            var u = t.event.special.mousewheel = {
                version: "3.1.12", setup: function () {
                    if (this.addEventListener) for (var i = a.length; i;) this.addEventListener(a[--i], e, !1); else this.onmousewheel = e;
                    t.data(this, "mousewheel-line-height", u.getLineHeight(this)), t.data(this, "mousewheel-page-height", u.getPageHeight(this))
                }, teardown: function () {
                    if (this.removeEventListener) for (var i = a.length; i;) this.removeEventListener(a[--i], e, !1); else this.onmousewheel = null;
                    t.removeData(this, "mousewheel-line-height"), t.removeData(this, "mousewheel-page-height")
                }, getLineHeight: function (e) {
                    var i = t(e), n = i["offsetParent" in t.fn ? "offsetParent" : "parent"]();
                    return n.length || (n = t("body")), parseInt(n.css("fontSize"), 10) || parseInt(i.css("fontSize"), 10) || 16
                }, getPageHeight: function (e) {
                    return t(e).height()
                }, settings: {adjustOldDeltas: !0, normalizeOffset: !0}
            };
            t.fn.extend({
                mousewheel: function (t) {
                    return t ? this.bind("mousewheel", t) : this.trigger("mousewheel")
                }, unmousewheel: function (t) {
                    return this.unbind("mousewheel", t)
                }
            })
        }), e.define("jquery.select2", ["jquery", "jquery-mousewheel", "./select2/core", "./select2/defaults"], function (t, e, i, n) {
            if (null == t.fn.select2) {
                var s = ["open", "close", "destroy"];
                t.fn.select2 = function (e) {
                    if ("object" == typeof(e = e || {})) return this.each(function () {
                        var n = t.extend(!0, {}, e);
                        new i(t(this), n)
                    }), this;
                    if ("string" == typeof e) {
                        var n, r = Array.prototype.slice.call(arguments, 1);
                        return this.each(function () {
                            var i = t(this).data("select2");
                            null == i && window.console && console.error && console.error("The select2('" + e + "') method was called on an element that is not using Select2."), n = i[e].apply(i, r)
                        }), t.inArray(e, s) > -1 ? this : n
                    }
                    throw new Error("Invalid arguments for Select2: " + e)
                }
            }
            return null == t.fn.select2.defaults && (t.fn.select2.defaults = n), i
        }), {define: e.define, require: e.require}
    }(), i = e.require("jquery.select2");
    return t.fn.select2.amd = e, i
}), function (t, e) {
    "use strict";
    var i, n, s = t.layui && layui.define, r = {
        getPath: function () {
            var t = document.scripts, e = t[t.length - 1], i = e.src;
            if (!e.getAttribute("merge")) return i.substring(0, i.lastIndexOf("/") + 1)
        }(),
        config: {},
        end: {},
        minIndex: 0,
        minLeft: [],
        btn: ["&#x786E;&#x5B9A;", "&#x53D6;&#x6D88;"],
        type: ["dialog", "page", "iframe", "loading", "tips"]
    }, o = {
        v: "3.0.3", ie: function () {
            var e = navigator.userAgent.toLowerCase();
            return !!(t.ActiveXObject || "ActiveXObject" in t) && ((e.match(/msie\s(\d+)/) || [])[1] || "11")
        }(), index: t.layer && t.layer.v ? 1e5 : 0, path: r.getPath, config: function (t, e) {
            return t = t || {}, o.cache = r.config = i.extend({}, r.config, t), o.path = r.config.path || o.path, "string" == typeof t.extend && (t.extend = [t.extend]), r.config.path && o.ready(), t.extend ? (s ? layui.addcss("modules/layer/" + t.extend) : o.link("skin/" + t.extend), this) : this
        }, link: function (e, n, s) {
            if (o.path) {
                var r = i("head")[0], a = document.createElement("link");
                "string" == typeof n && (s = n);
                var l = (s || e).replace(/\.|\//g, ""), c = "layuicss-" + l, u = 0;
                a.rel = "stylesheet", a.href = o.path + e, a.id = c, i("#" + c)[0] || r.appendChild(a), "function" == typeof n && function e() {
                    return ++u > 80 ? t.console && console.error("layer.css: Invalid") : void(1989 === parseInt(i("#" + c).css("width")) ? n() : setTimeout(e, 100))
                }()
            }
        }, ready: function (t) {
            var e = "skinlayercss";
            return s ? layui.addcss("modules/layer/default/layer.css?v=" + o.v + "303", t, e) : o.link("skin/default/layer.css?v=" + o.v + "303", t, e), this
        }, alert: function (t, e, n) {
            var s = "function" == typeof e;
            return s && (n = e), o.open(i.extend({content: t, yes: n}, s ? {} : e))
        }, confirm: function (t, e, n, s) {
            var a = "function" == typeof e;
            return a && (s = n, n = e), o.open(i.extend({content: t, btn: r.btn, yes: n, btn2: s}, a ? {} : e))
        }, msg: function (t, e, n) {
            var s = "function" == typeof e, a = r.config.skin, c = (a ? a + " " + a + "-msg" : "") || "layui-layer-msg",
                u = l.anim.length - 1;
            return s && (n = e), o.open(i.extend({
                content: t,
                time: 3e3,
                shade: !1,
                skin: c,
                title: !1,
                closeBtn: !1,
                btn: !1,
                resize: !1,
                end: n
            }, s && !r.config.skin ? {skin: c + " layui-layer-hui", anim: u} : function () {
                return e = e || {}, (-1 === e.icon || void 0 === e.icon && !r.config.skin) && (e.skin = c + " " + (e.skin || "layui-layer-hui")), e
            }()))
        }, load: function (t, e) {
            return o.open(i.extend({type: 3, icon: t || 0, resize: !1, shade: .01}, e))
        }, tips: function (t, e, n) {
            return o.open(i.extend({
                type: 4,
                content: [t, e],
                closeBtn: !1,
                time: 3e3,
                shade: !1,
                resize: !1,
                fixed: !1,
                maxWidth: 210
            }, n))
        }
    }, a = function (t) {
        var e = this;
        e.index = ++o.index, e.config = i.extend({}, e.config, r.config, t), document.body ? e.creat() : setTimeout(function () {
            e.creat()
        }, 30)
    };
    a.pt = a.prototype;
    var l = ["layui-layer", ".layui-layer-title", ".layui-layer-main", ".layui-layer-dialog", "layui-layer-iframe", "layui-layer-content", "layui-layer-btn", "layui-layer-close"];
    l.anim = ["layer-anim", "layer-anim-01", "layer-anim-02", "layer-anim-03", "layer-anim-04", "layer-anim-05", "layer-anim-06"], a.pt.config = {
        type: 0,
        shade: .3,
        fixed: !0,
        move: l[1],
        title: "&#x4FE1;&#x606F;",
        offset: "auto",
        area: "auto",
        closeBtn: 1,
        time: 0,
        zIndex: 19891014,
        maxWidth: 360,
        anim: 0,
        isOutAnim: !0,
        icon: -1,
        moveType: 1,
        resize: !0,
        scrollbar: !0,
        tips: 2
    }, a.pt.vessel = function (t, e) {
        var n = this, s = n.index, o = n.config, a = o.zIndex + s, c = "object" == typeof o.title,
            u = o.maxmin && (1 === o.type || 2 === o.type),
            h = o.title ? '<div class="layui-layer-title" style="' + (c ? o.title[1] : "") + '">' + (c ? o.title[0] : o.title) + "</div>" : "";
        return o.zIndex = a, e([o.shade ? '<div class="layui-layer-shade" id="layui-layer-shade' + s + '" times="' + s + '" style="z-index:' + (a - 1) + "; background-color:" + (o.shade[1] || "#000") + "; opacity:" + (o.shade[0] || o.shade) + "; filter:alpha(opacity=" + (100 * o.shade[0] || 100 * o.shade) + ');"></div>' : "", '<div class="' + l[0] + " layui-layer-" + r.type[o.type] + (0 != o.type && 2 != o.type || o.shade ? "" : " layui-layer-border") + " " + (o.skin || "") + '" id="' + l[0] + s + '" type="' + r.type[o.type] + '" times="' + s + '" showtime="' + o.time + '" conType="' + (t ? "object" : "string") + '" style="z-index: ' + a + "; width:" + o.area[0] + ";height:" + o.area[1] + (o.fixed ? "" : ";position:absolute;") + '">' + (t && 2 != o.type ? "" : h) + '<div id="' + (o.id || "") + '" class="layui-layer-content' + (0 == o.type && -1 !== o.icon ? " layui-layer-padding" : "") + (3 == o.type ? " layui-layer-loading" + o.icon : "") + '">' + (0 == o.type && -1 !== o.icon ? '<i class="layui-layer-ico layui-layer-ico' + o.icon + '"></i>' : "") + (1 == o.type && t ? "" : o.content || "") + '</div><span class="layui-layer-setwin">' + function () {
            var t = u ? '<a class="layui-layer-min" href="javascript:;"><cite></cite></a><a class="layui-layer-ico layui-layer-max" href="javascript:;"></a>' : "";
            return o.closeBtn && (t += '<a class="layui-layer-ico ' + l[7] + " " + l[7] + (o.title ? o.closeBtn : 4 == o.type ? "1" : "2") + '" href="javascript:;"></a>'), t
        }() + "</span>" + (o.btn ? function () {
            var t = "";
            "string" == typeof o.btn && (o.btn = [o.btn]);
            for (var e = 0, i = o.btn.length; e < i; e++) t += '<a class="' + l[6] + e + '">' + o.btn[e] + "</a>";
            return '<div class="' + l[6] + " layui-layer-btn-" + (o.btnAlign || "") + '">' + t + "</div>"
        }() : "") + (o.resize ? '<span class="layui-layer-resize"></span>' : "") + "</div>"], h, i('<div class="layui-layer-move"></div>')), n
    }, a.pt.creat = function () {
        var t = this, e = t.config, s = t.index, a = e.content, c = "object" == typeof a, u = i("body");
        if (!e.id || !i("#" + e.id)[0]) {
            switch ("string" == typeof e.area && (e.area = "auto" === e.area ? ["", ""] : [e.area, ""]), e.shift && (e.anim = e.shift), 6 == o.ie && (e.fixed = !1), e.type) {
                case 0:
                    e.btn = "btn" in e ? e.btn : r.btn[0], o.closeAll("dialog");
                    break;
                case 2:
                    var a = e.content = c ? e.content : [e.content, "auto"];
                    e.content = '<iframe scrolling="' + (e.content[1] || "auto") + '" allowtransparency="true" id="' + l[4] + s + '" name="' + l[4] + s + '" onload="this.className=\'\';" class="layui-layer-load" frameborder="0" src="' + e.content[0] + '"></iframe>';
                    break;
                case 3:
                    delete e.title, delete e.closeBtn, -1 === e.icon && e.icon, o.closeAll("loading");
                    break;
                case 4:
                    c || (e.content = [e.content, "body"]), e.follow = e.content[1], e.content = e.content[0] + '<i class="layui-layer-TipsG"></i>', delete e.title, e.tips = "object" == typeof e.tips ? e.tips : [e.tips, !0], e.tipsMore || o.closeAll("tips")
            }
            t.vessel(c, function (n, o, h) {
                u.append(n[0]), c ? function () {
                    2 == e.type || 4 == e.type ? function () {
                        i("body").append(n[1])
                    }() : function () {
                        a.parents("." + l[0])[0] || (a.data("display", a.css("display")).show().addClass("layui-layer-wrap").wrap(n[1]), i("#" + l[0] + s).find("." + l[5]).before(o))
                    }()
                }() : u.append(n[1]), i(".layui-layer-move")[0] || u.append(r.moveElem = h), t.layero = i("#" + l[0] + s), e.scrollbar || l.html.css("overflow", "hidden").attr("layer-full", s)
            }).auto(s), 2 == e.type && 6 == o.ie && t.layero.find("iframe").attr("src", a[0]), 4 == e.type ? t.tips() : t.offset(), e.fixed && n.on("resize", function () {
                t.offset(), (/^\d+%$/.test(e.area[0]) || /^\d+%$/.test(e.area[1])) && t.auto(s), 4 == e.type && t.tips()
            }), e.time <= 0 || setTimeout(function () {
                o.close(t.index)
            }, e.time), t.move().callback(), l.anim[e.anim] && t.layero.addClass(l.anim[e.anim]), e.isOutAnim && t.layero.data("isOutAnim", !0)
        }
    }, a.pt.auto = function (t) {
        function e(t) {
            t = a.find(t), t.height(c[1] - u - h - 2 * (0 | parseFloat(t.css("padding-top"))))
        }

        var s = this, r = s.config, a = i("#" + l[0] + t);
        "" === r.area[0] && r.maxWidth > 0 && (o.ie && o.ie < 8 && r.btn && a.width(a.innerWidth()), a.outerWidth() > r.maxWidth && a.width(r.maxWidth));
        var c = [a.innerWidth(), a.innerHeight()], u = a.find(l[1]).outerHeight() || 0,
            h = a.find("." + l[6]).outerHeight() || 0;
        switch (r.type) {
            case 2:
                e("iframe");
                break;
            default:
                "" === r.area[1] ? r.fixed && c[1] >= n.height() && (c[1] = n.height(), e("." + l[5])) : e("." + l[5])
        }
        return s
    }, a.pt.offset = function () {
        var t = this, e = t.config, i = t.layero, s = [i.outerWidth(), i.outerHeight()],
            r = "object" == typeof e.offset;
        t.offsetTop = (n.height() - s[1]) / 2, t.offsetLeft = (n.width() - s[0]) / 2, r ? (t.offsetTop = e.offset[0], t.offsetLeft = e.offset[1] || t.offsetLeft) : "auto" !== e.offset && ("t" === e.offset ? t.offsetTop = 0 : "r" === e.offset ? t.offsetLeft = n.width() - s[0] : "b" === e.offset ? t.offsetTop = n.height() - s[1] : "l" === e.offset ? t.offsetLeft = 0 : "lt" === e.offset ? (t.offsetTop = 0, t.offsetLeft = 0) : "lb" === e.offset ? (t.offsetTop = n.height() - s[1], t.offsetLeft = 0) : "rt" === e.offset ? (t.offsetTop = 0, t.offsetLeft = n.width() - s[0]) : "rb" === e.offset ? (t.offsetTop = n.height() - s[1], t.offsetLeft = n.width() - s[0]) : t.offsetTop = e.offset), e.fixed || (t.offsetTop = /%$/.test(t.offsetTop) ? n.height() * parseFloat(t.offsetTop) / 100 : parseFloat(t.offsetTop), t.offsetLeft = /%$/.test(t.offsetLeft) ? n.width() * parseFloat(t.offsetLeft) / 100 : parseFloat(t.offsetLeft), t.offsetTop += n.scrollTop(), t.offsetLeft += n.scrollLeft()), i.attr("minLeft") && (t.offsetTop = n.height() - (i.find(l[1]).outerHeight() || 0), t.offsetLeft = i.css("left")), i.css({
            top: t.offsetTop,
            left: t.offsetLeft
        })
    }, a.pt.tips = function () {
        var t = this, e = t.config, s = t.layero, r = [s.outerWidth(), s.outerHeight()], o = i(e.follow);
        o[0] || (o = i("body"));
        var a = {width: o.outerWidth(), height: o.outerHeight(), top: o.offset().top, left: o.offset().left},
            c = s.find(".layui-layer-TipsG"), u = e.tips[0];
        e.tips[1] || c.remove(), a.autoLeft = function () {
            a.left + r[0] - n.width() > 0 ? (a.tipLeft = a.left + a.width - r[0], c.css({
                right: 12,
                left: "auto"
            })) : a.tipLeft = a.left
        }, a.where = [function () {
            a.autoLeft(), a.tipTop = a.top - r[1] - 10, c.removeClass("layui-layer-TipsB").addClass("layui-layer-TipsT").css("border-right-color", e.tips[1])
        }, function () {
            a.tipLeft = a.left + a.width + 10, a.tipTop = a.top, c.removeClass("layui-layer-TipsL").addClass("layui-layer-TipsR").css("border-bottom-color", e.tips[1])
        }, function () {
            a.autoLeft(), a.tipTop = a.top + a.height + 10, c.removeClass("layui-layer-TipsT").addClass("layui-layer-TipsB").css("border-right-color", e.tips[1])
        }, function () {
            a.tipLeft = a.left - r[0] - 10, a.tipTop = a.top, c.removeClass("layui-layer-TipsR").addClass("layui-layer-TipsL").css("border-bottom-color", e.tips[1])
        }], a.where[u - 1](), 1 === u ? a.top - (n.scrollTop() + r[1] + 16) < 0 && a.where[2]() : 2 === u ? n.width() - (a.left + a.width + r[0] + 16) > 0 || a.where[3]() : 3 === u ? a.top - n.scrollTop() + a.height + r[1] + 16 - n.height() > 0 && a.where[0]() : 4 === u && r[0] + 16 - a.left > 0 && a.where[1](), s.find("." + l[5]).css({
            "background-color": e.tips[1],
            "padding-right": e.closeBtn ? "30px" : ""
        }), s.css({left: a.tipLeft - (e.fixed ? n.scrollLeft() : 0), top: a.tipTop - (e.fixed ? n.scrollTop() : 0)})
    }, a.pt.move = function () {
        var t = this, e = t.config, s = i(document), a = t.layero, l = a.find(e.move),
            c = a.find(".layui-layer-resize"), u = {};
        return e.move && l.css("cursor", "move"), l.on("mousedown", function (t) {
            t.preventDefault(), e.move && (u.moveStart = !0, u.offset = [t.clientX - parseFloat(a.css("left")), t.clientY - parseFloat(a.css("top"))], r.moveElem.css("cursor", "move").show())
        }), c.on("mousedown", function (t) {
            t.preventDefault(), u.resizeStart = !0, u.offset = [t.clientX, t.clientY], u.area = [a.outerWidth(), a.outerHeight()], r.moveElem.css("cursor", "se-resize").show()
        }), s.on("mousemove", function (i) {
            if (u.moveStart) {
                var s = i.clientX - u.offset[0], r = i.clientY - u.offset[1], l = "fixed" === a.css("position");
                if (i.preventDefault(), u.stX = l ? 0 : n.scrollLeft(), u.stY = l ? 0 : n.scrollTop(), !e.moveOut) {
                    var c = n.width() - a.outerWidth() + u.stX, h = n.height() - a.outerHeight() + u.stY;
                    s < u.stX && (s = u.stX), s > c && (s = c), r < u.stY && (r = u.stY), r > h && (r = h)
                }
                a.css({left: s, top: r})
            }
            if (e.resize && u.resizeStart) {
                var s = i.clientX - u.offset[0], r = i.clientY - u.offset[1];
                i.preventDefault(), o.style(t.index, {
                    width: u.area[0] + s,
                    height: u.area[1] + r
                }), u.isResize = !0, e.resizing && e.resizing(a)
            }
        }).on("mouseup", function (t) {
            u.moveStart && (delete u.moveStart, r.moveElem.hide(), e.moveEnd && e.moveEnd(a)), u.resizeStart && (delete u.resizeStart, r.moveElem.hide())
        }), t
    }, a.pt.callback = function () {
        function t() {
            !1 === (s.cancel && s.cancel(e.index, n)) || o.close(e.index)
        }

        var e = this, n = e.layero, s = e.config;
        e.openLayer(), s.success && (2 == s.type ? n.find("iframe").on("load", function () {
            s.success(n, e.index)
        }) : s.success(n, e.index)), 6 == o.ie && e.IE6(n), n.find("." + l[6]).children("a").on("click", function () {
            var t = i(this).index();
            if (0 === t) s.yes ? s.yes(e.index, n) : s.btn1 ? s.btn1(e.index, n) : o.close(e.index); else {
                !1 === (s["btn" + (t + 1)] && s["btn" + (t + 1)](e.index, n)) || o.close(e.index)
            }
        }), n.find("." + l[7]).on("click", t), s.shadeClose && i("#layui-layer-shade" + e.index).on("click", function () {
            o.close(e.index)
        }), n.find(".layui-layer-min").on("click", function () {
            !1 === (s.min && s.min(n)) || o.min(e.index, s)
        }), n.find(".layui-layer-max").on("click", function () {
            i(this).hasClass("layui-layer-maxmin") ? (o.restore(e.index), s.restore && s.restore(n)) : (o.full(e.index, s), setTimeout(function () {
                s.full && s.full(n)
            }, 100))
        }), s.end && (r.end[e.index] = s.end)
    }, r.reselect = function () {
        i.each(i("select"), function (t, e) {
            var n = i(this);
            n.parents("." + l[0])[0] || 1 == n.attr("layer") && i("." + l[0]).length < 1 && n.removeAttr("layer").show(), n = null
        })
    }, a.pt.IE6 = function (t) {
        i("select").each(function (t, e) {
            var n = i(this);
            n.parents("." + l[0])[0] || "none" === n.css("display") || n.attr({layer: "1"}).hide(), n = null
        })
    }, a.pt.openLayer = function () {
        var t = this;
        o.zIndex = t.config.zIndex, o.setTop = function (t) {
            var e = function () {
                o.zIndex++, t.css("z-index", o.zIndex + 1)
            };
            return o.zIndex = parseInt(t[0].style.zIndex), t.on("mousedown", e), o.zIndex
        }
    }, r.record = function (t) {
        var e = [t.width(), t.height(), t.position().top, t.position().left + parseFloat(t.css("margin-left"))];
        t.find(".layui-layer-max").addClass("layui-layer-maxmin"), t.attr({area: e})
    }, r.rescollbar = function (t) {
        l.html.attr("layer-full") == t && (l.html[0].style.removeProperty ? l.html[0].style.removeProperty("overflow") : l.html[0].style.removeAttribute("overflow"), l.html.removeAttr("layer-full"))
    }, t.layer = o, o.getChildFrame = function (t, e) {
        return e = e || i("." + l[4]).attr("times"), i("#" + l[0] + e).find("iframe").contents().find(t)
    }, o.getFrameIndex = function (t) {
        return i("#" + t).parents("." + l[4]).attr("times")
    }, o.iframeAuto = function (t) {
        if (t) {
            var e = o.getChildFrame("html", t).outerHeight(), n = i("#" + l[0] + t),
                s = n.find(l[1]).outerHeight() || 0, r = n.find("." + l[6]).outerHeight() || 0;
            n.css({height: e + s + r}), n.find("iframe").css({height: e})
        }
    }, o.iframeSrc = function (t, e) {
        i("#" + l[0] + t).find("iframe").attr("src", e)
    }, o.style = function (t, e, n) {
        var s = i("#" + l[0] + t), o = s.find(".layui-layer-content"), a = s.attr("type"),
            c = s.find(l[1]).outerHeight() || 0, u = s.find("." + l[6]).outerHeight() || 0;
        s.attr("minLeft"), a !== r.type[3] && a !== r.type[4] && (n || (parseFloat(e.width) <= 260 && (e.width = 260), parseFloat(e.height) - c - u <= 64 && (e.height = 64 + c + u)), s.css(e), u = s.find("." + l[6]).outerHeight(), a === r.type[2] ? s.find("iframe").css({height: parseFloat(e.height) - c - u}) : o.css({height: parseFloat(e.height) - c - u - parseFloat(o.css("padding-top")) - parseFloat(o.css("padding-bottom"))}))
    }, o.min = function (t, e) {
        var s = i("#" + l[0] + t), a = s.find(l[1]).outerHeight() || 0,
            c = s.attr("minLeft") || 181 * r.minIndex + "px", u = s.css("position");
        r.record(s), r.minLeft[0] && (c = r.minLeft[0], r.minLeft.shift()), s.attr("position", u), o.style(t, {
            width: 180,
            height: a,
            left: c,
            top: n.height() - a,
            position: "fixed",
            overflow: "hidden"
        }, !0), s.find(".layui-layer-min").hide(), "page" === s.attr("type") && s.find(l[4]).hide(), r.rescollbar(t), s.attr("minLeft") || r.minIndex++, s.attr("minLeft", c)
    }, o.restore = function (t) {
        var e = i("#" + l[0] + t), n = e.attr("area").split(",");
        e.attr("type"), o.style(t, {
            width: parseFloat(n[0]),
            height: parseFloat(n[1]),
            top: parseFloat(n[2]),
            left: parseFloat(n[3]),
            position: e.attr("position"),
            overflow: "visible"
        }, !0), e.find(".layui-layer-max").removeClass("layui-layer-maxmin"), e.find(".layui-layer-min").show(), "page" === e.attr("type") && e.find(l[4]).show(), r.rescollbar(t)
    }, o.full = function (t) {
        var e, s = i("#" + l[0] + t);
        r.record(s), l.html.attr("layer-full") || l.html.css("overflow", "hidden").attr("layer-full", t), clearTimeout(e), e = setTimeout(function () {
            var e = "fixed" === s.css("position");
            o.style(t, {
                top: e ? 0 : n.scrollTop(),
                left: e ? 0 : n.scrollLeft(),
                width: n.width(),
                height: n.height()
            }, !0), s.find(".layui-layer-min").hide()
        }, 100)
    }, o.title = function (t, e) {
        i("#" + l[0] + (e || o.index)).find(l[1]).html(t)
    }, o.close = function (t) {
        var e = i("#" + l[0] + t), n = e.attr("type");
        if (e[0]) {
            var s = "layui-layer-wrap", a = function () {
                if (n === r.type[1] && "object" === e.attr("conType")) {
                    e.children(":not(." + l[5] + ")").remove();
                    for (var o = e.find("." + s), a = 0; a < 2; a++) o.unwrap();
                    o.css("display", o.data("display")).removeClass(s)
                } else {
                    if (n === r.type[2]) try {
                        var c = i("#" + l[4] + t)[0];
                        c.contentWindow.document.write(""), c.contentWindow.close(), e.find("." + l[5])[0].removeChild(c)
                    } catch (t) {
                    }
                    e[0].innerHTML = "", e.remove()
                }
                "function" == typeof r.end[t] && r.end[t](), delete r.end[t]
            };
            e.data("isOutAnim") && e.addClass("layer-anim-close"), i("#layui-layer-moves, #layui-layer-shade" + t).remove(), 6 == o.ie && r.reselect(), r.rescollbar(t), e.attr("minLeft") && (r.minIndex--, r.minLeft.push(e.attr("minLeft"))), o.ie && o.ie < 10 || !e.data("isOutAnim") ? a() : setTimeout(function () {
                a()
            }, 200)
        }
    }, o.closeAll = function (t) {
        i.each(i("." + l[0]), function () {
            var e = i(this), n = t ? e.attr("type") === t : 1;
            n && o.close(e.attr("times")), n = null
        })
    };
    var c = o.cache || {}, u = function (t) {
        return c.skin ? " " + c.skin + " " + c.skin + "-" + t : ""
    };
    o.prompt = function (t, e) {
        var s = "";
        if (t = t || {}, "function" == typeof t && (e = t), t.area) {
            var r = t.area;
            s = 'style="width: ' + r[0] + "; height: " + r[1] + ';"', delete t.area
        }
        var a,
            l = 2 == t.formType ? '<textarea class="layui-layer-input"' + s + ">" + (t.value || "") + "</textarea>" : function () {
                return '<input type="' + (1 == t.formType ? "password" : "text") + '" class="layui-layer-input" value="' + (t.value || "") + '">'
            }(), c = t.success;
        return delete t.success, o.open(i.extend({
            type: 1,
            btn: ["&#x786E;&#x5B9A;", "&#x53D6;&#x6D88;"],
            content: l,
            skin: "layui-layer-prompt" + u("prompt"),
            maxWidth: n.width(),
            success: function (t) {
                a = t.find(".layui-layer-input"), a.focus(), "function" == typeof c && c(t)
            },
            resize: !1,
            yes: function (i) {
                var n = a.val();
                "" === n ? a.focus() : n.length > (t.maxlength || 500) ? o.tips("&#x6700;&#x591A;&#x8F93;&#x5165;" + (t.maxlength || 500) + "&#x4E2A;&#x5B57;&#x6570;", a, {tips: 1}) : e && e(n, i, a)
            }
        }, t))
    }, o.tab = function (t) {
        t = t || {};
        var e = t.tab || {}, n = t.success;
        return delete t.success, o.open(i.extend({
            type: 1,
            skin: "layui-layer-tab" + u("tab"),
            resize: !1,
            title: function () {
                var t = e.length, i = 1, n = "";
                if (t > 0) for (n = '<span class="layui-layer-tabnow">' + e[0].title + "</span>"; i < t; i++) n += "<span>" + e[i].title + "</span>";
                return n
            }(),
            content: '<ul class="layui-layer-tabmain">' + function () {
                var t = e.length, i = 1, n = "";
                if (t > 0) for (n = '<li class="layui-layer-tabli xubox_tab_layer">' + (e[0].content || "no content") + "</li>"; i < t; i++) n += '<li class="layui-layer-tabli">' + (e[i].content || "no  content") + "</li>";
                return n
            }() + "</ul>",
            success: function (e) {
                var s = e.find(".layui-layer-title").children(), r = e.find(".layui-layer-tabmain").children();
                s.on("mousedown", function (e) {
                    e.stopPropagation ? e.stopPropagation() : e.cancelBubble = !0;
                    var n = i(this), s = n.index();
                    n.addClass("layui-layer-tabnow").siblings().removeClass("layui-layer-tabnow"), r.eq(s).show().siblings().hide(), "function" == typeof t.change && t.change(s)
                }), "function" == typeof n && n(e)
            }
        }, t))
    }, o.photos = function (e, n, s) {
        var r = {};
        if (e = e || {}, e.photos) {
            var a = e.photos.constructor === Object, l = a ? e.photos : {}, c = l.data || [], h = l.start || 0;
            r.imgIndex = 1 + (0 | h), e.img = e.img || "img";
            var d = e.success;
            if (delete e.success, a) {
                if (0 === c.length) return o.msg("&#x6CA1;&#x6709;&#x56FE;&#x7247;")
            } else {
                var p = i(e.photos), f = function () {
                    c = [], p.find(e.img).each(function (t) {
                        var e = i(this);
                        e.attr("layer-index", t), c.push({
                            alt: e.attr("alt"),
                            pid: e.attr("layer-pid"),
                            src: e.attr("layer-src") || e.attr("src"),
                            thumb: e.attr("src")
                        })
                    })
                };
                if (f(), 0 === c.length) return;
                if (n || p.on("click", e.img, function () {
                    var t = i(this), n = t.attr("layer-index");
                    o.photos(i.extend(e, {photos: {start: n, data: c, tab: e.tab}, full: e.full}), !0), f()
                }), !n) return
            }
            r.imgprev = function (t) {
                r.imgIndex--, r.imgIndex < 1 && (r.imgIndex = c.length), r.tabimg(t)
            }, r.imgnext = function (t, e) {
                ++r.imgIndex > c.length && (r.imgIndex = 1, e) || r.tabimg(t)
            }, r.keyup = function (t) {
                if (!r.end) {
                    var e = t.keyCode;
                    t.preventDefault(), 37 === e ? r.imgprev(!0) : 39 === e ? r.imgnext(!0) : 27 === e && o.close(r.index)
                }
            }, r.tabimg = function (t) {
                if (!(c.length <= 1)) return l.start = r.imgIndex - 1, o.close(r.index), o.photos(e, !0, t)
            }, r.event = function () {
                r.bigimg.hover(function () {
                    r.imgsee.show()
                }, function () {
                    r.imgsee.hide()
                }), r.bigimg.find(".layui-layer-imgprev").on("click", function (t) {
                    t.preventDefault(), r.imgprev()
                }), r.bigimg.find(".layui-layer-imgnext").on("click", function (t) {
                    t.preventDefault(), r.imgnext()
                }), i(document).on("keyup", r.keyup)
            }, r.loadi = o.load(1, {shade: !("shade" in e) && .9, scrollbar: !1}), function (t, e, i) {
                var n = new Image;
                return n.src = t, n.complete ? e(n) : (n.onload = function () {
                    n.onload = null, e(n)
                }, void(n.onerror = function (t) {
                    n.onerror = null, i(t)
                }))
            }(c[h].src, function (n) {
                o.close(r.loadi), r.index = o.open(i.extend({
                    type: 1,
                    id: "layui-layer-photos",
                    area: function () {
                        var s = [n.width, n.height], r = [i(t).width() - 100, i(t).height() - 100];
                        if (!e.full && (s[0] > r[0] || s[1] > r[1])) {
                            var o = [s[0] / r[0], s[1] / r[1]];
                            o[0] > o[1] ? (s[0] = s[0] / o[0], s[1] = s[1] / o[0]) : o[0] < o[1] && (s[0] = s[0] / o[1], s[1] = s[1] / o[1])
                        }
                        return [s[0] + "px", s[1] + "px"]
                    }(),
                    title: !1,
                    shade: .9,
                    shadeClose: !0,
                    closeBtn: !1,
                    move: ".layui-layer-phimg img",
                    moveType: 1,
                    scrollbar: !1,
                    moveOut: !0,
                    isOutAnim: !1,
                    skin: "layui-layer-photos" + u("photos"),
                    content: '<div class="layui-layer-phimg"><img src="' + c[h].src + '" alt="' + (c[h].alt || "") + '" layer-pid="' + c[h].pid + '"><div class="layui-layer-imgsee">' + (c.length > 1 ? '<span class="layui-layer-imguide"><a href="javascript:;" class="layui-layer-iconext layui-layer-imgprev"></a><a href="javascript:;" class="layui-layer-iconext layui-layer-imgnext"></a></span>' : "") + '<div class="layui-layer-imgbar" style="display:' + (s ? "block" : "") + '"><span class="layui-layer-imgtit"><a href="javascript:;">' + (c[h].alt || "") + "</a><em>" + r.imgIndex + "/" + c.length + "</em></span></div></div></div>",
                    success: function (t, i) {
                        r.bigimg = t.find(".layui-layer-phimg"), r.imgsee = t.find(".layui-layer-imguide,.layui-layer-imgbar"), r.event(t), e.tab && e.tab(c[h], t), "function" == typeof d && d(t)
                    },
                    end: function () {
                        r.end = !0, i(document).off("keyup", r.keyup)
                    }
                }, e))
            }, function () {
                o.close(r.loadi), o.msg("&#x5F53;&#x524D;&#x56FE;&#x7247;&#x5730;&#x5740;&#x5F02;&#x5E38;<br>&#x662F;&#x5426;&#x7EE7;&#x7EED;&#x67E5;&#x770B;&#x4E0B;&#x4E00;&#x5F20;&#xFF1F;", {
                    time: 3e4,
                    btn: ["&#x4E0B;&#x4E00;&#x5F20;", "&#x4E0D;&#x770B;&#x4E86;"],
                    yes: function () {
                        c.length > 1 && r.imgnext(!0, !0)
                    }
                })
            })
        }
    }, r.run = function (e) {
        i = e, n = i(t), l.html = i("html"), o.open = function (t) {
            return new a(t).index
        }
    }, t.layui && layui.define ? (o.ready(), layui.define("jquery", function (e) {
        o.path = layui.cache.dir, r.run(layui.jquery), t.layer = o, e("layer", o)
    })) : "function" == typeof define && define.amd ? define(["jquery"], function () {
        return r.run(t.jQuery), o
    }) : function () {
        r.run(t.jQuery), o.ready()
    }()
}(window);