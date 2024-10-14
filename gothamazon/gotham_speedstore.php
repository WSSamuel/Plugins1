<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

function kapsulewheel_speedystore( $atts, $content = null, $tag = '') {
	
	$output = "";
	
	global $multisite;
	global $iddusite;
	global $store_multi_id;
	global $amp;
	global $imgtag;
	global $imgtag_resp;
	global $imgtag_close;
	global $buildstore;
	
	if ($amp != true) {
		wp_enqueue_style( 'gothamazon-css-io' );
	}
	
	// On récupère les attributs des short code
	$a= shortcode_atts( array(
		'cat' => 1, // Query
	), $atts );


	$categoriedespost = esc_attr( $a['cat'] ); // si le shortcode le veut, il peut écraser la catégorie d'origine
	$plugins_url = plugins_url();
	$upload_dir_url = wp_get_upload_dir();
	$upload_dir_url = $upload_dir_url["baseurl"] . '/gothamazon';
	
	$my_posts = new WP_Query(array('post_type' => 'post', 'posts_per_page' => '20', 'cat' => $categoriedespost, 'orderby' => 'title', 'order'  => 'ASC'));
	
	if($my_posts->have_posts()) : 
	
		$output .= "<div style='clear:both;'></div><ul id='goth_indexboutique' class='goth_indexboutique'>";

		while($my_posts->have_posts()) : $my_posts->the_post(); 
		
			$id_du_post = get_the_ID();
			$zetitle = esc_html( get_the_title() );
			$zepermalink = get_the_permalink();
			
			if ( (BEERUS == "godmod") AND ($buildstore != "image_ala_une") ) {
				$zeimage = "$upload_dir_url/$store_multi_id$id_du_post.jpg";
				$image_size_info = @getimagesize($zeimage);
				
				if ( $image_size_info == FALSE ) {
					
					if ($amp == true) {
						
						$mesjoliesdimensions = "width='200' height='200'";
						
					} else {
						
						$mesjoliesdimensions="";
					
					}
					
				} else {
					
					$mesjoliesdimensions = $image_size_info[3];
					
				}
				
			} else {
				
				$get_post_thumb_id = get_post_thumbnail_id($id_du_post);
				$zeimage = wp_get_attachment_image_src( $get_post_thumb_id , 'thumbnail' );
				$zeimage = isset($zeimage[0]) ? $zeimage[0] : NULL;
				
				if (is_null($zeimage)) {
					
					$zeimage = "$plugins_url/gothamazon/img/folder.png";
					
				}
				
				$image_size_info = @getimagesize($zeimage);
				
				if ( $image_size_info == FALSE ) {
					
					if ($amp == true) {
						
						$mesjoliesdimensions = "width='200' height='200'";
						
					} else {
						
						$mesjoliesdimensions="";
						
					}
					
				} else {
					
					$mesjoliesdimensions = $image_size_info[3];
					
				}
				
			}
			
			$output .='<li><a href="'. $zepermalink. '"><span>'. $zetitle. '</span><'. $imgtag_resp .' src="'. $zeimage. '" alt="'. $zetitle. '" '. $mesjoliesdimensions .'>'. $imgtag_close .'</a></li>';
		
		endwhile; 

		$output .="</ul><div style='clear:both;'></div>";
	
	endif; 
	
	wp_reset_query();
	
	return $output;
}
add_shortcode( 'speedyshop', 'kapsulewheel_speedystore' );
// !Fin de la Création du module Sommaire SpeedBoutique
///////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////
// Création du module Related SpeedBoutik
function kapsulewheel_related_speedystore( $atts, $content = null, $tag = '') {
	
	$output = "";

// Gestion du multisite
	global $multisite;
	global $iddusite;
	global $store_multi_id;
	global $amp;
	global $imgtag;
	global $imgtag_resp;
	global $imgtag_close;
	global $buildstore;
	
	if ($amp != true) {
		wp_enqueue_style( 'gothamazon-css-io' );
	}
	
	// On récupère les attributs des short code
	$a= shortcode_atts( array(
		'cat' => 1, // Query
		'nono' => 3, // Query
	), $atts );

	$categoriedespost = esc_attr( $a['cat'] ); // si le shortcode le veut, il peut écraser la catégorie d'origine
	$nombreitems = esc_attr( $a['nono'] ); // si le shortcode le veut, il peut écraser la catégorie d'origine
	$plugins_url = plugins_url();
	$upload_dir_url = wp_get_upload_dir();
	$upload_dir_url = $upload_dir_url["baseurl"] . '/gothamazon';
	$my_posts = new WP_Query(array('post_type' => 'post', 'posts_per_page' => $nombreitems, 'cat' => $categoriedespost, 'post__not_in' => array( get_the_ID() ), 'orderby' => 'rand'));
	
	if($my_posts->have_posts()) : 
	
		$output .= "<div style='clear:both;'></div><ul id='goth_relatedboutique' class='goth_indexboutique'>";
		
		while($my_posts->have_posts()) : $my_posts->the_post(); 
		
			$id_du_post = get_the_ID();
			$zetitle = esc_html( get_the_title() );
			$zepermalink = get_the_permalink();
			
			if ( (BEERUS == "godmod") AND ($buildstore != "image_ala_une") ) {
				
				$zeimage = "$upload_dir_url/$store_multi_id$id_du_post.jpg";
				$image_size_info = @getimagesize($zeimage);
				if ( $image_size_info == FALSE ) {
					
					if ($amp == true) {
						
						$mesjoliesdimensions = "width='200' height='200'";
						
					} else {
						
						$mesjoliesdimensions="";
						
					}
					
				} else {
					
						$mesjoliesdimensions = $image_size_info[3];
						
				}
				
			} else {
				
				$get_post_thumb_id = get_post_thumbnail_id($id_du_post);
				$zeimage = wp_get_attachment_image_src( $get_post_thumb_id , 'thumbnail' );
				$zeimage = $zeimage[0];
				
				if (empty($zeimage)) {
					
					$zeimage = "$plugins_url/gothamazon/img/folder.png";
					
				}
				
				$image_size_info = @getimagesize($zeimage);
				
				if ( $image_size_info == FALSE ) {
					
					if ($amp == true) {
						
						$mesjoliesdimensions = "width='200' height='200'";
						
					} else {
						
						$mesjoliesdimensions="";
						
					}
					
				} else {
					
					$mesjoliesdimensions = $image_size_info[3];
					
				}
				
			}
			
			$output .='<li><a href="'. $zepermalink. '"><span>'. $zetitle. '</span><'. $imgtag_resp .' src="'. $zeimage. '" alt="'. $zetitle. '" '. $mesjoliesdimensions .'>'. $imgtag_close .'</a></li>';
			
		endwhile; 
		
	$output .="</ul><div style='clear:both;'></div>";
	
	endif; 
	
	wp_reset_query();
	
	return $output;
}
add_shortcode( 'related_speedyshop', 'kapsulewheel_related_speedystore' );
// Fin de la Création du module Related SpeedyStore