( function( $ ) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSCounterHandler = function( $scope, $ ) {
        elementorFrontend.waypoint($scope.find('.cms-counter-number'), function () {
            var $number = $(this),
                data = $number.data();

            var decimalDigits = data.toValue.toString().match(/\.(.*)/);

            if (decimalDigits) {
                data.rounding = decimalDigits[1].length;
            }

            $number.numerator(data);

        }, {
            offset: '95%',
            triggerOnce: true
        });
        // add class active to counter chart bar
        elementorFrontend.waypoint($scope.find('.cms-counter-chart-bar'), function () {
            $(this).addClass('active');
        });
        //
        $scope.find('.counter-item').on('click', function(e) {
            e.preventDefault();
            var self = $(this);
            if (self.hasClass('animating')) {
                return false;
            }
            self.addClass('animating');
            var target = self.data('target');
            var parent = self.parents('.cms-counter-sticky');
            var active_items = parent.find('.counter-item.active');
            $.each(active_items, function(index, item) {
                var item_target = $(item).data('target');
                if (item_target != target) {
                    //$(item).removeClass('active');
                    //self.parent().removeClass('active');
                    //$(item_target).slideUp(400);
                    //$(item_target).removeClass('active');
                }
            });

            if (self.hasClass('active')) {
                //self.parent().removeClass('active');
                //self.removeClass('active');
                //$(target).slideUp(400);
                //$(target).removeClass('active');
            } else {
                self.parent().addClass('active');
                self.addClass('active');
                //$(target).slideDown(400);
                $(target).addClass('active');
            }
            setTimeout(function() {
                self.removeClass('animating');
            }, 400);
        });
        $scope.find('.counter-item').on('hover', function(e) {
            e.preventDefault();
            var self = $(this);
            if (self.hasClass('animating')) {
                return false;
            }
            self.addClass('animating');
            var target = self.data('target');
            var parent = self.parents('.cms-counter-sticky');
            var active_items = parent.find('.counter-item.active');
            $.each(active_items, function(index, item) {
                var item_target = $(item).data('target');
                if (item_target != target) {
                    $(item).removeClass('active');
                    self.parent().removeClass('active');
                    //$(item_target).slideUp(400);
                    $(item_target).removeClass('active');
                }
            });

            if (self.hasClass('active')) {
                //self.parent().removeClass('active');
                //self.removeClass('active');
                //$(target).slideUp(400);
                //$(target).removeClass('active');
            } else {
                self.parent().addClass('active');
                self.addClass('active');
                //$(target).slideDown(400);
                $(target).addClass('active');
            }
            setTimeout(function() {
                self.removeClass('animating');
            }, 400);
        });
    };

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_counter.default', WidgetCMSCounterHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_counter_sticky.default', WidgetCMSCounterHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_accordion_scroll.default', WidgetCMSCounterHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_contact_form.default', WidgetCMSCounterHandler );
    } );
} )( jQuery );