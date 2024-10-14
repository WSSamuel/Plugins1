<?php

/**
 * @link              https://roadmap.space
 * @since             1.0.0
 * @package           Roadmap_Space
 *
 * @wordpress-plugin
 * Plugin Name:       Roadmap
 * Plugin URI:        https://roadmap.space/help/roadmaps-and-stories/embedding-roadmap-on-your-wordpress-site/
 * Description:       This plugin allows you to embed your Roadmap and feedback widget on your website.
 * Version:           1.0.10
 * Author:            Roadmap
 * Author URI:        https://roadmap.space
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       roadmap-space
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ROADMAP_SPACE_VERSION', '1.0.10' );

require plugin_dir_path( __FILE__ ) . 'includes/class-roadmap-space.php';

function run_roadmap_space() {
	$plugin = new Roadmap_Space();
	$plugin->run();
}
run_roadmap_space();
