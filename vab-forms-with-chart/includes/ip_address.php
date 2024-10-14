<?php
$VABFWC_IP 	 = '';
$client 		 = sanitize_text_field( @$_SERVER['HTTP_CLIENT_IP'] );
$forward 		 = sanitize_text_field( @$_SERVER['HTTP_X_FORWARDED_FOR'] );
$remote 		 = sanitize_text_field( @$_SERVER['REMOTE_ADDR'] );
if ( filter_var( $client, FILTER_VALIDATE_IP ) ) {
	$VABFWC_IP = $client;
}elseif ( filter_var( $forward, FILTER_VALIDATE_IP ) ) {
	$VABFWC_IP = $forward;
}else {
	$VABFWC_IP = $remote;
}