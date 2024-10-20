! function(a) {
    window.haru_vidi_importMessages = {
        loading: "Importing, please wait...",
        wait: "Not done yet, still importing. You'll have to wait a bit longer.",
        importing: "Importing",
        done: "Import Complete"
    }, a(document).ready(function() {
        window.Haru_Vidi_Import = {
            init: function() {
                window.Haru_Vidi_Import.Events(), window.Haru_Vidi_Import.Wizard(), window.Haru_Vidi_Import.Params_Ajax(), window.Haru_Vidi_Import.Import_Ajax();
                var b = a(".wizard-wrap").attr("data-step");
                if (3 == b) {
                    window.Haru_Vidi_Import.Wizard_Step_Process(b - 1, 3);
                    var c = a("#blocks").height(),
                        d = a(".wp-list-table").height() + 170;
                    d > c && a("#blocks").height(d)
                }
            },
            Events: function() {
                a("#haru_vidi_feed").change(function() {
                    var b = a(this).val(),
                        c = a("#haru_vidi_order").val();
                    switch (a("label[for=haru_vidi_query]").html(a(this).find("option:selected").attr("title") + " :"), b) {
                        case "query":
                            a("tr.haru_vidi_duration").show();
                            var d = ["position", "commentCount", "duration", "reversedPosition", "title"],
                                e = ["relevance", "rating"];
                            a.each(d, function(b, c) {
                                a("#haru_vidi_order option[value=" + c + "]").attr({
                                    disabled: "disabled"
                                }).css("display", "none")
                            }), a.each(e, function(b, c) {
                                a("#haru_vidi_order option[value=" + c + "]").removeAttr("disabled").css("display", "")
                            });
                            var f = a.inArray(c, d); - 1 !== f && a("#haru_vidi_order option[value=" + d[f] + "]").removeAttr("selected");
                            break;
                        case "user":
                        case "playlist":
                            a("tr.haru_vidi_duration").hide();
                            var g = ["position", "commentCount", "duration", "reversedPosition", "title"],
                                h = ["relevance", "rating"];
                            a.each(h, function(b, c) {
                                a("#haru_vidi_order option[value=" + c + "]").attr({
                                    disabled: "disabled"
                                }).css("display", "none")
                            }), a.each(g, function(b, c) {
                                a("#haru_vidi_order option[value=" + c + "]").removeAttr("disabled").css("display", "")
                            });
                            var i = a.inArray(c, h); - 1 !== i && a("#haru_vidi_order option[value=" + h[i] + "]").removeAttr("selected")
                    }
                }).trigger("change")
            },
            Wizard: function() {
                a("body").on("click", ".progress_bar .step.complete", function() {
                    var b = a(this).parent().find(".current").data("step"),
                        c = a(this).data("step"),
                        d = "desc";
                    b < c && (d = "asc"), window.Haru_Vidi_Import.Wizard_Step_Process(b, c, d)
                })
            },
            Wizard_Move_to_Step: function(b, c, d, e) {
                var f = 25 * (parseInt(b + 1) - 1);
                "asc" === d ? (a("#step" + b).addClass("complete").removeClass("current"), a(".progress_bar").find(".current_steps").animate({
                    width: f + "%"
                }, e, function() {
                    a("#step" + (b + 1)).removeClass("complete").addClass("current"), b + 1 < c && window.Haru_Vidi_Import.Wizard_Move_to_Step(b + 1, c, d, e)
                })) : "desc" === d ? (a("#step" + b).removeClass("complete").removeClass("current"), a(".progress_bar").find(".current_steps").animate({
                    width: f + "%"
                }, e, function() {
                    a("#step" + (b - 1)).removeClass("complete").addClass("current"), b - 1 > c && window.Haru_Vidi_Import.Wizard_Move_to_Step(b - 1, c, d, e)
                })) : (a("#step" + b).removeClass("complete").removeClass("current"), a(".progress_bar").find(".current_steps").animate({
                    width: "0%"
                }, e, function() {
                    a("#step" + (b - 1)).removeClass("complete").addClass("current"), b - 1 > c && window.Haru_Vidi_Import.Wizard_Move_to_Step(b - 1, c, d, e)
                }))
            },
            Wizard_Step_Process: function(b, c, d) {
                a("html, body").animate({
                    scrollTop: 0
                }, "slow"), "undefined" == typeof d && (d = "asc");
                var e = "",
                    f = "",
                    g = 500;
                if ("asc" === d ? (e = "-", f = "") : "desc" === d && (e = "", f = "-"), a("#block" + b).animate({
                        left: e + "100%"
                    }, g, function() {
                        a(this).css({
                            left: "100%",
                            "z-index": "2"
                        })
                    }), a("#block" + c).css({
                        "z-index": "3",
                        left: f + "100%"
                    }).animate({
                        left: "0%"
                    }, g, function() {
                        a(this).css({
                            "z-index": "2"
                        })
                    }), 1 === Math.abs(b - c)) {
                    b < c ? a("#step" + b).addClass("complete").removeClass("current") : a("#step" + b).removeClass("complete").removeClass("current");
                    var h = 25 * (parseInt(c) - 1);
                    a(".progress_bar").find(".current_steps").animate({
                        width: h + "%"
                    }, g, function() {
                        a("#step" + c).removeClass("complete").addClass("current")
                    })
                } else {
                    var i = Math.abs(b - c),
                        j = g / i;
                    "restart" === d ? window.Haru_Vidi_Import.Wizard_Move_to_Step(b, c, "restart", j) : b < c ? window.Haru_Vidi_Import.Wizard_Move_to_Step(b, c, "asc", j) : window.Haru_Vidi_Import.Wizard_Move_to_Step(b, c, "desc", j)
                }
            },
            Params_Ajax: function() {
                a("#haru_vidi_load_feed_form").submit(function(b) {
                    var c = a("#haru_vidi_query").val();
                    "" === c && (b.preventDefault(), a("#haru_vidi_query, label[for=haru_vidi_query]").addClass("haru_vidi_error"))
                }), a("#haru_vidi_query").keyup(function() {
                    var b = a(this).val();
                    "" === b ? a("#haru_vidi_query, label[for=haru_vidi_query]").addClass("haru_vidi_error") : a("#haru_vidi_query, label[for=haru_vidi_query]").removeClass("haru_vidi_error")
                });
                a(".ajax-submit-params").on("click", function(b) {
                    var c = a("#haru_vidi_query").val();
                    "" !== c ? a(".import-global-loading").show().removeClass("haru_vidi_error") : a("label[for=haru_vidi_query]").addClass("haru_vidi_error")
                })
            },
            Import_Ajax: function() {
                a(".ajax-submit .tablenav.top .actions select[name=action]").attr({
                    name: "action_top"
                });
                var b = !1;
                a(".ajax-submit").submit(function(c) {
                    function d() {
                        var b;
                        return a.ajax({
                            type: "GET",
                            url: window.ajaxurl,
                            data: {
                                action: "haru_vidi_import_progress"
                            },
                            dataType: "JSON",
                            beforeSend: function() {}
                        }).done(function(b, c, d) {
                            var e = b;
                            "undefined" == typeof e.current && (e.current = 0), "undefined" == typeof e.total && (e.total = 1);
                            var f = Math.round(e.current / e.total * 100);
                            f = f ? f : 0, a(".video-central-ajax-response-progress").html(f + "%"), a(".import-progress-inner").removeClass("loading").css("width", f + "%")
                        }), b
                    }
                    if (c.preventDefault(), b) return a(".video-central-ajax-response-task").html(window.haru_vidi_importMessages.importing), void a(".video-central-ajax-response-progress").html(window.haru_vidi_importMessages.wait);
                    var e = a(this).serialize();
                    b = !0, a(".video-central-ajax-response-progress").removeClass("success error").addClass("loading").html(window.haru_vidi_importMessages.loading), a(".import-progress-inner").removeClass("success error done").addClass("loading");
                    var f = setInterval(function() {
                        new d
                    }, 5e3);
                    a.ajax({
                        type: "post",
                        url: window.ajaxurl,
                        data: e,
                        dataType: "json",
                        success: function(c) {
                            c.success && (a(".video-central-ajax-response-progress").removeClass("loading error").addClass("success").html(c.success), a(".video-central-ajax-response-task").html(window.haru_vidi_importMessages.done), a(".import-progress-inner").addClass("success done").css("width", "100%")), c.error && a(".video-central-ajax-response-progress").removeClass("loading success").addClass("error").html(c.error), clearInterval(f), b = !1
                        }
                    })
                })
            }
        }, window.Haru_Vidi_Import.init()
    })
}(jQuery);