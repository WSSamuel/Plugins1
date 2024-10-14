// Admin jQuery ajax call.
jQuery(function ($) {

    $(document).ready(function () {
        $('#jwdpv0001-bop').tabs();
    });

    $('#jwdpv0001-versions-sel').on('change', function () {

        jQuery.ajax({
            type: 'POST',
            data: {
                action: 'get_admin_version',
                version: $(this).val()
            },
            url: "admin-ajax.php",
            success: function (data) {
                $('#jwdpv0001-version-json').val(data);
                location.reload();
            }
        });
    });

    // Ajax call
    $('.dpv-num-change').change(function () {
        day = $(this).attr('id').match(/\d+/);
        verse = $(this).val();
        jQuery.ajax({
            type: 'POST',
            data: {
                action: 'get_admin_verse',
                day: day[0],
                verse: verse                
            },
            url: "admin-ajax.php",
            success: function (data) {                
                // Parse data to JSON                
                json = JSON.parse(data);               
                // Change verse html form element
                $('input#dpv-num-change-' + day).val(json.text);                
                // Alert if no verse was found
                if (json.response === 'N') {
                    alert(json.text);
                } else {
                    ele = new Array();
                    $.each( $('input.jwdpv0001-vod-verse') , function(k,v) {
                        day = k+1;
                        ele[k] = [$('#dpv-num-'+day).val(),$(this).val()]; 
                    } );                    
                    jwdpv0001_save_data(ele);                                     
                }
            }
        });
    });   

    $('#jwdpv0001-prv-txt-save').click( function(e){
        e.preventDefault();
        
        val = $('#jwdpv0001-prv-txt').val();
        
        if( val==='' ) {
            alert( 'Please enter a value!' );
            return false;
        }
        
        jQuery.ajax({
            type: 'POST',
            data: {
                action: 'admin_prv_txt_save',                
                prvtxt: val
            },
            url: "admin-ajax.php",
            success: function (data) { 
                alert(data);
                $( '#jwdpv0001-prv-txt-save-msg' ).text(data).css('display','block').attr( 'class' , 'success' ).delay(1500).fadeOut('slow');
                setTimeout( function() {
                    window.scrollTo(0, 0);
                    location.reload();
                } , 1500 );
            }
        });
    } );

    $('#jwdpv0001-reset-verses').click( function(e){
        e.preventDefault();
        jQuery.ajax({
            type: 'POST',
            data: {
                action: 'admin_vod_save',                
                method:'reset'
            },
            url: "admin-ajax.php",
            success: function (data) {
                window.scrollTo(0, 0);
                $( '#jwdpv0001-message-box' ).css('display','block').attr( 'class' , 'success' ).html('<p>'+data+'</p>').delay(2500).fadeOut('slow');
                setTimeout( function() {
                    location.reload();
                } , 2500 );
            }
        });
    } );

    // Hilight verse on change
    $('.dpv-num-change-txt').click(function () {
        $(this).select();
    });

    function jwdpv0001_save_data(verses)
    {
        jQuery.ajax({
            type: 'POST',
            data: {
                action: 'admin_vod_save',                
                verses: verses,
                method:'save'
            },
            url: "admin-ajax.php",
            success: function (data) {                
                $( '#jwdpv0001-message-box' ).css('display','block').attr( 'class' , 'success' ).html('<p>'+data+'</p>').delay(1000).fadeOut('slow');
            }
        });
    }

});