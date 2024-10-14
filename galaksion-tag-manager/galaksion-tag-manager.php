<?php
/*
Plugin Name: Galaksion Tag Manager
Plugin URI: https://wordpress.org/support/plugin/galaksion-tag-manager
Description: A great way to insert and manage custom code (CSS, JS, meta tags, etc.) into website before &lt;/head&gt;, after &lt;body&gt;, before &lt;/body&gt; or inside content templates.
Version: 1.0
Author: Galaksion Advertising Network
Author URI: https://galaksion.com/
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: galaksion-tag-manager
Domain Path: /languages

Galaksion Tag Manager is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Galaksion Tag Manager is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Galaksion Tag Manager. If not, see https://www.gnu.org/licenses/gpl-2.0.html.

todo remake readme.txt
todo remake changelog
*/

require 'glxtmAutoloader.php';
$glxtmAutoloader = new glxtmAutoloader();
$glxtmAutoloader->register();
$glxtmAutoloader->addNamespace( 'glxtm\scriptsControl', __DIR__ );

$config = require( __DIR__ . '/config/plugin.php' );
( new \glxtm\scriptsControl\plugin\Plugin( $config ) )->run( '1.0.0', __FILE__, 'glxtm_' );
