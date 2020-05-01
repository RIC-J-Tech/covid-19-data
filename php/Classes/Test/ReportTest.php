<?php
namespace RICJTech\Covid19Data;

use RICJTech\Covid19Data\{Business,Profile};

use Ramsey\Uuid\Uuid;

use RICJTech\Covid19Data\DataDesignTest;
use Faker;

require_once (dirname(__DIR__). "/Test/DataDesignTest.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

class ReportTest extends DataDesignTest {
	private $VALID_ACTIVATION_TOKEN;
	private $VALID_CLOUDINARY_ID ="astrongIdcloud";
	private $VALID_AVATAR_URL;
	private $VALID_PROFILE_EMAIL;
	private $VALID_PROFILE_HASH;
	private $VALID_PROFILE_PHONE ;
	private $VALID_PROFILE_USERNAME;
	private $VALID_REPORT_DATE;

	public function setUp(): void {
		parent::setUp();
		$faker = Faker\Factory::create();
		$this->VALID_REPORT_DATE=$faker->dateTime;

		// create and insert a Profile to own the report content
		$this->report = new Profile(generateUuidV4(),$this->VALID_CLOUDINARY_ID,$this->VALID_AVATAR_URL,
		$this->VALID_ACTIVATION_TOKEN,$this->VALID_PROFILE_EMAIL,
			$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE,$this->VALID_PROFILE_USERNAME);
		$this->profile->insert($this->getPDO());

	}



public function testInsert(): void {
	$faker = Faker\Factory::create();

	//get count of profile records in db before we run the test
	$numRows = $this->getConnection()->getRowCount("profile");


	$reportId = generateUuidV4()->toString();
	$reportBusinessId = generateUuidV4()->toString();
	$reportProfileId = generateUuidV4()->toString();

	$report = new Report($reportId,$reportBusinessId,$reportProfileId, $VALID_REPORT_CONTENT =$faker->text,
		$this->VALID_REPORT_DATE=$faker->dateTime);
	$report->insert($this->getPDO());

	//check count of Profile records in the database after the insert
	$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
	self::assertEquals($numRows + 1,$numRowsAfterInsert);

	//get a copy of the record just inserted and validate the values
	//make sure the values that went into the record are the same ones that come out
	$pdoProfile = Report::getReportByProfileId($this->getPDO(),$report->getProfileId()->getBytes());
	self::assertEquals($VALID_REPORT_CONTENT,$pdoProfile->getProfileCloudinaryId());
	self::assertEquals($this->	VALID_REPORT_DATE,$pdoProfile->getProfileAvatarUrl());
}




}