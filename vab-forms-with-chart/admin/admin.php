<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*register a new post type*/
add_action( 'init', 'VABFWC' );
if ( ! function_exists( 'VABFWC' ) ) {
	function VABFWC() {
		register_post_type( 'vab_fwc', array(
			'labels'							=>	array(
				'name'							=>	esc_html__( 'Forms with Charts', 'VABFWC' ),
				'singular_name'			=>	esc_html__( 'Forms', 'VABFWC' ),
				'add_new'						=>	esc_html__( 'Create Form', 'VABFWC' ),
				'add_new_item'			=>	esc_html__( 'Create Form', 'VABFWC' ),
				'edit'							=>	esc_html__( 'Edit Form', 'VABFWC' ),
				'edit_item'					=>	esc_html__( 'Edit Form', 'VABFWC' ),
				'new_item'					=>	esc_html__( 'New Form', 'VABFWC' ),
				'view'							=>	esc_html__( 'Look', 'VABFWC' ),
				'view_item'					=>	esc_html__( 'Look Form', 'VABFWC' ),
				'search_items'			=>	esc_html__( 'Search a form', 'VABFWC' ),
				'not_found'					=>	esc_html__( 'Not found', 'VABFWC' ),
			),
			'public'							=>	false,
			'show_ui'							=>	true,
			'query_var'						=>	false,
			'publicly_queryable'	=>	false,
			'show_in_rest'				=>	false,
			'menu_icon'						=>	'dashicons-chart-pie',
			'supports'						=>	array( 'title', ),
			'has_archive'					=>	false,
			'capability_type'			=>	'post',
			'rewrite'							=>	array(
																	'slug' =>	'vab_fwc'
																),
		) );
	}
}
/*add a meta box for basic form settings and create a list of questions*/
add_action( 'add_meta_boxes', 'vabfwc_contact_forms_meta_box' );
if ( ! function_exists( 'vabfwc_contact_forms_meta_box' ) ) {
	function vabfwc_contact_forms_meta_box() {
		$screens = array( 'vab_fwc' );
		add_meta_box(
			'vabfwc_contact_forms_meta',
			esc_html__( 'Copy the shortcode below and paste it into your posts, pages or text widget content', 'VABFWC' ) . ':',
			'vabfwc_contact_forms_meta_box_callback',
			$screens,
			'normal',
			'low'
		);
	}
}
/*A function that displays the contents of the meta block of basic options  the form on the HTML screen.*/
if ( ! function_exists( 'vabfwc_contact_forms_meta_box_callback' ) ) {
	function vabfwc_contact_forms_meta_box_callback( $post,$meta ) {
		wp_nonce_field( 'VABFWC_mode_FORMS_nonce', 'VABFWC_FORMS_nonce' );
		$id 								= intval( $post->ID );
		$VABFWC_FORMSA			= get_post_meta( $id, 'VABFWC_FORM', true );
		$VABFWC_FORMSA_OPT 	= get_post_meta( $id, 'VABFWC_FORM_OPT', true );
		$Button_del 				= '<img style="margin-bottom:-7px!important;" class="VABFWC_remove_Volna_Soc" src="' . esc_url( VABFWC_PLUGIN_URL . '/images/delete.png' ) . '" width="auto" height="33">';
		$Button_del_PP			= '<img style="margin-bottom:-7px!important;" class="remove_Parent_Parent" src="' . esc_url( VABFWC_PLUGIN_URL . '/images/delete.png' ) . '" width="auto" height="33">';
		$Button_del_arg			= 	array( /* wp_kses */
				'img'						=>	array(
					'style'				=>	array(),
					'class'				=>	array(),
					'src'					=>	array(),
					'width'				=>	array(),
					'height'			=>	array(),
				),
			);
	$this_value = 'jQuery( this ).prev().val( this.value )';
?>
	<script async="async" type="text/javascript">
	jQuery( document ).ready( function( $ ) {
		function VALTEXTARREA() {
			$( '.VALTEXTARREA' ).on( "keyup", function() {
				if ( ( $( this ).val().match( /[^0-9a-zA-Z-_]/g ) || [] ).length>0 ) {
					alert( '<?php esc_html_e( 'Russian alphabet, some characters and spaces are prohibited!', 'VABFWC' );?>' );
					$( this ).val( $( this ).val().slice( 0, 0 ) );
				}
			});
		}
		VALTEXTARREA();
		$( '#Otpravnoy_Punkt_Diagramm #VABFWC_add_Diagramm' ).click( function() {
			var typeDiagramm=$( this ).prev( '#typeDiagramm' ).val();
			if ( typeDiagramm !== 'none' ) {
				var VABFWC_Clon = document.createElement( 'div' );
				VABFWC_Clon.className = "VABFWC_Diagramm";
				var keyq = prompt( "<?php esc_html_e( 'Specify ID for the question. Use only the Latin alphabet', 'VABFWC' );?>" + ":", "");
				if ( keyq == null || keyq == '' || keyq == ' ' || keyq.match( /[^0-9a-zA-Z-_]/g ) || [].length>0 ){
					alert( '<?php esc_html_e( 'Russian alphabet, some characters and spaces are prohibited!', 'VABFWC' );?>' );
					return;
				}
				var	first = ''
									+ '<textarea cols="11" rows="1" placeholder="<?php esc_html_e( 'Specify ID', 'VABFWC' ); ?>" class="VALTEXTARREA" name="<?php echo $id; ?>[' + keyq + ']" value="' + keyq + '"required>' + keyq + '</textarea>'
									+ '<textarea cols="44" rows="1" placeholder="<?php esc_html_e( 'Formulate your question', 'VABFWC' );?>" name="<?php echo $id; ?>['+keyq+'][question]" value=""required></textarea>'
									+ '<input type="hidden" size="7" name="<?php echo $id; ?>[' + keyq + '][type]" value="' + typeDiagramm + '"required readonly/><?php echo wp_kses( $Button_del, $Button_del_arg ); ?>' + typeDiagramm,
						RanGes = ''
									+ '<table>'
										+ '<tbody>'
											+ '<tr>'
												+ '<td>'
													+ '<input type="text" size="25" name="<?php echo $id; ?>[' + keyq + '][min]" placeholder="<?php esc_html_e( 'Minimum value', 'VABFWC' );?>"required />'
												+ '</td>'
												+ '<td>'
													+ '<input type="text" size="25" name="<?php echo $id; ?>[' + keyq + '][max]" placeholder="<?php esc_html_e( 'Maximum value', 'VABFWC' );?>"required />'
												+ '</td>'
											+ '</tr>'
											+ '<tr>'
												+ '<td>'
													+ '<input type="text" size="25" name="<?php echo $id; ?>[' + keyq + '][step]" placeholder="<?php esc_html_e( 'Specify step', 'VABFWC' );?>"required />'
												+ '</td>'
											+ '</tr>'
										+ '</tbody>'
									+ '</table>',
						answer = ''
									+ '<textarea cols="44" rows="1" placeholder="<?php esc_html_e( 'Specify option answer', 'VABFWC' ); ?>" name="<?php echo $id; ?>[' + keyq + '][answer][]" value=""required></textarea>',
						coLors = ''
									+ '<input class="vabfwcColorChoose" type="text" size="11" placeholder="<?php esc_html_e('Pick a color on the chart', 'VABFWC' ); ?>" name="<?php echo $id; ?>[' + keyq + '][color][]" value=""required/>'
									//+ '<input type="color" name="ColorChoose" class="ColorChoose" onchange="<?php echo esc_js( $this_value ); ?>" />'
									+'',
						tR = ''
									+ '<tr><td>' + answer + '</td><td>' + coLors + '</td><td><?php echo wp_kses( $Button_del_PP, $Button_del_arg );?></td></tr>',
						add_answer = ''
									+ '<input type="button" class="add_answer_option" name="add_answer_option" value="<?php esc_html_e( 'Add an answer option', 'VABFWC' ); ?>" />',
						taBle = ''
									+ '<table id="tableDiagramm" class="tableDiagramm">'
										+ '<tbody>'
											+ '<tr><th><?php esc_html_e( 'Answer options', 'VABFWC' ); ?></th><th><?php esc_html_e( 'Color on chart', 'VABFWC' ); ?></th></tr>'
											+ tR + tR
											+ '<tr><th colspan="3">' + add_answer + '</th></tr>'
										+ '</tbody>'
									+ '</table>';
				if ( typeDiagramm == 'text' || typeDiagramm == 'url' || typeDiagramm == 'tel' ||
						 typeDiagramm == 'email' || typeDiagramm == 'date' || typeDiagramm == 'textarea' ) {
						VABFWC_Clon.innerHTML = first;
				}
				if( typeDiagramm == 'number' || typeDiagramm == 'range' ) {
						VABFWC_Clon.innerHTML = first + '<br /><br />' + RanGes + '<br /><br />';
				}
				if ( typeDiagramm == 'radio' ) {
					VABFWC_Clon.innerHTML = first + '<br /><br />' + taBle + '<br /><?php esc_html_e( 'Add «Other» textbox to the end?', 'VABFWC' ); ?><select id="plusArea" name="<?php echo $id; ?>[' + keyq + '][plusArea]"><option name="plusArea" value="none"><?php esc_html_e( 'Do not add', 'VABFWC' ); ?></option><option name="plusArea" value="yes"><?php esc_html_e( 'Add', 'VABFWC' ); ?></option></select>';
				}
				if ( typeDiagramm == 'checkbox' || typeDiagramm == 'select' ) {
					VABFWC_Clon.innerHTML = first + '<br /><br />' + taBle + '<br />';
				}
				Priemniy_Punkt_Diagramm.insertBefore( VABFWC_Clon, Priemniy_Punkt_Diagramm.children['last'] );
				VALTEXTARREA();
			}else{
				alert( '<?php _e( "No type selected", "VABFWC" ); ?>' );
			}
			$('.vabfwcColorChoose').wpColorPicker();
		} );
			$( document ).on( 'click', '.add_answer_option', function() {
				var paRr = $( this ).parent().parent().parent().parent().parent().find( 'textarea:first' ).attr( 'value' );
				jQuery( this ).parent().parent().before( ''
					+ '<tr>'
						+ '<td>'
							+ '<textarea cols="44" rows="1" placeholder="<?php esc_html_e( 'Specify option answer', 'VABFWC' ); ?>" name="<?php echo $id; ?>[' + paRr + '][answer][]" value=""required></textarea>'
						+ '</td>'
						+ '<td>'
							+ '<input class="vabfwcColorChoose" type="text" size="11" placeholder="<?php esc_html_e( 'Pick a color on the chart', 'VABFWC' ); ?>" name="<?php echo $id; ?>[' + paRr + '][color][]" value=""required/>'
							//+ '<input type="color" name="ColorChoose" class="ColorChoose" onchange="<?php echo esc_js( $this_value ); ?>" />'
						+ '</td>'
						+ '<td><?php echo wp_kses( $Button_del_PP, $Button_del_arg ); ?>'
						+ '</td>'
					+ '</tr>'
				);
				$('.vabfwcColorChoose').wpColorPicker();
			} );
			$( document ).on( 'click', '.VABFWC_remove_Volna_Soc', function() {
				$( this ).parent().remove();
			} );
			$( document ).on( 'click', '.remove_Parent_Parent', function() {
				$( this ).parent().parent().remove();
			} );
			$( document ).on( 'click', '.vabfwc_spoiler-head', function() {
				jQuery( this ).next().slideToggle( 400 );
			} );
		$( document ).on( 'click', '.VABFWC_ShortCode', function() {
			var w = window.getSelection(),range = document.createRange(), rStr;
			range.selectNode( this );
			w.addRange( range );
			rStr = range.toString();
			document.addEventListener( 'copy', function( e ) {
				e.clipboardData.setData( 'text/plain', rStr );
				e.preventDefault();
			} );
				document.execCommand( "copy" );
				alert( "<?php esc_html_e( 'Shortcode copied to clipboard', 'VABFWC' ); ?>");
		});
		$( document ).on( 'click', '.vabfwc_up', function() {
        var vabfwc_p_div = $( this ).parent( 'div' );
        vabfwc_p_div.insertBefore( vabfwc_p_div.prev() );
        return false;
    });
		$( document ).on( 'click', '.vabfwc_down', function() {
        var vabfwc_p_div = $( this ).parent( 'div' );
        vabfwc_p_div.insertAfter( vabfwc_p_div.next() );
        return false;
    });
		$('.wpColorChoose').wpColorPicker();
		function tableClick( el ) {
			$( document ).on( 'click', '.th_' + el, function() {
				jQuery( this ).toggleClass( 'OpEn' );
				jQuery( '.' + el ).fadeToggle( 500 );
			});
		}
		tableClick('log_files');
		tableClick('seet_diag');
		tableClick('seet_attach');
		tableClick('seet_mess');
	});</script>
	<?php
	$ButMas = array(
		esc_html__( 'Saved List:', 'VABFWC' ),
		esc_html__( 'List preparation block:', 'VABFWC' )
	);
	echo '<span class="VABFWC_ShortCode">[VABFWC id="' . $id . '"]</span>';
	$typeText = array(
		"text"							=>	esc_html__( 'Text', 'VABFWC' ),
		"url"								=>	esc_html__( 'Link', 'VABFWC' ),
		"tel"								=>	esc_html__( 'Phone', 'VABFWC' ),
		"email"							=>	esc_html__( 'Email', 'VABFWC' ),
		"date"							=>	esc_html__( 'Date', 'VABFWC' ),
		"number"						=>	esc_html__( 'Number', 'VABFWC' ),
		"range"							=>	esc_html__( 'Range', 'VABFWC' ),
		"radio"							=>	esc_html__( 'Radio buttons', 'VABFWC' ),
		"checkbox"					=>	esc_html__( 'Checkboxes', 'VABFWC' ),
		"select"						=>	esc_html__( 'Drop-down list', 'VABFWC' ),
		"textarea"					=>	esc_html__( 'Text area', 'VABFWC' ),
	);
if ( ! empty( $VABFWC_FORMSA ) ) {
	$VABFWC_FORMSA = $VABFWC_FORMSA[ $id ];
	echo	'<div class="accordion">
					<fieldset style="border:1px solid #FFF;margin:4px;padding:4px;">
						<legend align="center">
							<h2>' . $ButMas[ 0 ] . '</h2>
						</legend>';
		$iB = 1;
	foreach( $VABFWC_FORMSA as $k => $v ) {
		echo	'<div>';
		// if ( empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS']) ) {
			echo	'<span class="vabfwc_moving vabfwc_up" title="' . esc_html__( 'Up', 'VABFWC' ) . '">' . esc_html__( 'Up', 'VABFWC' ) . '</span>',
						'<span class="vabfwc_moving vabfwc_down" title="' . esc_html__( 'Down', 'VABFWC' ) . '">' . esc_html__( 'Down', 'VABFWC' ) . '</span>';
		// }
		$type = $v['type'];
		$type = $typeText["$type"];
		echo	'<div class="vabfwc_spoiler-head folded" style="text-align:center;cursor:pointer;background:#282828!important;color:#FFF;padding:7px;">' . esc_html( $iB ) . ' - ' . esc_html__( 'Collapse/Expand block', 'VABFWC' ) . '</div>
					<div class="vabfwc_spoiler-body" style="display:none;border:4px double rgba(125,125,125,.75);">';
		echo	'<textarea cols="11" rows="1" placeholder="' . esc_html__( 'Specify an identifier', 'VABFWC' ) . '" class="VALTEXTARREA" name="' . $id . '[' . $k . ']" value="' . esc_html( $k ) . '" required="">' . esc_html( $k ) . '</textarea>
					<textarea cols="44" rows="1" placeholder="' . esc_html__( 'Formulate your question', 'VABFWC' ) . '" name="' . $id . '[' . $k . '][question]" value="" required="">' . esc_html( $v['question'] ) . '</textarea>
					<input type="hidden" size="7" name="' . $id . '[' . $k . '][type]" value="' . esc_html( $v['type'] ) . '" required="" readonly="">' . wp_kses( $Button_del, $Button_del_arg ) . ' - ' . esc_html( $type );
		if ( $v['type'] == 'number' || $v['type'] == 'range' ) {
			echo	'<br /><br />',
							'<table>',
								'<tbody>',
									'<tr>',
										'<td>',
											'<input type="text" size="25" name="' .$id.'['.$k.'][min]" value="'.$v['min'].'" placeholder="' . esc_html__( 'Minimum value', 'VABFWC' ) . '" required />',
										'</td>',
										'<td>',
											'<input type="text" size="25" name="'.$id.'['.$k.'][max]" value="'.$v['max'].'" placeholder="' . esc_html__( 'Maximum value', 'VABFWC' ) . '" required />',
											'<input type="text" size="25" name="'.$id.'['.$k.'][step]" value="'.$v['step'].'" placeholder="' . esc_html__( 'Specify step', 'VABFWC') . '" required />',
										'</td>',
									'</tr>',
								'</tbody>',
							'</table>',
						'<br /><br />';
		}
			if ( $v['type'] == 'radio' || $v['type'] == 'checkbox' || $v['type'] == 'select' ) {
				$coanswer = count( $v['answer'] );
			echo	'<table id="tableDiagramm" class="tableDiagramm" cellspacing="4" cellpadding="4" border="1" style="border:4px double rgba(125,125,0,.25);">
							<tbody>
								<tr>
									<th>' . esc_html__( 'Answer options', 'VABFWC' ) . '</th>
									<th>' . esc_html__( 'Color on chart', 'VABFWC' ) . '</th>
								</tr>';
			for( $i = 0; $i < $coanswer; $i++ ) {
			echo	'<tr>
							<td>
								<textarea cols="33" rows="1" placeholder="' . esc_html__( 'Specify option answer', 'VABFWC' ) . '" name="' . $id . '[' . $k . '][answer][]" value="" required="">' . esc_html( $v['answer'][$i] ) . '</textarea>
							</td>
							<td>
								<input type="text" size="11" placeholder="' . esc_html__( 'Pick a color on the chart', 'VABFWC' ) . '" class="wpColorChoose" name="' . $id . '[' . $k . '][color][]" value="' . esc_html( $v['color'][$i] ) . '" required="">
							</td>
							<td>' .
								wp_kses( $Button_del_PP, $Button_del_arg ) .
							'</td>
						</tr>';
			}
			echo	'<tr>
							<th colspan="3">
								<input type="button" class="add_answer_option" name="add_answer_option" value="' . esc_html__( 'Add an answer option', 'VABFWC' ) . '" />
							</th>
						</tr>';
			if ( $v['type'] == 'radio' ) {
				$chtext = $v['plusArea'] == 'yes' ? esc_html__( 'Add', 'VABFWC' ) : esc_html__( 'Do not add', 'VABFWC' );
				$chekyes = $v['plusArea'] == 'yes' ? 'selected="selected"' : '';
				$cheknone = $v['plusArea'] == 'none' ? 'selected="selected"' : '';
				echo	'<br /><br />' . esc_html__( 'Add «Other» textbox to the end?', 'VABFWC' ) . '
								<select id="plusArea" name="' . $id . '[' . $k . '][plusArea]">
									<option name="' . $id . '[' . $k . '][plusArea]">' . $chtext . '</option>
									<option name="' . $id . '[' . $k . '][plusArea]" ' . esc_attr ( $cheknone ) . ' value="none">' . esc_html__( 'Do not add', 'VABFWC' ) . '</option>
									<option name="' . $id . '[' . $k . '][plusArea]" ' . esc_attr ( $chekyes ) . ' value="yes">' . esc_html__( 'Add', 'VABFWC' ) . '</option>
								</select>
							<br />';
			}
			echo '</tbody></table>';
		} echo	"</div><br>";
		echo	"</div>";
		$iB++;
	}
	echo		'</fieldset></div>';
}
	$typeOpt = '';
	foreach( $typeText as $k => $v ) {
		$typeOpt .= '<option name="option_Diagramm" value="' . $k . '">' . esc_html( $v ) . '</option>';
	}
	echo	'<legend align="center">
					<h2>' . $ButMas[1] . '.</h2>
				</legend>
				<div id="Priemniy_Punkt_Diagramm"></div>
				<div id="Otpravnoy_Punkt_Diagramm">
					<select id="typeDiagramm" name="typeDiagramm">
						<option name="option_Diagramm" value="none">' . esc_html__( 'Choose type', 'VABFWC' ) . '</option>
						' . $typeOpt . '
					</select><input type="button" id="VABFWC_add_Diagramm" name="VABFWC_add_Diagramm" value="' . esc_html__( 'Add Question', 'VABFWC' ) . '" />
				</div>';
}}
/*add a metabox for additional options*/
add_action( 'add_meta_boxes', 'vabfwc_contact_forms_options_meta_box' );
if ( ! function_exists( 'vabfwc_contact_forms_options_meta_box' ) ) {
	function vabfwc_contact_forms_options_meta_box() {
		$screens = array( 'vab_fwc' );
		add_meta_box(
			'vabfwc_contact_forms_options_meta',
			esc_html__( 'Additional options', 'VABFWC' ) . ':',
			'vabfwc_contact_forms_options_meta_box_callback',
			$screens,
			'side',
			'high'
		);
}}
/*A function that displays the contents of the meta block of additional options on the HTML screen.*/
if ( ! function_exists( 'vabfwc_contact_forms_options_meta_box_callback' ) ) {
	function vabfwc_contact_forms_options_meta_box_callback( $post, $meta ) {
		wp_nonce_field( 'VABFWC_mode_FORMS_opt_nonce', 'VABFWC_FORMS_opt_nonce' );
		global $wp_roles;
		$id									= $post->ID;
		$VABFWC_ROLES				= $wp_roles->get_names();
		$VABFWC_FORMSA_OPT 	= get_post_meta( $id, 'VABFWC_FORM_OPT', true );
			$VABFWC_FORMSA_OPT_NoDi 						= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDi'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_CSV_LOGS 				= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) ? 'checked="checked"' : '';
			foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ){
				${'VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE} = $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE] ) ? 'checked="checked"' : '';
			}
			$VABFWC_FORMSA_OPT_NoDate 					= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDate'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_NoIP 						= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoIP'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_NoAgent 					= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoAgent'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_PROT 						= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_PROT'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_HideDi 					= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_HideDi'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_ShowDi 					= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_ShowDi'] ) ? 'checked="checked"' : '';
			foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ){
				${'VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE} = $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE] ) ? 'checked="checked"' : '';
			}
			$VABFWC_FORMSA_OPT_TotaL 						= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_TotaL'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_TotaL_Every_circ = $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_TotaL_Every_circ'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans 	= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_TotaL_Every_ceck = $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_TotaL_Every_ceck'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_AddFile 					= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_AddFile'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_AddFileMulti			= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_AddFileMulti'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_SIZE 						= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_SIZE'] ) ? $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_SIZE'] : '3';
			$VABFWC_FORMSA_OPT_EXT 							= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_EXT'] ) ? $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_EXT'] : '';
			$VABFWC_FORMSA_OPT_TITLE_MAIL 			= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_TITLE_MAIL'] ) ? $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_TITLE_MAIL'] : '';
			$VABFWC_FORMSA_OPT_MAIL_Copy 				= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_MAIL_Copy'] ) ? 'checked="checked"' : '';
			$VABFWC_FORMSA_OPT_MAIL 						= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_MAIL'] ) ? $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_MAIL'] : '';
			$VABFWC_USER_SEND_MAIL							= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_USER_SEND_MAIL'] ) ? 'checked="checked"' : '';
			$VABFWC_NO_SEND_MAIL								= $VABFWC_FORMSA_OPT && ! empty( $VABFWC_FORMSA_OPT['VABFWC_NO_SEND_MAIL'] ) ? 'checked="checked"' : '';
			echo '<style type="text/css">
							.meta_forms label{
								display:flex;
								width:100%;
								padding:7px 0px 7px 0px;
							}
							.meta_forms label .ch{
								width:100%;
							}
							.meta_forms label .text{
								width:auto;
							}
							.meta_forms label input[type="number"]{
								width:33%;
							}
							.meta_forms label input[type="text"]{
								width:100%;
							}
						</style>
						<table class="meta_forms vabfwc_table" style="font-size:10px;">
							<tbody>
								<tr class="th_log_files"><th><hr>'.esc_html__('Control of log files','VABFWC').'<hr></th></tr>
								<tr class="log_files">
									<td>
										<label for="VABFWC_FORMSA_OPT_NoDi">
											<span class="ch">' . esc_html__( 'Write form responses to log files', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_NoDi" type="checkbox" name="VABFWC_FORMSA_OPT_NoDi" ' . esc_attr( $VABFWC_FORMSA_OPT_NoDi ) . '>
										</label>
									</td>
								</tr>
								<tr class="log_files">
									<td>
										<label for="VABFWC_FORMSA_OPT_CSV_LOGS">
											<span class="ch">' . esc_html__( 'Write form responses to csv files', 'VABFWC' ) . '. ' . esc_html__( 'Option required', 'VABFWC' ) . ' - ' . esc_html__( 'Write form responses to log files', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_CSV_LOGS" type="checkbox" name="VABFWC_FORMSA_OPT_CSV_LOGS" ' . esc_attr( $VABFWC_FORMSA_OPT_CSV_LOGS ) . '>
										</label>
									</td>
								</tr>';
		$VABFWC_CHEKER_ROLS = '';
		foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ){
			$VABFWC_CHEKER_ROLS .= '<label for="VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE . '">
																<span class="ch">' . $VABFWC_ROLE . '&nbsp;&nbsp;&nbsp;</span>
																<input id="VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE . '" type="checkbox" name="VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE . '" ' . esc_attr( ${'VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE} ) . '>
															</label>';
		}
		echo			'<tr class="log_files">
									<td>
										<span class="ch">' . esc_html__( 'Show the CSV files only for', 'VABFWC' ) . ':&nbsp;&nbsp;&nbsp;</span>
										' . $VABFWC_CHEKER_ROLS . '
									</td>
								</tr>';
			echo			'<tr class="log_files">
									<td>
										<label for="VABFWC_FORMSA_OPT_NoDate">
											<span class="ch">' . esc_html__( 'Don`t write date to log files', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_NoDate" type="checkbox" name="VABFWC_FORMSA_OPT_NoDate" ' . esc_attr( $VABFWC_FORMSA_OPT_NoDate ) . '>
										</label>
									</td>
								</tr>
								<tr class="log_files">
									<td>
										<label for="VABFWC_FORMSA_OPT_NoIP">
											<span class="ch">' . esc_html__( 'Don`t write IP address to log files', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_NoIP" type="checkbox" name="VABFWC_FORMSA_OPT_NoIP" ' . esc_attr( $VABFWC_FORMSA_OPT_NoIP ) . '>
										</label>
									</td>
								</tr>
								<tr class="log_files">
									<td>
										<label for="VABFWC_FORMSA_OPT_NoAgent">
											<span class="ch">' . esc_html__( 'Don`t write user Agent to log files', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_NoAgent" type="checkbox" name="VABFWC_FORMSA_OPT_NoAgent" ' . esc_attr( $VABFWC_FORMSA_OPT_NoAgent ) . '>
										</label>
									</td>
								</tr>
								<tr class="log_files">
									<td>
										<label for="VABFWC_FORMSA_OPT_PROT">
											<span class="ch">' . esc_html__( 'Block access to log files with htaccess', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_PROT" type="checkbox" name="VABFWC_FORMSA_OPT_PROT" ' . esc_attr( $VABFWC_FORMSA_OPT_PROT ) . '>
										</label>
									</td>
								</tr>
								<tr class="th_seet_diag"><th><hr>'.esc_html__('Settings of charts','VABFWC').'<hr></th></tr>
								<tr class="seet_diag">
									<td>
										<label for="VABFWC_FORMSA_OPT_HideDi">
											<span class="ch">' . esc_html__( 'Don`t show chart', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_HideDi" type="checkbox" name="VABFWC_FORMSA_OPT_HideDi" ' . esc_attr( $VABFWC_FORMSA_OPT_HideDi ) . '>
										</label>
									</td>
								</tr>
								<tr class="seet_diag">
									<td>
										<label for="VABFWC_FORMSA_OPT_ShowDi">
											<span class="ch">' . esc_html__( 'Always show the charts at the end of the questionnaire', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_ShowDi" type="checkbox" name="VABFWC_FORMSA_OPT_ShowDi" ' . esc_attr( $VABFWC_FORMSA_OPT_ShowDi ) . '>
										</label>
									</td>
								</tr>';
		$VABFWC_CHEKER_ROLE = '';
		foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ){
			$VABFWC_CHEKER_ROLE .= '<label for="VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE . '">
																<span class="ch">' . $VABFWC_ROLE . '&nbsp;&nbsp;&nbsp;</span>
																<input id="VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE . '" type="checkbox" name="VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE . '" ' . esc_attr( ${'VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE} ) . '>
															</label>';
		}
		echo			'<tr class="seet_diag">
									<td>
										<span class="ch">' . esc_html__( 'Show the charts only for', 'VABFWC' ) . ':&nbsp;&nbsp;&nbsp;</span>
										' . $VABFWC_CHEKER_ROLE . '
									</td>
								</tr>';
			echo			'<tr class="seet_diag">
									<td>
										<label for="VABFWC_FORMSA_OPT_TotaL">
											<span class="ch">' . esc_html__( 'Hide the total number of completed questionnaires', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_TotaL" type="checkbox" name="VABFWC_FORMSA_OPT_TotaL" ' . esc_attr( $VABFWC_FORMSA_OPT_TotaL ) . '>
									</label>
									</td>
								</tr>
								<tr class="seet_diag">
									<td>
										<label for="VABFWC_FORMSA_OPT_TotaL_Every_circ">
											<span class="ch">' . esc_html__( 'Show total answers per question above pie chart', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_TotaL_Every_circ" type="checkbox" name="VABFWC_FORMSA_OPT_TotaL_Every_circ" ' . esc_attr( $VABFWC_FORMSA_OPT_TotaL_Every_circ ) . '>
										</label>
									</td>
								</tr>
								<tr class="seet_diag">
									<td>
										<label for="VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans">
											<span class="ch">' . esc_html__( 'Show the number of answers for each question above the pie chart', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans" type="checkbox" name="VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans" ' . esc_attr( $VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans ) . '>
										</label>
									</td>
								</tr>
								<tr class="seet_diag">
									<td>
										<label for="VABFWC_FORMSA_OPT_TotaL_Every_ceck">
											<span class="ch">' . esc_html__( 'Hide the total selection number of each checkbox', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_TotaL_Every_ceck" type="checkbox" name="VABFWC_FORMSA_OPT_TotaL_Every_ceck" ' . esc_attr( $VABFWC_FORMSA_OPT_TotaL_Every_ceck ) . '>
										</label>
									</td>
								</tr>
								<tr class="th_seet_attach"><th><hr>'.esc_html__('Settings of attachments','VABFWC').'<hr></th></tr>
								<tr class="seet_attach">
									<td>
										<label for="VABFWC_FORMSA_OPT_AddFile">
											<span class="ch">' . esc_html__( 'Add the ability to send a file', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_AddFile" type="checkbox" name="VABFWC_FORMSA_OPT_AddFile" ' . esc_attr( $VABFWC_FORMSA_OPT_AddFile ) . '>
										</label>
									</td>
								</tr>
								<tr class="seet_attach">
									<td>
										<label for="VABFWC_FORMSA_OPT_AddFileMulti">
											<span class="ch">' . esc_html__( 'Multiple File Upload', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_AddFileMulti" type="checkbox" name="VABFWC_FORMSA_OPT_AddFileMulti" ' . esc_attr( $VABFWC_FORMSA_OPT_AddFileMulti ) . '>
										</label>
									</td>
								</tr>
								<tr class="seet_attach">
									<td>
										<label for="VABFWC_FORMSA_OPT_SIZE">
											<span class="text">' . esc_html__( 'Total files size', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;-&nbsp;(&nbsp;Mb&nbsp;)&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_SIZE" type="number" name="VABFWC_FORMSA_OPT_SIZE" min="1" max="9" step="1" value="' . esc_attr( $VABFWC_FORMSA_OPT_SIZE ) . '">
										</label>
									</td>
								</tr>
								<tr class="seet_attach">
									<td>
										<label for="VABFWC_FORMSA_OPT_EXT">
											<span class="text">' . esc_html__( 'Allowed extensions. Separate by comma', 'VABFWC' ) . '&nbsp;&nbsp;&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_EXT" type="text" name="VABFWC_FORMSA_OPT_EXT" value="' . esc_attr( $VABFWC_FORMSA_OPT_EXT ) . '">
										</label>
									</td>
								</tr>
								<tr class="th_seet_mess"><th><hr>' . esc_html__('Email settings','VABFWC') . '<hr></th></tr>
								<tr class="seet_mess">
									<td>
										<label for="VABFWC_FORMSA_OPT_TITLE_MAIL">
											<span class="text">' . esc_html__( 'Table title', 'VABFWC' ) . ' :</span>
											<input id="VABFWC_FORMSA_OPT_TITLE_MAIL" size="33" type="text" name="VABFWC_FORMSA_OPT_TITLE_MAIL" value="' . esc_attr( $VABFWC_FORMSA_OPT_TITLE_MAIL ) . '">
										</label>
									</td>
								</tr>
								<tr class="seet_mess">
									<td>
										<label for="VABFWC_FORMSA_OPT_MAIL_Copy">
											<span class="ch">' . esc_html__( 'Send a copy of the form to the admin', 'VABFWC' ) . '.&nbsp;' . esc_html__( 'The field below must be filled', 'VABFWC' ) . '&nbsp;</span>
											<input id="VABFWC_FORMSA_OPT_MAIL_Copy" type="checkbox" name="VABFWC_FORMSA_OPT_MAIL_Copy" ' . esc_attr( $VABFWC_FORMSA_OPT_MAIL_Copy ) . '>
										</label>
									</td>
								</tr>
								<tr class="seet_mess">
									<td>
										<label for="VABFWC_FORMSA_OPT_MAIL">
											<span class="text">' . esc_html__( 'Email to send the form to', 'VABFWC' ) . ' :</span>
											<input id="VABFWC_FORMSA_OPT_MAIL" size="33" type="text" name="VABFWC_FORMSA_OPT_MAIL" value="' . esc_attr( $VABFWC_FORMSA_OPT_MAIL ) . '">
										</label>
									</td>
								</tr>
								<tr class="seet_mess">
									<td>
										<label for="VABFWC_USER_SEND_MAIL">
											<span class="ch">' . esc_html__( 'Sending an email to a user. You can activate the receipt of a copy of the letter by e-mail for the user who submitted the form.The user`s email will be taken from the «email» form field', 'VABFWC' ) . '</span>
											<input id="VABFWC_USER_SEND_MAIL" type="checkbox" name="VABFWC_USER_SEND_MAIL" ' . esc_attr( $VABFWC_USER_SEND_MAIL ) . '>
										</label>
									</td>
								</tr>
								<tr class="seet_mess">
									<td>
										<label for="VABFWC_NO_SEND_MAIL">
											<span class="ch">' . esc_html__( 'Do not send emails', 'VABFWC' ) . '</span>
											<input id="VABFWC_NO_SEND_MAIL" type="checkbox" name="VABFWC_NO_SEND_MAIL" ' . esc_attr( $VABFWC_NO_SEND_MAIL ) . '>
										</label>
									</td>
								</tr>
								</tbody>
							</table>';
	}
}
/*we process meta data and save it in the database when publishing or saving the created form*/
add_action( 'edit_post', 'vabfwc_contact_forms_save_meta', 10, 2 );
if ( ! function_exists( 'vabfwc_contact_forms_save_meta' ) ) {
	function vabfwc_contact_forms_save_meta( $post_ID, $post ) {
		$post_type = get_post_type( $post_ID );
		if ( $post_type == 'vab_fwc' ) {
			$nonce=vabfwc_sanitize_data_types($_POST['VABFWC_FORMS_nonce']);
			/* $nonce = filter_input( INPUT_POST, 'VABFWC_FORMS_nonce', FILTER_SANITIZE_STRING ); */
			if ( ! $nonce ) {
				return $post_ID;
			}
			if ( ! wp_verify_nonce( $nonce, 'VABFWC_mode_FORMS_nonce' ) ) {
				return;
			}
			$nonceOpt=vabfwc_sanitize_data_types($_POST['VABFWC_FORMS_opt_nonce']);
			/* $nonceOpt = filter_input( INPUT_POST, 'VABFWC_FORMS_opt_nonce', FILTER_SANITIZE_STRING ); */
			if ( ! $nonceOpt ) {
				return $post_ID;
			}
			if ( ! wp_verify_nonce( $nonceOpt, 'VABFWC_mode_FORMS_opt_nonce' ) ) {
				return;
			}
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			if ( ! current_user_can( 'edit_post', $post_ID ) ) {
				return;
			}
			global $wp_roles;
			$VABFWC_ROLES					= $wp_roles->get_names();
			$VABFWC_FORMSA				= get_post_meta( $post_ID, 'VABFWC_FORM', true );
			$VABFWC_FORMS_filds 	= array();
			$VABFWC_FORMS_All 		= isset( $_POST[$post_ID] ) ? vabfwc_sanitize_text_field( $_POST[$post_ID] ) : '';
			$VABFWC_FORMS_All ? $VABFWC_FORMS_filds[$post_ID] = vabfwc_sanitize_text_field( $VABFWC_FORMS_All ) : true;
			$VABFWC_Class = new VABFWC_Class( $post_ID );
			if ( ! empty( $VABFWC_FORMS_filds ) ) {
				update_post_meta( $post_ID, 'VABFWC_FORM', $VABFWC_FORMS_filds );
				$VABFWC_Class->FileDel();
			} else {
				$GpMFORM = get_post_meta( $post_ID, 'VABFWC_FORM' );
				if ( $GpMFORM ) {
					delete_post_meta( $post_ID, 'VABFWC_FORM' );
					$VABFWC_Class->DirDel();
				}
			}
			$VABFWC_FORM_OPT										= array();
			$VABFWC_FORMSA_OPT_NoDi							=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_NoDi', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_CSV_LOGS					=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_CSV_LOGS', FILTER_VALIDATE_BOOLEAN );
			foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ){
				${'VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE} = filter_input( INPUT_POST, 'VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE, FILTER_VALIDATE_BOOLEAN );
			}
			$VABFWC_FORMSA_OPT_NoDate						=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_NoDate', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_NoIP							=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_NoIP', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_NoAgent					=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_NoAgent', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_PROT							=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_PROT', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_HideDi						=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_HideDi', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_ShowDi						=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_ShowDi', FILTER_VALIDATE_BOOLEAN );
			foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ){
				${'VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE} = filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE, FILTER_VALIDATE_BOOLEAN );
			}
			$VABFWC_FORMSA_OPT_TotaL						=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_TotaL', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_TotaL_Every_circ	=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_TotaL_Every_circ', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans		=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_TotaL_Every_ceck	=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_TotaL_Every_ceck', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_MAIL_Copy				=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_MAIL_Copy', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_AddFile					=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_AddFile', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_AddFileMulti			=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_AddFileMulti', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_FORMSA_OPT_SIZE							=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_SIZE', FILTER_VALIDATE_INT );
			$VABFWC_FORMSA_OPT_EXT							=	sanitize_text_field( str_replace( array( " ", "." ), "", $_POST['VABFWC_FORMSA_OPT_EXT'] ) );
			$VABFWC_FORMSA_OPT_MAIL							=	filter_input( INPUT_POST, 'VABFWC_FORMSA_OPT_MAIL', FILTER_VALIDATE_EMAIL );
			$VABFWC_FORMSA_OPT_TITLE_MAIL				=	sanitize_text_field( $_POST['VABFWC_FORMSA_OPT_TITLE_MAIL'] );
			$VABFWC_FORMSA_OPT_NoDi 						? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_NoDi'] = $VABFWC_FORMSA_OPT_NoDi : false;
			$VABFWC_FORMSA_OPT_CSV_LOGS 				? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] = $VABFWC_FORMSA_OPT_CSV_LOGS : false;
			foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ){
				${'VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE} ? $VABFWC_FORM_OPT['VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE]	= ${'VABFWC_FORMSA_CSV_Show_' . $VABFWC_ROLE}	: true;
			}
			$VABFWC_USER_SEND_MAIL							=	filter_input( INPUT_POST, 'VABFWC_USER_SEND_MAIL', FILTER_VALIDATE_BOOLEAN );
			$VABFWC_NO_SEND_MAIL								=	filter_input( INPUT_POST, 'VABFWC_NO_SEND_MAIL', FILTER_VALIDATE_BOOLEAN );
			if ( $VABFWC_FORMSA_OPT_NoDi == false ) {
				$VABFWC_Class->DirDel();
			}
			if ( $VABFWC_FORMSA_OPT_CSV_LOGS == false ) {
				$VABFWC_Class->DirDelCsv();
			}
			$VABFWC_FORMSA_OPT_PROT 						? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_PROT'] = $VABFWC_FORMSA_OPT_PROT : false;
			if ( ! file_exists( $VABFWC_Class->FD ) && ! empty( $VABFWC_FORMSA_OPT_NoDi ) ) {
				mkdir( $VABFWC_Class->FD, 0755, true );
			}
			if ( ! file_exists( $VABFWC_Class->FD . 'csv_logs' ) && ! empty( $VABFWC_FORMSA_OPT_NoDi ) && ! empty( $VABFWC_FORMSA_OPT_CSV_LOGS ) ) {
				mkdir( $VABFWC_Class->FD . 'csv_logs', 0755, true );
			}
			$VABFWC_Silence	 		= $VABFWC_Class->FD . "/index.php";
			if ( file_exists( $VABFWC_Class->FD ) && ! file_exists( $VABFWC_Silence ) ) {
				file_put_contents( $VABFWC_Silence, "<?php\n// Silence is golden." );
			}
			$VABFWC_Silence_CSV	= $VABFWC_Class->FD . "csv_logs/index.php";
			if ( file_exists( $VABFWC_Class->FD . 'csv_logs' ) && ! file_exists( $VABFWC_Silence_CSV ) ) {
				file_put_contents( $VABFWC_Silence_CSV, "<?php\n// Silence is golden." );
			}
			$AccessFile				= $VABFWC_Class->FD . "/.htaccess";
			if ( ! empty( $VABFWC_FORMSA_OPT_PROT ) && ! empty( $VABFWC_FORMSA_OPT_NoDi ) ) {
				if ( ! file_exists( $AccessFile ) ) {
					file_put_contents( $AccessFile, "Require all denied" );
				}
			} else {
				if ( file_exists( $AccessFile ) ) {
					unlink( $AccessFile );
				}
			}
			$AccessFile_CSV		= $VABFWC_Class->FD . "csv_logs/.htaccess";
			if ( ! empty( $VABFWC_FORMSA_OPT_PROT ) && ! empty( $VABFWC_FORMSA_OPT_CSV_LOGS ) ) {
				if ( ! file_exists( $AccessFile_CSV ) && file_exists( $VABFWC_Class->FD . 'csv_logs' ) ) {
					file_put_contents( $AccessFile_CSV, "Require all denied" );
				}
			} else {
				if ( file_exists( $AccessFile_CSV ) ) {
					unlink( $AccessFile_CSV );
				}
			}
			$VABFWC_FORMSA_OPT_NoDate						?	$VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_NoDate']						= $VABFWC_FORMSA_OPT_NoDate 					: true;
			$VABFWC_FORMSA_OPT_NoIP							?	$VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_NoIP']							= $VABFWC_FORMSA_OPT_NoIP 						: true;
			$VABFWC_FORMSA_OPT_NoAgent					?	$VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_NoAgent']						= $VABFWC_FORMSA_OPT_NoAgent 					: true;
			$VABFWC_FORMSA_OPT_HideDi						?	$VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_HideDi']						= $VABFWC_FORMSA_OPT_HideDi 					: true;
			$VABFWC_FORMSA_OPT_ShowDi						? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_ShowDi']					  = $VABFWC_FORMSA_OPT_ShowDi 					: true;
			foreach( $VABFWC_ROLES as $VABFWC_ROLE => $VABFWC_NAME ){
				${'VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE} ? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE]	= ${'VABFWC_FORMSA_OPT_Show_' . $VABFWC_ROLE}	: true;
			}
			$VABFWC_FORMSA_OPT_TotaL						? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_TotaL']							= $VABFWC_FORMSA_OPT_TotaL						: true;
			$VABFWC_FORMSA_OPT_TotaL_Every_circ ? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_TotaL_Every_circ']	= $VABFWC_FORMSA_OPT_TotaL_Every_circ : true;
			$VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans 	? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans']		= $VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans 	: true;
			$VABFWC_FORMSA_OPT_TotaL_Every_ceck ? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_TotaL_Every_ceck']	= $VABFWC_FORMSA_OPT_TotaL_Every_ceck : true;
			$VABFWC_FORMSA_OPT_AddFile					?	$VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_AddFile']						= $VABFWC_FORMSA_OPT_AddFile 					: true;
			$VABFWC_FORMSA_OPT_AddFileMulti			?	$VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_AddFileMulti']			= $VABFWC_FORMSA_OPT_AddFileMulti 		: true;
			$VABFWC_FORMSA_OPT_SIZE							?	$VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_SIZE']							= $VABFWC_FORMSA_OPT_SIZE 						: true;
			$VABFWC_FORMSA_OPT_EXT							?	$VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_EXT']								= $VABFWC_FORMSA_OPT_EXT 							: true;
			$VABFWC_FORMSA_OPT_TITLE_MAIL 			? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_TITLE_MAIL'] 				= $VABFWC_FORMSA_OPT_TITLE_MAIL 			: true;
			$VABFWC_FORMSA_OPT_MAIL_Copy 				? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_MAIL_Copy'] 				= $VABFWC_FORMSA_OPT_MAIL_Copy 				: true;
			$VABFWC_FORMSA_OPT_MAIL 						? $VABFWC_FORM_OPT['VABFWC_FORMSA_OPT_MAIL'] 							= $VABFWC_FORMSA_OPT_MAIL 						: true;
			$VABFWC_USER_SEND_MAIL							?	$VABFWC_FORM_OPT['VABFWC_USER_SEND_MAIL']								= $VABFWC_USER_SEND_MAIL 							: true;
			$VABFWC_NO_SEND_MAIL								?	$VABFWC_FORM_OPT['VABFWC_NO_SEND_MAIL']									= $VABFWC_NO_SEND_MAIL 								: true;
			if ( ! empty( $VABFWC_FORM_OPT ) ) {
				update_post_meta( $post_ID, 'VABFWC_FORM_OPT', $VABFWC_FORM_OPT );
			}else{
				$GpM = get_post_meta( $post_ID, 'VABFWC_FORM_OPT' );
				if ( $GpM ) {
					delete_post_meta( $post_ID, 'VABFWC_FORM_OPT' );
				}
			}
		}
	}
}
/*create a new column*/
add_filter( 'manage_vab_fwc_posts_columns', 'vabfwc_add_views_column', 4 );
if ( ! function_exists( 'vabfwc_add_views_column' ) ) {
	function vabfwc_add_views_column( $columns ) {
		$i = 0;
		$out = array();
		foreach( $columns as $col => $name ) {
			if ( ++$i == 3 ) {
				$out['vab_fwc_shortcode'] = esc_html__( 'Shortcode', 'VABFWC' );
			}
			$out[$col] = $name;
		}
		return $out;
	}
}
/*sorting a new column*/
add_filter( 'manage_vab_fwc_posts_custom_column', 'vabfwc_fill_views_column', 5, 2 );
if ( ! function_exists( 'vabfwc_fill_views_column' ) ) {
	function vabfwc_fill_views_column( $colname, $post_id ) {
		if ( $colname === 'vab_fwc_shortcode' ) {
			echo '<div class="VABFWC_ShortCode">[VABFWC id="' . esc_html( $post_id ) . '"]</div>';
		}
	}
}
/*delete the folder with the collected data for the chart when deleting a post*/
add_action( 'admin_init', 'vabfwc_contact_forms_init' );
if ( ! function_exists( 'vabfwc_contact_forms_init' ) ) {
	function vabfwc_contact_forms_init() {
		add_action( 'delete_post', 'vabfwc_contact_forms_del', 10 );
	}
}
if ( ! function_exists( 'vabfwc_contact_forms_del' ) ) {
	function vabfwc_contact_forms_del( $pid ) {
		$post_type = get_post_type( $pid );
		if ( $post_type == 'vab_fwc' ){
			$VABFWC_Class = new VABFWC_Class( $pid );
			$VABFWC_Class->DirDel();
		}
	}
}
add_action( 'admin_menu', 'add_vab_fwc_info' );
if ( ! function_exists( 'add_vab_fwc_info' ) ) {
  function add_vab_fwc_info() {
		add_submenu_page(
			'edit.php?post_type=vab_fwc',
			esc_html__( 'About release', 'VABFWC' ),
			esc_html__( 'About release', 'VABFWC' ),
			'manage_options',
			'vab_fwc_info',
			'vab_fwc_info'
		);
	}
}
if ( ! function_exists( 'vab_fwc_info' ) ) {
  function vab_fwc_info() {
		echo	'<div id="wrap_vab_fwc_info" style="width:96%;margin-left:2%;">' .
						'<center><h2>' . esc_html__( 'About release', 'VABFWC' ) . '</h2>' .
							'<table cellpadding="4" border="1" cellpadding="4" width="100%">' .
								'<tbody>' .
									'<tr>' .
										'<td>' .
											esc_html__( 'Plugin Name', 'VABFWC' ) .
										'</td>' .
										'<td>' .
											'Forms with chart from VAB' .
										'</td>' .
									'</tr>' .
									'<tr>' .
										'<td>' .
											esc_html__( 'Description', 'VABFWC' ) .
										'</td>' .
										'<td>' .
											esc_html__( 'Simple Plugin for creating forms, inquirer and questionnaires with the ability to display the results in the form of charts', 'VABFWC' ) .
										'</td>' .
									'</tr>' .
									'<tr>' .
										'<td>' .
											esc_html__( 'Author', 'VABFWC' ) .
										'</td>' .
										'<td>' .
											esc_html__( 'Vladimir Anatol`evich Brumer', 'VABFWC' ) .
										'</td>' .
									'</tr>' .
									'<tr>' .
										'<td>' .
											esc_html__( 'Version', 'VABFWC' ) .
										'</td>' .
										'<td>' .
											VABFWC_VERSION .
										'</td>' .
									'</tr>' .

									'<tr>' .
										'<td>' .
											esc_html__( 'Version Wordpress at least', 'VABFWC' ) .
										'</td>' .
										'<td>' .
											'5.5.1' .
										'</td>' .
									'</tr>' .
									'<tr>' .
										'<td>' .
											esc_html__( 'Tested Wordpress up to', 'VABFWC' ) .
										'</td>' .
										'<td>' .
											'6.6.0' .
										'</td>' .
									'</tr>' .
									'<tr>' .
										'<td>' .
											esc_html__( 'Requires PHP', 'VABFWC' ) .
										'</td>' .
										'<td>' .
											'5.6.20 - 8.3.6' .
										'</td>' .
									'</tr>' .
									'<tr>' .
										'<td>' .
											esc_html__( 'Plugin URI', 'VABFWC' ) .
										'</td>' .
										'<td>' .
											'<a target="_blank" href="' . esc_url( 'https://it-vab.ru/vab-forms-with-chart' ) . '">' .
												esc_url( 'https://it-vab.ru/vab-forms-with-chart' ) .
											'</a>' .
										'</td>' .
									'</tr>' .
									'<tr>' .
										'<td>' .
											esc_html__( 'GitHub', 'VABFWC' ) .
										'</td>' .
										'<td>' .
											'<a target="_blank" href="' . esc_url( 'https://github.com/Vladimir-Brumer/vab-forms-with-chart' ) . '">' .
												esc_url( 'https://github.com/Vladimir-Brumer/vab-forms-with-chart' ) .
											'</a>' .
										'</td>' .
									'</tr>' .
									'<tr>' .
										'<td>' .
											esc_html__( 'Donate link', 'VABFWC' ) .
										'</td>' .
										'<td>' .
											'<a target="_blank" href="' . esc_url( 'https://it-vab.ru/vab-forms-with-chart#donate' ) . '">' .
												esc_url( 'https://it-vab.ru/vab-forms-with-chart#donate' ) .
											'</a>' .
										'</td>' .
									'</tr>' .
								'</tbody>' .
							'</table>' .
							'<h3>' . esc_html__( 'New in version', 'VABFWC' ) . ' ' . VABFWC_VERSION . '</h3>' .
						'</center>' .
						'<ol>' .
							'<li>' . esc_html__( 'Fixes for compatibility with Wordpress 6.6', 'VABFWC' ) . '</li>' .
							'<li>' . esc_html__( 'Fixes for compatibility with PHP 8.1 and higher (replacing FILTER_SANITIZE_STRING)', 'VABFWC' ) . '</li>' .
							'<li>' . esc_html__( 'Fixed the work of the form option (sending the form by default to the Email field in the completed form)', 'VABFWC' ) . '</li>' .
						'</ol>' .
					'</div>';
	}
}