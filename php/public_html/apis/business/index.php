<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use RICJTech\Covid19Data\{
	Profile, Business, Image, Behavior
};


/**
 * api for the business class
 *
 * @author Russell Dorgan <clambakedbenz@gmail.com>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort28/ricjtech.ini");
	$pdo = $secrets->getPdoObject();



	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input

	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$businessName = filter_input(INPUT_GET, "businessName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$resultCount = filter_input(INPUT_GET, "resultCount", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	// handle GET request - if id is present, that business is returned, otherwise all business are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific business or all business'
		if(empty($id) === false) {
			$reply->data = business::getbusinessBybusinessId($pdo, $id);

			//getBusinessByBusinessName
		} else if(empty($businessName) === false) {
			$reply->data = business::getBusinessByBusinessName($pdo, $businessName)->toArray();
		}


		else {
			$reply->data = Business::getTopBusinesses($pdo,$resultCount)->toArray();
		}

	}


// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);