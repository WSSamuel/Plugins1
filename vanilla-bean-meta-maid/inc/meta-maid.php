<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VanillaBeans\MetaMaid;

if (!function_exists('\VanillaBeans\MetaMaid\vbean_wphead')) {

    function vbean_wphead() {
        echo vbean_filterwpvars(get_option('vbean_meta_maid_htmlhead'));
        if(wp_is_mobile()){
            echo vbean_filterwpvars(get_option('vbean_meta_maid_mobilehtmlhead'));
        }else{
            echo vbean_filterwpvars(get_option('vbean_meta_maid_desktophtmlhead'));
        }
    }

}
add_action('wp_head', '\VanillaBeans\MetaMaid\vbean_wphead', 11);


if (!function_exists('\VanillaBeans\MetaMaid\vbean_b4bodyend')) {

    function vbean_b4bodyend() {
        echo vbean_filterwpvars(get_option('vbean_meta_maid_htmlbeforeclosebody'));
        if(wp_is_mobile()){
            echo vbean_filterwpvars(get_option('vbean_meta_maid_mobilehtmlbeforeclosebody'));
        }else{
            echo vbean_filterwpvars(get_option('vbean_meta_maid_desktophtmlbeforeclosebody'));
        }
    }
}
add_filter('wp_footer', '\VanillaBeans\MetaMaid\vbean_b4bodyend', 11);

if (!function_exists('\VanillaBeans\MetaMaid\vbean_filterwpvars')) {

    function vbean_filterwpvars($s) {
       $pageid= get_the_ID();
       $catid = get_query_var( 'cat' );
       $catname = get_cat_name($catid); 
       $s = str_ireplace("##wpcatid##", $catid, $s);
       $s =str_ireplace("##wpcatname##", $catname, $s);
       $s = str_ireplace("##wppageid##", $pageid, $s);
       return($s);
       }

}