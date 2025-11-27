( function( $ ) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSToggleHandler = function( $scope, $ ) {
        $scope.find(".cms-toggle .cms-toggle-item .cms-toggle-title").on("click", function(e){
            e.preventDefault();
            var target = $(this).data("target");
            $(this).toggleClass("active");
            $(target).slideToggle(400);
        });
    };

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_toggle.default', WidgetCMSToggleHandler );
    } );
} )( jQuery );