(function($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSPostCarouselHandler = function($scope, $) {
        const Swiper = elementorFrontend.utils.swiper,
            settings = getSettings(),
            slidesToShow = +settings.slides_to_show || 3,
            isSingleSlide = 1 === slidesToShow,
            breakpoints = elementorFrontend.config.responsive.activeBreakpoints,
            defaultSlidesToShowMap = {
                mobile: 1,
                tablet: isSingleSlide ? 1 : 2
            },
            defaultSpaceBetween = 40;
        const swiperOptions = {
            slidesPerView: slidesToShow,
            loop: 'yes' === settings.infinite,
            speed: settings.speed,
            handleElementorBreakpoints: true,
            watchSlidesProgress: true,
            watchSlidesVisibility: true,
            slideVisibleClass: 'swiper-slide-visible'
        };
        swiperOptions.breakpoints = {};
        let lastBreakpointSlidesToShowValue = slidesToShow;
        $.each(Object.keys(breakpoints).reverse(), function(i, breakpointName) {
            // Tablet has a specific default `slides_to_show`.
            const defaultSlidesToShow = defaultSlidesToShowMap[breakpointName] ? defaultSlidesToShowMap[breakpointName] : lastBreakpointSlidesToShowValue;

            const defaultSlidesPerGroup= defaultSlidesToShowMap[breakpointName] ? defaultSlidesToShowMap[breakpointName] : lastBreakpointSlidesToShowValue;

            swiperOptions.breakpoints[breakpoints[breakpointName].value] = {
                slidesPerView: +settings['slides_to_show_' + breakpointName] || defaultSlidesToShow,
                slidesPerGroup: +settings['slides_to_scroll_' + breakpointName] || defaultSlidesPerGroup
            };
            if (settings.space_between) {
                swiperOptions.breakpoints[breakpoints[breakpointName].value].spaceBetween = elementorFrontend.utils.controls.getResponsiveControlValue(settings, 'space_between', 'size', breakpointName) || defaultSpaceBetween;
            }
            lastBreakpointSlidesToShowValue = +settings['slides_to_show_' + breakpointName] || defaultSlidesToShow;
        });
        if ('yes' === settings.autoplay) {
            swiperOptions.autoplay = {
                delay: settings.autoplay_speed,
                disableOnInteraction: 'yes' === settings.pause_on_interaction
            };
        }
        if (isSingleSlide) {
            swiperOptions.effect = settings.effect;
            if ('fade' === settings.effect) {
                swiperOptions.fadeEffect = {
                    crossFade: true
                };
            }
        } else {
            swiperOptions.slidesPerGroup = +settings.slides_to_scroll || slidesToShow;
        }
        if (settings.space_between) {
            swiperOptions.spaceBetween = elementorFrontend.utils.controls.getResponsiveControlValue(settings, 'space_between', 'size') || defaultSpaceBetween;
        }
        if ('yes' === settings.arrows) {
            swiperOptions.navigation = {
                nextEl: '.cms-carousel-button-next',
                prevEl: '.cms-carousel-button-prev'
            };
        }
        if ('yes' === settings.dots) {
            let dotsEl = $scope.find('.cms-carousel-dots');
            swiperOptions.pagination = {
                el: dotsEl[0],
                type: 'bullets',
                bulletClass: 'cms-swiper-pagination-bullet',
                bulletActiveClass: 'cms-swiper-pagination-bullet-active active',
                clickable: true,
            };

            let dotsChildren = dotsEl.children();
            if(dotsChildren.length > 0){
                swiperOptions.pagination.renderBullet = function (index, className) {
                    let dotsChild = dotsChildren.eq(index)
                    dotsChild.addClass(className);
                    return dotsChild.prop('outerHTML');
                };
            }

            let numberOfDots = getSettings('number_of_dots');
            if(typeof numberOfDots != 'undefined'){
                swiperOptions.pagination.dynamicBullets = true;
                swiperOptions.pagination.dynamicMainBullets = numberOfDots;
            }
        }
        if ('yes' === settings.lazyload) {
            swiperOptions.lazy = {
                loadPrevNext: true,
                loadPrevNextAmount: 1
            };
        }

        swiperOptions.on = {
            beforeInit: function(swiper) {
                // hide all elements will run animation on all slides
                swiper.slides.find('[data-cms-animation]').each(function() {
                    $(this).addClass('elementor-invisible');
                });
            },
            init : function (swiper){
                // calculate nav vertical position
                var activeIndex = this.activeIndex;
                var current = this.slides.eq(activeIndex);
                var based = current.find('.swiper-nav-vert');
                if(based!= 'undefined'){
                    var based_h = based.outerHeight()/2;
                    if(based.parents('.cms-carousel')){
                        if(based_h){
                            based.parents('.elementor-widget-container').find('.cms-carousel-button').css('top', based_h+'px');
                        }
                    }
                }
            },
            resize : function(swiper){
                // calculate nav vertical position
                var activeIndex = this.activeIndex;
                var current = this.slides.eq(activeIndex);
                var based = current.find('.swiper-nav-vert');
                if(based!= 'undefined'){
                    var based_h = based.outerHeight()/2;
                    if(based.parents('.cms-carousel')){
                        if(based_h){
                            based.parents('.elementor-widget-container').find('.cms-carousel-button').css('top', based_h+'px');
                        }
                    }
                }
            },
            afterInit: function(swiper) {
                let thumbsSliderEls = $scope.find('.thumbs-slider');
                if (thumbsSliderEls.length > 0) {
                    let thumbsSlider = new Swiper(thumbsSliderEls, {
                        loop: true,
                        slidesPerView: 1,
                        effect: 'fade',
                        on: {
                            afterInit: function(thumbsSwiper) {
                                swiper.controller.control = thumbsSwiper;
                                thumbsSwiper.controller.control = swiper;
                            },
                        },
                    });
                }
            },
            slideChange: function(swiper) {
                let loopedSlides = swiper.loopedSlides;
                if (loopedSlides !== null) {
                    let activeIndex = swiper.activeIndex;
                    let current = swiper.slides.eq(activeIndex);

                    current.find('[data-cms-animation]').each(function() {
                        let item = $(this);
                        let animation_key = item.data('cms-animation');
                        let animation_delay_key = item.data('cms-animation-delay');
                        item.addClass('elementor-invisible').removeClass('animated ' + getSettings(animation_key));
                        setTimeout(function() {
                            item.removeClass('elementor-invisible').addClass('animated ' + getSettings(animation_key));
                        }, getSettings(animation_delay_key));
                    });

                    current.find('.cms-counter-number').each(function () {
                        var $number = $(this),
                            data = $number.data();

                        $number.text(data.fromValue);

                        var decimalDigits = data.toValue.toString().match(/\.(.*)/);

                        if (decimalDigits) {
                            data.rounding = decimalDigits[1].length;
                        }

                        $number.numerator(data);
                    });

                    for (let i = loopedSlides - 1; i >= 0; i--) {
                        nextSlideIndex = ++activeIndex;
                        nextSlide = swiper.slides.eq(nextSlideIndex);
                        nextSlide.find('[data-cms-animation]').each(function() {
                            let item = $(this);
                            let animation_key = item.data('cms-animation');
                            let animation_delay_key = item.data('cms-animation-delay');
                            item.addClass('elementor-invisible').removeClass('animated ' + getSettings(animation_key));
                            setTimeout(function() {
                                item.removeClass('elementor-invisible').addClass('animated ' + getSettings(animation_key));
                            }, getSettings(animation_delay_key));
                        });

                        nextSlide.find('.cms-counter-number').each(function () {
                            var $number = $(this),
                                data = $number.data();

                            $number.text(data.fromValue);

                            var decimalDigits = data.toValue.toString().match(/\.(.*)/);

                            if (decimalDigits) {
                                data.rounding = decimalDigits[1].length;
                            }

                            $number.numerator(data);
                        });
                    }
                }
            }
        };

        let carouselEls = $scope.find(".cms-carousel");

        $.each(carouselEls, function(i, carouselEl) {
            carouselEl = $(carouselEl);
            let swiper = new Swiper(carouselEl, swiperOptions);
        });
        function getSettings(setting) {
            let settings = {};
            const modelCID = $scope.data('model-cid') || '',
                isEdit = $scope.hasClass('elementor-element-edit-mode');
            if (isEdit && modelCID) {
                const data = elementorFrontend.config.elements.data[modelCID],
                    attributes = data.attributes;
                let type = attributes.widgetType || attributes.elType;
                if (attributes.isInner) {
                    type = 'inner-' + type;
                }
                let dataKeys = elementorFrontend.config.elements.keys[type];
                if (!dataKeys) {
                    dataKeys = elementorFrontend.config.elements.keys[type] = [];
                    $.each(data.controls, (name, control) => {
                        if (control.frontend_available) {
                            dataKeys.push(name);
                        }
                    });
                }
                $.each(data.getActiveControls(), function(controlKey) {
                    if (-1 !== dataKeys.indexOf(controlKey)) {
                        let value = attributes[controlKey];
                        if (value.toJSON) {
                            value = value.toJSON();
                        }
                        settings[controlKey] = value;
                    }
                });
            } else {
                settings = $scope.data('settings') || {};
            }
            return getItems(settings, setting);
        }

        function getItems(items, itemKey) {
            if (itemKey) {
                const keyStack = itemKey.split('.'),
                    currentKey = keyStack.splice(0, 1);
                if (!keyStack.length) {
                    return items[currentKey];
                }
                if (!items[currentKey]) {
                    return;
                }
                return this.getItems(items[currentKey], keyStack.join('.'));
            }
            return items;
        }
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_blog_carousel.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_slider.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_clients.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_testimonials.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_teams.default', WidgetCMSPostCarouselHandler);
        //theme
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_counter.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_service_carousel.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_industry_carousel.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_industry_scroll_carousel.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_case_carousel.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_career_carousel.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_process.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_gallery_carousel.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_headline.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_products_carousel.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_products_category.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_instagram.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_taxonomies.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_business_consultant.default', WidgetCMSPostCarouselHandler);
    });
})(jQuery);