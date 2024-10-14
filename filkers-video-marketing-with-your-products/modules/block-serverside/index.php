<?php

defined( 'ABSPATH' ) || exit;

use Filkers\Blocks\FolderPlayerBlock;
require_once('src/FolderPlayerBlock.php');

use Filkers\Blocks\FeaturedProductsBlock;
require_once('src/FeaturedProductsBlock.php');

use Filkers\Blocks\HandpickedProductsBlock;
require_once('src/HandpickedProductsBlock.php');

use Filkers\Blocks\OnSaleProductsBlock;
require_once('src/OnSaleProductsBlock.php');

use Filkers\Blocks\NewestProductsBlock;
require_once('src/NewestProductsBlock.php');


/**
  * Include Filkers' javascript to provide tag library support
*/

function filkers_blocks_load_external_assets() {
    wp_enqueue_style(
        'filkers-taglib',
        'https://widgets.filkers.com/js/filkers-taglib.umd.css'
    );

    wp_enqueue_script(
        'filkers-taglib',
        'https://widgets.filkers.com/js/filkers-taglib.umd.js'
    );
}

add_action( 'enqueue_block_assets', 'filkers_blocks_load_external_assets' );





function filkers_blocks_init() {
    global $wp_version;
    /**
      * Adds Filkers' custom block category
      */

    if (strpos($wp_version, "5.8") === false) {
        add_filter( 'block_categories', function( $categories, $post ) {
            return array_merge(
                $categories,
                array(
                    array(
                        'slug'  => 'filkers-blocks',
                        'title' => 'Filkers',
                    ),
                )
            );
        }, 10, 2 );
    } else {
        add_filter(  'block_categories_all', function( $categories, $post ) {
            return array_merge(
                $categories,
                array(
                    array(
                        'slug'  => 'filkers-blocks',
                        'title' => 'Filkers',
                    ),
                )
            );
        }, 10, 2 );
    }

    /** Register blocks */

    $blocks = array(
        new FolderPlayerBlock(),
        new FeaturedProductsBlock(),
        new HandpickedProductsBlock(),
        new OnSaleProductsBlock(),
        new NewestProductsBlock()
    );

    foreach ( $blocks as $block) {
        $block->register();
    }
}

add_action( 'init', 'filkers_blocks_init' );
