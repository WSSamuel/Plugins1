<?php
add_action(
	'wp_enqueue_scripts',
	function() {
		wp_enqueue_script(
			'vabfwc-scripts',
			VABFWC_PLUGIN_URL . '/includes/js/vabfwc-scripts.js',
			array( 'jquery' ),
			VABFWC_VERSION,
			true
		);
		$VABFWC_SenD = array(
			'VABFWC_p_now_Out'		=> is_singular(),
			'VABFWC_Chu_F_Out'		=> esc_html__( 'Select files', 'VABFWC' ),
			'VABFWC_Chu_Fs_Out'		=> esc_html__( 'Selected files', 'VABFWC' )
		);
			wp_localize_script( 'vabfwc-scripts', 'VABFWC_SenD_In', $VABFWC_SenD );
	},
	10, 0
);
add_action(
	'get_footer',
	function() {
		wp_enqueue_style(
			'vabfwc-styles',
			VABFWC_PLUGIN_URL . '/includes/css/vabfwc-styles.css',
			array(),
			VABFWC_VERSION,
			'all'
		);
	},
	10, 0
);
if ( ! function_exists( 'VAB_add_defer_attribute' ) ) {
	function VAB_add_defer_attribute( $tag, $handle ) {
		$handles = array(
			'vabfwc-scripts',
		);
		foreach( $handles as $defer_script ) {
			if ( $defer_script === $handle ) {
				return str_replace( 'src', 'defer="defer" src', $tag );
			}
		}
		return $tag;
	}
}
add_filter( 'script_loader_tag', 'VAB_add_defer_attribute', 10, 2 );
if ( ! function_exists( 'VAB_add_preload_attribute' ) ) {
	function VAB_add_preload_attribute( $tag, $handle ) {
		$handles = array(
			'vabfwc-styles',
		);
		foreach( $handles as $defer_script ) {
			if( $defer_script === $handle ) {
				return str_replace( 'href', 'rel="preload" as="style" href', $tag );
			}
		}
		return $tag;
	}
}
add_filter( 'style_loader_tag', 'VAB_add_preload_attribute', 10, 2 );
add_action( 'current_screen', 'vabfwc__screen' );
if ( ! function_exists( 'vabfwc__screen' ) ) {
	function vabfwc__screen(){
		$screen = get_current_screen();
		if( 'vab_fwc' === $screen->post_type ){
			add_action( 'admin_enqueue_scripts', 'vabfwc_enqueue_admin_scripts' );
		}
	}
}
if ( ! function_exists( 'vabfwc_enqueue_admin_scripts' ) ) {
	function vabfwc_enqueue_admin_scripts() {
		wp_enqueue_style(
			'vabfwc-admin-styles',
			VABFWC_PLUGIN_URL . '/includes/css/vabfwc-admin-styles.css',
			array(),
			VABFWC_VERSION,
			'all'
		);
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}
}
add_action( 'admin_enqueue_scripts', 'all_vabfwc_enqueue_admin_scripts' );
if ( ! function_exists( 'all_vabfwc_enqueue_admin_scripts' ) ) {
	function all_vabfwc_enqueue_admin_scripts() {
		wp_enqueue_style(
			'all-vabfwc-admin-styles',
			VABFWC_PLUGIN_URL . '/includes/css/all-vabfwc-admin-styles.css',
			array(),
			VABFWC_VERSION,
			'all'
		);
    wp_enqueue_script(
			'vabfwc-add-gutenberg',
			VABFWC_PLUGIN_URL . '/includes/js/admin/vabfwc-add-gutenberg.js',
			array(
				'wp-blocks',
				'wp-i18n',
				'wp-element',
				'wp-components'
			),
			VABFWC_VERSION
		);
    wp_localize_script('vabfwc-add-gutenberg', 'vabfwc_local',
        array(
            'selectformname'		=> esc_html__( 'Form name', 'VABFWC' ),
            'emptyformname'			=> esc_html__( 'is empty', 'VABFWC' ),
            'textforid'					=> esc_html__( 'Specify an ID for the form', 'VABFWC' ),
            'textforclass'			=> esc_html__( 'Specify an class for the form', 'VABFWC' ),
            'selectform'				=> esc_html__( 'Select form', 'VABFWC' ),
            'idtoform'					=> esc_html__( 'Id to a form', 'VABFWC' ),
            'classtoform'				=> esc_html__( 'Сlass to a form', 'VABFWC' ),
            'formtag'						=> esc_html__( 'Choose a tag for the title', 'VABFWC' ),
            'formtitle'					=> esc_html__( 'Title to the chart', 'VABFWC' ),
            'chartsshort'				=> esc_html__( 'Display form charts', 'VABFWC' ),
            'textfortitle'			=> esc_html__( 'Specify an title for the chart', 'VABFWC' ),
            'classtotag'				=> esc_html__( 'Сlass for the tag in title', 'VABFWC' ),
            'textclassfortag'		=> esc_html__( 'Specify an class for the tag', 'VABFWC' ),
        )
    );
	}
}
add_action( 'admin_footer', 'vabfwc_form_from_gutenberg' );
if ( ! function_exists( 'vabfwc_form_from_gutenberg' ) ) {
	function  vabfwc_form_from_gutenberg() {
	$args = array(
			'post_type'      => 'vab_fwc',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
	);
	$query = new WP_Query( $args );
	$number = 0 ;
	$str_add_vabfwc_form = '';
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$str_add_vabfwc_form .='<input id="form' . esc_html( $query->post->ID ) . '" type="hidden" name="nameform" data-id="' . esc_html( $query->post->ID ) . '" checked></input><label for="form' . esc_html( $query->post->ID ) . '"><span>' . esc_html( get_the_title() ) . '</span></label>';
		}
	}
	wp_reset_postdata();
	echo '<div id="vabfwc_name_form">
				' . wp_specialchars_decode( $str_add_vabfwc_form ) . '
			 </div>';
}}
if ( VABFWC_WP_VERSION_CHECK < 580 ) {
	add_filter( 'block_categories', 'vabfwc_block_categories', 10, 2);
} else {
	add_filter( 'block_categories_all', 'vabfwc_block_categories', 10, 2);
}
if ( !function_exists( 'vabfwc_block_categories' ) ) {
	function vabfwc_block_categories( $categories,$post ) {
		return array_merge(
			array(
				array(
					'slug'	=>	'vabfwc_category',
					'title'	=>	esc_html__( 'Forms with chart from VAB', 'VABFWC' ),
					// 'icon'	=>	'wordpress',
				),
			),
			$categories
		);
	}
}
if ( !function_exists( 'add_plugin_vabfwc_link' ) ) {
	function add_plugin_vabfwc_link( $link ) {
		$vabfwc_link	= '<a href="edit.php?post_type=vab_fwc">' . esc_html__( 'Create Form', 'VABFWC' ) . '</a>';
		$link[]				= $vabfwc_link;
		return $link;
	}
}
add_filter( 'plugin_action_links_' . VABFWC_PLUGIN_BASENAME, 'add_plugin_vabfwc_link' );
if ( ! function_exists( 'VABFWC_file_force_download' ) ) {
	function VABFWC_file_force_download( $file ){
		if ( file_exists( $file ) ) {
			if ( ob_get_level() ) {
				ob_end_clean();
			}
			header( 'Content-Description:File Transfer' );
			header( 'Content-Type:application/octet-stream' );
			header( 'Content-Disposition:attachment;filename=' . basename( $file ) );
			header( 'Content-Transfer-Encoding:binary' );
			header( 'Expires:0' );
			header( 'Cache-Control:must-revalidate' );
			header( 'Pragma:public' );
			header( 'Content-Length:' . filesize( $file ) );
			if ( $fd = fopen( $file, 'rb' ) ) {
				while( ! feof( $fd ) ) {
					print fread( $fd, 1024 );
				}
			fclose( $fd );
			}
			exit;
		}
	}
}
add_action( 'send_headers', 'VABFWC_download_file' );
if	(	!	function_exists( 'VABFWC_download_file' ) ) {
	function VABFWC_download_file() {
		$SRC = VABFWC_UPLOAD_DIR . '/VABFWC/' . sanitize_title( stristr( VABFWCGSU, '://' ) ) . '/Diagram/';
		if ( isset($_GET['id']) &&
				 isset($_GET['my_file']) &&
				 isset($_GET['my_type']) &&
				 ( $_GET['my_type'] == 'adm_logs' || $_GET['my_type'] == 'csv_logs' ) &&
				 isset($_GET['hash']) ) {
					$getFileProtect	= 'HNUv6Q8YO4u8hTfhs6e5';
					$id							= sanitize_text_field( $_GET['id'] );
					$my_file				= sanitize_text_field( $_GET['my_file'] );
					$my_type				= sanitize_text_field( $_GET['my_type'] );
					$hash						= sanitize_text_field( $_GET['hash'] );
					$ouCh 					= hash( 'sha1', $id . '&' . $my_file . '&' . $my_type . '&' . $getFileProtect );
					if ( $hash === $ouCh ) {
						$add_url 			= $my_type == 'csv_logs' ? '/csv_logs/' : '/';
						$end_url 			= $my_type == 'csv_logs' ? '.csv' : '.txt';
						$UPFile				=	$SRC . $id .  $add_url . $my_file . $end_url;
						if ( file_exists( $UPFile ) ) {
							VABFWC_file_force_download( $UPFile );
						}
					}
		}
	}
}