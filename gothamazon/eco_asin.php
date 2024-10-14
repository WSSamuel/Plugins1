<?php 
define('GOTHAMZ_ROOTPATH', __DIR__); // Chemin Serveur
require_once(GOTHAMZ_ROOTPATH.'/gothaws.php'); 
require_once(GOTHAMZ_ROOTPATH.'/inc/decode.php'); 

if ($marketplace == '') { // Francais par défaut COCORICO

	$marketplace = 'fr_FR';
	
} 

if ($marketplace == 'fr_FR') {
	
	$marketplace_id = 'fr_FR';
	$marketplace_w = 'amazon.fr'; 
	$marketplace_region = 'eu-west-1';
	
} else {
	
	$marketplace_id = 'en_US'; 
	$marketplace_w = 'amazon.com'; 
	$marketplace_region = 'us-east-1';
	
}

$kapsule_dirstokage = GOTHAMZ_ROOTPATH . '/storefeed/';

$ioyasin = filter_var($ioyasin, FILTER_SANITIZE_URL);
$ioyasin = str_replace(' ', '_', $ioyasin);
$ioyasin = strtolower($ioyasin);

$accessKey = kaps_decrypt("$secret_amalog");
$secretKey = kaps_decrypt("$secret_amapass");

$dynamixcache = "$kapsule_dirstokage$domainname-inlineASIN-$gothamasin_asin.json"; // On créé le chemin du fichier de cache asin
$dynamixcache2 = "$kapsule_dirstokage$domainname-inline_$ioyasin-$categoryprecise-$prixmin-oui.json"; // On créé le chemin du fichier de cache parachute
	
if (file_exists($dynamixcache) && (( time() - $cachingtime > filemtime($dynamixcache)) OR ( 0 == filesize($dynamixcache) ))) {  // Si le fichier existe et (qu'il a dépassé la durée de vie du cache OU qu'il est vide) 
	
	unlink ($dynamixcache); // On l'efface
	
}

if (file_exists($dynamixcache)) { // Si le fichier de cache existe deja

		$link = "https://www.amazon.fr/dp/$gothamasin_asin?tag=$amazontrackingcode_tracker";

} else { 

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
	
	if ($fp == false) {header ("Location: $parachute");}

	$response = @stream_get_contents ( $fp );

	// Detection du flux vide //
	$padreponskaps = json_decode($response, true);
	$items = isset($padreponskaps['ItemsResult']['Items'][0]['Offers']['Listings'][0]['Price']['Amount']) ? $padreponskaps['ItemsResult']['Items'][0]['Offers']['Listings'][0]['Price']['Amount'] : NULL;
	
	if (!is_null($items)) { // Si le flux marche et nous renvoie donc un item
	
		file_put_contents($dynamixcache , $response); // On crée le cache
		$link = "https://www.amazon.fr/dp/$gothamasin_asin?tag=$amazontrackingcode_tracker"; // Le lien est tout simple et validé
		
	} else {  // Sinon on cherche par KW

		if (file_exists($dynamixcache2) && (( time() - $cachingtime > filemtime($dynamixcache2)) OR ( 0 == filesize($dynamixcache2) ))) {  // Si le fichier existe et (qu'il a dépassé la durée de vie du cache OU qu'il est vide) 
			
				unlink ($dynamixcache2); // On l'efface
				
		}

		if (file_exists($dynamixcache2)) { // Si le fichier de cache existe deja
		
				$response = @file_get_contents($dynamixcache2); // On charge le fichier de cache
				
		} else {
			
			$serviceName="ProductAdvertisingAPI";
			$region=$marketplace_region;
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
		$compteur = 0;
		$nbArt2Parse = 1;
		
		foreach ($items as $item){
			
			if($compteur == $nbArt2Parse) break;
			$link = isset($item['DetailPageURL']) ? $item['DetailPageURL'] : NULL;
			$compteur++;
			
		}
		
	}

}

if (is_null($link)){
	
	$redirectionok = $parachute; // Si la recherche ne donne rien on envoie vers le parachute
	
} else {
	
	$redirectionok = $link;
	
}

header ("Location: $redirectionok");