<?php
/**
 * Plugin Name:       GothAmazon
 * Plugin URI:        https://gothamazon.com
 * Description:       Parse Amazon Product Advertising API Feed in 30 seconds
 * Version:           3.2.8
 * Requires PHP:      7.4
 * Author:            Kapsule Network
 * Author URI:        https://kapsulenetwork.com
 * License:           GPLv2 
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

define('GOTHAMZ_ROOTPATH', plugin_dir_path( __FILE__ )); // Chemin Serveur

$gtz_store_data_dir = wp_get_upload_dir();
$gtz_store_data_dir = $gtz_store_data_dir ["basedir"];	
$gtz_store_data_dir = $gtz_store_data_dir . '/gtz_store/';
$gtz_store_data_dir_backup = $gtz_store_data_dir . 'backup/';
						
if (! is_dir($gtz_store_data_dir)) {
	mkdir( $gtz_store_data_dir, 0755 );
}		

if (! is_dir($gtz_store_data_dir_backup)) {
	mkdir( $gtz_store_data_dir_backup, 0755 );
}		

define('GOTHAMZ_UPLOAD_PATH', $gtz_store_data_dir);
define('GOTHAMZ_UPLOAD_PATH_BACKUP', $gtz_store_data_dir_backup); 

require_once(GOTHAMZ_ROOTPATH.'gothaws.php');
require_once(GOTHAMZ_ROOTPATH.'inc/vmob.php');
require_once(GOTHAMZ_ROOTPATH.'inc/valid_api.php');
require_once(GOTHAMZ_ROOTPATH.'inc/encode.php');
require_once(GOTHAMZ_ROOTPATH.'inc/decode.php');
require_once(GOTHAMZ_ROOTPATH.'inc/hashtagamazon.php');
require_once(GOTHAMZ_ROOTPATH.'inc/erase_old_caching_files.php');


// Test de la Validité de la licence //
$doubleface = false;
$doubleface = check_kapsuleapi_licence();

if ($doubleface == "cUrl") {
	
	$msgerreur = "Votre serveur n'arrive pas à se connecter à notre API - cURL error 28: Operation timed out - L'erreur semble venir de votre solution d'hébergement car tout fonctionne du côté des serveurs de Gothamazon, mais n'hésitez pas à <u><a href='https://gothamazon.com/contact.php' target='_blank'>contacter notre support</a></u> pour tenter de régler cela ensemble.";$doubleface=false;
	
} elseif ($doubleface == "Erreur") {
	
	$msgerreur = "Votre serveur n'arrive pas à se connecter à notre API"; 
	$doubleface=false;
	
} else {
	
	$msgerreur = "";
	
}
define('BEERUS', $doubleface); // API ACTIVE ou NON
//////////////////////////////////////////

if (BEERUS == true) {

	// VARIABLES GLOBALES
	$marketplace = get_option('gothamazon_option_marketplace'); 
	if ($marketplace == '') {$marketplace = 'fr_FR';} // Francais par défaut COCORICO
	if ($marketplace == 'fr_FR') {$marketplace_id = 'fr_FR'; $marketplace_w = 'amazon.fr'; $marketplace_region = 'eu-west-1';$ladevise = '€'; $ladevise_v2 = "EUR";}
	else {$marketplace_id = 'en_US'; $marketplace_w = 'amazon.com'; $marketplace_region = 'us-east-1';$ladevise='$';  $ladevise_v2 = "USD";}

	$secret_amalog = get_option('gothamazon_ama_login');
	$secret_amapass = get_option('gothamazon_ama_key');
	$secret_amapass = kaps_decrypt("$secret_amapass");
	$amazontrackingcode = get_option('gothamazon_ama_track');
	$amazontrackingcode_ghost = $amazontrackingcode; // Ancrage pour gérer le multi user

	$cachingtime = get_option('gothamazon_option_cachingtime'); 
	if ($cachingtime == 86400) {$cachingtime_txt="24h";} // 24 H par défaut
	elseif ($cachingtime == 43200) {$cachingtime_txt="12h";}
	elseif ($cachingtime == 21600) {$cachingtime_txt="6h";}
	elseif ($cachingtime == 7200) {$cachingtime_txt="2h";}
	elseif ($cachingtime == 3600) {$cachingtime_txt="1h";}
	elseif ($cachingtime == 1800) {$cachingtime_txt="30 min";}
	else {$cachingtime = 86400; $cachingtime_txt="24h";}

	$neufunik = get_option('gothamazon_option_neufunik');
	if ($neufunik == '') {$neufunik = 'Any';} // Tous les ITEMS

	$sortbay = get_option('gothamazon_option_sortbay'); 
	if (($sortbay == '') OR ($sortbay == 'Default')) {$tripardefaut = 'oui';} // Tri par defaut si vide

	$vendeur = get_option('gothamazon_option_vendeur');
	if ($vendeur == '') {$vendeur == 'All';} // Tous les ITEMS

	$cloaking = get_option('gothamazon_option_cloaking');
	if ($cloaking == "") {$cloaking = "non";}

	$cloakingimage = get_option('gothamazon_option_cloakingimage');
	if ($cloakingimage == "") {$cloakingimage = "non";}

	$css_inclus = get_option('gothamazon_option_css');
	if ($css_inclus == "") {$css_inclus = "oui";}

	$legalytext = get_option('gothamazon_option_legal');
	if ($legalytext == "") {$legalytext = "oui";}

	$economycostapi = get_option('gothamazon_option_economycostapi');
	if ($economycostapi == "") {$economycostapi = "non";}

	$buildstore = get_option('gothamazon_option_speedboutique');
	if ($buildstore == "") {$buildstore = "non";}
	
	$gtz_tokyo4 = get_option('gtz_tokyo4');
	if ($gtz_tokyo4 == "") {
			
		$gtz_tokyo4 = "non";
		
	}
	
	$gtz_tokyo4_3bay = get_option('gtz_tokyo4_3bay');
	if ($gtz_tokyo4_3bay == "") {
		
		if (BEERUS == "godmod") {
			
			$gtz_tokyo4_3bay = "cdiscount";
		
		} else {
			
			$gtz_tokyo4_3bay = "amazon";
			
		}
		
	}
	
	$gtz_linquery_default = get_option('gtz_linquery_default');
	if ($gtz_linquery_default == "") {
		
		if (BEERUS == "godmod") {
			
			$gtz_linquery_default = "oui";
		
		} else {
			
			$gtz_linquery_default = "non";
			
		}
		
	}
	
	$gtz_awin_ref_id = get_option('gtz_awin_ref_id');
	if ($gtz_awin_ref_id == "") {$gtz_awin_ref_id = "initial";}

	$use_prixbarre = get_option('gothamazon_option_prixbarre');
	if ($use_prixbarre == "") {$use_prixbarre = "oui";}

	$use_amaprime = get_option('gothamazon_option_amaprime');
	if ($use_amaprime == "") {$use_amaprime = "oui";}

	$use_rating = get_option('gothamazon_option_rating');
	if ($use_rating == "") {$use_rating = "non";}

	$boodisplayprice = get_option('gothamazon_option_boodisplayprice');
	if ($boodisplayprice == "") {$boodisplayprice = "oui";}

	$hidetitre = get_option('gothamazon_option_hidetitre');
	if ($hidetitre == "") {$hidetitre = "non";}

	$gothamazon_option_color_cta = get_option('gothamazon_option_color_cta');
	if ($gothamazon_option_color_cta == "") {$gothamazon_option_color_cta = "#2bd899";} 

	$gothamazon_option_color_price_bg = get_option('gothamazon_option_color_price_bg');
	if ($gothamazon_option_color_price_bg == "") {$gothamazon_option_color_price_bg = "#f92457";}

	$gothamazon_option_powered_check = get_option('gothamazon_option_powered');
	if ($gothamazon_option_powered_check == "") {$gothamazon_option_powered_check = "non";}
	
	$gothamazon_option_marchandlogo = get_option('gothamazon_option_marchandlogo');
	if ($gothamazon_option_marchandlogo == "") {$gothamazon_option_marchandlogo = "oui";}
 
	$domainname = $_SERVER['HTTP_HOST'];
	
	$gtz_called = 0;
	
	if ((BEERUS == 'premium') OR (BEERUS == 'godmod') ) {
		
		function gtz_intelli_split_my_query($query) { // Split la requete
				$tmp = explode("|", $query);
				$query = array_map('trim',$tmp);
				return $query;
		}
		
		// Multi Compte
		$amazontrackingcode2 = get_option('gothamazon_ama_track2');
		if ($amazontrackingcode2 != "") {
			
			function gtz_revenue_share_shuffle($array) {
				
				return $array[array_rand($array)];
				
			};
			
			$gtz_multi_partners_array = [$amazontrackingcode, $amazontrackingcode2];
			$gtz_choose_random_partner = gtz_revenue_share_shuffle($gtz_multi_partners_array);
			
			$amazontrackingcode_tracker = $gtz_choose_random_partner;
			$amazontrackingcode = $amazontrackingcode_ghost;
			
		} else {
			
			$amazontrackingcode_tracker = $amazontrackingcode_ghost;
			$amazontrackingcode = $amazontrackingcode_ghost;
			
		}

		
	} else {
		
		function gtz_intelli_split_my_query($query) { // Ne fait rien
			$temp = array();
			$temp[] = $query;
			$result = $temp;
			return $result;
		}
		
		$amazontrackingcode_tracker = $amazontrackingcode_ghost;
		$amazontrackingcode = $amazontrackingcode_ghost;
		 
	}
	
	$urlgta = get_option('gothamazon_option_urlgta');
	if ($urlgta != "") {
		
		$parachutemodeegta = $urlgta;
		
	} else {
		
		$parachutemodeegta = "https://www.amazon.fr/?tag=$amazontrackingcode";
		
	} 
	

	// Gestion du multisite
	if ( is_multisite() ) {
		
		$multisite = true; 
		$iddusite = get_current_blog_id();
		$store_multi_id = "$iddusite-";
		
	} else {
		
		$multisite = false; 
		$iddusite = false;
		$store_multi_id = "";
		
	}

	// Gestion de l'AMP via Get
	if (isset($_GET['amp'])) {
		
		$amp = true;
		$imgtag = 'amp-img'; 
		$imgtag_resp='amp-img layout="responsive"';
		$imgtag_close="</amp-img>";
		$cloaking = "non"; // on empeche le cloaking a cause du js ! AMPS
		$css_inclus = "non"; // on empeche le cloaking a cause du css ! AMP
			
	} else {
		
		$amp = false;
		$imgtag = 'img';
		$imgtag_resp='img'; 
		$imgtag_close = "";
		
	} 


	///////////////////////////////////////////////////
	// Function InlineASIN NGEN
	///////////////////////////////////////////////////
	require_once(GOTHAMZ_ROOTPATH.'/gotham_inline_asin.php');
	///////////////////////////////////////////////////
	// Function Easy AMAZON Boutique
	///////////////////////////////////////////////////
	require_once(GOTHAMZ_ROOTPATH.'/gotham_boutique.php');
	///////////////////////////////////////////////////
	// Function Inline TEXT & SpeedStore
	///////////////////////////////////////////////////
	if ((BEERUS == 'premium') OR (BEERUS == 'godmod') ) {
		
		require_once(GOTHAMZ_ROOTPATH.'/gotham_inline_text.php');
		require_once(GOTHAMZ_ROOTPATH.'/gotham_speedstore.php');
		
	}
	///////////////////////////////////////////////////
	// Function Spotlight ASIN
	///////////////////////////////////////////////////
	require_once(GOTHAMZ_ROOTPATH.'/gotham_spotlight_asin.php');
	///////////////////////////////////////////////////
	// Function Spotlight KeyWord
	///////////////////////////////////////////////////
	require_once(GOTHAMZ_ROOTPATH.'/gotham_spotlight_keyword.php');

	// Module de CSS

	if ($css_inclus == "oui") {
		
		if ($amp != true) {
			
			function gtz_hex2rgb($hex) {
				$hex = str_replace("#", "", $hex);
				if(strlen($hex) == 3) {
					$r = hexdec(substr($hex,0,1).substr($hex,0,1));
					$g = hexdec(substr($hex,1,1).substr($hex,1,1));
					$b = hexdec(substr($hex,2,1).substr($hex,2,1));
				} else {
					$r = hexdec(substr($hex,0,2));
					$g = hexdec(substr($hex,2,2));
					$b = hexdec(substr($hex,4,2));
				}
				$rgb = array($r, $g, $b);
				return $rgb;
			}
			
			function gtz_minimizeCSSsimple($css){
				$css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css); // negative look ahead
				$css = preg_replace('/\s{2,}/', ' ', $css);
				$css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
				$css = preg_replace('/;}/', '}', $css);
				return $css;
			}
			
			function gtz_hook_css_io() { 
			
				global $gothamazon_option_color_cta, $gothamazon_option_color_price_bg;
				
				if ($gothamazon_option_color_cta != "#2bd899") {
					$gtz_myhex2rgb = gtz_hex2rgb($gothamazon_option_color_cta);
					$gtz_smartbackbackground = 'rgba('.$gtz_myhex2rgb[0].','.$gtz_myhex2rgb[1].','.$gtz_myhex2rgb[2].',0.2)';
					$gtz_couleurvoisine = $gtz_myhex2rgb[0] - 90;
					if ($gtz_couleurvoisine < 0) {$gtz_couleurvoisine = 0;}
					$gtz_cta_hover_color = 'rgba('.$gtz_couleurvoisine.','.$gtz_myhex2rgb[1].','.$gtz_myhex2rgb[2].',1)';
					
				} else {
					$gtz_smartbackbackground = "#e9fbeb";
					$gtz_cta_hover_color = "#107651";
				}
				
				$plugins_url = plugins_url();
				$imgducsshey = "$plugins_url/gothamazon/img/";
				$css_rowshop = get_option('gothamazon_option_css_rowshop');
				if ($css_rowshop == "") {$css_rowshop = 3;}
				$css_rowcatspeed = get_option('gothamazon_option_css_rowcatspeed');
				$css_yourstyle = get_option('gothamazon_option_css_yourstyle');
			

					// Parametrage du nombre de colonnes d'une page item
					if ($css_rowshop == 2) 
						{$io_width="48%";$io_padding="0.5%";$io_margin="0.5%";} 
					elseif ($css_rowshop == 3)  
						{$io_width="31%";$io_padding="0.5%";$io_margin="0.5%";} 
					elseif ($css_rowshop == 4)  
						{$io_width="23%";$io_padding="0.5%";$io_margin="0.5%";}
					else // 5
						{$io_width="18%";$io_padding="0.5%";$io_margin="0.5%";}
					
					// Parametrage du nombre de colonnes d'une récap des catégories + Related Cat
					if ($css_rowcatspeed == 2) 
						{$io2_width="49%";} 
					elseif ($css_rowcatspeed == 3) 
						{$io2_width="32%";}
					elseif ($css_rowcatspeed == 4) 
						{$io2_width="24%";}
					else //5
						{$io2_width="19%";}

				$build_dynamic_css = '
					ul.smartstore {
						display: block;
						clear: both;
						list-style: none;
						padding: 0!important;
						margin: 0!important;
					}

					ul.smartstore li {
						display: inline-block;
						width: '.$io_width.';
						list-style: none;
						padding: '.$io_padding.';
						margin: '.$io_margin.';
						border: 1px solid #eee;
						border-radius: 3px;
						cursor: pointer;
					}

					ul.smartstoresidebar li,
					ul.smartstoresidebar li span.storeitemfoo {
						width: 100%;
						border: 0;
					}

					ul.smartstore li .ficheproduit {
						background: #fff;
						border: 0;
						text-decoration: none;
						color: #000;
					}

					ul.smartstore li .ficheproduit:hover {
						opacity: .6;
						transition: .5s;
					}

					.imgkra {
						width: 100%;
						display: flex;
						background: white;
						margin: 10px 0;
						align-items: center;
						height: 160px;
					}

					ul.smartstore .gothamrate img,
					ul.smartstoresidebar .gothamrate img {
						margin: 5px 0!important
					}

					ul.smartstoresidebar li .ficheproduit .imgkra img,
					ul.smartstore li .ficheproduit .imgkra img {
						max-height: 140px;
						text-align: center;
						margin: 0 auto!important;
						display: block;
						max-width: 100%;
						width: auto!important
					}

					ul.smartstore li .ficheproduit:hover img.mainpics {
						animation: roll 3s infinite
					}

					@keyframes roll {
						0% {
							transform: rotate(0)
						}
						100% {
							transform: rotate(360deg)
						}
					}

					ul.smartstore li .ficheproduit span.storeitemtitle {
						display: block;
						text-align: center;
						text-transform: uppercase;
						font-weight: 700
					}

					.ratak {
						height: 22px;
						overflow: hidden
					}

					ul.smartstore li .ficheproduit span.storeitemfoo {
						display: block;
						background: '.$gtz_smartbackbackground.';
						width: 100%;
						float: left;
						border-radius: 4px;
						padding: 5px 0;
						text-align: center
					}

					ul.smartstore li .ficheproduit span.storeitemprice {
						display: inline-block;
						text-align: center;
						color: #000;
						font-style: italic;
						font-weight: 400;
						width: 40%;
						padding: 4px
					}

					ul.smartstore li .ficheproduit span.storeitemcta {
						background: '.$gothamazon_option_color_cta.';
						text-align: center;
						color: #fff;
						width: 47%;
						border-radius: 3px;
						float: right;
						margin-right: 2%;
						font-weight: bold;
						padding: 4px
					}

					ul.smartstore li .ficheproduit span.storeitemcta:hover {
						background: '.$gtz_cta_hover_color.'
					}

					p.smartstorelegal {
						font-style:italic;
						text-align:center!important;
						font-size:11px!important;
						margin:10px 0;
						font-family:arial!important;
						line-height:12px!important;
						background:#eee;
						padding:15px;
						color:#666;
						border-radius:5px;
						opacity:0.9;
					}

					ul.smartstore li .ficheproduit span.cuzprice_css {
						float: none;
						font-weight: bold;
						width: 86%;
						display: inline-block;
						margin: 0 auto
					}

					ul.smartstore.izishop92 {
						padding: 5px 0 !important;
						margin: 10px 0!important;
						border: 1px solid #f0f0f0;
						background: #eee;
						text-align: center;
						border-radius: 5px;
					}

					ul.smartstore.izishop92 li {
						background: white;
						display: inline-grid;
						vertical-align:top;
						
					}

					ul.smartstoresidebar.izishop92 {
						border: 0;
						padding: 0;
						margin: 0;
						background: white;
					}

					ul.smartstoresidebar.izishop92 li {
						padding: 0!important;
						margin: 0!important;
						width: 100%!important;
					}

					ul.smartstorekontent span.pricepromo {
						margin-top: 4px;
					}
					
					.newrules24 {position:absolute;top:24px;right:7px;width: auto !important;}
					ul.smartstore li {position:relative;}
					
					.gtz-info-icon {
					  position: relative;
					  cursor: pointer;
					}
					
					.pixanchor {
					position:absolute;
					left:0;
					top:0;
					}

					.gtz-info-icon:hover .gtz-tooltip,
					.gtz-info-icon:focus .gtz-tooltip
					{
					  visibility: visible;
					  opacity: 1;
					}

					.gtz-tooltip {
					  visibility: hidden;
					  width: 120px;
					  background-color: black;
					  color: white;
					  text-align: center;
					  padding: 5px 0;
					  border-radius: 6px;
					  position: absolute;
					  z-index: 1;
					  bottom: 100%;
					  left: 50%;
					  margin-left: -60px;
					  opacity: 0;
					  transition: opacity 0.5s;
					}

					.gtz-tooltip::after {
					  content: "";
					  position: absolute;
					  top: 100%;
					  left: 50%;
					  margin-left: -5px;
					  border-width: 5px;
					  border-style: solid;
					  border-color: black transparent transparent transparent;
					}
					
					.pixanchor .gtz-tooltip {position:relative;padding: 5px 10px;}

					@media only screen and (max-width:1024px) {
						ul.smartstore li {
							border: 0
						}
					}

					@media only screen and (min-width:768px) and (max-width:1024px) {
						ul.smartstoresidebar li {
							width: 100%
						}
						ul.smartstoresidebar li .ficheproduit span.storeitemfoo {
							width: 90%
						}
						ul.smartstore.izishop92 li .ficheproduit span.storeitemprice {
							width: 100%
						}
						ul.smartstore.izishop92 li .ficheproduit span.storeitemcta {
							width: 100%;
							margin-right: 0;
							padding: 0;
						}
						ul.izishop92.goku li .ficheproduit.kamesen span.storeitemfoo span.storeitemprice {
							width: 100%;
							margin-right: 0;
						}
					}

					@media only screen and (max-width:767px) {
						ul.smartstore.izishop92 {
							background: white;
						}
						ul.smartstore li {
							width: 100%
						}
						ul.smartstore li .ficheproduit span.storeitemfoo {
							width: 100%
						}
						ul.izishop92 li {
							margin: 3px 1%;
							padding: 0;
							width: 48%;
						}
						.ratak {
							padding: 0 10px;
						}
						ul.smartstore li .ficheproduit span.storeitemcta {
							text-align: center;
							color: #fff;
							width: 80%;
							border-radius: 3px;
							float: none;
							margin: 2% auto;
							font-weight: bold;
							padding: 4px;
							display: block;
						}
						ul.smartstore li .ficheproduit span.storeitemprice {
							width: 100%;
							padding: 4px 0;
						}
					}

					ul.smartstorespotlight {
						border: 1px solid #eee;
						border-radius: 3px;
						background: white
					}

					ul.smartstorespotlight li {
						width: 100%;
						display: inline-block;
						list-style: none;
						margin: 0!important;
						padding: 0!important;
						border: 0!important
					}

					.bleft {
						background: #fff;
						border-radius: 4px;
						width: 45%;
						padding: 10px 5px 30px;
						float: left
					}

					.bright {
						margin-left: 0;
						width: 52%;
						display: inline-block
					}

					.area4mainpics {
						display: block;
						width: 100%;
						max-height: 300px
					}

					.blob {
						font-size: 12px;
						font-size: 14px;
						margin: 20px;
						text-align: justify;
						display: inline-block
					}

					ul.smartstore li .ficheproduit .area4mainpics img.mainpics {
						width: 100%!important;
						max-height: 300px!important;
						height: 100%!important;
						margin: 0!important;
						object-fit: contain!important
					}

					ul.smartstore li .ficheproduit .vaiamage {
						display: block;
						width: 100%
					}

					ul.smartstore li .ficheproduit .vaiamage span {
						float: left;
						width: 32.5%!important;
						margin: 0!important;
						border: 1px solid #eee;
						object-fit: cover
					}

					.elprime {
						display: block;
						width: 100%;
						text-align: right
					}

					.gothamrate {
						display: block;
						width: 100%;
						text-align: right
					}

					ul.smartstore li .ficheproduit img.prime,
					ul.smartstore li .ficheproduit img.gotrate {
						max-width: 80px;
						display: inline;
						margin-right: 20px!important
					}

					.storeitemprice strike {
						color: '.$gothamazon_option_color_price_bg.';
						white-space: nowrap;
						font-size: 80%;
					}

					.pricepromo {
						font-size: 160%;
						font-family: arial;
						background-color: '.$gothamazon_option_color_price_bg.';
						color: white;
						transform: rotate(-1deg);
						width: 100%;
						display: block;
						font-style: italic;
						font-weight: 1000;
						padding: 5px 0;
						text-align: center;
					}

					ul.smartstorespotlight li .ficheproduit span.storeitemfoo {
						width: 100%;
						text-align: center
					}

					.uaresmart {
						background: #226ab5;
						color: white;
						display: inline-block;
						width: 100%;
						padding: 3px 0;
						border-radius: 4px;
						text-align: center;
					}

					.uaresmart strong,
					.uaresmart u {
						color: white!important;
					}

					ul.smartstorespotlight li .ficheproduit span.storeitemcta {
						display: block;
						background: '.$gothamazon_option_color_cta.';
						text-align: center;
						color: #fff;
						width: 47%;
						border-radius: 3px;
						float: right;
						font-size: 20px;
						font-family: arial;
						font-weight: bold;
						padding: 13px;
						text-shadow: 0 0 2px #755656;
						text-transform: uppercase;
						letter-spacing: -1px;
					}

					ul.smartstorespotlight li .ficheproduit span.storeitemtitle {
						margin-top: 24px;
						padding: 10px
					}

					ul.smartstoresidebar {
						padding: 0!important
					}

					ul.smartstoresidebar li {
						margin: 3px 0;
						padding: 0
					}

					ul.smartstoresidebar li .bleft,
					ul.smartstoresidebar li .bright {
						width: 100%;
						display: block;
						float: none;
						padding: 0;
						text-align: center
					}

					ul.smartstoresidebar li .elprime {
						float: right;
						width: auto
					}

					ul.smartstoresidebar li .gothamrate {
						float: left;
						width: auto;
						margin-left: 24px
					}

					ul.smartstoresidebar li .ficheproduit span.storeitemprice {
						width: 94%;
						color: white;
						background: '.$gothamazon_option_color_price_bg.';
						padding: 0
					}

					ul.smartstoresidebar li .ficheproduit span.storeitemprice strike {
						color: '.$gothamazon_option_color_price_bg.';
						background: white;
						white-space: nowrap;
					}

					ul.smartstoresidebar li .ficheproduit span.storeitemcta {
						width: 94%;
						float: none;
						padding: 10px 0;
						margin: 10px auto
					}

					ul.smartstoresidebar .blob {
						margin: 20px 26px
					}

					ul.smartstoresidebar li .ficheproduit span.storeitemfoo {
						width: 100%;
						background: transparent
					}

					ul.smartstorespotlight li .ficheproduit span.cuzprice_css {
						float: none;
						font-weight: bold;
						width: 86%;
						display: inline-block;
						margin: 0 auto
					}

					ul.smartstoresidebar li {
						background: white;
						display: inline-block;
						padding: 10px 0;
						margin: 0;
						border-radius: 0;
						border: 0
					}

					ul.smartstoresidebar li .ficheproduit span.storeitemtitle {
						display: inline-block;
						text-align: center
					}

					ul.izishop92 .gothamrate {
						text-align: center;
						margin: 5px 0 0;
						float: none;
						display: inline-block;
						width: 100%!important;
						padding: 0
					}

					ul.izishop92 li .ficheproduit .gothamrate img.gotrate {
						margin: 0 auto!important;
						float: none;
					}

					ul.goku li .ficheproduit span.storeitemtitle {
						width: 100%;
						padding: 0;
					}

					ul.goku li .ficheproduit.kamesen span.storeitemfoo {
						width: 100%
					}

					ul.goku li .ficheproduit.kamesen span.storeitemfoo span.storeitemprice {
						display: inline-block;
						color: white;
						font-weight: bold;
						font-size: 20px;
						width: 70%!important;
						padding: 5px 0!important;
						border-radius: 8px;
						transform: rotate(-3deg);
					}

					ul.goku li .ficheproduit.kamesen span.storeitemfoo span.storeitemcta {
						width: 39%;
						display: inline-block;
						font-size: 20px;
						padding: 10px 0
					}

					ul.smartstore.smartstoresidebar.izishop92.goku li .ficheproduit.kamesen span.gothamrate {
						margin-left: 0
					}


				
				@media only screen and (min-width:768px) and (max-width:1024px){
					.bleft,
					.bright {
						max-width: initial;
						min-width: initial;
						text-align: center;
						width: 100%;
						margin: 0;
						padding: 0
					}

					.area4mainpics {
						width: auto;
						height: auto
					}

					ul.smartstore li .ficheproduit .area4mainpics img.mainpics,
					ul.smartstore li .ficheproduit .vaiamage span {
						clear: none
					}

					ul.smartstorespotlight li .ficheproduit span.storeitemfoo {
						width: 100%
					}

				}
					
				@media only screen and (max-width:767px) {
					ul.smartstorespotlight {
						border: 0!important;
						border-radius: 3px;
						background: white;
						margin: 0!important;
						width: 100%!important;
						padding: 0!important
					}
					.bleft,
					.bright {
						width: 100%;
						margin: 0;
						padding: 0
					}
					.area4mainpics {
						float: left;
						width: 100%
					}
					ul.smartstore li .ficheproduit .area4mainpics img.mainpics {
						max-height: initial;
						height: auto;
						border: 1px solid #eee;
						max-width: 100%;
						object-fit: cover;
						width: 100%
					}
					ul.smartstore li .ficheproduit .vaiamage {
						float: left;
						padding-top: 20px;
						width: 100%
					}
					ul.smartstore li .ficheproduit .vaiamage span {
						float: left;
						margin: 0!important;
						border: 1px solid #eee;
						object-fit: cover;
						width: 32.5%!important;
						max-height: 100px;
					}
					.storeitemprice strike {
						float: left;
						text-align: center;
						width: 100%;
						white-space: nowrap;
					}
					.blob {
						margin-bottom: 20px
					}
					ul.smartstorespotlight li .ficheproduit span.storeitemprice {
						width: 100%;
						padding: 0;
						background: 0
					}
					ul.smartstorespotlight li .ficheproduit span.storeitemcta {
						float: none;
						padding: 10px 0;
						width: 86%;
						margin: 10px auto
					}
					ul.smartstorespotlight li .ficheproduit span.storeitemfoo {
						width: 100%;
						padding: 0;
						margin: 0
					}
					ul.smartstorespotlight li .ficheproduit .area4mainpics img.mainpics {
						border: 0
					}
					.pricepromo {
						width: 86%;
						margin: 5px auto 0
					}
					.uaresmart {
						width: 86%;
						padding: 5px 0
					}
				}
				
				/* INLINE STYLE */
				
				.lienvoyant {
					cursor: pointer;
					border-bottom: 2px solid;
					text-decoration: none!important;
					color: blue
				}

				.lienvoyant:hover {
					border-bottom: 0;
					text-decoration: none
				}

				.lienvoyantsmartcss {
					border: 0
				}

				.lienvoyantsmartcss img {
					cursor: pointer
				}

				.lienvoyantsmartcss img:hover {
					opacity: .8
				}
				
				.ama_itxtlink::before {
					background: url("'.$imgducsshey.'ama_icon.png") no-repeat left center transparent; 
					position:relative; 
					z-index:100000; 
					left:0;
					top:0;  
					background-size: 100% 100%;
					line-height: 12px;
					width: 12px;
					height: 12px;
					display: inline-block;
					margin-left:2px;
					margin-right:2px;
					content: "\0000a0";
					opacity:0.8;
				 }
	
				/* Show Must Go On */
				
				p.showmustgoon {
					text-align: center;
					margin: 30px 0;
				}	

				p.showmustgoon .gothmshbutton {
					cursor: pointer;
					display: inline-block;
					text-align: center;
					vertical-align: middle;
					padding: 12px 24px;
					border: 0 solid #c3263e;
					border-radius: 8px;
					background: '.$gothamazon_option_color_cta.';
					background: -webkit-gradient(linear, left top, left bottom, from('.$gothamazon_option_color_cta.'), to('.$gtz_cta_hover_color.'));
					background: -moz-linear-gradient(top, '.$gothamazon_option_color_cta.', '.$gtz_cta_hover_color.');
					background: linear-gradient(to bottom, '.$gothamazon_option_color_cta.', '.$gtz_cta_hover_color.');
					box-shadow: #fff 0 0 40px 0;
					font: normal normal bold 20px arial;
					color: #fff;
					text-decoration: none
				}

				p.showmustgoon .gothmshbutton:focus,
				p.showmustgoon .gothmshbutton:hover {
					border: 0 solid ##f4304e;
					background: #ff4a79;
					background: -webkit-gradient(linear, left top, left bottom, from(#ff4a79), to(#ea2e4a));
					background: -moz-linear-gradient(top, #ff4a79, #ea2e4a);
					background: linear-gradient(to bottom, #ff4a79, #ea2e4a);
					color: #fff;
					text-decoration: none
				}

				p.showmustgoon .gothmshbutton:active {
					background: #c3263e;
					background: -webkit-gradient(linear, left top, left bottom, from(#c3263e), to(#c3263e));
					background: -moz-linear-gradient(top, #c3263e, #c3263e);
					background: linear-gradient(to bottom, #c3263e, #c3263e)
				}

				p.showmustgoon .gothmshbutton:before {
					content: "\0000a0";
					display: inline-block;
					height: 24px;
					width: 24px;
					line-height: 24px;
					margin: 0 4px -6px -4px;
					position: relative;
					top: 0;
					left: 0;
					background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAA7EAAAOxAGVKw4bAAACYklEQVRIibWWv4vVQBDHPzOb5B6HWFnogdZidWB7ha2diIVio2hv7z9g7X9goceBhdhZC1pbnQiHhb/wJygc50uyO2OR5JmXe3l3grch7CS7M5/d78zmPQGUI2xdcBsZt/9hD3eg/9OW1rDBwNyOrj+/eztM8vP9d2mvevHowr2HHNCyBeR9z1/qzxc1zy7PAWI9ATYPC+hWPMyJAuaW1ESQrBn2aIh71s7T4fy+3QG6Nky2AZgamjuSeQMQx3WsLhbvYGmpemZ4ZlgHwPHM+n6jiR5K1E2Y26YFg5AQlQYQHA+p81sq0VwVXX1554blnAFQVSQLaKZ8Kj9ei5N0lhaAOfk0e3WqWHtiKWHRcGviasnO1sb9TQY5UIDX37Zv6YpuSBBkJaCFooUieUDaq5Oozsv1nfLNutWGVYaXCU+OlekZsLVQomglagHNAiKGi2Io4hExAf7uwN2bXIhhYrgkzAxL89LNVVFMFWoBMW36JIgqIgLe3i0Ac9wcT4Ynw6ztG8Bs0X2A1rFC61YOUcQVcWn6AEgLcMdjcx68dryy5o7eAWaV1AdY/F2+k6RvEZBckEKRXNDVcFIKWe0n2Srf9b301SvH6waEg1f2oS/Rom/Rvnb66bnHejxckSBNEHPsV3rw/tL2zWV++yQam1RPS7QISGirKDk2TUt9FgFGD0ucVmgRILRvEx3gn79FfdDMjmWNTtM8oLTR+X37UBKlFNUqmR0DrJGp9V+av4MkmgAn0s9aRXXad7QfqQDWgO/AlBG5DqqiDDgGrALFYAFVG3gXiGMx+oAj+3dxpD/6fwB9pE++ZE6k6gAAAABJRU5ErkJggg==) no-repeat left center transparent;
					background-size: 100% 100%
				}
				
				/* Mini Boutique */

				ul.goth_indexboutique {
					list-style: none;
					padding: 0;
					margin: 0;
					display: inline-block;
					width: 100%;
				}

				ul.goth_indexboutique li {
					list-style: none;
					width: '.$io2_width.';
					padding: 1%;
					margin: 0.5%;
					display: inline-flex;
					background: white;
					border-radius: 4px;
					text-align: center;
				}

				ul.goth_indexboutique li a {
					width: 100%;
				}

				ul.goth_indexboutique li a img {
					width: 100%;
					object-fit: contain;
					height: 200px;
					padding: 15px;
				}

				ul.goth_indexboutique li a span {
					background: #fff;
					transform: rotate(0deg);
					width: 90%;
					display: block;
					color: #000;
					text-align: center;
					text-transform: uppercase;
					font-weight: 700;
					margin: 0 auto
				}

				ul.goth_indexboutique li a:hover {
					text-decoration: none;
					text-shadow: 0 0 3px #fff
				}

				ul.goth_indexboutique li a:hover img {
					opacity: .7
				}

				ul.goth_indexboutique li a:hover span {
					transform: rotate(1.5deg)
				}

				@media only screen and (max-width:1024px) {
					ul.goth_indexboutique {
						display: inline-block;
					}
					ul.goth_indexboutique li {
						background: white;
						width: 22%;
						margin: 1.5%;
						padding: 10px 0;
						border-radius: 3px;
					}
				}

				@media only screen and (max-width:767px) {
					ul.goth_indexboutique li {
						width: 48%;
						margin: 1%
					}
					ul.goth_indexboutique li a span {
						width: 100%;
						padding: 0 10px;
					}
				}


				/* CTA EyeCandy */

				path.one {
					transition: .4s;
					transform: translateX(-60%)
				}

				path.two {
					transition: .5s;
					transform: translateX(-30%)
				}

				.eyecandy:hover path.three {
					animation: color_anim 1s infinite .2s
				}

				.storeitemcta:hover path.one {
					transform: translateX(0);
					animation: color_anim 1s infinite .6s
				}

				.storeitemcta:hover path.two {
					transform: translateX(0);
					animation: color_anim 1s infinite .4s
				}

				@keyframes color_anim {
					0% {
						fill: #fff
					}
					50% {
						fill: #fbc638
					}
					100% {
						fill: #fff
					}
				}

				.smartstore svg {
					position: relative;
				}

				@media only screen and (min-width:1023px) {
					.eyecandyoptim span:after {
						content: url("'.$imgducsshey.'arrowinit.svg");
						position: relative;
						left: -8px;
						transition: width 2s ease-in .5s;
						top: 1px;
					}
					.storeitemcta:hover .eyecandyoptim span:after {
						content: url("'.$imgducsshey.'arrow.svg");
						position: relative;
						left: 0px;
					}
					ul.smartstore.vegeta li .ficheproduit span.storeitemprice {
						font-size: 18px;
					}
				}


				/* CTA CSS Default Inline */

				.gamz_cont {
					text-align: center
				}

				.gamz_cta {
					color: #20bf6b!important;
					text-transform: uppercase;
					background: #fff;
					padding: 20px;
					border: 4px solid #20bf6b!important;
					border-radius: 6px;
					display: inline-block;
					transition: all .3s ease 0s
				}

				.gamz_cta:hover {
					color: #494949!important;
					border-radius: 50px;
					border-color: #494949!important;
					transition: all .3s ease 0s
				}
				
				.gtz_amacompliant{
					background:#181818;
					color:#eee;
					text-align:center;
					padding:5px;
					font-size:12px;
					margin:0;
				}
				.gtz_amz {
					display:block;
					float:none!important;
					text-align:right;	
				}
				.izishop92 .gtz_amz {
					text-align:center;	
				}
				
				.gtz_amz img {
					width:auto;
					max-width:100%;
					display:initial!important;
				}
				
				@media only screen and (max-width:1024px) {
					.gtz_amz {
						text-align:center;
					}
				}
				
				.ssj24-carousel-arrow {position: absolute;transform: translateY(-50%);top: 22%;z-index: 10;cursor: pointer;  opacity:0.8;}.ssj24-left-arrow{left: 0;transform: translate(0, -50%);}.ssj24-right-arrow {right: 0;transform: translate(0, -50%);}.ssj24-carousel-arrow img {  width: 50px;height: auto;}
				@media screen and (max-width: 767px) {.ssj24-carousel-arrow{top:16%;}.ssj24-carousel-arrow img {width: 40px;}}
				.small_sous_cta{font-size: 10px;font-family: arial; position:absolute;bottom: -15px; right: 0;background: white;border: 1px solid;padding: 1px 5px;opacity: 0.8;border-radius: 3px;}.relative_ssj4slider{position:relative!important;}
	
				';

				if ($css_yourstyle !="") {
					$build_dynamic_css .= $css_yourstyle;
				}

				return gtz_minimizeCSSsimple($build_dynamic_css);  
		
			} 	
			
			function gtz_smart_css_f_load_script_css_front() {
				wp_register_style( 'gothamazon-css-io', false ); // On enregistre le style		
				$envoie_le_css_gros = gtz_hook_css_io();		
				wp_add_inline_style( 'gothamazon-css-io', $envoie_le_css_gros );	
			}
			add_action( 'wp_enqueue_scripts', 'gtz_smart_css_f_load_script_css_front' );		

		}

	} // Fin du Module de CSS

	//////// Création du JS pour le Cloaking
	// Thks to 410-gone

	if ($cloaking == "oui") {
		
		if ($amp != true) {
			if (! function_exists('kapsule_cloaking_rewritee')) {
				function kapsule_cloaking_rewritee() {
					wp_enqueue_script( 'gothamazon-js-obf', plugins_url('js/obf.js', __FILE__ ), array(), NULL );	
				}
				add_action( 'wp_enqueue_scripts', 'kapsule_cloaking_rewritee' );	
			}
			
			function gtz_noaccesstoobf( $output, $public ) {
				
				 $plugin_url = plugin_dir_url( __FILE__ );

				// Extraire le chemin relatif à partir de l'URL absolue
				$relative_path = parse_url( $plugin_url, PHP_URL_PATH );

				// Ajoute une ligne personnalisée au fichier robots.txt avec le chemin relatif
				$output .= "Disallow: " . $relative_path . "js/obf.js\n";

				return $output;
			}
			add_filter( 'robots_txt', 'gtz_noaccesstoobf', 10, 2 );
			
			
		}
	} // Fin du du JS Cloaking
	
	if ($amp != true) {

			if (! function_exists('insert_js4krousel_in_footer')) {
				function kapsule_krousel_js() {
					wp_enqueue_script( 'krousel-js', plugins_url('js/krousel.js', __FILE__ ), array(), NULL );	
				}
				add_action( 'wp_enqueue_scripts', 'kapsule_krousel_js' );	
			}			
		
	} // Fin du du JS KRoussel

}
	
// Création des datas enregistrés dans l'admin	
if ( is_admin() ){

	//	Sanitize Custom CSS	
	function gothamazon_sanitize_css( $input ) {
		return wp_strip_all_tags( $input );
	}
	
	add_action( 'admin_init', 'gothamazon_batarang' );
	function gothamazon_batarang() {

		register_setting( 'gothamazonbat-settings-group', 		'gothamazon_ama_kapsule_apijeton', 		'sanitize_text_field' );
		register_setting( 'gothamazonbat_alt-settings-group', 	'gothamazon_ama_kapsule_apijeton', 		'sanitize_text_field' );
		register_setting( 'gothamazonbat_first-settings-group', 'gothamazon_ama_kapsule_apijeton', 		'sanitize_text_field' );
		
		register_setting( 'gothamazonbat-settings-group', 		'gothamazon_ama_key',					'kaps_encrypt' );
		register_setting( 'gothamazonbat_first-settings-group', 'gothamazon_ama_key',					'kaps_encrypt' );
		
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_ama_login',				'sanitize_text_field');
		
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_ama_track', 				'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_marketplace', 		'sanitize_text_field' );
		
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_legal', 			'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_powered', 			'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_cloaking', 		'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_cloakingimage', 	'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_hidetitre', 		'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_amaprime', 		'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_prixbarre', 		'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_rating', 			'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_aturner', 			'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_speedboutique', 	'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_urlgta', 			'sanitize_url' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_boodisplayprice',	'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_economycostapi', 	'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_neufunik', 		'sanitize_text_field' );

		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_cachingtime', 		'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_sortbay', 		 	'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_vendeur', 		 	'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_css', 		 		'sanitize_text_field' );
		
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_color_cta', 		'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_color_price_bg', 	'sanitize_text_field' );
		
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_css_rowshop', 		'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_css_rowcatspeed', 	'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_css_yourstyle',	'gothamazon_sanitize_css' );
		
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_ama_track2', 				'sanitize_text_field' ); // Multicompte
		register_setting( 'gothamazonbat-settings-group', 'gtz_tokyo4', 						'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gtz_tokyo4_3bay', 					'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gtz_linquery_default', 				'sanitize_text_field' );
		register_setting( 'gothamazonbat-settings-group', 'gtz_awin_ref_id', 					'sanitize_text_field' );
		
		register_setting( 'gothamazonbat-settings-group', 'gothamazon_option_marchandlogo', 	'sanitize_text_field' );
		
		add_action('admin_enqueue_scripts', 'check_licence_update');
		
	}

	///////////////////////////////////
	// On créé le menu de l'admin
	//////////////////////////////////

	add_action('admin_menu','gothamazon_setupmenu');
	function gothamazon_setupmenu(){
		
		  add_menu_page('Configuration de Amazon Speed', 'GothAmazon', 'administrator', 'gothamazon-plugin', 'gothamazon_init_cave', 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE2LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgd2lkdGg9IjE5NC4zMjhweCIgaGVpZ2h0PSIxOTQuMzI3cHgiIHZpZXdCb3g9IjAgMCAxOTQuMzI4IDE5NC4zMjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDE5NC4zMjggMTk0LjMyNzsiDQoJIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPHBhdGggZD0iTTEwNy42OTQsNi43NzJjMCwwLTQuODIyLDE2Ljk0LTUuNDI5LDE2LjU4MWMtMy4xNDgtMS45NjQtOC45NjYtMS43NzgtMTEuNjQ2LTAuMDU4DQoJCWMtMC40MTQtMC45NDctNC4wNTUtMTYuNjQyLTQuMDU1LTE2LjY0MnMtOC43MTcsMjIuNjQzLTYuODU2LDM0Ljc5M2MtMC4zNjIsMy41NDctMC41NjMsMTEuNTQyLDAuMTg2LDEzLjY2MQ0KCQljLTEuNDUyLTEuMDM1LTM0LjEzMi0yMS4xNzUtMzMuNTYzLTM2LjA4NGMtMzEuMDU4LDIuNTYzLTkzLjg2MSwxMjMuMzQ1LDE1LjMyNiwxNjguNjQ4Yy0xMS44NS0xOC43MDYtMTkuNC0zOC41MzMtMTguMDU4LTQ4LjIzOA0KCQljMi40MDUsMS43NzcsNy4xNzYsMTIuNDk0LDIwLjc3MSwxOS4zMDNjMC0zLjk4OSwyLjI4LTIyLjc5OSw3LjgxMi0yOC4zNTJjMi4xMzcsMy4xNjYsMjQuMDY4LDUxLjgzNywyNC4wNjgsNTEuODM3bDI0LjA2Ny01MS44MzcNCgkJYzAsMCw2LjQ2LDIyLjUwNiw0LjUxOCwyOC4wNTljMy4zNS0yLjA5NSwxNy43OC0xMS40MzYsMjEuMDU3LTE5LjAxYzAuOTUsMi45NDcsMC45NDMsMjcuNTQxLTE2LjUzOCw0OC4yMzgNCgkJYzI4LjQxMi0wLjAzNywxMTguMjA5LTEwMi4wOTgsMjAuNjY2LTE2OC44ODljLTEuOTMsOC4yNDItMzEuNTQ4LDM2LjEzOS0zNy4yMjksMzYuMTM5YzAuMDYxLTEuMjcyLDAuODM0LTguNjA3LDAtMTMuNDc2DQoJCUMxMTMuNjc5LDM5LjQ0MSwxMTAuNzYzLDE5LjM0NCwxMDcuNjk0LDYuNzcyeiIvPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=' );
		  
	}

	///////////////////////////////////
	// On charge le JS CSS de l'admin
	//////////////////////////////////
	function gothamazon_monjsdansladmin() {
		
		echo "<style>.gotham_ad_wrap{margin:20px}.gotham_ad_form{width:70%;background:#665e5e;margin:0 auto;float:left;padding:40px 0;border-radius:8px}#lefameuxform{margin:0 auto;width:90%}.gotham_ad_credit{width:23%;background:#fff;box-shadow:0 0 0 1px rgba(0,0,0,.05);padding:1%;margin-left:1%;display:inline-block;border:3px solid;border-radius:5px}#batbaseadmin tr td.libelle{font-weight:700;width:400px}#batbaseadmin input,#batbaseadmin select,#batbaseadmin textarea{width:280px;float:left}.explain{background:#fff;box-shadow:0 0 0 1px rgba(0,0,0,.05)}.explain p, .explain h4{padding:10px;background: #825f5f;color: white;}.explain ul{padding:0 10px;list-style:square inside}.explain li{padding:0}.explain h3{padding:6px 10px;background:black;color:white;text-align:center;}table#batbaseadmin{border:1px solid #444;border-radius:8px;padding:9px;background:#fff;width:100%}table#batbaseadmin tr td{padding:5px 10px}dfn{border-bottom:dashed 1px rgba(0,0,0,.8);padding:0;cursor:help;font-style:normal;position:relative}dfn::after{content:attr(data-info);display:inline;position:absolute;top:22px;left:0;opacity:0;width:230px;font-size:13px;font-weight:700;line-height:1.5em;padding:.5em .8em;background:rgba(0,0,0,.8);color:#fff;pointer-events:none;transition:opacity 250ms,top 250ms}dfn::before{content:'';display:block;position:absolute;top:12px;left:20px;opacity:0;width:0;height:0;border:solid transparent 5px;border-bottom-color:rgba(0,0,0,.8);transition:opacity 250ms,top 250ms}dfn:hover{z-index:999}dfn:hover::after,dfn:hover::before{opacity:1}dfn:hover::after{top:30px}dfn:hover::before{top:20px}.mizengarde{background:red;color:#fff;padding:0 10px;display:block;border-radius:3px;margin-top:5px}.restricted2premium{border: 3px solid #aa2b2b;border-radius: 6px;box-shadow: 0 0 10px red;}.restricted2premium::before{content:'🔒 Premium Only';display:block;background:#000;color:#fff;font-weight:700;text-align:center}.gotham_ad_credit ul{list-style:inside square}.gotham_ad_credit h4{background:#000;padding:5px;text-align:center;color:#fff}@media only screen and (max-width:767px){.gotham_ad_form{width:100%}.gotham_ad_credit{width:100%}}
		.blink_me{ animation: blinker 1s linear infinite;}@keyframes blinker {50% {background:yellow;}}</style>";
	
	}
	add_action('admin_enqueue_scripts', 'gothamazon_monjsdansladmin');


	// Ajout du color picker
	function mw_enqueue_color_picker( $hook_suffix ) {
		
		// first check that $hook_suffix is appropriate for your admin page
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'my-script-handle', plugins_url('js/color-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		
	}
	add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );

	// Ajout du ShortCode Editor de Base
	function gothamazonw_tinymce_button() {
		if ( ! current_user_can('edit_posts') 
		  && ! current_user_can('edit_pages') ) {
			return false;
		}

		if ( get_user_option('rich_editing') == 'true') {
			add_filter( 'mce_external_plugins', 'gothamazonw_script_tiny' );
			add_filter( 'mce_buttons', 'gothamazonw_register_button' );
		}
	}

	function gothamazonw_register_button( $buttons ) {
		array_push( $buttons, '|', 'kapsuleamaz_bouton' );
		return $buttons;
	}
	add_action( 'admin_init', 'gothamazonw_tinymce_button' );
	

	function gothamazonw_script_tiny( $plugin_array ) { // /!\ On rattache ca au marketplace et non au langage du WP, car les paramètres de l'API Amazon diffèrent selon le MktPlace
		global $marketplace_id;
		if ((BEERUS == 'premium') OR (BEERUS == 'godmod') ) { // PREMIUM
			if ($marketplace_id == 'en_US') {
				$plugin_array['kapsulegscript'] = plugins_url( '/js/tinymscript_us.js', __FILE__ );
			}
			else {
				$plugin_array['kapsulegscript'] = plugins_url( '/js/tinymscript.js', __FILE__ );
			}
		}
		else { // FREEMIUM
			if ($marketplace_id == 'en_US') {
				$plugin_array['kapsulegscript'] = plugins_url( '/js/tinymscript_min_us.js', __FILE__ );
			}
			else {
				$plugin_array['kapsulegscript'] = plugins_url( '/js/tinymscript_min.js', __FILE__ );
			}	
		}
		return $plugin_array;
	}
	
	add_action( 'admin_init', 'add_gothamazonw_styles_to_editor' );
	function add_gothamazonw_styles_to_editor() {
		global $editor_styles;
		$editor_styles[] = plugins_url( '/styles.css', __FILE__ );
	}

	// Création de la page d'options du plugin ////////////////
	function gothamazon_init_cave(){
		
	global $msgerreur, $gothamazon_option_color_cta, $gothamazon_option_color_price_bg;
		
	///////////////////////////////////////
	/// Mini zone de langage pour l'admin
	///////////////////////////////////////

	///FRANCAIS
	if ( 'fr_' === substr( get_user_locale(), 0, 3 ) ) {
		
		$txt_adwin_welcome = "🦇 Welcome 2 GothAmazon 🦇";
		$txt_adwin_yes = "Oui";
		$txt_adwin_no = "Non";
		$txt_adwin_login = "Amazon Access Key (Unique Key)";
		$txt_adwin_key = "Amazon Secret Key (Password)";
		$txt_adwin_track = "Amazon Partner Tag (Tracking ID)";
		$txt_adwin_kapsulejeton = "GothamAzon API Key";
		$txt_adwin_firemode = "En moins de 2 minutes vous allez pouvoir déployer une boutique Amazon";
		$txt_adwin_firemode_p = "<ol><li>Saisissez votre <a href='//gothamazon.com' target='_blank'>clé d'API GothamAzon</a></li><li>Saisissez ci-dessous votre <a href='//webservices.amazon.com/paapi5/documentation/register-for-pa-api.html' target='_blank' rel='noreferrer nofollow'>clé d'accès Amazon de l'API Product Advertising (API PA)</a> ainsi que son mot de passe.</li><li>Saisissez votre <a href='https://partenaires.amazon.fr/home/account/tag/manage' target='_blank' rel='noreferrer nofollow'>tracking ID Amazon</a> pour connecter le plugin.</li><li>Définissez les paramètres généraux du plugin ci-dessous.</li><li>Utilisez les widgets ou les shortcodes dans l'éditeur de texte <em>Classic Editor</em> <u>en mode visuel</u> (<a href='https://fr.wordpress.org/plugins/classic-editor/' target='_blank'>à télécharger ici si ce n'est pas déjà fait</a>) pour insérer vos blocs Amazon.</li></ol>";
		$txt_adwin_mecha = "1. Activation du plugin";
		$txt_adwin_helpkapsule = "3. Je soutiens l'éditeur de ce plugin car je suis quelqu'un de bien";
		$txt_adwin_helpkapsule_p = "En sélectionnant OUI, un lien hypertexte <u>discret</u> vers notre site sera inséré en dessous des différents modules du plugin";
		$txt_adwin_helpkapsule_label = "J'accepte le deal";
		$txt_adwin_onparametre_headline = "2. Règlages du plugin";
		$txt_adwin_onparametre_p = "Je paramètre ma boutique de manière générale :";
		$txt_adwin_onparametre_p2 = "Paramètres pour le module Gotham Spotlight by KW/ASIN :";
		$txt_adwin_onparametre_p3 = "Paramètres pour le module Gotham Store :";
		$txt_adwin_blokright_title = "Besoin d’aide ?";
		$txt_adwin_blokright_corpus_1 = "Si vous rencontrez d'autres problèmes avec cette extension, vous trouverez probablement des réponses dans ces deux pages :";
		$txt_adwin_blokright_corpus_2 = "Documentation";
		$txt_adwin_blokright_corpus_3 = "Forum de Support";
		$txt_adwin_blokright_aime = "Vous aimez cette extension ?";
		$txt_adwin_blokright_vote = "Notez nous 5/5";
		$txt_adwin_blokright_sur = "sur";

	} else { ///ANGLAIS
	
		$txt_adwin_welcome = "🦇 Welcome 2 GothAmzon 🦇";
		$txt_adwin_yes = "Oui";
		$txt_adwin_no = "Non";
		$txt_adwin_login = "Amazon Access Key (Unique Key)";
		$txt_adwin_key = "Amazon Secret Key (Password)";
		$txt_adwin_track = "Amazon Partner Tag (Tracking ID)";
		$txt_adwin_kapsulejeton = "GothamAzon API Key";
		$txt_adwin_firemode = "En moins de 2 minutes vous allez pouvoir déployer une boutique Amazon";
		$txt_adwin_firemode_p = "<ol><li>Saisissez votre <a href='//gothamazon.com' target='_blank'>clé d'API GothamAzon</a></li><li>Saisissez ci-dessous votre <a href='//webservices.amazon.com/paapi5/documentation/register-for-pa-api.html' target='_blank' rel='noreferrer nofollow'>clé d'accès Amazon de l'API Product Advertising (API PA)</a> ainsi que son mot de passe.</li><li>Saisissez votre <a href='https://partenaires.amazon.fr/home/account/tag/manage' target='_blank' rel='noreferrer nofollow'>tracking ID Amazon</a> pour connecter le plugin.</li><li>Définissez les paramètres généraux du plugin ci-dessous.</li><li>Utilisez les widgets ou les shortcodes dans l'éditeur de texte <em>Classic Editor</em> <u>en mode visuel</u> (<a href='https://fr.wordpress.org/plugins/classic-editor/' target='_blank'>à télécharger ici si ce n'est pas déjà fait</a>) pour insérer vos blocs Amazon.</li></ol>";
		$txt_adwin_mecha = "1. Activation du plugin";
		$txt_adwin_helpkapsule = "3. Je soutiens l'éditeur de ce plugin car je suis quelqu'un de bien";
		$txt_adwin_helpkapsule_p = "En sélectionnant OUI, un lien hypertexte <u>discret</u> vers notre site sera inséré en dessous des différents modules du plugin";
		$txt_adwin_helpkapsule_label = "J'accepte le deal";
		$txt_adwin_onparametre_headline = "2. Règlages du plugin";
		$txt_adwin_onparametre_p = "Je paramètre ma boutique de manière générale :";
		$txt_adwin_onparametre_p2 = "Paramètres pour le module Gotham Spotlight by KW/ASIN :";
		$txt_adwin_onparametre_p3 = "Paramètres pour le module Gotham Store :";
		$txt_adwin_blokright_title = "Besoin d’aide ?";
		$txt_adwin_blokright_corpus_1 = "Si vous rencontrez d'autres problèmes avec cette extension, vous trouverez probablement des réponses dans ces deux pages :";
		$txt_adwin_blokright_corpus_2 = "Documentation";
		$txt_adwin_blokright_corpus_3 = "Forum de Support";
		$txt_adwin_blokright_aime = "Vous aimez cette extension ?";
		$txt_adwin_blokright_vote = "Notez nous 5/5";
		$txt_adwin_blokright_sur = "sur";
		
	}
	////////////////////////////////////////

?>
	<div class="gotham_ad_wrap">

	  <div class="gotham_ad_form">
	  
	  <form method="post" action="options.php" id="lefameuxform">
	   
	  <?php // First Launch

			$check_if_exist_licence_key = get_option('gothamazon_ama_kapsule_apijeton'); 
			if ($check_if_exist_licence_key == NULL) {
				
					$licence_key_exist = "non";
					
			} else {
				
					$licence_key_exist = "oui";
					
			}

			$check_if_exist_data = get_option('gothamazon_option_powered'); 
			if ($check_if_exist_data == NULL) {
				
					$firstlaunch = "oui";
					
			} else {
				
					$firstlaunch = "non";
					
			}
			
			if (BEERUS == true) { // Si API Key OK => On enregistre tous les paramètres du formulaire
			
				settings_fields( 'gothamazonbat-settings-group' );
				do_settings_sections('gothamazonbat-settings-group');
				
			} elseif ((BEERUS == false) AND ($firstlaunch == "oui")) { // Si API Key DOWN + Premier lancement => On enregistre la clé API + on initie le champ password pour fixer un bug d'encryption
				
				settings_fields( 'gothamazonbat_first-settings-group' ); 
				do_settings_sections('gothamazonbat_first-settings-group'); 
				
				
			} else { // Sinon (API Key Down + Déjà paramétré par le passé) => On enregistre la nouvelle API KEY uniquement (pour ne pas effacer les autres settings)
				
				settings_fields( 'gothamazonbat_alt-settings-group' ); 
				do_settings_sections('gothamazonbat_alt-settings-group'); 
				
			} 
		?>

		  <table id="batbaseadmin">
		
				<tr class="explain">
				<td colspan="2"> 
				<h1><?php echo $txt_adwin_welcome; ?></h1>
			  <h3>🔥 <?php echo $txt_adwin_firemode; ?> 🚀</h3>
			  <?php echo $txt_adwin_firemode_p; ?>
				</td>
				</tr>
			<tr class="explain">
				<td colspan="2">
			  <h3><?php echo $txt_adwin_mecha; ?></h3>
				</td>
			</tr>
			
			<tr>
				  <td class="libelle">
					<label for="gothamazon_ama_kapsule_apijeton">
						🤫 <dfn data-info="Validez puis rafraichissez cette page pour que le changement de licence soit pris en compte."><?php echo $txt_adwin_kapsulejeton; ?></dfn>
						<?php if ($licence_key_exist == "oui") { // Si le champ API Key est rempli
									if (BEERUS != false) { // Si la connexion se fait
									
										echo "<span style='color:green;'>OK</span> ("; echo BEERUS.")";
										
									} else { // Sinon, si pas de connexion
									
										echo "<br /><span style='color:red;'>⚠️ Clé Invalide</span>";
										
									} 
							} 
						?>
						<?php if (BEERUS == false) { ?>
						
							.:. <a href="https://gothamazon.com/free.php" target="_blank" rel="nofollow noopener noreferrer" class="blink_me">Obtenir une clé 🔑</a>
							
						<?php } // Si pas de connexion ?>
						
						<?php if ((!empty($msgerreur) AND ($firstlaunch == "non"))) {
							
							echo "<p style='color:red;'>$msgerreur</p>";
							
						} // S'il y a un message d'erreur et que ce n'est pas la première connexion ?>
						
					</label>
				</td>
				<td><input type="text" id="gothamazon_ama_kapsule_apijeton" name="gothamazon_ama_kapsule_apijeton" value="<?php echo get_option('gothamazon_ama_kapsule_apijeton'); ?>" /></td>
			  </tr>
			  
			  <?php if (BEERUS == true) { 
			  
				$check_if_ama_entered = get_option('gothamazon_ama_login'); 
				if (($firstlaunch == "non") AND ($check_if_ama_entered == "")) {
					
					$css_semihide = "style='opacity:0.4;'";
					$what_api_enabled = "💘 API 3RD ONLY";
					
				} else {
					
					$css_semihide = false;
					$what_api_enabled = "✅";
					
				} ?>
				
				<tr class="explain"><td colspan="2"><h3 style="background:#666";>Amazon API <?php echo $what_api_enabled; ?></h3></td></tr>
				<tr <?php echo $css_semihide; ?>>
				  <td class="libelle"><label for="gothamazon_option_marketplace"><dfn data-info="Choix du marché Amazon">🌍 Marketplace</dfn></label></td>
				  <td>
					<?php $gothamazon_option_marketplace = get_option('gothamazon_option_marketplace'); ?>
					<select id="gothamazon_option_marketplace" name="gothamazon_option_marketplace" value="<?php echo get_option('gothamazon_option_marketplace'); ?>">
						<option value="fr_FR" <?php selected( $gothamazon_option_marketplace, 'fr_FR' ); ?>>FR 🇫🇷</option>
						<option value="en_US" <?php selected( $gothamazon_option_marketplace, 'en_US' ); ?>>US 🇺🇸</option>
					</select>
					</td>
			  </tr>
			  <tr <?php echo $css_semihide; ?>>
				  <td class="libelle"><label for="gothamazon_ama_login">🧨 <?php echo $txt_adwin_login; ?> / <a href="https://webservices.amazon.com/paapi5/documentation/register-for-pa-api.html" target="_blank" rel="nofollow noopener noreferrer">Help</a></label></td>
				  <td><input type="text" id="gothamazon_ama_login" name="gothamazon_ama_login" value="<?php echo get_option('gothamazon_ama_login'); ?>"  autocomplete="new-password" /></td>
			  </tr>
			  <tr <?php echo $css_semihide; ?>>
				   <td class="libelle"><label for="gothamazon_ama_key">🔑 <?php echo $txt_adwin_key; ?> / <a href="https://webservices.amazon.com/paapi5/documentation/register-for-pa-api.html" target="_blank" rel="nofollow noopener noreferrer">Help</a></label></td>
				   <?php $cryptedkey = get_option('gothamazon_ama_key');$uncrypt_ama_key = kaps_decrypt("$cryptedkey");  ?>
				  <td><input type="password" id="gothamazon_ama_key" name="gothamazon_ama_key" value="<?php echo $uncrypt_ama_key; ?>"  autocomplete="new-password" /></td>
			  </tr>
			  <tr <?php echo $css_semihide; ?>>
				  <td class="libelle"><label for="gothamazon_ama_track">🏷️ <?php echo $txt_adwin_track; ?> / <a href="https://partenaires.amazon.fr/home/account/tag/manage" target="_blank" rel="nofollow noopener noreferrer">Help</a></label></td>
				  <td><input type="text" id="gothamazon_ama_track" name="gothamazon_ama_track" value="<?php echo get_option('gothamazon_ama_track'); ?>"  autocomplete="new-password" /></td>
			  </tr>
			 
			  <tr class="explain">
				<td colspan="2">
			  <h3><?php echo $txt_adwin_onparametre_headline; ?></h3>
			  <p>⚙️ <?php echo $txt_adwin_onparametre_p; ?></p>
				</td>
				</tr>
				 
			   <tr>
				  <td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_cloaking"><dfn data-info="Obfusquera en JS vos liens">👻 Cloaking Link :</dfn></label></td>
				  <td>
					<?php $gothamazon_option_cloaking = get_option('gothamazon_option_cloaking'); ?>
					<select id="gothamazon_option_cloaking" name="gothamazon_option_cloaking" value="<?php echo get_option('gothamazon_option_cloaking'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="non" <?php selected( $gothamazon_option_cloaking, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
						<option value="oui" <?php selected( $gothamazon_option_cloaking, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ✔️</option>
					</select>
					</td>
			  </tr>
			  
			  <tr>
				  <td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_cloakingimage"><dfn data-info="Remplacera l'url de l'annonceur par l'url de votre site dans la source de l'image ⚠️ (Couteux en ressource sur certain feeds)">👻 Cloaking SRC Image ⚠️ :</dfn></label></td>
				  <td>
					<?php $gothamazon_option_cloakingimage = get_option('gothamazon_option_cloakingimage'); ?>
					<select id="gothamazon_option_cloakingimage" name="gothamazon_option_cloakingimage" value="<?php echo get_option('gothamazon_option_cloakingimage'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="non" <?php selected( $gothamazon_option_cloakingimage, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
						<option value="oui" <?php selected( $gothamazon_option_cloakingimage, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ✔️</option>
					</select>
					</td>
			  </tr>
			<tr>
				<td colspan="2" style="background:#eee;"></td>
			</tr>
			 
			  <tr <?php echo $css_semihide; ?>>
				  <td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_sortbay"><dfn data-info="Quels sera le critère utilisé pour effectuer votre requête : pertinence / nouveauté / moins cher ... Ce paramètre peut être écrasé via shortcodes / widgets. Laissez sur défaut pour économiser l'API Amazon">🔃 Tri par défaut :</dfn></label></td>
				  <td>
					<?php $gothamazon_option_sortbay = get_option('gothamazon_option_sortbay'); ?>
					<select id="gothamazon_option_sortbay" name="gothamazon_option_sortbay" value="<?php echo get_option('gothamazon_option_sortbay'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="Default" <?php selected( $gothamazon_option_sortbay, 'Default' ); ?>>🍉 Par défaut (ECO API)</option>
						<option value="Relevance" <?php selected( $gothamazon_option_sortbay, 'Relevance' ); ?>>💥 Pertinence</option>
						<option value="AvgCustomerReviews" <?php selected( $gothamazon_option_sortbay, 'AvgCustomerReviews' ); ?>>⭐ Mieux notés</option>
						<option value="Featured" <?php selected( $gothamazon_option_sortbay, 'Featured' ); ?>>🔥 Recommandés</option>
						<option value="NewestArrivals" <?php selected( $gothamazon_option_sortbay, 'NewestArrivals' ); ?>>🌶️ Nouveautés</option>
						<option value="Price:LowToHigh" <?php selected( $gothamazon_option_sortbay, 'Price:LowToHigh' ); ?>>🏷️ Moins cher d'abord</option>
						<option value="Price:HighToLow" <?php selected( $gothamazon_option_sortbay, 'Price:HighToLow' ); ?>>💸️ Plus cher d'abord</option>
					</select>
					</td>
			  </tr>
			  
			  

			  <tr <?php echo $css_semihide; ?>>
				  <td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_neufunik"><dfn data-info="Influera notamment sur le prix affiché. Ex : si un article est disponible en occasion à 500€ et neuf à 800€, le prix affiché sera de 500€ mais la landing page sera pluggué sur celui à 800€. Attention, peut retourner un flux vide si aucun item n'est trouvé dans l'état souhaité">🏷️ Etat des articles : </dfn></label></td>
				  <td>
					<?php $gothamazon_option_neufunik = get_option('gothamazon_option_neufunik'); ?>
					<select id="gothamazon_option_neufunik" name="gothamazon_option_neufunik" value="<?php echo get_option('gothamazon_option_neufunik'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="New" <?php selected( $gothamazon_option_neufunik, 'New' ); ?>>Neufs uniquement</option>
						<option value="Any" <?php selected( $gothamazon_option_neufunik, 'Any' ); ?>>Tous (ECO API)</option>
						<option value="Used" <?php selected( $gothamazon_option_neufunik, 'Used' ); ?>>Occasion</option>
						<option value="Collectible" <?php selected( $gothamazon_option_neufunik, 'Collectible' ); ?>>Collection</option>
						<option value="Refurbished" <?php selected( $gothamazon_option_neufunik, 'Refurbished' ); ?>>Remis à neuf</option>
					</select>
					</td>
			  </tr>
			   <tr <?php echo $css_semihide; ?>>
				<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_vendeur"><dfn data-info="Voulez-vous afficher les produits vendus par Amazon uniquement ou également par toute la marketplace ?">🐉 Type de Vendeur :</dfn></label></td>
				  <td>
					<?php $gothamazon_option_vendeur = get_option('gothamazon_option_vendeur'); ?>
					<select id="gothamazon_option_vendeur" name="gothamazon_option_vendeur" value="<?php echo get_option('gothamazon_option_vendeur'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="All" <?php selected( $gothamazon_option_vendeur, 'All' ); ?>>Tous = Amz + Mktplace (ECO API)</option>
						<option value="Amazon" <?php selected( $gothamazon_option_vendeur, 'Amazon' ); ?>>Amazon seulement</option>
					</select>
					</td>
			  </tr>
			  <tr>
				<td colspan="2" style="background:#eee;"></td>
			  </tr>
			  <tr>
				<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_css"><dfn data-info="Utiliser ou non le CSS du plugin">✅ Utiliser le CSS du Plugin :</dfn></label></td>
				  <td>
					<?php $gothamazon_option_css = get_option('gothamazon_option_css'); ?>
					<select id="gothamazon_option_css" name="gothamazon_option_css" value="<?php echo get_option('gothamazon_option_css'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="oui" <?php selected( $gothamazon_option_css, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ✔️</option>
						<option value="non" <?php selected( $gothamazon_option_css, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
					</select>
					</td>
			  </tr>
			  <tr>
					<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_color_cta">🎨 Couleur du Bouton :</label></td>
					<td><input type="text" id="gothamazon_option_color_cta" name="gothamazon_option_color_cta" value="<?php echo $gothamazon_option_color_cta; ?>" class="my-color-field" data-default-color="#2bd899" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?> /></td>
			  </tr>
			  
			  <tr>
					<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_color_price_bg">🎨 Couleur du Prix :</label></td>
					<td><input type="text" id="gothamazon_option_color_price_bg" name="gothamazon_option_color_price_bg" value="<?php echo $gothamazon_option_color_price_bg; ?>" class="my-color-field" data-default-color="#f92457" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?> /></td>
			  </tr>
			   <tr>
					<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_css_yourstyle">🎨 Ajouter du CSS Perso :</label></td>
					<?php $gothamazon_option_css_yourstyle = get_option('gothamazon_option_css_yourstyle'); ?>
					<td><textarea id="gothamazon_option_css_yourstyle" name="gothamazon_option_css_yourstyle" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>><?php echo $gothamazon_option_css_yourstyle; ?></textarea></td>
			  </tr>
			  
			   <tr>
				<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_css_rowshop">🔢 Nombre de colonnes d'une page boutique (par défaut)</label></td>
				  <td>
					<?php $gothamazon_option_css_rowshop = get_option('gothamazon_option_css_rowshop'); ?>
					<select id="gothamazon_option_css_rowshop" name="gothamazon_option_css_rowshop" value="<?php echo get_option('gothamazon_option_css_rowshop'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="3" <?php selected( $gothamazon_option_css_rowshop, '3' ); ?>>3</option>
						<option value="2" <?php selected( $gothamazon_option_css_rowshop, '2' ); ?>>2</option>
						<option value="4" <?php selected( $gothamazon_option_css_rowshop, '4' ); ?>>4</option>
						<option value="5" <?php selected( $gothamazon_option_css_rowshop, '5' ); ?>>5</option>
					</select>
					</td>
			  </tr>
			  <tr>
				  <td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_boodisplayprice"><dfn data-info="Afficher par défaut les prix des articles. Ce paramètre peut être écrasé via shortcodes / widgets">💶 Affichage du prix des items (par défaut)</dfn></label></td>
				  <td>
					<?php $gothamazon_option_boodisplayprice = get_option('gothamazon_option_boodisplayprice'); ?>
					<select id="gothamazon_option_boodisplayprice" name="gothamazon_option_boodisplayprice" value="<?php echo get_option('gothamazon_option_boodisplayprice'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="oui" <?php selected( $gothamazon_option_boodisplayprice, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ✔️</option>
						<option value="non" <?php selected( $gothamazon_option_boodisplayprice, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
					</select>
					</td>
			  </tr>
			  <tr>
				<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_rating"><dfn data-info="Afficher ou non de manière aléatoire des étoiles sous le produit. Note entre 4.5 et 5/5">🌟 Affichage du ratings (par défaut)</dfn></label></td>
				  <td>
					<?php $gothamazon_option_rating = get_option('gothamazon_option_rating'); ?>
					<select id="gothamazon_option_rating" name="gothamazon_option_rating" value="<?php echo get_option('gothamazon_option_rating'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="non" <?php selected( $gothamazon_option_rating, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
						<option value="oui" <?php selected( $gothamazon_option_rating, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ✔️</option>
					</select>
					</td>
			  </tr>
			   <tr>
				<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_marchandlogo"><dfn data-info="Afficher ou non le logo du commerçant">👁 Affichage du logo du marchand (par défaut)</dfn></label></td>
				  <td>
					<?php $gothamazon_option_marchandlogo = get_option('gothamazon_option_marchandlogo'); ?>
					<select id="gothamazon_option_marchandlogo" name="gothamazon_option_marchandlogo" value="<?php echo get_option('gothamazon_option_marchandlogo'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="oui" <?php selected( $gothamazon_option_marchandlogo, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ✔️</option>
						<option value="non" <?php selected( $gothamazon_option_marchandlogo, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
					</select>
					</td>
			  </tr>
			   <tr>
				  <td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_cachingtime"><dfn data-info="Combien de temps le flux Amazon doit-il être conservé en cache ? (Max & Défaut = 24H)">⌛ Durée de mise en cache du flux</dfn></label></td>
				  <td>
					<?php $gothamazon_option_cachingtime = get_option('gothamazon_option_cachingtime'); ?>
					<select id="gothamazon_option_cachingtime" name="gothamazon_option_cachingtime" value="<?php echo get_option('gothamazon_option_cachingtime'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="86400" <?php selected( $gothamazon_option_cachingtime, '86400' ); ?>>24H</option>
						<option value="43200" <?php selected( $gothamazon_option_cachingtime, '43200' ); ?>>12H</option>
						<option value="21600" <?php selected( $gothamazon_option_cachingtime, '21600' ); ?>>6H</option>
						<option value="7200" <?php selected( $gothamazon_option_cachingtime, '7200' ); ?>>2H</option>
						<option value="3600" <?php selected( $gothamazon_option_cachingtime, '3600' ); ?>>1H</option>
						<option value="1800" <?php selected( $gothamazon_option_cachingtime, '1800' ); ?>>30 Min</option>
					</select>
					</td>
			  </tr>
			  <tr>
				  <td class="libelle"><label for="gothamazon_option_legal"><dfn data-info="Afficher par défaut les mentions Amazon relatives au cache sur les prix des produits et sur la participation au programme partenaire">⚖️ Affichage des mentions légales (par défaut)</dfn></label></td>
				  <td>
					<?php $gothamazon_option_legal = get_option('gothamazon_option_legal'); ?>
					<select id="gothamazon_option_legal" name="gothamazon_option_legal" value="<?php echo get_option('gothamazon_option_legal'); ?>">
						<option value="oui" <?php selected( $gothamazon_option_legal, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ✔️</option>
						<option value="non" <?php selected( $gothamazon_option_legal, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
					</select>
					</td>
			  </tr>
			  <tr <?php echo $css_semihide; ?>>
				  <td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_ama_track2"><dfn data-info="Utilisera un deuxième TAG Amazon aléatoirement à 50/50 : idéal pour un site géré à 2">🏷️ <?php echo $txt_adwin_track; ?> #2</dfn></label></td>
				  <td><input type="text" id="gothamazon_ama_track2" name="gothamazon_ama_track2" value="<?php echo get_option('gothamazon_ama_track2'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>/></td>
			  </tr>
			  
					 
			<tr class="explain">
				<td colspan="2">
					<h4><center>Paramètres pour les modules Gotham Inline Text by KW/ASIN</center></h4>
				</td>
			</tr>
			<tr>
				<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>">
					<label for="gothamazon_option_urlgta"><dfn data-info="Le module inline va chercher à faire un lien vers un produit qui match avec votre requête. Selon les cas, s'il ne peut pas trouver d'items mais doit faire un lien (cas du CTA), il renverra dans le pire des cas vers cette url. Si vous utilisez la balise %GTZ_QUERY% dans l'URL du parachute, notre module remplacera cette dernière par le mot clé que vous cherchiez à atteindre initialement">🪂 URL Parachute :</dfn></label>
				</td>
				<?php $gothamazon_option_urlgta = get_option('gothamazon_option_urlgta'); ?>
				<td>
					<input type="text" id="gothamazon_option_urlgta" name="gothamazon_option_urlgta" value="<?php echo $gothamazon_option_urlgta; ?>" 
					<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled"; } ?> 
					/>
				</td>
			</tr>
			  <tr>
				  <td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_economycostapi"><dfn data-info="Plutot que de lancer l'API Amazon au chargement de la page pour chercher une item (ce qui utilise votre quota), le module lancera l'API uniquement lorsque l'utilisateur cliquera sur le lien, puis mettra le résultat en cache 24H. Super pour ne pas cramer votre quota de l'API Amazon">📉 Appeler API Amazon au clic uniquement</dfn> <dfn data-info="Ne fonctionne pas si l'execution de PHP est désactivé dans le répertoire des extensions par un plugin de sécurité. De plus, vous devrez avoir activé le cloaking des liens dans les paramètres généraux ci-dessus (CLOAKING LINK)">⚠️⚠️⚠️</dfn></label></td>
				  <td>
					<?php $gothamazon_option_economycostapi = get_option('gothamazon_option_economycostapi'); ?>
					<select id="gothamazon_option_economycostapi" name="gothamazon_option_economycostapi" value="<?php echo get_option('gothamazon_option_economycostapi'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="non" <?php selected( $gothamazon_option_economycostapi, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
						<option value="oui" <?php selected( $gothamazon_option_economycostapi, 'oui' ); ?> ><?php echo $txt_adwin_yes; ?> ✔️</option>
					</select>
					</td>
			  </tr>
			
			  <tr class="explain">
				<td colspan="2">
			  <h4><center><?php echo  $txt_adwin_onparametre_p2; ?></center></h4>
				</td>
			 </tr>
			  <tr <?php echo $css_semihide; ?>>
				<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_amaprime"><dfn data-info="Affichera le logo PRIME si produit éligible. Peut être déclencheur d'achat mais révèle indirectement à l'internaute qu'il va terminer sur Amazon">🚀 Affichage du logo Prime</dfn></label></td>
				  <td>
					<?php $gothamazon_option_amaprime = get_option('gothamazon_option_amaprime'); ?>
					<select id="gothamazon_option_amaprime" name="gothamazon_option_amaprime" value="<?php echo get_option('gothamazon_option_amaprime'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="oui" <?php selected( $gothamazon_option_amaprime, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ️✔️</option>
						<option value="non" <?php selected( $gothamazon_option_amaprime, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
					</select>
					</td>
			  </tr>
			  
				  <tr>
				<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_prixbarre"><dfn data-info="Affichera un encart prix barré (ancien prix, nouveau prix, économie réalisée) si le produit est actuellement en promotion.">🤑 Affichage d'un éventuel Prix Barré</dfn></label></td>
				  <td>
					<?php $gothamazon_option_prixbarre = get_option('gothamazon_option_prixbarre'); ?>
					<select id="gothamazon_option_prixbarre" name="gothamazon_option_prixbarre" value="<?php echo get_option('gothamazon_option_prixbarre'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="oui" <?php selected( $gothamazon_option_prixbarre, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ✔️</option>
						<option value="non" <?php selected( $gothamazon_option_prixbarre, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
					</select>
					</td>
			  </tr>
			  
			   
			
			  <tr class="explain">
				<td colspan="2">
			  <h4><center><?php echo  $txt_adwin_onparametre_p3; ?></center></h4>
				</td>
			 </tr>
			  <tr>
				  <td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_hidetitre">🤐 Masquer le titre du produit (Réglages par défaut)</label></td>
				  <td>
					<?php $gothamazon_option_hidetitre = get_option('gothamazon_option_hidetitre'); ?>
					<select id="gothamazon_option_hidetitre" name="gothamazon_option_hidetitre" value="<?php echo get_option('gothamazon_option_hidetitre'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="non" <?php selected( $gothamazon_option_hidetitre, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
						<option value="oui" <?php selected( $gothamazon_option_hidetitre, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ✔️</option>
					</select>
					</td>
			  </tr>
			
			  <tr>
				  <td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_aturner"><dfn data-info="A la fin d'un module Gotham Store by KW, on peut afficher un bouton 'voir les autres articles' qui pointera vers la page de résultat Amazon de votre recherche. Paramétrez ici à partir de combien d'items ce bouton s'affiche ou le cas échéant s'il ne doit jamais s'afficher.">👀 Afficher le bouton + d'articles à partir de combien d'articles:</dfn></label></td>
				  <td>
					<?php $gothamazon_option_aturner = get_option('gothamazon_option_aturner'); ?>
					<select id="gothamazon_option_aturner" name="gothamazon_option_aturner" value="<?php echo get_option('gothamazon_option_aturner'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="non" <?php selected( $gothamazon_option_aturner, '0' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
						<option value="1" <?php selected( $gothamazon_option_aturner, '1' ); ?>>1</option>
						<option value="2" <?php selected( $gothamazon_option_aturner, '2' ); ?>>2</option>
						<option value="3" <?php selected( $gothamazon_option_aturner, '3' ); ?>>3</option>
						<option value="4" <?php selected( $gothamazon_option_aturner, '4' ); ?>>4</option>
						<option value="5" <?php selected( $gothamazon_option_aturner, '5' ); ?>>5</option>
						<option value="6" <?php selected( $gothamazon_option_aturner, '6' ); ?>>6</option>
						<option value="7" <?php selected( $gothamazon_option_aturner, '7' ); ?>>7</option>
						<option value="8" <?php selected( $gothamazon_option_aturner, '8' ); ?>>8</option>
						<option value="9" <?php selected( $gothamazon_option_aturner, '9' ); ?>>9</option>
						<option value="10" <?php selected( $gothamazon_option_aturner, '10' ); ?>>10</option>
					</select>
					</td>
			  </tr>

			  <tr class="explain">
				<td colspan="2">
				<h4><center>SpeedyShop Factory</center></h4>
				</td>
			 </tr>
			 <tr>
				<td class="libelle<?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo " restricted2premium"; } ?>"><label for="gothamazon_option_css_rowcatspeed">🔢 Nombre de colonnes du listing des catégories</label></td>
				  <td>
					<?php $gothamazon_option_css_rowcatspeed = get_option('gothamazon_option_css_rowcatspeed'); ?>
					<select id="gothamazon_option_css_rowcatspeed" name="gothamazon_option_css_rowcatspeed" value="<?php echo get_option('gothamazon_option_css_rowcatspeed'); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) { echo "disabled"; } ?>>
						<option value="3" <?php selected( $gothamazon_option_css_rowcatspeed, '3' ); ?>>3</option>
						<option value="2" <?php selected( $gothamazon_option_css_rowcatspeed, '2' ); ?>>2</option>
						<option value="4" <?php selected( $gothamazon_option_css_rowcatspeed, '4' ); ?>>4</option>
						<option value="5" <?php selected( $gothamazon_option_css_rowcatspeed, '5' ); ?>>5</option>
					</select>
					</td>
			  </tr>

			  <?php if (BEERUS == "godmod") { ?>
				
				<tr>
				  <td class="libelle"><label for="gothamazon_option_speedboutique">🎣 Capture d'image AMZ pour la SpeedBoutique :</label></td>
				  <td>
					<?php $gothamazon_option_speedboutique = get_option('gothamazon_option_speedboutique'); ?>
					<select id="gothamazon_option_speedboutique" name="gothamazon_option_speedboutique" value="<?php echo get_option('gothamazon_option_speedboutique'); ?>">
						<option value="non" <?php selected( $gothamazon_option_speedboutique, 'non' ); ?>>Image AMZ (Capture Off ❌)</option>
						<option value="oui" <?php selected( $gothamazon_option_speedboutique, 'oui' ); ?>>Image AMZ (Capture ON ✔️)</option>
						<option value="image_ala_une" <?php selected( $gothamazon_option_speedboutique, 'image_ala_une' ); ?>>Image à la une 🥽</option>
					</select>
					</td>
				</tr>
				<tr class="explain">
				<td colspan="2">
					<h4><center>NEXT LEVEL</center></h4>
				</td>
				</tr>
				<tr>
				  <td class="libelle"><label for="gtz_tokyo4">☢️ Tokyo 4 :</label></td>
				  <td>
					<?php $gtz_tokyo4 = get_option('gtz_tokyo4'); ?>
					<select id="gtz_tokyo4" name="gtz_tokyo4" value="<?php echo get_option('gtz_tokyo4'); ?>">
						<option value="oui" <?php selected( $gtz_tokyo4, 'oui' ); ?>>ON ✔️</option>
						<option value="non" <?php selected( $gtz_tokyo4, 'non' ); ?>>Off ❌</option>
					</select>
					</td>
				</tr>
				<tr>
				  <td class="libelle"><label for="gtz_tokyo4_3bay">🔨 API Default :</label></td>
				  <td>
					<?php $gtz_tokyo4_3bay = get_option('gtz_tokyo4_3bay'); ?>
					<select id="gtz_tokyo4_3bay" name="gtz_tokyo4_3bay" value="<?php echo get_option('gtz_tokyo4_3bay'); ?>">
						<option value="amazon" <?php selected( $gtz_tokyo4_3bay, 'amazon' ); ?>>Amazon</option>
						<option value="americantourister" <?php selected( $gtz_tokyo4_3bay, 'americantourister' ); ?>>American Tourister</option>
						<option value="boulanger" <?php selected( $gtz_tokyo4_3bay, 'boulanger' ); ?>>Boulanger</option>
						<option value="cdiscount" <?php selected( $gtz_tokyo4_3bay, 'cdiscount' ); ?>>Cdiscount</option>
						<option value="deguisetoi" <?php selected( $gtz_tokyo4_3bay, 'deguisetoi' ); ?>>Deguisetoi</option>
						<option value="ebay" <?php selected( $gtz_tokyo4_3bay, 'ebay' ); ?>>eBay</option>
						<option value="fnacbook" <?php selected( $gtz_tokyo4_3bay, 'fnacbook' ); ?>>Fnac (Livres)</option>
						<option value="lego" <?php selected( $gtz_tokyo4_3bay, 'lego' ); ?>>LEGO</option>
						<option value="manomano" <?php selected( $gtz_tokyo4_3bay, 'manomano' ); ?>>Manomano</option>
						<option value="wegoboard" <?php selected( $gtz_tokyo4_3bay, 'wegoboard' ); ?>>Wegoboard</option>
						<option value="global_pets" <?php selected( $gtz_tokyo4_3bay, 'global_pets' ); ?>>⭐ Animaux</option>
						<option value="global_beaute" <?php selected( $gtz_tokyo4_3bay, 'global_beaute' ); ?>>⭐ Beauté</option>
						<option value="global_bebe" <?php selected( $gtz_tokyo4_3bay, 'global_bebe' ); ?>>⭐ Bébé & Maternité</option>
						<option value="global_bijoux" <?php selected( $gtz_tokyo4_3bay, 'global_bijoux' ); ?>>⭐ Bijoux & Montres</option>
						<option value="global_gift" <?php selected( $gtz_tokyo4_3bay, 'global_gift' ); ?>>⭐ Cadeaux Originaux</option>
						<option value="global_geek" <?php selected( $gtz_tokyo4_3bay, 'global_geek' ); ?>>⭐ Geek</option>
						<option value="global_jv" <?php selected( $gtz_tokyo4_3bay, 'global_jv' ); ?>>⭐ Jeux Vidéos</option>
						<option value="global_jouets" <?php selected( $gtz_tokyo4_3bay, 'global_jouets' ); ?>>⭐ Jouets</option>
						<option value="global_home" <?php selected( $gtz_tokyo4_3bay, 'global_home' ); ?>>⭐ Maison / Bricolage</option>
						<option value="global_mobilite" <?php selected( $gtz_tokyo4_3bay, 'global_mobilite' ); ?>>⭐ Mobilité Urbaine</option>
						<option value="global_mode" <?php selected( $gtz_tokyo4_3bay, 'global_mode' ); ?>>⭐ Mode</option>
						<option value="global_womanwear" <?php selected( $gtz_tokyo4_3bay, 'global_womanwear' ); ?>>⭐ Mode Femme Casual</option>
						<option value="global_optique" <?php selected( $gtz_tokyo4_3bay, 'global_optique' ); ?>>⭐ Optique</option>
						<option value="global_sexy" <?php selected( $gtz_tokyo4_3bay, 'global_sexy' ); ?>>⭐ S3xy</option>
						<option value="global_sport" <?php selected( $gtz_tokyo4_3bay, 'global_sport' ); ?>>⭐ Sport</option>
						<option value="global_tech" <?php selected( $gtz_tokyo4_3bay, 'global_tech' ); ?>>⭐ Tech & Hifi</option>
					</select>
					</td>
				</tr>
				<tr>
				  <td class="libelle"><label for="gtz_linquery_default">🤖 Linquery Default :</label></td>
				  <td>
					<?php $gtz_linquery_default = get_option('gtz_linquery_default'); ?>
					<select id="gtz_linquery_default" name="gtz_linquery_default" value="<?php echo get_option('gtz_linquery_default'); ?>">
						<option value="oui" <?php selected( $gtz_linquery_default, 'oui' ); ?>>ON ✔️</option>
						<option value="non" <?php selected( $gtz_linquery_default, 'non' ); ?>>Off ❌</option>
					</select>
					</td>
				</tr>
				<tr>
					<td class="libelle"><label for="gtz_awin_ref_id">🏷️ Awin ID :</label></td>
					<td><input type="text" id="gtz_awin_ref_id" name="gtz_awin_ref_id" value="<?php echo get_option('gtz_awin_ref_id'); ?>" /></td>
				</tr>
				
				
			<?php } ?>
			
			
			 <tr class="explain">
				<td colspan="2">
				<h4><center>⚡ AMP Ready ⚡</center></h4>
				</td>
			 </tr>
			 <tr>
			 
			 <script>function gtz_ampCSS() {
					var x = document.getElementById("code_du_css_amp");
					if (x.style.display === "none") {
						x.style.display = "contents";
					} else {
						x.style.display = "none";
					}
				} 
			</script>

			<td colspan="2">
				<strong>Notre plugin détecte désormais le GET "?amp=1"</strong> et convertit tous les éléments incompatibles en éléments compatible AMP lorsqu'une page est appellée avec ce paramètre à la fin de l'URL. Ceci étant, dès lors qu'une url est appelée avec le paramètre ?amp=1, le plugin considère qu'il doit afficher une version AMP : l'obfuscation des liens en JS (<em>si activé</em>) disparait et bascule automatiquement sur des liens "normaux" et le CSS se désactive.
				<br /> Si vous utilisez AMP, rajoutez le CSS suivant entre &lt;style amp-custom> et &lt;/style>
				<br />
				<br />
				<span style="font-weight:bold;cursor:pointer;text-decoration:underline;" onclick="gtz_ampCSS()">👁️ Voir le CSS 👁️</span>
			</td>
			 </tr>
			 <tr id="code_du_css_amp" style="display:none;">
				<?php 
				$plugins_url = plugins_url();
				$imgducsshey = "$plugins_url/gothamazon/img/";
				?>
				<td colspan="2"><textarea style="width:100%;height:400px;">/* Gothamazon AMP CSS Version 1.0 */ ul.smartstore{background:#fff;list-style:none;font-family:arial;font-size:13px;border:1px solid #eee;padding: 16px;border-radius:4px;margin:20px 0;display:inline-block;}ul.smartstore a .blob,ul.smartstore a .storeitemtitle{text-decoration:none}ul.izishop92 li{margin:3px 1%;margin-top:3px;list-style:none;padding:0;width:48%;border-radius:3px;display:inline-block}ul.smartstore .gothamrate{margin:5px 0 0;float:none;display:inline-block;width:100px;padding:0}ul.izishop92 .gothamrate{text-align:center;width:100%}ul.smartstore li .ficheproduit span.storeitemfoo{display:block;background:#e9fbeb;width:100%;float:left;border-radius:4px;padding:5px 0;text-align:center}ul.izishop92 li .ficheproduit span.storeitemprice{display:inline-block;color:#fff;font-weight:700;font-size:20px;width:100%;padding:5px 0;border-radius:8px;background:<?php echo $gothamazon_option_color_price_bg; ?>;font-style:italic;text-align:center;margin-bottom:5px}ul.smartstoresidebar li .ficheproduit span.storeitemprice strike, ul.smartstore li .ficheproduit span.storeitemprice strike{color:<?php echo $gothamazon_option_color_price_bg; ?>;background:#fff;white-space:nowrap;float:left;text-align:center;width:100%;font-size:14px}ul.smartstore li .ficheproduit span.storeitemcta{text-align:center;color:#fff;width:80%;border-radius:3px;float:none;margin:2% auto;font-weight:700;padding:4px;display:block;background:<?php echo $gothamazon_option_color_cta; ?>}ul.smartstorespotlight li .ficheproduit span.storeitemcta{font-size:26px}.blob{font-size:12px;text-align:center;display:block;margin:20px 0;color:#000}.elprime{width:90px;display:inline-block;float:right}ul.smartstore li .ficheproduit .vaiamage span{float:left;margin:0;border:1px solid #eee;object-fit:cover;width:32.5%;max-height:100px}.smartstorespotlight .storeitemtitle{font-size:12px;text-align:center;font-weight:700;display:block;clear:both;margin:20px 0;float:left;width:100%}.izishop92 .storeitemtitle{font-size:12px;text-align:center;font-weight:700;text-decoration:none;display:block;clear:both;height:20px;line-height:20px;overflow:hidden}.smartstorelegal{font-size:11px;text-align:center;font-family:arial;line-height:12px;}.pricepromo{font-size:160%;font-family:arial;background-color:<?php echo $gothamazon_option_color_price_bg; ?>;color:#fff;transform:rotate(-1deg);width:100%;display:block;font-style:italic;font-weight:1000;padding:5px 0;text-align:center}.uaresmart{background:#226ab5;color:#fff;display:inline-block;width:100%;padding:3px 0;border-radius:4px;text-align:center}.uaresmart strong,.uaresmart u{color:#fff}ul.smartstorespotlight .bleft,ul.smartstorespotlight .bright{display:block} ul.smartstore li a.ficheproduit.kamesen span.imgkra amp-img{height:160px;display:block;overflow:hidden;}ul.smartstore li a.ficheproduit.kamesen span.imgkra amp-img img{height:160px;overflow:hidden;object-fit:contain}ul.goth_indexboutique{list-style:none;padding:0;margin:0;display:inline-block;width:100%}ul.goth_indexboutique li{list-style:none;width:48%;padding:1%;margin:.5%;display:inline-flex;background:#fff;text-align:center;border-radius:3px}ul.goth_indexboutique li a{width:100%}ul.goth_indexboutique li a amp-img{width:100%;object-fit:contain;height:150px;padding:15px;overflow:hidden}ul.goth_indexboutique li a amp-img img{height:150px;overflow:hidden;object-fit:contain}ul.goth_indexboutique li a span{background:#fff;display:block;color:#000;text-align:center;text-transform:uppercase;font-weight:700;margin:0 auto;width:100%;padding:0 10px}.gtz_amacompliant{background:#181818;	color:#eee;text-align:center;padding:5px;font-size:12px;}.gtz_amz {display:block;float:none;text-align:right;}.izishop92 .gtz_amz {text-align:center;}.gtz_amz img {width:auto;max-width:100%;display:initial;}.ama_itxtlink::before{background:url("<?php echo $imgducsshey; ?>ama_icon.png") no-repeat left center transparent;position:relative;z-index:100000;left:0;top:0;background-size:100% 100%;line-height:12px;width:12px;height:12px;display:inline-block;margin-right:2px;margin-left:2px;content:"\0000a0";opacity:0.8;}.ssjinstinct ul {display: flex;overflow-x: scroll;border-radius:0;scroll-snap-type: x mandatory;}.ssjinstinct ul li {	flex-grow: 1;flex-shrink: 0;flex-basis: 230px;}.ssjinstinct ul li.samba {width: 100%;margin:0 5px;background: transparent;	padding: 0;border-radius: 8px;}.ssjinstinct ul li.jonlok {width: 100%;padding: 0;margin: 0;}.ssjinstinct ul li .bim_blokprod {border-radius:0;}	.ssjinstinct ul::-webkit-scrollbar {height: 26px;background-color: #181818;}.ssjinstinct ul::-webkit-scrollbar-thumb {background-color: #ff5a5f;border-top: 4px solid#181818; border-bottom: 4px solid #181818;}@media only screen and (max-width:1024px) {.gtz_amz {text-align:center;}}.newrules24 {position:absolute;top:24px;left:2px;width: auto;}ul.smartstore li {position:relative;}.gtz-info-icon {position: relative;cursor: pointer;}.gtz-info-icon:hover .gtz-tooltip,.gtz-info-icon:focus .gtz-tooltip {visibility: visible;opacity: 1;}.gtz-tooltip {	  visibility: hidden;width: 120px; background-color: black;color: white;text-align: center;padding: 5px 0;border-radius: 6px;position: absolute;z-index: 1;bottom: 100%;left: 50%;margin-left: -60px;opacity: 0;transition: opacity 0.5s;}.gtz-tooltip::after{content: "";position: absolute;top: 100%;left: 50%;margin-left: -5px;border-width: 5px;border-style: solid;border-color: black transparent transparent transparent;}.pixanchor .gtz-tooltip {position:relative;padding: 5px 10px;}.small_sous_cta{font-size: 10px;font-family: arial; position:absolute;bottom: -15px; right: 0;background: white;border: 1px solid;padding: 1px 5px;opacity: 0.8;border-radius: 3px;} {/* ! Gothamazon AMP CSS */</textarea></td>
			 </tr>
			  
			  
			  <tr class="explain">
				<td colspan="2">
			  <h3><?php echo $txt_adwin_helpkapsule; ?> 💪</h3>
			  <p><?php echo $txt_adwin_helpkapsule_p; ?></p>
				</td>
				</tr>
			  <tr>
				  <td class="libelle"><label for="gothamazon_option_powered"><?php echo $txt_adwin_helpkapsule_label; ?> :</label></td>
				  <td>
					<?php $gothamazon_option_powered = get_option('gothamazon_option_powered'); ?>
					<select id="gothamazon_option_powered" name="gothamazon_option_powered" value="<?php echo get_option('gothamazon_option_powered'); ?>">
						<option value="non" <?php selected( $gothamazon_option_powered, 'non' ); ?>><?php echo $txt_adwin_no; ?> ❌</option>
						<option value="oui" <?php selected( $gothamazon_option_powered, 'oui' ); ?>><?php echo $txt_adwin_yes; ?> ✔️</option>
					</select>
				  </td>
			  </tr>
			  <?php } ?>
		  </table>

	  <?php submit_button(); ?>
	  </form>
	  </div>
	   <div class="gotham_ad_credit">
			<h3>🦇 GothAmazon</h3>
			<div class="inside">
				<h4 class="inner"><?php echo $txt_adwin_blokright_title; ?></h4>
				<p class="inner"><?php echo $txt_adwin_blokright_corpus_1; ?></p>
				<ul>
					<li><a href="https://wordpress.org/plugins/gothamazon/"><?php echo $txt_adwin_blokright_corpus_2; ?></a></li>
					<li><a href="https://wordpress.org/support/plugin/gothamazon/"><?php echo $txt_adwin_blokright_corpus_3; ?></a></li>
				</ul>
				<hr>
				<h4 class="inner">🏆 <?php echo $txt_adwin_blokright_aime; ?></h4>
				<p class="inner">⭐ <a href="https://wordpress.org/support/plugin/gothamazon/reviews/?filter=5#new-post" target="_blank"><?php echo $txt_adwin_blokright_vote; ?></a> <?php echo $txt_adwin_blokright_sur; ?> WordPress.org</p>
				<hr>
				
				
				<?php if (BEERUS == "godmod") {	

							
				$bug_log = GOTHAMZ_UPLOAD_PATH . 'modlog/';
				$gtz_bug_fileList = @scandir( $bug_log );
				
				function gtz_get_link_by_slug($slug, $type = 'post'){
					$post = get_page_by_path($slug, OBJECT, $type);
					if (!is_null($post)) {
						return get_permalink($post->ID);
					} else {
						return "ERROR";
					}
				}
				
				function gtz_get_category_url_by_slug( $category_slug ) {
					$idObj = get_category_by_slug($category_slug); 
					$id = $idObj->term_id;
					return get_category_link($id);	
				}
				
				
					if (!empty($gtz_bug_fileList)) {
						
						echo "<h4 class='inner'>Display Log</h4><ul>";

						foreach($gtz_bug_fileList as $gtz_bug_filename){
							
							if ($gtz_bug_filename == "ZZsidebar") {
								
								echo "<li>⭐ SIDEBAR</li>";
								
							} elseif ('.' !== $gtz_bug_filename && '..' !== $gtz_bug_filename) {
								
								if (strpos($gtz_bug_filename, "ZZELCAT")!== false) {
									
									$gtz_bug_filename = str_replace("ZZELCAT", "", $gtz_bug_filename);
									$io_gtz_page_url = gtz_get_category_url_by_slug("$gtz_bug_filename");
									$label = "🏷️ [CAT] ";
								
									
								} elseif (strpos($gtz_bug_filename, "ZZELTAG") !== false) {
									
									$gtz_tag_id = str_replace("ZZELTAG", "", $gtz_bug_filename);
									$io_gtz_page_url = get_tag_link($gtz_tag_id);
									$tag_info = get_tag($gtz_tag_id); 
									$gtz_bug_filename = $tag_info ->name;
									$label = "🔖 [TAG] ";
									
								} elseif (strpos($gtz_bug_filename, "ZZELPAGE") !== false) {
									
									$gtz_tag_id = str_replace("ZZELPAGE", "", $gtz_bug_filename);
									$io_gtz_page_url = get_permalink($gtz_tag_id);
									$gtz_bug_filename = get_the_title($gtz_tag_id);
									$label = "📄 [PAGE] ";
									
								} else {
									
									$io_gtz_page_url = gtz_get_link_by_slug("$gtz_bug_filename");
									$label = "";
									
								}
								
								if ($io_gtz_page_url != "ERROR") {
									
									echo "<li><a href='$io_gtz_page_url' target='_blank'>$label$gtz_bug_filename</a></li>";
								
								}
								
							}
							
						}
						
						echo"</ul>";
						
					}
					
				}
					
				?>
				
				<hr>
				<h4 class="inner">🔓 Seulement pour les PREMIUMS</h4>
				<ul>
					<li><dfn data-info="Idéal pour ne pas avoir un code source rempli de liens d'affiliation visible des moteurs de recherche">Obfuscation des liens (cloaking JS)</dfn></li>
					<li><dfn data-info="Remplacera amazon.com par l'url de votre site dans la source de l'image">Cloaking des Images</dfn></li>
					<li><dfn data-info="Choisissez si vous voulez afficher les prix (pour mettre en avant le tarif avantageux) ou au contraire le masquer afin d'inciter au clic par un bouton 'voir le prix'">Afficher/Masquer le prix des items</dfn></li>
					<li><dfn data-info="Dans les modules de blocks spotlight, saisissez votre propre titre et description pour éviter le duplicate content">Personnalisation des titres et descriptions</dfn></li>
					<li><dfn data-info="Choisissez si la recherche d'itemps doit se faire par critères de pertinence / prix / nouveauté / mieux notés... de manière générale et + précisémment dans les widgets et shortcodes. Laissez par défaut pour économiser l'API Amazon.">Choix du critère de tri de la requète</dfn></li>
					<li><dfn data-info="N'affichez que les produits neufs, reconditionnés ou de collection, ou affichez tous les produits.">Choix de l'état des produits affichés</dfn></li>
					<li><dfn data-info="N'affichez que les produits vendus par Amazon ou par tout le monde">Choix des vendeurs</dfn></li>
					<li><dfn data-info="N'affichez que les produits en promo et paramétrez le seuil de réduction minimum">Affichage des produits en promo uniquement</dfn></li>
					<li><dfn data-info="Affichera de manière dynamique à coté de votre ancre (à partir de X euros)">Afficher prix dans les modules inline txt</dfn></li>
					<li><dfn data-info="Plutot que de lancer l'API Amazon au chargement de la page pour chercher une item (ce qui utilise votre quota), le module lancera l'API uniquement lorsque l'utilisateur cliquera sur le lien, puis mettra le résultat en cache 24H. Super pour ne pas cramer votre quota de l'API Amazon">Appel API au clic (Modules inline txt)</dfn></li>
					<li><dfn data-info="Construisez un mini eCommerce en 2 clics avec la génération de fake categorie de produits">Speedy Shop Factory</dfn></li>
					<li><dfn data-info="Si le produit que vous avez saisi (via son ID ASIN) n'est plus disponible, on push un produit équivalent grace au mot clé saisit en parachute">Parachute sur les modules par ASIN</dfn></li>
					<li><dfn data-info="Permet de saisir dans vos différents articles un mot clé qui écrasera le mot clé utilisé de manière générale dans vos widgets Ministore et SpotlightQ. Indispensable pour avoir des produits pertinents dans sa sidebar.">Smart Query 4 Widget</dfn></li>
				</ul>
				<h4 class="inner">🌶️ Nos autres plugins</h4>
				<ul>
					<li><a href="https://wordpress.org/plugins/echo-date-4-seo/">Echo Date 4 SEO</a> est un petit plugin 100% GRATUIT qui vous permet d'afficher la date du jour comme si vous éditiez un site en php en dur avec les fonctions "echo date('Y')" ! Idéal en SEO pour chercher la longue traine sans avoir à changer la date de vos articles manuellement !</li>
					<li><a href="https://wordpress.org/plugins/gotham-block-extra-light/">Gotham Block Adblock</a> est un petit plugin 100% Gratuit & ULTRA Light pour bloquer les logiciels Adblock de manière +/- agressive ! Récupérez vos revenus perdus dans la nature !</li>
				</ul>
				<hr>
				<p class="inner">© Copyright <a href="https://www.kapsulecorp.com/">Kapsule Corp</a></p>
			</div>
		</div>
	</div>
	
<?php 

	}
}

// Fin de l'Admin




//////////////////////////////////////////////////
// Ajout de fonctionalités si licence valide
if (BEERUS == true) {
	

	// Module CLoaking Image
	add_action( 'rest_api_init', function () {
			register_rest_route( 'gtz/v1', '/smartimg/(?P<id>[a-zA-Z0-9+-_]+)', array(
					'methods' => 'GET',
					'callback' => 'gothamazon_restapi',
					'permission_callback' => '__return_true',
			) );
	} );
	
	function gothamazon_restapi( $request_data) {
			$amazingtips = $request_data['id'];
			$amazingtips = sanitize_text_field( $amazingtips );
			$madata = "https://m.media-amazon.com/images/I/"; 
			$madata .= $amazingtips;
			$madata .= ".jpg";
			$result = new WP_REST_Response($madata);
			$result->set_headers(array('Cache-Control' => 'max-age=3600'));
			$result->set_status( 301 );
			$result->header( 'Location', "$madata" );
			return $result;
	}
	////

	// WIDGETS
	require_once(GOTHAMZ_ROOTPATH.'/widget_asin.php');
	require_once(GOTHAMZ_ROOTPATH.'/widget_store.php');
	require_once(GOTHAMZ_ROOTPATH.'/widget_spotlight_kw.php');

	// Register and load all the widgets
	function gothamazon_load_widget() {
		
		register_widget( 'hybridq_asin_widget' );
		register_widget( 'gotamazon_shoppingstore_widget' );
		register_widget( 'gotamazon_asin_widget' );
		
	}
	add_action( 'widgets_init', 'gothamazon_load_widget' );


	// Autorise Shortcode de ce plugin en commentaires

	add_filter( 'comment_text', 'do_shortcode' ); 


	/////////////////////////////////////////////////
	// Ajout d'une metabox pour le Widget Intelligent
	if ((BEERUS != "premium") AND (BEERUS != "godmod")) {$lockdown_i= "🔒";$disab = "disabled";} else {$lockdown_i= "⭐";}

	function kapsulewheel_customlink_add_meta_box() {
		
		global $lockdown_i;
		$screens = array('post','page');
		foreach ( $screens as $screen ) {
			add_meta_box(
			  'smartquery4widgetgotham',
			  __( "$lockdown_i GTAMZ KW 4 Widget", 'smartquery4widget' ),
			  'kapsulewheel_customlink_meta_box_callback',
			  $screen, 'side', 'high'
			);
		}
		  
		function kapsulewheel_customlink_meta_box_callback( $post ) {
			
			global $disab;
			wp_nonce_field( 'kapsulewheel_customlink_save_meta_box_data', 'kapsulewheel_customlink_meta_box_nonce' );
			$value = get_post_meta( $post->ID, 'gotham_dynamic_store_widget', true );
			echo "<label for='kapsulewheel_customlink_new_field'>";
			_e( 'Mot clé intelligent :', 'smartquery4widget' );
			echo '</label> ';
			echo '<input type="text" id="kapsulewheel_customlink_new_field" name="kapsulewheel_customlink_new_field" value="' . esc_attr( $value ) . '" size="20" '.$disab.' />';
			echo '<p>Saisissez dans le champ ci-dessus un mot clé, si vous voulez que celui-ci écrase le mot clé utilisé dans vos widgets Ministore et SpotlightQ. (PREMIUM)</p>';
			
		}
	}
	add_action( 'add_meta_boxes', 'kapsulewheel_customlink_add_meta_box' );

	// Uploader le champ personnalisé
	function kapsulewheel_customlink_save_meta_box_data( $post_id ) {
	  if ( ! isset( $_POST['kapsulewheel_customlink_meta_box_nonce'] ) ) {
		return;
	  }
	  if ( ! wp_verify_nonce( $_POST['kapsulewheel_customlink_meta_box_nonce'], 'kapsulewheel_customlink_save_meta_box_data' ) ) {
		return;
	  }
	  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	  }
	  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
		  return;
		}
	  } else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
		  return;
		}
	  }
	  if ( ! isset( $_POST['kapsulewheel_customlink_new_field'] ) ) {
		return;
	  }
	  $my_data = sanitize_text_field( $_POST['kapsulewheel_customlink_new_field'] );
	  update_post_meta( $post_id, 'gotham_dynamic_store_widget', $my_data );
	}
	add_action( 'save_post', 'kapsulewheel_customlink_save_meta_box_data' );
	
	////////////////////////////////////////////////////////////////////////
	// ! Fin de la Metabox
	////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Mentions légales obligatoires Amazon
	//////////////////////////////////////////////////////////////////////////////////////

	if (!empty($secret_amalog)) {
		
		if ((BEERUS == "godmod") AND ($gtz_tokyo4 != "oui")) {
			
			function gothamadblock_amazon_partner_compliant() {
				
				global $gtz_called;
					
				// Provisoire
				if ($gtz_called <= 0) {
					
					echo "<p class='gtz_amacompliant' style='background:#181818;color:#eee;text-align:center;padding:5px;font-size:12px;margin:0;'>Notre site internet participe au programme Partenaire Αmazοn et réalise ainsi un bénéfice sur les achats qui remplissent les conditions requises.</p>";
					
				}
				//! Provisoire
				
				if ($gtz_called > 0) {
					
					global $amp; 
					if ($amp == true) {
						
						echo "<p class='gtz_amacompliant'>Notre site internet participe au programme Partenaire Αmazοn et réalise ainsi un bénéfice sur les achats qui remplissent les conditions requises.</p>";
						
					} else {
						
						echo '<script>document.write("<p class=\'gtz_amacompliant\'>Notre site internet participe au programme Partenaire Αmazοn et réalise ainsi un bénéfice sur les achats qui remplissent les conditions requises.</p>");</script>';
						
					}
				}
				
				
			}
			add_action( 'wp_footer', 'gothamadblock_amazon_partner_compliant' );
			
		} else {
			
			if ($legalytext == "oui") {
				
				global $gtz_called;
				function gothamadblock_amazon_partner_compliant() {
					
					if ($gtz_called > 0) {
					
						echo "<p class='gtz_amacompliant'>En tant que Partenaire Αmazοn, je réalise un bénéfice sur les achats remplissant les conditions requises.</p>";
					
					}
				}
				
				add_action( 'wp_footer', 'gothamadblock_amazon_partner_compliant' );
				
			}
		}
	
	}
	
}