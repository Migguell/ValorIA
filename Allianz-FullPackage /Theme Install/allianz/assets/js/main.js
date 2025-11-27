(function($) {
    "use strict";
    /* ===================
     Page reload 
     ===================== */
    var window_h = $(window).height(),
        window_w = $(window).width();
    var windowHeight = window.innerHeight;
    var windowWidth = window.innerWidth;
    var scrollTop = $(window).scrollTop();
    var scroll_top;
    var last_scroll_top = 0;
    var $imgLogo = $('#cms-header .site-logo img');
    var srcLogo = $imgLogo.attr('src'),
        srcLogoMobile = $imgLogo.data('mobile'),
        logo_tablet_mobile_size = 1025;
    var dataSticky = $imgLogo.data('sticky');
    var dataStickyMobile = $imgLogo.data('sticky-mobile');
    var $header = $('#cms-header');
    var header_height = $header.outerHeight();
    var header_btn1 = $header.find('.h-btn1'),
        header_btn1_classes = header_btn1.data('classes'),
        header_btn2 = $header.find('.h-btn2'),
        header_btn2_classes = header_btn2.data('classes'),
        header_btn_phone = $header.find('.site-header-phone .btn'),
        header_btn_phone_classes = header_btn_phone.data('classes');

    $(window).on('load', function() {
        $(".cms-loader").fadeOut("slow");
        scroll_top = $(this).scrollTop();
        if (scroll_top > header_height) {
            $header.addClass('header-sticky-hidden');
        }
        if ($(window).outerWidth() < logo_tablet_mobile_size && srcLogoMobile != null) {
            $($imgLogo).attr('src', srcLogoMobile);
        }
        // change class for header button
        if ($header.hasClass('header-transparent')) {
            setTimeout(function() {
                $('body').css('--cms-wrap-header-height', $('.header-transparent').outerHeight() + 'px');
            }, 1000);
            // Header button Class
            if (header_btn1.length > 0) {
                header_btn1.removeClass(header_btn1_classes['default'].replace('+', ' ')).addClass(header_btn1_classes['transparent'].replace('+', ' '));
            }
            if (header_btn2.length > 0) {
                header_btn2.removeClass(header_btn2_classes['default'].replace('+', ' ')).addClass(header_btn2_classes['transparent'].replace('+', ' '));
            }
            if (header_btn_phone.length > 0) {
                //header_btn_phone.removeClass(header_btn_phone_classes['default']).addClass(header_btn_phone_classes['transparent']);
            }
        } else {
            if (header_btn1.length > 0) {
                header_btn1.removeClass(header_btn1_classes['transparent'].replace('+', ' ')).addClass(header_btn1_classes['default'].replace('+', ' '));
            }
            if (header_btn2.length > 0) {
                header_btn2.removeClass(header_btn2_classes['transparent'].replace('+', ' ')).addClass(header_btn2_classes['default'].replace('+', ' '));
            }
            if (header_btn_phone.length > 0) {
                header_btn_phone.removeClass(header_btn_phone_classes['transparent'].replace('+', ' ')).addClass(header_btn_phone_classes['default'].replace('+', ' '));
            }
        }
        //
        allianz_dropdown_touched_side();
        //allianz_header_cart_dropdown();
        // ScrollWheel
        allianz_scrollwheel();
        // WooCommerce
        allianz_single_product_gallery_arrows();
    });

    $(window).on('resize', function() {
        if ($header.hasClass('header-transparent')) {
            setTimeout(function() {
                $('body').css('--cms-wrap-header-height', $('.header-transparent').outerHeight() + 'px');
            }, 0);
        }
        if ($header.hasClass('header-sticky-show')) {
            $header.addClass('header-sticky-hidden').removeClass('header-sticky-show');
        }

        if ($(window).outerWidth() < logo_tablet_mobile_size && srcLogoMobile != null) {
            $($imgLogo).attr('src', srcLogoMobile);
        } else {
            $($imgLogo).attr('src', srcLogo);
        }
        $('.cms-primary-menu-dropdown .sub-menu').removeClass('submenu-open').attr('style', '');
        // Dropdown Mega Menu
        allianz_dropdown_mega_menu_full_width();
        allianz_header_cart_dropdown();
        allianz_dropdown_touched_side();
        // WooCommerce
        allianz_single_product_gallery_arrows();
    });

    /* ====================
        Scroll To Top
    ====================== */
    $(window).on('scroll', function() {
        scroll_top = $(this).scrollTop();
        allianz_header_sticky();
        allianz_add_on_scroll();
        allianz_scroll_to_top();
        last_scroll_top = scroll_top;
    });

    function allianz_scroll_to_top() {
        if (scroll_top > last_scroll_top && scroll_top > header_height + 300) {
            $('.scroll-top').removeClass('to-top-show').addClass('to-top-hidden');
        } else {
            $('.scroll-top').removeClass('to-top-hidden').addClass('to-top-show');
            if (scroll_top < header_height + 300) {
                $('.scroll-top').removeClass('to-top-hidden').removeClass('to-top-show');
            }
        }
    }
    /* ====================
        Header Sticky
    ====================== */
    function allianz_header_sticky() {
        //if($header.hasClass('sticky-on')){
        if (scroll_top > 2 && scroll_top < header_height && $header.hasClass('transparent-on')) {
            $header.addClass('header-sticky-show');
            $imgLogo.attr('src', dataSticky);
            if ($(window).outerWidth() < logo_tablet_mobile_size && dataStickyMobile != null) {
                $($imgLogo).attr('src', dataStickyMobile);
            }
            // change class for header button
            if (header_btn1.length > 0) {
                header_btn1.removeClass(header_btn1_classes['transparent'].replace('+', ' ')).addClass(header_btn1_classes['default'].replace('+', ' '));
            }
            if (header_btn2.length > 0) {
                header_btn2.removeClass(header_btn2_classes['transparent'].replace('+', ' ')).addClass(header_btn2_classes['default'].replace('+', ' '));
            }
            if (header_btn_phone.length > 0) {
                header_btn_phone.removeClass(header_btn_phone_classes['transparent'].replace('+', ' ')).addClass(header_btn_phone_classes['default'].replace('+', ' '));
            }
        }

        if (scroll_top > last_scroll_top && scroll_top > header_height) {
            if (!$header.hasClass('header-sticky-hidden')) {
                $header.removeClass('header-sticky-show').addClass('header-sticky-hidden header-sticky-hidden-1');

                if($header.hasClass('sticky-always')){
                    $($imgLogo).attr('src', dataSticky);
                    if ($(window).outerWidth() < logo_tablet_mobile_size) {
                        $($imgLogo).attr('src', dataStickyMobile);
                    }
                    // change class for header button
                    if (header_btn1.length > 0) {
                        header_btn1.removeClass(header_btn1_classes['transparent'].replace('+', ' ')).addClass(header_btn1_classes['default'].replace('+', ' '));
                    }
                    if (header_btn2.length > 0) {
                        header_btn2.removeClass(header_btn2_classes['transparent'].replace('+', ' ')).addClass(header_btn2_classes['default'].replace('+', ' '));
                    }
                    if (header_btn_phone.length > 0) {
                        header_btn_phone.removeClass(header_btn_phone_classes['transparent'].replace('+', ' ')).addClass(header_btn_phone_classes['default'].replace('+', ' '));
                    }
                } else {
                    $($imgLogo).attr('src', srcLogo);
                    if ($(window).outerWidth() < logo_tablet_mobile_size) {
                        $($imgLogo).attr('src', srcLogoMobile);
                    }
                    // change class for header button
                    if (header_btn1.length > 0) {
                        header_btn1.removeClass(header_btn1_classes['default'].replace('+', ' ')).addClass(header_btn1_classes['transparent'].replace('+', ' '));
                    }
                    if (header_btn2.length > 0) {
                        header_btn2.removeClass(header_btn2_classes['default'].replace('+', ' ')).addClass(header_btn2_classes['transparent'].replace('+', ' '));
                    }
                    if (header_btn_phone.length > 0) {
                        header_btn_phone.removeClass(header_btn_phone_classes['default'].replace('+', ' ')).addClass(header_btn_phone_classes['transparent'].replace('+', ' '));
                    }
                }
            }
            if ($header.hasClass('header-mobile-open')) {
                $imgLogo.attr('src', dataSticky);
                if ($(window).outerWidth() < logo_tablet_mobile_size) {
                    $($imgLogo).attr('src', dataStickyMobile);
                }
            }
        } else {
            if ($header.hasClass('header-sticky-hidden') && $header.hasClass('sticky-on')) {
                $header.removeClass('header-sticky-hidden').addClass('header-sticky-show');
                $imgLogo.attr('src', dataSticky);
                if ($(window).outerWidth() < logo_tablet_mobile_size) {
                    $($imgLogo).attr('src', dataStickyMobile);
                }
                if (!$header.hasClass('transparent-on')) {
                    $('#cms-header-wrap').height(header_height);
                }
                // change class for header button
                if (header_btn1.length > 0) {
                    header_btn1.removeClass(header_btn1_classes['transparent'].replace('+', ' ')).addClass(header_btn1_classes['default'].replace('+', ' '));
                }
                if (header_btn2.length > 0) {
                    header_btn2.removeClass(header_btn2_classes['transparent'].replace('+', ' ')).addClass(header_btn2_classes['default'].replace('+', ' '));
                }

                if (header_btn_phone.length > 0) {
                    header_btn_phone.removeClass(header_btn_phone_classes['transparent'].replace('+', ' ')).addClass(header_btn_phone_classes['default'].replace('+', ' '));
                }
            }
            if (scroll_top < header_height) {
                $header.removeClass('header-sticky-hidden').removeClass('header-sticky-show');
                if (!$header.hasClass('transparent-on')) {
                    $('#cms-header-wrap').height('auto');
                }

                // change class for header button
                if (header_btn1.length > 0) {
                    header_btn1.removeClass(header_btn1_classes['default'].replace('+', ' ')).addClass(header_btn1_classes['transparent'].replace('+', ' '));
                }
                if (header_btn2.length > 0) {
                    header_btn2.removeClass(header_btn2_classes['default'].replace('+', ' ')).addClass(header_btn2_classes['transparent'].replace('+', ' '));
                }
                if (header_btn_phone.length > 0 && $header.hasClass('transparent-on')) {
                    header_btn_phone.removeClass(header_btn_phone_classes['default'].replace('+', ' ')).addClass(header_btn_phone_classes['transparent'].replace('+', ' '));
                }

                $imgLogo.attr('src', srcLogo);
                if ($(window).outerWidth() < logo_tablet_mobile_size) {
                    $($imgLogo).attr('src', srcLogoMobile);
                }
                if ($header.hasClass('transparent-on') && $header.hasClass('header-mobile-open')) {
                    $($imgLogo).attr('src', dataSticky);
                } else {
                    $($imgLogo).attr('src', srcLogo);
                }
                if ($(window).outerWidth() < logo_tablet_mobile_size) {
                    if ($header.hasClass('transparent-on') && $header.hasClass('header-mobile-open')) {
                        $($imgLogo).attr('src', dataStickyMobile);
                    } else {
                        $($imgLogo).attr('src', srcLogoMobile);
                    }
                }
            }
            if ($header.hasClass('header-mobile-open')) {
                $header.removeClass('header-sticky-hidden').addClass('header-sticky-show');
            }
        }
        //} 
    }

    $(document).ready(function() {
        /* =================
         Menu Dropdown
         =================== */
        var $menu = $('.site-navigation-dropdown');
        $menu.find('.cms-primary-menu-dropdown li').each(function() {
            var $submenu = $(this).find('> ul.sub-menu');
            if ($submenu.length == 1) {
                $(this).on('hover', function() {
                    if ($submenu.offset().left + $submenu.outerWidth() > $(window).width()) {
                        $submenu.addClass('back');
                    } else if ($submenu.offset().left < 0) {
                        $submenu.addClass('back');
                    }
                }, function() {
                    $submenu.removeClass('back');
                });
            }
        });

        $('.sub-menu .current-menu-item').parents('.menu-item-has-children').addClass('current-menu-ancestor');
        $('.mega-auto-width').parents('.megamenu').addClass('remove-pos');
        // add current ancestor for mega parent 
        $('.cms-emenu-6 > .cms-title').each(function() {
            var mega_url = $(this).attr("href");
            var mega_root = window.location.href;
            if (mega_url == mega_root) {
                $('.cms-emenu-6 > .cms-title').addClass('current');
                $('.cms-emenu-6 > .cms-title').parents('.menu-item-has-children').addClass('current-menu-ancestor');
            }
        });
        /* =================
         Menu Mobile
         =================== */
        $("#main-menu-mobile").on('click', function(e) {
            e.preventDefault();
            $('#cms-header').toggleClass('header-mobile-open');
            $(this).find('.open-menu').toggleClass('opened');
            $('.site-navigation').toggleClass('navigation-open');
            if (scroll_top < header_height) {
                $header.removeClass('header-sticky-hidden').removeClass('header-sticky-show');
            }
            if (scroll_top < header_height) {
                if ($header.hasClass('transparent-on') && $header.hasClass('header-mobile-open')) {
                    //$($imgLogo).attr('src', dataSticky);
                } else {
                    //$($imgLogo).attr('src', srcLogo);
                }
            }
            if ($(window).outerWidth() < logo_tablet_mobile_size) {
                if (scroll_top < header_height) {
                    if ($header.hasClass('transparent-on') && $header.hasClass('header-mobile-open')) {
                        $($imgLogo).attr('src', dataStickyMobile);
                    } else {
                        $($imgLogo).attr('src', srcLogoMobile);
                    }
                }
            }
        });
        $("#main-menu-mobile-close").on('click', function() {
            $('#cms-header').removeClass('header-mobile-open');
            $('.site-navigation').removeClass('navigation-open');
            $('.open-menu').removeClass('opened');
        });
        /* Mobile Sub Menu */
        $('.main-menu-toggle').on('click', function(e) {
            e.preventDefault();
            $(this).toggleClass('open');
            $(this).parents('.menu-item').find('> .sub-menu').toggleClass('submenu-open');
            $(this).parent('.cms-menu-link').next('.sub-menu').slideToggle();
        });

        // HTML Checkbox
        allianz_checkbox();
        // Modal
        allianz_modal();
        // Dropdown Mega Menu
        allianz_dropdown_mega_menu_full_width();
        // Dropdown touched side
        allianz_dropdown_touched_side();
        // Lazy load
        allianz_lazy_images();
        // on scroll
        allianz_add_on_scroll();
        // Woo
        allianz_quantity_plus_minus_action();
        allianz_header_cart_dropdown();
        allianz_single_product_gallery_arrows();
        allianz_woo_checkout_place_order_button();
        allianz_woocs_menu_change_currency();

        // WPCF7
        allianz_wpcf7();
        // Select 2 
        allianz_select2();
    });
    // Ajax Complete
    $(document).ajaxComplete(function(event, xhr, settings) {
        "use strict";
        // Modal
        allianz_modal();
        // WPCF7
        allianz_wpcf7();
        // WooCommerce
        allianz_woo_checkout_place_order_button();
        allianz_single_product_gallery_arrows();
        // Select 2 
        allianz_select2();
    });
    /**
     * HTML Checkbox
     * */
    function allianz_checkbox() {
        'use strict';
        $('.cms-checkbox').on('click', function() {
            $(this).toggleClass('cms-checked')
        });
    }
    /**
     * Modal
     * 
     * */
    function allianz_modal() {
        'use strict';
        $('.cms-modal').each(function() {
            var modal_open = $(this).data('modal'),
                modal_mode = $(this).data('modal-mode'),
                modal_slide = $(this).data('modal-slide'),
                modal_class = $(this).data('modal-class'),
                modal_width = $(this).data('modal-width'),
                modal_hidden = $(this).data('modal-hidden'),
                modal_placeholder = $(this).data('modal-placeholder'),
                close_text = $(this).data('close-text');
            $(modal_open).addClass('cms-modal-' + modal_mode);
            $(modal_open).addClass('cms-modal-' + modal_mode + '-' + modal_slide);
            $(modal_open).addClass(modal_class);
            $(modal_open).css('--cms-modal-width', modal_width);
            if (typeof modal_placeholder != 'undefined') {
                $(modal_open).find('.search-popup .cms-search-popup-input').attr('placeholder', modal_placeholder);
            }
            if (typeof close_text != 'undefined' && typeof close_text != '') {
                $(modal_open).find('.cms-close').prepend('<span class="close-text">' + close_text + '</span>');
            }
            if (typeof modal_hidden != 'undefined') {
                $(modal_open).find('.cms-close').attr('data-modal-hidden', modal_hidden);
            }
        });
        $('.cms-modal').on('click', function(e) {
            e.preventDefault();
            var modal_open = $(this).data('modal'),
                focus = $(this).data('focus'),
                modal_slide = $(this).data('modal-slide'),
                overlay_class = $(this).data('overlay-class'),
                modal_hidden = $(this).data('modal-hidden');
            $(this).toggleClass('open');
            $(modal_open).toggleClass('open');
            if (typeof focus != 'undefined') {
                setTimeout(function() {
                    $(focus).focus();
                }, 300);
            }
            //
            $('html').toggleClass('cms-modal-opened');
            $('body').find('.cms-modal-overlay').addClass(overlay_class);
            $('body').find('.cms-modal-overlay').toggleClass('open');
            $('body').find('.cms-modal-overlay').attr('data-modal-hidden', modal_hidden);
            $(modal_hidden).css({ 'opacity': '0', 'visibility': 'hidden' });
        });
        $('.cms-close').on('click', function(e) {
            e.preventDefault();
            var modal_hidden = $(this).data('modal-hidden');
            $('html').removeClass('cms-modal-opened');
            $(this).parents('.cms-modal-html').removeClass('open');
            $(this).parents('body').find('.cms-modal.open').removeClass('open');
            $(this).parents('body').find('.cms-modal-overlay.open').removeClass('open');
            // get back
            $(modal_hidden).css({ 'opacity': '', 'visibility': '' });
        });
        $('.cms-modal-overlay').on('click', function(e) {
            e.preventDefault();
            var modal_hidden = $(this).data('modal-hidden');
            $(this).removeClass('open');
            $('html').removeClass('cms-modal-opened');
            $(this).parent().find('.cms-modal.open').removeClass('open');
            $(this).parent().find('.cms-modal-html.open').removeClass('open');
            // get back
            $(modal_hidden).css({ 'opacity': '', 'visibility': '' });
        });
    }
    /**
     * Dropdown Mega Menu
     * Full Width
     **/
    function allianz_dropdown_mega_menu_full_width() {
        'use strict';
        var parentPos = $('.cms-primary-menu'),
            window_width = $(window).width();
        parentPos.find('.megamenu').each(function() {
            var megamenu = $(this).find('> .cms-megamenu-full');
            if (megamenu.length == 1 && $(this).offset().left != 'undefined') {
                var megamenuPos = $(this).offset().left;
                if (window_width > 1279) {
                    if (allianz_is_rtl()) {
                        megamenu.css({ 'right': megamenuPos, 'left': 'auto' });
                    } else {
                        megamenu.css({ 'left': megamenuPos * -1, 'right': 'auto' });
                    }
                } else {
                    megamenu.css({ 'left': '', 'right': '' });
                }
            }
            // Mega menu container
            var megamenu_container = $(this).find('> .cms-megamenu-container');
            if (megamenu_container.length == 1 && $(this).offset().left != 'undefined') {
                var megamenu_container_w = megamenu_container.outerWidth(),
                    menuoffset = megamenu_container.offset().left,
                    megamenuPos = (menuoffset + megamenu_container_w - window_width) / -1;

                if ((menuoffset + megamenu_container_w) > window_width) {
                    if (allianz_is_rtl()) {
                        megamenu_container.css({ 'right': megamenuPos, 'left': 'auto' });
                    } else {
                        megamenu_container.css({ 'left': megamenuPos, 'right': 'auto' });
                    }
                } else {
                    megamenu_container.css({ 'left': '', 'right': '' });
                }
            }
        });
    }
    /**
     * Dropdown Touched Side
     * */
    function allianz_dropdown_touched_side() {
        setTimeout(function() {
            $('.cms-touchedside').each(function() {
                var content = $(this).find('.cms--touchedside'),
                    content_w = content.outerWidth(),
                    window_width = $(window).width(),
                    offsetLeft = $(this).offset().left,
                    offsetRight = window_width - offsetLeft - $(this).outerWidth();
                content.removeClass('back');
                $(this).attr('data-offset', offsetLeft);
                $(this).attr('data-w', content_w);
                $(this).attr('data-ww', window_width);
                if (content.length == 1) {
                    if (allianz_is_rtl()) {
                        if (offsetRight + content_w > window_width) {
                            var position = offsetRight + content_w - window_width;
                            content.css({ 'right': '0', 'left': 'auto' });
                            content.addClass('back');
                        } else {
                            content.css({ 'left': '', 'right': '' });
                            content.removeClass('back');
                        }
                    } else {
                        if (offsetLeft + content_w > window_width) {
                            var position = offsetLeft + content_w - window_width;
                            //content.css({'left': position*-1, 'right':'auto'});
                            content.css({ 'left': 'auto', 'right': '0' });
                            content.addClass('back');
                        } else {
                            content.css({ 'left': '0', 'right': 'auto' });
                            content.removeClass('back');
                        }
                    }
                }
            });
        }, 1000);
    }
    /*
     * Lazy Images
     */
    function allianz_lazy_images() {
        'use strict';
        setTimeout(function() {
            $('.cms-lazy').each(function() {
                $(this).removeClass('lazy-loading').addClass('cms-lazy-loaded');
            });
        }, 100);
    }
    /**
     * ScrollWheel
     * */
    function allianz_scrollwheel() {
        $('.cms-scrollwheel').each(function() {
            var parent = $(this).parents('.cms-enable-scrollwheel'),
                parent_h = parent.height(),
                padding_space = 50, //parseInt(parent.css('padding-top')) + parseInt(parent.css('padding-bottom')),
                sticky_top = parent.data('sticky-top'),
                scrollWheel_h = $(this).outerHeight(),
                other_h = parseInt(parent_h - scrollWheel_h);
            if (other_h < 0) other_h = other_h * -1;
            var mouseWheel_h = window_h - padding_space - other_h - sticky_top;
            // render
            $(this).css('--cms-scrollwheel-height', mouseWheel_h + 'px');
            parent.css('max-height', window_h - sticky_top);
        });
    }
    /**
     * Adding class on Scrolling
     * 
     * **/
    function allianz_add_on_scroll(){
        // add class when scrolling
        $('.cms-scrolling--').each(function () {
            var topLimit = 0; // parseFloat($('.cms-scrolling-item').first().css('top'));
            var bottomLimit = parseFloat($('.cms-scrolling-item').first().outerHeight())
                + parseFloat($('.cms-scrolling-item-02').css('margin-top'));
            $('.cms-scrolling-item').removeClass('preactive end').each(function (is) {
                var currentTop = $(this).offset().top - scrollTop - topLimit;
                var c = parseFloat(currentTop / bottomLimit);
                if (c < 0) c = 0;
                else if (c > 1) c = 1;

                if (c == 0 || is == 0){
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }

                if (c < .5 || is == 0) {
                    $(this).addClass('preactive');
                } else {
                    $(this).removeClass('preactive');
                }
            });

            $('.cms-scrolling-item.preactive').slice(0, -1).removeClass('active').addClass('end');

        });
    }

    /**
     * Check right to left
     */
    function allianz_is_rtl() {
        "use strict";
        var rtl = $('html[dir="rtl"]'),
            is_rtl = rtl.length ? true : false;
        return is_rtl;
    }
    /**
     * Header WooCommerce Cart Dropdown
     * */
    function allianz_header_cart_dropdown() {
        "use strict";
        var header_cart = $('.site-header-cart'),
            header_cart_content = $('.cms-header-cart-dropdown'),
            header_cart_content_h = header_cart_content.height();

        if (header_cart_content.length == 1) {
            $(window).on('scroll', function() {
                header_cart_content.removeClass('open');
            });
            header_cart.on('click touch', function() {
                //$(this).toggleClass('active');
                //header_cart_content.toggleClass('open');
            });
            header_cart.on('click', function(e) {
                //e.preventDefault();
                $(this).toggleClass('open');
                header_cart_content.toggleClass("open");
            });
            $('body').on('click', function() {
                //header_cart.removeClass('open');
                //header_cart_content.removeClass('open');
            });
        }
    }
    /**
     * WooCommerce 
     * Select 2 form product order form
     * */
    function allianz_select2() {
        'use strict';
        if (typeof jQuery.fn.select2 != 'undefined') {
            $('.woocommerce-ordering select').select2({
                theme: 'cms-dropdown',
                minimumResultsForSearch: -1
            });
        } else {
            $('.woocommerce-ordering select').addClass('no-select2');
        }
    }
    /*
     * WooCommerce Quantity action
     */
    function allianz_quantity_plus_minus_action() {
        "use strict";
        $(document).on('click', '.quantity .cms-qty-act', function() {
            var $this = $(this),
                spinner = $this.parents('.quantity'),
                input = spinner.find('input.qty'),
                step = input.attr('step'),
                min = input.attr('min'),
                max = input.attr('max'),
                value = parseInt(input.val());
            if (!value) value = 0;
            if (!step) step = 1;
            step = parseInt(step);
            if (!min) min = 0;
            var type = $this.hasClass('cms-qty-up') ? 'up' : 'down';
            switch (type) {
                case 'up':
                    if (!(max && value >= max))
                        input.val(value + step).change();
                    break;
                case 'down':
                    if (value > min)
                        input.val(value - step).change();
                    break;
            }
            if (max && (parseInt(input.val()) > max))
                input.val(max).change();
            if (parseInt(input.val()) < min)
                input.val(min).change();
        });
    }
    /**
     * WooCommerce Product Gallery
     * Flex direction Nav position
     * 
     * */
    function allianz_single_product_gallery_arrows() {
        'use strict';
        // fix arrow position
        if (typeof $.flexslider != 'undefined') {
            setTimeout(function() {
                $('.woocommerce-product-gallery').each(function() {
                    var flex_viewport = $(this).find('.flex-viewport'),
                        flex_viewport_h = flex_viewport.outerHeight(),
                        arrow_pos = (flex_viewport_h / 2),
                        arrow = $(this).find('.flex-direction-nav li');
                    arrow.css('top', arrow_pos);
                }), 1000
            });
        }
    }
    /**
     * WooCommerce
     * Place Order Button
     * Wrap text by Span
     * */
    function allianz_woo_checkout_place_order_button() {
        'use strict';
        setTimeout(function() {
            $('#place_order').wrapInner('<span class="cms-place-order"></span>');
        }, 1000);
    }
    /**
     * WooCommerce Currency Switcher
     * 
     * Add currency to menu
     * **/
    function allianz_woocs_menu_change_currency() {
        'use strict';
        $('.cms-woocs').on('click', function(e) {
            e.preventDefault();
            var currency = $(this).data('currency');
            window.location.href = location.protocol + '//' + location.host + location.pathname + '?currency=' + currency;
        });
    }
    // Contact form 7
    function allianz_wpcf7() {
        'use strict';
        // add radio class active for default item
        $('.wpcf7-radio').each(function() {
            $('input[checked="checked"]').parents('.wpcf7-list-item').addClass('active');
        });
        // add radio class active on click
        $('.wpcf7-radio .wpcf7-list-item').on('click', function() {
            $(this).parent().find('.wpcf7-list-item').removeClass('active');
            $(this).toggleClass('active');
        });
        // add checkbox class active for default item
        $('.wpcf7-checkbox').each(function() {
            //$('input[checked="checked"]').parents('.wpcf7-list-item').addClass('active');
        });
        // add checkbox class active on click
        $('.wpcf7-checkbox .wpcf7-list-item').on('click', function() {
            $(this).toggleClass('active');
        });
        // date time
        $('.wpcf7-form-control-wrap.cms-date-time').on('click', function() {
            $(this).addClass('active');
        });
    }
})(jQuery);

