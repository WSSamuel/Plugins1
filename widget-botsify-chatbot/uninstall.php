<?php

/**
  * Trigger this file on Plugin uninstall
  * 
  * @package BotsifyChatbotWidget
  */


if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;

}

delete_option( 'botsify_chatbot_api_key' );
