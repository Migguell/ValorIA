( function( $ ) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetPieChartHandler = function( $scope, $ ) {
        $scope.find(".cms-piecharts .piechart .percentage").each( function() {
            var track_color = $(this).data('track-color');
            var bar_color = $(this).data('bar-color');

            var options = {
                animate: 2000,
                lineWidth: 10,
                barColor: bar_color,
                trackColor: track_color,
                scaleColor: false,
                lineCap: 'square',
                size: 220
            };
            $(this).easyPieChart(options);
        });
    };

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_piecharts.default', WidgetPieChartHandler );
    } );
} )( jQuery );