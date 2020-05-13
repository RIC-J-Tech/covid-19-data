<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";

use RICJTech\Covid19Data\{
	Profile, Business, Image, Behavior
};

/**
 * Cloudinary API for Images
 *
 * @author Marty Bonacci
 * @version 1.0
 */

// start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;

try {

	// Grab the MySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/ddctwitter.ini");
	$pdo = $secrets->getPdoObject();
	$cloudinary = $secrets->getSecret("cloudinary");

	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	$behaviorId = filter_input(INPUT_GET, "imageBehaviorId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$businessId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);


	// process GET requests
	if($method === "GET") {
		// set XSRF token
		setXsrfCookie();
		$reply->data = Image::getAllImages($pdo)->toArray();
	}  elseif($method === "POST") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		//use $_POST super global to grab the needed Id
		$behaviorId = filter_input(INPUT_POST, "behaviorId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// assigning variable to the user profile, add image extension
		$tempUserFileName = $_FILES["image"]["tmp_name"];

		// upload image to cloudinary and get public id
		$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 200, "crop" => "scale"));

		// after sending the image to Cloudinary, create a new image
		$image = new Image(generateUuidV4(), $behaviorId, $cloudinaryResult["signature"], $cloudinaryResult["secure_url"]);
		$image->insert($pdo);
		// update reply
		$reply->message = "Image uploaded Ok";
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-Type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);