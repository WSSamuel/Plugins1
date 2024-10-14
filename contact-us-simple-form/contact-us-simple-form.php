<?php
/*
Plugin Name: Contact Us Simple Form
Plugin URI: https://wordpress.org/support/profile/bruterdregz
Description: Contact Us Simple Form - Quick, small and easy contact form for wordpress.
Version: 1.0
Author: Bruter Dregz
Author URI: https://wordpress.org/support/profile/bruterdregz
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/  
class BruterContactSlider{
    
    public $options;
    
    public function __construct() {
        //you can run delete_option method to reset all data
        //delete_option('bruter_cf_contact_plugin_options');
        $this->options = get_option('bruter_cf_contact_plugin_options');
        $this->bruter_cf_contact_register_settings_and_fields();
    }
    
    public static function add_bruter_cf_tools_options_page(){
        add_options_page('Contact Us Simple Form', 'Contact Us Simple Form ', 'administrator', __FILE__, array('BruterContactSlider','bruter_cf_contact_tools_options'));
    }
    
    public static function bruter_cf_contact_tools_options(){
?>
<div class="wrap">
    <h2>Contact Us Simple Form Configuration</h2>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('bruter_cf_contact_plugin_options'); ?>
        <?php do_settings_sections(__FILE__); ?>
        <p class="submit">
         <input name="submit" type="submit" class="button-primary" value="Save Changes"/>
        </p>
    </form>
</div>
<?php
    }
    public function bruter_cf_contact_register_settings_and_fields(){
        register_setting('bruter_cf_contact_plugin_options', 'bruter_cf_contact_plugin_options',array($this,'bruter_cf_contact_validate_settings'));
        add_settings_section('bruter_cf_contact_main_section', 'Settings', array($this,'bruter_cf_contact_main_section_cb'), __FILE__);
        //Start Creating Fields and Options
             
        //recipient
        add_settings_field('recipient', 'Recipient Mail', array($this,'recipient_settings'), __FILE__,'bruter_cf_contact_main_section');
         //name
        add_settings_field('name', 'Form Name', array($this,'name_settings'), __FILE__,'bruter_cf_contact_main_section');
        //marginTop
        add_settings_field('marginTop', 'Margin Top', array($this,'marginTop_settings'), __FILE__,'bruter_cf_contact_main_section');
        //alignment option
         add_settings_field('alignment', 'Alignment Position', array($this,'position_settings'),__FILE__,'bruter_cf_contact_main_section');
        //width
        add_settings_field('width', 'Width', array($this,'width_settings'), __FILE__,'bruter_cf_contact_main_section');
        //height
        add_settings_field('height', 'Height', array($this,'height_settings'), __FILE__,'bruter_cf_contact_main_section');

    }
    public function bruter_cf_contact_validate_settings($plugin_options){
        return($plugin_options);
    }
    public function bruter_cf_contact_main_section_cb(){
        //optional
    }


    
    //recipient_settings
    public function recipient_settings() {
        if(empty($this->options['recipient'])) $this->options['recipient'] = "yourmail@gmail.com";
        echo "<input name='bruter_cf_contact_plugin_options[recipient]' type='text' value='{$this->options['recipient']}' />";
    }

     //name_settings
    public function name_settings() {
        if(empty($this->options['name'])) $this->options['name'] = "Contact Us Slider";
        echo "<input name='bruter_cf_contact_plugin_options[name]' type='text' value='{$this->options['name']}' />";
    }
    
    //marginTop_settings
    public function marginTop_settings() {
        if(empty($this->options['marginTop'])) $this->options['marginTop'] = "250";
        echo "<input name='bruter_cf_contact_plugin_options[marginTop]' type='text' value='{$this->options['marginTop']}' />";
    }
    //alignment_settings
    public function position_settings(){
        if(empty($this->options['alignment'])) $this->options['alignment'] = "left";
        $items = array('left','right');
        echo "<select name='bruter_cf_contact_plugin_options[alignment]'>";
        foreach($items as $item){
            $selected = ($this->options['alignment'] === $item) ? 'selected = "selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }
    //width_settings
    public function width_settings() {
        if(empty($this->options['width'])) $this->options['width'] = "350";
        echo "<input name='bruter_cf_contact_plugin_options[width]' type='text' value='{$this->options['width']}' />";
    }
    //height_settings
    public function height_settings() {
        if(empty($this->options['height'])) $this->options['height'] = "400";
        echo "<input name='bruter_cf_contact_plugin_options[height]' type='text' value='{$this->options['height']}' />";
    }

}
add_action('admin_menu', 'bruter_cf_contact_trigger_options_function');

function bruter_cf_contact_trigger_options_function(){
    BruterContactSlider::add_bruter_cf_tools_options_page();
}

add_action('admin_init','bruter_cf_contact_trigger_create_object');
function bruter_cf_contact_trigger_create_object(){
    new BruterContactSlider();
}
add_action('wp_footer','bruter_cf_contact_add_content_in_footer');
function bruter_cf_contact_add_content_in_footer(){
    
    $option_value = get_option('bruter_cf_contact_plugin_options');
    extract($option_value);
    $total_height=$height-95;
    $max_height=$total_height+10;
	/*contact form code start*/
