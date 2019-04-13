(function(b) {
    var a = [];
    b.fn.imglazyload = function(c) {
        var g = Array.prototype.splice,
        c = b.extend({
            threshold: 0,
            container: window,
            urlName: "data-url",
            placeHolder: "",
            eventName: "scrollStop",
            innerScroll: false,
            isVertical: true
        },
        c),
        l = b(c.container),
        m = c.isVertical,
        f = b.isWindow(l.get(0)),
        h = {
            win: [m ? "scrollY": "scrollX", m ? "innerHeight": "innerWidth"],
            img: [m ? "top": "left", m ? "height": "width"]
        },
        d = b(c.placeHolder).length ? b(c.placeHolder) : null,
        i = b(this).is("img"); ! f && (h.win = h.img);
        function n(r) {
            var q = f ? window: l.offset(),
            o = q[h.win[0]],
            p = q[h.win[1]];
            return o >= r[h.img[0]] - c.threshold - p && o <= r[h.img[0]] + r[h.img[1]]
        }
        a = Array.prototype.slice.call(b(a.reverse()).add(this), 0).reverse();
        if (b.isFunction(b.fn.imglazyload.detect)) {
            e();
            return this
        }
        function k(r) {
            var p = b(r),
            o = {},
            q = p;
            if (!i) {
                b.each(p.get(0).attributes,
                function() {~this.name.indexOf("data-") && (o[this.name] = this.value)
                });
                q = b("<img />").attr(o)
            }
            p.trigger("startload");
            q.on("load",
            function() { ! i && p.replaceWith(q);
                p.trigger("loadcomplete");
                q.off("load")
            }).on("error",
            function() {
                var s = b.Event("error");
                p.trigger(s);
                s.defaultPrevented || a.push(r);
                q.off("error").remove()
            }).attr("src", p.attr(c.urlName))
        }
        function j() {
            var o, p, q, r;
            for (o = a.length; o--;) {
                p = b(r = a[o]);
                q = p.offset();
                n(q) && (g.call(a, o, 1), k(r))
            }
        }
        function e() { ! i && d && b(a).append(d)
        }
        b(document).ready(function() {
            e();
            j()
        }); ! c.innerScroll && b(window).on(c.eventName + " ortchange",
        function() {
            j()
        });
        b.fn.imglazyload.detect = j;
        return this
    }
})(Zepto);