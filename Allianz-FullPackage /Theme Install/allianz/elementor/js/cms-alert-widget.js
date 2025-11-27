( function( $ ) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSAlertHandler = function( $scope, $ ) {
        $scope.find(".cms-alert .cms-alert-dismiss").on("click", function(e){
            $(this).parents(".cms-alert").fadeOut(400);
        });
    };

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_alert.default', WidgetCMSAlertHandler );
    } );
} )( jQuery );