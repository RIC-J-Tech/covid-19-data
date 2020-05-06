<?php

namespace RICJTech\Covid19Data\Test;

use RICJTech\Covid19Data\{Profile,Behavior, Business, Vote};
use Ramsey\Uuid\Uuid;
//use RICJTech\Covid19Data\DataTest;
use Faker;
//require_once(dirname(__DIR__) . "/Test/DataDesignTest.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

class VoteTest extends DataDesignTest {
	private $profile = null;
	private $behavior = null;
	private $business= null;
	private $VALID_ACTIVATION_TOKEN;
	private $VALID_CLOUDINARY_ID ="astrongIdcloud";
	private $VALID_AVATAR_URL;
	private $VALID_PROFILE_EMAIL;
	private $VALID_PROFILE_HASH;
	private $VALID_PROFILE_PHONE ;
	private $VALID_PROFILE_USERNAME;
	private $VALID_VOTE_RESULT;
	private $VALID_VOTE_DATE;


	public function setUp(): void {
		parent::setUp();
		$faker = Faker\Factory::create();

		$password =$faker->password;
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I,["time_cost"=>45]);
		$this->VALID_ACTIVATION_TOKEN= bin2hex(random_bytes(16));
		$this->VALID_PROFILE_EMAIL = $faker->email;
		$this->VALID_PROFILE_PHONE = $faker->phoneNumber;
//		$this->VALID_CLOUDINARY_ID = "astrongIdcloud";
		$this->VALID_AVATAR_URL = $faker->url;
		$this->VALID_PROFILE_USERNAME = $faker->userName;
		$this->VALID_VOTE_DATE = $faker->dateTime;
		$this->VALID_VOTE_RESULT=true;

		// create and insert a Profile to own the report content
		$this->profile = new Profile(generateUuidV4()->toString(), $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
			$this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL,
			$this->VALID_PROFILE_HASH, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_USERNAME);
		$this->profile->insert($this->getPDO());


		$this->business = new Business(generateUuidV4()->toString(), "myyelpid","123.456456", "128.789609", "RICJTECH","https://ricjtech.com");
		$this->business->insert($this->getPDO());

		$this->behavior = new Behavior(generateUuidV4()->toString(), $this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),"india", new \DateTime());
		$this->behavior->insert($this->getPDO());
	}
	public function testInsertValidVote(): void {
		//get count of profile records in db before we run the test
		$numRows = $this->getConnection()->getRowCount("vote");

		//insert a profile record in the db

		$vote = new Vote($this->behavior->getBehaviorId()->toString(), $this->profile->getProfileId()->toString(),$this->VALID_VOTE_RESULT,$this->VALID_VOTE_DATE);
		$vote->insert($this->getPDO());


		// grab the data from mySQL and enforce the fields match our expectations
		$results = Vote::getVotesByVoteProfileId ($this->getPDO(), $vote->getVoteProfileId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertCount(1, $results);

		// grab the result from the array and validate it
		$pdoVote = $results[0];

		$this->assertEquals($pdoVote->getVoteProfileId()->toString(), $this->profile->getProfileId()->toString());
		$this->assertEquals($pdoVote->getVoteResult(), $this->VALID_VOTE_RESULT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoVote->getVoteDate()->getTimestamp(), $this->VALID_VOTE_DATE->getTimestamp());
	}


	public function testUpdate():void{

	$faker = Faker\Factory::create();
	//get count of profile records in database before we run the test
	$numRows = $this->getConnection()->getRowCount("vote");

	/** @var Uuid $voteBehaviorId */
	$voteProfileId = generateUuidV4()->toString();
	$this->VALID_REPORT_RESULT=$faker->text;
	$this->VALID_REPORT_DATE = $faker->dateTime;
	$votes = new vote ($voteBehaviorId,$this->vote->getvoteBehaviorId()->toString(),$this->voteProfileId->getvoteProfileId()->toString(),
		$this->VALID_VOTE_RESULT, $this->VALID_VOTE_DATE);
	$votes->insert($this->getPDO());

	// edit the vote and update it in mySQL
	$votes->setVoteResult($this->VALID_REPORT_RESULT=$faker->text);
	$votes->update($this->getPDO());

	//get a copy of the record just inserted and validate the values
	//make sure the values that went into the record are the same ones that come out
	$pdoVotes = vote::getVotesByVoteProfileId($this->getPDO(),$votes->getVoteProfileId()()->getBytes());

	$this->assertEquals($pdoVotes->getVoteProfileId(), $this->profile->getVoteProfileId());

	$this->assertEquals($pdoVotes->getVoteBehaviorId(), $this->behavior->getVoteResult());

	$this->assertEquals($pdoVotes->getVoteResult(), $this->VALID_VOTE_RESULT);

	//format the date too seconds since the beginning of time to avoid round off error
	$this->assertEquals($pdoVotes->getVoteDate()->getTimestamp(), $this->VALID_REPORT_DATE->get());
	}

	public function testDeleteValidVote(): void{

$faker = Faker\Factory::create();

//count the number of rows and save it for later
$numRows = $this->getConnection()->getRowCount("report");
/** @var Uuid $voteProfilrId */
$reportId = generateUuidV4()->toString();
$this->VALID_REPORT_DATE=$faker->dateTime;
$this->VALID_REPORT_CONTENT = $faker->text;

$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);

$report->insert($this->getPDO());
// delete the Report from mySQL
$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("report"));

$report->delete($this->getPDO());

//grab the data from mySQL and enforce the Report does not exist
$pdoReport = Report::getReportByReportId($this->getPDO(),$report->getReportId()->getBytes());

$this->assertNull($pdoReport);

$this->assertEquals($numRows, $this->getConnection()->getRowCount("report"));
	}

public function testGetValidReportByBusinessId(): void{
$faker = Faker\Factory::create();

//get count of profile records in db before we run the test
$numRows = $this->getConnection()->getRowCount("report");

//	/** @var Uuid $reportId */
$reportId = generateUuidV4()->toString();
$this->VALID_REPORT_DATE=$faker->dateTime;
$this->VALID_REPORT_CONTENT = $faker->text;

$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);
$report->insert($this->getPDO());
/$report->getReportBusinessId($this->getPDO(),$this->business->getBusinessId()->getBytes());
//	//check count of profile record in the db after the insert
$numRowsAfter = $this->getConnection()->getRowCount("report");
self::assertEquals($numRows + 1, $numRowsAfter,"checked record count");
public function testGetValidReportByReportId():void{
$faker = Faker\Factory::create();
//get count of profile records in db before we run the test
$numRows = $this->getConnection()->getRowCount("report");

/** @var Uuid $reportId */
$reportId = generateUuidV4()->toString();

$this->VALID_REPORT_DATE=$faker->dateTime;

$this->VALID_REPORT_CONTENT = $faker->text;

	$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
		$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);
$report->insert($this->getPDO());

$report->getReportId($this->getPDO(),$report->getReportId());
//check count of profile record in the db after the insert
	$numRowsAfter = $this->getConnection()->getRowCount("report");
self::assertEquals($numRows + 1, $numRowsAfter,"checked record count");
$this->assertEquals($report->getReportDate()->getTimestamp(), $this->VALID_REPORT_DATE->getTimestamp());
$this->assertEquals($report->getReportContent(), $this->VALID_REPORT_CONTENT);
$this->assertEquals($report->getReportBusinessId(),$this->business->getBusinessId());
$this->assertEquals($report->getReportProfileId(),$this->profile->getProfileId());
}
	}

	}

