(function($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSAccordionHandler = function($scope, $) {
        $scope.find('.cms-accordion-title').on('click', function(e) {
            e.preventDefault();
            var self = $(this);
            if (self.hasClass('animating')) {
                return false;
            }
            self.addClass('animating');
            var target = self.data('target');
            var parent = self.parents('.cms-accordion-wrap');
            var active_items = parent.find('.cms-accordion-title.active');
            $.each(active_items, function(index, item) {
                var item_target = $(item).data('target');
                if (item_target != target) {
                    $(item).removeClass('active');
                    self.parent().removeClass('active');
                    $(item_target).slideUp(400);
                }
            });

            if (self.hasClass('active')) {
                self.parent().removeClass('active');
                self.removeClass('active');
                $(target).slideUp(400);
            } else {
                self.parents('.cms-accordion').find('.cms-accordion-item').removeClass('active');
                self.parents('.cms-accordion').find('.cms-accordion-title').removeClass('active');
                self.parents('.cms-accordion').find('.cms-accordion-content').slideUp(400);
                self.parent().addClass('active');
                self.addClass('active');
                $(target).slideDown(400);
            }
            setTimeout(function() {
                self.removeClass('animating');
            }, 400);
        });
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_accordion.default', WidgetCMSAccordionHandler);
    });
})(jQuery);