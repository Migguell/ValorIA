(function($) {
    "use strict";
    
    $(window).on('elementor/frontend/init', function() {
        var _elementor = typeof elementor != 'undefined' ? elementor : elementorFrontend;
        // lazy load image
        var GlobalLazyLoad = function($scope, $) {
            elementorFrontend.waypoint($scope.find('.cms-lazy'), function() {
                // remove css class
                $(this).removeClass('lazy-loading').addClass('cms-lazy-loaded');
                // add style
                var duration = $(this).data('duration');
                if(typeof duration != 'undefined'){
                    $(this).css({'animation-duration': duration+'ms'});
                }
            }, {
                //offset: 'top-in-view'
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', GlobalLazyLoad);
        // Animate
        var GlobalWidgetAnimateHandler = function($scope, $) {
            elementorFrontend.waypoint($scope.find('.elementor-invisible'), function() {
                var $heading = $(this),
                    data = $heading.data('settings');

                if (typeof data['_animation'] != 'undefined') {
                    //$heading.addClass(data['_animation']+' animated').removeClass('elementor-invisible');
                    setTimeout(function() {
                        $heading.removeClass('elementor-invisible').addClass('animated ' + data['_animation']);
                    }, data['animation_delay']);
                }
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', GlobalWidgetAnimateHandler);
        // CMS Sticky
        var WidgetCMSStickyHandler = function( $scope, $ ) {
            // Stick at bottom of window
            var sticky_bottom = $scope.find('.cms-sticky-bottom');
            sticky_bottom.each(function(){
                var window_h = $(window).height(),
                    sticky_bottom_h = $(this).outerHeight(),
                    sticky_top = window_h - sticky_bottom_h - 20,
                    sticky__top = sticky_top+'px;';
                $(this).css('top', sticky_top);
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSStickyHandler);
        // CMS Text Scroll
        var CMSTextScrollHandler = function($scope, $) {
            // Swiper Scroll
            const Swiper = elementorFrontend.utils.swiper,
                carousel = $scope.find(".cms-swiper-container"),
                carousel_settings = {
                    wrapperClass: 'cms-swiper-wrapper',
                    slideClass: 'cms-swiper-slide',
                    slidesPerView: 'auto',
                    centeredSlides: true,
                    spaceBetween: 10,
                    speed: 4000,
                    watchSlidesProgress: true,
                    watchSlidesVisibility: true,
                    autoplay: {
                        delay: 0,
                        pauseOnMouseEnter: true
                    },
                    loop: true,
                    navigation: false,
                    pagination: false
                };
            carousel.each(function(index, element) {
                var swiper = new Swiper(carousel, carousel_settings);
            });
            // GSAP Text Parallax
            gsap.registerPlugin(ScrollTrigger);
            var cmsScroll = $scope.find( '.cms-text-parallax' ),
                maskImage   = cmsScroll.find( '.mask-img' ),
                maskContent = cmsScroll.find( '.cms-text-parallax-content-mask' ),
                sections = gsap.utils.toArray(".cms-text-parallax-item"),
                slides = document.querySelectorAll(".fromRight"); 
            cmsScroll.each(function(){
                ScrollTrigger.create({
                    trigger: $(this),
                    start: 'top top',
                    end: () =>  "+=" + ($(this).find('.cms-text-parallax-item').outerHeight()),
                    pin: true,
                });
                if ( maskImage.length ) {
                    gsap.to(
                        maskImage, //[0] is for passing as pure js
                        {
                            scrollTrigger: {
                                trigger: maskImage,
                                start: '50% center',
                                scrub: 1,
                                toggleActions: 'restart pause reverse none',
                            },
                            webkitClipPath: 'inset(0% 0% 0% 0%)',
                            clipPath: 'inset(0% 0% 0% 0%)',
                            duration: 3,
                        }
                    );
                }

                if ( maskContent.length ) {
                    gsap.to(
                        maskContent, //[0] is for passing as pure js
                        {
                            scrollTrigger: {
                                trigger: maskContent,
                                start: '50% center',
                                scrub: 2.5,
                                toggleActions: 'restart pause reverse none',
                            },
                            webkitClipPath: 'inset(0% 0% 0% 0%)',
                            clipPath: 'inset(0% 0% 0% 0%)',
                            duration: 3,
                        }
                    );
                }
            });
        };
        // Make sure you run this code under Elementor.
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_text_scroll.default', CMSTextScrollHandler);
        // CMS Swiper Split Slider
        var CMSSplitSliderHandler = function($scope, $) {
            // Swiper Scroll
            const Swiper = elementorFrontend.utils.swiper,
                carousel = $scope.find(".cms-swiper-splits"),
                carousel_settings = {
                    wrapperClass: 'swiper-split-wrapper',
                    slideClass: 'cms-swiper-split',
                    slidesPerView: 1,
                    
                    direction: 'vertical',
                    loop: false,
                    mousewheel: true,
                    sensitivity: 0.1,
                    keyboard: true,
                    releaseOnEdges: true,
                    
                    spaceBetween: 0,
                    speed: 300,
                    watchSlidesProgress: true,
                    watchSlidesVisibility: true,
                    autoplay: {
                        delay: 60000,
                        pauseOnMouseEnter: true
                    },
                    navigation: false,
                    pagination: {
                        el: '.cms-swiper-splits-dots',
                        type: 'bullets',
                        bulletClass: 'cms-swiper-pagination-bullet',
                        bulletActiveClass: 'cms-swiper-pagination-bullet-active',
                        clickable: true,
                        renderBullet: function (index, className) {
                            var number = (index + 1);
                            if(number < 10) number = '0' + number;
                            return '<span class="' + className + '">' + number + "</span>";
                        }
                    }
                };
            carousel.each(function(index, element) {
                var swiper = new Swiper(carousel, carousel_settings);
            });
        }
        elementorFrontend.hooks.addAction('frontend/element_ready/global', CMSSplitSliderHandler);
        // CMS multiScroll Split Slider
        var CMSmultiScrollHandler = function($scope, $) {
            // multiScroll
            const multiScroll = $scope.find('.cms-multiScroll'),
                  data_settings =   multiScroll.data('settings'),
                  multiScroll_settings = {
                    menu: false,
                    sectionsColor: [],
                    navigation: true,
                    navigationPosition: 'right',
                    navigationColor: '#000',
                    navigationTooltips: [],
                  };
            multiScroll.each(function(){
                $(this).multiscroll({
                    //sectionsColor: ['#00b3d7', '#ed2', '#ff73a1'],
                    //anchors: ['first', 'second', 'third'],
                    //menu: '#menu',
                    loopTop: false,
                    loopBottom: false,
                    navigation: true,
                    navigationPosition: 'right',
                    // selector
                    sectionSelector: '.ms-section',
                    leftSelector: '.ms-left',
                    rightSelector: '.ms-right',
                    // responsive
                    responsiveWidth: 880,
                    responsiveHeight: 600,
                    responsiveExpand: true,
                    // events
                    afterRender: function(){
                        multiScroll.addClass('cms-rendered');
                        $('body').addClass(multiScroll.data('class'));
                        $('body').find('#multiscroll-nav').addClass(multiScroll.data('menu-class'));
                        //alert("The resulting DOM structure is ready");
                    }
                });
            });
        }
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_products_showcase.default', CMSmultiScrollHandler);
        // CMSProcessHandler
        var CMSProcessHandler = function($scope, $) {
            // Swiper Scroll
            const Swiper = elementorFrontend.utils.swiper,
                carousel = $scope.find(".cms-swiper-vertical"),
                carousel_settings = {
                    direction: "vertical",
                    mousewheel: true,
                    parallax: false,
                    autoplay: {
                        delay: 2000,
                        pauseOnMouseEnter: true
                    },
                    slidesPerView: 3,
                    slidesPerGroup: 1,
                    spaceBetween: 60,
                    speed: 1000,
                    navigation: false,
                    pagination: false,
                    loop: true,
                    on:{
                        afterInit: function(swiper) {
                            /*swiper.appendSlide(
                              '<div class="swiper-slide"></div>'
                            );*/
                            let thumbsSliderEls = $scope.find('.cms-process-banners');
                            if (thumbsSliderEls.length > 0) {
                                let thumbsSlider = new Swiper(thumbsSliderEls, {
                                    loop: false,
                                    slidesPerView: 1,
                                    slidesPerGroup: 1,
                                    effect: 'fade',
                                    on: {
                                        afterInit: function(thumbsSwiper) {
                                            swiper.thumbs = {
                                                swiper: thumbsSwiper
                                            };
                                        },
                                    },
                                });
                            }
                        }
                    },
                    breakpoints:{
                        1025 : {
                            slidesPerView: 2,
                            slidesPerGroup: 1
                        }
                    }
                };
            carousel.each(function(index, element) {
                var swiper = new Swiper(carousel, carousel_settings);
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_process.default', CMSProcessHandler);

        // CMS Progress Bar
        var WidgetCMSProgressBarHandler = function($scope, $) {
            elementorFrontend.waypoint($scope.find('.cms-progress-bar-wrap'), function() {
                var $progressbar_w = $(this).find('.cms-progress-bar-w'),
                    $progressbar_h = $(this).find('.cms-progress-bar-h');
                $progressbar_w.css('width', $progressbar_w.data('max') + '%');
                $progressbar_h.css('height', $progressbar_h.data('max') + '%');

                var $number = $(this).find('.cms-progress-bar-number'),
                    data = $number.data(),
                    decimalDigits = data.toValue.toString().match(/\.(.*)/);
                if (decimalDigits) {
                    data.rounding = decimalDigits[1].length;
                }
                $number.numerator(data);
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSProgressBarHandler);
        // CMS Image Cursor
        var WidgetCMSPointerImageCursor = function ($scope, $){
            var $links            = $scope.find( '.cms-img-cursor' ),
                x                 = 0,
                y                 = 0,
                currentXCPosition = 0,
                currentYCPosition = 0;

            if ( $links.length ) {
                $links.on(
                    'mouseenter',
                    function () {
                        $links.removeClass( 'cms--active' );
                        $( this ).addClass( 'cms--active' );
                    }
                ).on(
                    'mousemove',
                    function ( event ) {
                        var $thisLink         = $( this ),
                            $followInfoHolder = $thisLink.find( '.cms-cursor-pointer' ),
                            $followImage      = $followInfoHolder.find( '.cms-cursor--pointer' ),
                            $followImageItem  = $followImage.find( 'img' ),
                            followImageWidth  = $followImageItem.width(),
                            followImagesCount = parseInt( $followImage.data( 'images-count' ), 10 ),
                            followImagesSrc   = $followImage.data( 'images' ),
                            $followTitle      = $followInfoHolder.find( '.cms-cursor--title' ),
                            itemWidth         = $thisLink.outerWidth(),
                            itemHeight        = $thisLink.outerHeight(),
                            itemOffsetTop     = $thisLink.offset().top - $( window ).scrollTop(),
                            itemOffsetLeft    = $thisLink.offset().left;
                        x = (event.clientX - itemOffsetLeft) >> 0;
                        y = (event.clientY - itemOffsetTop) >> 0;

                        if ( x > itemWidth ) {
                            currentXCPosition = itemWidth;
                        } else if ( x < 0 ) {
                            currentXCPosition = 0;
                        } else {
                            currentXCPosition = x;
                        }

                        if ( y > itemHeight ) {
                            currentYCPosition = itemHeight;
                        } else if ( y < 0 ) {
                            currentYCPosition = 0;
                        } else {
                            currentYCPosition = y;
                        }

                        if ( followImagesCount > 1 ) {
                            var imagesUrl    = followImagesSrc.split( '|' ),
                                itemPartSize = itemWidth / followImagesCount;

                            $followImageItem.removeAttr( 'srcset' );

                            if ( currentXCPosition < itemPartSize ) {
                                $followImageItem.attr( 'src', imagesUrl[0] );
                            }

                            // -2 is constant - to remove first and last item from the loop
                            for ( var index = 1; index <= (followImagesCount - 2); index++ ) {
                                if ( currentXCPosition >= itemPartSize * index && currentXCPosition < itemPartSize * (index + 1) ) {
                                    $followImageItem.attr( 'src', imagesUrl[index] );
                                }
                            }

                            if ( currentXCPosition >= itemWidth - itemPartSize ) {
                                $followImageItem.attr( 'src', imagesUrl[followImagesCount - 1] );
                            }
                        }

                        $followImage.css(
                            {
                                'top': itemHeight / 2,
                            }
                        );
                        $followTitle.css(
                            {
                                'transform': 'translateY(' + -(parseInt( itemHeight, 10 ) / 2 + currentYCPosition) + 'px)',
                                'left': -(currentXCPosition - followImageWidth / 2),
                            }
                        );
                        $followInfoHolder.css( { 'top': currentYCPosition, 'left': currentXCPosition } );
                    }
                ).on(
                    'mouseleave',
                    function () {
                        $links.removeClass( 'cms--active' );
                    }
                );
            }
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSPointerImageCursor);
        // CMS Sticky Mousewheel
        var WidgetCMSStickyMouseWheel = function ($scope, $){
            var $sticky_mousewheel = $scope.find('.cms-sticky-mousewheel');
            $(window).on('scroll', function() {
                if($sticky_mousewheel != 'undefined'){            
                    $sticky_mousewheel.each(function (){
                        var $sticky_mousewheel_inner = $(this).find('.cms-sticky--mousewheel'),
                            $sticky_mousewheel_offset_top = $(this).data('offset'),
                            $sticky_offsetTop = $(this).position().top,
                            $scroll_Top = $(this).offset().top - $(window).scrollTop();
                        if($scroll_Top == $sticky_mousewheel_offset_top){
                            $sticky_mousewheel_inner.addClass('cms-accs--item-sticky cms-mousewheel');
                        } else {
                            $sticky_mousewheel_inner.removeClass('cms-accs--item-sticky cms-mousewheel');
                        }
                    });
                }
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSStickyMouseWheel);
    });
}(jQuery));