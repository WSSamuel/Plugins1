<?php
/*
Plugin Name: Europe Map ORG
Plugin URI: https://www.wpmapplugins.com/interactive-map-of-europe-wordpress-plugin.html
Description: Customize each country (colors, link, etc) through the dashboard and use the shortcode in your page.
Version: 2.7
Author: WP Map Plugins
Author URI: https://www.wpmapplugins.com/
Text Domain: eu-map-org
Domain Path: /languages
*/

declare(strict_types=1);

namespace EUMap_ORG;

use EUMap_ORG\EUMap_ORG;

if (!defined('EUMAP_ORG_VERSION')) {
    define('EUMAP_ORG_VERSION', '2.7');
}

if (!defined('EUMAP_ORG_DIR')) {
    define('EUMAP_ORG_DIR', plugin_dir_path(__FILE__));
}

if (!defined('EUMAP_ORG_URL')) {
    define('EUMAP_ORG_URL', plugin_dir_url(__FILE__));
}

(new EUMap_ORG())->init();

class EUMap_ORG {

    const PLUGIN_NAME = 'Europe Map ORG';

    private $options = null;

    public function init() {
        $this->initActions();
        $this->initShortcodes();
        $this->initOptions();
    }

    private function initActions() {
    	if( !function_exists('wp_get_current_user') ) {
            include(ABSPATH . "wp-includes/pluggable.php");
        }
        add_action( 'admin_menu', array($this, 'addOptionsPage') );
        add_action( 'admin_footer', array($this, 'addJsConfigInFooter') );
        add_action( 'admin_enqueue_scripts', array($this, 'initAdminScript') );
        add_action( 'init', array($this, 'loadTextdomain') );
    }

    private function initShortcodes() {
        add_shortcode('eu_map_org', array($this, 'EUMap_ORGShortcode'));
    }

    private function initOptions() {
        $defaultOptions = $this->getDefaultOptions();
        $this->options  = get_option('eu_map_org');

        if (current_user_can( 'manage_options' )){
            $this->updateOptions($defaultOptions);
        }

        if (!is_array($this->options)) {
            $this->options = $defaultOptions;
        }

        $this->prepareOptionsListForTpl();
    }

    public function addJsConfigInFooter() {
        include __DIR__ . "/includes/js-config.php";
    }

    public function addOptionsPage() {
        add_menu_page(
            EUMap_ORG::PLUGIN_NAME,
            EUMap_ORG::PLUGIN_NAME,
            'manage_options',
            'eu-map-org',
            array($this, 'optionsScreen'),
            EUMAP_ORG_URL . 'public/images/map-icon.png'
        );
    }

    /**
     * @return array
     */
    private function getDefaultOptions() {
        $default = array(
            'eubrdrclr_org'    => '#6B8B9E',
        );

        $areas = array(
            'ALBANIA', 'ANDORRA', 'AUSTRIA', 'BELARUS', 'BELGIUM', 'BOSNIA AND HERZEGOVINA', 'BULGARIA', 'CROATIA', 'CYPRUS', 'CZECH REPUBLIC', 'DENMARK', 'ESTONIA', 'FINLAND', 'FRANCE', 'GERMANY', 'GREECE', 'HUNGARY', 'ICELAND', 'IRELAND', 'ITALY', 'KOSOVO', 'LATVIA', 'LIECHTENSTEIN', 'LITHUANIA', 'LUXEMBOURG', 'MACEDONIA', 'MALTA', 'MOLDOVA', 'MONACO', 'MONTENEGRO', 'NETHERLANDS', 'NORWAY', 'POLAND', 'PORTUGAL', 'ROMANIA', 'RUSSIA (EUROPEAN PART)', 'SAN MARINO', 'SERBIA', 'SLOVAKIA', 'SLOVENIA', 'SPAIN', 'SWEDEN', 'SWITZERLAND', 'UKRAINE', 'UNITED KINGDOM', 'VATICAN CITY'
        );

        foreach ($areas as $k => $area) {
            $default['upclr_' . ($k + 1)]  = '#E0F3FF';
            $default['ovrclr_' . ($k + 1)] = '#8FBEE8';
            $default['dwnclr_' . ($k + 1)] = '#477CB2';
            $default['url_' . ($k + 1)]    = '';
            $default['turl_' . ($k + 1)]   = '_self';
            $default['enbl_' . ($k + 1)]   = 1;
        }

        return $default;
    }

