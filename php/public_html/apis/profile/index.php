<?php


require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

use RICJTech\Covid19Data\Profile;

/**
 * API for Profile
 *
 * @author Opeyemi Jonah
 * @version 1.0
 */

//verify the session, if it is not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection

	$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort28/ricjtech.ini");
	$pdo = $secrets->getPdoObject();


	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileUsername = filter_input(INPUT_GET, "profileUsername", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//Applying Cloudinary configurations to upload am image for the Profile pic
	Configuration::instance([
		'cloud' => [
		  'cloud_name' => 'dbmcm6ruq', 
		  'api_key' => '411919186298744', 
		  'api_secret' => '5ooWzF-yboEevIYnh0CpLVZVp6s'],
		'url' => [
		  'secure' => true]]);
	
	(new UploadApi())->upload('./images/tola.jpg');

	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets a post by content
		if(empty($id) === false) {
			$reply->data = Profile::getProfileByProfileId($pdo, $id);

		} else if(empty($profileUsername) === false) {
			$reply->data = Profile::getProfileByUsername($pdo, $profileUsername);

		} else if(empty($profileEmail) === false) {

			$reply->data = Profile::getProfileByEmail($pdo, $profileEmail);
		}
		else {
			$reply->data = Profile::getAllProfiles($pdo)->toArray();
		}

	} elseif($method === "PUT") {

		//enforce that the XSRF token is present in the header
		verifyXsrf();

		//enforce the end user has a JWT token
		//validateJwtHeader();

		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		validateJwtHeader();

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}


		//profile username
		if(empty($requestObject->profileUsername) === true) {
			throw(new \InvalidArgumentException ("No profile at handle", 405));
		}

		//profile email is a required field
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException ("No profile email present", 405));
		}

		//profile phone # | if null use the profile phone that is in the database
		if(empty($requestObject->profilePhone) === true) {
			$requestObject->ProfilePhone = $profile->getProfilePhone();
		}

		$profile->setProfileUsername($requestObject->profileUsername);
		$profile->setProfileEmail($requestObject->profileEmail);
		$profile->setProfilePhone($requestObject->profilePhone);
		$profile->update($pdo);

		// update reply
		$reply->message = "Profile information updated";


	} elseif($method === "DELETE") {

		//verify the XSRF Token
		verifyXsrf();

		//enforce the end user has a JWT token
		//validateJwtHeader();

		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw (new RuntimeException("Profile does not exist"));
		}

		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $profile->getProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		validateJwtHeader();

		//delete the post from the database
		$profile->delete($pdo);
		$reply->message = "Profile Deleted";

	} else {
		throw (new InvalidArgumentException("Invalid HTTP request", 400));
	}
	// catch any exceptions that were thrown and update the status and message state variable fields
} catch
(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);
