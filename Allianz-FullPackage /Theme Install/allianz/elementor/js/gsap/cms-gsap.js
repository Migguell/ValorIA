(function($) {
    // CMS GSAP
    var WidgetCMSGSAPHandler = function($scope, $) {
        gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);
        var cmssroller_vertical = $scope.find(".cms-scroller-vertical"),
            cmssroller_horizontal = $scope.find(".cms-scroller-horizontal"),
            sections = gsap.utils.toArray(".cms-scroller-item"),
            scroll_vertical = $scope.find(".cms-scroller-vertical-item"),
            scroll_horizontal = $scope.find(".cms-scroller-horizontal-item");
        //
        $scope.find('.cms-stack-item').each(function() {
            var item_top_space = parseInt($(this).find('.cms-stack--item').css('padding-top')),
                item_title_h = $(this).find('.cms-stack-title').outerHeight(),
                item_header_h = item_top_space + item_title_h;
            $(this).find('.cms-scrollwheel').css('--cms-scrollwheel-height', item_title_h + 'px');
        });
        // Stacking section headers
        const allTitles = gsap.utils.toArray('.cms-stack-item'); //.row
        let offsets; // an Array with each title's offset
        let totalOffset; // adds up all the heights of the titles

        // to make it responsive, we put the calculations into a function that we call on window resize (and initially)
        function calculateOffsets() {
            totalOffset = 0;
            offsets = allTitles.map(title => {
                let prev = totalOffset;
                totalOffset += title.querySelector(".cms-stack-title").offsetHeight; // h1
                return prev;
            });
        }
        calculateOffsets();
        window.addEventListener("resize", calculateOffsets);

        allTitles.forEach((title, i) => {
            let heading = title.querySelector(".cms-stack--item");
            heading.style = '--cms-stack--item-height:calc(100vh - ' + offsets[i] + 'px)';

            ScrollTrigger.create({
                trigger: heading,
                endTrigger: ".cms-stack", //.row-wrap
                start: () => "top " + offsets[i],
                end: () => "bottom " + totalOffset,
                pin: heading,
                pinSpacing: false,
                toggleClass: 'cms-enable-scrollwheel',
                onToggle: function (self) {
                    console.log(self);
                },
            });
        });

        // Vertial Sticky on Scroll
        gsap.timeline({
                scrollTrigger: {
                    trigger: cmssroller_vertical,
                    pin: true,
                    scrub: 0.3,
                    start: "top top",
                    //end: "+=0",
                    //offset: 50
                }
            })
            .to(scroll_vertical, {
                yPercent: -100,
                duration: 2,
                ease: "none",
                stagger: 3
            })
            .to({}, {
                duration: 1
            });
        // Horizontal Sticky on Scroll
        gsap.timeline({
                scrollTrigger: {
                    trigger: cmssroller_horizontal,
                    pin: true,
                    scrub: 1,
                    start: "top top",
                    end: "+=3000",
                    //offset: 50
                }
            })
            .to(scroll_horizontal, {
                xPercent: -100,
                duration: 2,
                ease: "none",
                stagger: 3
            })
            .to({}, {
                duration: 1
            });
    };
    var WidgetCMSGSAPProcessHandler = function($scope, $) {
        gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);
        var cmsProcess = $scope.find(".cms-process-slides-wrapper");
        //

        $scope.find('.process-sdesc').each(function() {
            var top_space = parseInt($(this).parents('.cms-eprocess').css('padding-top')),
                bottom_space = parseInt($(this).parents('.cms-eprocess').css('padding-bottom')),
                sdesc_height = top_space;
            if ($(window).width() >= 881) {
                $(this).css({
                    'min-height': 'calc(100vh - ' + sdesc_height + 'px)',
                    'padding-bottom': bottom_space + 'px',
                    '--cms-sticky-top': top_space + 'px'
                });
            }
            $(window).on('resize', function() {
                if ($(window).width() <= 880) {
                    $(this).css({
                        'min-height': '',
                        'padding-bottom': '',
                        '--cms-sticky-top': ''
                    });
                } else {
                    $(this).css({
                        'min-height': 'calc(100vh - ' + sdesc_height + 'px)',
                        'padding-bottom': bottom_space + 'px',
                        '--cms-sticky-top': top_space + 'px'
                    });
                }
            });
        });
        //
        var panels = gsap.utils.toArray(cmsProcess.find(".panel"));

        panels.pop(); // get rid of the last one (don't need it in the loop)
        panels.forEach((panel, i) => {
            scrollTriggerOptions = {
                trigger: panel,
                start: "center center", // "bottom bottom",
                pinSpacing: false,
                pin: true,
                scrub: true,
                // set the transformOrigin so that it's in the center vertically of the viewport when the element's bottom hits the bottom of the viewport
                onRefresh: () => gsap.set(panel, { transformOrigin: "center " + (panel.offsetHeight - window.innerHeight / 2) + "px" }),
                toggleClass: 'toggleClass'
            };
            if(i == 0){
                scrollTriggerOptions.onEnter = function (self) {
                    $scope.find('.process--sdesc').hide();
                };
                scrollTriggerOptions.onLeaveBack = function (self) {
                    $scope.find('.process--sdesc').show();
                };
            }
            let tl = gsap.timeline({
                scrollTrigger: scrollTriggerOptions
            });

            tl.fromTo(panel, 1, { y: 0, rotate: 0, scale: 1, opacity: 1 }, { y: 0, rotateX: 0, scale: 0.85, opacity: 0.9 }, 0)
                .to(panel, 0, { opacity: 0 })

        });

    };
    // CMS Sticky Scroll Content Horizontal
    var WidgetCMSScrollContentHorizontal = function ($scope, $){
        gsap.registerPlugin(ScrollTrigger, Observer);
        if($(window).innerWidth() > 1024){
            cms_scroll_horizontal();
        }
    }
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_accordion_scroll.default', WidgetCMSGSAPHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_process.default', WidgetCMSGSAPProcessHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_industry_scroll.default', WidgetCMSScrollContentHorizontal);
    });
    function cms_scroll_horizontal() {
        let scrollItems = gsap.utils.toArray(".cms-scroll-item");
        let dragRatio = 1;
        let scrollTo;
        let scrollTween = gsap.to(scrollItems, {
            xPercent: -100 * (scrollItems.length - 4),
            ease: "none",
            immediateRender: false,
            scrollTrigger: {
                trigger: ".cms-horizontal-scroll", // ".vertical-scroll-container",
                pin: true,
                scrub:1,
                start: "top",
                onRefresh: (self) => {
                    dragRatio = (self.end - self.start) / ((scrollItems.length - 1) * scrollItems[0].offsetWidth);
                },
                end: "+=3000",
                markers: false
            }
        });
        Observer.create({
            target: ".cms-horizontal-scroll",
            type: "wheel,touch,pointer",
            onPress: (self) => {
                self.startScroll = scrollTween.scrollTrigger.scroll();
                scrollTo = gsap.quickTo(scrollTween.scrollTrigger, "scroll", {
                    duration: 0.5,
                    ease: "power3"
                });
            },
            onDrag: (self) => {
                scrollTo(self.startScroll + (self.startX - self.x) * dragRatio);
            }
        }); 
    }
})(jQuery);