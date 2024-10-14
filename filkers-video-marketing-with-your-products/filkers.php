<?php

/*
	Plugin Name: Filkers - Turn your products into videos
	Plugin URI:  https://www.filkers.com/woocommerce/
	Description: Connect your product catalog to make videos in real time with Filkers. Filkers will enable you to advertise your products with flair, creativity and professionalism. The way they deserve to be marketed!
	Version:     1.1.12
	Author:      Filkers
	Author URI:  https://filkers.com
	License:     GPL v2 or later
	License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
    Text Domain: filkers-video-marketing-with-your-products
    Domain Path: /languages/
*/

/*
  "Filkers Plugin" Copyright (C) 2021 Filkers (email : info@filkers.com)

  Filkers Plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

  Filkers Plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along with Contact Form to Database Extension. If not, see http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) || exit;

global $filkers_plugin_base_dir_path;
$filkers_plugin_base_dir_path = plugin_dir_path( __FILE__ );

require_once('modules/block-serverside/index.php');
require_once('modules/elementor/index.php');
require_once('modules/data-connector/index.php');
