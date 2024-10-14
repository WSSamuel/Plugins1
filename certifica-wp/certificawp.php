<?php
/*
Plugin Name: Certifica WP
Plugin URI: https://certificawp.com.br/
Description: Plugin para gerar certificados dos seus cursos ou eventos. Acesse https://certificawp.com.br/ e cadastre-se.
Version: 3.1
Author: CertificaWP
Author URI: https://certificawp.com.br/
*/

function CWP_get_certificate($atts)
{

	$defaults = shortcode_atts( array( 'evento' => '' ), $atts );

	if ( ! is_user_logged_in() )
		return 'Você precisa estar logado para obter o certificado.';

	( isset($defaults['evento']) && !empty($defaults['evento']) ) ?
		$event_key = trim( $defaults['evento'] ) :
		$event_key = '';

	if ( empty($event_key) )
		return 'Parece que está faltando configurar o ID do evento.';

	if ( $event_key == 'ID_EVENTO' )
		return 'Substitua "ID_EVENTO" pelo ID correto do seu evento.';

	$userinfo = wp_get_current_user();

	if ( isset($userinfo->user_firstname) && !empty($userinfo->user_firstname) && isset($userinfo->user_lastname) && !empty($userinfo->user_lastname) ) {
		$user_name = $userinfo->user_firstname.' '.$userinfo->user_lastname;
	} elseif ( isset($userinfo->display_name) && !empty($userinfo->display_name) ) {
		$user_name = $userinfo->display_name;
	} else {
		$user_name = $userinfo->user_login;
	}

	$user_email = $userinfo->user_email;

	if ( !isset($user_name) || empty($user_name) || !isset($user_email) || empty($user_email) )
		return 'Você está logado mas não tem um nome/email configurado neste site. Entre em contato com o administrador.';

	$local = array('127.0.0.1','192.56.1.30','teste.com');
	( in_array($_SERVER['HTTP_HOST'], $local) ) ?
		$url_endpoint = 'http://192.56.1.30/certificawp/v2/public/certificates/plugin' :
		$url_endpoint = 'https://certificawp.com.br/certificates/plugin';

	$user_infos = SHA1($user_email.'lucas').'|'.$user_email.'|'.urlencode($user_name);
	$user_infos = base64_encode($user_infos);
	$get_URL = $url_endpoint.'/'.$event_key.'/'.$user_infos;

	( isset($_GET['certificawp']) && !empty($_GET['certificawp']) ) ?
		$redirect = trim( $_GET['certificawp'] ) :
		$redirect = '';

	$return = '';

	if ( !empty($redirect) ) {

		( $redirect == 'success' ) ?
			$alert = 'Parabéns! As instruções para download do seu certificado foram enviadas para o seu e-mail.' :
			$alert = 'Ops! '. urldecode($redirect) .' Entre em contato com o administrador.';

		$return .= '<script>alert("'.$alert.'");</script>';

	}

	$return .= '
		<style>
			.certificawp-btn-get-certificate { background-color: #009AAE; color: white !important; text-decoration: none; padding: 15px 20px; border-radius: 5px; -moz-border-radius: 5px; box-shadow: none !important; }
			.certificawp-btn-get-certificate:hover,
			.certificawp-btn-get-certificate:active,
			.certificawp-btn-get-certificate:focus { background-color: rgb(0,141,158) !important; color: white !important; text-decoration: none; padding: 15px 20px; border-radius: 5px; -moz-border-radius: 5px; box-shadow: none !important; }
		</style>
		<div style="padding-top: 20px;padding-bottom: 20px;">
			<a href="'.$get_URL.'" target="_self" class="certificawp-btn-get-certificate">Obter Certificado</a>
		</div>';

	return $return;
}
add_shortcode('certificawp','CWP_get_certificate');
?>