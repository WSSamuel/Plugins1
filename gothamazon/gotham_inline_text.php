<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

function kapsulewheel_inlinetextio( $atts, $content = null, $tag = '') {
	
	global $secret_amalog;
	global $secret_amapass;
	global $amazontrackingcode;
	global $amazontrackingcode2;
	global $amazontrackingcode_tracker;
	global $marketplace_id;
	global $marketplace_w; 
	global $marketplace_region; 
	global $ladevise;
	global $neufunik; 
	global $vendeur;
	global $sortbay;
	global $tripardefaut;
	global $domainname;
	global $parachutemodeegta;
	global $economycostapi;
	global $cloaking;
	global $multisite;
	global $iddusite;
	global $store_multi_id;
	global $amp;
	global $imgtag;
	global $imgtag_resp;
	global $imgtag_close;
	global $cachingtime;
	global $cachingtime_txt;
	global $gtz_tokyo4;
	global $gtz_tokyo4_3bay;
	global $gtz_linquery_default;
	global $gtz_awin_ref_id;
	global $gtz_called;
	
	// Module de Log
	$bug_log = GOTHAMZ_UPLOAD_PATH . 'modlog/';
	if (! is_dir($bug_log)) {
		mkdir( $bug_log, 0755 );
	}
		
	if (is_archive()) {
		
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
	//
	
	
	// Module AMP
	if ($amp != true) {
		wp_enqueue_style( 'gothamazon-css-io' );
	}
	
	// On récupère les attributs des short code
	$a= shortcode_atts( array(
		'inlinekw' => 'Nintendo Switch', // Query
		'ancre' => 'Ancre du lien', // Anchor
		'prixmin' => 1, // Prix Min
		'cat' => 'All', // Catégorie précise
		'inlineprice' => 'non', 
		'image_anchor_url' => '',
		'classcsscta' => '',
		'sort' => $sortbay , // Tri
		'vendeur' => $vendeur,
		'marque' => '',
		'force_api' => '', 
		'special_aff_id' => '',
		'exclusion' => '',
		'inclusion' => '',
		'nkw' => '',
	), $atts );

	$zipq = esc_attr( $a['inlinekw'] );
	$ancredulien = esc_attr( $a['ancre'] ); // Ancre du lien
	
	if ((BEERUS == 'premium') OR (BEERUS == 'godmod') ) { // si le shortcode le veut, il peut écraser ou non le tri par défaut 
	
		$force_api = esc_attr( $a['force_api'] ); 
		if ($force_api =='amazon') {
			
			$kel_api_utiliser = "amazon";
			
		} elseif ($force_api =='ebay') {
			
			$kel_api_utiliser = "ebay";	
			
		} elseif (!empty($force_api)) {
			
			$kel_api_utiliser = $force_api;	
			
		} else {
			
			if ($gtz_tokyo4_3bay == "oui") {
				
				$kel_api_utiliser = "ebay";	
				
			} elseif ($gtz_tokyo4_3bay == "non") {
				
				$kel_api_utiliser = "amazon";	
				
			} else {
				
				$kel_api_utiliser = $gtz_tokyo4_3bay;	
			
			}
			
		}	
		
		
		// Ecrasage ciblé d'une ID AFF
		$special_aff_id = esc_attr( $a['special_aff_id'] );
		if (!empty($special_aff_id)) {
			
			$gtz_awin_ref_id = $special_aff_id;
			
		}
		
		// Exclusion d'un marchand pour les flux multimarchands
		$exclusion = esc_attr( $a['exclusion'] ); 
		
		// Inclusion d'un ou plusieurs marchands pour les flux multimarchands
		$inclusion = esc_attr( $a['inclusion'] ); 
		$inclusion_s = str_replace(',', '', $inclusion);
		
		// Inclusion des negatives kw
		$nkw = esc_attr( $a['nkw'] ); 
		$nkw_s = str_replace(',', '', $nkw);
	
	} else {
		
		$kel_api_utiliser = "amazon";	
		
	}
	

	/////////////////////////////
	// Gestion du MultiQuery
	$gtz_intelli_multiquery = gtz_intelli_split_my_query($zipq);
	$multiquery_counter = count($gtz_intelli_multiquery);
	
	if ($multiquery_counter > 1) {
		
		$randomChoice  = function($array) {return $array[array_rand($array)];};
		$zipq = $randomChoice($gtz_intelli_multiquery);
		
	}	
	
	////////////////////////////
	// Gestion du parachute intelligent
	////////////////////////////
		
	if ($zipq == "") {
			
			$chance2find = $ancredulien;
			
	} else {
			
			$chance2find = $zipq;
			
	}
		
	$zipq_san = sanitize_title_with_dashes($chance2find);
		
	if (preg_match("(cdiscount|fnac|manomano|ebay|amazon|amzn)", $parachutemodeegta)) {
		
			$zipq_san = str_replace('-', "%2B", $zipq_san);
			
	}

	$parachutemodee_gta = str_replace('%GTZ_QUERY%', $zipq_san, $parachutemodeegta);
	// Fin du parachute
	
	$prixmin= esc_attr( $a['prixmin'] );
	if (($prixmin == 0) OR ($prixmin == '')) {$prixmin = 1;}
	$categoryprecise = esc_attr( $a['cat'] ); // si le shortcode le veut, il peut écraser la catégorie d'origine
	$check_sortbay = $a['sort']; if (!empty($check_sortbay)) {$sortbay = $check_sortbay;}
	if (($sortbay == '') OR ($sortbay == 'Default')) {$tripardefaut = 'oui';} else {$tripardefaut = 'non';} // Tri par defaut si vide
	$classcsscta = esc_attr( $a['classcsscta'] ); // Permet de rajouter une classe CSS pour un CTA
	$inlineprice = esc_attr( $a['inlineprice'] );
	$check_marque = esc_attr( $a['marque'] ); if (!empty($check_marque)) {$marque = $check_marque;$marque4slug = sanitize_title($check_marque);} else {$marque = "None";$marque4slug="None";}
	$check_vendeur = $a['vendeur']; if (!empty($check_vendeur)) {$vendeur = $check_vendeur;}
	if ($vendeur == '') {$vendeur = 'All';}

	$ioyasin = $zipq; 
	$kapsule_plug = GOTHAMZ_ROOTPATH;
	$kapsule_dirstokage = GOTHAMZ_ROOTPATH . 'storefeed/';
	$ioyasin = filter_var($ioyasin, FILTER_SANITIZE_URL);
	$ioyasin = preg_replace('/[^A-Za-z0-9]/','', $ioyasin);
	$ioyasin = str_replace(' ', '_', $ioyasin);
	$ioyasin = str_replace(';', '', $ioyasin);
	$ioyasin = strtolower($ioyasin);
	$dynamixcache = "$kapsule_dirstokage$domainname-inline_$ioyasin-$categoryprecise-$prixmin-$inlineprice-$sortbay$vendeur$marque4slug$kel_api_utiliser-ex$exclusion-inc$inclusion_s-nkw$nkw_s.json"; // On créé le chemin du fichier de cache
	
	// Gestion de l'image en ancre
	$image_anchor_url = esc_attr( $a['image_anchor_url'] );
	$pixanchor = false;
	
	if ($image_anchor_url == "") {
		
	   $smart_ancrage = $ancredulien;
	   $lienvoyantsmartcss = "lienvoyant";
	   if ($kel_api_utiliser == "amazon") {$lienvoyantsmartcss .= " ama_itxtlink";} else {}
	   $yapadpiks = true;
	   $addclass = "";
	   
	} else {
		
		$image_size_info = @getimagesize($image_anchor_url); 
		
		if ( $image_size_info == FALSE ) {
			
			if ($amp == true) {
				
				$mesjoliesdimensions = "width='640' height='480'";
				
			} else {
				
				$mesjoliesdimensions="";
				
			}
			
		} else {
			
			$mesjoliesdimensions = $image_size_info[3];
			
		}
		
		$smart_ancrage = '<'.$imgtag_resp.' alt="'. $ancredulien. '" title= "'. $zipq. '" src="'. $image_anchor_url. '" '.$mesjoliesdimensions.'>'. $imgtag_close.'';
		$lienvoyantsmartcss = "lienvoyantsmartcss";
		$pixanchor = true;
		$yapadpiks = false;
		$addclass = " pixanchor";
		
	}

	///////////////////////////

	if ($gtz_tokyo4 != "oui") {
		
		if (file_exists($dynamixcache) && (( time() - $cachingtime > filemtime($dynamixcache)) OR ( 0 == filesize($dynamixcache) ))) {  // Si le fichier existe et (qu'il a dépassé la durée de vie du cache OU qu'il est vide) 
			
			$dynamixcache_archive = str_replace(".json","___BACKUP.json",$dynamixcache);
			rename($dynamixcache, $dynamixcache_archive);
			
		}

	} else { // Mode Tokyo 4
		
		$output = "";	
		$construction_du_lien = $parachutemodee_gta;
		if ($cloaking == 'oui') {
				
				$lurlencode= base64_encode($construction_du_lien); 
				$complement="datasin='$lurlencode'";
				$kelbalise="span";
				
		} else {
				
				$complement ="href='$construction_du_lien' rel='nofollow noopener' target='_blank'";
				$kelbalise="a";
				
		} 
			
		if ($classcsscta == "gamz_cta") {
				
				$output .="<div class='gamz_cont'>";
				
		}
		
		if ($pixanchor == true) {
					
			$output.="<div style='position:relative;'>";
					
		}
		
			
		$output .= "<$kelbalise $complement class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta'>$smart_ancrage</$kelbalise>"; 
		
		if ($kel_api_utiliser == "amazon") {
			
			$output .= '<span class="gtz-info-icon '.$addclass.'" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';
		
		}
		
		if ($pixanchor == true) {
				
				$output .= "</div>";
				
		}
				
		if ($classcsscta == "gamz_cta") {
				
				$output .= "</div>";
				
		}
		
		return $output;
			
	}
	// Fin de Tokyo 4
	// A PARTIR D'ICI ON N'EST PLUS EN TOKYO4

	if ((!file_exists($dynamixcache)) AND ($inlineprice != 'oui') AND ($cloaking == 'oui') AND ($economycostapi == 'oui') AND ($kel_api_utiliser == 'amazon')){ // Si le fichier de cache n'existe pas + pas besoin du prix + cloaking activé + eco api activé + API AMAZON
		
		// On sanitize la marque pour l'url du fichier temp
		$marquess = filter_var($marque, FILTER_SANITIZE_URL);
		$marquess = preg_replace('/[^A-Za-z0-9]/','', $marquess);
		$marquess = str_replace(' ', '_', $marquess);
		$marquess = str_replace(';', '', $marquess);
		$marquess = strtolower($marquess);
		
		// Création de l'appel
		$plugins_url = plugins_url(); // On récupère l'url des plugins
		$urllightapi = "$plugins_url/gothamazon/temp/bl-$store_multi_id$ioyasin-$categoryprecise-$prixmin$marquess.php"; //On créé l'url du fichier temportaire
		$urllightapi = base64_encode($urllightapi); // On encode
		$output == "";
		
		if (($pixanchor == true) OR (!empty($classcsscta))) {
					
			$output.="<div style='position:relative;'>";
					
		}
		
		$output.= "<span datasin='$urllightapi' class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta'>$smart_ancrage</span>"; // On créé le lien cloaké
		
		if ($kel_api_utiliser == "amazon") {
		
			if (empty($classcsscta)) { 
			
				$output.= '<span class="gtz-info-icon '.$addclass.'" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';
				
			} else {
				
				$output.= '<p class="small_sous_cta">#Αmazοn #Rémunéré</p>';
			}
		
		}
		
		if (($pixanchor == true) OR (!empty($classcsscta))) {
					
			$output.="</div>";
					
		}
		
		// Création du ficher temporaire
		$xfiles = "$kapsule_plug/temp/bl-$store_multi_id$ioyasin-$categoryprecise-$prixmin$marquess.php"; // Construction du nom du fichier temporaire
		$gogogo = true;
		
		if (!file_exists($xfiles) OR (( time() - 180 > filemtime($xfiles)) OR ( 0 == filesize($xfiles) ))) { // Si le fichier temporaire n'existe pas déjà ou a + de 180 secondes, on le créé
		
			$s_secret_amalog = kaps_encrypt("$secret_amalog");
			$s_secret_amapass = kaps_encrypt("$secret_amapass");

			$smartimprovment = "<?php \$domainname = '$domainname';\$ioyasin = '$ioyasin';\$zipq='$zipq';\$prixmin='$prixmin';\$categoryprecise='$categoryprecise';\$sortbay='$sortbay';\$vendeur='$vendeur';\$marque='$marque';\$marque4slug='$marque4slug';\$kel_api_utiliser='$kel_api_utiliser';\$exclusion='$exclusion';\$inclusion_s='$inclusion_s';\$nkw_s='$nkw_s';\$parachute='$parachutemodee_gta';\$amazontrackingcode='$amazontrackingcode';\$secret_amapass='$s_secret_amapass';\$secret_amalog='$s_secret_amalog'; \$marketplace='$marketplace_id';\$amazontrackingcode_tracker='$amazontrackingcode_tracker';\$leroot= \$_SERVER['SERVER_NAME'];\$dirparent = dirname( dirname(__FILE__) ); define('GOTHAMZ_ROOTPATH', \$dirparent); require_once(GOTHAMZ_ROOTPATH.'/eco.php'); unlink(__FILE__); \$current_url = __FILE__; \$crashbandicoot = \"<?php header('Location: \$redirectionok');\"; file_put_contents(\$current_url , \$crashbandicoot);"; // Passage des variables puis auto destruction
		
			file_put_contents($xfiles , $smartimprovment); // Création du fichier
			
			
		}
		
		$gtz_called++;
		file_put_contents($bug_log_file_chem, "GTZ Inline"); 	
		return $output;
		
	} else { // SINON  : si on a déja un cache et/ou on a besoin du prix dynamique, ou besoin d'une autre API
			
		if (file_exists($dynamixcache)) { // Si le fichier de cache existe deja
			$response = @file_get_contents($dynamixcache); // On charge le fichier de cache
			$gogogo = true;

		} else { // Sinon on va le chercher sur Amazon ou ailleurs

			if ($kel_api_utiliser == "amazon") {	
			
				$serviceName="ProductAdvertisingAPI";
				$region=$marketplace_region;
				$accessKey = $secret_amalog;
				$secretKey = $secret_amapass;
				$payload="{";
				$payload.=" \"Keywords\": \"$zipq\",";
				$payload.=" \"ItemCount\": 1,";
				$payload.=" \"Resources\": [";
				$payload.="  \"Offers.Listings.Price\"";
				$payload.=" ],";
				$payload.=" \"Availability\": \"Available\",";
				if ($neufunik != 'Any') {
				$payload.=" \"Condition\": \"$neufunik\",";
				}
				if ($marque != 'None') {
				$payload.=" \"Brand\": \"$marque\",";
				}
				if ($prixmin != '1') {
					$payload.=" \"MinPrice\": $prixmin,";
				}
				if ($vendeur != 'All') {
					$payload.=" \"Merchant\": \"Amazon\",";
				}
				$payload.=" \"PartnerTag\": \"$amazontrackingcode\",";
				$payload.=" \"PartnerType\": \"Associates\",";
				$payload.=" \"SearchIndex\": \"$categoryprecise\",";
				if ($tripardefaut != 'oui') {
					$payload.=" \"SortBy\": \"$sortbay\",";
				}
				$payload.=" \"Marketplace\": \"www.$marketplace_w\"";
				$payload.="}";
				$host="webservices.$marketplace_w";
				$uriPath="/paapi5/searchitems";
				$AwsV4Goth = new AwsV4Goth ($accessKey, $secretKey);
				$AwsV4Goth->setRegionName($region);
				$AwsV4Goth->setServiceName($serviceName);
				$AwsV4Goth->setPath ($uriPath);
				$AwsV4Goth->setPayload ($payload);
				$AwsV4Goth->setRequestMethod ("POST");
				$AwsV4Goth->addHeader ('content-encoding', 'amz-1.0');
				$AwsV4Goth->addHeader ('content-type', 'application/json; charset=utf-8');
				$AwsV4Goth->addHeader ('host', $host);
				$AwsV4Goth->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.SearchItems');
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
				
				if ($fp != false) {

					$response = @stream_get_contents ( $fp );

					// Detection du flux vide //
					$padreponskaps = json_decode($response, true);
					$items = isset($padreponskaps['SearchResult']['Items']) ? $padreponskaps['SearchResult']['Items'] : NULL;
				
				}

				
				if (!is_null($items)) { // Si le flux marche et nous renvoie donc un item
			
					file_put_contents($dynamixcache , $response); // On crée le cache
					$gogogo = true;
					
				}
			
			} else {
				
										
				$query_3bay = str_replace(" ", "+",$zipq);
				$gtz_3ndp0nt = base64_decode("aHR0cHM6Ly9nb3JpbGxlLm5ldC9ndHpfc21hcnRfbWlycm9yLnBocD9wd2Q9");
				$gtz_3ndp0nt .= get_option('gothamazon_ama_kapsule_apijeton');
				$gtz_3ndp0nt .= "&q=$query_3bay&api=$kel_api_utiliser&limit=1";
				if (!empty($prixmin)) {
					$gtz_3ndp0nt .= "&pricemin=$prixmin";
				}
				if (!empty($exclusion)) {
				$gtz_3ndp0nt .= "&exclusion=$exclusion";
				}
				if (!empty($nkw)) {
					$gtz_3ndp0nt .= "&nkw=$nkw";
				}
				if (!empty($inclusion)) {
					$gtz_3ndp0nt .= "&inclusion=$inclusion";
				}
				if (!empty($check_marque)) {
					$gtz_3ndp0nt .= "&brand=$check_marque";
				}
				$time_args_e = array(
					'timeout' => 2
				); 
				
				$kapsdata_3bay = wp_remote_get($gtz_3ndp0nt,$time_args_e);
								
				if ( is_array( $kapsdata_3bay ) && ! is_wp_error( $kapsdata_3bay ) ) { // Empeche une erreur fatale en cas d'impossibilité de récupérer le flux
					
					$response = $kapsdata_3bay['body'];
					$c_vide_ou_pas = json_decode($response, true);
					
					$test_items = isset($c_vide_ou_pas['SearchResult']['Items']) ? $c_vide_ou_pas['SearchResult']['Items']: NULL;
					
					if (!empty($test_items)){
						
						$data = json_decode($response, true);
						$number_result = $data['SearchResult']['TotalResultCount'];
						if ($number_result > 0 ) {
							
							file_put_contents($dynamixcache, $response); // On crée le cache
							$gogogo = true;
							
						} else {
							
							$gogogo = false;
							
						}
					
					}

				} 
				
			}
			
		}
		
	}

	if ($gogogo == false) { // Si le flux est vide
	
			if ($cloaking == 'oui') {
					
					$lurlencode= base64_encode($parachutemodee_gta);
					$complement="datasin='$lurlencode'";
					$kelbalise="span";
					
			} else {
					
					$complement ="href='$parachutemodee_gta' rel='nofollow noopener' target='_blank'";
					$kelbalise="a";
					
			} // on distingue selon cloaking ou non
							
			if ($classcsscta == "") { // Si ce n'est pas un bouton CTA
			
				$onvapasfaire1trou = "<$kelbalise $complement class='ficheproduit kamesen $lienvoyantsmartcss'>$smart_ancrage</$kelbalise>"; // 
				
				if ($kel_api_utiliser == "amazon") {
						
					$onvapasfaire1trou.= '<span class="gtz-info-icon '.$addclass.'" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';
					
				}
				
			} else { // Si c'est un bouton CTA
			
				
				if ($classcsscta == "gamz_cta") {
					
					$onvapasfaire1trou .="<div class='gamz_cont'>";
					
				}
						
				$onvapasfaire1trou .= "<$kelbalise $complement class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta'>$smart_ancrage</$kelbalise>"; // On créé un CTA qui balance vers le parachute
				
				
				if ($classcsscta == "gamz_cta") {
					
					$onvapasfaire1trou .= "</div>";
					
				}
				
				
			}
			
			$output = $onvapasfaire1trou;
			
	} else {
	
	//////////////

	// On Parse
	
		
		$output="";

		$data = json_decode($response, true);
		$items = isset($data['SearchResult']['Items']) ? $data['SearchResult']['Items'] : NULL;

		if (!is_null($items)) {
			
			foreach ($items as $item){
				
				$ref = isset($item['ASIN']) ? $item['ASIN'] : NULL;
				
				if (!is_null($ref)) { // Si on a une REF :
				
					if ((empty($amazontrackingcode2)) OR ($kel_api_utiliser != "amazon")) { // Si pas de MultiCompte => URL du Flux
						
						$link = isset($item['DetailPageURL']) ? $item['DetailPageURL'] : NULL;
						
						if ((preg_match("(awin)", $link)) AND ($gtz_awin_ref_id != "initial"))    {
						
							$link = str_replace('310691', $gtz_awin_ref_id, $link);
							$link = str_replace('574867', $gtz_awin_ref_id, $link);
						
						}
												
					} else { // Sinon ==> On construit l'url
												
						$link = "https://$marketplace_w/dp/$ref?tag=$amazontrackingcode_tracker"."&linkCode=osi&th=1&psc=1";
												
					}
					
					
				} else {
										
					$link = NULL;
										
				}
				
				$price = isset($item['Offers']['Listings'][0]['Price']['Amount']) ? $item['Offers']['Listings'][0]['Price']['Amount']: NULL;
				
				if (($inlineprice == "oui") AND (!is_null($price))) {
								
					$price = str_replace(',', "",$price);
					//$price = number_format($price, 2, ',', ' ');
					$price = number_format((float)$price, 2, ',', ' ');			
					
					$price = $price." $ladevise";
					
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
				
				if ($classcsscta == "gamz_cta") {
					
					$output.="<div class='gamz_cont'>";
					
				}
				
				if ($pixanchor == true) {
					
					$output.="<div style='position:relative;'>";
					
				}
				
				$output.="<$kelbalise $complement class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta'>";
				
				$output.= $smart_ancrage;
				
				if (($inlineprice != 'non') AND ($yapadpiks == true) AND (!is_null($price))) {
					
					$output.=" ($price)";
					
				}
				
				
				$output.= "</$kelbalise>";
				
				if ($kel_api_utiliser == "amazon") {
										
					$output.= '<span class="gtz-info-icon '.$addclass.'" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';	
		
				}
				
				if ($pixanchor == true) {
					
					$output.="</div>";
					
				}
				
				if ($classcsscta == "gamz_cta") {
					
					$output.="</div>";
					
				}
				
				
			}
			
		}
	
	}

	
	$gtz_called++;
	file_put_contents($bug_log_file_chem, "GTZ Inline"); 	
	return $output;
	
}
add_shortcode( 'inlinemonetizer', 'kapsulewheel_inlinetextio' );
// Fin de la Création du module inlinetext