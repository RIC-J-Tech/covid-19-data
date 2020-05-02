<?php

namespace RICJTech\Covid19Data\Test;

use RICJTech\Covid19Data\{Profile,Business,Report};
use Ramsey\Uuid\Uuid;
use RICJTech\Covid19Data\DataDesignTest;
use Faker;
require_once (dirname(__DIR__). "/Test/DataDesignTest.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


class ReportTest extends DataDesignTest {
	protected $VALID_CLOUDINARY_ID ="astrongIdcloud";
	protected $VALID_REPORT_DATE =null;
	protected $VALID_REPORT_CONTENT="some random report of nuisance";
	protected $VALID_DATE = null;

	/**
	 * @var \RICJTech\Covid19Data\Business
	 */
	protected $business;
	/**
	 * @var \RICJTech\Covid19Data\Profile
	 */
	protected $profile;


	public function setUp(): void {
		parent::setUp();
		$faker = Faker\Factory::create();
		$this->VALID_REPORT_DATE=$faker->dateTime;

		//insert a profile record in the db
		/** @var Uuid $profileId */
		$profileId = generateUuidV4()->toString();
		$password =$faker->password;
		$VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I,["time_cost"=>45]);
		$VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));

		$this->VALID_REPORT_DATE= new \DateTime();

		// create and insert a Profile to own the report content
		$this->profile = new Profile($profileId,$this->VALID_CLOUDINARY_ID, $VALID_AVATAR_URL =$faker->url,
			$VALID_ACTIVATION_TOKEN, $VALID_PROFILE_EMAIL =$faker->email,
			$VALID_PROFILE_HASH, $VALID_PROFILE_PHONE =$faker->phoneNumber, $VALID_PROFILE_USERNAME =$faker->userName);
		$this->profile->insert($this->getPDO());


		//create and insert a Business to own the Report content
		//insert a profile record in the db
		/** @var Uuid $businessId */
			$reportBusinessId = $faker->uuid;
		$this->business = new Business($reportBusinessId, "1234567898364527",$faker->longitude, $faker->latitude,
			"RICJTECH","https://ricjtech.com");
		$this->business->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_DATE = new \DateTime();


	}


public function testInsert(): void {
	$faker = Faker\Factory::create();

	//get count of profile records in db before we run the test
	$numRows = $this->getConnection()->getRowCount("profile");

	/** @var Uuid $reportId */
	$reportId = generateUuidV4();

	$report = new Report($reportId,$this->business->getBusinessId(),$this->profile->getProfileId(), $VALID_REPORT_CONTENT =$faker->text, $this->VALID_REPORT_DATE=$faker->dateTime);
	$report->insert($this->getPDO());

	//check count of Profile records in the database after the insert
	$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
	self::assertEquals($numRows + 1,$numRowsAfterInsert);

	//get a copy of the record just inserted and validate the values
	//make sure the values that went into the record are the same ones that come out
	$pdoReport = Report::getReportByReportId($this->getPDO(),$report->getReportId()->getBytes());

	$this->assertEquals($pdoReport->getReportProfileId(), $this->profile->getProfileId());

	$this->assertEquals($pdoReport->getReportBusinessId(), $this->business->getBusinessId());

	$this->assertEquals($pdoReport->getReportContent(), $this->VALID_REPORT_CONTENT);

	//format the date too seconds since the beginning of time to avoid round off error
	$this->assertEquals($pdoReport->getReportDate()->getTimestamp(), $this->VALID_DATE->getTimestamp());

//	self::assertEquals($this->	VALID_REPORT_DATE,$pdoReport->getReportDate());
//	self::assertEquals(,$pdoReport->getReportContent());




	}







}