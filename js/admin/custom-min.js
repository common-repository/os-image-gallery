! function(e) {
    e(document).on("click", ".toggle", function(t) {
        e(this).parent().parent().next().slideToggle(500), e(this).hasClass("up") ? e(this).removeClass("up").addClass("down") : e(this).removeClass("down").addClass("up")
    }), e(document).on("click", ".attribute-box label.attribute", function(t) {
        e(this).next().slideToggle(500)
    }), e("#os-image-gallery-slider-wrapper").sortable({
        handle: ".os-image-gallery-header",
        placeholder: "os-slider-slide-placeholder",
        forcePlaceholderSize: !0,
        delay: 100,
        update: function(t, a) {
            e("#os-image-gallery-slider-wrapper .os-image-gallery-box").each(function(t, a) {
                e(a).find("input, select, textarea").each(function(a, l) {
                    var i = e(l).attr("name");
                    i && (i = i.replace(/\[[0-9]+\]/, "[" + t + "]"), e(l).attr("name", i))
                })
            })
        }
    }), e(document).on("click", "#add-slide", function(t) {
        var a = e(".os-image-gallery-box").length,
            l = e(".os-image-gallery-box-wrap").html();
        l = l.replace(/{id}/g, a), e("#os-image-gallery-slider-wrapper").append(l), t.preventDefault()
    });
    var t;
    e(document).on("click", "#add-image", function(a) {
        return a.preventDefault(), curr_element = e(this), t ? void t.open() : (e(".media-modal, .media-modal-backdrop").hide(), t = wp.media.frames.file_frame = wp.media({
            title: "Choose an image",
            frame: "select",
            button: {
                text: "Add to slide"
            },
            library: {
                type: "image"
            },
            multiple: !0
        }), t.on("select", function() {
            attachment = t.state().get("selection").first().toJSON();
            var a = e("<img>");
            attachment.sizes.medium ? a.attr({
                src: attachment.sizes.medium.url,
                alt: "medium"
            }) : a.attr({
                src: attachment.sizes.full.url,
                alt: "full"
            }), curr_element.prev().prev().html(a), curr_element.parent().parent().prev().find(".os-image-gallery-caption").html(attachment.title), curr_element.prev().val(attachment.id), curr_element.val("Update Image"), window.scrollTo(300, 0)
        }), void t.open())
    }), e(document).on("click", ".os-image-gallery-box .delete", function(t) {
        e(this).closest(".os-image-gallery-box").remove()
    }), e(document).on("click", ".slider_type", function(t) {
        if (e(this).hasClass("active")) e("#slider_type").val(""), e(".slider_type").removeClass("active");
        else {
            var a = e(this).attr("id");
            e("#slider_type").val(a), e(".slider_type").removeClass("active"), e(this).addClass("active")
        }
    }), e(document).on("click", ".shortcode", function(t) {
        e(this).select(), e(this).onmouseup = function() {
            return e(this).onmouseup = null, !1
        }
    }), e(document).on("click", ".next_button", function(t) {
        window.send_to_editor = function(t) {
            imgurl = jQuery("img", t).attr("src"), e(".next_button").prev().val(imgurl);
        }
    }), e(document).on("click", ".prev_button", function(t) {
        window.send_to_editor = function(t) {
            imgurl = jQuery("img", t).attr("src"), e(".prev_button").prev().val(imgurl);
        }
    })
    e('.button-color').wpColorPicker();
}(jQuery);