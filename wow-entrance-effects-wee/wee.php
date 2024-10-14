<?php
/*
Plugin Name: WOW Entrance Effects (WEE!)
Plugin URI: http://www.darkos.io
Description: Helps you add awesome entrance effects using shortcodes.
Author: Darkos
Version: 0.1
Author URI: http://www.darkos.io
*/

/*-----------------------------------------------------------
Enqueue Scripts > FrontEnd
-----------------------------------------------------------*/
function wee_scripts() {
    wp_register_style( 'wee-animate-css', plugin_dir_url( __FILE__ ) . '/assets/css/animate.min.css', false, false);
    wp_enqueue_style('wee-animate-css');
    wp_register_script( 'wee-wow-js', plugin_dir_url( __FILE__ ) . '/assets/js/wow.min.js', false, false, true );
    wp_enqueue_script('wee-wow-js');

}
add_action('wp_enqueue_scripts', 'wee_scripts');

/*-----------------------------------------------------------
Enqueue Scripts > BackEnd
-----------------------------------------------------------*/

function wee_admin_scripts()
  {
  wp_register_script( 'wee-core-js', plugin_dir_url( __FILE__ ) . '/assets/js/wee_core.js', false, false, true );
  wp_register_style( 'wee-animate-css', plugin_dir_url( __FILE__ ) . '/assets/css/animate.min.css', false, false );
  wp_register_style( 'wee-options', plugin_dir_url( __FILE__ ) . '/assets/css/options.min.css', false, false );

  wp_enqueue_script('wee-core-js');
  wp_enqueue_style('wee-animate-css');
  wp_enqueue_style('wee-options');
  }

add_action('admin_enqueue_scripts', 'wee_admin_scripts');


/*-----------------------------------------------------------
Add Options Link on Plugin List
-----------------------------------------------------------*/

