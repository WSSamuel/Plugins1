<?php

namespace Filkers\Blocks;

abstract class AbstractBlock {

    private static $globalAssetsLoaded = false;

    private static function loadGlobalAssets() {
        global $filkers_plugin_base_dir_path;

        if ( ! self::$globalAssetsLoaded) {
            self::$globalAssetsLoaded = true;

            // Apuntamos al fichero con la lista automatica de dependencias
            $asset_file = include( $filkers_plugin_base_dir_path . 'modules/block-registration/build/index.asset.php');

            // Registramos el script principal
            wp_register_script(
                'filkers-blocks-script',
                plugins_url( '../../block-registration/build/index.js', __FILE__ ),
                $asset_file['dependencies'],
                $asset_file['version']
            );

            // Registramos los estilos de reproduccion y edicion
            wp_register_style(
                'filkers-blocks-editor-style',
                plugins_url( '../../block-registration/build/index.css', __FILE__ ),
                array( 'wp-edit-blocks' ),
                filemtime( plugin_dir_path( __FILE__ ) . '../../block-registration/build/index.css' )
            );

            wp_register_style(
                'filkers-blocks-style',
                plugins_url( '../../block-registration/build/style-index.css', __FILE__ ),
                array( ),
                filemtime( plugin_dir_path( __FILE__ ) . '../../block-registration/build/style-index.css' )
            );

            $filkers_blocks_global_variables = array(
                'adminPluginsUrl' => network_admin_url( 'plugin-install.php' ),
                'isWooActive'     => in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true )
            );
            wp_localize_script( 'filkers-blocks-script', 'filkersBlocksGlobalVariables', $filkers_blocks_global_variables );

        }
    }

    protected $package = "filkers-blocks";
    protected $name = "";


    public function __construct($name) {
        $this->name = $name ? $name : $this->name;
    }

    protected function initialize() {
        if ( empty( $this->name ) ) {
    		_doing_it_wrong( __METHOD__, esc_html( __( 'Block name is required.', 'filkers-blocks' ) ), '4.5.0' );
    		return false;
    	}
    }

    protected function getSettings() {
        return array(
            'editor_script' => 'filkers-blocks-script',
            'style' => 'filkers-blocks-style',
            'editor_style' => 'filkers-blocks-editor-style'
        );
    }

    public function register() {
        AbstractBlock::loadGlobalAssets();
        $blockName = $this->package . '/' . $this->name;
        register_block_type($blockName, $this->getSettings());
    }
}