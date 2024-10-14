<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
#[AllowDynamicProperties]
class VABFWC_Class {
	public $PostID;
	public $FD;
	public $mIP;
	public $mDATE;
	public $mAGENT;
	function __construct( $PostID ) {
		$this->PostID 		= intval( $PostID );
		$this->FD 				= VABFWC_UPLOAD_DIR . '/VABFWC/' . sanitize_title( stristr( VABFWCGSU, '://' ) ) . '/Diagram/' . $this->PostID . '/';
		$VABFWC_FORMSA		= get_post_meta( $this->PostID, 'VABFWC_FORM' ,true );
		if ( !empty($VABFWC_FORMSA) ) {
			$VABFWC_FORMSA	= vabfwc_sanitize_text_field( $VABFWC_FORMSA[$this->PostID] );
			foreach( $VABFWC_FORMSA as $k => $v ) {
				$this->$k 		= $this->FD . "$k.txt";
			}
		}
		$this->mIP				= $this->FD . 'mIP_' . $this->PostID . '.txt';
		$this->mDATE			= $this->FD . 'mDATE_' . $this->PostID . '.txt';
		$this->mAGENT			= $this->FD . 'mAGENT_' . $this->PostID . '.txt';
	}
	function DirDel() {
		if ( file_exists( $this->FD ) ) {
			dirDel( $this->FD );
		}
	}
	function DirDelCsv() {
		if ( file_exists( $this->FD . 'csv_logs' ) ) {
			dirDel( $this->FD . 'csv_logs' );
		}
	}
	function FileDel() {
		if ( file_exists( $this->FD ) ) {
		$FileDir					= scandir( $this->FD );
		$VABFWC_FORMSA		= get_post_meta( $this->PostID, 'VABFWC_FORM', true );
			if ( !empty($VABFWC_FORMSA) ) {
				$VABFWC_FORMSA	= $VABFWC_FORMSA[$this->PostID];
				foreach( $FileDir as $file ) {
					if ( $file != "." && $file != ".." &&
							 $file != 'mIP_' . $this->PostID . '.txt' &&
							 $file != 'mDATE_' . $this->PostID . '.txt' &&
							 $file != 'mAGENT_' . $this->PostID . '.txt' /* &&
							 $file != $this->FD . 'csv_logs' */ ) {
						$name			= basename( $file, ".txt" );
						if ( !array_key_exists( $name, $VABFWC_FORMSA ) && $name !== 'csv_logs' ) {
							unlink( $this->FD . $file );
						}
					}
				}
			}
		}
	}
function __call( $n, $ag ) {
	echo	'<ul class="semicircle_chart ' . esc_attr( $ag[0] ) . '">';
	for( $i = 1, $icount = $ag[1]; $i <= $icount; $i++ ) {
		if ( defined( $ag[0] . $i . 'Per' ) && constant( $ag[0] . $i . 'Per' ) > 0 ) {
			echo '<li><span>' . constant( esc_html( $ag[0] . $i . 'Per' ) ) . '</span></li>';
		} else {
			echo '<li><span></span></li>';
		}
	}
	echo	'</ul><br><br><style type="text/css">';
	for( $i = 1, $icount = $ag[1]; $i <= $icount; $i++ ) {
		if ( $i > 1 ) {
			$ii = $i - 1;
			${$ag[0] . $i . 'Gr'} = ( constant( sanitize_text_field( $ag[0] . $i . 'Per' ) ) / 100 ) * 180 + sanitize_text_field( ${$ag[0] . $ii . 'Gr'} );
		} else {
			${$ag[0] . $i . 'Gr'} = ( constant( sanitize_text_field( $ag[0] . $i . 'Per' ) ) / 100 ) * 180;
		}
		echo	'.' . esc_html( $ag[0] ) . ' li:nth-child(' . esc_html( $i ) . '){',
						'transform:rotate(' . esc_html( ${$ag[0] . $i . 'Gr'} ) . 'deg);',
					'}',
					'.' . esc_html( $ag[0] ) . ' li:nth-child(' . esc_html( $i ) . ') span{',
						'transform:rotate(-' . esc_html( ${$ag[0] . $i . 'Gr'} ) . 'deg);',
					'}';
	}
	echo'</style>';
	}
}