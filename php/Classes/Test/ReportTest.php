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
	private $VALID_CLOUDINARY_ID ="astrongIdcloud";
	private $VALID_REPORT_DATE =null;
	private $VALID_REPORT_CONTENT="some random report of nuisance";
	private $VALID_REPORT_CONTENT2;


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


		// create and insert a Profile to own the report content
		$this->profile = new Profile($profileId,$this->VALID_CLOUDINARY_ID, $faker->url,
			$VALID_ACTIVATION_TOKEN, $faker->email,
			$VALID_PROFILE_HASH, $faker->phoneNumber, $faker->userName);
		$this->profile->insert($this->getPDO());


		//create and insert a Business to own the Report content
		//insert a profile record in the db
		/** @var Uuid $businessId */
			$reportBusinessId =generateUuidV4()->toString();
		$this->business = new Business($reportBusinessId, "1234567898364527",$faker->longitude, $faker->latitude,
			"RICJTECH","https://ricjtech.com");
		$this->business->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_REPORT_DATE= new \DateTime();


	}


//public function testInsert(): void {
//	$faker = Faker\Factory::create();
//
//	//get count of profile records in db before we run the test
//	$numRows = $this->getConnection()->getRowCount("report");
//
//	/** @var Uuid $reportId */
//	$reportId = generateUuidV4()->toString();
//	$this->VALID_REPORT_DATE=$faker->dateTime;
//$this->VALID_REPORT_CONTENT = $faker->text;
//	$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
//		$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);
//	$report->insert($this->getPDO());
//
//	//check count of Profile records in the database after the insert
//	$numRowsAfterInsert = $this->getConnection()->getRowCount("report");
//	self::assertEquals($numRows + 1,$numRowsAfterInsert);
//
//	//get a copy of the record just inserted and validate the values
//	//make sure the values that went into the record are the same ones that come out
//	$pdoReport = Report::getReportByReportId($this->getPDO(),$report->getReportId()->getBytes());
//
//	$this->assertEquals($pdoReport->getReportProfileId(), $this->profile->getProfileId());
//
//	$this->assertEquals($pdoReport->getReportBusinessId(), $this->business->getBusinessId());
//
//	$this->assertEquals($pdoReport->getReportContent(), $this->VALID_REPORT_CONTENT);
//
//	//format the date too seconds since the beginning of time to avoid round off error
//	$this->assertEquals($pdoReport->getReportDate()->getTimestamp(), $this->VALID_REPORT_DATE->getTimestamp());
//
//	self::assertEquals($this->	VALID_REPORT_DATE,$pdoReport->getReportDate());
//	self::assertEquals($this->VALID_REPORT_CONTENT,$pdoReport->getReportContent());
//
//
//	}
//
//public function testUpdate():void{
//
//	$faker = Faker\Factory::create();
//	//get count of profile records in database before we run the test
//	$numRows = $this->getConnection()->getRowCount("report");
//
//	/** @var Uuid $reportId */
//	$reportId = generateUuidV4()->toString();
//	$this->VALID_REPORT_DATE=$faker->dateTime;
//	$this->VALID_REPORT_CONTENT = $faker->text;
//	$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
//		$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);
//	$report->insert($this->getPDO());
//
//	// edit the Report and update it in mySQL
//	$report->setReportContent($this->VALID_REPORT_CONTENT2=$faker->text);
//	$report->update($this->getPDO());
//
//	//get a copy of the record just inserted and validate the values
//	//make sure the values that went into the record are the same ones that come out
//	$pdoReport = Report::getReportByReportId($this->getPDO(),$report->getReportId()->getBytes());
//
//	$this->assertEquals($pdoReport->getReportProfileId(), $this->profile->getProfileId());
//
//	$this->assertEquals($pdoReport->getReportBusinessId(), $this->business->getBusinessId());
//
//	$this->assertEquals($pdoReport->getReportContent(), $this->VALID_REPORT_CONTENT2);
//
//	//format the date too seconds since the beginning of time to avoid round off error
//	$this->assertEquals($pdoReport->getReportDate()->getTimestamp(), $this->VALID_REPORT_DATE->getTimestamp());
//
//
//}
//
//public function testDelete() : void{
//
//	$faker = Faker\Factory::create();
//
//// count the number of rows and save it for later
//	$numRows = $this->getConnection()->getRowCount("report");
//
//	/** @var Uuid $reportId */
//	$reportId = generateUuidV4()->toString();
//	$this->VALID_REPORT_DATE=$faker->dateTime;
//	$this->VALID_REPORT_CONTENT = $faker->text;
//
//	$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
//		$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);
//
//	$report->insert($this->getPDO());
//
//	// delete the Report from mySQL
//	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("report"));
//
//	$report->delete($this->getPDO());
//
//	// grab the data from mySQL and enforce the Report does not exist
//	$pdoReport = Report::getReportByReportId($this->getPDO(),$report->getReportId()->getBytes());
//
//	$this->assertNull($pdoReport);
//
//	$this->assertEquals($numRows, $this->getConnection()->getRowCount("report"));
//
//}

//public function testGetValidReportByBusinessId(): void{
//	$faker = Faker\Factory::create();
//
//	//get count of profile records in db before we run the test
//	$numRows = $this->getConnection()->getRowCount("report");
//
//	/** @var Uuid $reportId */
//	$reportId = generateUuidV4()->toString();
//	$this->VALID_REPORT_DATE=$faker->dateTime;
//	$this->VALID_REPORT_CONTENT = $faker->text;
//
//	$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
//		$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);
//	$report->insert($this->getPDO());
//
//	$report->getReportBusinessId($this->getPDO(),$this->business->getBusinessId()->getBytes());
//	//check count of profile record in the db after the insert
//	$numRowsAfter = $this->getConnection()->getRowCount("report");
//	self::assertEquals($numRows + 1, $numRowsAfter,"checked record count");
//
//}

//public function testGetValidReportByReportId():void{
//
//	$faker = Faker\Factory::create();
//
//	//get count of profile records in db before we run the test
//	$numRows = $this->getConnection()->getRowCount("report");
//
//	/** @var Uuid $reportId */
//	$reportId = generateUuidV4()->toString();
//	$this->VALID_REPORT_DATE=$faker->dateTime;
//	$this->VALID_REPORT_CONTENT = $faker->text;
//
//	$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
//		$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);
//	$report->insert($this->getPDO());
//
//	$report->getReportId($this->getPDO(),$report->getReportId());
//	//check count of profile record in the db after the insert
//	$numRowsAfter = $this->getConnection()->getRowCount("report");
//	self::assertEquals($numRows + 1, $numRowsAfter,"checked record count");
//
//
//}


public function testGetValidReportByDate(): void{



}



}