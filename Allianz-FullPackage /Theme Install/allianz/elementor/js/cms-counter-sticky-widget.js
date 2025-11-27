(function($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSCounterHandler = function($scope, $) {
        // var _throttleTimer = null;
        // var _throttleDelay = 100;
        // var $window = $(window);
        // var $document = $(document);
        // var offsetTop = 15;

        // $window.off('scroll', ScrollHandler).on('scroll', ScrollHandler);

        // function ScrollHandler(e) {
        //     //throttle event:
        //     clearTimeout(_throttleTimer);
        //     _throttleTimer = setTimeout(function() {
        //         var scrollTop = $window.scrollTop();
        //         var scrollHeight = $window.height();
        //         var counterStickyEls = $scope.find('.cms-counter-sticky');
        //         counterStickyEls.each(function() {
        //             counterStickyEl = $(this);
        //             // counterOffset = counterStickyEl.offset();
        //             // counterHeight = counterStickyEl.outerHeight();
        //             // calc = scrollTop - counterOffset.top + offsetTop;
        //             // if (calc < 0) {
        //             //     console.log(counterStickyEl);
        //             //     console.log(scrollTop);
        //             //     console.log('blur');
        //             //     console.log('============================================================');
        //             // } else if (calc == 0 || (calc > 0 && calc <= counterHeight)) {
        //             //     console.log(counterStickyEl);
        //             //     console.log(scrollTop);
        //             //     console.log('active');
        //             //     console.log('============================================================');
        //             // } else if (calc > counterHeight) {
        //             //     console.log(counterStickyEl);
        //             //     console.log(scrollTop);
        //             //     console.log('invisible');
        //             //     console.log('============================================================');
        //             // }

        //             // Get the dimensions of the window
        //             var windowWidth = $window.width();
        //             var windowHeight = $window.height();

        //             // Get the position of the element
        //             var elementRect = counterStickyEl[0].getBoundingClientRect();
        //             var elementWidth = elementRect.width;
        //             var elementHeight = elementRect.height;
        //             var elementX = elementRect.left;
        //             var elementY = elementRect.top;

        //             // Calculate the center position of the window
        //             var windowCenterX = windowWidth / 2;
        //             var windowCenterY = windowHeight / 2;

        //             // Calculate the center position of the element
        //             var elementCenterX = elementX + elementWidth / 2;
        //             var elementCenterY = elementY + elementHeight / 2;

        //             // Check if the element is at the center of the window
        //             var isElementAtCenter = Math.abs(elementCenterX - windowCenterX) < elementWidth / 2 && Math.abs(elementCenterY - windowCenterY) < elementHeight / 2;

        //             console.log(isElementAtCenter);
        //         });

        //     }, _throttleDelay);
        // }

        // var counterEls = $('.cms-counter-numbers');
        // counterEls.each(function () {
        //     counterEl = $(this);
        //     var counterParentEl = counterEl.parent();

        // });

        // var waypoint = new Waypoint({
        //     element: document.querySelectorAll('.cms-counter-numbers-wrapper'),
        //     handler: function(direction) {
        //         alert('Direction: ' + direction);
        //     },
        //     // context: document.getElementById('overflow-scroll')
        // });

        $scope.find('.cms-counter-number-list').each(function () {
            var counterNumberList = $(this);
            var counterNumberListInner = counterNumberList.find('> .cms-counter-number-list-inner');
            counterNumberList.parent().css('height', counterNumberListInner.outerHeight() * 2);
        });

        $scope.find('.cms-counter-numbers-wrapper').each(function () {
            var item = this;
            var waypoint = new Waypoint({
                element: item,
                handler: function(direction) {
                    console.log(direction);
                    console.log(this);
                    console.log('============================================================');
                },
                offset: item.offsetHeight,
            });
        });
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_counter_sticky.default', WidgetCMSCounterHandler);
    });
})(jQuery);