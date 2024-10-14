<?php
/**
 * Additional filtering of form fields and Users
 */
if ( ! function_exists( 'VABFWC_CHEK_ROLES' ) ) {
	function VABFWC_CHEK_ROLES( $post_id ) {
		global								$wp_roles;
		$VABFWC_ROLES				= $wp_roles->get_names();
		$VABFWC_FORMSA_OPT	= get_post_meta( $post_id, 'VABFWC_FORM_OPT', true );
		foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ) {
			if ( is_user_logged_in() ) {
					$user_id	=	get_current_user_id();
					$u_meta		=	get_userdata( $user_id );
					if ( ! empty( $u_meta ) ) {
						$u_roles	=	$u_meta->roles;
						if ( in_array( $VABFWC_ROLE, $u_roles, true ) && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE] ) ) {
							return true;
						}}
			}
		}
		return false;
}}
if ( ! function_exists( 'VABFWC_CHEK_CSV_ROLES' ) ) {
	function VABFWC_CHEK_CSV_ROLES( $post_id ) {
		global								$wp_roles;
		$VABFWC_ROLES				= $wp_roles->get_names();
		$VABFWC_FORMSA_OPT	= get_post_meta( $post_id, 'VABFWC_FORM_OPT', true );
		foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ) {
			if ( is_user_logged_in() ) {
					$user_id	=	get_current_user_id();
					$u_meta		=	get_userdata( $user_id );
					if ( ! empty( $u_meta ) ) {
						$u_roles	=	$u_meta->roles;
						if ( in_array( $VABFWC_ROLE, $u_roles, true ) && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE] ) ) {
							return true;
						}}
			}
		}
		return false;
}}
if ( ! function_exists( 'VABFWC_CHEK_OPT_ROLES' ) ) {
	function VABFWC_CHEK_OPT_ROLES( $post_id ) {
		global								$wp_roles;
		$VABFWC_ROLES				= $wp_roles->get_names();
		$VABFWC_FORMSA_OPT	= get_post_meta( $post_id, 'VABFWC_FORM_OPT', true );
		foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ) {
			if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE] ) ) {
				return true;
			}
		}
		return false;
}}
if ( ! function_exists( 'VABFWC_CHEK_CSV_OPT_ROLES' ) ) {
	function VABFWC_CHEK_CSV_OPT_ROLES( $post_id ) {
		global								$wp_roles;
		$VABFWC_ROLES				= $wp_roles->get_names();
		$VABFWC_FORMSA_OPT	= get_post_meta( $post_id, 'VABFWC_FORM_OPT', true );
		foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ) {
			if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE] ) ) {
				return true;
			}
		}
		return false;
}}
if ( ! function_exists( 'vabfwc_sanitize_text_field' ) ) {
	function vabfwc_sanitize_text_field( $array ) {
		foreach ( $array as $key => $value ) {
			if ( is_array( $value ) ) {
				$value = vabfwc_sanitize_text_field( $value );
			}
			else {
				$value = sanitize_text_field( $value );
			}
		}
		return $array;
	}
}
if ( ! function_exists( 'VABFWC_is_tel' ) ) {
	function VABFWC_is_tel( $tel ) {
		$pattern = '%^[+]?'
			.'(?:\([0-9]+\)|[0-9]+)'
			.'(?:[/ -]*'
			.'(?:\([0-9]+\)|[0-9]+)'
			.')*$%';
		$result = preg_match( $pattern, trim( $tel ) );
		return apply_filters( 'VABFWC_is_tel', $result, $tel );
	}
}
if ( ! function_exists( 'VABFWC_is_email' ) ) {
	function VABFWC_is_email( $email ) {
		$result = is_email( $email );
		return apply_filters( 'VABFWC_is_email', $result, $email );
	}
}
if ( ! function_exists( 'VABFWC_is_date' ) ) {
	function VABFWC_is_date( $date ) {
		$result = preg_match( '/^([0-9]{4,})-([0-9]{2})-([0-9]{2})$/', $date, $matches );
		if ( $result ) {
			$result = checkdate( $matches[2], $matches[3], $matches[1] );
		}
		return apply_filters( 'VABFWC_is_date', $result, $date );
	}}
if ( ! function_exists( 'VABFWC_is_number' ) ) {
	function VABFWC_is_number( $number ) {
		$result = is_numeric( $number );
		return apply_filters( 'VABFWC_is_number', $result, $number );
	}
}
if ( ! function_exists( 'VABFWC_is_url' ) ) {
	function VABFWC_is_url( $url ) {
		$result = ( false !== filter_var( $url, FILTER_VALIDATE_URL ) );
		return apply_filters( 'VABFWC_is_url', $result,$url );
	}}
if ( ! function_exists( 'VABFWC_Chek_url' ) ) {
	function VABFWC_Chek_url( $url ) {
		return preg_match_all( '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $url, $match );
	}
}
if ( ! function_exists( 'VABFWC_Only_url' ) ) {
	function VABFWC_Only_url( $url ) {
		return preg_match( '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url );
	}
}
if ( ! function_exists( 'vabfwc_sanitize_string' ) ) {
	function vabfwc_sanitize_string( $string ) {
		// Replace HTML tags and entities with their plain text equivalents
		$string = htmlspecialchars_decode( $string, ENT_QUOTES );
		// Remove any remaining HTML tags
		$string = strip_tags( $string );
		return $string;
	}
}
if ( ! function_exists( 'vabfwc_sanitize_data_types' ) ) {
	/**
	 * Sanitizes a value according to its type.
	 *
	 * The function will recursively sanitize array values.
	 *
	 */
	function vabfwc_sanitize_data_types( &$value ) {
		if ( is_bool( $value ) ) {
			return $value;
		}
		if ( is_string( $value ) ) {
			$value = vabfwc_sanitize_string( $value );
			return $value;
		}
		if ( is_int( $value ) ) {
			$value = filter_var( $value, FILTER_VALIDATE_INT );
			return $value;
		}
		if ( is_float( $value ) ) {
			$value = filter_var( $value, FILTER_VALIDATE_FLOAT );
			return $value;
		}
		if ( is_array( $value ) ) {
			array_walk( $value, 'vabfwc_sanitize_data_types' );
			return $value;
		}

		return null;
	}
}