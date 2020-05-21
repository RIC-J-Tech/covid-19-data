<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";


use RICJTech\Covid19Data\{ Business, Profile, Report};


/**
 * api for the Report class
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
	$reportBusinessId = filter_input(INPUT_GET, "reportBusinessId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$reportProfileId = filter_input(INPUT_GET, "reportProfileId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
//	var_dump($reportProfileId);
	$reportContent = filter_input(INPUT_GET, "reportContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}


	// handle GET request - if id is present, that report post is returned, otherwise all reports are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific report or all reports and update reply
		if(empty($id) === false) {
			$reply->data = Report::getReportByReportId($pdo, $id);
		} else if(empty($reportBusinessId) === false) {
			// if the user is logged in grab all the reports by that user based  on who is logged in
			$reply->data = Report::getReportByReportBusinessId($pdo, $reportBusinessId)->toArray();

		} else if(empty($reportProfileId) === false) {
			// if the user is logged in grab all the reports by that user based  on who is logged in
			$reply->data = Report::getReportByReportProfileId($pdo, $reportProfileId)->toArray();

		} else if(empty($reportContent) === false) {
			$reply->data = Report::getReportByReportContent($pdo, $reportContent)->toArray();

		} else {
			$reports = Report::getAllReports($pdo)->toArray();
			$reportProfiles = [];
			foreach($reports as $report){
				$business = Business::getBusinessByBusinessId($pdo, $report->getReportBusinessId());
				$reportBusinesses[] = (object)[
					"reportId"=>$report->getReportId(),
					"reportBusinessId"=>$report->getReportBusinessId(),
					"reportProfileId"=>$report->getReportProfileId(),
					"reportContent"=>$report->getReportContent(),
					"reportDate"=>$report->getReportDate()->format("U.u") * 1000,
					"businessUrl"=>$business->getBusinessUrl(),
					"businessName"=>$business->getBusinessName(),
				];

				$profile = 	Profile::getProfileByProfileId($pdo, $report->getReportProfileId());
				$reportProfiles[] = (object)[
					"reportId"=>$report->getReportId(),
					"reportBusinessId"=>$report->getReportBusinessId(),
					"reportProfileId"=>$report->getReportProfileId(),
					"reportContent"=>$report->getReportContent(),
					"ReportDate"=>$report->getReportDate()->format("U.u") * 1000,
					"profileAvatarUrl"=>$profile->getProfileAvatarUrl(),
					"profileUsername"=>$profile->getProfileUsername(),
				];
			}
			$reply->data = $reportBusinesses;
			$reply->data = $reportProfiles;
		}
	} else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();

		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post reports", 401));
		}

		$requestContent = file_get_contents("php://input");


		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);

		// This Line Then decodes the JSON package and stores that result in $requestObject
		//make sure report content is available (required field)
		if(empty($requestObject->reportContent) === true) {
			throw(new \InvalidArgumentException ("No content for Report.", 405));
		}
		$requestObject->reportContent; //value:bar
		// make sure report date is accurate (optional field)
		if(empty($requestObject->reportDate) === true) {
			$requestObject->reportDate = null;
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the report to update
			$report = Report::getReportByReportId($pdo, $id);
			if($report === null) {
				throw(new RuntimeException("Report does not exist", 404));
			}

			//enforce the end user has a JWT token


			//enforce the user is signed in and only trying to edit their own report post
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $report->getReportProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this report", 403));
			}

			validateJwtHeader();

			// update all attributes
			//$report->setReportDate($requestObject->reportDate);
			$report->setReportContent($requestObject->reportContent);
			$report->update($pdo);

			// update reply
			$reply->message = "Report updated OK";

		} else if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post reports", 403));
			}

			//enforce the end user has a JWT token
			validateJwtHeader();

			// create new report and insert into the database
			$report = new Report(generateUuidV4()->toString(),  $requestObject->reportBusinessId,
				$_SESSION["profile"]->getProfileId()->toString(), $requestObject->reportContent, new DateTime());
			$report->insert($pdo);

			// update reply
			$reply->message = "Report created OK";
		}

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Report to be deleted
		$report = Report::getReportByReportId($pdo, $id);
		if($report === null) {
			throw(new RuntimeException("Report does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own report post
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $report->getReportProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this report", 403));
		}

		//enforce the end user has a JWT token
		validateJwtHeader();

		// delete report
		$report->delete($pdo);
		// update reply
		$reply->message = "Report deleted OK";
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