function wee_plugin_options_link($links) {
    $settings_link = '<a href="options-general.php?page=wee-generate.php">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'wee_plugin_options_link');

/*-----------------------------------------------------------
The Shortcode
-----------------------------------------------------------*/
function wee_animate($atts, $content = null) {
    extract(shortcode_atts(
        array(
            'animation' => 'fadeIn',
            'duration' => '1',
            'repeats' => '1',
            'delay' => '0',
            'offset' => '0'
        ), $atts));

    return '<div class="wow animated '. $animation .
    '" data-wow-iteration="'. $repeats .
    '" ' .
    'data-wow-duration="' . $duration .
    's" ' .
    'data-wow-delay="' . $delay .
    's" ' . 
    'data-wow-offset="' . $offset . 
    '">' . do_shortcode($content) .
    '</div>';

}
add_shortcode('wee', 'wee_animate');

/*-----------------------------------------------------------
The Options Page
-----------------------------------------------------------*/
add_action('admin_menu', 'wee_plugin_setup_menu');

function wee_plugin_setup_menu() {
    add_submenu_page('options-general.php', 'WOW Entrance Effects', 'WEE! Generator', 'manage_options', 'wee-generate', 'wee_init');
}

function wee_init() {
?>
<h1>Generate your shortcode</h1>

<div class="wee-playground">
    <div id="animationSandbox" style="display: block;">
        <h1>WEE!</h1>
    </div>
</div>

<form>
    <select class="input input--dropdown js--animations">
        <optgroup label="Attention Seekers">
            <option value="bounce">
                bounce
            </option>

            <option value="flash">
                flash
            </option>

            <option value="pulse">
                pulse
            </option>

            <option value="rubberBand">
                rubberBand
            </option>

            <option value="shake">
                shake
            </option>

            <option value="swing">
                swing
            </option>

            <option value="tada">
                tada
            </option>

            <option value="wobble">
                wobble
            </option>

            <option value="jello">
                jello
            </option>
        </optgroup>

        <optgroup label="Bouncing Entrances">
            <option value="bounceIn">
                bounceIn
            </option>

            <option value="bounceInDown">
                bounceInDown
            </option>

            <option value="bounceInLeft">
                bounceInLeft
            </option>

            <option value="bounceInRight">
                bounceInRight
            </option>

            <option value="bounceInUp">
                bounceInUp
            </option>
        </optgroup>

        <optgroup label="Bouncing Exits">
            <option value="bounceOut">
                bounceOut
            </option>

            <option value="bounceOutDown">
                bounceOutDown
            </option>

            <option value="bounceOutLeft">
                bounceOutLeft
            </option>

            <option value="bounceOutRight">
                bounceOutRight
            </option>

            <option value="bounceOutUp">
                bounceOutUp
            </option>
        </optgroup>

        <optgroup label="Fading Entrances">
            <option value="fadeIn">
                fadeIn
            </option>

            <option value="fadeInDown">
                fadeInDown
            </option>

            <option value="fadeInDownBig">
                fadeInDownBig
            </option>

            <option value="fadeInLeft">
                fadeInLeft
            </option>

            <option value="fadeInLeftBig">
                fadeInLeftBig
            </option>

            <option value="fadeInRight">
                fadeInRight
            </option>

            <option value="fadeInRightBig">
                fadeInRightBig
            </option>

            <option value="fadeInUp">
                fadeInUp
            </option>

            <option value="fadeInUpBig">
                fadeInUpBig
            </option>
        </optgroup>

        <optgroup label="Fading Exits">
            <option value="fadeOut">
                fadeOut
            </option>

            <option value="fadeOutDown">
                fadeOutDown
            </option>

            <option value="fadeOutDownBig">
                fadeOutDownBig
            </option>

            <option value="fadeOutLeft">
                fadeOutLeft
            </option>

            <option value="fadeOutLeftBig">
                fadeOutLeftBig
            </option>

            <option value="fadeOutRight">
                fadeOutRight
            </option>

            <option value="fadeOutRightBig">
                fadeOutRightBig
            </option>

            <option value="fadeOutUp">
                fadeOutUp
            </option>

            <option value="fadeOutUpBig">
                fadeOutUpBig
            </option>
        </optgroup>

        <optgroup label="Flippers">
            <option value="flip">
                flip
            </option>

            <option value="flipInX">
                flipInX
            </option>

            <option value="flipInY">
                flipInY
            </option>

            <option value="flipOutX">
                flipOutX
            </option>

            <option value="flipOutY">
                flipOutY
            </option>
        </optgroup>

        <optgroup label="Lightspeed">
            <option value="lightSpeedIn">
                lightSpeedIn
            </option>

            <option value="lightSpeedOut">
                lightSpeedOut
            </option>
        </optgroup>

        <optgroup label="Rotating Entrances">
            <option value="rotateIn">
                rotateIn
            </option>

            <option value="rotateInDownLeft">
                rotateInDownLeft
            </option>

            <option value="rotateInDownRight">
                rotateInDownRight
            </option>

            <option value="rotateInUpLeft">
                rotateInUpLeft
            </option>

            <option value="rotateInUpRight">
                rotateInUpRight
            </option>
        </optgroup>

        <optgroup label="Rotating Exits">
            <option value="rotateOut">
                rotateOut
            </option>

            <option value="rotateOutDownLeft">
                rotateOutDownLeft
            </option>

            <option value="rotateOutDownRight">
                rotateOutDownRight
            </option>

            <option value="rotateOutUpLeft">
                rotateOutUpLeft
            </option>

            <option value="rotateOutUpRight">
                rotateOutUpRight
            </option>
        </optgroup>

        <optgroup label="Sliding Entrances">
            <option value="slideInUp">
                slideInUp
            </option>

            <option value="slideInDown">
                slideInDown
            </option>

            <option value="slideInLeft">
                slideInLeft
            </option>

            <option value="slideInRight">
                slideInRight
            </option>
        </optgroup>

        <optgroup label="Sliding Exits">
            <option value="slideOutUp">
                slideOutUp
            </option>

            <option value="slideOutDown">
                slideOutDown
            </option>

            <option value="slideOutLeft">
                slideOutLeft
            </option>

            <option value="slideOutRight">
                slideOutRight
            </option>
        </optgroup>

        <optgroup label="Zoom Entrances">
            <option value="zoomIn">
                zoomIn
            </option>

            <option value="zoomInDown">
                zoomInDown
            </option>

            <option value="zoomInLeft">
                zoomInLeft
            </option>

            <option value="zoomInRight">
                zoomInRight
            </option>

            <option value="zoomInUp">
                zoomInUp
            </option>
        </optgroup>

        <optgroup label="Zoom Exits">
            <option value="zoomOut">
                zoomOut
            </option>

            <option value="zoomOutDown">
                zoomOutDown
            </option>

            <option value="zoomOutLeft">
                zoomOutLeft
            </option>

            <option value="zoomOutRight">
                zoomOutRight
            </option>

            <option value="zoomOutUp">
                zoomOutUp
            </option>
        </optgroup>

        <optgroup label="Specials">
            <option value="hinge">
                hinge
            </option>

            <option value="rollIn">
                rollIn
            </option>

            <option value="rollOut">
                rollOut
            </option>
        </optgroup>
    </select> <button class="wee-btn js--triggerAnimation">Replay
    Animation</button> <input class="the-shortcode" placeholder=
    "Your shortcode will appear here" readonly type="text">
</form>

<div class="instructions">
    <h3>Instructions:</h3>

<p>Pretty straight forward.&nbsp;Use the generator above to test the animations
and copy your shortcode. You can tweak the <strong>duration</strong>,
<strong>delay</strong> and <strong>repeats</strong>. For infinite repeats
please use: <strong>repeats=&quot;infinite&quot;</strong>.<br>
The numbers on the shortcode represent the <strong>seconds</strong> of duration
and delay. If you want to use miliseconds you can use it this way:
<strong>duration=&quot;0.5&quot;</strong>. This means that the animation will
take 500 miliseconds to complete.</p>
</div>

<div class="available-options">
<h3>Available options:</h3>

<ul>
    <li><strong>animation</strong> (The animation type. Default: fadeIn)</li>

    <li><strong>duration</strong> (The animation duration in seconds. Default:
    1)</li>

    <li><strong>repeats</strong> (The times that the animation repeats. Can be
    a number or &quot;infinite&quot;. Default: 1)</li>

    <li><strong>delay</strong> (The delay before the animation triggers, in
    seconds. Default: 0)</li>

    <li><strong>offset</strong> (Distance to the element when triggering the
    animation. Default: 0)</li>
</ul>
</div>
<div class="credits">
    <h3>Credits:</h3>

    <ul>
        <li>
            <a href="https://daneden.me/" target="_blank">Animate.css - Daniel
            T. Eden</a>
        </li>

        <li>
            <a href="https://twitter.com/mattaussaguel/" target="_blank">WOW.js
            - Matt Aussaguel</a>
        </li>

        <li>
            <a href="https://www.facebook.com/darkosxrc/" target="_blank">This
            Plugin - George Darkos</a>
        </li>
    </ul>Thanks for using WEE! I hope you enjoy it. :)
</div>
<?php
}

/* That's all folks! */