$url = $_SERVER['PHP_SELF'];
$url = esc_url($url);
$myError = '';
$CORRECT_EMAIL = '';
$CORRECT_SUBJECT = '';
$CORRECT_MESSAGE = '';


if (isset($_POST["cf_email"])) {
  $CORRECT_SUBJECT = esc_html(sanitize_text_field($_POST["cf_subject"]));
  $CORRECT_MESSAGE = esc_html(sanitize_text_field($_POST["cf_message"]));
  
  
  // check email
  if ($_POST["cf_email"] === "") {
    $myError = '<span style="color:#f00; padding: 0 0 0 10px;">No Email</span>';
  }
  if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", strtolower($_POST["cf_email"]))) {
    $myError = '<span style="color: #cccccc;">Invalid Email</span>';
  }
  else {
    $CORRECT_EMAIL = esc_html(sanitize_email($_POST["cf_email"]));
  }
  
   if ($myError == '') {

	 $CORRECT_EMAIL = esc_html(sanitize_email($_POST["cf_email"]));
	 $mySubject = esc_html(sanitize_text_field($_POST["cf_subject"]));
	 $CORRECT_MESSAGE = esc_html(sanitize_text_field($_POST["cf_message"])); 
	 
	 $myMessage = 'You received a message from '. $CORRECT_EMAIL  ."\n\n". $CORRECT_MESSAGE;

	
	

$mailSender = wp_mail( $recipient, $mySubject, $myMessage );


    if ($mailSender) {
		$myError = '<span style="color:#00ff00; padding: 0 0 0 10px;">' . "Thanks for submitting form" . '</span>';
    } else {
		$myError = '<span style="color:#f00; padding: 0 0 0 10px;">' . "Showing Error" . '</span>';
    }

  }
  
 }
 
 
$contact_simple = '';
$contact_simple .= '
    <div class="contact-form">
     <form action='. $url .' method="post">
      <div class="contact-form-text">'.$myError.'</div>
       <label for="email">Email:</label>
       <input type="text" name="cf_email" value="" placeholder="put your email" required/>
       <label for="Subject">Subject:</label>
       <input type="text" name="cf_subject" value="" placeholder="put the subject" required/>
       <label for="message">Message:</label>
       <textarea name="cf_message" ></textarea>
       <div class="contact-submit"><input type="submit" value="Send Email" /></div>
     </form>
    </div>
	';


$imgURL = plugins_url('assets/contact-icon.png', __FILE__);

?>
<style>
  div#cbox1 {
  height: <?php echo $max_height;?>px !important;
  }
</style>
<?php if($alignment=='left'){?>
<div id="real_contact_display">
    <div id="cbox1" style="left: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+10);?>px;">
        <div id="cbox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>;">
            <a class="open" id="ylink" href="#"></a><img style="top: 0px;right:-50px;" src="<?php echo $imgURL;?>" alt="">
            <?php echo $contact_simple; ?>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function()
{
jQuery("#cbox1").hover(function(){ 
jQuery('#cbox1').css('z-index',101009);
jQuery(this).stop(true,false).animate({left:  0}, 500); },
function(){ 
    jQuery('#cbox1').css('z-index',10000);
    jQuery("#cbox1").stop(true,false).animate({left: -<?php echo trim($width+10); ?>}, 500); });
}); 
</script>
<?php } else { ?>
<div id="real_contact_display">
    <div id="cbox1" style="right: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+10);?>px;">
        <div id="cbox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>;">
            <a class="open" id="ylink" href="#"></a><img style="top: 0px;left:-50px;" src="<?php echo $imgURL;?>" alt="">
            <?php echo $contact_simple; ?>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function()
{
jQuery(function (){
jQuery("#cbox1").hover(function(){ 
jQuery('#cbox1').css('z-index',101009);
jQuery(this).stop(true,false).animate({right:  0}, 500); },
function(){ 
    jQuery('#cbox1').css('z-index',10000);
    jQuery("#cbox1").stop(true,false).animate({right: -<?php echo trim($width+10); ?>}, 500); });
});});

</script>
<?php } ?>
<?php
}
add_action( 'wp_enqueue_scripts', 'register_bruter_cf_contact_slider_styles' );
 function register_bruter_cf_contact_slider_styles() {
    wp_register_style( 'register_bruter_cf_contact_slider_styles', plugins_url( 'assets/cts_style.css' , __FILE__ ) );
    wp_enqueue_style( 'register_bruter_cf_contact_slider_styles' );
    wp_enqueue_script('jquery');
 }
 $bruter_cf_contact_default_values = array(
     'marginTop' => 250,
     'recipient' => 'yourmail@mail.com',
     'width' => '350',
     'height' => '430',
     'alignment' => 'left'
     
 );
add_option('bruter_cf_contact_plugin_options', $bruter_cf_contact_default_values);