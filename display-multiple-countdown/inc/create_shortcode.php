<?php 
if (!defined('ABSPATH')) {
  exit; // Exit if directly accessed
}

if (!class_exists('multiCountDownShortcodeClass')) {
  
class multiCountDownShortcodeClass
{
  function __construct()
  {
     add_shortcode('multiCountDown', array($this,'multiCountDown_shortcode'));
  }

function multiCountDown_shortcode($attr){

 if (!isset($attr["endtime"]) && $attr["endtime"] == "")
     return '<b>endtime</b> attribute is required.';

    if (!isset($attr["formet"]) && $attr["formet"] == "")
     return '<b>formet</b> attribute is required.';

    if (!isset($attr["formet_text"]) && $attr["formet_text"] == "")
      return '<b>formet text</b> attribute is required.';

    $formet_text = explode("-", $attr["formet_text"]);
    $formet =  $attr["formet"];
    $formet_html = "";

    foreach (explode("-", $formet) as $key => $value) {
    $formet_html .= ' <li class="li_'.$value.'"><ul><li><span>%'.$value.'</span></li></ul><span class="abc">'.$formet_text[$key].'</span></li>';
    }

$randomClass = $this->multiCountDownRandomString(6);

_e('<style>
.countDown ul.my_timer li ul li {margin: 1px !important;}
.countDown ul.my_timer li ul li {margin: 0 !important;}
.countDown ul.my_timer li {margin: 0px 10px 0px 0px !important;}
.countDown ul.my_timer li {display: inline-block;margin: 0px 0px 0px 10px;text-align: center;}
.countDown ul.my_timer li span {font-size: 10px;font-weight: bold;}
.countDown ul.my_timer li ul li {margin: 1px !important;}
.countDown ul.c_'.$randomClass.'my_timer li ul li span {
    display: inline-block;
    background-color: '.$attr["background_color"].';
    color: '.$attr["text_color"].';
    width: 50px;
    width: auto;
    padding: 2px 16px;
    line-height: 40px;
    border-radius: 10px;
    font-size: 17px;
}
.countDown .my_timer ul {margin: 0px;}
ul.c_'.$randomClass.'my_timer li .abc {
    color: '.$attr["outer_text_color"].';
}
ul.my_timer li {margin: 0px 15px 0px 0px;}
.countDown .my_timer li .abc {font-size: 12px;font-weight: 500;}
.countDown .my_timer li ul {padding: 0px 0px 10px 0px;}
</style>');

_e('<div class="countDown"><ul class="my_timer c_'.$randomClass.'my_timer" data-countdown="'.$attr["endtime"].'">
        </ul><div class="html" style="display: none;">'.$formet_html.'</div></div>'); 
}


    public function multiCountDownRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


}

new multiCountDownShortcodeClass;
}
?>