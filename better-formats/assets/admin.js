jQuery(function($){
    var
        bf  = $('#bf-info'),             //betterformats inline help text
        pfs = $('#post-formats-select'), //our custom output
        fdi = $('#formatdiv > .inside'); //post formats meta box

    //Move the new UI into the box
    pfs.hide();
    bf.prependTo(fdi).show();

    //Adjust CSS
    fdi.css({'padding':0,'margin':0});

    //Enable UI
    bf.children('.bf-opt').on('click',function(){
        var me = $(this);
        //console.log('clicked');
        $( '#post-format-'+me.data('format') ).click();
        me.addClass('selected').siblings().removeClass('selected');
    });
});