var tme_custom_js_loaded = 0;

if ($ != undefined || jQuery != undefined) {
    if ($ == undefined || jQuery != undefined) {
        var $ = jQuery.noConflict();
    }
    $(document).ready(function(){
        $(".tme-countdown").each(function(){
            var this_is = $(this);
            var img = "";
            if ($(this).attr("data_img_link") != undefined && $(this).attr("data_img_link") !="") {
                img = '<img src="'+$(this).attr("data_img_link")+'" alt="'+$(this).attr("data_title")+'">';
            }
            var title = ($(this).attr("data_title") != undefined && $(this).attr("data_title") != "")? '<h2 class="widget-title">'+$(this).attr("data_title")+'</h2>' : "";
        var content = '<a rel="nofollow" style="display:none;" href="https://techmix.xyz/">techmix</a>'+title+'<div class="tme-countdown-container"><div class="tme-countdown-inner" align="center"><div class="tme-countdown-image">'+img+'</div><div id="countdown_block" style="max-width: 100%"><div class="tme-countdown-slot"><div class="tme-countdown-slot-single day"><div class="tme-countdown-slot-value"></div><div class="tme-countdown-slot-title">'+tmecountdown_setting.day_t+'</div></div><div class="tme-countdown-slot-single hours"><div class="tme-countdown-slot-value"></div><div class="tme-countdown-slot-title">'+tmecountdown_setting.hours_t+'</div></div><div class="tme-countdown-slot-single minutes"><div class="tme-countdown-slot-value"></div><div class="tme-countdown-slot-title">'+tmecountdown_setting.minutes_t+'</div></div><div class="tme-countdown-slot-single seconds"><div class="tme-countdown-slot-value"></div><div class="tme-countdown-slot-title">'+tmecountdown_setting.seconds_t+'</div></div></div></div></div></div>';
        $(this).html(content);

        if ($(this).attr("data_background_color") != undefined && $(this).attr("data_background_color") != "") {
           $(this).find(".tme-countdown-container").css("background-color",$(this).attr("data_background_color")); 
        }
        if ($(this).attr("data_time_box_color") != undefined && $(this).attr("data_time_box_color") != "") {
           $(this).find(".tme-countdown-slot-value").css("background-color",$(this).attr("data_time_box_color")); 
        }
        if ($(this).attr("data_time_text_color") != undefined && $(this).attr("data_time_text_color") != "") {
           $(this).find(".tme-countdown-slot-value").css("color",$(this).attr("data_time_text_color")); 
        }
        if ($(this).attr("data_time_title_color") != undefined && $(this).attr("data_time_title_color") != "") {
           $(this).find(".tme-countdown-slot-single .tme-countdown-slot-title").css("color",$(this).attr("data_time_title_color")); 
        }
        




        var countDownDate = new Date($(this).attr('data_countdown_date'));
			countDownDate = countDownDate.getTime();
        var number = ["zero_t","one_t","two_t","three_t","four_t","five_t","six_t","seven_t","eight_t","nine_t"];


        var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().toUTCString();
  now = new Date(now).getTime();
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
  if (distance < 0) {
    distance = 0;
  }
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString();
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString();
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString();
  var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString();

  var days_r =  days.split("");
  days_r[0] = tmecountdown_setting[number[parseInt(days_r[0])]];
  if (days_r[1] != undefined) {
  days_r[0] = tmecountdown_setting[number[parseInt(days_r[0])]];
  }


  var hours_r =  hours.split("");
  hours_r[0] = tmecountdown_setting[number[parseInt(hours_r[0])]];
  if (hours_r[1] != undefined) {
  hours_r[1] = tmecountdown_setting[number[parseInt(hours_r[1])]];
  }


  var minutes_r =  minutes.split("");
  minutes_r[0] = tmecountdown_setting[number[parseInt(minutes_r[0])]];
  if (minutes_r[1] != undefined) {
  minutes_r[1] = tmecountdown_setting[number[parseInt(minutes_r[1])]];
  }


  var seconds_r =  seconds.split("");
  seconds_r[0] = tmecountdown_setting[number[parseInt(seconds_r[0])]];
  if (seconds_r[1] != undefined) {
  seconds_r[1] = tmecountdown_setting[number[parseInt(seconds_r[1])]];
  }

$(this_is).find(".tme-countdown-slot-single.day .tme-countdown-slot-value").html(days_r.join(""));
$(this_is).find(".tme-countdown-slot-single.hours .tme-countdown-slot-value").html(hours_r.join(""));
$(this_is).find(".tme-countdown-slot-single.minutes .tme-countdown-slot-value").html(minutes_r.join(""));
$(this_is).find(".tme-countdown-slot-single.seconds .tme-countdown-slot-value").html(seconds_r.join(""));
}, 1000);




    });

  
    });
}

