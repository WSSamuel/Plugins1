<?php

/**
 * Filter Anything
 *
 * @author            Kalrav Joshi
 * @link              https://www.vardaam.com
 * @copyright         2022 Vardaam Web Solution Pvt Ltd
 * @package           WFA
 *
 * @wordpress-plugin
 * Plugin Name:       Filter Anything
 * Description:       This plugin provides dynamic Filter creation for any Post type or User data.
 * Version:           0.1.4
 * Author:            Vardaam™
 * Author URI:        https://www.vardaam.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wfa
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
const FILTER_ANYTHING_VERSION = '0.1.4';

require_once plugin_dir_path( __FILE__ ) . 'lib/autoload.php';
require_once plugin_dir_path( __FILE__ ) . 'src/helper_functions.php';

use Vardaam\FilterAnything\AjaxHandler;
use Vardaam\FilterAnything\CptAndTax;
use Vardaam\FilterAnything\GeneralHooks;
use Vardaam\FilterAnything\LoadCarbonField;
use Vardaam\FilterAnything\RegisterDirectoryFields;
use Vardaam\FilterAnything\Shortcode;

( function () {
	new GeneralHooks();
	new CptAndTax();
	new LoadCarbonField();
	new RegisterDirectoryFields();
	new Shortcode();
	new AjaxHandler();
} )();
