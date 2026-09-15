(function ($) {
	"use strict";
    jQuery(document).ready(function($){


        // JS for rtl
        var rtlEnable = $('html').attr('dir');
        var sliderRtlValue = !(typeof rtlEnable === 'undefined' || rtlEnable === 'ltr');
        var OwlRtlValue = !(typeof rtlEnable === 'undefined' || rtlEnable === 'ltr');
        /*--------------------
        *  language change
        * ------------------*/
		$(document).on('click','.selected-language',function (e){
           e.preventDefault();
           $(this).next('ul').toggleClass('show');

        });


        /**-----------------------------
         *  Navbar fix
         * ---------------------------*/
        $(document).on('click','.navbar-area .navbar-nav li.menu-item-has-children>a',function(e){
            e.preventDefault();
        })

        /*------------------------------
            counter section activation
        -------------------------------*/
        var counternumber = $('.count-num');
        counternumber.rCounter({
            duration: 40
        });
        
        /*----------------------------------------
          work single page carousel
        ----------------------------------------*/
        var $caseStudyGalleryCarousel = $('.case-study-gallery-carousel');
        if ($caseStudyGalleryCarousel.length > 0) {
            $caseStudyGalleryCarousel.owlCarousel({
                rtl: OwlRtlValue,
                loop: true,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 0,
                dots: true,
                nav: false,
                smartSpeed:1000,
                animateIn:'fadeIn',
                animateOut:'fadeOut',
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 1,
                        nav:false,
                        dots:false
                    },
                    1200: {
                        items: 1
                    },
                    1920: {
                        items: 1
                    }
                }
            });
        }
        
        /*--------------------
            wow js init
        --------------------*/
        new WOW().init();
        /*-------------------------------------
            Recent Work filter activation
        -------------------------------------*/
        var Container = $('.recent-work-masonry');
        if (Container.length > 0) {
            Container.imagesLoaded(function () {
                var festivarMasonry = $('.recent-work-masonry').isotope({
                    itemSelector: '.single-recent-wrok-item',
                    percentPosition: true,
                    masonry: {
                        columnWidth: 0,
                        gutter:0
                    }
                });
                $(document).on('click', '.recent-work-nav-area ul li', function () {
                    var filterValue = $(this).attr('data-filter');
                    festivarMasonry.isotope({
                        filter: filterValue
                    });
                });
            });
        }
        /*----------------------------
            recent work menu active
        ----------------------------*/
        var portfolioMenu = '.recent-work-nav-area ul li';
        $(document).on('click', portfolioMenu, function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        });

        /*----------------------------------
            magnific popup activation
        ----------------------------------*/
        $('.image-popup').magnificPopup({
            type: 'image'
        });
        $('.video-play-btn').magnificPopup({
            type: 'video'
        });
        /*-------------------------------
            back to top
        ------------------------------*/
        $(document).on('click', '.back-to-top', function () {
            $("html,body").animate({
                scrollTop: 0
            }, 2000);
        });


        /*----------------------------------------
            Header Slider 01 carousel
        ----------------------------------------*/
        var $headerCarousel = $('.header-carousel-two');
        if ($headerCarousel.length > 0) {
            $headerCarousel.owlCarousel({
                rtl: OwlRtlValue,
                loop: true,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 0,
                dots: true,
                nav: false,
                smartSpeed:1000,
                animateIn:'fadeIn',
                animateOut:'fadeOut',
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 1,
                        nav:false,
                        dots:false
                    },
                    1200: {
                        items: 1
                    },
                    1920: {
                        items: 1
                    }
                }
            });
        }
				/*---------------------------
					 Brand carousel
			 ---------------------------*/
			 var $BrandCarousel = $('.brand-carousel');
			 if ($BrandCarousel.length > 0) {
					 $BrandCarousel.owlCarousel({
                             rtl: OwlRtlValue,
							 loop: false,
							 autoplay: true, //true if you want enable autoplay
							 autoPlayTimeout: 1000,
							 margin: 30,
							 dots: false,
							 nav: false,
							 lazyLoad:true,
							 smartSpeed: 2000,

							 responsive: {
									 0: {
											 items: 1
									 },
									 360: {
											 items: 1
									 },
									 460: {
											 items: 2
									 },
									 599: {
											 items: 2
									 },
									 768: {
											 items: 3
									 },
									 960: {
											 items: 4
									 },
									 1200: {
											 items: 5
									 },
									 1920: {
											 items: 5
									 }
							 }
					 });
			 }
        /*----------------------------------------
            testimonial carousel
        ----------------------------------------*/
        var $testimonialCarousel = $('.testimonial-carousel');
        if ($testimonialCarousel.length > 0) {
            $testimonialCarousel.owlCarousel({
                rtl: OwlRtlValue,
                loop: true,
                autoplay: false, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 0,
                dots: true,
                nav: false,
                smartSpeed:1000,
                center:true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    991: {
                        items: 2,
                        nav:false,
                        dots:false
                    },
                    1200: {
                        items: 3
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }
        var $teastimonialQuote = $(".single-testimonial-quote");
            $testimonialCarousel.on("changed.owl.carousel", function (e) {
                var o = e.item.index + 1 - e.relatedTarget._clones.length / 2,
                    n = e.item.count;
                (o > n || 0 == o) && (o = n - o % n), o--;
                var t = $(".single-testimonial-quote:nth(" + o + ")");
                owlCaouselrightItem(t)
            }),
            $('document').on("click",$teastimonialQuote, function () {
                var e = $(this).data("owl-item");
                $testimonialCarousel.trigger("to.owl.carousel", e), a($(this))
            });

        function owlCaouselrightItem(e) {
            $teastimonialQuote.removeClass("active"), e.addClass("active")
        }


    });


    //define variable for store last scrolltop
    var lastScrollTop = '';
    $(window).on('scroll', function () {
        /*---------------------------
            back to top show / hide
        ---------------------------*/
       var ScrollTop = $('.back-to-top');
       if ($(window).scrollTop() > 1000) {
           ScrollTop.fadeIn(1000);
       } else {
           ScrollTop.fadeOut(1000);
       }
       /*--------------------------
        sticky menu activation
       ---------------------------*/
        var st = $(this).scrollTop();
        // var mainMenuTop = $('.navbar-area');
        // if ($(window).scrollTop() > 1000) {
        //     mainMenuTop.addClass('nav-fixed');
        // } else {
        //     mainMenuTop.removeClass('nav-fixed ');
        // }
        if (st < lastScrollTop) {
            $('.navbar-wrapper').addClass('nav-fixed');
            $('body').css('padding-top', '72px'); // navbar height
        } else {
            $('.navbar-wrapper').removeClass('nav-fixed');
            $('body').css('padding-top', '0');
        }
        lastScrollTop = st;

    });

    $(window).on('load',function(){
        $('.navbar-nav li > ul.sub-menu').parent().addClass('menu-item-has-children');
        /*-----------------------------
            preloader
        -----------------------------*/
        var preLoder = $("#preloader");
        preLoder.fadeOut(1000);
        /*-----------------------------
            back to top
        -----------------------------*/
        var backtoTop = $('.back-to-top')
        backtoTop.fadeOut(100);

    });

    // mobile navbar
    $(window).on('load',function(){
        $('.navbar-toggler').click(function() {
            navbarMobileExpand();

            $('.navbar-toggler .material-symbols').toggleClass('color-gray-900 color-bci-secondary');
            $('.navbar-toggler').toggleClass('border-secondary');
        });
    });

    function navbarMobileExpand() {
        $('#navbar-mobile').toggleClass('d-none d-md-none');
    }

}(jQuery));
