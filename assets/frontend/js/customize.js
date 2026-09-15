(function ($) {
	"use strict";
    jQuery(document).ready(function($){


        // JS for rtl
        var rtlEnable = $('html').attr('dir');
        var sliderRtlValue = !(typeof rtlEnable === 'undefined' || rtlEnable === 'ltr');
        var OwlRtlValue = !(typeof rtlEnable === 'undefined' || rtlEnable === 'ltr');

        /*----------------------------------------
            homepage carousel
        ----------------------------------------*/
        var $homepageCarousel = $('.homepage-carousel');
        if ($homepageCarousel.length > 0) {
            $homepageCarousel.owlCarousel({
                rtl: OwlRtlValue,
                loop: true,
                autoplay: false, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                dots: false,
                nav: true,
                navText : ['<img src="assets/frontend/img/bc/arrow-left_bc.svg">','<img src="assets/frontend/img/bc/arrow-right_bc.svg">'],
                smartSpeed:1000,
                center:true,
                responsive: {
                    0: {
                        items: 1.8,
                        margin: 60,
                    },
                    767: {
                        items: 1.8,
                        margin: 70,
                    },
                    768: {
                        items: 1.8,
                        margin: 80,
                    },
                    991: {
                        items: 1.8,
                        margin: 100,
                    },
                    1200: {
                        items: 1.8,
                        margin: 100,
                    },
                    1920: {
                        items: 1.8,
                        margin: 100,
                    }
                }
            });
        }
        var $homepageQuote = $(".single-homepage-quote");
        $homepageCarousel.on("changed.owl.carousel", function (e) {
            var o = e.item.index + 1 - e.relatedTarget._clones.length / 2,
                n = e.item.count;
            (o > n || 0 == o) && (o = n - o % n), o--;
            var t = $(".single-homepage-quote:nth(" + o + ")");
            owlCaouselrightItem(t)
        }),
        $('document').on("click",$homepageQuote, function () {
            var e = $(this).data("owl-item");
            $homepageCarousel.trigger("to.owl.carousel", e), a($(this))
        });

    function owlCaouselrightItem(e) {
        $homepageQuote.removeClass("active"), e.addClass("active")
    }
    });

}(jQuery));