/**
 * WPC Smart Wishlist
 * update wishlist count on header 
 */
jQuery(document).on('woosw_change_count', function(event, count) {
    jQuery('.wishlist-count').html(count);
    jQuery('.wishlist-icon').attr('data-count', count);
});
/**
 * WPC Smart Compare
 * update compare count on header 
 */
jQuery(document).on('woosc_change_count', function(event, count) {
    jQuery('.compare-count').html(count);
    jQuery('.compare-icon').attr('data-count', count);
});

/**
 * Popup Newsletter
 * 
 * */
(function($) {
    'use strict';
    window.AllianzCore = {};
    AllianzCore.body = $('body');
    AllianzCore.html = $('html');
    AllianzCore.windowWidth = $(window).width();
    AllianzCore.windowHeight = $(window).height();
    AllianzCore.scroll = 0;
    $(window).on(
        'load',
        function() {
            AllianzSubscribeModal.init();
        }
    );

    var AllianzSubscribeModal = {
        init: function() {
            this.holder = $('#cms-subscribe-popup');

            if (this.holder.length) {
                var $preventHolder = this.holder.find('.cms-sp-prevent-inner'),
                    $modalClose = $('.cms-sp-close'),
                    disabledPopup = 'no';

                if ($preventHolder.length) {
                    var isLocalStorage = this.holder.hasClass('cms-sp-prevent-cookies'),
                        $preventInput = $preventHolder.find('.cms-sp-prevent-input');

                    if (isLocalStorage) {
                        disabledPopup = localStorage.getItem('disabledPopup');
                        sessionStorage.removeItem('disabledPopup');
                    } else {
                        disabledPopup = sessionStorage.getItem('disabledPopup');
                        localStorage.removeItem('disabledPopup');
                    }

                    $preventHolder.children().on(
                        'click',
                        function(e) {
                            $preventInput.val(this.checked);

                            if ($preventInput.attr('value') === 'true') {
                                if (isLocalStorage) {
                                    localStorage.setItem('disabledPopup', 'yes');
                                } else {
                                    sessionStorage.setItem('disabledPopup', 'yes');
                                }
                            } else {
                                if (isLocalStorage) {
                                    localStorage.setItem('disabledPopup', 'no');
                                } else {
                                    sessionStorage.setItem('disabledPopup', 'no');
                                }
                            }
                        }
                    );
                }

                if (disabledPopup !== 'yes') {
                    if (AllianzCore.body.hasClass('cms-sp-opened')) {
                        AllianzSubscribeModal.handleClassAndScroll('remove');
                    } else {
                        AllianzSubscribeModal.handleClassAndScroll('add');
                    }

                    $modalClose.on(
                        'click',
                        function(e) {
                            e.preventDefault();

                            AllianzSubscribeModal.handleClassAndScroll('remove');
                        }
                    );

                    // Close on escape
                    $(document).keyup(
                        function(e) {
                            if (e.keyCode === 27) { // KeyCode for ESC button is 27
                                AllianzSubscribeModal.handleClassAndScroll('remove');
                            }
                        }
                    );
                }
            }
        },

        handleClassAndScroll: function(option) {
            if (option === 'remove') {
                AllianzCore.body.removeClass('cms-sp-opened');
            }

            if (option === 'add') {
                AllianzCore.body.addClass('cms-sp-opened');
            }
        },
    };

})(jQuery);
/**
 * Allianz 
 * Mouse Cursor
 * 
 * **/
