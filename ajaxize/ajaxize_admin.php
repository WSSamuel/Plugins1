<?php

/* PLUGIN SETTINGS */
/* handling the admin option page for ajaxize */

// add the admin options page
add_action('admin_menu', 'ajaxize_admin_add_page');
// add the admin settings and such
add_action('admin_init', 'ajaxize_admin_init');

$div_content = '';

function ajaxize_this_generate_div_header() {
?>
    <div class="wrap">
    <h2><?php _e('Generate Ajaxized DIV for your function'); ?></h2>

    <p> Ajaxize will allow you to ajaxize almost any php function on your site. </p>
    <p> It can be a plugin, a function you wrote, or even a core wordpress function. </p>
    <br/>
    <p> There are some (obvious or less obvious) limitations currently: <p>
    <p> 
    <ul style="list-style-type: disc; margin-left: 20px;">
    <li>Functions must return valid HTML - this will be called in php and returned via the Ajax call</li>
    <li>Functions cannot accept any parameters (at least at the moment)</li>
    </ul>
    </p>
    <br />
    <form action="" method="post" id="ajaxize-this-function" style="">
    <?php if ( function_exists('wp_nonce_field') )
        wp_nonce_field('ajaxize_this_generate_div');
    ?>
    <p> Enter a function name below.</p>
    <p>Function Name: <input type="text" id="function_name" name="function_name"></p>
    <p class="submit"><input type="submit" name="submit" value="<?php _e('Generate DIV &raquo;'); ?>" /></p>
    <p>The generated div can be inserted to any page/post on the site and will ajaxize the call to the function automatically.</p>
    <p>Please make sure you enter a valid function name, that the function does not require any parameters, and that it returns valid HTML.</p>
    </form>
    </div>
<?php 
    global $div_content;
    echo $div_content;
}

function ajaxize_this_generate_div_content($fn_name) {
    $content = '';
    $content .= "<p> Copy & paste this div below </p>";
    $output_div = "<div id=\"ajaxize_this:" . $fn_name . ":" . ajaxize_this_hmac($fn_name) . "\"></div>";
    $content .= "<pre><strong>" . htmlentities($output_div) . "</strong></pre>";
    $content .= "<p> Function output (via ajaxize): </p>";
    $content .= '<div style="border: #d4d4d4 1px solid; border-radius: 8px; webkit-border-radius: 8px; moz-border-radius: 8px;">';
    $content .= str_replace('><', '> If you see this message. Something is not working <', $output_div);
    $content .= '</div>';
    return $content;
}


function ajaxize_admin_add_page() {
    global $ajaxize_this_hook;
    $ajaxize_this_hook = add_options_page('Ajaxize settings', 'Ajaxize', 'manage_options', 'ajaxize_this', 'ajaxize_options_page');
}

// display the admin options page
function ajaxize_options_page() { ?>
    <div class="wrap">
    <h2>Ajaxize</h2>

    <form action="options.php" method="post">
    <?php settings_fields('ajaxize_this_options'); ?>
    <?php do_settings_sections('ajaxize_this'); ?>
<p>A random Secret Key was automatically generated when the plugin was first installed.<br />
You can change your secret key, but please be aware that any previously-generated divs will stop working.<br />
Do not post or share this key.</p>
<p>De-selecting Ajax Referer Check can help with some browsers with aggressive caching.<br />
You can de-select Ajax Referer Check if your ajaxize functions have no side-effect. Recommended settings: On</p>
    <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form></div>

<?php ajaxize_this_generate_div_header();
}


function ajaxize_admin_init(){
    register_setting( 'ajaxize_this_options', 'ajaxize_this_options', 'ajaxize_options_validate_secret_key' );
    add_settings_section('plugin_main', 'Security Settings', create_function('',''), 'ajaxize_this');
    add_settings_field('secret_key', 'Secret Key', 'plugin_setting_secret_key', 'ajaxize_this', 'plugin_main');
    add_settings_field('ajax_referer_check', 'Ajax Referer Check', 'plugin_setting_ajax_referer_check', 'ajaxize_this', 'plugin_main');
    init_ajaxize_options('ajaxize_this_options');

    // handle POST of function name (placed here to allow displaying errors)
    if ( isset($_POST['submit']) && isset($_POST['function_name'])) {
        check_admin_referer('ajaxize_this_generate_div');
        $fn_name = ajaxize_this_validate_function($_POST['function_name']);
        if (! empty($fn_name) ) {
            global $div_content;
            $div_content = ajaxize_this_generate_div_content($fn_name);
        }
    }
}

function init_ajaxize_options($opt_name) {
    $options = get_option($opt_name);
    if (empty($options)) {
        $options['secret_key'] = sha1(session_id());
        $options['ajax_referer_check'] = 1;
        update_option($opt_name, $options);
    }
    if (!array_key_exists('ajax_referer_check', $options)) {
        $options['ajax_referer_check'] = 1;
        update_option($opt_name, $options);
    }
}

function plugin_setting_secret_key () {
    $options = get_option('ajaxize_this_options');
    echo "<input id='secret_key' name='ajaxize_this_options[secret_key]' size='40' type='text' value='{$options['secret_key']}' />";
}

function plugin_setting_ajax_referer_check () {
    $options = get_option('ajaxize_this_options');
    if ($options['ajax_referer_check'] == 1) { $checked = "checked='checked'"; }
    echo "<input id='ajax_referer_check' name='ajaxize_this_options[ajax_referer_check]' type='checkbox' value='1' {$checked} />";
}

// validate our options
function ajaxize_options_validate_secret_key($input) {
    $options = get_option('ajaxize_this_options');
    $options['ajax_referer_check'] = 0;
    // doing per-field regex validation. 
    // You can add / change validation rules here
    foreach ($input as $k => $v) {
        if (preg_match('/ajax_referer_check/i', $k)) { $options[$k] = $v; continue; }
        if (preg_match('/^[a-z0-9]{12,}$/i', $v)) {
            $options[$k] = $v;
        }
        else {
            add_settings_error('secret_key','ajaxize_this_err','Secret Key must be alphanumeric and at least 12 characters long','error');
        }
    }
    return $options;
}


function ajaxize_this_validate_function($fn_name) {
    if (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $fn_name)) {
        if (! function_exists($fn_name)) {
            add_action('admin_notices', create_function('', 'echo \'<div id="message" class="error"><p>Fuction not found.</p></div>\';'));
        }
        else return $fn_name;
    }
    else {
        add_action('admin_notices', create_function('', 'echo \'<div id="message" class="error"><p>Invalid function name. Make sure to remove () and any extra spaces.</p></div>\';'));
    }

}

add_filter('contextual_help', 'ajaxize_this_help', 10, 3);
// help page for ajaxize plugin (taken from FAQ)
function ajaxize_this_help($contextual_help, $screen_id, $screen) {
    global $ajaxize_this_hook;
    if ($screen_id == $ajaxize_this_hook) {
        $contextual_help = <<<EOD
    <h1>Ajaxize</h1> 
 
    <p>Ajaxize will allow you to ajaxize almost any php function on your site.
It can be a plugin, a function you wrote, or even a core wordpress function.</p>    <hr /> 
        <h3>Frequently Asked Questions</h3> 
        Please check out the <a href="https://wordpress.org/plugins/ajaxize/faq/" target="_blank">Frequently Asked Questions</a> page for more info.
EOD;
    }
    return $contextual_help;
}
/* END PLUGIN SETTINGS */
?>
