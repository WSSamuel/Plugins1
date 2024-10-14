<?php
/*
Plugin Name: Ird Slider
Plugin URI: https://inforrada.es/plugins/
Description: Galería apta para testimonios, opiniones, portfolios, etc
Version: 1.0.2
Author: Inforrada
Author URI: https://inforrada.es
License: GPL2
*/
defined('ABSPATH') or die("Bye bye");
define('IRDSLIDER_BASE',plugin_dir_path(__FILE__));
define('IRDSLIDER_BASE_URL',plugin_dir_url(__FILE__));

include IRDSLIDER_BASE . 'includes/ird_shortcodes.php';
include IRDSLIDER_BASE . 'includes/ird_comun.php';


add_action( 'admin_menu', 'irdslider_create_admin_menu');

function irdslider_create_admin_menu() {

 add_options_page( 'IRD Slider', 'Ird Slider', 'manage_options', IRDSLIDER_BASE . 'admin/ird_slider_general.php', null, null );
 
 }

 function irdslider_settings_link ( $links ) {
    $settings_link = array( 'settings' => '<a href="' . admin_url('admin.php?page=irdslider/admin/ird_slider_general.php' ) . '">' . __('Settings', 'irdslider') . '</a>');

    return array_merge( $links, $settings_link );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'irdslider_settings_link' );

////

 function irdslider_tarjeta_add() {
    $screens = [ 'irdslider'];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'irdslider_tarjeta', 'Información del slider', 'irdslider_tarjeta_paint',
            $screen                            // Post type
        );
    }
}
$irdslider_campos = Array ();

array_push ($irdslider_campos, Array ('etiquetas', 'Etiquetas', 'T'));
array_push ($irdslider_campos, Array ('url', 'url', 'T'));
array_push ($irdslider_campos, Array ('tipo', 'Tipo', 'T'));
array_push ($irdslider_campos, Array ('orden', 'Orden', 'P')); 

//array_push ($irdslider_campos, Array ('nombre', 'Nombre', 'T'));
function irdslider_tarjeta_paint( $post ) {
    global $irdslider_campos;
    if (sizeof ($irdslider_campos) > 0) {
        echo '<table>';
        foreach ($irdslider_campos as &$item) {
            irdslider_pintaCampo ($post, $item[1], $item[0], $item[2], true);
        
        }
        echo '</table>';
    } 

}


function irdslider_tarjeta_save( $post) {
    global $irdslider_campos;

    if ( current_user_can( 'edit_post', $post)){
        foreach ($irdslider_campos as &$item) {
            irdslider_upd_field ($post, $item[0], $item[2]);
        }
    }
  }
 

function irdslider_register_tarjeta_post_type() { 
    $labels = array(
       'name' => _x( 'Ird sliders', 'Datos complementarios' ), 
       'singular_name' => _x( 'Ird Slider', 'Datos complementarios' )
    );   
    
    $args = array(
      'labels' => $labels,
      'description' => 'Datos opcionales',
      'menu_position' => 8,
      'menu_icon' => 'dashicons-format-gallery',
      'supports' => array( 'title', 'editor', 'thumbnail'),
      'show_in_rest' => true,
      'public' => true,
      'has_archive' => true,
      'capabilities' => array(
        'edit_post'          => 'update_core',
        'read_post'          => 'update_core',
        'delete_post'        => 'update_core',
        'edit_posts'         => 'update_core',
        'edit_others_posts'  => 'update_core',
        'delete_posts'       => 'update_core',
        'publish_posts'      => 'update_core',
        'read_private_posts' => 'update_core'
    ),
    );


   
   
    register_post_type( 'irdslider', $args );
    
  }



add_action( 'init', 'irdslider_register_tarjeta_post_type' );
add_action( 'add_meta_boxes', 'irdslider_tarjeta_add' );
add_action( 'save_post', 'irdslider_tarjeta_save');


////

function irdslider_pintaCampo  ($post, $lbl, $campo, $tipo, $tabulado = false)  {
    $value = get_post_meta( $post->ID, $campo, true );
    $s = '';
    if ($tabulado == true) {
        $s .= '<tr><td>';
    }

  
        $s .= '<label for="' . $campo. '">' . esc_html ($lbl) . '</label>';

    if ($tabulado == true) {
        $s .= '</td><td>';
    }
    $tipoinput = 'text';
    if ($tipo == 'D') {
        $tipoinput = 'date';
    }
    else if ($tipo == 'E') {
        $tipoinput = 'email';
    }
    else if ($tipo == 'P') {
        $tipoinput = 'number';
    }
    $s .=  '<input type="' . $tipoinput . '" id="' . $campo. '" name="' . $campo. '" value="' . esc_html($value) . '">';


    if ($tabulado == true) {
        $s .= '</td></tr>';
    }

    echo esc_html ($s);
}