(function($) {
    'use strict';
    // This case is important when theme is not active
    if (typeof AllianzCore !== 'object') {
        window.AllianzCore = {};
    }
    window.AllianzCore = {};
    AllianzCore.body = $('body');
    AllianzCore.html = $('html');
    AllianzCore.windowWidth = $(window).width();
    AllianzCore.windowHeight = $(window).height();
    AllianzCore.scroll = 0;

    $(document).ready(function() {
        CMSThemeCursor().init();
    });

    function CMSThemeCursor() {
        var cursorEnabled = AllianzCore.body.hasClass('cms-theme-cursor'),
            cursor = $('#cms-theme-cursor');
        var moveCursor = function() {
            var transformCursor = function(x, y) {
                cursor.css({
                    'transform': 'translate3d(' + x + 'px, ' + y + 'px, 0)'
                });
            };

            var handleMove = function(e) {
                var x = e.clientX - cursor.width() / 2,
                    y = e.clientY - cursor.height() / 2;

                requestAnimationFrame(function() {
                    transformCursor(x, y);
                });
            };

            $(window).on('mousemove', handleMove);
        };

        var hoverClass = function() {
            $('.button').disabled = false;

            var items = 'a, button';
            var addCSSClass = function() {
                !cursor.hasClass('cms-hovering') && cursor.addClass('cms-hovering');
            };

            var removeCSSClass = function() {
                cursor.hasClass('cms-hovering') && cursor.removeClass('cms-hovering');
            };

            $(document).on('mouseenter', items, addCSSClass);
            $(document).on('mouseleave', items, removeCSSClass);
        };

        var showCursor = function() {
            !cursor.hasClass('cms-visible') && cursor.addClass('cms-visible');
        }

        var hideCursor = function() {
            cursor.hasClass('cms-visible') && cursor.removeClass('cms-visible cms-hovering');
        };

        var overrideCursor = function() {
            cursor.toggleClass('cms-override');
        };

        var controlItems = function() {
            var items = $('.cms-hover-move');
            items.length &&
                items.each(function() {
                    var item = $(this),
                        inner = item.children(),
                        coeff = item.parent().data('move') == 'strict' ? 0.6 : 1,
                        limit = 9 * coeff;

                    var cX, cY, w, h, x, y, inRange; //position variables

                    var updatePosition = function() {
                        cX = cursor.offset().left;
                        cY = cursor.offset().top;
                        w = item.width();
                        h = item.height();
                        x = item.offset().left + w / 2;
                        y = item.offset().top + h / 2;
                        inRange = Math.abs(x - cX) < w * coeff && Math.abs(y - cY) < h * coeff;
                    };

                    var coords = function() {
                        return {
                            x: Math.abs(cX - x) < limit ? cX - x : limit * (cX - x) / Math.abs(cX - x),
                            y: Math.abs(cY - y) < limit ? cY - y : limit * (cY - y) / Math.abs(cY - y)
                        }
                    };

                    var moveItem = function() {
                        inner.addClass('cms-moving');
                        var deltaX = 0,
                            deltaY = 0,
                            dX = coords().x,
                            dY = coords().y;

                        var transformItem = function() {
                            deltaX += (coords().x - dX) / 5;
                            deltaY += (coords().y - dY) / 5;

                            deltaX.toFixed(2) !== dX.toFixed(2) &&
                                inner.css({
                                    'transform': 'translate3d(' + deltaX + 'px, ' + deltaY + 'px, 0)',
                                    'transition': '1s cubic-bezier(.2,.84,.5,1)'
                                });

                            dX = deltaX;
                            dY = deltaY;

                            requestAnimationFrame(function() {
                                inRange && transformItem();
                            });
                        };

                        transformItem();
                    };

                    var resetItem = function() {
                        inner
                            .removeClass('cms-moving')
                            .css({
                                'transition': 'transform 1.6s',
                                'transform': 'translate3d(0px, 0px, 0px)'
                            })
                            .one(AllianzCore.CMSTransitionEnd, function() {
                                inner.removeClass('cms-controlled');
                                inner.css({
                                    'transition': 'none'
                                });
                            });
                    };

                    var setState = function() {
                        updatePosition();

                        if (inRange) {
                            !inner.hasClass('cms-moving') && moveItem(); //start move
                        } else {
                            inner.hasClass('cms-moving') && resetItem();
                        }
                        requestAnimationFrame(setState);
                    };
                    requestAnimationFrame(setState);
                });
        };

        var changeCursor = function() {
            var instances = [{
                        type: 'light',
                        triggers: '.cms-cursor-light'
                    },
                    {
                        type: 'dark',
                        triggers: '.cms-cursor-dark'
                    },
                    {
                        type: 'preloader',
                        triggers: '.cms-page-spinner'
                    },
                    {
                        type: 'drag',
                        triggers: '.drag-cursor'
                    },
                ],
                triggers = '',
                hides = '.cms-portfolio-info-float .cms-pli-link, .cms-pls-item-inner, .fluidvids, iframe',
                overrides = '.cms-portfolio-list.cms-item-layout--info-on-hover-boxed .cms-e';

            var setCursor = function(type) {
                cursor.addClass('cms-' + type);
            };

            var resetCursor = function() {
                instances.forEach(function(instance) {
                    cursor.removeClass('cms-' + instance.type);
                });
            };

            instances.forEach(function(instance, i) {
                triggers += instance.triggers;
                if (i + 1 < instances.length) triggers += ', ';

                $(document).on('mouseenter', instance.triggers, function() {
                    setCursor(instance.type);
                });
            });

            $(document).on('mouseleave', triggers, resetCursor);
            $(document).on('mouseenter mouseleave', overrides, function() {
                overrideCursor();
            });
            $(document).on('mousemove', hides, function() {
                hideCursor();
            });
            $(document).on('mouseleave', hides, function() {
                showCursor();
            });
            $(document).on('mouseleave', hideCursor);
            $(document).on('mouseenter', showCursor);
        };

        var isIE = function() {

            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");
            var isIE = false;

            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer
            {
                isIE = true;

                if (cursorEnabled) {
                    AllianzCore.body.removeClass('cms-theme-cursor');
                }
            } else // If another browser
            {
                isIE = false;
            }

            return isIE;
        };

        var init = function() {
            $(document).one('mousemove', function() {
                showCursor();
            });
            moveCursor();
            hoverClass();
            controlItems();
            changeCursor();
        };

        return {
            init: function() {
                !Modernizr.touch && cursorEnabled && !isIE() && init();
            }
        }
    }
})(jQuery);

/**
 * Allianz 
 * add class when css sticky actived
 * based on : https://usefulangle.com/post/108/javascript-detecting-element-gets-fixed-in-css-position-sticky
 * based on : https://codepen.io/paulobrien/pen/povzpga
 * **/
(function($) {
    "use strict";
    var stickyEls = $('.cms-sticky');
    $.each(stickyEls, function(index, stickyEl) {
        stickyEl = $(stickyEl);
        let observer = new IntersectionObserver(
            function([e]) {
                if (e.intersectionRatio < 1) {
                    $(e.target).removeClass('cms-sticky-active');
                } else {
                    $(e.target).addClass('cms-sticky-active');
                }
            }, { threshold: [1] }
        );
        observer.observe(stickyEl[0]);
    });
})(jQuery);