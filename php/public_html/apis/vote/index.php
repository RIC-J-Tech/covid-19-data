<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once ("/etc/apache2/capstone-mysql/cohort28/ricjtech.ini");

use RICJTech\Covid19Data\{Behavior, Profile, Vote};

/**
 * Api for the vote class
 *
 * @author india byrne
 */

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


	//sanitize the search parameters
	$voteProfileId = $id = filter_input(INPUT_GET, "voteProfileId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$voteBehaviorId = $id = filter_input(INPUT_GET, "voteBehaviorId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);


	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets  a specific vote associated based on its composite key
		if ($voteProfileId !== null && $voteBehaviorId !== null) {
			$vote = Vote::getVoteByVoteBehaviorIdAndVoteProfileId($pdo, $voteProfileId, $voteProfileId);


			if($vote!== null) {
				$reply->data = $vote;
			}
			//if none of the search parameters are met throw an exception
		} else if(empty($voteProfileId) === false) {
			$reply->data = Vote::getVoteByVoteProfileId($pdo, $voteProfileId)->toArray();
			//get all the votes associated with the behaviorId
		} else if(empty($voteBehaviorId) === false) {
			$reply->data = Vote::getVoteByVoteBehaviorId($pdo, $voteBehaviorId)->toArray();
		} else {
			throw new InvalidArgumentException("incorrect search parameters ", 404);
		}

	} else if($method === "POST" || $method === "PUT") {

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		if(empty($requestObject->voteProfileId) === true) {
			throw (new \InvalidArgumentException("No Profile linked to the Vote", 405));
		}

		if(empty($requestObject->voteBehaviorId) === true) {
			throw (new \InvalidArgumentException("No behavior linked to the Vote", 405));
		}

		if(empty($requestObject->voteDate) === true) {
			$requestObject->VoteDate =  date("y-m-d H:i:s");
		}


		if($method === "POST") {

			//enforce that the end user has a XSRF token.
			verifyXsrf();

			//enforce the end user has a JWT token
			//validateJwtHeader();

			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in too vote posts", 403));
			}

			validateJwtHeader();

			$vote = new Vote($_SESSION["profile"]->getProfileId(), $requestObject->voteBehaviorId);
			$vote->insert($pdo);
			$reply->message = "voted behavior successful";


		} else if($method === "PUT") {

			//enforce the end user has a XSRF token.
			verifyXsrf();

			//enforce the end user has a JWT token
			validateJwtHeader();

			//grab the vote by its composite key
			$vote = Vote::getVoteByVoteBehaviorIdAndVoteProfileId($pdo, $requestObject->voteProfileId, $requestObject->voteBehaviorId);
			if($vote === null) {
				throw (new RuntimeException("Vote does not exist"));
			}

			//enforce the user is signed in and only trying to edit their own vote
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $vote->getVoteProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to delete this behavior", 403));
			}

			//validateJwtHeader();

			//preform the actual delete
			$vote->delete($pdo);

			//update the message
			$reply->message = "Vote successfully deleted";
		}

		// if any other HTTP request is sent throw an exception
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}
	//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);