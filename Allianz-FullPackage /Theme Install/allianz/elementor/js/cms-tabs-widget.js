( function( $ ) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    /*var WidgetCMSTabsHandler = function( $scope, $ ) {
        $scope.find(".cms-tabs .cms-tabs-filter .cms-tab-filter").on("click", function(e){
            e.preventDefault();
            var target = $(this).data("target");
            var parent = $(this).parents(".cms-tabs");
            parent.find(".cms-tabs-content .cms-tab-content").hide();
            parent.find(".cms-tabs-title .cms-tab-title").removeClass('active');
            $(this).addClass("active");
            $(target).show();
        });
    };*/
    var WidgetCMSTabsHandler = function( $scope, $ ) {
        $scope.find(".cms-tab-title").on("click", function(e){
            e.preventDefault();
            var target = $(this).data("target");
            var target2 = $(this).data("target-2");
            var parent = $(this).parents(".cms-tabs");
            // hide all
            parent.find(".cms-tabs-content").hide().removeClass('active');
            parent.find(".cms-tab-title").removeClass('active');
            // Show current
            $(this).addClass("active");
            $(target).show().addClass('active');
            $(target2).show().addClass('active');
            //$(target).find('.cms-tab-title[data-target="'+target+'"]').addClass('active');
            // fix animate Mobile
            //$('html,body').animate({scrollTop: parent.offset().top - 100}, 30);
        });
        $scope.find(".cms-tab-title").on('hover', function(e){
            e.preventDefault();
            var target = $(this).data("target");
            var target2 = $(this).data("target-2");
            var parent = $(this).parents(".cms-tabs");
            // hide all
            parent.find(".cms-tabs-content").hide().removeClass('active');
            parent.find(".cms-tab-title").removeClass('active');
            // Show current
            $(this).addClass("active");
            $(target).show().addClass('active');
            $(target2).show().addClass('active');
            //$(target).find('.cms-tab-title[data-target="'+target+'"]').addClass('active');
            // fix animate Mobile
            //$('html,body').animate({scrollTop: parent.offset().top - 100}, 30);
        });
    };
    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_tabs.default', WidgetCMSTabsHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_products_tabs.default', WidgetCMSTabsHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_products_custom_tabs.default', WidgetCMSTabsHandler );
    } );
} )( jQuery );