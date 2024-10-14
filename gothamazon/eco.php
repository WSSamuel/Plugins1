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

if (($sortbay == '') OR ($sortbay == 'Default')) { // Tri par defaut si vide

	$tripardefaut = 'oui';
	
} 

$kapsule_dirstokage = GOTHAMZ_ROOTPATH . '/storefeed/';
$ioyasin = filter_var($ioyasin, FILTER_SANITIZE_URL);
$ioyasin = str_replace(' ', '_', $ioyasin);
$ioyasin = strtolower($ioyasin);
$dynamixcache = "$kapsule_dirstokage$domainname-inline_$ioyasin-$categoryprecise-$prixmin-non-$sortbay$vendeur$marque4slug$kel_api_utiliser-ex$exclusion-inc$inclusion_s-nkw$nkw_s.json"; // On créé le chemin du fichier de cache

$accessKey = kaps_decrypt("$secret_amalog");
$secretKey = kaps_decrypt("$secret_amapass");

$serviceName = "ProductAdvertisingAPI";
$region = $marketplace_region;
$payload="{";
$payload.=" \"Keywords\": \"$zipq\",";
$payload.=" \"ItemCount\": 1,";
$payload.=" \"Availability\": \"Available\",";
if ($prixmin != '1') {
	$payload.=" \"MinPrice\": $prixmin,";
}
if ($marque != 'None') {
	$payload.=" \"Brand\": \"$marque\",";
}
$payload.=" \"PartnerTag\": \"$amazontrackingcode\",";
$payload.=" \"PartnerType\": \"Associates\",";
$payload.=" \"SearchIndex\": \"$categoryprecise\",";
if ($tripardefaut != 'oui') {
	$payload.=" \"SortBy\": \"$sortbay\",";
}
if ($vendeur != 'All') {
	$payload.=" \"Merchant\": \"Amazon\",";
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

if ($fp == false) {header ("Location: $parachute");}

$response = @stream_get_contents ( $fp );

// Detection du flux vide //
$padreponskaps = json_decode($response, true);
$items = isset($padreponskaps['SearchResult']['Items']) ? $padreponskaps['SearchResult']['Items'] : NULL;

if (!is_null($items)) {  // Si le flux marche et nous renvoie donc un item
	
	file_put_contents($dynamixcache , $response); // On crée le cache
	
}
//////////////


// On Parse

$data = json_decode($response, true);

//var_dump($items);

if (!is_null($items)) {
	
	foreach ($items as $item){
			
		$ref = isset($item['ASIN']) ? $item['ASIN'] : NULL;
		$link = "https://$marketplace_w/dp/$ref?tag=$amazontrackingcode_tracker"."&linkCode=osi&th=1&psc=1";
		
	}
	
} else {
	
	$link = NULL;
	
}

if (is_null($link)){
	
	$redirectionok = $parachute; // Si la recherche ne donne rien on envoie vers le parachute
	
} else {
	
	$redirectionok = $link;
	
}

header ("Location: $redirectionok");