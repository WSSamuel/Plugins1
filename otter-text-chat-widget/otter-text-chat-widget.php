<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ottertext.com
 * @since             1.0.0
 * @package           otter_text_chat_widget
 *
 * @wordpress-plugin
 * Plugin Name:       Otter Text - Chat Widget
 * Description:       This plugin allows you to quickly and easily add the Otter Text widget to your website.
 * Version:           1.0.0
 * Author:            Otter Text
 * Author URI:        https://ottertext.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       otter_text_chat_widget
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'OTTER_TEXT_CHAT_WIDGET_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-otter-text-chat-widget-activator.php
 */
function otter_text_chat_widget_activate_otter_text_chat_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-otter-text-chat-widget-activator.php';
	Otter_Text_Chat_Widget_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-otter-text-chat-widget-deactivator.php
 */
function otter_text_chat_widget_deactivate_otter_text_chat_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-otter-text-chat-widget-deactivator.php';
	Otter_Text_Chat_Widget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'otter_text_chat_widget_activate_otter_text_chat_widget' );
register_deactivation_hook( __FILE__, 'otter_text_chat_widget_deactivate_otter_text_chat_widget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-otter-text-chat-widget-main.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function otter_text_chat_widget_run() {

	$plugin = new Otter_Text_Chat_Widget_Main();
	$plugin->run();

}
otter_text_chat_widget_run();