    private function updateOptions(array $defaultOptions) {
        if (isset($_POST['eu_map_org']) && isset($_POST['submit-clrs'])) {
            $i = 1;
            while (isset($_POST['url_' . $i])) {
                $_POST['upclr_' . $i]  = $_POST['upclr_all'];
                $_POST['ovrclr_' . $i] = $_POST['ovrclr_all'];
                $_POST['dwnclr_' . $i] = $_POST['dwnclr_all'];

                $i++;
            }

            update_option('eu_map_org',$_POST);

            $this->options = $_POST;
        }

        if (isset($_POST['eu_map_org']) && isset($_POST['submit-url'])) {
            $i = 1;
            while (isset($_POST['url_' . $i])) {
                $_POST['url_' . $i]  = $_POST['url_all'];
                $_POST['turl_' . $i] = $_POST['turl_all'];

                $i++;
            }

            update_option('eu_map_org',$_POST);

            $this->options = $_POST;
        }

        if (isset($_POST['eu_map_org']) && !isset($_POST['preview_map'])) {
            update_option('eu_map_org',$_POST);

            $this->options = $_POST;
        }

        if (isset($_POST['eu_map_org']) && isset($_POST['restore_default'])) {
            update_option('eu_map_org', $defaultOptions);

            $this->options = $defaultOptions;
        }
    }

    private function prepareOptionsListForTpl() {
        $this->options['prepared_list'] = array();
        $i                              = 1;
        while (isset($this->options['url_' . $i])) {
            $this->options['prepared_list'][] = array(
                'index'  => $i,
                'url'    => $this->options['url_' . $i],
                'turl'   => $this->options['turl_' . $i],
                'upclr'  => $this->options['upclr_' . $i],
                'ovrclr' => $this->options['ovrclr_' . $i],
                'dwnclr' => $this->options['dwnclr_' . $i],
                'enbl'   => isset($this->options['enbl_' . $i]),
            );

            $i++;
        }
    }

    public function EUMap_ORGShortcode() {
        wp_enqueue_style('eu-map-org-style-frontend', EUMAP_ORG_URL . 'public/css/map-style.css', false, '1.0', 'all');
        wp_enqueue_script('eu-map-org-interact', EUMAP_ORG_URL . 'public/js/map-interact.js?t=' . time(), array('jquery'), 10, '1.0', true);

        ob_start();

        include __DIR__ . "/includes/map.php";
        include __DIR__ . "/includes/js-config.php";

        return ob_get_clean();
    }

    public function optionsScreen() {
        include __DIR__ . "/includes/admin.php";
    }

    public function initAdminScript() {
        if ( current_user_can( 'manage_options') && ( esc_attr(isset($_GET['page'])) && esc_attr($_GET['page']) == 'eu-map-org') ):
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_style('thickbox');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('media-upload');

            wp_enqueue_style('eu-map-org-dashboard-style', EUMAP_ORG_URL . 'public/css/dashboard-style.css', false, '1.0', 'all');
            wp_enqueue_style('eu-map-org-style', EUMAP_ORG_URL . 'public/css/map-style.css', false, '1.0', 'all');
            wp_enqueue_style('wp-tinyeditor', EUMAP_ORG_URL . 'public/css/tinyeditor.css', false, '1.0', 'all');

            wp_enqueue_script('eu-map-org-interact', EUMAP_ORG_URL . 'public/js/map-interact.js?t=' . time(), array('jquery'), 10, '1.0', true);
            wp_enqueue_script('eu-map-org-tiny.editor', EUMAP_ORG_URL . 'public/js/editor/tinymce.min.js', 10, '1.0', true);
            wp_enqueue_script('eu-map-org-script', EUMAP_ORG_URL . 'public/js/editor/scripts.js', array('wp-color-picker'), false, true);
        endif;
    }
    
    public function loadTextdomain() {
        load_plugin_textdomain( 'eu-map-org', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }
}
