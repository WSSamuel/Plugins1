<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

function kapsulewheel_inlineasin( $atts, $content = null, $tag = '') {
	
	global $amazontrackingcode;
	global $marketplace_id;
	global $marketplace_w;
	global $marketplace_region;
	global $amp;
	global $imgtag;
	global $imgtag_resp;
	global $imgtag_close;
	global $cachingtime;
	global $gtz_tokyo4;
	
	// On récupère les attributs des short code
	$a = shortcode_atts( array(
	'asin' => 'Asin', // Anchor
	'ancre' => 'Ancre du lien', // Anchor
	'image_anchor_url' => '',
	'inlineprice' => 'non', 
	'classcsscta' => '',
	'inlinekw' => '',
	'prixmin' => 1, // Prix Min
	'cat' => 'All' // Catégorie précise	// Query
	), $atts );

	$gothamasin_asin = esc_attr( $a['asin'] );
	$ancredulien = esc_attr( $a['ancre'] ); // Ancre du lien
	$construction_du_lien = "https://".$marketplace_w."/dp/$gothamasin_asin?tag=$amazontrackingcode";
	
	if ($amp != true) {
		wp_enqueue_style( 'gothamazon-css-io' );
	}
	
	if ((BEERUS != 'premium') AND (BEERUS != 'godmod') ) { // Si pas PREMIUM, PAS DE CLOAKING ni d'options si ce n'est la classe CSS, simple lien Amazon.
	
		$output = "<a href='$construction_du_lien' rel='nofollow noopener' target='_blank' class='ficheproduit kamesen lienvoyant ama_itxtlink'>$ancredulien</a>";
		$output.= '<span class="gtz-info-icon" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';
	
	} else { // SI PREMIUM, PLUSIEURS OPTIONS

		global $cloaking;
		global $economycostapi;
		global $domainname;
		global $secret_amalog;
		global $secret_amapass;
		global $parachutemodeegta;
		global $amazontrackingcode2;
		global $amazontrackingcode_tracker;
		
			
		// Gestion du parachute intelligent
		$zipq = esc_attr( $a['inlinekw'] );
		
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
		
				
		// Gestion de l'image en ancre
		$image_anchor_url = esc_attr( $a['image_anchor_url'] );
		$pixanchor = false;
		if ($image_anchor_url == "") {
			
		   $smart_ancrage = $ancredulien;
		   $lienvoyantsmartcss = "lienvoyant ama_itxtlink";
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
			
			$smart_ancrage = '<'.$imgtag_resp.' alt="'. $ancredulien. '" title= "'. $ancredulien. '" src="'. $image_anchor_url. '" '.$mesjoliesdimensions.'>'. $imgtag_close.'';
			$lienvoyantsmartcss = "lienvoyantsmartcss";
			$pixanchor = true;
			$yapadpiks = false;
			$addclass = " pixanchor";
			
		}
		// Fin de la gestion de l'image en ancre
		
		$classcsscta = esc_attr( $a['classcsscta'] ); // Permet de rajouter une classe CSS pour un CTA
		
		$output = "";
		
		//Mode Tokyo 4
		if ($gtz_tokyo4 == "oui") {
			
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
				
			$output .= "<$kelbalise $complement class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta'>$smart_ancrage</$kelbalise>"; 
					
			if ($classcsscta == "gamz_cta") {
					
					$output .= "</div>";
					
			}
			
			return $output;
			
		}
		// Fin de Tokyo 4
		
		// Construction du lien PREMIUM				
		$construction_du_lien = "https://".$marketplace_w."/dp/$gothamasin_asin?tag=$amazontrackingcode_tracker"."&linkCode=osi&th=1&psc=1"; // On le reconstruit avec l'éventuel tag partage

		$inlineprice = esc_attr( $a['inlineprice'] );
		
		$prixmin = esc_attr( $a['prixmin'] );
		
		$categoryprecise = esc_attr( $a['cat'] );
		if ($categoryprecise == '') {$categoryprecise = 'All';}
		
		$ioyasin = filter_var($zipq, FILTER_SANITIZE_URL);
		$ioyasin = preg_replace('/[^A-Za-z0-9]/','', $ioyasin);
		$ioyasin = str_replace(' ', '_', $ioyasin);
		$ioyasin = str_replace(';', '', $ioyasin);
		$ioyasin = strtolower($ioyasin);
		
		$kapsule_dirstokage = GOTHAMZ_ROOTPATH . 'storefeed/';
		$dynamixcache = "$kapsule_dirstokage$domainname-inlineASIN-$gothamasin_asin.json"; // On créé le chemin du fichier de cache
		$dynamixcache2 = "$kapsule_dirstokage$domainname-inline_$ioyasin-$categoryprecise-$prixmin-oui.json"; // On créé le chemin du fichier de cache parachute
		
		
		if (($inlineprice == "non") OR ($yapadpiks == false)) { // Si on ne demande pas le prix, ou que l'ancre est une image (donc sans prix)
				
			if ($zipq == "") { // Si parachute vide == On balance sur la page de l'ASIN, dispo ou pas
						
				// on distingue selon cloaking ou non
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
				
				if (($pixanchor == true) OR (!empty($classcsscta))) {
					
					$output.="<div style='position:relative;'>";
								
				}
				
					$output .= "<$kelbalise $complement class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta'>$smart_ancrage</$kelbalise>"; 
					if (empty($classcsscta)) { 
		
						$output.= '<span class="gtz-info-icon '.$addclass.'" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';
						
					} else {
						
						$output.= '<p class="small_sous_cta">#Αmazοn #Rémunéré</p>';
					}
					
					
				if (($pixanchor == true) OR (!empty($classcsscta))) {
						
						$output .= "</div>";
				}
					
				if ($classcsscta == "gamz_cta") {
					
					$output .= "</div>";
					
				}
				
			} else { // Si parachute disponible , on regarde si un cache existe
					
				if (file_exists($dynamixcache) && (( time() - $cachingtime > filemtime($dynamixcache)) OR ( 0 == filesize($dynamixcache) ))) { 
				// Si le fichier existe et qu'il a dépassé la durée de vie du cache OU qu'il est vide) 
				
					unlink ($dynamixcache); // On l'efface
					
				}
					

				if (file_exists($dynamixcache)) { // Si le fichier de cache existe deja c'est que le produit existait les dernières 24H ==> On balance le lien vers la page ASIN

					if ($cloaking == 'oui') {
						
						$lurlencode= base64_encode($construction_du_lien);
						$complement="datasin='$lurlencode'";
						$kelbalise="span";
						
					} else {
						
						$complement ="href='$construction_du_lien' rel='nofollow noopener' target='_blank'";
						$kelbalise="a";
						
					} 
				
					if ($classcsscta == "gamz_cta") {
						
						$output .= "<div class='gamz_cont'>";
						
					}
					
					if (($pixanchor == true) OR (!empty($classcsscta))) {
					
					$output.="<div style='position:relative;'>";
								
					}
						
					$output .= "<$kelbalise $complement class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta'>$smart_ancrage</$kelbalise>"; 
					
					if (empty($classcsscta)) { 
		
						$output.= '<span class="gtz-info-icon '.$addclass.'" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';
						
					} else {
						
						$output.= '<p class="small_sous_cta">#Αmazοn #Rémunéré</p>';
					}
				
					if (($pixanchor == true) OR (!empty($classcsscta))) {
						
						$output .= "</div>";
					}
					
					if ($classcsscta == "gamz_cta") {
						
						$output .= "</div>";
					}
					
				} else { // Si pas encore de cache => on va chercher si produit dispo, et sinon on enverra son cache
				
				
					if (($cloaking =='oui') AND ($economycostapi =='oui')){ // Si cloaking & eco API enclanché on utilise ce moyen plus économe

						// Création de l'appel
						$plugins_url = plugins_url(); // On récupère l'url des plugins
						$urllightapi = "$plugins_url/gothamazon/temp/bl-$gothamasin_asin.php"; //On créé l'url du fichier temportaire
						$urllightapi = base64_encode($urllightapi); // On encode
						$output = "<span datasin='$urllightapi' class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta'>$smart_ancrage</span>"; // On créé le lien cloaké
						
						if (preg_match('/amzn|amazon/i', $parachutemodeegta)) { // Si le parachute est basé sur Amazon
							if (empty($classcsscta)) { 
			
								$output.= '<span class="gtz-info-icon '.$addclass.'" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';
							
							} else {
								
								$output.= '<p class="small_sous_cta">#Αmazοn #Rémunéré</p>';
							}
						}
			
						// Création du ficher temporaire
						$kapsule_plug = GOTHAMZ_ROOTPATH;
						$xfiles = "$kapsule_plug/temp/bl-$gothamasin_asin.php"; // Construction du nom du fichier temporaire
						
						if (!file_exists($xfiles) OR (( time() - 180 > filemtime($xfiles)) OR ( 0 == filesize($xfiles) ))) { // S'il n'existe pas déjà ou a + de 180 secondes
								
							require_once(GOTHAMZ_ROOTPATH.'/inc/encode.php');
							$s_secret_amalog = kaps_encrypt("$secret_amalog"); $s_secret_amapass = kaps_encrypt("$secret_amapass");
							$smartimprovment = "<?php \$domainname = '$domainname';\$gothamasin_asin = '$gothamasin_asin'; \$ioyasin = '$ioyasin';\$zipq='$zipq';\$prixmin='$prixmin';\$categoryprecise='$categoryprecise';\$parachute='$parachutemodee_gta';\$amazontrackingcode='$amazontrackingcode';\$secret_amapass='$s_secret_amapass';\$secret_amalog='$s_secret_amalog';\$marketplace='$marketplace_id';\$amazontrackingcode_tracker='$amazontrackingcode_tracker';\$leroot= \$_SERVER['SERVER_NAME'];\$dirparent = dirname( dirname(__FILE__) ); define('GOTHAMZ_ROOTPATH', \$dirparent); require_once(GOTHAMZ_ROOTPATH.'/eco_asin.php'); unlink(__FILE__); \$current_url = __FILE__; \$crashbandicoot = \"<?php header('Location: \$redirectionok');\"; file_put_contents(\$current_url , \$crashbandicoot);"; // Passage des variables puis auto destruction
							file_put_contents($xfiles , $smartimprovment); // Création du fichier
							
						}
									
					} else {
						
						// On fait tout sur place
						$accessKey = $secret_amalog;
						$secretKey = $secret_amapass;
						$serviceName="ProductAdvertisingAPI";
						$region=$marketplace_region;
						$payload="{";
						$payload.=" \"ItemIds\": [";
						$payload.="  \"$gothamasin_asin\"";
						$payload.=" ],";
						$payload.=" \"Resources\": [";
						$payload.="  \"Offers.Listings.Price\"";
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
						$items = isset($padreponskaps['ItemsResult']['Items'][0]['Offers']['Listings'][0]['Price']['DisplayAmount']) ? $padreponskaps['ItemsResult']['Items'][0]['Offers']['Listings'][0]['Price']['DisplayAmount'] : NULL;

						if (!is_null($items)) { // Si le flux marche et nous renvoie donc un item
						
							file_put_contents($dynamixcache , $response); // On crée le cache
							
							if ($cloaking == 'oui') {
								
								$lurlencode= base64_encode($construction_du_lien);
								$complement="datasin='$lurlencode'";
								$kelbalise="span";
								
							} else {
								
								$complement ="href='$construction_du_lien' rel='nofollow noopener' target='_blank'";
								$kelbalise="a";
								
							} 
							
							$output ="";
							if ($classcsscta == "gamz_cta") {
								
								$output .="<div class='gamz_cont'>";
							}
							
							if (($pixanchor == true) OR (!empty($classcsscta))) {
					
								$output.="<div style='position:relative;'>";
								
							}
							
							$output .= "<$kelbalise $complement class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta'>$smart_ancrage</$kelbalise>"; 
							if (empty($classcsscta)) { 
		
								$output.= '<span class="gtz-info-icon '.$addclass.'" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';
								
							} else {
								
								$output.= '<p class="small_sous_cta">#Αmazοn #Rémunéré</p>';
							}
				
							
							if (($pixanchor == true) OR (!empty($classcsscta))) {
								
								$output .= "</div>";
								
							}
							
							if ($classcsscta == "gamz_cta") {
								
								$output .= "</div>";
								
							}
						
						} else {  // Sinon on cherche par KW
						
						
							if (file_exists($dynamixcache2) && (( time() - $cachingtime > filemtime($dynamixcache2)) OR ( 0 == filesize($dynamixcache2) ))) {  
							// Si le fichier existe et (qu'il a dépassé la durée de vie du cache OU qu'il est vide) 
							
								unlink ($dynamixcache2); // On l'efface
									
							}

							if (file_exists($dynamixcache2)) { // Si le fichier de cache existe deja
							
								$url = $dynamixcache2; // Url du fichier de cache
								$response = @file_get_contents($url); // On charge le fichier de cache
									
							} else {
								
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
								if ($prixmin != '1') {
									$payload.=" \"MinPrice\": $prixmin,";
								}
								$payload.=" \"PartnerTag\": \"$amazontrackingcode\",";
								$payload.=" \"PartnerType\": \"Associates\",";
								$payload.=" \"SearchIndex\": \"$categoryprecise\",";
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

								$response = @stream_get_contents ( $fp );
							}

							// Detection du flux vide //
							$padreponskaps = json_decode($response, true);
							$items = isset($padreponskaps['SearchResult']['Items']) ? $padreponskaps['SearchResult']['Items'] : NULL;

							if (!is_null($items)) { 
							
								// Si le flux marche et nous renvoie donc un item
								file_put_contents($dynamixcache2 , $response); // On crée le cache

							}

							$data = json_decode($response, true);
							$items = isset($data['SearchResult']['Items']) ? $data['SearchResult']['Items'] : NULL;
							
							$newlink = NULL;
							
							if (!is_null($items)) {
								
								foreach ($items as $item){
									
									$ref = isset($item['ASIN']) ? $item['ASIN'] : NULL;
									
									if (!is_null($ref)) { // Si on a une REF :
										
										if (empty($amazontrackingcode2)) { // Si pas de MultiCompte => URL du Flux
											
											$newlink = isset($item['DetailPageURL']) ? $item['DetailPageURL'] : NULL;
											
										} else { // Sinon ==> On construit l'url
											
											$newlink = "https://$marketplace_w/dp/$ref?tag=$amazontrackingcode_tracker"."&linkCode=osi&th=1&psc=1";
											
										}
										
									} else {
										
										$newlink = NULL;
										
									}
									
								}
								
							}
							
							if (is_null($newlink)) { // Si toujours rien => on envoie le parachute GTA, sinon on a choppé le backlink
								
								$newlink = $parachutemodee_gta;
								
							} 
							
							if ($cloaking == 'oui') {
								
								$lurlencode= base64_encode($newlink); 
								$complement="datasin='$lurlencode'";
								$kelbalise="span";
								
							} else {
								
								$complement ="href='$newlink' rel='nofollow noopener' target='_blank'";
								$kelbalise="a";
								
							} 
						
							$output ="";
							
							if ($classcsscta == "gamz_cta") {
								
								$output .="<div class='gamz_cont'>";
								
							}
							
							if (($pixanchor == true) OR (!empty($classcsscta))) {
					
								$output.="<div style='position:relative;'>";
								
							}
							
	
							$output .= "<$kelbalise $complement class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta $addclass'>$smart_ancrage</$kelbalise>"; 
							
							
							if (empty($classcsscta)) { 
		
								$output.= '<span class="gtz-info-icon '.$addclass.'" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';
								
							} else {
								
								$output.= '<p class="small_sous_cta">#Αmazοn #Rémunéré</p>';
							}
	
							
							if (($pixanchor == true) OR (!empty($classcsscta))) {
					
								$output.="</div>";
								
							}
				
							if ($classcsscta == "gamz_cta") {
								
								$output .= "</div>";
								
							}
							
						}
						
					}
				}
			
			}
				
		} else { // Si on demande le prix, on a besoin de se connecter forcément en amont
		

			
			if (file_exists($dynamixcache) && (( time() - $cachingtime > filemtime($dynamixcache)) OR ( 0 == filesize($dynamixcache) ))) {  
				
					// Si le fichier existe et (qu'il a dépassé la durée de vie du cache OU qu'il est vide) 
					unlink ($dynamixcache); // On l'efface
					
			}
			

			if (file_exists($dynamixcache)) { // Si le fichier de cache existe deja
			
				$url = $dynamixcache; // Url du fichier de cache
				$response = @file_get_contents($url); // On charge le fichier de cache
				
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
				$payload.="  \"Offers.Listings.Price\"";
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

				$response = @stream_get_contents ( $fp );
			}
				
			$output="";
			
			// Detection du flux vide //
			$padreponskaps = json_decode($response, true);
			$items = isset($padreponskaps['ItemsResult']['Items'][0]['Offers']['Listings'][0]['Price']['DisplayAmount']) ? $padreponskaps['ItemsResult']['Items'][0]['Offers']['Listings'][0]['Price']['DisplayAmount'] : NULL;
			
			if (!is_null($items)) { // Si le flux marche et nous renvoie donc un item
			
				file_put_contents($dynamixcache , $response); // On crée le cache
				
				// on distingue selon cloaking ou non
				if ($cloaking == 'oui') {
					
					$lurlencode= base64_encode($construction_du_lien);
					$complement="datasin='$lurlencode'";
					$kelbalise="span";
					
				} else {
					
					$complement ="href='$construction_du_lien' rel='nofollow noopener' target='_blank'";
					$kelbalise="a";
					
				} 
							
				$output ="";
				
				if ($classcsscta == "gamz_cta") {
					
					$output .="<div class='gamz_cont'>";
					
				}
				
				if (($pixanchor == true) OR (!empty($classcsscta))) {
					
					$output.="<div style='position:relative;'>";
								
				}
				
				$output .= "<$kelbalise $complement class='ficheproduit kamesen $lienvoyantsmartcss $classcsscta'>$smart_ancrage ($items)</$kelbalise>"; 
				
				if (empty($classcsscta)) { 
		
					$output.= '<span class="gtz-info-icon '.$addclass.'" tabindex="0" aria-haspopup="true"> ⓘ <span class="gtz-tooltip">#Αmazοn #Rémunéré</span></span>';
								
				} else {
								
					$output.= '<p class="small_sous_cta">#Αmazοn #Rémunéré</p>';
				}
				
				if (($pixanchor == true) OR (!empty($classcsscta))) {
					
					$output.="</div>";
								
				}
				
				if ($classcsscta == "gamz_cta") {
					
					$output .= "</div>";
					
				}
						
			} else {
				
				if ($zipq != '') { // Si Mot clé parachute existe, on lance le module ASIN
				
					$output = do_shortcode( '[inlinemonetizer inlinekw="'.$zipq.'" ancre="'.$ancredulien.'" inlineprice="oui" prixmin="'.$prixmin.'" cat="'.$categoryprecise.'" image_anchor_url="'.$image_anchor_url.'" classcsscta="'.$classcsscta.'"]' );
					
				} 
				
				
			}
			
		}
		
	}
	
global $gtz_called;
$gtz_called++;

// MOD LOG TOKYO 4 //
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
		file_put_contents($bug_log_file_chem, "GTZ Inline ASIN"); 

	}
//
	
return $output;

}

add_shortcode( 'inlineASIN', 'kapsulewheel_inlineasin' );
// Fin de la Création du module inlinetext