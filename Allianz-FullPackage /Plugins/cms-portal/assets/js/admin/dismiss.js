;(function ($) {
    "use strict";

    $(document).on('click', '.cpt-notice-dismiss', function (e) {
        e.preventDefault();

        let notice = $(this).parents('.notice');
        let key = $(this).data('key');
        $.ajax({
            url: cms_portal.ajax_url,
            type: "POST",
            beforeSend: function () {
                
            },
            data: {
                action: 'cpt_dismiss',
                key: key
            },
        }).done(function (res) {
            
        }).fail(function (res) {

        }).always(function () {
           notice.fadeTo( 100, 0, function() {
                notice.slideUp( 100, function() {
                    notice.remove();
                });
            }); 
        });
    });
})(jQuery);