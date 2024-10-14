(function( $ ) {
    'use strict';

    function relacePoweredBy(){
        const params = elvez_edit_powered_by;
        const text = params.powered_by_text || '';
        const url = params.powered_by_url || '';

        const $poweredBy = $('.powered-by-wordpress');
        const $link = $poweredBy.find('a');

        $link.text(text);
        $link.attr('href', url);
        $poweredBy.addClass('show');
    }
    $( window ).ready(relacePoweredBy);

})( jQuery );
