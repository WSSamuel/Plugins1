(function($) {
    $(document).ready(function () {
        $('#moradam-seo-header-edit-domain-input').keypress(function(e) {
            if (e.which == 13) {
                $('#moradam-seo-header-save-new-domain-btn').click();
            }
        });

    });
})( jQuery );
