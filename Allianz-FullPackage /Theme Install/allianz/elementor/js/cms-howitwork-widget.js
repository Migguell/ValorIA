(function($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSCounterHandler = function($scope, $) {
        var items = $scope.find('.hiw-item');
        var itemsBanner = $scope.find('.hiw-item-banner');
        $scope.find('.hiw-item').each(function () {
            var item = this;
            var waypoint = new Waypoint({
                element: item,
                handler: function(direction) {
                    var _this = $(this.element);
                    var target = _this.data('target');
                    target = $(target);
                    items.removeClass('active');
                    itemsBanner.removeClass('active');
                    _this.addClass('active');
                    target.addClass('active');
                },
                offset: item.offsetHeight,
            });
        });
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_howitwork.default', WidgetCMSCounterHandler);
    });
})(jQuery);