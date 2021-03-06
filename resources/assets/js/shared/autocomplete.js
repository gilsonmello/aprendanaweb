! function(t) {
    "use strict";
    var e = function(e, s) {
        if (this.$element = t(e), this.options = t.extend(!0, {}, t.fn.typeahead.defaults, s), this.$menu = t(this.options.menu).appendTo("body"), this.shown = !1, this.eventSupported = this.options.eventSupported || this.eventSupported, this.grepper = this.options.grepper || this.grepper, this.highlighter = this.options.highlighter || this.highlighter, this.lookup = this.options.lookup || this.lookup, this.matcher = this.options.matcher || this.matcher, this.render = this.options.render || this.render, this.select = this.options.select || this.select, this.sorter = this.options.sorter || this.sorter, this.source = this.options.source || this.source, !this.source.length) {
            var i = this.options.ajax;
            this.ajax = "string" == typeof i ? t.extend({}, t.fn.typeahead.defaults.ajax, {
                url: i
            }) : t.extend({}, t.fn.typeahead.defaults.ajax, i), this.ajax.url || (this.ajax = null)
        }
        this.listen()
    };
    e.prototype = {
        constructor: e,
        eventSupported: function(t) {
            var e = t in this.$element;
            return e || (this.$element.setAttribute(t, "return;"), e = "function" == typeof this.$element[t]), e
        },
        ajaxer: function() {
            console.log('ajaxer');
            var e = this,
                s = e.$element.val();
            return s === e.query ? e : (e.query = s, e.ajax.timerId && (clearTimeout(e.ajax.timerId), e.ajax.timerId = null), !s || s.length < e.ajax.triggerLength ? (e.ajax.xhr && (e.ajax.xhr.abort(), e.ajax.xhr = null, e.ajaxToggleLoadClass(!1)), e.shown ? e.hide() : e) : (e.ajax.timerId = setTimeout(function() {
                t.proxy(e.ajaxExecute(s), e)
            }, e.ajax.timeout), e))
        },
        ajaxExecute: function(e) {
            console.log('ajaxExecute');
            this.ajaxToggleLoadClass(!0), this.ajax.xhr && this.ajax.xhr.abort();
            var s = this.ajax.preDispatch ? this.ajax.preDispatch(e) : {
                    query: e
                },
                i = "post" === this.ajax.method ? t.post : t.get;
            this.ajax.xhr = i(this.ajax.url, s, t.proxy(this.ajaxLookup, this)), this.ajax.timerId = null
        },
        ajaxLookup: function(t) {
            console.log('ajaxLookup');
            var e;
            return this.ajaxToggleLoadClass(!1), this.ajax.xhr ? (this.ajax.preProcess && (t = this.ajax.preProcess(t)), this.ajax.data = t, e = this.grepper(this.ajax.data), e && e.length ? (this.ajax.xhr = null, this.render(e.slice(0, this.options.items)).show()) : this.shown ? this.hide() : this) : void 0
        },
        ajaxToggleLoadClass: function(t) {
            console.log('ajaxToggleLoadClass');
            this.ajax.loadingClass && this.$element.toggleClass(this.ajax.loadingClass, t)
        },
        lookup: function() {
            console.log('lookup');
            var t, e = this;
            return e.ajax ? void e.ajaxer() : (e.query = e.$element.val(), e.query ? (t = e.grepper(e.source), t && t.length ? e.render(t.slice(0, e.options.items)).show() : e.shown ? e.hide() : e) : e.shown ? e.hide() : e)
        },
        grepper: function(e) {
            console.log('grepper');
            var s, i = this;
            return e && e.length && !e[0].hasOwnProperty(i.options.display) ? null : (s = t.grep(e, function(t) {
                return i.matcher(t[i.options.display], t)
            }), this.sorter(s))
        },
        matcher: function(t) {
            console.log('matcher');
            return ~t.toLowerCase().indexOf(this.query.toLowerCase())
        },
        sorter: function(t) {
            console.log('sorter');
            for (var e, s = this, i = [], a = [], n = []; e = t.shift();) e[s.options.display].toLowerCase().indexOf(this.query.toLowerCase()) ? ~e[s.options.display].indexOf(this.query) ? a.push(e) : n.push(e) : i.push(e);
            return i.concat(a, n)
        },
        show: function() {
            console.log('show');
            var e = t.extend({}, this.$element.offset(), {
                height: this.$element[0].offsetHeight
            });
            return this.$menu.css({
                top: e.top + e.height,
                left: e.left
            }), this.$menu.show(), this.shown = !0, this
        },
        hide: function() {
            console.log('hide');
            return this.$menu.hide(), this.shown = !1, this
        },
        highlighter: function(t) {
            console.log('highlighter');
            var e = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
            return t.replace(new RegExp("(" + e + ")", "ig"), function(t, e) {
                return "<strong>" + e + "</strong>"
            })
        },
        render: function(e) {
            console.log('render');
            var s = this;
            return e = t(e).map(function(e, i) {
                return e = t(s.options.item).attr("data-value", i[s.options.val]), e.find("a").html(s.highlighter(i[s.options.display], i)), e[0]
            }), e.first().addClass(""), this.$menu.html(e), this
            //}), e.first().addClass("active"), this.$menu.html(e), this
        },
        select: function() {
            var t = this.$menu.find(".active");
            if(t.text()){
                return this.$element.val(t.text()).change(), this.options.itemSelected(t, t.attr("data-value"), t.text()), this.hide()
            }else{
                return this.$element.val(this.$element[0].value).change(), this.options.itemSelected(t, t.attr("data-value"), this.$element[0].value), this.hide()
            }

        },
        next: function() {
            console.log('next');
            var e = this.$menu.find(".active").removeClass("active"),
                s = e.next();
            s.length || (s = t(this.$menu.find("li")[0])), s.addClass("active")
        },
        prev: function() {
            console.log('prev');
            var t = this.$menu.find(".active").removeClass("active"),
                e = t.prev();
            e.length || (e = this.$menu.find("li").last()), e.addClass("active")
        },
        listen: function() {
            console.log('listen');
            this.$element.on("blur", t.proxy(this.blur, this)).on("keyup", t.proxy(this.keyup, this)), this.eventSupported("keydown") ? this.$element.on("keydown", t.proxy(this.keypress, this)) : this.$element.on("keypress", t.proxy(this.keypress, this)), this.$menu.on("click", t.proxy(this.click, this)).on("mouseenter", "li", t.proxy(this.mouseenter, this))
        },
        keyup: function(t) {
            console.log('keyup');
            switch (t.stopPropagation(), t.preventDefault(), t.keyCode) {
                case 40:
                case 38:
                    break;
                case 9:
                case 13:
                    console.log(9, 13);
                    if (!this.shown) return;
                    this.select();
                    break;
                case 27:
                    this.hide();
                    break;
                default:
                    this.lookup()
            }
        },
        keypress: function(t) {
            console.log('keypress');
            if (t.stopPropagation(), this.shown) switch (t.keyCode) {
                case 9:
                case 13:
                case 27:
                    t.preventDefault();
                    break;
                case 38:
                    t.preventDefault(), this.prev();
                    break;
                case 40:
                    t.preventDefault(), this.next()
            }
        },
        blur: function(t) {
            console.log('blur');
            var e = this;
            t.stopPropagation(), t.preventDefault(), setTimeout(function() {
                e.$menu.is(":focus") || e.hide()
            }, 150)
        },
        click: function(t) {
            console.log('click');
            t.stopPropagation(), t.preventDefault(), this.select()
        },
        mouseenter: function(e) {
            console.log('mouseenter');
            this.$menu.find(".active").removeClass("active"), t(e.currentTarget).addClass("active")
        }
    }, t.fn.typeahead = function(s) {
        return this.each(function() {
            var i = t(this),
                a = i.data("typeahead"),
                n = "object" == typeof s && s;
            a || i.data("typeahead", a = new e(this, n)), "string" == typeof s && a[s]()
        })
    }, t.fn.typeahead.defaults = {
        source: [],
        items: 8,
        menu: '<ul class="typeahead dropdown-menu"></ul>',
        item: '<li><a href="#"></a></li>',
        display: "name",
        val: "id",
        itemSelected: function() {},
        ajax: {
            url: null,
            timeout: 300,
            method: "post",
            triggerLength: 3,
            loadingClass: null,
            displayField: null,
            preDispatch: null,
            preProcess: null
        }
    }, t.fn.typeahead.Constructor = e, t(function() {
        t("body").on("focus.typeahead.data-api", '[data-provide="typeahead"]', function(e) {
            var s = t(this);
            s.data("typeahead") || (e.preventDefault(), s.typeahead(s.data()))
        })
    })
}(window.jQuery);