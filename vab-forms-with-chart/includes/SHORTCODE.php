<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*************************************
*************************************
****CREATE SHORTCODE AND FORM HANDLER
*************************************
*************************************/
$vabfwc = 1;
add_shortcode( "VABFWC", "vabfwc_short" );
if ( ! function_exists( 'vabfwc_short' ) ) {
	function vabfwc_short( $atts ) {
	ob_start();
	$id										= ! empty( $atts['id'] ) ? intval( $atts['id'] ) : '';
	$form_id							= ! empty( $atts['form_id'] ) ? ' id="' . sanitize_text_field( $atts['form_id'] ) . '"' : '';
	$form_class						= ! empty( $atts['form_class'] ) ? ' ' . sanitize_text_field( $atts['form_class'] ) : '';
	$VABFWC_FORMSA				= get_post_meta( $id, 'VABFWC_FORM', true );
	$VABFWC_FORMSA_OPT		= get_post_meta( $id, 'VABFWC_FORM_OPT', true );
	$i										= esc_html( 'diagramm_' . $GLOBALS['vabfwc'] );
	$i										= ! empty( $atts['id'] ) ? intval( $atts['id'] ) . '_' . $i : $i;
	$VABFWC								=	new VABFWC_Forms_Protect( $i );
	$VABFWC_AD						=	new VABFWC_Forms_Protect( 'veri_Ad_' . $i );
	$VABFWC_Prot_Arg			= 	array( /* wp_kses */
		'fieldset'					=>	array(),
		'legend'						=>	array(),
		'label'							=>	array(
			'for'							=>	array(),
		),
		'input'							=>	array(
			'type'						=>	array(),
			'id'							=>	array(),
			'class'						=>	array(),
			'name'						=>	array(),
			'value'						=>	array(),
			'checked'					=>	array(),
			'onfocus'					=>	array(),
			'onchange'				=>	array(),
		),
	);
	$Class_Adm_Arg				= 	array( /* wp_kses */
		'div'								=>	array(
			'class'						=>	array(),
			'tabindex'				=>	array(),
		),
		'table'							=>	array(),
		'thead'							=>	array(),
		'tbody'							=>	array(),
		'tr'								=>	array(),
		'th'								=>	array(),
		'td'								=>	array(),
		'label'							=>	array(
			'for'							=>	array(),
			'style'						=>	array(),
		),
		'input'							=>	array(
			'id'							=>	array(),
			'style'						=>	array(),
			'type'						=>	array(),
			'name'						=>	array(),
			'value'						=>	array(),
			'onclick'					=>	array(),
		),
		'tfoot'							=>	array(),
		'a'									=>	array(
			'target'					=>	array(),
			'href'						=>	array(),
		),
	);
	$Class_Graphic_Arg		= 	array( /* wp_kses */
		'div'								=>	array(
			'class'						=>	array(),
			'style'						=>	array(),
		),
		'br'								=>	array(),
		'center'						=>	array(),
		'style'							=>	array(
			'type'						=>	array(),
		),
		'span'							=>	array(
			'class'						=>	array(),
			'style'						=>	array(),
		),
	);
	$Erchik								= esc_html__( 'Check entered data', 'VABFWC' );
	$VABFWC_USER_SEND_MAIL= '';
	$VABFWC_SizeSum				=	0;
	$F_S_M								=	! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_SIZE'] ) ? sanitize_text_field( intval( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_SIZE'] ) ) : '3';
	$FileSendErorSizeInf	=	'';	/* filtering the output through wp_kses */
	$FileSendErorSize			=	'';	/* filtering the output through wp_kses */
	$SiZeS								=	esc_html__( 'Uploaded file size bytes/Mb', 'VABFWC' );
	$VABFWC_multipart			= ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_AddFile'] ) ? esc_attr( 'enctype=multipart/form-data' ) : '';
	$VABFWC_TEMP					=	esc_html( VABFWC_UPLOAD_DIR .'/VABFWC/temp' );
	$VABFWC_EXT 					= ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_EXT'] ) ? explode( ",", $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_EXT'] ) : array();
	$validate_VABFWC			=	false;
	$fields_VABFWC				=	false;
	$message_VABFWC				=	false;
	$message_after_VABFWC	=	false;
	$hasErrorAdMassage		=	'';
	if ( ! empty( $VABFWC_FORMSA ) ) {
		$VABFWC_FORMSA		= $VABFWC_FORMSA[$id];
		/* HANDLER */
		foreach( $VABFWC_FORMSA as $k => $v ) {
			${$k . 'Error'}		= '';
			${$k . 'put'}			= '';
		}
	$VABFWC_Class = new VABFWC_Class( $id );
	$hasErrorAd	= false;
	if ( isset( $_POST['submitres'] ) ) {
		$CheckFieldsErorAd	=	$VABFWC_AD->CheckFields();
		if ( $CheckFieldsErorAd == true || empty( $_POST['resTable'] ) ) {
			$hasErrorAd = true;
			$hasErrorAdMassage = esc_html__( 'Confirm the reset by checking the box', 'VABFWC' );
		}
		if ( $hasErrorAd !== true ) {
			unlink( $VABFWC_Class->mIP );
			unlink( $VABFWC_Class->mDATE );
			unlink( $VABFWC_Class->mAGENT );
		}
	}
	if ( isset( $_POST['submitted_' . $id] ) ) {
		if ( ! file_exists( $VABFWC_Class->FD ) && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDi'] ) ) {
			mkdir( $VABFWC_Class->FD, 0755, true );
		}
	if ( empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDate']) || empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoIP']) || empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoAgent']) ) {
			if ( ! file_exists( $VABFWC_Class->mIP ) && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDi'] ) ) {
				if ( file_exists( $VABFWC_Class->FD . 'mIP.txt' ) ) {
					rename ( $VABFWC_Class->FD . 'mIP.txt', $VABFWC_Class->mIP );
				}
				file_put_contents( $VABFWC_Class->mIP, '', FILE_APPEND );
			}
			if ( ! file_exists( $VABFWC_Class->mDATE ) && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDi'] ) ) {
				if ( file_exists( $VABFWC_Class->FD . 'mDATE.txt' ) ) {
					rename ( $VABFWC_Class->FD . 'mDATE.txt', $VABFWC_Class->mDATE );
				}
				file_put_contents( $VABFWC_Class->mDATE, '', FILE_APPEND );
			}
			if ( ! file_exists( $VABFWC_Class->mAGENT ) && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDi'] ) ) {
				if ( file_exists( $VABFWC_Class->FD . 'mAGENT.txt' ) ) {
					rename ( $VABFWC_Class->FD . 'mAGENT.txt', $VABFWC_Class->mAGENT );
				}
				file_put_contents( $VABFWC_Class->mAGENT, '', FILE_APPEND );
			}
	}
		$sub			= esc_html__( 'Message from the site', 'VABFWC' )
							. ' «'
							. esc_html( get_bloginfo( 'name' ) )
							. '» / «'
							. esc_html__( 'Form', 'VABFWC' )
							. ' - '
							. esc_html( get_the_title( $id ) )
							. '»';
		$Titla		= ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_TITLE_MAIL'] )
								? esc_html( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_TITLE_MAIL'] )
								: esc_html__( 'Questionnaire content', 'VABFWC' );
		$IP				= esc_html__( 'IP address', 'VABFWC' )
							. ": " . $GLOBALS['VABFWC_IP'];
		$AVT			= esc_html__( 'The form author Vladimir Anatolyevich Brumer', 'VABFWC' )
							. '<br>'
							.	'<a style="padding:4px;font-size:14px;text-decoration:underline;color:#FFF;" href="'
							. esc_html( 'mailto:m@it-vab.ru' ) . '" target="_blank" rel="noopener noreferrer">'
							. esc_html( 'm@it-vab.ru' ) . '</a>'.
							' ¯\_(ツ)_/¯ '
							. '<a style="padding:4px;font-size:14px;text-decoration:underline;color:#FFF;" href="'
							. esc_html( 'mailto:brumer.vladimir@mail.ru' ) . '" target="_blank" rel="noopener noreferrer">'
							. esc_html( 'brumer.vladimir@mail.ru' ) . '</a>';
		$Qw				= esc_html__( 'Question', 'VABFWC' );
		$Ans			= esc_html__( 'Possible answer', 'VABFWC' );
		$Oth			= esc_html__( 'Your own answer', 'VABFWC' );
		$tdIn			= '<td style="max-width:15px;min-width:15px;width:15px;"></td>';
		$sty			= 'style="padding-bottom:22px;padding-top:44px;"';
		$ChBody		= '';
		$hasError	= false;
		if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) && file_exists( $VABFWC_Class->FD . 'csv_logs' ) ) {
			$csv_logs 				= $VABFWC_Class->FD . 'csv_logs';
			$csv_log_report 	= $csv_logs . '/' . date( 'm_Y') . '.csv';
			$csv_t						= ! empty( get_the_title( $id ) ) ? get_the_title( $id ) : esc_html__( 'Title not specified', 'VABFWC' );
			$csv_title				= array( esc_html__( 'Title the form', 'VABFWC' ) . ': ' . $csv_t . ' ( ID - ' . $id .').' );
			$csv_f_srtok			= array( '№', esc_html__( 'Date', 'VABFWC' ) );
			foreach( $VABFWC_FORMSA as $k => $v ) {
				$csv_f_srtok[]	= esc_html ( $v['question'] );
			}
			$csv_line					= array(
														$csv_title,
														$csv_f_srtok,
													);
			if ( file_exists( $csv_logs ) && ! file_exists( $csv_log_report ) ) {
				$csv_file				= fopen( $csv_log_report, 'w' );
				fputs( $csv_file, chr(0xEF) . chr(0xBB) . chr(0xBF) );
				foreach( $csv_line as $line ){
					fputcsv( $csv_file, $line, ';' );
				}
				fclose( $csv_file );
			}
			$number_csv				= array();
			$chek_csv_array		= array();//наполним текущим
			if ( file_exists( $csv_logs ) && file_exists( $csv_log_report ) ) {
				$chek_csv_file	= fopen( $csv_log_report, 'r' );
				while ( ($data 	= fgetcsv($chek_csv_file, 1000, ";") ) !== FALSE){
						if ( is_numeric ($data[0]) ) {
							$number_csv[]			= $data[0];
						}
						if ( $data[0] == '№' ) {
							$chek_csv_array[] = $data;
						}
				}
			}
			fclose( $chek_csv_file );
			if ( !empty($number_csv) ) {
				$number_csv_max = max($number_csv) + 1;
			}
			$csv_diff 			= array_diff( $csv_line[1], end($chek_csv_array) ); //получим расхождение
			$csv_assoc 			= array_diff_assoc( $csv_line[1], end($chek_csv_array) );
			$csv_diff_rev 	= array_diff( end($chek_csv_array), $csv_line[1] ); //получим расхождение
			$csv_assoc_rev 	= array_diff_assoc( end($chek_csv_array), $csv_line[1] );
// print_r($csv_line[1]);
			if ( ! empty($csv_diff) || ! empty($csv_assoc) || ! empty($csv_diff_rev) || ! empty($csv_assoc_rev) ) {//если расход есть
				$new_csv_array			= array( $csv_line[1] ); //будущий нормальный массив
				if ( file_exists( $csv_logs ) && file_exists( $csv_log_report ) ) {
					$update_csv_file	= fopen( $csv_log_report, 'a+' );
					while ( ($data 		= fgetcsv($update_csv_file, 1000, ";") ) !== FALSE ) {
						fputcsv( $update_csv_file, $new_csv_array[0], ';' );
					}
				}
				fclose( $update_csv_file );
			}
			$massivfile		  	= file( $csv_log_report, FILE_SKIP_EMPTY_LINES );
			$countmassivfile	= count( $massivfile );
			$dates						= date( 'H \h. i \m\i\n. d.m.Y' );
			$answers					= array ( !empty ($number_csv_max) ? $number_csv_max: $countmassivfile -1, $dates );
		}
		foreach( $VABFWC_FORMSA as $k => $v ) {
			if ( ! file_exists( $VABFWC_Class->$k ) && ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDi'] ) ) {
				file_put_contents( $VABFWC_Class->$k, '', FILE_APPEND );
			}
			if ( $v['type'] == 'checkbox' ) {
				$coanswer		= count( $v['answer'] );
				$ChBody		 .= '<tr style="color:#FFF;">'
											. '<td valign="top">'
												. esc_html ( $v['question'] )
											. '</td>'
											. '<td valign="top" align="center">';
				$chekX			= 0;
				$okChek			= '';
				for ( $i = 0; $i < $coanswer; $i++ ) {
					if ( isset($_POST[$k . $i]) && $_POST[$k . $i] !== '' ) {
						$chekX++;
						$ok = sanitize_text_field( $_POST[$k . $i] );
						$ChBody .= '<p>' . $ok . '';
						${$k . 'put'} .= $ok . "\n";
						$okChek	.= " - " . $ok . "| ";
					}
				}
				$ChBody .= '</td>'
								 . '<td valign="top" align="center">'
									. ' - '
								. '</td>'
							. '</tr>';
				if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) ) {
					$answers[] = $okChek;
				}
				if ( $chekX == 0 ) {
					$hasError = true;
					${$k . 'Error'} = $Erchik;
				}
			} else if ( $v['type'] == 'url' ) {
					$ok = '';
					if ( isset($_POST[$k]) && $_POST[$k] !== '' && VABFWC_Chek_url( $_POST[$k] )&& VABFWC_is_url( $_POST[$k] ) ) {
						$ok = sanitize_url( $_POST[$k] );
					}	else {
						$hasError = true;
						${$k . 'Error'} = $Erchik;
					}
					${$k . 'put'} .= $ok . "\n";
				$ChBody .= '<tr style="color:#FFF;">'
									. '<td valign="top">'
										. esc_html ( $v['question'] )
									. '</td>'
									. '<td valign="top" align="center">'
										. '<a style="color:#FFF;" href="' . esc_url( $ok ) . '" target="_blank" rel="noopener noreferrer">'
											. esc_html ( $ok )
										. '</a>'
									. '</td>'
									. '<td valign="top" align="center">'
										. ' - '
									. '</td>'
								. '</tr>';
				if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) ) {
					$answers[]	= $ok;
				}
			}else if($v['type']=='tel' ) {
					$ok = '';
					if ( isset($_POST[$k]) && $_POST[$k] !== '' && !VABFWC_Chek_url( $_POST[$k] ) && VABFWC_is_tel( $_POST[$k] ) ) {
						$ok = sanitize_text_field( $_POST[$k] );
					}	else {
						$hasError = true;
						${$k . 'Error'} = $Erchik;
					}
					${$k . 'put'} .= $ok . "\n";
				$ChBody .= '<tr style="color:#FFF;">'
									. '<td valign="top">'
										. esc_html ( $v['question'] )
									. '</td>'
									. '<td valign="top" align="center">'
										. esc_html ( $ok )
									. '</td>'
									. '<td valign="top" align="center">'
										. ' - '
									. '</td>'
								. '</tr>';

				if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) ) {
					$answers[]	= $ok;
				}
			}else if($v['type']=='email' ) {
					$ok = '';
					if ( isset($_POST[$k]) && $_POST[$k] !== '' && !VABFWC_Chek_url( $_POST[$k] ) && VABFWC_is_email( $_POST[$k] ) ) {
						$ok = sanitize_text_field( $_POST[$k] );
						$VABFWC_USER_SEND_MAIL = sanitize_text_field( $_POST[$k] );
					}	else {
						$hasError = true;
						${$k . 'Error'} = $Erchik;
					}
					${$k . 'put'} .= $ok . "\n";
				$ChBody .= '<tr style="color:#FFF;">'
									. '<td valign="top">'
										. esc_html ( $v['question'] )
									. '</td>'
									. '<td valign="top" align="center">'
										. '<a style="color:#FFF;" href="' . esc_url( $ok ) . '" target="_blank" rel="noopener noreferrer">'
											. esc_html ( $ok )
										. '</a>'
									. '</td>'
									. '<td valign="top" align="center">'
										. ' - '
									. '</td>'
								. '</tr>';
				if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) ) {
					$answers[]	= $ok;
				}
			}else if($v['type']=='date' ) {
					$ok = '';
					if ( isset($_POST[$k]) && $_POST[$k] !== '' && !VABFWC_Chek_url( $_POST[$k] ) && VABFWC_is_date( $_POST[$k] ) ) {
						$ok = sanitize_text_field( $_POST[$k] );
					}	else {
						$hasError = true;
						${$k . 'Error'} = $Erchik;
					}
					${$k . 'put'} .= $ok . "\n";
				$ChBody .= '<tr style="color:#FFF;">'
									. '<td valign="top">'
										. esc_html ( $v['question'] )
									. '</td>'
									. '<td valign="top" align="center">'
										. esc_html ( $ok )
									. '</td>'
									. '<td valign="top" align="center">'
										. ' - '
									. '</td>'
								. '</tr>';
				if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) ) {
					$answers[]	= $ok;
				}
			}else if($v['type']=='number'||$v['type']=='range' ) {
					$ok = '';
					if ( isset($_POST[$k]) && $_POST[$k] !== '' && !VABFWC_Chek_url( $_POST[$k] ) && VABFWC_is_number( $_POST[$k] ) ) {
						$ok = sanitize_text_field( intval( $_POST[$k] ) );
					}	else {
						$hasError = true;
						${$k . 'Error'} = $Erchik;
					}
					${$k . 'put'} .= $ok . "\n";
				$ChBody .= '<tr style="color:#FFF;">'
									. '<td valign="top">'
										. esc_html ( $v['question'] )
									. '</td>'
									. '<td valign="top" align="center">'
										. esc_html ( $ok )
									. '</td>'
									. '<td valign="top" align="center">'
										. ' - '
									. '</td>'
								. '</tr>';
				if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) ) {
					$answers[]	= $ok;
				}
			} else if ( $v['type'] == 'select') {
					$ok = '';
					if ( isset($_POST[$k]) && $_POST[$k] !== '' && $_POST[$k] !== 'default' && !VABFWC_Chek_url( $_POST[$k] ) ) {
						$ok = sanitize_text_field( $_POST[$k] );
					}	else {
						$hasError = true;
						${$k . 'Error'} = $Erchik;
					}
					${$k . 'put'} .= $ok . "\n";
				$ChBody .= '<tr style="color:#FFF;">'
									. '<td valign="top">'
										. esc_html ( $v['question'] )
									. '</td>'
									. '<td valign="top" align="center">'
										. esc_html ( $ok )
									. '</td>'
									. '<td valign="top" align="center">'
										. ' - '
									. '</td>'
								. '</tr>';
				if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) ) {
					$answers[]	= $ok;
				}
			}	else {
				if ( ( isset($_POST[$k]) && $_POST[$k] !== '' && !VABFWC_Chek_url( $_POST[$k] ) ) || ( !empty( $_POST[$k . 'area'] ) && !VABFWC_Chek_url( $_POST[$k . 'area'] ) ) ) {
					$ok			= '';
					$okArea	= '';
					if ( isset($_POST[$k]) && $_POST[$k] !== '' && !VABFWC_Chek_url( $_POST[$k] ) ) {
						$ok = sanitize_text_field( $_POST[$k] );
					} else {
						$hasError = true;
						${$k . 'Error'} = $Erchik;
					}/*remove so that the field is different without choosing the radio passed*/
					${$k . 'put'} .= $ok . "\n";
					$ChBody .= '<tr style="color:#FFF;">'
										. '<td valign="top">'
											. esc_html ( $v['question'] )
										. '</td>'
										. '<td valign="top" align="center">'
											. esc_html ( $ok )
										. '</td>';
					$okArea .= $ok;
					if ( !empty($_POST[$k . 'area']) && !VABFWC_Chek_url( $_POST[$k . 'area'] ) ) {
						$ChBody .= '<td valign="top" align="center">'
												. sanitize_text_field( $_POST[$k . 'area'] )
										. '</td>'
								. '</tr>';
						$okArea .= " ( ";
						$okArea .= sanitize_text_field( $_POST[$k . 'area'] );
						$okArea .= " )";
					} else if ( !empty($_POST[$k . 'area']) && VABFWC_Chek_url( $_POST[$k . 'area'] ) ) {
						$hasError = true;
						${$k . 'Error'} = $Erchik . '. ' . esc_html__( 'Links not allowed', 'VABFWC' ) . ' !!!';
					}
					if ( empty($_POST[$k . 'area']) ) {
						$ChBody .= '<td valign="top" align="center">'
												. ' - '
										. '</td>'
									. '</tr>';
						// $okArea .= " - ";
					}
					if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) ) {
						$answers[]	= $okArea;
					}
				} else {
					$hasError = true;
					${$k . 'Error'} = $Erchik;
				}
			}
		}
		if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS'] ) && file_exists( $VABFWC_Class->FD . 'csv_logs' ) && $hasError !== true ) {
			$csv_file_add = fopen( $csv_log_report, 'a+' );
			fputcsv( $csv_file_add, $answers, ';' );
			fclose( $csv_file_add );
		}
		$body_Arg							= 	array( /* wp_kses */
			'html'							=>	array(
				'xmlns'						=>	array(),
			),
			'head'							=>	array(),
			'meta'							=>	array(
				'http-equiv'			=>	array(),
				'content'					=>	array(),
				'charset'					=>	array(),
			),
			'title'							=>	array(),
			'h1'								=>	array(
				'style'						=>	array(),
			),
			'body'							=>	array(
				'class'						=>	array(),
				'style'						=>	array(),
			),
			'table'							=>	array(
				'style'						=>	array(),
				'cellspacing'			=>	array(),
				'cellpadding'			=>	array(),
				'border'					=>	array(),
				'align'						=>	array(),
			),
			'tbody'							=>	array(),
			'tr'								=>	array(
				'style'						=>	array(),
			),
			'th'								=>	array(
				'style'						=>	array(),
				'valign'					=>	array(),
			),
			'td'								=>	array(
				'style'						=>	array(),
				'align'						=>	array(),
				'valign'					=>	array(),
			),
			'label'							=>	array(
				'for'							=>	array(),
				'style'						=>	array(),
			),
			'p'									=>	array(
				'style'						=>	array(),
			),
			'a'									=>	array(
				'target'					=>	array(),
				'href'						=>	array(),
				'rel'							=>	array(),
				'style'						=>	array(),
			),
			'br'								=>	array(),
		);
		if ( empty($VABFWC_FORMSA_OPT['VABFWC_NO_SEND_MAIL']) ) {
			$body =	'<html xmlns="http://www.w3.org/1999/xhtml">' .
								'<head>' .
									'<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' .
									'<title>' . $sub . '</title>' .
								'</head>' .
								'<body class="myBody" style="padding:0px;margin:0px;word-break:normal;">' .
									'<table style="background-color:#014266;max-width:100%;min-width:100%;padding:0;width:100%;" width="100%" cellspacing="0" cellpadding="0" border="0">' .
									'<tbody>' .
										'<tr>' .
											'<td valign="middle" align="center">' .
												'<table style="border:0;max-width:600px;padding:0;width:100%;" cellspacing="0" cellpadding="0" border="0" align="center">' .
													'<tbody>' .
														'<tr>' .
															$tdIn .
															'<td style="padding-bottom:50px;padding-top:30px;" align="center">' .
																'<p style="color:#FFF;font-size:20px;font-style:normal;font-weight:100;line-height:24px;margin-bottom:0;margin-top:0;padding-bottom:10px;">' .
																	'<h1 style="color:#FFF;font-size:20px">' . $Titla . '</h1>' .
																'</p>' .
																'<table style="border:0;max-width:600px;padding:0;width:100%;" cellspacing="2" border="1" cellpadding="5">' .
																	'<tbody>' .
																		'<tr style="text-align:center;color:#FFF;">' .
																			'<th ' . $sty . ' valign="top">' .
																				'<p style="padding:4px;">' . $Qw .
																			'</th>' .
																			'<th ' . $sty . ' valign="top">' .
																				'<p style="padding:4px;">' . $Ans .
																			'</th>' .
																			'<th ' . $sty . ' valign="top">' .
																				'<p style="padding:4px;">' . $Oth .
																			'</th>' .
																		'</tr>' .
																		$ChBody .
																	'</tbody>' .
																'</table>' .
																'<table cellspacing="0" cellpadding="0">' .
																	'<tbody>' .
																			'<tr style="text-align:center;">' .
																				'<td colspan="2" valign="top">' .
																					'<p style="color:#FFF;font-size:14px;"> ' . $IP . ' </p>' .
																				'</td>' .
																			'</tr>' .
																			'<tr style="text-align:center;">' .
																				'<td style="padding:4px;font-size:14px;color:#FFF;" valign="top" align="center">' .
																					$AVT .
																				'</td>' .
																			'</tr>' .
																	'</tbody>' .
																'</table>' .
															'</td>' .
															$tdIn .
														'</tr>' .
													'</tbody>' .
												'</table>' .
											'</td>' .
										'</tr>' .
									'</tbody>' .
								'</table>' .
							'</body>' .
						'</html>';
			$body 												=	wp_kses( $body, $body_Arg );
		}
		$validate_VABFWC							=	apply_filters( 'VABFWC_validate_filter', false );
		if ( $validate_VABFWC != false ) {
			$hasError										= true;
		}
		$CheckFieldsEror							=	$VABFWC->CheckFields();
		if ( $CheckFieldsEror == true ) {
			$hasError										= true;
		}
		$attachment 									= array();
		if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_AddFile'] ) ) {
			for( $i = 0, $iC = count( $_FILES['VABFWC_file']['name'] ); $i < $iC; $i++ ) {
				if ( is_uploaded_file( $_FILES['VABFWC_file']['tmp_name'][$i] ) && validate_file( $_FILES['VABFWC_file']['name'][$i] ) === 0 ) {
					$vab 										= $i+1;
					$vabContent[$i] 				= chunk_split( base64_encode( file_get_contents( esc_html( $_FILES['VABFWC_file']['tmp_name'][$i] ) ) ) );
					$vabFilesName[$i]				= sanitize_file_name( $_FILES['VABFWC_file']['name'][$i] );
					$fileInfo = wp_check_filetype( basename( $_FILES['VABFWC_file']['name'][$i] ) );
					if ( ! empty( $fileInfo['ext'] ) && is_uploaded_file( $_FILES['VABFWC_file']['tmp_name'][$i] ) ) { /* This file is valid and file uploaded using HTTP POST */
						$FILES_tmp_name[$i]			= $_FILES['VABFWC_file']['tmp_name'][$i];
						$FILES_type[$i]					= sanitize_mime_type( $_FILES['VABFWC_file']['type'][$i] );
						$FILES_size[$i]					= intval( $_FILES['VABFWC_file']['size'][$i] );
						$FILES_size_Mb[$i]			= intval( $FILES_size[$i] )/1024/1024;
						$ext[$i]								=	substr( $vabFilesName[$i], strpos( $vabFilesName[$i], '.' ), strlen( $vabFilesName[$i] ) - 1 );
						if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_AddFileMulti'] ) ) {
							$VABFWC_SizeSum 		 += $FILES_size[$i];
						}
						if ( $FILES_size[$i] > 1024 * $F_S_M * 1024 ) {
							$FileSendErorSize		 .= '<span class="er">***</span>' . esc_html__(' One or more files exceed the allowed size ', 'VABFWC') . '' . $F_S_M . '' . esc_html__(' Мб','VABFWC') . '<br />';
							$FileSendErorSizeInf .= '<br />' . $vabFilesName[$i] . ' : ' . $SiZeS . ' - ' . $FILES_size[$i] . " / " . $FILES_size_Mb[$i] . '<br />';
							$hasError 						= true;
						}
						if( is_array( $VABFWC_EXT ) && sizeof($VABFWC_EXT) !== 0 && ! in_array( str_replace( '.', '', $ext[$i] ), $VABFWC_EXT ) ){
							$FileSendErorSize		 .= '<span class="er">***</span>' . esc_html__(' One or more files are not in a valid format', 'VABFWC') . '<br />';
							$FileSendErorSizeInf .= '<br />' . esc_html__('File', 'VABFWC') . ' ' . $vabFilesName[$i];
							$FileSendErorSizeInf .= ' ' . esc_html__('have extension', 'VABFWC') . ' - ' . $ext[$i] . '<br />';
							$hasError 						= true;
						}
						if ( $hasError !== true ) {
							if ( ! file_exists( $VABFWC_TEMP ) ) {
								mkdir( $VABFWC_TEMP, 0755, true );
							}
							move_uploaded_file( $FILES_tmp_name[$i], $VABFWC_TEMP . '/' . basename( $vabFilesName[$i] ) );
							$attachment[]					= $VABFWC_TEMP . '/' . basename( $vabFilesName[$i] );
						}
					}
				}
			}
					if ( ! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_AddFileMulti'] ) && $VABFWC_SizeSum > 1024 * $F_S_M * 1024 ) {
						$FileSendErorSize		 .= '<span class="er">***</span>' . esc_html__(' The total size of files exceeds the allowed size ', 'VABFWC') . '' . $F_S_M . '' . esc_html__(' Мб','VABFWC') . '<br />';
						$hasError 						= true;
					}
		}
		if ( $hasError !== true ) {
			if ( ! empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDi']) ) {
				foreach( $VABFWC_FORMSA as $k => $v ) {
					if ( !empty(${$k . 'put'}) ) {
						file_put_contents( $VABFWC_Class->$k, ${$k . 'put'}, FILE_APPEND );
					}
				}
				if ( empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDate']) || empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoIP']) || empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoAgent']) ) {
					$mDATEp 	= empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDate']) ? date("r") . "\n" : " - \n";
					file_put_contents( $VABFWC_Class->mDATE, $mDATEp, FILE_APPEND );
					$mIPp 		= empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoIP']) ? sanitize_text_field( $GLOBALS['VABFWC_IP'] ) . "\n" : " - \n";
					file_put_contents( $VABFWC_Class->mIP, $mIPp, FILE_APPEND );
					$AGENTp		= empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoAgent']) ? sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) . "\n" : " - \n";
					file_put_contents( $VABFWC_Class->mAGENT, $AGENTp, FILE_APPEND );
				}
			}
			if ( empty($VABFWC_FORMSA_OPT['VABFWC_NO_SEND_MAIL']) ) {
				$ADMEm    = get_option('admin_email');
				$ADMEm    = sanitize_email( $ADMEm );
				$emailTo	= $VABFWC_FORMSA_OPT && !empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_MAIL']) ? $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_MAIL'] : get_option('admin_email');
				$emailTo	= sanitize_email( $emailTo );
				$headers	= "From:" . $emailTo . "\r\n";
				$headers .= "Reply-To: " . $ADMEm . "\r\n";
				$headers .= "List-Unsubscribe:<mailto:" . $ADMEm . "?subject=unsubscribe>\r\n";
				if ( $VABFWC_FORMSA_OPT && !empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_MAIL']) && !empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_MAIL_Copy']) ) {
					$headers .= "Bcc: " . $ADMEm . " <" . $ADMEm . ">\r\n";
				}
				if ( !empty($VABFWC_USER_SEND_MAIL) && !empty($VABFWC_FORMSA_OPT['VABFWC_USER_SEND_MAIL']) ) {
					$headers .= "Cc: " . $VABFWC_USER_SEND_MAIL . " <" . $VABFWC_USER_SEND_MAIL . ">\r\n";
				}
				$headers .= "Content-Type:text/html; charset=\"utf-8\"\r\n";
				$headers .= "X-WPVABFWC-Content-Type: text/html\n";
				wp_mail( $emailTo, $sub, $body, $headers, $attachment );
			}
			if ( file_exists( $VABFWC_TEMP ) ) {
				dirDel( $VABFWC_TEMP );
			}
			$emailSent = true;
		}
	}
		/* FINISH OF HANDLER */
	} else {
		return '<div class="contact_message"><h5>' . esc_html__( 'Data array is empty', 'VABFWC' ) . '</h5></div>';
	}
	$VABFWC_CHEK_ROLES					= VABFWC_CHEK_ROLES( $id );
	$VABFWC_CHEK_OPT_ROLES			= VABFWC_CHEK_OPT_ROLES( $id );
	$VABFWC_CHEK_CSV_ROLES			= VABFWC_CHEK_CSV_ROLES( $id );
	$VABFWC_CHEK_CSV_OPT_ROLES	= VABFWC_CHEK_CSV_OPT_ROLES( $id );
	$placeHolder								= __( 'Text input field...', 'VABFWC' );
	$HolderPlus									= esc_html__( 'Write your answer', 'VABFWC' );
	$sentYN											= '';
	$SentY											= esc_html__( 'Your message was successfully sent', 'VABFWC' ) . '!';
	$SentN											= esc_html__( 'Message not sent', 'VABFWC' ) . '!';
	$ResF												= "";
	$ResFY											= (	empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDi'])	) ||
																(	!empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_HideDi']) && empty($VABFWC_CHEK_ROLES) ) ||
																(	!empty($VABFWC_CHEK_OPT_ROLES) && empty($VABFWC_CHEK_ROLES) ) ? '' :
																( ( ( !empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_ShowDi']) && empty($VABFWC_CHEK_OPT_ROLES) ) ||
																(	!empty($VABFWC_CHEK_ROLES) ) ) ? esc_html__( 'The results are displayed at the end of the questionnaire', 'VABFWC' ) . '!' : esc_html__( 'Results will be displayed after filling out and sending the questionnaire', 'VABFWC' ) . '!' );
	if ( isset($emailSent) && $emailSent == true ) {
		$sentYN		= $SentY;
		$ResFY		= $ResF;
		if ( empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDi']) ) {
			ECHO '<div class="contact_message"><span class="VABFWCotrazhenie" title="' . esc_attr( $sentYN ) . '">' . esc_html( $sentYN ) . '</span></div>';
		}
		$message_after_VABFWC = apply_filters( 'VABFWC_message_after_filter', false );
		if ( !empty($message_after_VABFWC) ) {
			ECHO wp_kses_post( $message_after_VABFWC );
		}
	} else {
		if ( isset($hasError) ) {
			$sentYN	= $SentN;
			$message_VABFWC = apply_filters( 'VABFWC_message_filter', false );
		}
		ECHO	'<div class="contact_message"><span class="VABFWCotrazhenie" title="' . esc_attr( $sentYN ) . '">' . esc_html( $sentYN ) . '</span><br>',
					esc_html( $message_VABFWC ),
					'<h5>' . esc_html( $ResFY ) . '</h5></div><br>';
		ECHO '<div id="anketa">',
				 '<form ' . $form_id . $VABFWC_multipart . ' class="FormS FormSContact' . $form_class . '" action="' . esc_url( get_the_permalink() ) . '" method="post">';
		ECHO '<div id="UlLi">';
		foreach( $VABFWC_FORMSA as $k => $v ) {
		ECHO '<fieldset><legend>&nbsp;&nbsp;' . esc_html( $v['question'] ) . ': &nbsp;&nbsp;</legend><ul class="' . esc_attr( $k ) . '_ul">';
		if ( ${$k . 'Error'} != '' ) {
			ECHO '<div class="errors"><span class="er">***</span> ' . esc_html( ${$k . 'Error'} ) . '</div>';
		}
		if ( $v['type'] == 'text' ) {
			$isset = isset($_POST[$k]) ? sanitize_text_field( $_POST[$k] ) : '';
			ECHO	'<li class="' . esc_attr( $k ) . '_li" tabindex="0">',
							'<input size="33" type="text" id="' . esc_attr( $k ) . '" name="' . esc_attr( $k ). '" placeholder="' . esc_html( $placeHolder ) . '" value="' . esc_attr( $isset ) . '">',
						'</li>';
		}
		if ( $v['type'] == 'url' ) {
			$isset = isset($_POST[$k]) ? sanitize_text_field( $_POST[$k] ) : '';
			ECHO	'<li class="' . esc_attr( $k ) . '_li" tabindex="0">',
							'<input size="33" type="url" id="' . esc_attr( $k ). '" name="' . esc_attr( $k ). '" title="' . esc_html__( 'URL input field', 'VABFWC' ) . '" placeholder="' . esc_html( $placeHolder ) . '" value="' . esc_url( $isset ) . '">',
						'</li>';
		}
		if ( $v['type'] == 'tel' ) {
			$isset = isset($_POST[$k]) ? sanitize_text_field( $_POST[$k] ) : '';
			ECHO	'<li class="' . esc_attr( $k ) . '_li" tabindex="0">',
							'<input size="33" type="tel" id="' . esc_attr( $k ). '" name="' . esc_attr( $k ). '" title="' . esc_html__( 'Phone input field', 'VABFWC' ) . '" placeholder="'.esc_html( $placeHolder ).'" value="' . esc_attr( $isset ) . '">',
						'</li>';
		}
		if ($v['type'] == 'email' ) {
			$isset = isset($_POST[$k]) ? sanitize_text_field( $_POST[$k] ) : '';
			ECHO	'<li class="' . esc_attr( $k ) . '_li" tabindex="0">',
							'<input size="33" type="email" id="' . esc_attr( $k ). '" name="' . esc_attr( $k ). '" title="' . esc_html__( 'Email input field', 'VABFWC' ) . '" placeholder="'.esc_html( $placeHolder ).'" value="' . esc_attr( $isset ) . '">',
						'</li>';
		}
		if ( $v['type'] == 'date' ) {
			$isset = isset($_POST[$k]) ? sanitize_text_field( $_POST[$k] ) : '';
			ECHO	'<li class="' . esc_attr( $k ) . '_li" tabindex="0">',
							'<input size="33" type="date" id="' . esc_attr( $k ). '" name="' . esc_attr( $k ). '" title="' . esc_html__( 'Input field type «Date»', 'VABFWC' ) . '" placeholder="'.esc_html( $placeHolder ).'" value="' . esc_attr( $isset ) . '">',
						'</li>';
		}
		if ( $v['type'] == 'number' || $v['type'] == 'range' ) {
			$isset		= isset($_POST[$k]) ? sanitize_text_field( intval( $_POST[$k] ) ) : '';
			$TyPe			= $v['type'] == 'number' 	? 'number' : 'range';
			$titles		= $TyPe == 'range' 				? __( 'Input field type «Range»', 'VABFWC' ) : __( 'Input field type «Number»', 'VABFWC' );
			$ScRiPt		= $TyPe == 'range' 				? 'onchange=document.getElementById("'.$k.'_s").innerHTML=this.value' : '';
			$mIn			= !empty($v['min']) 			? $v['min'] : '1';
			$mAx			= !empty($v['max']) 			? $v['max'] : '100';
			$sTEp			= !empty($v['step']) 			? $v['step'] : '1';
			ECHO	$TyPe == 'range' ? '<span id="' . esc_attr( $k . '_s' ) . '">' . esc_html( $isset ) . '</span>' : '' .
						'<li class="' . esc_attr( $k ) . '_li" tabindex="0">',
							'<input size="33" type="' . esc_attr( $TyPe ) . '" id="' . esc_attr( $k ). '" ' . esc_js( $ScRiPt ) .' name="' . esc_attr( $k ). '" title="' . esc_html( $titles ) . '" min="' . esc_attr( $mIn ) . '"  max="' . esc_attr( $mAx ) . '" step="' . esc_attr( $sTEp ) .'" value="' . esc_attr( $isset ) . '">',
						'</li>';
		}
		if ( $v['type'] == 'textarea' ) {
			$isset = isset($_POST[$k]) ? sanitize_text_field( $_POST[$k] ) : '';
			ECHO '<li class="' . esc_attr( $k ) . '_li" tabindex="0">',
							'<label for="' . esc_attr( $k ) . '">&nbsp;</label>',
							'<textarea id="' . esc_attr( $k ) . '" name="' . esc_attr( $k ) . '" rows="4" cols="40" placeholder="' . esc_html( $placeHolder ) . '" value="">',
								esc_html( $isset ),
							'</textarea>',
						'</li>';
		}
		if ( $v['type'] == 'radio' || $v['type'] == 'checkbox' || $v['type'] == 'select' ) {
			$coanswer = count( $v['answer'] );
			if ( $v['type'] == 'select' ) {
				ECHO	'<li class="' . esc_attr( $k ) . '_li" tabindex="0">',
								'<select name="' . esc_attr( $k ) . '" title="' . esc_html__( 'Input field type «Dropdown list»', 'VABFWC') . '">',
									'<option name="' . esc_attr( $k ) . '" value="default">',
										esc_html__( 'Choose a variant', 'VABFWC' ),
									'</option>';
			}
			for( $ii = 0; $ii < $coanswer; $ii++ ) {
				$isset = '';
				$name = $v['type'] == 'radio' || $v['type'] == 'select' ? $k : $k . $ii;
				if ( $v['type'] == 'checkbox' ) {
					$isset = isset($_POST[$name]) ? 'checked="checked"' : '';
				}
				if ( $v['type'] == 'radio' ) {
					$isset = isset($_POST[$name]) && $_POST[$name] == $v['answer'][$ii] ? 'checked="checked"' : '';
				}
				if ( $v['type'] == 'select' ) {
					$isset = isset($_POST[$name]) && $_POST[$name] == $v['answer'][$ii] ? 'selected="selected"' : '';
					ECHO	'<option name="' . esc_attr( $name ) . '" title="' . esc_attr( $v['answer'][$ii] ) . '" ' . esc_attr( $isset ) . ' value="' . esc_attr( $v['answer'][$ii] ) . '">' . esc_html( $v['answer'][$ii] ) . '</option>';
				} else {
					ECHO	'<li class="' . esc_attr( $k . $ii ) . '_li" tabindex="0">',
									'<label for="' . esc_attr( $k . 'id' . $ii ) . '">',
										'<input id="' . esc_attr( $k . 'id' . $ii ) . '" type="' . esc_attr( $v['type'] ) . '" name="' . esc_attr( $name ) . '" ' . esc_attr( $isset ) . ' title="' . esc_attr( $v['answer'][$ii] ) . '" value="' . esc_attr( $v['answer'][$ii] ) . '"/>',
										esc_html( $v['answer'][$ii] ),
									'</label>',
								'</li>';
				}
			}
			if ( $v['type'] == 'select' ) {
				ECHO		'</select>',
							'</li>';
			}
			if ( $v['type'] == 'radio' && $v['plusArea'] == 'yes' ) {
				$isset = isset($_POST[$k]) && $_POST[$k] == esc_html__( 'Other', 'VABFWC' ) ? 'checked="checked"' : '';
				$issett = isset($_POST[$k . 'area']) ? sanitize_text_field( $_POST[$k . 'area'] ) : '';
				ECHO	'<li class="vabfwc_click ' . esc_attr( $k ) . '_li" tabindex="0">',
								'<label for="' . esc_attr( $k ) . '">',
									'<input id="' . esc_attr( $k ) . '" type="' . esc_attr( $v['type'] ) . '" name="' . esc_attr( $k ) . '" ' . esc_attr( $isset ) . ' title="' . esc_html__( 'Other', 'VABFWC' ) . '" value="' . esc_html__( 'Other', 'VABFWC' ) . '"/>',
									esc_html__('Other','VABFWC'),
								'</label>',
								'<textarea id="' . esc_attr( $k ) . 'area" name="' . esc_attr( $k ) . 'area" rows="4" cols="40" placeholder="' . esc_html( $placeHolder ) . '" value="">',
									esc_html( $issett ),
								'</textarea>',
							'</li>';
			}
		}
		ECHO '</ul></fieldset>';}
		if ( ! empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_AddFile']) ) {
			$VABFWC_multiple = ! empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_AddFileMulti']) ? 'multiple' : '';
			ECHO	'<fieldset>';
			if ( $FileSendErorSize != '' ) {
				$FileSendErorSize_arg			= 	array(
								'span'						=>	array(
									'class'					=>	array(),
								),
								'br'							=>	array(),
							);
				$FileSendErorSizeInf_arg	= 	array(
								'br'							=>	array(),
							);
				ECHO	'<span class="er">***</span>' . esc_html__(' Sorry, the message was not sent.', 'VABFWC') . '<br />',
							wp_kses( $FileSendErorSize, $FileSendErorSize_arg ),
							wp_kses( $FileSendErorSizeInf, $FileSendErorSizeInf_arg );
			}
			ECHO	'<label for="VABFWC_file" class="VABFWC_fileL">' . esc_html__( 'Select files', 'VABFWC') . '</label>',
						! empty( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_EXT'] ) ? esc_html__( 'Valid File Format', 'VABFWC' ) .
						': ' . str_replace( array( " ", "." ), " ", esc_html( $VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_EXT'] ) ) : '',
						'<input type="file" name="VABFWC_file[]" class="VABFWC_file" id="VABFWC_file" ' . esc_attr( $VABFWC_multiple ) . ' required />',
						'<div id="UploadServerInfo">',
						'</div>',
						'</fieldset>';
		}
		ECHO '</div>';
		$fields_VABFWC = apply_filters( 'VABFWC_fields_filter', false );
		if ( $fields_VABFWC != false ) {
			ECHO wp_kses( $fields_VABFWC, $VABFWC_Prot_Arg );
		}
		ECHO wp_kses( $VABFWC->FieldS(), $VABFWC_Prot_Arg ) .
						'<input id="anketaSbros" type="reset" name="profilereset_' . $id . '" value="' . esc_attr__( 'Resetting the filled fields', 'VABFWC') . '">',
						'&nbsp;&nbsp;&nbsp;&nbsp;',
						'<input id="anketaSend" type="submit" name="profilesubmit" value="' . esc_attr__( 'Send', 'VABFWC') . '">',
						'<input type="hidden" name="submitted_' . $id . '" id="submitted" value="true" />',
					'</form>',
					'</div>';
	}
	if ( ( empty($VABFWC_CHEK_CSV_OPT_ROLES) || ! empty($VABFWC_CHEK_CSV_ROLES) ) &&
			 ! empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_CSV_LOGS']) &&
			 file_exists( $VABFWC_Class->FD . 'csv_logs' ) ) {
		$csv_table_arg				= 	array( /* wp_kses */
			'br'								=>	array(),
			'center'						=>	array(),
			'div'								=>	array(
				'class'						=>	array(),
				'tabindex'				=>	array(),
			),
			'table'							=>	array(
				'style'						=>	array(),
			),
			'tr'								=>	array(),
			'td'								=>	array(),
			'a'									=>	array(
				'target'					=>	array(),
				'href'						=>	array(),
			),
		);
		$csv_logs 						= $VABFWC_Class->FD . 'csv_logs';
		$csv_logs_Dir					= scandir( $csv_logs );
		$getFileProtect				= 'HNUv6Q8YO4u8hTfhs6e5';
		$csv_table						= '';
		$csv_table .=	'<br><center>
									 <div class="vabfwc_spoiler-wrap">
										<div class="vabfwc_spoiler-head folded" tabindex="0">' . esc_html__('CSV log files', 'VABFWC') . '</div>
											<div class="vabfwc_spoiler-body">
												<table style="width:100%;text-align:center;">';
		$PostW					=	get_post();
		$Link						=	$PostW->guid;
		foreach( $csv_logs_Dir as $file ) {
				if ( $file != "." &&
						 $file != ".."  &&
						 $file != '.htaccess' &&
						 $file != 'index.php' ) {
						 $name	= basename( $file, ".csv" );
				$my_file		= $name;
				$my_type		=	'csv_logs';
				$ouCh				= hash( 'sha1', $id . '&' . $my_file . '&' . $my_type . '&' . $getFileProtect );
				$GetLink		=	$Link . '&id=' . $id . '&my_file=' . $my_file . '&my_type=' . $my_type . '&hash=' . $ouCh;
				$csv_table .=	'<tr>
												<td>' . $name . '</td>
												<td>
													<a target="_blank" href="' . esc_url( $GetLink ) . '">' . esc_html__( 'Download', 'VABFWC' ) . '</a>
												</td>
											 </tr>';
				}
			}
		$csv_table .=	'			</table>
											</div>
										</div>
										</center>';
		echo wp_kses( $csv_table, $csv_table_arg );
	}
	if ( ! empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_NoDi']) ) {
		if ( $sentYN == $SentY || is_user_logged_in() && current_user_can( 'administrator' ) ) {
			ECHO	'<form class="FormS FormSContact" action="' . esc_url( get_the_permalink() ) . '" method="post">';
				if ( isset($_POST['submitres']) && $hasErrorAd !== true ) {
					$sentYN = esc_html__( 'Table deleted successfully', 'VABFWC' ) . ' !';
				}
			ECHO	'<div class="contact_message"><span class="VABFWCotrazhenie" title="' . esc_attr( $sentYN ) . '">' . esc_html( $sentYN ) . '</span></div>';
			if ( !empty($VABFWC_FORMSA) ) {
				ECHO !empty( $hasErrorAdMassage ) ? '<br /><span class="er">***</span> ' . esc_html( $hasErrorAdMassage ) . '<br />' : '';
				$VABFWC = new VABFWC_Class_Adm( $id );
				ECHO	'<br>' . wp_kses( $VABFWC->ShoW(), $Class_Adm_Arg );
			}
				ECHO	wp_kses( $VABFWC_AD->FieldS(), $VABFWC_Prot_Arg ) .
							'<input type="hidden" name="submitres" id="submitres" value="true" />';
			ECHO	'</form>';
		}
		if (	!empty($VABFWC_FORMSA) &&
					(
						(	$sentYN == $SentY && empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_HideDi']) && empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_ShowDi']) && empty($VABFWC_CHEK_OPT_ROLES) ) ||
						( $sentYN != $SentY && !empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_ShowDi']) && empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_HideDi']) && empty($VABFWC_CHEK_OPT_ROLES) ) ||
						( $sentYN != $SentY && !empty($VABFWC_CHEK_ROLES) )
					)
				) {
			$VABFWC = new VABFWC_Class_Graphic( $id );
			ECHO	wp_kses( $VABFWC->ShoW(), $Class_Graphic_Arg );
		}
	}
	$GLOBALS['vabfwc']++;
	return ob_get_clean();
	}
}
/********************************
****CREATE SHORTCODE FOR GRAPHIC
*********************************/
add_shortcode( "VABFWC_Graphic", "vabfwc_short_Graphic" );
if ( ! function_exists( 'vabfwc_short_Graphic' ) ) {
	function vabfwc_short_Graphic( $atts ) {
		ob_start();
		$id													= ! empty( $atts['id'] ) 				? intval( $atts['id'] ) : '';
		$VABFWC_CHEK_ROLES					= VABFWC_CHEK_ROLES( $id );
		$VABFWC_CHEK_OPT_ROLES			= VABFWC_CHEK_OPT_ROLES( $id );
		$VABFWC_CHEK_CSV_ROLES			= VABFWC_CHEK_CSV_ROLES( $id );
		$VABFWC_CHEK_CSV_OPT_ROLES	= VABFWC_CHEK_CSV_OPT_ROLES( $id );
		$short_class								= ! empty( $atts['class'] )			? 'class="' . sanitize_text_field( $atts['class'] ) . '"' : '';
		$short_tag									= ! empty( $atts['tag'] ) 			? sanitize_text_field( $atts['tag'] ) : '';
		$short_tags_st							= ! empty( $short_tag )					? '<' . sanitize_text_field( $short_tag ) . ' ' . $short_class . '>' : '';
		$short_tag_end							= ! empty( $short_tag )					? '</' . sanitize_text_field( $short_tag ) . '>' : '';
		$short_title								= ! empty( $atts['title'] ) 		? $short_tags_st . sanitize_text_field( $atts['title'] ) . $short_tag_end : '';
		$title_Arg									= 	array( /* wp_kses */
			'h1'											=>	array(
				'class'									=>	array(),
			),
			'h2'											=>	array(
				'class'									=>	array(),
			),
			'h3'											=>	array(
				'class'									=>	array(),
			),
			'h4'											=>	array(
				'class'									=>	array(),
			),
			'h5'											=>	array(
				'class'									=>	array(),
			),
			'h6'											=>	array(
				'class'									=>	array(),
			),
			'div'											=>	array(
				'class'									=>	array(),
			),
			'p'												=>	array(
				'class'									=>	array(),
			),
			'center'									=>	array(
				'class'									=>	array(),
			),
		);
		ECHO	wp_kses( $short_title, $title_Arg );
		$Class_Graphic_Arg		= 	array( /* wp_kses */
			'div'								=>	array(
				'class'						=>	array(),
				'style'						=>	array(),
			),
			'br'								=>	array(),
			'center'						=>	array(),
			'style'							=>	array(
				'type'						=>	array(),
			),
			'span'							=>	array(
				'class'						=>	array(),
				'style'						=>	array(),
			),
		);
		$VABFWC = new VABFWC_Class_Graphic( $id );
		ECHO	wp_kses( $VABFWC->ShoW(), $Class_Graphic_Arg );
		return ob_get_clean();
	}
}