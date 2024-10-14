<?php if (!defined('ABSPATH')) {
  exit; // Exit if directly accessed
}

$CDCcurrent = new DateTime();
$CDCYear = date('Y-m-d h:i a', strtotime("+1 Year", strtotime($CDCcurrent->format('Y-m-d h:i a'))));
$CDCmonth = date('Y-m-d h:i a', strtotime("+1 month", strtotime($CDCcurrent->format('Y-m-d h:i a'))));
$CDCday = date('Y-m-d h:i a', strtotime("+1 day ", strtotime($CDCcurrent->format('Y-m-d h:i a'))));

?>

<div class="row">
<div class="card" style="max-width: 100%;">
  <div class="CDC_card-header">
  <h3>Multi CountDown</h3>
  <p>Define Formet = Y : "years", m : "months", w : "weeks", d : "days", D : "totalDays", H : "hours", M : "minutes", S : "seconds"</p>
  </div>
  <div class="card-body">
<table width="100%" class="CDC_table">
  <tbody>
      <tr class="CDC_shortcode">
        <td><p>[multiCountDown endtime="2022-12-10 02:00" formet="Y-m-w-D-H-M-S" formet_text="Years-Months-Weeks-Day-Hours-Minutes-Second" background_color="black" text_color="#fff" outer_text_color="#000000"]</p></td>
        <td class="CDC_timer"><?php _e(do_shortcode('[multiCountDown endtime="2022-12-10 02:00" formet="Y-m-w-D-H-M-S" formet_text="Years-Months-Weeks-Day-Hours-Minutes-Second" background_color="black" text_color="#fff" outer_text_color="#000000"]')); ?>
        </td>
      </tr>
      <tr><td></td></tr>
      <tr class="CDC_shortcode">
        <td><p>[multiCountDown endtime="2022-12-10 02:00" formet="m-D-H-M-S" formet_text="Months-Day-Hours-Minutes-Second" background_color="red" text_color="#fff" outer_text_color="red"]</p></td>
        <td class="CDC_timer"><?php _e(do_shortcode('[multiCountDown endtime="'.$CDCmonth .'" formet="m-D-H-M-S" formet_text="Months-Day-Hours-Minutes-Second" background_color="red" text_color="#fff" outer_text_color="red"]')); ?>
        </td>
      </tr>
      <tr><td></td></tr>
      <tr class="CDC_shortcode">
        <td><p>[multiCountDown endtime="2022-12-10 02:00" formet="D-H-M-S" formet_text="Day-Hours-Minutes-Second" background_color="3fe968" text_color="fff" outer_text_color="3fe968"]</p></td>
        <td class="CDC_timer"><?php _e(do_shortcode('[multiCountDown endtime="'.$CDCday .'" formet="D-H-M-S" formet_text="Day-Hours-Minutes-Second" background_color="#3fe968" text_color="#fff" outer_text_color="#3fe968"]')); ?>
        </td>
      </tr>      
  </tbody>
</table>

  </div>
</div>
  </div>
</div>




