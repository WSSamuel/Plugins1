<?php
/**
 * author_avatar
 *
 * Add a Upload field in the user profile admin
 *
 * @package   author-avatar
 * @author    Guillaume Kanoufi <guillaume@lostwebdesigns.com>
 * @license   GPL-2.0+
 * @link      http://lostwebdesigns.com
 * @copyright 12-16-2013 Company Name
 *
 * @wordpress-plugin
 * Plugin Name: author_avatar
 * Plugin URI:  http://lostwebdesigns.com
 * Description: Add a Upload field in the user profile admin
 * Version:     1.0.2
 * Author:      Guillaume Kanoufi
 * Author URI:  http://lostwebdesigns.com
 * Text Domain: author-avatar-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if (!defined("WPINC")) {
	die;
}

require_once(plugin_dir_path(__FILE__) . "authorAvatar.php");

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook(__FILE__, array("authorAvatar", "activate"));
register_deactivation_hook(__FILE__, array("authorAvatar", "deactivate"));


authorAvatar::get_instance();
