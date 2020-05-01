<?php
namespace RICJTech\Covid19Data;

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
	private $VALID_CLOUDINARY_ID ="astrongIdcloud";
	private $VALID_REPORT_DATE =null;
	private $VALID_REPORT_ID;

	/**
	 * @var \RICJTech\Covid19Data\Business
	 */
	private $business;
	/**
	 * @var \RICJTech\Covid19Data\Profile
	 */
	private $profile;


	public function setUp(): void {
		parent::setUp();
		$faker = Faker\Factory::create();
		$this->VALID_REPORT_DATE=$faker->dateTime;
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
		$this->business = new Business(generateUuidV4()->toString(), $faker->url,$faker->longitude, $faker->latitude,
			"RICJTECH","https://ricjtech.com");
		$this->business->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_DATE = new \DateTime();


	}






public function testInsert(): void {
	$faker = Faker\Factory::create();

	//get count of profile records in db before we run the test
	$numRows = $this->getConnection()->getRowCount("profile");


	$reportId = generateUuidV4()->toString();
	$reportBusinessId = generateUuidV4()->toString();
	$reportProfileId = generateUuidV4()->toString();

	$report = new Report($reportId,$this->business->getBusinessId(),$this->profile->getProfileId(), $VALID_REPORT_CONTENT =$faker->text,
		$this->VALID_REPORT_DATE=$faker->dateTime);
	$report->insert($this->getPDO());

	//check count of Profile records in the database after the insert
	$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
	self::assertEquals($numRows + 1,$numRowsAfterInsert);

	//get a copy of the record just inserted and validate the values
	//make sure the values that went into the record are the same ones that come out
	$pdoReport = Report::getReportByReportId($this->getPDO(),$report->getReportId()->getBytes());


	self::assertEquals($VALID_REPORT_CONTENT,$pdoReport->getReportContent());

	$this->assertEquals($pdoReport->getReportProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoReport->getReportBusinessId(), $this->business->getBusinessId());
	//format the date too seconds since the beginning of time to avoid round off error
	$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
//	self::assertEquals($this->	VALID_REPORT_DATE,$pdoReport->getReportDate());





	}







}