define([
    'jquery',
    'jquery/ui',
    'bootstrap',
    'lightslider',
    'lightbox',
    'filterizr',
    'mage/translate'
], function($, ui, _responsive){
    'use strict';
  
    $.widget('infinispace.infinispace', {
  
        _create: function() {
            this.initAllPages();
            this.initHomePage();
            this.initCategoryPage();
            this.initProductPage();
            this.initSearchPage();
            this.initCategorySearchPage();
            this.initShoppingCartPage();
            this.initCheckoutPage();
            this.initRegisterPage();
            this.initCustomerAccountPage();
            this.initInvoicePage();
            this.initCmsPage();
            this.initContactPage();
            this.initLoginPage();
        },

        initAllPages: function() {
            $('.header.panel>.header.links>li').insertBefore('.minicart-custom');

            $(window).on('load', function(e) {
                var winwidth = $(window).width();
                if (winwidth > 768) {

                    var heights = [];
                    $('.review_single').each(function() {
                        var height = $(this).height();
                        heights.push(height);
                    });
                    var max = Math.max.apply(Math, heights);
                    $('.review_single').css("height", max);

                    var menu_height = $('.main_heading').height();
                    var about_img = $('.single_about_img').height();
                    $('.single_about_text').height(about_img);
                    var about_bottom = $('.single_about_skill').height();
                    $('.single_about_bottom').height(about_bottom);

                    //alert(about_img);

                    // Defining a function to set size for #hero 
                    function fullscreen() {
                        $('.banner_main').css({
                            width: $(window).width(),
                            height: $(window).height()
                        });
                    }

                    fullscreen();

                    // Run the function in case of window resize
                    $(window).on('resize', function(e) {
                        fullscreen();
                    });

                    //For sticky Header
                    $(window).on('scroll', function(e) {
                        if ($(this).scrollTop() > 1) {
                            $('header').addClass("sticky");
                        } else {
                            $('header').removeClass("sticky");
                        }
                    });
    
                }
            });

            // WOW js
            // new WOW().init();

            $(window).on('load', function(e) {
                //Preloader
                setTimeout(function() {
                    $('.preloader').fadeOut('slow', function() {});
                }, 500);

                $('.filtr-container').filterizr();
                //Simple filter controls
                $('.simplefilter li').on('click', function(e) {
                    $('.simplefilter li').removeClass('active');
                    $(this).addClass('active');
                });
            });

            //Back To Top
            $(window).on('scroll', function(e) {
                if ($(this).scrollTop() > 400) {
                    $('#back-top').fadeIn();
                } else {
                    $('#back-top').fadeOut();
                }
            });
            // scroll body to 0px on click
            $('#back-top').on('click', function(e) {
                $('#back-top').tooltip('hide');
                $('body,html').animate({
                    scrollTop: 0
                }, 1500);
                return false;
            });
            $('.home_slide').lightSlider({
                item: 1,
                auto: true,
                loop: true,
                autoWidth: false,
                controls: true,
                prevHtml: '<i class="fa fa-angle-left"></i>',
                nextHtml: '<i class="fa fa-angle-right"></i>',
            });
            // Brand Carousel Home Page
            $("#team_slide").lightSlider({
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
            $(function() {
                $('a[href*="#"]:not([href="#"])').on('click', function(e) {
                    var headheight = $("header").height();
                    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        if (target.length) {
                            $('html, body').animate({
                                scrollTop: target.offset().top - 65
                            }, 1000);
                            return false;
                        }
                    }
                });
            });
        },

        initHomePage: function() {
            
            if ($('body.cms-index-index').length) {
            }
        },

        initCategoryPage: function() {

            if ($('body.catalog-category-view').length) {
            }
        },

        initProductPage: function() {

            if ($('body.catalog-product-view').length) {       
            }
        },

        initSearchPage: function() {

            if ($('body.catalogsearch-result-index').length) {
            }
        },

        initCategorySearchPage: function() {

            if ($('body.catalog-category-view:not(.page-layout-category-series)').length || $('body.catalogsearch-result-index').length) {         
            }
        },

        initShoppingCartPage: function() {

            if ($('body.checkout-cart-index').length) {
                
            }
        },

        initCheckoutPage: function() {

            if ($('body.checkout-onepage-index').length) {  
            }
        },

        initRegisterPage: function() {

            if ($('body.customer-account-create').length) {
            }
        },

        initLoginPage: function() {

            if ($('body.customer-account-login').length) {
            }
        },
    
        initCustomerAccountPage: function() {
            
            if( $('body.account').length ) {
            }
        },
      
        initInvoicePage: function() {
            if ($('body.sales-order-invoice').length) {
            }
        },
    
        initCmsPage: function() {

            if ($('body.cms-page-view').length) { 
            }
        },

        initContactPage: function() {
            if ($('body.contact-index-index').length) {  
            }
        }
    });

    return $.infinispace.main;

});