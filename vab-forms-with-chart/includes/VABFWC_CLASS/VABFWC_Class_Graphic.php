<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
#[AllowDynamicProperties]
class VABFWC_Class_Graphic extends VABFWC_Class {
	function __construct( $PostID ) {
		parent::__construct( $PostID );
	}
	function ShoW() {
		$chek_file							= true;
		$VABFWC_FORMSA					= get_post_meta( $this->PostID, 'VABFWC_FORM', true );
		$VABFWC_FORMSA_OPT			= get_post_meta( $this->PostID, 'VABFWC_FORM_OPT', true );
		if ( !empty($VABFWC_FORMSA) ) {
			$VABFWC_FORMSA				= vabfwc_sanitize_text_field( $VABFWC_FORMSA[$this->PostID] );
		}
		$AnswerCount						= 0;
		$countmassivfile				= 0;
		$AnswerCountchec				= 0;
		$total									= array();
		$otv										= esc_html__( 'Answers to the question', 'VABFWC' );
		$Ans										= esc_html__( 'Answers', 'VABFWC' );
		foreach( $VABFWC_FORMSA as $k => $v ) {
			if ( file_exists( $this->$k ) ) {
				if ( $v['type'] == 'radio' || $v['type'] == 'select' ) {
					$coanswer			  	= count( $v['answer'] );
					$massivfile		  	= file( $this->$k );
					$countmassivfile	= count( $massivfile );
					$total[]				 .= $countmassivfile;
					for( $i = 0; $i < $coanswer; $i++ ) {
						${$k . 'Count_' . $i} = 0;
						${$k . '_' . $i} = sanitize_text_field( $v['answer'][$i] ) . "\n";
						if ( is_array( $massivfile ) ) {
							foreach( $massivfile as $kf ) {
								if ( $kf === ${$k . '_' . $i} ) {
									${$k . 'Count_' . $i}++;
									$AnswerCount++;
								}
							}
						}
							$ii = $i + 1;
							if ( $countmassivfile == 0 ) {
								$countmassivfile = 1;
							}
							if ( ! defined( sanitize_text_field( $k . $ii . 'Per' ) ) ) {
								define( sanitize_text_field( $k . $ii . 'Per' ), round( intval( ${$k . 'Count_' . $i} ) * 100 / intval( $countmassivfile ), 1 ) );
							}
					}
					if ( $v['type'] !== 'select' && $v['plusArea'] == 'yes' ) {
						$coanswer++;
						${$k . 'Count_' . $coanswer}	= 0;
						${$k . '_' . $coanswer}				= esc_html__( 'Other', 'VABFWC' ) . "\n";
						if ( is_array( $massivfile ) ) {
							foreach( $massivfile as $kf ) {
								if ( $kf === ${$k . '_' . $coanswer} ) {
									${$k . 'Count_' . $coanswer}++;
									$AnswerCount++;
								}
							}
						}
					}
					$Every = !empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_TotaL_Every_circ']) ? '<span>' . sanitize_text_field( $otv ) . ' - ' . intval( $countmassivfile ) . '</span>':'';
					$Every_Arg						= 	array( /* wp_kses */
						'span'							=>	array(),
					);
					echo "<br><center><legend><h4> › " . esc_html( $v['question'] ) . ":</h4></legend>" . wp_kses( $Every, $Every_Arg ) . '<br>';
					for( $i = 0; $i < $coanswer; $i++ ) {
			//////**********//////
						$preTot		= '';
						$totAns 	= '';
						$totAnsO	= '';
						if ( !empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_Tot_Ev_cir_Ans']) ) {
							$preTot 	= ' ( ' . $Ans . ' - ';
							$totAns  .= '0';
							$totAnsO .= '0';
							$searchefile		  	= file( $this->$k );
							$countsearchefile 	= count( $searchefile );
							for( $us = 0; $us < $countsearchefile; $us++ ) {
								if ( ! empty($searchefile[$us]) ) {
									if ( isset($v['answer'][$i]) ) {
										if ( $v['answer'][$i] . "\n" == $searchefile[$us] ) {
											$totAns++;
										}
									}
									if ( esc_html__( 'Other', 'VABFWC' ) . "\n" ==  $searchefile[$us] ) {
										$totAnsO++;
									}
								}
							}
							$totAns 	.= ' )';
							$totAnsO 	.= ' )';
						}
			//////**********//////
						if ( isset($v['answer'][$i]) ) {
							echo '<center>' . esc_html( $v['answer'][$i] ) . ' - <span class="cub" style="background-color:' . esc_html( $v['color'][$i] ) . ';"></span>&nbsp;&nbsp; ' . $preTot . $totAns . '</center>';
						} else {
							echo '<center>' . esc_html__( 'Other', 'VABFWC' ) . ' - <span class="cub" style="background-color:#A8A8A8;"></span>&nbsp;&nbsp; ' . $preTot . $totAnsO . '</center>';}}
					echo "</center><br>";
					for( $i = 0; $i < $coanswer; $i++ ) {
						${$k . 'Count_' . $i} = 0;
						if ( isset($v['answer'][$i]) ) {
						${$k . '_' . $i} = sanitize_text_field( $v['answer'][$i] ) . "\n";
						$color = $v['color'][$i];
							if ( is_array( $massivfile ) ) {
								foreach( $massivfile as $kf ) {
									if ( $kf === ${$k . '_' . $i} ) {
										${$k . 'Count_' . $i}++;
									}
								}
							}
							$per = round( intval( ${$k . 'Count_' . $i} ) * 100 / intval( $countmassivfile ), 1 );
						}
						if ( $v['type'] !== 'select' && $v['plusArea'] == 'yes' && $i < $coanswer && !isset($v['answer'][$i]) ) {
							${$k . 'Count_' . $coanswer} = 0;
							${$k . '_' . $coanswer} = esc_html__( 'Other', 'VABFWC' ) . "\n";
							if ( is_array( $massivfile ) ) {
								foreach( $massivfile as $kf ) {
									if ( $kf === ${$k . '_' . $coanswer} ) {
										${$k . 'Count_' . $coanswer}++;
									}
								}
							}
							$perAr = round( intval( ${$k . 'Count_' . $coanswer} ) * 100 / intval( $countmassivfile ), 1 );
							if ( ! defined( sanitize_text_field( $k . $coanswer . 'Per' ) ) ) {
								define( sanitize_text_field( $k . $coanswer . 'Per' ), $perAr );
							}
						}
					}
					$this->VABFWC_Class( sanitize_text_field( $k ), intval( $coanswer ) );
				}
				if ( $v['type'] == 'checkbox' ) {
					echo	"<br><center><legend><h4> › " . esc_html( $v['question'] ) . ":</h4></legend><span style=\"display:none;\">" . esc_html( $otv ) . ' - ' . esc_html( $countmassivfile ) ."</span><br></center>";
					$coanswerchec						= count( $v['answer'] );
					$massivfilechec					= file( $this->$k );
					$countmassivfilechec		= count( $massivfilechec );
					for( $i = 0; $i < $coanswerchec; $i++ ) {
						${$k . 'Countchec_' . $i} = 0;
						${$k . 'C_' . $i} = sanitize_text_field( $v['answer'][$i] ) . "\n";
						if ( is_array( $massivfilechec ) ) {
							foreach( $massivfilechec as $kfchec ) {
								if ( $kfchec === ${$k . 'C_' . $i} ) {
									${$k . 'Countchec_' . $i}++;
									$AnswerCountchec++;
								}
							}
						}
						ECHO	'<center>' . esc_html( ${$k.'C_'.$i} ) . ' - <span class="cub " style="background-color:' . esc_html( $v['color'][$i] ) . ';"></span>&nbsp;&nbsp;</center>';
					}
					echo '<br><br><br><br><center><div class="Dynamic_chart ' . esc_html( $k ) . '">';
					for( $i = 0; $i < $coanswerchec; $i++ ) {
						$ic = $i + 1;
						echo	'<div class="Dynamic_bar bar_' . esc_html( $k . $ic ) . '" style="background-color:' . esc_html( $v['color'][$ic-1] ) . ';"></div>';
					}
					echo	'</div></center><br><br><br>';?>
					<style type="text/css">
						.<?php	echo esc_html( $k );?> {
							grid-template-areas:'<?php
							for( $i = 0; $i < $coanswerchec; $i++ ) {
								$ii = $i + 1;
								echo esc_html( 'bar_'.$k.$ii.' ' );
							}
						?>';
							grid-template-columns:<?php
							for( $i = 0; $i < $coanswerchec; $i++ ) {
								$ii = $i + 1;
								echo esc_html( '1fr ' );
							}
						?>;
						}
						<?php
						for( $i = 0; $i < $coanswerchec; $i++ ) {
							${$k . 'Countchec_' . $i} = 0;
							$ii = $i + 1;
							if ( is_array( $massivfilechec ) ) {
								foreach( $massivfilechec as $kfchec ) {
									if ( $kfchec === ${$k . 'C_' . $i} ) {
										${$k . 'Countchec_' . $i}++;
									}
								}
							}
							if ( $countmassivfilechec == 0) {
								$countmassivfilechec = 1;
							}
							$Per = round( intval( ${$k . 'Countchec_' . $i} ) * 100 / intval( $countmassivfilechec ), 1 );
							$EveryCh = empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_TotaL_Every_ceck']) ? '(' . intval( ${$k . 'Countchec_' . $i} ) . ')' : '';
							echo	'.bar_' . esc_html( $k . $ii ) . ':after{content:"' . esc_html ( $Per ) . '% ' . esc_html( $EveryCh ) . '";} ';?>
							.bar_<?php
								echo esc_html( $k . $ii );
							?> {
								grid-area:bar_<?php
									echo esc_html ( $k . $ii ) ;
								?>;
								grid-row-start:span <?php
								if ( $Per > 0 ) {
									print( round( intval( $Per ), 0 ) );
								} else {
									print( '2' );
								}
								?>
								;}
								<?php
						}
						?>
					</style>
					<?php
				}
			}
		}
		echo	'<style type="text/css">';
			foreach( $VABFWC_FORMSA as $k => $v ) {
				if ( $v['type'] == 'radio' || $v['type'] == 'select' ) {
					$colCol = count( $v['color'] );
					for( $i = 1; $i <= $colCol; $i++ ) {
						$ii = $i - 1;
						echo	'.' . esc_html( $k ) . ' li:nth-child(' . esc_html( $i ) . '){border-color:' . esc_html( $v['color'][$ii] ) . ';}';
					}
					if ( $v['type'] !== 'select' && $v['plusArea'] == 'yes' ) {
						$colCol = intval( $colCol ) + 1;
						echo	'.' . esc_html( $k ) . ' li:nth-child(' . esc_html( $colCol ) . '){border-color:#A8A8A8;}';
					}
					for( $i = 1, $num = $colCol; $i <= $colCol; $i++ ) {
						echo	'.' . esc_html( $k ) . ' li:nth-child(' . esc_html( $i ) . '){z-index:' . esc_html( $num ) . ';}';
						$num--;
					}
				}
			}
		echo	'</style>';
		echo	!empty($total)
					&& empty($VABFWC_FORMSA_OPT['VABFWC_FORMSA_OPT_TotaL'])
					? '<h3><center>' . esc_html__( 'Questionnaire completed', 'VABFWC' ) . ': ' . intval( max( $total ) ) . ' ' . esc_html__( 'times', 'VABFWC' ) . '</center></h3>'
					: '';
		?>
		<style type="text/css">
			.semicircle_chart{margin:0 auto;padding:0;list-style-type:none;}
			.semicircle_chart *,.semicircle_chart::before{box-sizing:border-box;}
			.semicircle_chart{position:relative;width:330px!important;height:165px!important;overflow:hidden;}
			.semicircle_chart::before,.semicircle_chart::after{position:absolute;}
			.semicircle_chart::before{content:'';width:inherit;height:inherit;border:45px solid rgba(211, 211, 211, .3);border-bottom:none;border-top-left-radius:200px;border-top-right-radius:200px;}
			.semicircle_chart::after{left:50%;bottom:10px;transform:translateX(-50%);font-weight:bold;}
			.semicircle_chart li{position:absolute;top:100%;left:0px;width:inherit;height:inherit;border:45px solid;border-top:none;border-bottom-left-radius:200px;border-bottom-right-radius:200px;transform-origin:50% 0;margin:0 !important;}
			.semicircle_chart span{position:absolute;font-size:.85rem;}
			.semicircle_chart::after{content:'%';}
			/* //////////////////////////////////// */
			.Dynamic_chart{display:grid;grid-column-gap:5px;height:100px;width:90%;padding:5px 10px;grid-template-areas:/* 'bar_1 bar_2 bar_3' */;}
			.Dynamic_bar{position:relative;border-radius:5px 5px 0 0;background-color:#ff4136;}
			.Dynamic_bar:after{position:absolute;margin-top:-22px;left:50%;transform:translate(-50%,0);}
			.cub{display:inline-block;width:33px;height:15px;}
		</style>
		<?php
	}
}