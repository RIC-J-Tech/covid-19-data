<?php

require_once("configs.php");

//$businessId = null;
//$businessLng = 0;
//$businessLat = 0;
//$businessName = null;
//$businessUrl = null;
//$businessYelpId = null;
//
//$authorization = "Authorization: Bearer".$yelpToken;
//$ch = curl_init('https://api.yelp.com/v3/businesses/search?location=Albuquerque&limit=50');
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
//curl_setopt($ch, CURLOPT_HTTPGET, true);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$result = curl_exec($ch);
//curl_close($ch);
//var_dump(json_decode($result));


require_once(dirname(__DIR__, 1) . "/Classes/Business.php");
require_once("uuid.php");
//require_once("configs.php");

use RICJTech\Covid19Data\Business;

// The pdo object has been created for you.
require_once("/etc/apache2/capstone-mysql/Secrets.php");
$secrets = new Secrets("/etc/apache2/capstone-mysql/cohort28/ricjtech.ini");
$pdo = $secrets->getPdoObject();

//cURL - https://www.php.net/manual/en/function.curl-setopt.php
//$yelpToken is in a separate configs.php file that is not committed to github.
$authorization = "Authorization: Bearer " . $yelpToken;

for($offset = 0; $offset < 100; $offset = $offset + 20) {

	$ch = curl_init('https://api.yelp.com/v3/businesses/search?term=restaurants&location=NM&offset=' . $offset);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	$businesses = json_decode($result)->businesses;

	foreach($businesses as $business) {
		echo($business->id . "<br>");
		echo($business->name . "<br>");
		echo($business->url . "<br>");
		echo($business->coordinates->latitude . "<br>");
		echo($business->coordinates->longitude . "<br>");
		echo "<br>";
		$bus = new Business(generateUuidV4()->toString(), $business->name, $business->id, $business->coordinates->longitude, $business->coordinates->latitude, $business->url);
		$bus->insert($pdo);
	}
}
