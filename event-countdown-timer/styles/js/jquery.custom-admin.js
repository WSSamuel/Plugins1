var tme_custom_js_loaded = 0;

if ($ != undefined || jQuery != undefined) {
    if ($ == undefined || jQuery != undefined) {
        var $ = jQuery.noConflict();
    }
    $(document).ready(function(){

  $('.tme-datetime').tmedatetimepicker();
  $('.w-tme-datetime').tmedatetimepicker();
$(document).ajaxSuccess(function(e, xhr, settings) {
  $('.w-tme-datetime').tmedatetimepicker({dateFormat: "yy-mm-dd HH:ii:ss"});
  // you may put your own action here
});


  
    });
}

