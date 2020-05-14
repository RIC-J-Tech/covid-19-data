<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/cohort28/ricjtech.ini");

use RICJTech\Covid19Data\{ Business, Profile, Behavior};


/**
 * api for the Behavior class
 *
 * @author Cathy Tasama <lauremanyi@gmail.com>
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
	$behaviorBusinessId = filter_input(INPUT_GET, "behaviorBus", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	var_dump($behaviorBusinessId);
	$behaviorProfileId = filter_input(INPUT_GET, "behaviorProf", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
//	var_dump($behaviorProfileId);
	$behaviorContent = filter_input(INPUT_GET, "behaviorContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}


	// handle GET request - if id is present, that behavior post is returned, otherwise all behaviors are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific behavior or all behaviors and update reply
		if(empty($id) === false) {
			$reply->data = Behavior::getBehaviorByBehaviorId($pdo, $id);
		} else if(empty($behaviorBusinessId) === false) {
			// if the user is logged in grab all the behaviors by that user based  on who is logged in
			$reply->data = Behavior::getBehaviorByBehaviorBusinessId($pdo, $behaviorBusinessId)->toArray();

		} else if(empty($behaviorProfileId) === false) {
			// if the user is logged in grab all the behaviors by that user based  on who is logged in
			$reply->data = Behavior::getBehaviorByBehaviorProfileId($pdo, $behaviorProfileId)->toArray();

		} else if(empty($behaviorContent) === false) {
			$reply->data = Behavior::getBehaviorByBehaviorContent($pdo, $behaviorContent)->toArray();

		} else {
			$behaviors = Behavior::getAllBehaviors($pdo)->toArray();
			$behaviorBusinesses = [];
			$behaviorProfiles = [];
			foreach($behaviors as $behavior){
				$business = Business::getBusinessByBusinessId($pdo, $behavior->getBehaviorBusinessId());
				$behaviorBusinesses[] = (object)[
					"behaviorId"=>$behavior->getBehaviorId(),
					"behaviorBusinessId"=>$behavior->getBehaviorBusinessId(),
					"behaviorProfileId"=>$behavior->getBehaviorProfileId(),
					"behaviorContent"=>$behavior->getBehaviorContent(),
					"behaviorDate"=>$behavior->getBehaviorDate()->format("U.u") * 1000,
					"businessUrl"=>$business->getBusinessUrl(),
					"businessName"=>$business->getBusinessName(),
				];
				$profile = 	Profile::getProfileByProfileId($pdo, $behavior->getBehaviorProfileId());
				$behaviorProfiles[] = (object)[
					"behaviorId"=>$behavior->getBehaviorId(),
					"behaviorBusinessId"=>$behavior->getBehaviorBusinessId(),
					"behaviorProfileId"=>$behavior->getBehaviorProfileId(),
					"behaviorContent"=>$behavior->getBehaviorContent(),
					"behaviorDate"=>$behavior->getBehaviorDate()->format("U.u") * 1000,
					"profileAvatarUrl"=>$profile->getProfileAvatarUrl(),
					"profileUsername"=>$profile->getProfileUsername(),
				];
			}
			$reply->data = $behaviorBusinesses;
			$reply->data = $behaviorProfiles;
		}
	} else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();

		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post behaviors", 401));
		}

		$requestContent = file_get_contents("php://input");


		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);

		// This Line Then decodes the JSON package and stores that result in $requestObject
		//make sure behavior content is available (required field)
		if(empty($requestObject->behaviorContent) === true) {
			throw(new \InvalidArgumentException ("No content for Behavior.", 405));
		}
		$requestObject->behaviorContent; //value:bar
		// make sure behavior date is accurate (optional field)
		if(empty($requestObject->behaviorDate) === true) {
			$requestObject->behaviorDate = null;
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the behavior to update
			$behavior = Behavior::getBehaviorByBehaviorId($pdo, $id);
			if($behavior === null) {
				throw(new RuntimeException("Behavior does not exist", 404));
			}

			//enforce the end user has a JWT token


			//enforce the user is signed in and only trying to edit their own behavior post
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $behavior->getBehaviorProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this behavior", 403));
			}

			validateJwtHeader();

			// update all attributes
			//$behavior->setBehaviorDate($requestObject->behaviorDate);
			$behavior->setBehaviorContent($requestObject->behaviorContent);
			$behavior->update($pdo);

			// update reply
			$reply->message = "Behavior updated OK";

		} else if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post behaviors", 403));
			}

			//enforce the end user has a JWT token
			validateJwtHeader();
//var_dump(generateUuidV4()->toString());
			// create new behavior and insert into the database
			$behavior = new Behavior(generateUuidV4()->toString(),  "AC539910-1294-49DC-ACA4-13041ECD9F6C",
				$_SESSION["profile"]->getProfileId(), $requestObject->behaviorContent, new DateTime());
			$behavior->insert($pdo);

			// update reply
			$reply->message = "Behavior created OK";
		}

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Behavior to be deleted
		$behavior = Behavior::getBehaviorBybBehaviorId($pdo, $id);
		if($behavior === null) {
			throw(new RuntimeException("Behavior does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own behavior post
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $behavior->getBehaviorProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this behavior", 403));
		}

		//enforce the end user has a JWT token
		validateJwtHeader();

		// delete behavior
		$behavior->delete($pdo);
		// update reply
		$reply->message = "Behavior deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request", 418));
	}
// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);