<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
#[AllowDynamicProperties]
class VABFWC_Forms_Protect {
	public $text;
	function __construct( $text ) {
		$this->text = !empty($text) ? sanitize_text_field( $text ) : '';
	}
	function CheckFields() {
		$i								=	$this->text;
		$CheckFieldsEror	=	false;
		if ( !empty($_POST['for_dop_name_'.$i]) || ( empty($_POST['for_dop_maile_'.$i]) ||
					empty($_POST['for_dop_theme_'.$i]) ) ||	trim($_POST['for_dop_maile_'.$i])	!==	'7'	||
					trim($_POST['for_dop_theme_'.$i])	!==	'7'	||	(	trim($_POST['for_dop_maile_'.$i])	!==	trim($_POST['for_dop_theme_'.$i])	)	||
				 !empty($_POST['send_for_dop_'.$i]) ) {
			return $CheckFieldsEror = true;
		}
		$nonces						=	vabfwc_sanitize_data_types($_POST['VABFWC_contact_nonce_' . $i]);
		/* $nonces						=	filter_input(	INPUT_POST,	'VABFWC_contact_nonce_' . $i, FILTER_SANITIZE_STRING	); */
		if	(	!$nonces	||	!wp_verify_nonce($nonces, 'VABFWC_mode_contact_nonce_' . $i ) ) {
			return $CheckFieldsEror	=	true;
		}
	}
	function FieldS()	{
		return wp_nonce_field('VABFWC_mode_contact_nonce_' . esc_attr($this->text), 'VABFWC_contact_nonce_' . esc_attr($this->text), true, false) .
						'<input name="for_dop_name_' . esc_attr($this->text) . '" onfocus="' . esc_js( 'getVABFWC(this)' ) . '" onchange="' . esc_js( 'getVABFWC(this)' ) . '" type="text" class="formInput"/>' .
						'<input name="for_dop_maile_' . esc_attr($this->text) . '" type="text" class="formInput" value="7"/>' .
						'<input name="for_dop_theme_' . esc_attr($this->text) . '" type="text" class="formInput" value="7"/>' .
						'<input class="vabfwc_veri formInput" name="send_for_dop_' . esc_attr($this->text) . '" type="checkbox" checked="checked"/>';
	}
}