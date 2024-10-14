<?php
/*
Plugin Name: Eventbee Ticketing Widget
Plugin URI: https://wordpress.org/plugins/eventbee-ticketing-widget
Description: Eventbee Ticket Widget plugin is a great solution for Event Managers who wish to sell their tickets having Ticket Widget on their WordPress sites. Usage [eventbeeticketwidget frameid="1" eid="???" width=""]
Author: Eventbee Dev Team
Version: 1.0
Author URI: http://www.eventbee.com/
*/


  
function eventbeewidget_func( $atts ) {
   $a = shortcode_atts( array(
       'frameid' => '1',
       'eid' => '',
	   'width' => '700'), $atts );
	$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
	/* 
		$jsurl=$protocol.'://www.eventbee.com/home/js/widget/eventregistration.js'; 
		$iframeurl=$protocol."://www.eventbee.com/eregister?eid=".$a['eid']."&viewType=iframe;resizeIFrame=true&context=web";
	*/
	$iframeurl=$protocol."://www.eventbee.com/home/js/widget/frameHelper.js";
	$content="<div id='eventbee_iframe' frame-eventId='".$a['eid']."' frame-domain='".$protocol."://www.eventbee.com' frame-width='".$a['width']."'
			   frame-border='0px solid gray'>
			   <script type='text/javascript' language='JavaScript' src='".$iframeurl."'> </script></div>";
	
	/* $content="<script type='text/javascript' language='JavaScript' src='".$jsurl."'></script>
							<iframe id='_EbeeIFrame_ticketwidget_".$a['frameid']."'
										name='_EbeeIFrame_ticketwidget_".$a['frameid']."'
										src='".$iframeurl."'
										height='0' width='".$a['width']."'></iframe>";
	*/
   return $content;
}
add_shortcode( 'eventbeeticketwidget', 'eventbeewidget_func' );
?>