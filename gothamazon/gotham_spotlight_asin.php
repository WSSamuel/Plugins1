<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

function kapsstartasin( $atts, $content = null, $tag = '') {
		
	global $secret_amalog;
	global $secret_amapass;
	global $amazontrackingcode;
	global $amazontrackingcode2;
	global $amazontrackingcode_tracker;
	global $marketplace_id; 
	global $marketplace_w; 
	global $marketplace_region;
	global $cloaking;
	global $cloakingimage;
	global $legalytext;
	global $ladevise;
	global $multisite;
	global $iddusite;
	global $store_multi_id;
	global $domainname;
	global $amp;
	global $imgtag;
	global $imgtag_resp;
	global $imgtag_close;
	global $cachingtime;
	global $cachingtime_txt;
	global $boodisplayprice;
	global $use_rating;
	global $use_prixbarre;
	global $use_amaprime;
	global $hidetitre;
	global $gtz_tokyo4;
	global $parachutemodeegta;
	
	if ($amp != true) {
		wp_enqueue_style( 'gothamazon-css-io' );
	}
	
	// On récupère les attributs des short code
	$a = shortcode_atts( array(
		'asin' => 'B07WKNQ8JT', // Query
		'titremano' => '', // Query
		'descriptionmano' => '', // Query
		'force1pic' => '', // Query
		'design' => 'full', // Query
		'parachutekw' => '', // Query
		'legal' => $legalytext, // Mentions Amazon
		'boodisplayprice' => $boodisplayprice, // Afficher/Masquer le titre
		'prixmin' => 1, // Prix Min
		'cat' => 'All', // Catégorie précise	// Query
		'linquery' => '', 
	), $atts );

	$hashtagamazon = gtz_display_special_mention();
	$gothamasin_asin = esc_attr( $a['asin'] ); // on récupère l'ASIN via le widget
	$boodisplayprice_ghost = $boodisplayprice; // A garder pour référence
	$store_my_devise = $ladevise; // A garder pour référence
	
	if ((BEERUS == 'premium') OR (BEERUS == 'godmod') ) {
		
		$titremano = esc_attr( $a['titremano'] ); // si le shortcode le veut, il peut écraser le titre fourni par amazon
		$descriptionmano = esc_attr( $a['descriptionmano'] ); // si le shortcode le veut, il peut écraser la description fournie par Amazon
		$force1pic = esc_attr( $a['force1pic'] ); 
		
		$boodisplayprice = esc_attr( $a['boodisplayprice'] ); // si le shortcode le veut, il peut écraser ou non l'affichage du prix
		if ($boodisplayprice == 'defaut') {$boodisplayprice = $boodisplayprice_ghost;} 
		if ($gtz_tokyo4 == "oui") { $boodisplayprice = "non"; }
		
	} else {
		
		$titremano = NULL;
		$descriptionmano = NULL;
		$force1pic = "non";

		$boodisplayprice = $boodisplayprice_ghost;
		
	}
	
	// Tokyo 4 //
	
	if ($gtz_tokyo4 == "oui") {
		
		// Preparation des images
		if ($switch23bay == true) { 
			$gtz_filou_px = "ebay";
		} elseif (preg_match("(cdiscount)", $parachutemodeegta)) {
			$gtz_filou_px = "cdiscount";
		} elseif (preg_match("(darty)", $parachutemodeegta)) {
			$gtz_filou_px = "darty";
		} elseif (preg_match("(fnac)", $parachutemodeegta)) {
			$gtz_filou_px = "fnac";
		} elseif (preg_match("(manomano)", $parachutemodeegta)) {
			$gtz_filou_px = "manomano";
		} elseif (preg_match("(boulanger)", $parachutemodeegta)) {
			$gtz_filou_px = "boulanger";
		} elseif (preg_match("(ebay)", $parachutemodeegta)) {
			$gtz_filou_px = "ebay";
		} elseif (preg_match("(amzn|amazon)", $parachutemodeegta)) {
			$gtz_filou_px = "amazon";
		} else {
			$gtz_filou_px = "internet";
		}
	
	} else {
		
		$gtz_filou_px = "amazon";
		
	}
	// ! Tokyo4 //
	
	// Derniers Paramètres
	$sidebardesign = esc_attr( $a['design'] ); // Design pleine page ou sidebar
	$legalytext = esc_attr( $a['legal'] ); // si le shortcode le veut, il peut écraser l'affichage ou non du texte légal
	
	///////////////////////////
	if ($titremano != '') {$kapsutitre='o';} else {$kapsutitre='n';}
	if ($descriptionmano != '') {$kapsudesc='o';} else {$kapsudesc='n';}
	if ($use_amaprime == "oui") {$skraprime = 'o';} else {$skraprime = 'n';}
	if ($force1pic == 'oui') {$tsec='o';} elseif ($force1pic == 'non') {$tsec='n';} else {$tsec='n';$force1pic='non';}
	//////////////////////////////////////////////////////////////////////////////

	$kapsule_dirstokage = GOTHAMZ_UPLOAD_PATH;
	$kapsule_dirstokage_backup = GOTHAMZ_UPLOAD_PATH_BACKUP;
	$dynamixcache = ''.$kapsule_dirstokage.'ASIN_'.$gothamasin_asin.'-'.$kapsutitre.''.$kapsudesc.''.$skraprime.''.$tsec.'.json'; // On créé le chemin du fichier de cache
	/////////////////////
	
	$output="";

	if ($gtz_tokyo4 != "oui") {
		
		if (file_exists($dynamixcache) && (( time() - $cachingtime > filemtime($dynamixcache)) OR ( 0 == filesize($dynamixcache) ))) {  // Si le fichier existe et (qu'il a dépassé la durée de vie du cache OU qu'il est vide) 
			
			$dynamixcache_archive = str_replace($kapsule_dirstokage,$kapsule_dirstokage_backup,$dynamixcache);
			
			if (file_exists($dynamixcache_archive)) { // Si un cache existe deja
		
				unlink ($dynamixcache_archive); // On l'efface
				rename($dynamixcache, $dynamixcache_archive); // On fait un nouveau backup
				
			} else { // Sinon on fait un backup
				
				rename($dynamixcache, $dynamixcache_archive);
			
			}
			
		}
		
	} else {
		
		if (!file_exists($dynamixcache)) { // Si pas de cache, on cherche un fichier ayant cet ASIN, meme si les variables ne sont pas identiques
			
			$glob_checker = $kapsule_dirstokage.'*ASIN_'.$gothamasin_asin.'*.json'; 
			
			$files = glob($glob_checker);
			if (count($files) > 0) {
				
				$dynamixcache = $files[0];	
				
			} else {
				
				$glob_checker2 = $kapsule_dirstokage_backup.'*ASIN_'.$gothamasin_asin.'*.json'; 
				$files2 = glob($glob_checker2);
				
				if (count($files2) > 0) {
				
					$dynamixcache = $files2[0];
				
				}
				
			}
			
		}
		
			
	}
	

	if (file_exists($dynamixcache)) { // Si le fichier de cache existe deja
	
		$response = @file_get_contents($dynamixcache); // On charge le fichier de cache
		$onstoptout = "non"; // On a un flux stocké donc on parse
		
	} else { 
	
		$serviceName="ProductAdvertisingAPI";
		$region=$marketplace_region;
		$accessKey = $secret_amalog;
		$secretKey = $secret_amapass;
		$payload="{";
		$payload.=" \"ItemIds\": [";
		$payload.="  \"$gothamasin_asin\"";
		$payload.=" ],";
		$payload.=" \"Resources\": [";
		$payload.="  \"Images.Primary.Large\"";
		$payload.=",  \"ItemInfo.ExternalIds\"";
		if ($force1pic == 'non') {
			$payload.=",  \"Images.Variants.Medium\"";
		}
		if ($descriptionmano == '') {
			$payload.=",  \"ItemInfo.Features\"";
		}
		if ($titremano == '') {
			$payload.=",  \"ItemInfo.Title\"";
		}
		if ($use_amaprime == "oui") {
			$payload.=",  \"Offers.Listings.DeliveryInfo.IsPrimeEligible\"";
		}
		// if ($boodisplayprice == 'oui') { Provoque un Bug Inexpliqué
			$payload.=",  \"Offers.Listings.Price\"";
			$payload.=",  \"Offers.Listings.Promotions\"";
			$payload.=",  \"Offers.Listings.SavingBasis\"";

		//}
		$payload.=" ],";
		$payload.=" \"PartnerTag\": \"$amazontrackingcode\",";
		$payload.=" \"PartnerType\": \"Associates\",";
		$payload.=" \"Marketplace\": \"www.$marketplace_w\"";
		$payload.="}";
		$host="webservices.$marketplace_w";
		$uriPath="/paapi5/getitems";
		$AwsV4Goth = new AwsV4Goth ($accessKey, $secretKey);
		$AwsV4Goth->setRegionName($region);
		$AwsV4Goth->setServiceName($serviceName);
		$AwsV4Goth->setPath ($uriPath);
		$AwsV4Goth->setPayload ($payload);
		$AwsV4Goth->setRequestMethod ("POST");
		$AwsV4Goth->addHeader ('content-encoding', 'amz-1.0');
		$AwsV4Goth->addHeader ('content-type', 'application/json; charset=utf-8');
		$AwsV4Goth->addHeader ('host', $host);
		$AwsV4Goth->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.GetItems');
		$headers = $AwsV4Goth->getHeaders ();
		$headerString = "";
		foreach ( $headers as $key => $value ) {
			$headerString .= $key . ': ' . $value . "\r\n";
		}
		$params = array (
				'http' => array (
					'header' => $headerString,
					'method' => 'POST',
					'content' => $payload
				)
			);
		$stream = stream_context_create ( $params );

		$fp = @fopen ( 'https://'.$host.$uriPath, 'rb', false, $stream );
		
		if ($fp == false) {return;}

		$response = @stream_get_contents ( $fp );

		// Detection du flux vide //
		$padreponskaps = json_decode($response, true);
		$items = isset($padreponskaps['ItemsResult']['Items'][0]['Offers']['Listings'][0]['Price']['Amount']) ? $padreponskaps['ItemsResult']['Items'][0]['Offers']['Listings'][0]['Price']['Amount'] : NULL ; // On cherche l'existence d'un prix ce qui signifie qu'un article est en vente et pas indisponible
		
		
		if (!is_null($items)) { 
		
			// Si le flux marche et nous renvoie donc un item
			file_put_contents($dynamixcache , $response); // On crée le cache
			$onstoptout = "non";
			
		} else {
			
			// Sinon on rebondit comme on peut
			$onstoptout = "oui";
				
			if ((BEERUS == 'premium') OR (BEERUS == 'godmod') ) {
					
				$parachutekw = esc_attr( $a['parachutekw'] ); // on récupère le parachute car l'ASIN ne marche plus

				if ($parachutekw != '') { // Si un mot clé parachute existe
					
					// On récupère les autres variables
					$categoryprecise = esc_attr( $a['cat'] );
					if ($categoryprecise == '') {$categoryprecise = 'All';}
					
					$prixmin = esc_attr( $a['prixmin'] );
					if (($prixmin == 0) OR ($prixmin == '')) {$prixmin = 1;}
					
					$force1pic = esc_attr( $a['force1pic'] );
					
					if ($sidebardesign == 'sidebar') {
						
						$pirouette = 'design="sidebar"';
						
					} else {
						
						$pirouette = 'design=""';
						
					}
					
					$output = do_shortcode( '[spotlightbyq title="'. $parachutekw .'" prixmin="'.$prixmin.'" '.$pirouette.' force1pic="'. $force1pic .'" boodisplayprice="'. $boodisplayprice .'" cat="'. $categoryprecise .'"]' );
					
				} 
				
			}
			
		}
		
	}

	if ($onstoptout == "non") { // On Parse

		$output.="<div style='clear:both;'></div>";
		
		if ($sidebardesign == 'sidebar') {
			
			$output.="<ul class='smartstore smartstorespotlight smartstoresidebar'>";
			
		} else {
			
			$output.="<ul class='smartstore smartstorespotlight smartstorekontent'>";
			
		}
		
		$data = json_decode($response, true);
		$items = isset($data['ItemsResult']['Items']) ? $data['ItemsResult']['Items'] : NULL;
		$plugins_url = plugins_url();
		
		foreach ($items as $item){
			
			$ref = isset($item['ASIN']) ? $item['ASIN'] : NULL;
			
			if ($gtz_tokyo4 != "oui") {
										
				if (!is_null($ref)) { // Si on a une REF :
					
					if (empty($amazontrackingcode2)) { // Si pas de MultiCompte => URL du Flux
						
						$link = isset($item['DetailPageURL']) ? $item['DetailPageURL'] : NULL;
												
					} else { // Sinon ==> On construit l'url
												
						$link = "https://$marketplace_w/dp/$ref?tag=$amazontrackingcode_tracker"."&linkCode=osi&th=1&psc=1";
												
					}
											
				} else {
											
						$link = NULL;
											
				}
			
			} else {
				
				$tokyo4_title = isset($item['ItemInfo']['Title']['DisplayValue']) ? $item['ItemInfo']['Title']['DisplayValue'] : NULL;
				$linquery = esc_attr( $a['linquery'] ); // Nombre d'items sur PC
				$parachutekw = esc_attr( $a['parachutekw'] ); // on récupère le parachute car l'ASIN ne marche plus
				
				if ((is_null($tokyo4_title)) OR ($linquery == "oui")) {
					
					$tokyo4_sanitized_query = sanitize_title_with_dashes($parachutekw);	
				
					
				} else {
					
					$tokyo4_sanitized_query = sanitize_title_with_dashes($tokyo4_title);	
					
				}
				
				if ( ($gtz_filou_px == "cdiscount") OR ($gtz_filou_px == "fnac") OR ($gtz_filou_px == "manomano") OR ($gtz_filou_px == "boulanger") OR ($gtz_filou_px == "ebay") OR ($gtz_filou_px == "amazon")) {
					
					$tokyo4_query = str_replace('-', "%2B", $tokyo4_sanitized_query);
					
				} else {
					
					$tokyo4_query = $tokyo4_sanitized_query;
					
				}
					
				$link = str_replace('%GTZ_QUERY%', $tokyo4_query, $parachutemodeegta);
				
			}
			
			
			$image = isset($item['Images']['Primary']['Large']['URL']) ? $item['Images']['Primary']['Large']['URL'] : NULL;
			
			$image_statut = get_headers($image);
			$image_statut = $image_statut[0];
			
			if (($image == "") OR (strpos($image_statut,"403")) OR (strpos($image_statut,"404")) OR (strpos($image_statut,"500"))) {
				
				$image = "$plugins_url/gothamazon/img/nopics.png";
				
			}
			
			
			$image_4_tokyo4 = $image;
			$image_width = isset($item['Images']['Primary']['Large']['Width']) ? $item['Images']['Primary']['Large']['Width'] : NULL;
			$image_height = isset($item['Images']['Primary']['Large']['Height']) ? $item['Images']['Primary']['Large']['Height'] : NULL;
			
			if (is_null($image_width)) {$image_width = 400;}
			if (is_null($image_height)) {$image_height = 500;}
			
			// Module Cloaking Image
			if ($cloakingimage == 'oui') {
				
				$image_ama_id = str_replace("https://m.media-amazon.com/images/I/","",$image);
				$image_ama_id = str_replace(".jpg","",$image_ama_id);
				$image = rest_url( "gtz/v1/smartimg/{$image_ama_id}" );
				
			}
			
			// Titre Amazon
			if ($titremano =="") {
				
				$title = isset($item['ItemInfo']['Title']['DisplayValue']) ? $item['ItemInfo']['Title']['DisplayValue'] : NULL;
				
				if (!is_null($title)) {
					
					$title_truncate = mb_strimwidth($title, 0, 100, "...");
					$sanitize_alt_title = str_replace('"', "", $title);
					$sanitize_alt_title = str_replace("'", "", $sanitize_alt_title);
					$sanitize_alt_title = mb_strimwidth($sanitize_alt_title, 0, 60);
					
				}
				
			} else {
				
				$sanitize_alt_title = $titremano;
				$title_truncate = $titremano;
				
			}
			
		
			// Gestion du Prix
			if ($boodisplayprice == 'oui') {
				
				$price = $item['Offers']['Listings'][0]['Price']['Amount'] ? $item['Offers']['Listings'][0]['Price']['Amount'] : NULL;
				$prixnumerik = isset($item['Offers']['Listings'][0]['Price']['Amount']) ? $item['Offers']['Listings'][0]['Price']['Amount'] : NULL;
				$economierealisee = isset($item['Offers']['Listings'][0]['Price']['Savings']['Amount']) ? $item['Offers']['Listings'][0]['Price']['Savings']['Amount'] : NULL;
				
				// Module Special Price
				
				if (is_null($price)) { // Si pas de prix
				
					$price = "Special";
					$display_devise = ""; // on enlève le sigle €/$
					
				} else {
					
					$price = str_replace(',', "",$price);
					//$price = number_format($price, 2, ',', ' ');
					$price = number_format((float)$price, 2, ',', ' ');		
					$display_devise = $store_my_devise;
					
				}
				
				if ($use_prixbarre == "oui") {
										
					if ((!is_null($economierealisee)) AND ($economierealisee != 0) AND ($economierealisee != "")) {
						
						$prix_de_base2k22 = isset($item['Offers']['Listings'][0]['SavingBasis']['Amount']) ? $item['Offers']['Listings'][0]['SavingBasis']['Amount'] : NULL;
						$pourcentrealise = isset($item['Offers']['Listings'][0]['Price']['Savings']['Percentage']) ? $item['Offers']['Listings'][0]['Price']['Savings']['Percentage'] : NULL;
						
						if ((!is_null($prix_de_base2k22)) AND ($prix_de_base2k22 != 0)) {
						
							$calculduprixdebaz = $prix_de_base2k22;
							$calculduprixdebaz = str_replace(',', "",$calculduprixdebaz);
							$calculduprixdebaz = number_format($calculduprixdebaz, 2, ',', ' ');
						
						} else {
						
							$calculduprixdebaz = $prixnumerik + $economierealisee;
							$calculduprixdebaz = number_format($calculduprixdebaz, 2, ',', ' ');
						
						}
					
					}
					
				}
				
			}

			
			// Amazon Prime
			$logoduprime = "";
			if (($use_amaprime == "oui") AND ($gtz_tokyo4 != "oui")) {
				
				$urldulogoprime = "$plugins_url/gothamazon/img/prime.png";
				$amaprime = isset($item['Offers']['Listings'][0]['DeliveryInfo']['IsPrimeEligible']) ? $item['Offers']['Listings'][0]['DeliveryInfo']['IsPrimeEligible'] : NULL;

				if ((!is_null($amaprime)) AND ($amaprime != false)) {
					
					$logoduprime ="<span class='elprime'><$imgtag_resp src='$urldulogoprime' alt='Livraison Prime' class='prime' width='200' height='84'>$imgtag_close</span>";
					
				} else {
					
					$logoduprime = "";
					
				}
				
			}
				
			// Product Rating
			$urldulogo45stars = "$plugins_url/gothamazon/img/45rate.png";
			$urldulogo5stars = "$plugins_url/gothamazon/img/5rate.png";
			
			if ($use_rating == "oui") {
				
				$gothamrating='<span class="gothamrate"><'. $imgtag .' src="' .$urldulogo45stars .'" alt="Avis sur '. $sanitize_alt_title .'" class="gotrate" width="97" height="27">'. $imgtag_close .'</span>';
				
			} else {
				
				$gothamrating = NULL;
				
			}
			
			// 1 ou 4 Images
			if ($force1pic == 'non') {
				
				$image_variant1 = isset($item['Images']['Variants'][0]['Medium']['URL']) ? $item['Images']['Variants'][0]['Medium']['URL'] : NULL;
				$image_variant1_width = isset($item['Images']['Variants'][0]['Medium']['Width']) ? $item['Images']['Variants'][0]['Medium']['Width'] : NULL;
				$image_variant1_height = isset($item['Images']['Variants'][0]['Medium']['Height']) ? $item['Images']['Variants'][0]['Medium']['Height'] : NULL;
				$image_variant1_tokyo4 = $image_variant1;
				$image_variant2 = isset($item['Images']['Variants'][1]['Medium']['URL']) ? $item['Images']['Variants'][1]['Medium']['URL'] : NULL;
				$image_variant2_width = isset($item['Images']['Variants'][1]['Medium']['Width']) ? $item['Images']['Variants'][1]['Medium']['Width'] : NULL;
				$image_variant2_height = isset($item['Images']['Variants'][1]['Medium']['Height']) ? $item['Images']['Variants'][1]['Medium']['Height'] : NULL;
				$image_variant2_tokyo4 = $image_variant2;
				$image_variant3 = isset($item['Images']['Variants'][2]['Medium']['URL']) ? $item['Images']['Variants'][2]['Medium']['URL'] : NULL;
				$image_variant3_width = isset($item['Images']['Variants'][2]['Medium']['Width']) ? $item['Images']['Variants'][2]['Medium']['Width'] : NULL;
				$image_variant3_height = isset($item['Images']['Variants'][2]['Medium']['Height']) ? $item['Images']['Variants'][2]['Medium']['Height'] : NULL;
				$image_variant3_tokyo4 = $image_variant3;
				
				// Module Cloaking Image
				if (($cloakingimage == 'oui') AND (!empty($image_variant3))) {
					
					$image_ama_id1 = str_replace("https://m.media-amazon.com/images/I/","",$image_variant1);
					$image_ama_id1 = str_replace("._SL160_.jpg","",$image_ama_id1);
					$image_variant1 = rest_url( "gtz/v1/smartimg/{$image_ama_id1}" );
					$image_ama_id2 = str_replace("https://m.media-amazon.com/images/I/","",$image_variant2);
					$image_ama_id2 = str_replace("._SL160_.jpg","",$image_ama_id2);
					$image_variant2 = rest_url( "gtz/v1/smartimg/{$image_ama_id2}" );
					$image_ama_id3 = str_replace("https://m.media-amazon.com/images/I/","",$image_variant3);
					$image_ama_id3 = str_replace("._SL160_.jpg","",$image_ama_id3);
					$image_variant3 = rest_url( "gtz/v1/smartimg/{$image_ama_id3}" );
				}
				
			}
			
			
			if ($gtz_tokyo4 == "oui") {
					
				$upload_dir_url = wp_get_upload_dir();
				
				$kapsule_dirstokage_pics_t4 = $upload_dir_url["basedir"];
				$kapsule_dirstokage_pics_t4 = $kapsule_dirstokage_pics_t4 . '/gtz_t4';
				
				if (! is_dir($kapsule_dirstokage_pics_t4)) {
					mkdir( $kapsule_dirstokage_pics_t4, 0755 );
				}
				
				$chemin_img_bup = "$kapsule_dirstokage_pics_t4/$ref.jpg";
				
				$upload_dir_url_gtzt4 = $upload_dir_url["baseurl"] . '/gtz_t4';
				$chemin_http_img_bup = "$upload_dir_url_gtzt4/$ref.jpg";
				
				if (file_exists($chemin_img_bup) && ((time() - 43200 < filemtime($chemin_img_bup)) AND (filesize($chemin_img_bup) > 0))) { // Si l'image existe, a quelques octets et a moins de 12H
					
					$image = $chemin_http_img_bup;
					
				} else {
					
					@copy($image_4_tokyo4, $chemin_img_bup);
					
				}
				
				if (!empty($image_variant3)) {
					
					$chemin_img_bup = "$kapsule_dirstokage_pics_t4/$ref-1.jpg";
					$chemin_img_bup = "$kapsule_dirstokage_pics_t4/$ref-2.jpg";
					$chemin_img_bup = "$kapsule_dirstokage_pics_t4/$ref-3.jpg";
					$chemin_http_img_bup_1 = "$upload_dir_url_gtzt4/$ref-1.jpg";
					$chemin_http_img_bup_2 = "$upload_dir_url_gtzt4/$ref-2.jpg";
					$chemin_http_img_bup_3 = "$upload_dir_url_gtzt4/$ref-3.jpg";
					
					if (file_exists($chemin_img_bup)) {
					
						$image_variant1 = $chemin_http_img_bup_1;
						$image_variant2 = $chemin_http_img_bup_2;
						$image_variant3 = $chemin_http_img_bup_3;
					
					} else {
						
						copy($image_variant1_tokyo4, $chemin_img_bup_1);
						copy($image_variant2_tokyo4, $chemin_img_bup_2);
						copy($image_variant3_tokyo4, $chemin_img_bup_3);
						
					}
	
				
				}

			}
			
			// Description Amazon
			if ($descriptionmano !="") {
				
				$description  = $descriptionmano;
				
			} else {
				
				$description0 = isset($item['ItemInfo']['Features']['DisplayValues'][0]) ? $item['ItemInfo']['Features']['DisplayValues'][0] : NULL;
				$description1 = isset($item['ItemInfo']['Features']['DisplayValues'][1]) ? $item['ItemInfo']['Features']['DisplayValues'][1] : NULL;
				$description2 = isset($item['ItemInfo']['Features']['DisplayValues'][3]) ? $item['ItemInfo']['Features']['DisplayValues'][3] : NULL;
				$description3 = isset($item['ItemInfo']['Features']['DisplayValues'][4]) ? $item['ItemInfo']['Features']['DisplayValues'][4] : NULL;
				
				$description_array = array($description0, $description1, $description2, $description3);
				
				asort($description_array);
				
				$description = "";
				
				foreach ($description_array as $descrishuffle) {
					
					$description .= "$descrishuffle ";
					
				}
				
				$description = mb_strimwidth($description, 0, 280, "...");
				$description = str_replace('é', "e", $description);
				$description = str_replace('è', "e", $description);
				$description = str_replace('à', "a", $description);
				$description = str_replace('ù', "u", $description);
				$description = str_replace('.', ". ", $description);
				
			}

			
			$centrage = "";
			
			if ((empty($image_variant3)) OR ($force1pic == "oui")) {
				
				$centrage = "style='width:100%;text-align:center;'";
				
			}
			
			if ($cloaking == 'oui') {
				
				$lurlencode= base64_encode($link);
				$complement="datasin='$lurlencode'";
				$kelbalise="span";
				
			} else {
				
				$urlnextgena = $link; 
				$complement ="href='$urlnextgena' rel='nofollow noopener' target='_blank'";
				$kelbalise="a";
				
			}
			
			// Construction du module
			$output.='<li><'.$kelbalise.' '.$complement.' class="ficheproduit kamesen"><span class="bleft"><span class="area4mainpics" '.$centrage.'><'.$imgtag_resp.' src="'.$image.'" alt="'.$sanitize_alt_title.'" width="'.$image_width.'" height="'.$image_height.'" class="mainpics">'.$imgtag_close.'</span>';
			
			if ((!empty($image_variant3)) AND ($force1pic != "oui")) {
				
				$output.='<span class="vaiamage"><span><'.$imgtag_resp.' src="'.$image_variant1.'" alt="'.$sanitize_alt_title.'" width="'.$image_variant1_width.'" height="'.$image_variant1_height.'">'.$imgtag_close.'</span><span><'.$imgtag_resp.' src="'.$image_variant2.'" alt="'.$sanitize_alt_title.'" width="'.$image_variant2_width.'" height="'.$image_variant2_height.'">'.$imgtag_close.'</span><span><'.$imgtag_resp.' src="'.$image_variant3.'" alt="'.$sanitize_alt_title.'" width="'.$image_variant3_width.'" height="'.$image_variant3_height.'">'.$imgtag_close.'</span></span>';
			
			}
			
			$output.="</span><span class='bright'><span class='storeitemtitle'>$title_truncate</span><span class='blob'>$description</span>$gothamrating$logoduprime";
			
			if ((BEERUS == "godmod") OR ($legalytext == "oui")) {
				
				if ($gtz_tokyo4 == "oui") {
					
					$gtz_amz_url = "$plugins_url/gothamazon/img/$gtz_filou_px.png"; 
					
				} else {

					$gtz_amz_url = "$plugins_url/gothamazon/img/amz.png"; 
					
				}
				
				$output.='<span class="gtz_amz"><'. $imgtag_resp. ' src="' .$gtz_amz_url. '" alt="'. $sanitize_alt_title. '" width="200" height="52">'. $imgtag_close .'</span>';
				
				$output .= $hashtagamazon;
			
			}
			
			$output.="<span class='storeitemfoo'>";
			
			if ($boodisplayprice == 'oui') {
				
				$cuzhprice_css ='';
				
				if (($economierealisee != "0") AND (!is_null($economierealisee)) AND ($economierealisee != "") AND ($use_prixbarre == "oui")) {
					
					$output.="<span class='storeitemprice'><span class='pricepromo'>$price $display_devise</span> <strike>$calculduprixdebaz $display_devise</strike><span class='uaresmart'>Votre économie :<br /> <u>$economierealisee $display_devise</u> (- <strong>$pourcentrealise %</strong>)</span></span>";
					
				} else {
					
					$output.="<span class='storeitemprice'><span class='pricepromo'>$price $display_devise</span></span>";
					
				}
				
			} else {
				
				$cuzhprice_css ='cuzprice_css';
				
			}
			
			$output.="<span class='storeitemcta $cuzhprice_css'><span class='eyecandy'><span>(+) d'infos</span>";
			
			if (GOTHAMZ_VMOB != "mobile") {
				
				$output.="<span><svg width='36px' height='16px' viewBox='0 0 66 43' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><g id='arrow' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'><path class='one' d='M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z' fill='#FFFFFF'></path><path class='two' d='M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z' fill='#FFFFFF'></path><path class='three' d='M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z' fill='#FFFFFF'></path></g></svg></span>";
				
			}
			
			$output.="</span></span></span></span></$kelbalise></li>";
			
		}
		
		$output.= "</ul><div style='clear:both;'></div>";
		
		if (((BEERUS == "godmod") OR ($legalytext == "oui")) AND ($onstoptout != true)) {
			
			if ($gtz_tokyo4 == "oui") {
					
				if ($gtz_filou_px == "internet") { 
				
					$gtz_url_targeted = "un site web partenaire. Les prix sont donnés à titre indicatifs, et seul le prix affiché sur le site du commerçant est valable."; 
					
				} else {
					
					$gtz_url_targeted = "le moteur de recherche de $gtz_filou_px. Les prix sont donnés à titre indicatifs, et seul le prix affiché sur le site du commerçant est valable."; 
					
				}
				
				if ($gtz_filou_px == "amazon") {
					
					$gtz_url_targeted .= " Notre site internet participe au programme Partenaire Αmazοn et réalise ainsi un bénéfice sur les achats qui remplissent les conditions requises.";
					
				}
					
			} else {
						
				$gtz_url_targeted = "sa fiche produit sur Amazon.fr"; 
						
			}
			
			$output .="<p class='smartstorelegal'>ⓘ En cliquant sur l'article ci-dessus, vous serez redirigé vers $gtz_url_targeted";
			
		} else {
			
			$output .="<p class='smartstorelegal'>ⓘ En cliquant sur l'article ci-dessus, vous serez redirigé vers sa fiche produit sur Αmazοn.fr. Notre site internet participe au programme Partenaire Αmazοn et réalise ainsi un bénéfice sur les achats qui remplissent les conditions requises.";
		}
		
		if ((file_exists($dynamixcache)) AND ((BEERUS == "godmod") OR ($legalytext == "oui")) AND ($boodisplayprice == 'oui') AND ($gtz_tokyo4 != "oui") AND ($onstoptout != true)) {
			
			$lastcache = date ("d/m/y à H:i:s.", filemtime($dynamixcache));
			$output.=" Relevés de prix actualisés toutes les $cachingtime_txt. Le dernier relevé date du $lastcache";
		   
		}
		
		if (((BEERUS == "godmod") OR ($legalytext == "oui")) AND ($onstoptout != true)) {
			
			$output.= "</p>";
			
		}

		// Module Powered By //
		$gothamazon_option_powered_check = get_option('gothamazon_option_powered');
		if ($gothamazon_option_powered_check == "oui") {
			
			$output.="<p class='smartstorelegal'>Ce module vous est proposé par <a href=//gothamazon.com' target='_blank' rel='noopener'>Gothamazon</a></p>";
					 
		}
		// Fin du Module Powered By

	}
	
global $gtz_called;
$gtz_called++;

// BUG LOG TOKYO 4 //
	if ($gtz_tokyo4 == "oui") {
		
		$bug_log = GOTHAMZ_UPLOAD_PATH . 'modlog/';
		
		if (! is_dir($bug_log)) {
			mkdir( $bug_log, 0755 );
		}
		
		if ($sidebardesign == 'sidebar') {
			
			$bug_log_current_url = "ZZsidebar";

		} elseif (is_archive()) {
			
			$term = get_queried_object();
			if(is_tag()) {
				
				$hxh = "ZZELTAG";
				$bug_log_current_url = "$hxh".$term->term_id;
				
			} else {
				
				$hxh = "ZZELCAT";
				$bug_log_current_url = "$hxh".$term->slug;
			}
				

		} else {
			
			if (is_page()) {
			
				$bug_log_current_url = "ZZELPAGE".get_post_field( 'ID', get_post() );
			
			} else {
				
				$bug_log_current_url = get_post_field( 'post_name', get_post() );
			}
			
		}
		
		$bug_log_file_chem = $bug_log.$bug_log_current_url;
		file_put_contents($bug_log_file_chem, "GTZ Spotlight ASIN"); 
	
	}
//
		
return $output;

}
add_shortcode( 'gothasin', 'kapsstartasin' );
// Fin de la création du module de recherche par ASIN