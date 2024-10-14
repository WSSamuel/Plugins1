<?php 

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

$doubleface = false;
$home_url = get_home_url();
$home_url = str_replace("https://", "", $home_url);
$home_url = str_replace("http://", "", $home_url);
$home_url = str_replace("www.", "", $home_url);

$unik = base64_encode($home_url);
$unik = preg_replace("/[^a-zA-Z0-9]/", "", $unik);

if ( is_multisite() ) {
	
	$iddusite = get_current_blog_id();
	$lkey = "$unik-SKK58-$iddusite";
	
} else {
	
	$lkey = "HJS5-$unik";
	
}

$kapsule_cookie_token = GOTHAMZ_ROOTPATH . "temp/token-$lkey.json";
$newjeton = false;

// L'URL est-elle bien déclarée
$url = get_site_url(); 

function check_site_current_url ($url) {
	
	$url = str_replace("https://", "", $url);
	$url = str_replace("http://", "", $url);
	$url = str_replace("www.", "", $url);
	
	if (substr($url, -1) == '/') {
		
		$url = substr($url,0,strlen($url)-1);
	
	}
	
	return $url;
	
}
$choppezla = check_site_current_url($url);	

// On vire le cache token quand on update la clé API
function check_licence_update(){
	
		global $kapsule_cookie_token;
		
		if (file_exists($kapsule_cookie_token)) { // S'il existe
		
			unlink ($kapsule_cookie_token);
			
		}
		
		check_kapsuleapi_licence();
}


function connect_2_gtz_server ($call) {

	global $kapsule_cookie_token;
	global $choppezla;
	
	$urlcheckapi = base64_decode($call);
	$jokerjeton = get_option('gothamazon_ama_kapsule_apijeton');
	
	$api_endpoint = "$urlcheckapi$jokerjeton&url=$choppezla";
	
	$time_args = array(
		'timeout'     => 2
	); 
	
	$kapsdata = wp_remote_get($api_endpoint,$time_args);
	
	if ( is_array( $kapsdata ) && ! is_wp_error( $kapsdata ) ) { // Empeche une erreur fatale en cas d'impossibilité de récupérer le flux
	
		$kapsdata_array = json_decode($kapsdata["body"], true);
		
		if (is_null($kapsdata_array)) { // On n'arrive pas à chopper le JSON de licence
		
			$statut = "cUrl"; // Vraiment impossible de se connecter au serveur Gothamazon / Bug CUrl RemoteAPI		
		
		}
		
		elseif (is_wp_error($kapsdata) || !isset($kapsdata["body"]) || $kapsdata["response"]["code"] != 200 || $kapsdata_array['token'] != 'KISh8sUJD5848gkfoSKKSuS' || $kapsdata_array['acces'] != 'true'){
			
			$statut = "Erreur";
			
		} else {
			
			if ($kapsdata_array['limit'] == 'premium') {
				
				$statut="premium";
				
			} elseif ($kapsdata_array['limit'] == 'godmod') {
				
				$statut="godmod";
				
			} else {
				
				$statut="free";
				
			}
			
			$kakabody = $kapsdata["body"];
			
			if ((!empty($kapsule_cookie_token)) AND (!empty($kakabody))) {
				
				file_put_contents($kapsule_cookie_token , $kakabody); // On crée le cache
				
			}
			
		} 
		
		
	} else {
	
		$statut = "Erreur";
			
	}
		
	return $statut;

}


// On check si API valide
function check_kapsuleapi_licence() {

	global $doubleface;
	global $kapsule_cookie_token;
	global $newjeton;

	 // Si le fichier existe et (qu'il a + de 6H OU qu'il est vide) 
	if (file_exists($kapsule_cookie_token) && ((0 == filesize($kapsule_cookie_token)) OR ($newjeton == true))) { 
	
		unlink ($kapsule_cookie_token); // On l'efface
		
	}

	if (file_exists($kapsule_cookie_token)) { // Si le fichier de cache existe deja
	
		$kapsdata = @file_get_contents($kapsule_cookie_token); // On charge le fichier de cache
		
		$kapsdata_array = json_decode($kapsdata, true);
		
		if ($kapsdata_array['token'] == 'KISh8sUJD5848gkfoSKKSuS' AND $kapsdata_array['acces'] == 'true') {
			
			if ($kapsdata_array['limit'] == 'premium') {
				
				$statut="premium";
				
			} elseif ($kapsdata_array['limit'] == 'godmod') {
				
				$statut="godmod";
				
			} else {
				
				$statut="free";
				
			}
			
			if ($statut != "godmod") { // Si ce n'est pas le godmod on efface le cookie passé 6H
				
				if ( time() - 21600 > filemtime($kapsule_cookie_token))	{
					
					unlink ($kapsule_cookie_token); // On l'efface
					
				}
				
			}
				
		} else {
				
			$statut = "Erreur";
				
		}
	
		return $statut;
			
	} else {
		
		$urlcheckapi = "aHR0cHM6Ly9nb3RoYW1hem9uLmNvbS9saWNlbmNlLnBocD90b2tlbj0";
		$urlcheckapi_alt = "aHR0cHM6Ly9nb3JpbGxlLm5ldC9ndHpfYXBpMi5waHA/dG9rZW49";
		
		$statut = connect_2_gtz_server($urlcheckapi);
		
		if (($statut == "cUrl") OR (($statut == "Erreur"))) {
			
			$try_2 = connect_2_gtz_server($urlcheckapi_alt);
			
			if ($try_2 == "cUrl") {

				$statut = "cUrl";
				
			} else {
				
				$statut = $try_2;
				
			}	
			
		} 
		
		return $statut; 	
		
	}
	
}