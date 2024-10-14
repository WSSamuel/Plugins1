<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

function kapsulewheel_startboutique( $atts, $content = null, $tag = '') {
	
	$aturner = get_option('gothamazon_option_aturner');
	if ($aturner == "") {$aturner = "non";}
	
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
	global $cloaking;
	global $cloakingimage;
	global $legalytext;
	global $multisite;
	global $iddusite;
	global $store_multi_id;
	global $amp;
	global $imgtag;
	global $imgtag_resp;
	global $imgtag_close;
	global $cachingtime;
	global $cachingtime_txt;
	global $buildstore;
	global $boodisplayprice;
	global $use_rating;
	global $use_prixbarre;
	global $use_amaprime;
	global $gothamazon_option_marchandlogo;
	global $hidetitre;
	global $gothamazon_option_powered_check;
	global $parachutemodeegta;
	global $gtz_tokyo4;
	global $gtz_tokyo4_3bay;
	global $gtz_linquery_default;
	global $gtz_awin_ref_id;

	
	if ($amp != true) {
		wp_enqueue_style( 'gothamazon-css-io' );
	}
	
	// On récupère les attributs des short code
	$a= shortcode_atts( array(
		'title' => 'Title', // Query
		'prixmin' => 1, // Prix Min
		'prixmax' => '', // Prix Max
		'nono' => 3, // Nombre d'articles
		'design' => 'full', // Design Sidebar ou Full
		'cat' => 'All', // Catégorie précise
		'legal' => $legalytext, // Mentions Amazon
		'hidetitre' => $hidetitre, // Afficher/Masquer le titre
		'aturner' => $aturner, // Afficher le bouton en voir +
		'smartitem4mobile' => '', // Afficher un nombre différent d'articles sur mobile
		'boodisplayprice' => $boodisplayprice, // Afficher/Masquer le titre
		'sort' => $sortbay, // Tri 
		'economiemin' => '', // % de réduction minimum
		'vendeur' => $vendeur, // Amazon ou All
		'neufunik' => $neufunik, // Etat de l'article
		'marque' => '', 
		'linquery' => '', // Utiliser le keyword demandé dans le module (sinon utiliser le titre de l'item du flux)
		'force_api' => '', 
		'special_aff_id' => '', 
		'target_cat_deep' => '', 
		'exclusion' => '',
		'inclusion' => '',
		'nkw' => '',
		'af2' => '',
	), $atts );

	// Query //
	

	$zipq = esc_attr( $a['title'] );
	
	$hashtagamazon = gtz_display_special_mention();
	
		/////////////////////////////
		// Gestion du MultiQuery
		$gtz_intelli_multiquery = gtz_intelli_split_my_query($zipq);
		$multiquery_counter = count($gtz_intelli_multiquery);
		
		if ($multiquery_counter > 1) {
			
			$randomChoice  = function($array) {return $array[array_rand($array)];};
			$zipq = $randomChoice($gtz_intelli_multiquery);
			
		}	
		
		////////////////////////////
		////////////////////////////
	
	// ! Query //
	
	
	// Nombre d'articles
	
	$nono = esc_attr( $a['nono'] ); // Nombre d'items sur PC
	if ($nono == false) {$nono = 3;} // Fix Bug dans les nouveaux Blocks Widgets

	// Affichage ou non du Prix
	$boodisplayprice_ghost = isset($boodisplayprice) ? $boodisplayprice : NULL; // A garder pour référence
	$store_my_devise = isset($ladevise) ? $ladevise : "€"; // A garder pour référence 
	$store_my_linquery = isset($gtz_linquery_default) ? $gtz_linquery_default : NULL; // A garder pour référence 
	
	if ((BEERUS == 'premium') OR (BEERUS == 'godmod') ) { // si le shortcode le veut, il peut écraser ou non le tri par défaut 
		
		// FORCE API
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
		
		$initial_carbon_kel_api_utiliser = $kel_api_utiliser;	
		
		// Ecrasage ciblé d'une ID AFF
		$special_aff_id = esc_attr( $a['special_aff_id'] );
		if (!empty($special_aff_id)) {
			
			$gtz_awin_ref_id = $special_aff_id;
			
		}
		
		// Appel d'un flux par catégorie
		$target_cat_deep = esc_attr( $a['target_cat_deep'] ); 
		
		// AF2
		$af2 = esc_attr( $a['af2'] ); 
		$af2_s = str_replace(',', '', $af2);
		
		if (($kel_api_utiliser == "amazon") AND (!empty($af2))) {$kel_api_utiliser = "cdiscount";} // Si on demande un Genkidama on ne peut pas partir en natif sur AMZ et on doit utiliser GTZ
		
		// Exclusion d'un marchand pour les flux multimarchands
		$exclusion = esc_attr( $a['exclusion'] ); 
		
		// Inclusion d'un ou plusieurs marchands pour les flux multimarchands
		$inclusion = esc_attr( $a['inclusion'] ); 
		$inclusion_s = str_replace(',', '', $inclusion);
		
		// Inclusion des negatives kw
		$nkw = esc_attr( $a['nkw'] ); 
		$nkw_s = str_replace(',', '', $nkw);
	
		// Prix Min
		$prixmin = esc_attr( $a['prixmin'] );
		if (($prixmin == 0) OR ($prixmin == '')) {$prixmin = 1;}
		/// Prix Max ///
		$prixmax = esc_attr( $a['prixmax'] );
		if (($prixmax == '1000000') OR ($prixmax == '')) {$kachprixmax='z';$prixmax = NULL;} else {$kachprixmax=$prixmax;}
		///////////////
		
		$categoryprecise = esc_attr( $a['cat'] );
	
		$check_sortbay = $a['sort']; 
		if (!empty($check_sortbay)) {$sortbay = $check_sortbay;} else {$sortbay = "Default";}
		if (($sortbay == '') OR ($sortbay == 'Default')) {$tripardefaut = 'oui';} else {$tripardefaut = 'non';}
		
		$check_eco = $a['economiemin']; if (!empty($check_eco)) {$economiemin = $check_eco;} else {$economiemin = false;}
		
		$check_vendeur = $a['vendeur']; if (!empty($check_vendeur)) {$vendeur = $check_vendeur;} else {$vendeur = "All";}
		
		$check_marque = esc_attr( $a['marque'] ); if (!empty($check_marque)) {$marque = $check_marque;$marque4slug = sanitize_title($check_marque);} else {$marque = "None";$marque4slug="None";}
		
		$boodisplayprice = esc_attr( $a['boodisplayprice'] );
		if ($boodisplayprice == 'defaut') {$boodisplayprice = $boodisplayprice_ghost;} 
		
		if (($gtz_tokyo4 == "oui") AND ($kel_api_utiliser != "ebay")) { $boodisplayprice = "non"; }
		
		$hidetitre_w = esc_attr( $a['hidetitre'] ); // si le shortcode le veut, il peut écraser ou non l'affichage du titre
		if (($hidetitre_w != "") AND ($hidetitre_w != "defaut")) {$hidetitre = $hidetitre_w;} // Si le paramètre hidetitre du widget n'est pas vide ou différent de defaut, il remplace le paramètre par défaut
		
		$smartitem4mobile = esc_attr( $a['smartitem4mobile'] ); // nombre différents d'articles pour mobile
		if (($smartitem4mobile == 'defaut') OR ($smartitem4mobile == '')) {
			/// On retranche 1 Item si nono est impaire mais différent de 1 (bug qui donnait 0)
				if (($nono%2 == 1) AND ($nono != 1))
					{$smartitem4mobile= $nono-1;}
				else 
					{$smartitem4mobile= $nono;}
				//////
		} 
		
		$check_neufunik = $a['neufunik']; if (!empty($check_neufunik)) {$neufunik = $check_neufunik;} else {$neufunik = "Any";}
		
	}  else { // On rétrograde certaines fonctions
	
		$kel_api_utiliser = "amazon";	
		$prixmin = 1;
		$prixmax = NULL; $kachprixmax = 'z';
		$categoryprecise = "All";
		$tripardefaut = 'oui';
		$economiemin = false;
		$vendeur = "All";
		$marque = "None";
		$boodisplayprice = $boodisplayprice_ghost;
		$hidetitre = "non";
		$smartitem4mobile = $nono;
		$neufunik = "Any";	
		$exclusion = "";
		$inclusion = "";
		$inclusion_s = "";
		$nkw = "";
		$nkw_s = "";
		$target_cat_deep = "";
		$af2 = ""; 
		$af2_s = "";
		
	}


	// Derniers Paramètres
	$legalytext = esc_attr( $a['legal'] ); // si le shortcode le veut, il peut écraser l'affichage ou non du texte légal
	$genkidama_is_possible = "no"; // Ne permet que le genkidama si GTZ a trouvé qqch
	$lafusion_a_marche = "no"; // Ne permet que la megafusion si effective
	$sidebardesign = esc_attr( $a['design'] ); // Design


	if ($sidebardesign == "hybrid") {
		
		if (GOTHAMZ_VMOB == "mobile") {
			
			$sidebardesign = "slider";
			
		} else {
			
			$sidebardesign = "sidebar";
			
		} 
		
	}
	
	$leshowmustgoon = esc_attr( $a['aturner'] ); // si le shortcode le veut, il peut écraser ou non l'affichage du bouton en voir +
	
	// Création du Chemin Cache
	$ioyasin = $zipq; 
	$kapsule_dirstokage = GOTHAMZ_UPLOAD_PATH;
	$kapsule_dirstokage_backup = GOTHAMZ_UPLOAD_PATH_BACKUP;
	$ioyasin = filter_var($ioyasin, FILTER_SANITIZE_URL);
	$ioyasin = preg_replace('/[^A-Za-z0-9]/','', $ioyasin);
	$ioyasin = str_replace(' ', '_', $ioyasin);
	$ioyasin = str_replace(';', '', $ioyasin);
	$ioyasin = strtolower($ioyasin);
	
	$dynamixcache = "$kapsule_dirstokage$domainname-shop_$ioyasin-$categoryprecise-$boodisplayprice-$hidetitre-$prixmin-$kachprixmax-$nono-$sortbay$economiemin$vendeur$marque4slug$kel_api_utiliser$target_cat_deep-ex$exclusion-inc$inclusion_s-nkw$nkw_s-multi$af2_s.json"; // On créé le chemin du fichier de cache
	// Module pour ne pas redemander des flux plus petit si on a déja appelé un flux de 9 
	$dynamixcache9items = "$kapsule_dirstokage$domainname-shop_$ioyasin-$categoryprecise-$boodisplayprice-$hidetitre-$prixmin-$kachprixmax-9-$sortbay$economiemin$vendeur$marque4slug$kel_api_utiliser$target_cat_deep-ex$exclusion-inc$inclusion_s-nkw$nkw_s-multi$af2_s.json"; 
	if (file_exists($dynamixcache9items)) {$dynamixcache = $dynamixcache9items;}
	
	
	///////////////////////////

	if ($gtz_tokyo4 != "oui") { // Si Mode Normal
		
		if (file_exists($dynamixcache) && (( time() - $cachingtime > filemtime($dynamixcache)) OR ( 0 == filesize($dynamixcache) ))) {  // Si le fichier existe et (qu'il a dépassé la durée de vie du cache OU qu'il est vide) 
						
			$dynamixcache_archive = str_replace($kapsule_dirstokage,$kapsule_dirstokage_backup,$dynamixcache);
			
			if (file_exists($dynamixcache_archive)) { // Si un cache existe deja
		
				unlink ($dynamixcache_archive); // On l'efface
				rename($dynamixcache, $dynamixcache_archive); // On fait un nouveau backup
				
			} else { // Sinon on fait juste un backup
				
				rename($dynamixcache, $dynamixcache_archive);
			
			}
			
		}
		
	} else {
		
		if (!file_exists($dynamixcache)) { // Si pas de cache, on cherche un fichier similaire meme si les variables ne sont pas identiques
			
			$glob_checker = $kapsule_dirstokage.''.$domainname.'-shop_'.$ioyasin.'*.json'; 
			
			$files = glob($glob_checker);
			if (count($files) > 0) {
				
				$dynamixcache = $files[0];	
				
			} else {
				
				$glob_checker2 = $kapsule_dirstokage_backup.''.$domainname.'-shop_'.$ioyasin.'*.json'; 
				$files2 = glob($glob_checker2);
				
				if (count($files2) > 0) {
				
					$dynamixcache = $files2[0];
				
				}
				
			}
			
		}	
		
	}
	
	$switch23bay = "";
	if ($kel_api_utiliser != "amazon") { // Si ebay ou gtz demande
			
		if (file_exists($dynamixcache)) { // Si le fichier de cache existe deja
	
			$response = @file_get_contents($dynamixcache); // On charge le fichier de cache
			$onstoptout = false;
			$switch23bay = true;
		
		} else { // Sinon on fait un call ebay ou gtz
		
			$query_3bay = str_replace(" ", "+",$zipq);
			$gtz_3ndp0nt = base64_decode("aHR0cHM6Ly9nb3JpbGxlLm5ldC9ndHpfc21hcnRfbWlycm9yLnBocD9wd2Q9");
			$gtz_3ndp0nt .= get_option('gothamazon_ama_kapsule_apijeton');
			$gtz_3ndp0nt .= "&q=$query_3bay&api=$kel_api_utiliser&limit=$nono";
			if (!empty($prixmin)) {
				$gtz_3ndp0nt .= "&pricemin=$prixmin";
			}
			if (!empty($target_cat_deep)) {
				$gtz_3ndp0nt .= "&searchbycat=$target_cat_deep";
			}
			if (!empty($exclusion)) {
				$gtz_3ndp0nt .= "&exclusion=$exclusion";
			}
			if ($economiemin != false) {
				$gtz_3ndp0nt .= "&promo=1";
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
			if (!empty($af2)) {
				$gtz_3ndp0nt .= "&io_aff2=$af2";
			}
			
			if ($af2 == "genkidama") {

				$time_args_e = array(
					'timeout'     => 50
				); 
				
			} else {
				
				$time_args_e = array(
					'timeout'     => 5
				); 
				
			}
		
			$kapsdata_3bay = wp_remote_get($gtz_3ndp0nt,$time_args_e);
			//var_dump($gtz_3ndp0nt);
			
			/* Nouveau Module de Prevention de Flux Vide */
			$check_if_ama_entered = get_option('gothamazon_ama_login');
			$plugins_url = plugins_url();
			$precoce_output = "<p style='margin: 20px 0;font-size: 20px;font-weight: bold;line-height: 24px;border: 6px solid;border-radius: 3px;padding: 80px 0;display:block;background:white;text-align:center;color:#181818;'><span style='text-align:center;margin-bottom:20px;display:block'><img src='$plugins_url/gothamazon/img/maintenance.gif'></span>Maintenance de la boutique</p>";
		
			if ( is_array( $kapsdata_3bay ) && ! is_wp_error( $kapsdata_3bay ) ) { // Empeche une erreur fatale en cas d'impossibilité de récupérer le flux
			
				$response = $kapsdata_3bay['body'];

				$c_vide_ou_pas = json_decode($response, true);
				$test_items = isset($c_vide_ou_pas['SearchResult']['Items']) ? $c_vide_ou_pas['SearchResult']['Items']: NULL;
				
				
				if (!empty($test_items)){
	
					$onstoptout = false;
					$switch23bay = true;
					$data = json_decode($response, true);
					$number_result = $data['SearchResult']['TotalResultCount'];
					
					if ($number_result > 0 ) {
							
						file_put_contents($dynamixcache, $response); // On crée le cache
						$genkidama_is_possible = "yes";
							
					} else {
					
						$onstoptout = true;
						$switch23bay = false;
						if (!empty($check_if_ama_entered)) {
							
							$kel_api_utiliser = "amazon";
							
						} else {
							
							if (($sidebardesign != "sidebar") AND ($nono > 3)) {
					
								return $precoce_output;
						
							} else {
								
								return;
								
							}
						
						}
						
					}
					
				
				} else {
							
					$switch23bay = false;
					$kel_api_utiliser = "amazon";
					if (!empty($check_if_ama_entered)) {
						
						$kel_api_utiliser = "amazon";
						
					} else {
						
						if (($sidebardesign != "sidebar") AND ($nono > 3)) {
					
								return $precoce_output;
						
						} else {
								
							return;
								
						}
					
					}
					
				}

			} else {
				
				$switch23bay = false;
				$kel_api_utiliser = "amazon";
				
			}
			
		}
	
	} 	
	
	// Module de MEGA FUSION
	if ((($af2 == "genkidama") OR (preg_match("/amazon/", $af2))) AND ($genkidama_is_possible == "yes") AND (!empty($secret_amalog))) {
		
			$onstoptout = false;
			
			$serviceName="ProductAdvertisingAPI";
			$region = $marketplace_region;
			$accessKey = $secret_amalog;
			$secretKey = $secret_amapass;
			$payload="{";
			$payload.=" \"Keywords\": \"$zipq\",";
			$payload.=" \"ItemCount\": $nono,";
			$payload.=" \"Resources\": [";
			$payload.="  \"Images.Primary.Large\"";
			$payload.=",  \"ItemInfo.Title\"";
			
			if ($boodisplayprice == "oui") {
				
				$payload.=",  \"Offers.Listings.Price\"";
				if ($use_prixbarre == "oui") {
					
					$payload.=",  \"Offers.Listings.Promotions\"";
					$payload.=",  \"Offers.Listings.SavingBasis\"";
					
				}
				
			}
			
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
			if (!is_null($prixmax)) {
				$payload.=" \"MaxPrice\": $prixmax,";
			}
			if ($economiemin != '') {
				$payload.=" \"MinSavingPercent\": $economiemin,";
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
			$mega_response = @stream_get_contents ( $fp );

			// Detection du flux vide //
			$mega_padreponskaps = json_decode($mega_response, true);
			$mega_items = isset($mega_padreponskaps['SearchResult']['Items']) ? $mega_padreponskaps['SearchResult']['Items'] : NULL ;
		
			if (!is_null($mega_items)) { // Si le flux AMZ marche et nous renvoie donc un item
			
				$fusionultime = array_merge_recursive($data,$mega_padreponskaps);
				
				function gtz_fusion_shuffle_assoc($list) {
	
					if (!is_array($list)) return $list;
					$json_shuffled = array( "SearchResult" => array("Items" => array()));
					$keys = array_keys($list['SearchResult']['Items']);
					shuffle($keys);
					foreach ($keys as $key) {
						$json_shuffled['SearchResult']['Items'][$key] = $list['SearchResult']['Items'][$key];
					}
					return $json_shuffled;
				}
				
				$fusionultime = gtz_fusion_shuffle_assoc($fusionultime);
				$fusionultime = json_encode($fusionultime);
				$lafusion_a_marche = "yes";
				
				file_put_contents($dynamixcache , $fusionultime); // On crée le cache

			} 
			
	}
	// Fin du Module de MEGAFUSION
	
			
	if ($switch23bay != true) { // Amazon System

		$dynamixcache = str_replace($initial_carbon_kel_api_utiliser, "amazon", $dynamixcache);

		if (file_exists($dynamixcache)) { // Si le fichier de cache existe deja
		
			$response = @file_get_contents($dynamixcache); // On charge le fichier de cache
			$onstoptout = false;
			
		} else { 
				
			$serviceName="ProductAdvertisingAPI";
			$region = $marketplace_region;
			$accessKey = $secret_amalog;
			$secretKey = $secret_amapass;
			$payload="{";
			$payload.=" \"Keywords\": \"$zipq\",";
			$payload.=" \"ItemCount\": $nono,";
			$payload.=" \"Resources\": [";
			$payload.="  \"Images.Primary.Large\"";
			$payload.=",  \"ItemInfo.Title\"";
			
			if ($boodisplayprice == "oui") {
				
				$payload.=",  \"Offers.Listings.Price\"";
				if ($use_prixbarre == "oui") {
					
					$payload.=",  \"Offers.Listings.Promotions\"";
					$payload.=",  \"Offers.Listings.SavingBasis\"";
					
				}
				
			}
			
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
			if (!is_null($prixmax)) {
				$payload.=" \"MaxPrice\": $prixmax,";
			}
			if ($economiemin != '') {
				$payload.=" \"MinSavingPercent\": $economiemin,";
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
			
			if ($fp == false) {
				
				if (($sidebardesign != "sidebar") AND ($nono > 3)) {
					
					$plugins_url = plugins_url();
					$precoce_output = "<p style='margin: 20px 0;font-size: 20px;font-weight: bold;line-height: 24px;border: 6px solid;border-radius: 3px;padding: 80px 0;display:block;background:white;text-align:center;color:#181818;'><span style='text-align:center;margin-bottom:20px;display:block'><img src='$plugins_url/gothamazon/img/maintenance.gif'></span>Store actuellement en maintenance. Retour imminent.</p>";
					return $precoce_output;
			
				} else {
					
					return;
					
				}
				
			}

			$response = @stream_get_contents ( $fp );

			// Detection du flux vide //
			$padreponskaps = json_decode($response, true);
			$items = isset($padreponskaps['SearchResult']['Items']) ? $padreponskaps['SearchResult']['Items'] : NULL ;
			$onstoptout = false;
			
			if (!is_null($items)) { 
			
					// Si le flux marche et nous renvoie donc un item
					file_put_contents($dynamixcache , $response); // On crée le cache
					$onstoptout = false;
					
			} else {
				
					$onstoptout = true;
					
			}
			
		}
	
	}
	//////////////
	
	// Tokyo 4 //
	
	if ($gtz_tokyo4 == "oui") {

		// Preparation des images
		if (preg_match("(cdiscount)", $parachutemodeegta)) {
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
				
		if ($force_api !='') {
		
			$gtz_filou_px = $force_api;
	
		}
	
	} else {
		
		$gtz_filou_px = $kel_api_utiliser;
		
	}
	// ! Tokyo4 //


	$output = "";

	if ($onstoptout != true) {
		
		// On Parse
		$plugins_url = plugins_url();

		if ($amp != true) { 
		// Si c'est AMP on ne peut pas afficher ce script en plein milieu
			$preloadimgg = "$plugins_url/gothamazon/img/arrow.svg";
			$output.="<script>new Image().src = '$preloadimgg';</script>"; // On précharge l'image hover
			$amp_class_2k23 = "";
			
		} else {
			
			$amp_class_2k23 = "v_amp";
		}
		
		$output.="<div style='clear:both;'></div>";
		
		if ($sidebardesign == 'sidebar') {
			
			$output.="<ul class='smartstore smartstoresidebar izishop92 goku $amp_class_2k23'>";
			
		} elseif ($sidebardesign == 'slider') {
			
			$idkroussel = rand();
			$idkrousselo = "krousel".$idkroussel;
			$output.="<div class='ssjinstinct relative_ssj4slider'>";
			if ($amp != true) { 
				$output.='<div class="ssj24-carousel-arrow ssj24-left-arrow" onclick="scrollKrousel(\'left\' , \''.$idkrousselo.'\')">' .
				'<img src="'.$plugins_url.'/gothamazon/img/left_a.png" alt="Précédent"/>' .
				'</div>';
			}
			$output.="<ul class='smartstore izishop92 vegeta $amp_class_2k23' id='$idkrousselo'>";
			
			
			
		} elseif ($sidebardesign == 'listing') {
			
			$output.="<div class='ssjlisting'><ul class='smartstore izishop92 vegeta $amp_class_2k23'>";
			
		} else {
			
			$output.="<ul class='smartstore izishop92 vegeta $amp_class_2k23'>";
			
		}
		
		$data = json_decode($response, true);
		
		// MODE FUSION ULTIME
		if ($lafusion_a_marche == "yes") { // On ecrase la variable data avec le megamix
			
			$data = json_decode($fusionultime, true);
		
		} 		
		// FIN DU MODE FUSION ULTIME

		$items = isset($data['SearchResult']['Items']) ? $data['SearchResult']['Items'] : NULL;
		$compteur = 0;
		
		// Si on a passé un nombre différent d'article pour mobile que pour PC on stope la boucle avant, sans demander un nouveau flux
		if (GOTHAMZ_VMOB == "mobile") {
			
			$nbArt2Parse = $smartitem4mobile;
			
		} else {
			
			$nbArt2Parse = $nono;
			
		} 
		
		foreach ($items as $item){
			
			if($compteur == $nbArt2Parse) break;
			$leprixstrike = "";
			$mkstriker = "";
			$ref = isset($item['ASIN']) ? $item['ASIN'] : NULL;
			
			$get_merchand_name = isset($item['Bonus']['Marchand']) ? $item['Bonus']['Marchand'] : NULL;
			if (!is_null($get_merchand_name)) {
				$slug_merchand_name = sanitize_title($get_merchand_name);
			}
			
			if ($gtz_tokyo4 != "oui") { // Mode Normal
			
				if ((empty($amazontrackingcode2)) OR ($kel_api_utiliser != "amazon")) { // Si pas de MultiCompte => URL du Flux
					
					$link = isset($item['DetailPageURL']) ? $item['DetailPageURL'] : NULL;
					
					if ((preg_match("(awin)", $link)) AND ($gtz_awin_ref_id != "initial"))    {
						
						$link = str_replace('310691', $gtz_awin_ref_id, $link);
						$link = str_replace('574867', $gtz_awin_ref_id, $link);
						
					}
					
				} else { // Sinon ==> On construit l'url
					
					$link = "https://$marketplace_w/dp/$ref?tag=$amazontrackingcode_tracker"."&linkCode=osi&th=1&psc=1";
					
				}
			
			} else { // Mode Tokyo 4
				
				if ($switch23bay == true) { // eBay
				
					$link =  isset($item['DetailPageURL']) ? $item['DetailPageURL'] : NULL;
					if ((preg_match("(awin)", $link)) AND ($gtz_awin_ref_id != "initial"))    {
						
						$link = str_replace('310691', $gtz_awin_ref_id, $link);
						$link = str_replace('574867', $gtz_awin_ref_id, $link);
						
					}
				
				} else { // Smart Parachute
				
					$tokyo4_title = isset($item['ItemInfo']['Title']['DisplayValue']) ? $item['ItemInfo']['Title']['DisplayValue'] : NULL;
					$linquery = esc_attr( $a['linquery'] ); // Utilise le keyword demandé dans le module (sinon utiliser le titre de l'item du flux)
					if ($linquery == '') {$linquery = $store_my_linquery;} 
					
					if ((is_null($tokyo4_title)) OR ($linquery == "oui")) {
						
						$tokyo4_sanitized_query = sanitize_title_with_dashes($zipq);	
					
						
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
				
			}
	
			if (($kel_api_utiliser == "lafayette") OR ($kel_api_utiliser == "global_tech")) { 
			
				$image = isset($item['Images']['Thumb']['URL']) ? $item['Images']['Thumb']['URL'] : NULL;
				
			} else {
				
				$image = isset($item['Images']['Primary']['Large']['URL']) ? $item['Images']['Primary']['Large']['URL'] : NULL;

			}
			
			$image_width = isset($item['Images']['Primary']['Large']['Width']) ? $item['Images']['Primary']['Large']['Width'] : NULL;
			$image_height = isset($item['Images']['Primary']['Large']['Height']) ? $item['Images']['Primary']['Large']['Height'] : NULL;
			
			if (!empty($image)) {
				
				$image_statut = get_headers($image);
				$image_statut = $image_statut[0];
				
				if ($kel_api_utiliser != "wegoboard") { // Wegoboard a des images en 404 qui fonctionnent pourtant
				
					if ((strpos($image_statut,"403")) OR (strpos($image_statut,"404")) OR (strpos($image_statut,"500"))) {
						
						$image = "$plugins_url/gothamazon/img/nopics.png";
						
					}
				
				}
			
			} else {
				
				 $image = "$plugins_url/gothamazon/img/nopics.png";
			}
			
			if (empty($image_width)) {$image_width = 400;}
			if (empty($image_height)) {$image_height = 500;}
			
			if ( BEERUS == "godmod" ) {
				
				if ($buildstore == "oui") {
					
					if (($nbArt2Parse >= 4) AND ($sidebardesign != 'sidebar')){ // Si nombre items supérieur/égal à 4 et pas en sidebar, sinon ce n'est pas une page catégorie fake
					
						$id_page_appelante = get_the_ID();
						$upload_dir_url = wp_get_upload_dir();
						$kapsule_dirstokage_pics = $upload_dir_url["basedir"];
						$kapsule_dirstokage_pics = $kapsule_dirstokage_pics . '/gothamazon';
						
						if (! is_dir($kapsule_dirstokage_pics)) {
							mkdir( $kapsule_dirstokage_pics, 0755 );
						}

						if ($compteur == 0) {
							copy($image, "$kapsule_dirstokage_pics/$store_multi_id$id_page_appelante.jpg");
						}
					}
				
				}
				
				if (($gtz_tokyo4 == "oui") OR (($cloakingimage == 'oui') AND ($kel_api_utiliser != "amazon"))) {
					
					$upload_dir_url = wp_get_upload_dir();
					
					$kapsule_dirstokage_pics_t4 = $upload_dir_url["basedir"];
					$kapsule_dirstokage_pics_t4 = $kapsule_dirstokage_pics_t4 . '/gtz_t4';
					
					if (! is_dir($kapsule_dirstokage_pics_t4)) {
						mkdir( $kapsule_dirstokage_pics_t4, 0755 );
					}
					
					$chemin_img_bup = "$kapsule_dirstokage_pics_t4/$slug_merchand_name$ref.jpg";
					
					$upload_dir_url_gtzt4 = $upload_dir_url["baseurl"] . '/gtz_t4';
					$chemin_http_img_bup = "$upload_dir_url_gtzt4/$slug_merchand_name$ref.jpg";
					
					if (file_exists($chemin_img_bup) && ((time() - 43200 < filemtime($chemin_img_bup)) AND (filesize($chemin_img_bup) > 0))) { // Si l'image existe, a quelques octets et a moins de 12H
						
						$image = $chemin_http_img_bup;
						
					} else {
						
						@copy($image, $chemin_img_bup);

					}

				}
				
				
			}
			
			// Module Cloaking Image
			if (($cloakingimage == 'oui') AND ($gtz_tokyo4 != "oui") AND ($kel_api_utiliser == "amazon")) {
				
				$image_ama_id = str_replace("https://m.media-amazon.com/images/I/","",$image);
				$image_ama_id = str_replace(".jpg","",$image_ama_id);
				$image = rest_url( "gtz/v1/smartimg/{$image_ama_id}" );
				
			}
			//
			
			// A laisser même si on manque le titre pour les balises ALT
			$title = isset($item['ItemInfo']['Title']['DisplayValue']) ? $item['ItemInfo']['Title']['DisplayValue'] : NULL;
			if (!is_null($title)) {
				$sanitize_alt_title = str_replace('"', "", $title);
				$sanitize_alt_title = str_replace("'", "", $sanitize_alt_title);
				$sanitize_alt_title = mb_strimwidth($sanitize_alt_title, 0, 60);
				$title_truncate = mb_strimwidth($title, 0, 30, "...");
			}
			//

			if ($boodisplayprice == "oui") {
				
				$price = isset($item['Offers']['Listings'][0]['Price']['Amount']) ? $item['Offers']['Listings'][0]['Price']['Amount'] : NULL;
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
	
						$pourcentrealise = isset($item['Offers']['Listings'][0]['Price']['Savings']['Percentage']) ? $item['Offers']['Listings'][0]['Price']['Savings']['Percentage'] : NULL;
						$prix_de_base2k22 = isset($item['Offers']['Listings'][0]['SavingBasis']['Amount']) ? $item['Offers']['Listings'][0]['SavingBasis']['Amount'] : NULL;
						
						if ((!is_null($prix_de_base2k22)) AND ($prix_de_base2k22 != 0)) {
						
							$calculduprixdebaz = $prix_de_base2k22;
							$calculduprixdebaz = str_replace(',', "",$calculduprixdebaz);
							$calculduprixdebaz = number_format($calculduprixdebaz, 2, ',', ' ');
						
						} else {
						
							$calculduprixdebaz = $prixnumerik + $economierealisee;
							$calculduprixdebaz = number_format($calculduprixdebaz, 2, ',', ' ');
						
						}
					
						$leprixstrike = "<strike>$calculduprixdebaz $display_devise</strike>";
						
						if ($sidebardesign == 'full') {
							
							$mkstriker="style='line-height:16px;'";
							
						} else {
							
							$mkstriker="style='width:100%;padding:0;'";
							
						}
					}
				}
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

			// Module Etoiles Aleatoire 
			$gothamrating = "";
			if ($use_rating == "oui") {
				
				$urldulogoprime = "$plugins_url/gothamazon/img/prime.png";
				$urldulogo45stars = "$plugins_url/gothamazon/img/45rate.png";
				$urldulogo5stars = "$plugins_url/gothamazon/img/5rate.png";
				$carapuce = strlen($title);
				
				$gothamrating='<span class="gothamrate">';
				if ($carapuce%2 == 1) {
					
					$gothamrating .='<'. $imgtag .' src="'. $urldulogo45stars .'" alt="Avis sur '. $sanitize_alt_title .'" class="gotrate" width="97" height="27">'. $imgtag_close .'';
					
				} else {
					
					$gothamrating .='<'. $imgtag .' src="' .$urldulogo5stars .'" alt="Avis sur '. $sanitize_alt_title .'" class="gotrate" width="97" height="27">'. $imgtag_close .'';
					
				}
				$gothamrating .='</span>';
			}	
			// ! Module Etoiles Aleatoire
			
			/* Module Highlight */
			$ssj_highlight = isset($item['Offers']['Listings'][0]['Price']['Savings']['Amount']) ? $item['Offers']['Listings'][0]['Price']['Savings']['Amount'] : NULL;
			if ((!is_null($ssj_highlight)) AND ($ssj_highlight != 0) AND ($ssj_highlight != "")) { 
			
				$output.="<li class='kmh'>";
			
			} else {
				
				$output.="<li>";
			
			}
			/* ! Module Highlight */
			
			$output.="<$kelbalise $complement class='ficheproduit kamesen'>";
			
			if ($hidetitre == 'non') {$output.="<span class='storeitemtitle ratak'>$title_truncate</span>";}
			
			$output.='<span class="imgkra"><'. $imgtag_resp. ' src="' .$image. '" alt="'. $sanitize_alt_title. '" class="mainpics" width="'. $image_width .'" height="'. $image_height .'">'. $imgtag_close .'</span>'. $gothamrating. '';
			
			$show_merchand_logo = true;
			$show_merchand_name = false;
			
			if ((BEERUS == "godmod") OR ($legalytext == "oui")) {
				
				if ($gtz_tokyo4 == "oui") {
					
					if ($gothamazon_option_marchandlogo == "oui") {$show_merchand_logo = true;} else {$show_merchand_logo = false;}
					$gtz_amz_url = "$plugins_url/gothamazon/img/$gtz_filou_px.png"; 
					
				} else {
					
					if ($kel_api_utiliser == "amazon") {
						
						$show_merchand_logo = true;
						$gtz_amz_url = "$plugins_url/gothamazon/img/amz.png"; 
					
					} else {
						
						if ($gothamazon_option_marchandlogo == "oui") {
							
							$show_merchand_logo = true;
							
							if ((!preg_match("(global)", $kel_api_utiliser)) AND (empty($af2))) { // Si on trouve le mot global dans le flux => c'est un flux multimarchand
							
								$gtz_amz_url = "$plugins_url/gothamazon/img/$gtz_filou_px.png"; 
								
							} else {
								
								if (preg_match("/amazon/", $link)) {
									
									$gtz_amz_url = "$plugins_url/gothamazon/img/amz.png"; 
									
								} elseif (file_exists(GOTHAMZ_ROOTPATH . "img/$slug_merchand_name.png")) {
									
									$gtz_amz_url = "$plugins_url/gothamazon/img/$slug_merchand_name.png"; 
									
								} elseif (is_numeric($slug_merchand_name)) {
									
									$gtz_amz_url = "$plugins_url/gothamazon/img/smartbug.png"; 
									
								}  else {
				
									$gtz_amz_url = "$plugins_url/gothamazon/img/disponow.png"; 
									$maj_merchand_name = str_replace(" FR","", $get_merchand_name);
									$maj_merchand_name = strtoupper($maj_merchand_name);
									$show_merchand_name = "<br><strong>($maj_merchand_name)</strong>";
									
								}
								
							}
				
						} else {
								
								$show_merchand_logo = false;
								
						}

					}
					
				}
				
				if ($show_merchand_logo == true) {
					
					$output.='<span class="gtz_amz"><'. $imgtag_resp. ' src="' .$gtz_amz_url. '" alt="'. $sanitize_alt_title. '" width="200" height="52">'. $imgtag_close .''.$show_merchand_name.'</span>';
					
					
				}
	
				if (($kel_api_utiliser == "amazon") OR (preg_match("/amazon/", $link))) {
						
					$output .= $hashtagamazon;
					
				}
			
			}
			
			
			$output.='<span class="storeitemfoo">';
			
			if ($boodisplayprice == 'oui') {
				
				$output.="<span class='storeitemprice' $mkstriker><span style='white-space:nowrap;'>$price $display_devise</span> $leprixstrike </span>";
				$cuzhprice_css='';
				
			} else {
				
				$cuzhprice_css ='cuzprice_css';
				
			}
			
			$output.="<span class='storeitemcta $cuzhprice_css'><span class='eyecandyoptim'><span>Voir</span>";
			$output.="</span></span></span></$kelbalise></li>";
			$compteur++;
			
		}
		
		$output.= "</ul>";
		
		
		if ($sidebardesign == 'slider') {
			
			if ($amp != true) { 
				$output.='<div class="ssj24-carousel-arrow ssj24-right-arrow" onclick="scrollKrousel(\'right\' , \''.$idkrousselo.'\')">' .
				'<img src="'.$plugins_url.'/gothamazon/img/right_a.png" alt="Suivant"/>' .
				'</div>';
			}
			$output.="</div>";
		
		} elseif ($sidebardesign == 'listing'){
			
			$output.="</div>";
			
		}
		
		$output.= "<div style='clear:both;'></div>";

		if ($gtz_tokyo4 != "oui") {
			
			if ((($leshowmustgoon <= $nono) AND ($leshowmustgoon != "non")) OR ($leshowmustgoon == "oui")) {
				
				$showmutgoonurl = isset($data['SearchResult']['SearchURL']) ? $data['SearchResult']['SearchURL'] : NULL;
				$showmutgoonnumber = isset($data['SearchResult']['TotalResultCount']) ? $data['SearchResult']['TotalResultCount'] : NULL;
				
				if (!preg_match("(gothamazon)", $showmutgoonurl)) {	
				
					if (empty($amazontrackingcode2)) { // Si pas de MultiCompte => URL du Flux
						
						$showmutgoonurl = isset($data['SearchResult']['SearchURL']) ? $data['SearchResult']['SearchURL'] : NULL;
						
					} else { // Sinon ==> On construit l'url
						
						$showmutgoonurl = "https://$marketplace_w/s?k=$zipq&tag=$amazontrackingcode_tracker";
						
					}
					
					if ($cloaking == 'oui') {
						
						$showmutgoonurl_e = base64_encode($showmutgoonurl); 
						$complement = "datasin='$showmutgoonurl_e'";
						$kelbalise ="span";
						
					} else {
						
						$showmutgoonurl_e = $showmutgoonurl; 
						$complement = "href='$showmutgoonurl_e' rel='nofollow noopener' target='_blank'";
						$kelbalise="a";
						
					}
					
					 $output.="<p class='showmustgoon'><$kelbalise $complement class='gothmshbutton kamesen'>Voir + de $showmutgoonnumber autres articles</$kelbalise></p>";
				 
				}
				
			}
		
		}
		
		if (((BEERUS == "godmod") OR ($legalytext == "oui")) AND ($onstoptout != true)) {
			
			if ($gtz_tokyo4 == "oui") {
				
				if ($switch23bay == true) { 
					
					$gtz_url_targeted = "un site partenaire. Les prix sont donnés à titre indicatifs, et seul le prix affiché sur le site du commerçant est valable."; 
					
				} elseif ($gtz_filou_px == "internet") {

					$gtz_url_targeted = "le moteur de recherche de $gtz_filou_px. Les prix sont donnés à titre indicatifs, et seul le prix affiché sur le site du commerçant est valable."; 

				} else {
					
					$gtz_url_targeted = "le moteur de recherche de $gtz_filou_px. Les prix sont donnés à titre indicatifs, et seul le prix affiché sur le site du commerçant est valable."; 
					
				}
				
				if ($gtz_filou_px == "amazon") {
					
					$gtz_url_targeted .= " Notre site internet participe au programme Partenaire Αmazοn et réalise ainsi un bénéfice sur les achats qui remplissent les conditions requises.";
					
				}
				
				if ($gtz_filou_px == "ebay") {
					
					$gtz_url_targeted .= " Notre site internet a une collaboration commerciale avec ebay et réalise ainsi un bénéfice sur les achats qui remplissent les conditions requises sur eBay EPN.";
					
				}
					
			} else {
				
				if ($gtz_filou_px == "amazon") {
					
					$gtz_url_targeted = "sa fiche produit sur Αmazοn.fr. Notre site internet participe au programme Partenaire Αmazοn et réalise ainsi un bénéfice sur les achats qui remplissent les conditions requises."; 
					
				} elseif ($gtz_filou_px == "ebay") {
					
					$gtz_url_targeted = "sa fiche produit sur eBay. Notre site internet a une collaboration commerciale avec ebay et réalise ainsi un bénéfice sur les achats qui remplissent les conditions requises sur eBay EPN.";
				
				} else {
					
					if ((preg_match("(global)", $kel_api_utiliser)) OR (!empty($af2))) { // Si on trouve le mot global dans le flux ==> Flux multimarchand
						
						$gtz_url_targeted = "sa fiche produit sur notre site partenaire.";
						
						if ($af2 == "amazon") $gtz_url_targeted .= "Notre site internet participe au programme Partenaire Αmazοn et réalise ainsi un bénéfice sur les achats qui remplissent les conditions requises.";

					} else { // Sinon ==> Flux mono marchand
						
						if ($kel_api_utiliser == "fnacbook"){
							
							$kel_api_utiliser_maj = "FNAC";
							
						} else {
							
							$kel_api_utiliser_maj = strtoupper($kel_api_utiliser);
						
						}
						
						$gtz_url_targeted = "sa fiche produit sur $kel_api_utiliser_maj"; 
					
					}
					
				}
					
					
			}
		
			$output .="<p class='smartstorelegal'>ⓘ En cliquant sur l'un des articles ci-dessus, vous serez redirigé vers $gtz_url_targeted";
			
		}

		if ((file_exists($dynamixcache)) AND ((BEERUS == "godmod") OR ($legalytext == "oui")) AND ($boodisplayprice == 'oui') AND ($gtz_tokyo4 != "oui") AND ($onstoptout != true)) {
			
			$lastcache = date ("d/m/y à H:i:s.", filemtime($dynamixcache));
			$output.=" Relevés de prix actualisés toutes les $cachingtime_txt. Le dernier relevé date du $lastcache";
			
		}
		
		if (((BEERUS == "godmod") OR ($legalytext == "oui")) AND ($onstoptout != true)) {
			
			$output.= " Module propulsé par <b>GTZ</b></p>";
			
		}
		
		// Module Powered By //
		if ($gothamazon_option_powered_check == "oui") {
			
			$output.="<p class='smartstorelegal'>Ce module vous est proposé par <a href=https://gothamazon.com' target='_blank' rel='noopener'>Gothamazon</a></p>";
					 
		}
		// Fin du Module Powered By
	
	}

if ($kel_api_utiliser == "amazon") {
	
	global $gtz_called;
	$gtz_called++;
	
}


if (($nono > 3)  AND ($sidebardesign == 'slider') AND ($amp == false) ) { // Si + de 3 articles on active le carroussel
$output .= '<style>.ssjinstinct ul {display: flex!important;overflow-x: scroll;border-radius:0;scroll-snap-type: x mandatory;}.ssjinstinct ul li {	flex-grow: 1;flex-shrink: 0;flex-basis: 230px;}.ssjinstinct ul li.samba {width: 100%;margin:0 5px;background: transparent;	padding: 0;border-radius: 8px;}.ssjinstinct ul li.jonlok {width: 100%;padding: 0;margin: 0;}.ssjinstinct ul li .bim_blokprod {border-radius:0;}	.ssjinstinct ul::-webkit-scrollbar-track {background-color: #181818;}.ssjinstinct ul::-webkit-scrollbar {height: 26px;background-color: #181818;}.ssjinstinct ul::-webkit-scrollbar-thumb {background-color: #ff5a5f;border-top: 4px solid#181818; border-bottom: 4px solid #181818;} .v_amp .storeitemprice span{color:white;}</style>';
}

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
file_put_contents($bug_log_file_chem, "GTZ Boutique"); 



return $output;

}
add_shortcode( 'boutique', 'kapsulewheel_startboutique' );
// Fin de la Création du module de recherche par keyword 