function irdslider_upd_field ($post, $campo, $tipo) {
    if ( isset($_POST[$campo]) ) {   
        if ($tipo == 'GAL') {
            $s = sanitize_text_field ($_POST[$campo]);
            $elem = explode (',', $s);
            $data = serialize($elem);

            update_post_meta($post, $campo,  $data);   
        }     
        else if ($tipo == 'L') {
            update_post_meta($post, $campo, explode(";", sanitize_text_field($_POST[$campo])));      
        }
        else {
            if ($tipo == 'CHK') {
                update_post_meta($post, $campo,  sanitize_text_field($_POST[$campo]));

            }
            else {
                update_post_meta($post, $campo, sanitize_text_field($_POST[$campo]));      
 
            }
      
        }
      }
}

/// SHORTCODE

function irdslider_pinta_shortcode($atts = []) { 
    $id = 0;
    if (isset ($atts['id'])){
        $id = $atts['id'];
    }
    $estilos = 'webmovil';
    $tipo = 'algo';
    $target = '_blank'; 
    $speed = '5000';

    if (isset ($atts['estilo'])){
        $estilos = $atts['estilo'];
    }
    if (isset ($atts['tipo'])){
        $tipo = $atts['tipo'];
    }
    if (isset ($atts['target'])){
        $target = $atts['target'];
    }
    if (isset ($atts['speed'])){
        $speed = $atts['speed'];
    }
    $temp_post = $post; // Guardamos el objeto de $post temporalmente
    $args = array(
        'post_type' => 'irdslider', 
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'meta_key' => 'orden',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query'     => [
            [
                'key'      => 'tipo',
                'value'    => $tipo,
            ]
        ],
        );
                
    $my_query = new WP_Query($args);
    $s = '<div id="irdslider_' . $id . '" class="irdslider-contenedor">';
    $i = 0;
    if ($my_query->have_posts()) {
        
        
        while ($my_query->have_posts()) {
            $p = $my_query->next_post();
            
            $title = $p->post_title;
            $img = get_the_post_thumbnail_url ($p->ID);
            $subtitulo = get_post_meta( $p->ID, 'etiquetas', true );;
            $url = get_post_meta( $p->ID, 'url', true );;
            $texto = $p->post_content;
            $click = '';
            if ($url != '') {
                $click = ' onclick="window.open (\'' . $url . '\', \'' . $target . '\')" ';
            }
            $s .= '<div><div id="irdslider_' . $id . '_' . $i . '" class="irdslider-tarjeta" ' . $click. '>';
            
            if ($img != '') {
                $s .= '<div id="irdslider_' . $id . '_di_' . $i . '" class="irdslider-div-img"><img src="' . $img . '" class="irdslider-img"></div>';
            }
            if (($title != '') || ($subtitulo != '') || ($texto != '')) {
                $s .= '<div id="irdslider_' . $id . '_dt_' . $i . '" class="irdslider-div-txt">';
                    $s .= '<div id="irdslider_' . $id . '_tit_' . $i . '" class="irdslider-div-titulo">' . esc_html ($title). '</div>';
                    $s .= '<div id="irdslider_' . $id . '_sub_' . $i . '" class="irdslider-div-subtitulo">' .  esc_html($subtitulo) . '</div>';
                    $s .= '<div id="irdslider_' . $id . '_txt_' . $i . '" class="irdslider-div-texto">' . esc_html ($texto) . '</div>';
            
                $s .= '</div>';
            }
            $s .= '</div></div>';
        }
    
       
        

    }
    wp_reset_postdata();
    $post = $temp_post; 


    
    $s .= '</div>';

$script = 'jQuery(\'#irdslider_' . $id . '\').slick({
    dots: true,
    infinite: true,
    lazyLoad: \'ondemand\',
    speed: 500,
    autoplay: true,
    autoplaySpeed: ' . $speed . ',
    fade: false,
    cssEase: \'linear\'
  }); console.log ("PASO")';

    wp_enqueue_style( 'irdslider-slickcss', IRDSLIDER_BASE_URL . 'public/css/slick.1.8.1.css' );
    wp_enqueue_style( 'irdslider-slicktheme', IRDSLIDER_BASE_URL . 'public/css/slick-theme.1.8.1.css' );
    wp_enqueue_script( 'irdslider-slickjs', IRDSLIDER_BASE_URL . 'public/js/slick.min.1.8.1.js'  );
   
    wp_enqueue_style( 'irdslider-base', IRDSLIDER_BASE_URL . 'public/css/' . $estilos . '.css' );
    wp_add_inline_script('irdslider-slickjs', $script, 'after');
    
    return $s;
}
add_shortcode('irdslider', 'irdslider_pinta_shortcode');

?>