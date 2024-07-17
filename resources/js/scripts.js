document.addEventListener("DOMContentLoaded", (function() {
    if (document.querySelectorAll('.color input[type="radio"]').forEach((e => {
        let t = e.value,
            c = e;
        c.style.backgroundColor = t, c.style.border = "2px solid", c.style.borderColor = "white" === t ? "#D9D9D9" : "white"
    })), document.querySelector(".top-prodaz-card")) {
        document.querySelectorAll(".top-prodaz-card").forEach((e => {
            window.innerWidth < 1024 ? (e.classList.add("mobile-top-prodaz"), e.classList.remove("top-prodaz-card")) : (e.classList.remove("mobile-top-prodaz"), e.classList.add("top-prodaz-card"))
        }))
    }
    if (document.querySelectorAll(".card img").forEach((e => {
        e.addEventListener("click", (function() {
            window.location.href = "card.html"
        }))
    })), document.querySelector(".catalog-container")) {
        const W = document.querySelector(".catalog-container"),
            M = document.querySelector(".box a"),
            D = document.querySelector(".line a"),
            B = W.querySelectorAll("figure");
        D.addEventListener("click", (function() {
            this.classList.add("active-btn-card-line"), M.classList.remove("active-btn-card"), W.classList.add("line-catalog"), W.classList.remove("grid-catalog"), B.forEach((e => {
                e.querySelector(".card-view-block").classList.add("grig-card-line"), e.querySelector(".main-info-card").classList.add("d-flex"), e.querySelector("picture").classList.add("picture-line"), e.querySelector(".flag").classList.add("flag-line")
            }))
        })), M.addEventListener("click", (function() {
            this.classList.add("active-btn-card"), D.classList.remove("active-btn-card-line"), W.classList.remove("line-catalog"), W.classList.add("grid-catalog"), B.forEach((e => {
                e.querySelector(".card-view-block").classList.remove("grig-card-line"), e.querySelector(".main-info-card").classList.remove("d-flex"), e.querySelector("picture").classList.remove("picture-line"), e.querySelector(".flag").classList.remove("flag-line")
            }))
        }))
    }
    if (document.querySelectorAll(".select__item").forEach((e => {
        e.addEventListener("click", (function() {
            const e = this.getAttribute("data-value");
            document.querySelector(".select__input").value = e, document.querySelector("#countForm").submit(), document.querySelector("#sortForm").submit()
        }))
    })), window.innerWidth < 1024) {
        const I = document.querySelector(".search-mobile"),
            _ = document.querySelector(".search-block"),
            P = document.querySelector("header");
        I.addEventListener("click", (function() {
            _.classList.toggle("search-mobile-form"), P.classList.toggle("padding-for-search")
        }))
    }

    function e() {
        if (window.innerWidth < 1024) {
            const e = window.location.hash.substring(1);
            if (e) {
                document.querySelectorAll(".help-content").forEach((e => {
                    e.classList.remove("visible"), console.log(e)
                })), document.querySelectorAll(".menu-help-item a").forEach((e => {
                    e.classList.remove("readmore-active")
                }));
                const t = document.querySelector(`.menu-help-item a[data-href="${e}"]`),
                    c = document.getElementById(e);
                t && c && (t.classList.add("readmore-active"), c.classList.add("visible"))
            }
        }
    }
    if (document.querySelectorAll(".help-sub-menu a").forEach((t => {
        t.addEventListener("click", (function() {
            setTimeout(e, 0)
        }))
    })), function() {
        if (window.innerWidth < 1024) {
            [{
                buttonSelector: ".haracteristic-btn a",
                targetAttr: "data-target",
                sectionSelector: ".description-product, .haracteristic-block, .comment-card, .delivery-card",
                initialButtonSelector: '.transparent-cta[data-target="about"]',
                initialSectionId: "about",
                readmoreClass: "readmore",
                moreClass: "description-more",
                activeClass: "readmore-active",
                visibleClass: "visible"
            }, {
                buttonSelector: ".menu-help-item a",
                targetAttr: "data-href",
                sectionSelector: ".help-content",
                initialButtonSelector: '.menu-help-item a[data-href="aboutUs"]',
                initialSectionId: "aboutUs",
                readmoreClass: "readmore",
                moreClass: "description-more",
                activeClass: "readmore-active",
                visibleClass: "visible"
            }].forEach((({
                             buttonSelector: e,
                             targetAttr: t,
                             sectionSelector: c,
                             initialButtonSelector: n,
                             initialSectionId: o,
                             readmoreClass: l,
                             moreClass: r,
                             activeClass: s,
                             visibleClass: i
                         }) => {
                document.querySelectorAll(e).forEach((e => {
                    let c = e.getAttribute(t),
                        n = document.getElementById(c);
                    n && e.insertAdjacentElement("afterend", n)
                })), document.querySelectorAll(`${e}[${t}]`).forEach((e => {
                    e.classList.add(l)
                })), document.querySelectorAll(c).forEach((e => {
                    e.classList.add(r)
                }));
                const a = document.querySelector(n),
                    d = document.getElementById(o);
                a && d && (a.classList.add(s), d.classList.add(i))
            }))
        }
    }(), e(), window.addEventListener("hashchange", e), document.querySelector(".menu-cabinet-item")) {
        const $ = document.querySelectorAll(".menu-cabinet-item a"),
            U = document.querySelector(".cabinet-top-prodaz");
        $.forEach((e => {
            e.addEventListener("click", (function() {
                const t = e.getAttribute("data-href");
                U.style.display = "cartCabinet" === t ? "block" : "none"
            }))
        }))
    }
    const t = document.querySelector(".black-fon");
    if (document.querySelector(".down-menu")) {
        if (window.innerWidth >= 1024) {
            const V = document.querySelectorAll(".down-menu"),
                Y = (document.querySelector("#body"), document.querySelectorAll(".navigation-menu-catalog > li")),
                H = document.querySelectorAll(".sub-menu > li"),
                O = (e, t) => e.classList.add(t),
                T = (e, t) => e.classList.remove(t);
            Y.forEach((e => {
                e.addEventListener("mousemove", (function() {
                    const e = this.querySelector("a"),
                        t = this.querySelector(".sub-menu-main") || this.querySelector(".help-sub-menu");
                    e && O(e, "yellow-header-hover"), t && O(t, t.classList.contains("sub-menu-main") ? "hover-sub-menu" : "hover-help-menu")
                })), e.addEventListener("mouseleave", (function() {
                    const e = this.querySelector("a"),
                        t = this.querySelector(".sub-menu-main") || this.querySelector(".help-sub-menu");
                    e && T(e, "yellow-header-hover"), t && T(t, t.classList.contains("sub-menu-main") ? "hover-sub-menu" : "hover-help-menu")
                }))
            })), H.forEach((e => {
                e.addEventListener("mousemove", (function() {
                    O(this, "hover-sub-sub-a");
                    const e = this.querySelector(".second-subMenu");
                    e && O(e, "subSecond-hover")
                })), e.addEventListener("mouseleave", (function() {
                    T(this, "hover-sub-sub-a");
                    const e = this.querySelector(".second-subMenu");
                    e && T(e, "subSecond-hover")
                }))
            })), V.forEach((e => {
                const t = e.nextElementSibling,
                    c = document.querySelector(".black-fon");
                console.log(c), console.log(t);
                const n = () => {
                        c.classList.add("black-fon-style"), c.style.display = "block"
                    },
                    o = () => {
                        c.classList.remove("black-fon-style"), c.style.display = "none"
                    };
                e.addEventListener("mouseenter", n), e.addEventListener("mouseleave", o), t.addEventListener("mouseenter", n), t.addEventListener("mouseleave", o)
            }))
        }
        if (window.innerWidth < 1024) {
            document.querySelectorAll(".navigation-menu-catalog > li").forEach((e => {
                e.addEventListener("click", (function() {
                    console.log(e);
                    let t = e.querySelector(".mobile-menu");
                    t && t.classList.toggle("d-block")
                }))
            }))
        }
        let X = document.querySelector(".default-menu");
        if (window.innerWidth < 1024 ? X.classList.remove("default-menu") : X.classList.add("default-menu"), window.innerWidth < 1024) {
            const F = document.querySelectorAll(".second-subMenu");
            document.querySelectorAll(".mobile-item").forEach((e => {
                e.classList.contains("default-item") && e.classList.remove("default-item")
            })), F.forEach((e => {
                e.classList.contains("default-menu") && e.classList.remove("default-menu")
            }));
            document.querySelectorAll(".mobile-item > a").forEach((e => {
                e.addEventListener("click", (function(t) {
                    t.preventDefault();
                    const c = e.nextElementSibling;
                    c && c.classList.toggle("d-block")
                }))
            }))
        }
        if (document.querySelectorAll(".item").forEach((e => {
            const t = document.querySelector(".default-menu");
            e.addEventListener("mouseenter", (function() {
                t && (t.style.display = "none")
            })), e.addEventListener("mouseleave", (function() {
                t && (window.matchMedia("(min-width: 1024px)").matches ? t.style.display = "flex" : t.style.display = "block")
            }))
        })), document.querySelector("#burger")) {
            const R = document.querySelector(".burger"),
                j = document.querySelector(".navigation-menu-catalog"),
                G = document.querySelectorAll(".scrollBurger"),
                J = document.querySelector(".cancel-menu"),
                K = document.querySelectorAll(".head-subMenu");
            let N = !1;

            function c() {
                R.classList.remove("active"), R.classList.add("noactive"), j.style.left = "-100%", j.style.top = "-62px", j.style.overflowY = "", R.style.left = "0", t.classList.remove("black-fon-mobile"), t.style.left = "0"
            }
            K.forEach((e => {
                e.addEventListener("click", (function() {
                    let t = e.nextElementSibling;
                    console.log(e.nextElementSibling), t.classList.toggle("d-block")
                }))
            })), R.addEventListener("click", (function() {
                R.classList.add("active"), j.style.overflowY = "scroll", j.style.left = "0", j.style.top = "-62px", t.classList.add("black-fon-mobile"), t.style.left = "80%", N = !0
            })), window.addEventListener("scroll", (function() {
                G.forEach((e => {
                    const t = e.getBoundingClientRect();
                    t.top <= 0 && t.bottom >= 0 && (R.classList.remove("active"), c(), N = !1)
                }))
            })), J.addEventListener("click", (function() {
                c()
            })), t.addEventListener("click", (function() {
                c()
            }))
        }
    }
    if (document.querySelector(".filter-btn-mobile")) {
        const Q = document.querySelector(".filter-btn-mobile"),
            Z = document.querySelector(".filter"),
            ee = document.querySelector(".cancel-filter");

        function n() {
            t.classList.remove("black-fon-mobile"), t.style.left = "0", Z.style.left = "-100%", Z.style.transition = ""
        }
        Q.addEventListener("click", (function(e) {
            e.preventDefault(), Z.style.left = "0", Z.style.transition = "all .5s ease", t.classList.add("black-fon-mobile"), t.style.left = "80%"
        })), ee.addEventListener("click", (function(e) {
            n()
        })), t.addEventListener("click", (function() {
            n()
        }))
    }
    if (document.querySelector(".sort-select")) {
        const te = document.querySelectorAll(".select");
        te.forEach((e => {
            const t = e.querySelector(".select__in"),
                c = e.querySelectorAll(".select__item"),
                n = e.querySelector(".select__input"),
                o = new Event("change");
            if (t.addEventListener("click", (() => {
                te.forEach((t => {
                    t !== e && t.classList.remove("is-opened")
                })), e.classList.toggle("is-opened")
            })), c.length > 0) {
                const e = c[0];
                n.value = e.dataset.value, e.classList.add("is-active")
            }
            c.forEach((l => {
                l.addEventListener("click", (() => {
                    n.value = l.dataset.value, n.dispatchEvent(o), t.innerHTML = l.innerHTML, c.forEach((e => {
                        e.classList.remove("is-active")
                    })), l.classList.add("is-active"), e.classList.remove("is-opened")
                }))
            }))
        })), document.addEventListener("click", (e => {
            e.target.closest(".select") || te.forEach((e => {
                e.classList.contains("is-opened") && e.classList.remove("is-opened")
            }))
        })), document.addEventListener("keyup", (e => {
            "Escape" == e.key && te.forEach((e => {
                e.classList.contains("is-opened") && e.classList.remove("is-opened")
            }))
        }))
    }
    if (document.querySelector(".slider-range")) {
        const ce = document.querySelector(".slider-range"),
            ne = document.querySelector("#min-handle"),
            oe = document.querySelector("#max-handle"),
            le = document.querySelector("#range"),
            re = document.querySelector("#min-price"),
            se = document.querySelector("#max-price"),
            ie = document.querySelector("#min-value"),
            ae = document.querySelector("#max-value"),
            de = ce.offsetWidth,
            ue = ne.offsetWidth;
        let me = ie.getAttribute("data-value"),
            ye = ae.getAttribute("data-value");

        function o() {
            const e = ne.offsetLeft,
                t = oe.offsetLeft;
            le.style.left = e + "px", le.style.width = t - e + "px";
            const c = Math.round(me + e / (de - ue) * (ye - me)),
                n = Math.round(me + t / (de - ue) * (ye - me));
            re.value = c, se.value = n, ie.textContent = c, ae.textContent = n
        }

        function l(e, t) {
            e.preventDefault();
            const c = e.clientX || e.touches[0].clientX,
                n = t.offsetLeft,
                l = e => {
                    let l = (e.clientX || e.touches[0].clientX) - c + n;
                    l = t === ne ? Math.max(0, Math.min(l, oe.offsetLeft - ue)) : Math.max(ne.offsetLeft + ue, Math.min(l, de - ue)), t.style.left = l + "px", o()
                },
                r = () => {
                    document.removeEventListener("mousemove", l), document.removeEventListener("mouseup", r), document.removeEventListener("touchmove", l), document.removeEventListener("touchend", r)
                };
            document.addEventListener("mousemove", l), document.addEventListener("mouseup", r), document.addEventListener("touchmove", l), document.addEventListener("touchend", r)
        }
        ne.addEventListener("mousedown", (e => l(e, ne))), oe.addEventListener("mousedown", (e => l(e, oe))), ne.addEventListener("touchstart", (e => l(e, ne))), oe.addEventListener("touchstart", (e => l(e, oe))), o()
    }

    function r(e, t, c) {
        e.forEach((e => {
            e.addEventListener("click", (function(n) {
                n.preventDefault();
                e.nextElementSibling.classList.toggle(t), e.classList.toggle(c)
            }))
        }))
    }
    const s = document.querySelectorAll(".readmore"),
        i = document.querySelectorAll(".readmore-menu"),
        a = document.querySelectorAll(".readmore-menu-main");
    if (r(s, "visible", "readmore-active"), r(i, "visible-menu", "readmore-active-menu"), r(a, "visible-menu", "readmore-active-menu-main"), window.innerWidth < 1024 && document.querySelector(".btn-slider")) {
        const fe = document.querySelectorAll(".image-for-slider"),
            ve = document.querySelector(".img-slider"),
            he = document.querySelector(".btn-slider");
        fe.forEach(((e, t) => {
            let c = document.createElement("img"),
                n = document.createElement("input");
            n.type = "radio", n.name = "slider-radio", n.id = `slider-radio-${t}`, 0 === t && (n.checked = !0), c.src = e.src, c.classList.add("mobile-slider"), 0 === t && c.classList.add("active"), ve.appendChild(c), he.appendChild(n)
        }));
        const pe = document.querySelectorAll('input[name="slider-radio"]'),
            Se = document.querySelectorAll(".mobile-slider");
        let Le = 0;

        function d(e) {
            pe[e].checked = !0, Se.forEach((e => {
                e.classList.remove("active")
            })), Se[e].classList.add("active"), Le = e
        }
        pe.forEach(((e, t) => {
            e.addEventListener("change", (() => {
                d(t)
            }))
        })), ve.addEventListener("touchstart", (function(e) {
            const t = e.touches[0];
            qe = t.clientX
        }), !1), ve.addEventListener("touchmove", (function(e) {
            if (!qe) return !1;
            Le = e.touches[0].clientX - qe > 0 ? (Le - 1 + pe.length) % pe.length : (Le + 1) % pe.length;
            d(Le), qe = null
        }), !1);
        let qe = null
    }

    function u() {
        const e = document.querySelector(".carousel-card"),
            t = [...document.querySelectorAll(".carousel-item")],
            c = document.querySelectorAll(".btn");
        let n = t[0].offsetHeight,
            o = 0;
        c.forEach((e => {
            e.style.display = t.length > 3 ? "block" : "none"
        }));
        const l = document.querySelector(".btn-next");
        l && l.addEventListener("click", (function(t) {
            t.preventDefault(), o > 0 && (o--, e.style.transition = "transform 0.3s ease-in-out", e.style.transform = `translateY(-${o*n}px)`)
        }));
        const r = document.querySelector(".btn-prev");
        r && r.addEventListener("click", (function(c) {
            c.preventDefault(), o < t.length - 3 && (o++, e.style.transition = "transform 0.3s ease-in-out", e.style.transform = `translateY(-${o*n}px)`)
        }))
    }
    if (document.querySelector(".img-block") && (u(), window.addEventListener("resize", (() => {
        u()
    }))), document.querySelector("#delivery") && window.innerWidth >= 1024) {
        const be = document.querySelectorAll(".transparent-cta"),
            Ee = document.querySelectorAll(".description-product, .haracteristic-block, .comment-card, .delivery-card");

        function m() {
            Ee.forEach((e => e.classList.remove("active")))
        }

        function y() {
            be.forEach((e => e.classList.remove("active")))
        }
        be.forEach((e => {
            e.addEventListener("click", (function(t) {
                t.preventDefault();
                const c = e.getAttribute("data-target");
                m(), y();
                const n = document.getElementById(c);
                n && (n.classList.add("active"), e.classList.add("active"))
            }))
        })), m(), y(), document.querySelector(".description-product").classList.add("active"), document.querySelector('[data-target="about"]').classList.add("active")
    }
    if (document.querySelector(".popup-size-cta")) {
        const ge = document.querySelector(".popup-size-cta"),
            ke = document.querySelector(".black-fon-popup-size"),
            we = document.querySelector(".size-table-popup"),
            Ae = document.querySelector(".cancel-size-popup");

        function f() {
            window.innerWidth >= 1024 ? ke.classList.remove("black-fon-style") : ke.classList.remove("black-fon-mobile"), we.style.display = "none", body.style.height = "", body.style.overflow = ""
        }
        ge.addEventListener("click", (function() {
            we.style.display = "block", window.innerWidth >= 1024 ? ke.classList.add("black-fon-style") : ke.classList.add("black-fon-mobile")
        })), Ae.addEventListener("click", (function() {
            f()
        })), ke.addEventListener("click", (function() {
            f()
        }))
    }
    const v = document.querySelectorAll(".cabinet-cta"),
        h = document.querySelector(".black-fon-popup"),
        p = document.querySelector(".popup-cabinet"),
        S = document.querySelector(".cancel-popup-cabinet"),
        L = document.querySelectorAll(".eye"),
        q = document.querySelector(".navigation-menu-catalog");
    v.forEach((e => {
        e.addEventListener("click", (function(e) {
            e.preventDefault(), console.log("+"), p.style.display = "block", h.style.display = "block", q.style.zIndex = "20"
        })), S.addEventListener("click", (function(e) {
            e.preventDefault(), p.style.display = "none", h.style.display = "none", q.style.zIndex = "30"
        }))
    })), L.forEach((e => {
        e.addEventListener("click", (function(t) {
            t.preventDefault();
            const c = document.getElementById(this.getAttribute("data-target")),
                n = this.querySelector("svg");
            console.log(n), console.log(n), "password" === c.type ? (c.type = "text", n.style.display = "block", e.classList.remove("closeEye")) : (c.type = "password", n.style.display = "none", e.classList.add("closeEye"))
        }))
    }));
    const b = document.querySelector(".d-flex.item-center.cta-reg .entry"),
        E = document.querySelector(".d-flex.item-center.cta-reg .registration"),
        g = document.querySelector(".entry-form"),
        k = document.querySelector(".registration-form");
    if (b.addEventListener("click", (function() {
        b.classList.add("active-link"), E.classList.remove("active-link"), g.classList.add("active-form"), k.classList.remove("active-form")
    })), E.addEventListener("click", (function() {
        E.classList.add("active-link"), b.classList.remove("active-link"), k.classList.add("active-form"), g.classList.remove("active-form")
    })), document.querySelector(".menu-help-item ")) {
        document.querySelectorAll(".menu-help-item a").forEach((e => {
            e.addEventListener("mouseenter", (function() {
                e.classList.add("hover-cta-help")
            })), e.addEventListener("mouseleave", (function() {
                e.classList.remove("hover-cta-help")
            }))
        }))
    }
    if (document.querySelector(".help-content") && window.innerWidth >= 1024) {
        const xe = document.querySelectorAll(".menu-help-item a"),
            Ce = document.querySelectorAll(".help-content");

        function w(e) {
            xe.forEach((e => e.classList.remove("active-cta-help")));
            const t = Array.from(xe).find((t => t.getAttribute("data-href") === e));
            t && t.classList.add("active-cta-help"), Ce.forEach((e => {
                e.style.display = "none", e.classList.remove("active-help")
            }));
            const c = document.getElementById(e);
            c && (c.style.display = "block", c.classList.add("active-help"))
        }
        if (xe.length > 0) {
            xe.forEach((e => {
                e.addEventListener("click", (function(e) {
                    e.preventDefault();
                    const t = this.getAttribute("data-href");
                    w(t), history.pushState(null, "", `#${t}`)
                }))
            }));
            const ze = window.location.hash.substring(1);
            if (ze) w(ze);
            else {
                const We = document.getElementById(xe[0].getAttribute("data-href"));
                We && (We.style.display = "block", We.classList.add("active-help"))
            }
            window.addEventListener("hashchange", (function() {
                w(window.location.hash.substring(1))
            }))
        }
    }
    if (document.querySelector("#ukrPoshta")) {
        const Me = document.querySelector("#ukrPoshta"),
            De = document.querySelector("#novaPoshta"),
            Be = document.querySelector("#meest"),
            Ie = document.querySelector(".post-radio"),
            _e = document.querySelector("#cityVilageOptions"),
            Pe = document.querySelector("#forCityAdress"),
            $e = document.querySelector("#forCityViddilenia"),
            Ue = document.querySelector("#forVilage"),
            Xe = document.querySelector("#postomatOption"),
            Ve = document.querySelector("#forPostomat"),
            Ye = document.querySelectorAll('input[name="adress"]'),
            He = document.querySelectorAll('input[name="cityVilage"]'),
            Oe = document.querySelector("#ukrPostRadio"),
            Te = document.querySelector("#novaPostMeest");

        function A() {
            Me.checked || De.checked || Be.checked ? (Ie.style.display = "flex", Be.checked ? (Xe.style.display = "none", document.querySelector("#poshtomat").checked && (document.querySelector("#poshtomat").checked = !1)) : Xe.style.display = "flex") : (Ie.style.display = "none", _e.style.display = "none", Pe.style.display = "none", $e.style.display = "none", Ue.style.display = "none", Ve.style.display = "none"), Me.checked ? (Oe.style.display = "flex", Te.style.display = "none") : Oe.style.display = "none"
        }

        function x() {
            document.querySelector("#viddilenia").checked || document.querySelector("#adress").checked || document.querySelector("#poshtomat").checked || document.querySelector("#viddileniaExpres").checked || document.querySelector("#viddileniaUkr").checked || document.querySelector("#curierExpres").checked || document.querySelector("#curierUkr").checked ? _e.style.display = "flex" : (_e.style.display = "none", Pe.style.display = "none", $e.style.display = "none", Ue.style.display = "none", Ve.style.display = "none")
        }

        function C() {
            Pe.style.display = "none", $e.style.display = "none", Ue.style.display = "none", Ve.style.display = "none", document.querySelector("#viddilenia").checked || document.querySelector("#viddileniaExpres").checked || document.querySelector("#viddileniaExpres").checked || document.querySelector("#viddileniaUkr").checked || document.querySelector("#curierExpres").checked || document.querySelector("#curierUkr").checked ? document.querySelector("#city").checked ? $e.style.display = "block" : document.querySelector("#vilage").checked && (Ue.style.display = "block") : document.querySelector("#adress").checked ? document.querySelector("#city").checked ? Pe.style.display = "block" : document.querySelector("#vilage").checked && (Ue.style.display = "block") : document.querySelector("#poshtomat").checked && (Ve.style.display = "block")
        }
        Ie.style.display = "none", _e.style.display = "none", Pe.style.display = "none", $e.style.display = "none", Ue.style.display = "none", Ve.style.display = "none", Xe.style.display = "none", Te.style.display = "none", Oe.style.display = "none", Me.addEventListener("change", (() => {
            A(), x(), C()
        })), De.addEventListener("change", (() => {
            A(), x(), C()
        })), Be.addEventListener("change", (() => {
            A(), x(), C()
        })), Ye.forEach((e => {
            e.addEventListener("change", (() => {
                x(), C()
            }))
        })), He.forEach((e => {
            e.addEventListener("change", C)
        })), A(), x(), C()
    }
    if (document.querySelector(".cabinet-top-prodaz")) {
        const Fe = document.querySelector(".top-prodaz-main.cabinet-top-prodaz"),
            Re = document.querySelector(".cabinet-cart-product"),
            je = Fe.parentElement;
        Fe.nextElementSibling;

        function z() {
            window.innerWidth <= 1024 ? Fe && Fe.parentElement !== Re && Re.appendChild(Fe) : je.appendChild(Fe)
        }
        z(), window.addEventListener("resize", z)
    }
    if (document.querySelector("#userPhone")) {
        const Ge = document.querySelector("#userPhone");
        Ge.addEventListener("input", (function() {
            let e = Ge.value.trim();
            const t = "+380";
            e.startsWith(t) || (e = t + e);
            let c = e.replace(/[^\d+]/g, "");
            c.length > 13 && (c = c.slice(0, 13));
            const n = function(e) {
                return /^\+?(\d{2})?([(]?\d{3}[)]?)\s?[-]?\s?(?:\d{3})\s?[-]?(?:\s?\d{2})\s?[-]?(?:\s?\d{2})$/.test(e)
            }(c);
            n && 13 === c.length ? Ge.style.borderColor = "green" : Ge.style.borderColor = "red"
        }))
    }
    document.querySelectorAll(".inputMask").forEach((function(e) {
        e.addEventListener("click", (function() {
            e.value || (e.value = "+380")
        })), e.addEventListener("input", (function() {
            let t = e.value.replace(/[^\d+]/g, "");
            e.value = t, t.length > 13 && (e.value = t.slice(0, 13)), t.startsWith("+380") || (e.value = "+380" + t.slice(3))
        }))
    }))
}));
