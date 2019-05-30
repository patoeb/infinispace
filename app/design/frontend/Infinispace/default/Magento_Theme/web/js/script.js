(function($) {
    "use strict";
    jQuery(document).on('ready', function(e) {

        jQuery(window).on('load', function(e) {
            var winwidth = jQuery(window).width();
            if (winwidth > 768) {

                var heights = [];
                jQuery('.review_single').each(function() {
                    var height = $(this).height();
                    heights.push(height);
                });
                var max = Math.max.apply(Math, heights);
                jQuery('.review_single').css("height", max);

                var menu_height = jQuery('.main_heading').height();
                var about_img = jQuery('.single_about_img').height();
                jQuery('.single_about_text').height(about_img);
                var about_bottom = jQuery('.single_about_skill').height();
                jQuery('.single_about_bottom').height(about_bottom);

                //alert(about_img);

                // Defining a function to set size for #hero 
                function fullscreen() {
                    jQuery('.banner_main').css({
                        width: jQuery(window).width(),
                        height: jQuery(window).height()
                    });
                }

                fullscreen();

                // Run the function in case of window resize
                jQuery(window).on('resize', function(e) {
                    fullscreen();
                });


                //For sticky Header
                jQuery(window).on('scroll', function(e) {
                    if (jQuery(this).scrollTop() > 1) {
                        jQuery('header').addClass("sticky");
                    } else {
                        jQuery('header').removeClass("sticky");
                    }
                });

            }
        });

        // WOW js
        new WOW().init();

        jQuery(window).on('load', function(e) {
            //Preloader
            setTimeout(function() {
                jQuery('.preloader').fadeOut('slow', function() {});
            }, 2000);

            jQuery('.filtr-container').filterizr();
            //Simple filter controls
            jQuery('.simplefilter li').on('click', function(e) {
                jQuery('.simplefilter li').removeClass('active');
                jQuery(this).addClass('active');
            });
        });

        //Back To Top
        jQuery(window).on('scroll', function(e) {
            if (jQuery(this).scrollTop() > 400) {
                jQuery('#back-top').fadeIn();
            } else {
                jQuery('#back-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        jQuery('#back-top').on('click', function(e) {
            jQuery('#back-top').tooltip('hide');
            jQuery('body,html').animate({
                scrollTop: 0
            }, 1500);
            return false;
        });

        jQuery('.home_slide').lightSlider({
            item: 1,
            auto: true,
            autoWidth: false,
            controls: true,
            prevHtml: '<i class="fa fa-angle-left"></i>',
            nextHtml: '<i class="fa fa-angle-right"></i>',
        });
        // Brand Carousel Home Page
        jQuery("#team_slide").lightSlider({
            item: 3,
            autoWidth: false,
            slideMove: 1, // slidemove will be 1 if loop is true
            slideMargin: 20,

            addClass: '',
            mode: "slide",
            useCSS: true,
            cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
            easing: 'linear', //'for jquery animation',////

            speed: 400, //ms'
            auto: true,
            loop: false,
            slideEndAnimation: true,
            pause: 2000,

            keyPress: true,
            controls: false,
            prevHtml: '<i class="fa fa-angle-left"></i>',
            nextHtml: '<i class="fa fa-angle-right"></i>',

            rtl: false,
            adaptiveHeight: false,

            vertical: false,
            verticalHeight: 500,
            vThumbWidth: 100,

            thumbItem: 10,
            pager: true,
            gallery: false,
            galleryMargin: 5,
            thumbMargin: 5,
            currentPagerPosition: 'middle',

            enableTouch: true,
            enableDrag: true,
            freeMove: true,
            swipeThreshold: 40,

            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        item: 3,
                        slideMove: 1,
                        slideMargin: 6,
                    }
                }, {
                    breakpoint: 980,
                    settings: {
                        item: 3,
                        slideMove: 1,
                        slideMargin: 6,
                    }
                },

                {
                    breakpoint: 768,
                    settings: {
                        item: 3,
                        slideMove: 1,
                        slideMargin: 6,
                    }
                },

                {
                    breakpoint: 767,
                    settings: {
                        item: 2,
                        slideMove: 1,
                        slideMargin: 6,
                    }
                },

                {
                    breakpoint: 480,
                    settings: {
                        item: 1,
                        slideMove: 1
                    }
                }
            ],

            onBeforeStart: function(el) {},
            onSliderLoad: function(el) {},
            onBeforeSlide: function(el) {},
            onAfterSlide: function(el) {},
            onBeforeNextSlide: function(el) {},
            onBeforePrevSlide: function(el) {}
        });
        //Smoth Scroll
        jQuery(function() {
            jQuery('a[href*="#"]:not([href="#"])').on('click', function(e) {
                var headheight = jQuery("header").height();
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = jQuery(this.hash);
                    target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        jQuery('html, body').animate({
                            scrollTop: target.offset().top - 65
                        }, 1000);
                        return false;
                    }
                }
            });
        });

    });
})(jQuery);