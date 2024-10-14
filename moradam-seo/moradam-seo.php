<?php

/**
 * Moradam SEO
 *
 * @link              https://www.moradam.com
 * @since             1.0.0
 * @package           Moradam_Seo
 * @copyright    Copyright (C) 2019, Moradam SEO - company@moradam.com
 *
 * @wordpress-plugin
 * Plugin Name:       Moradam SEO
 * Description:       Moradam SEO – Hepsi bir arada SEO eklentisi arama sonuçları sayfasında üst sıralarda yer almak istiyorsanız, web sitenizin metriklerini izlemeli ve rakiplerinizi yakından takip etmelisiniz. Moradam SEO ajansının sunduğu Wordpress sıra bulucu vb. Seo eklentileri ile gerekli tüm verileri bir anda kontrol etmenizi sağlayan oyun değiştiren bir yazılımdır.
 * Version:           1.0.7
 * Requires at least: 5.1
 * Requires PHP:      7.2
 * Author:            Moradam
 * Author URI:        https://www.moradam.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       moradam-seo
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

define ('MORADAM_SEO_PATH', plugin_dir_path( __FILE__ ));
define ('MORADAMSEO_URL', plugin_dir_url( __FILE__ ));

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MORADAM_SEO_VERSION', '1.0.7' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-moradam-seo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_moradam_seo() {
	$plugin = new Moradam_Seo();
	$plugin->run();
}

run_moradam_seo();
