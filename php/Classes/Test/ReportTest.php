<?php

namespace RICJTech\Covid19Data\Test;

require_once(dirname(__DIR__) . "/autoload.php");

use phpDocumentor\Reflection\Types\Self_;
use RICJTech\Covid19Data\{Profile,Business,Report};
use Ramsey\Uuid\Uuid;

use RICJTech\Covid19Data\Test\DataDesignTest;
use Faker;

// grab the class under scrutiny

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


class ReportTest extends DataDesignTest {
	private $VALID_CLOUDINARY_ID ="astrongIdcloud";
	private $VALID_REPORT_DATE =null;
	private $VALID_REPORT_CONTENT="some random report of nuisance";
	private $VALID_REPORT_CONTENT2;
	use setUpTest;

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

		$this->profile = self::createProfile();

		$this->profile->insert($this->getPDO());

		$this->business = self::createBusiness();
		$this->business->insert($this->getPDO());


	}


public function testInsert(): void {
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

	//check count of Profile records in the database after the insert
	$numRowsAfterInsert = $this->getConnection()->getRowCount("report");
	self::assertEquals($numRows + 1,$numRowsAfterInsert);

	//get a copy of the record just inserted and validate the values
	//make sure the values that went into the record are the same ones that come out
	$pdoReport = Report::getReportByReportId($this->getPDO(),$report->getReportId()->getBytes());

	$this->assertEquals($pdoReport->getReportProfileId(), $this->profile->getProfileId());

	$this->assertEquals($pdoReport->getReportBusinessId(), $this->business->getBusinessId());

	$this->assertEquals($pdoReport->getReportContent(), $this->VALID_REPORT_CONTENT);

	//format the date too seconds since the beginning of time to avoid round off error
	$this->assertEquals($pdoReport->getReportDate()->getTimestamp(), $this->VALID_REPORT_DATE->getTimestamp());

	self::assertEquals($this->	VALID_REPORT_DATE,$pdoReport->getReportDate());
	self::assertEquals($this->VALID_REPORT_CONTENT,$pdoReport->getReportContent());


	}

public function testUpdate():void{

	$faker = Faker\Factory::create();
	//get count of profile records in database before we run the test
	$numRows = $this->getConnection()->getRowCount("report");

	/** @var Uuid $reportId */
	$reportId = generateUuidV4()->toString();
	$this->VALID_REPORT_DATE=$faker->dateTime;
	$this->VALID_REPORT_CONTENT = $faker->text;
	$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
		$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);
	$report->insert($this->getPDO());

	// edit the Report and update it in mySQL
	$report->setReportContent($this->VALID_REPORT_CONTENT2=$faker->text);
	$report->update($this->getPDO());

	//get a copy of the record just inserted and validate the values
	//make sure the values that went into the record are the same ones that come out
	$pdoReport = Report::getReportByReportId($this->getPDO(),$report->getReportId()->getBytes());

	$this->assertEquals($pdoReport->getReportProfileId(), $this->profile->getProfileId());

	$this->assertEquals($pdoReport->getReportBusinessId(), $this->business->getBusinessId());

	$this->assertEquals($pdoReport->getReportContent(), $this->VALID_REPORT_CONTENT2);

	//format the date too seconds since the beginning of time to avoid round off error
	$this->assertEquals($pdoReport->getReportDate()->getTimestamp(), $this->VALID_REPORT_DATE->getTimestamp());


}

public function testDelete() : void{

	$faker = Faker\Factory::create();

// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("report");

	/** @var Uuid $reportId */
	$reportId = generateUuidV4()->toString();
	$this->VALID_REPORT_DATE=$faker->dateTime;
	$this->VALID_REPORT_CONTENT = $faker->text;

	$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
		$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);

	$report->insert($this->getPDO());

	// delete the Report from mySQL
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("report"));

	$report->delete($this->getPDO());

	// grab the data from mySQL and enforce the Report does not exist
	$pdoReport = Report::getReportByReportId($this->getPDO(),$report->getReportId()->getBytes());

	$this->assertNull($pdoReport);

	$this->assertEquals($numRows, $this->getConnection()->getRowCount("report"));

}

public function testGetValidReportByBusinessId(): void{
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

	$report->getReportBusinessId($this->getPDO(),$this->business->getBusinessId()->getBytes());
	//check count of profile record in the db after the insert
	$numRowsAfter = $this->getConnection()->getRowCount("report");
	self::assertEquals($numRows + 1, $numRowsAfter,"checked record count");

}

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


public function testGetValidReportByDate(): void {
	$faker = Faker\Factory::create();

	//get count of profile records in db before we run the test
	$numRows = $this->getConnection()->getRowCount("report");


	/** @var Uuid $reportId */

	$reportId = generateUuidV4()->toString();
	$this->VALID_REPORT_DATE = $this->getTestDate(45);
	$this->VALID_REPORT_CONTENT = $faker->text;
	$report = new Report($reportId, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
		$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);

	$reportId2 = generateUuidV4()->toString();
	$VALID_REPORT_DATE2 = $this->getTestDate(-5);
	$this->VALID_REPORT_CONTENT = $faker->text;
	$report2 = new Report($reportId2, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
		$this->VALID_REPORT_CONTENT, $VALID_REPORT_DATE2);

	$reportId3 = generateUuidV4()->toString();
	$VALID_REPORT_DATE3 = $this->getTestDate(-15);
	$this->VALID_REPORT_CONTENT = $faker->text;
	$report3 = new Report($reportId3, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
		$this->VALID_REPORT_CONTENT, $VALID_REPORT_DATE3);

	$reportId4 = generateUuidV4()->toString();
	$VALID_REPORT_DATE4 = $this->getTestDate(-35);
	$this->VALID_REPORT_CONTENT = $faker->text;
	$report4 = new Report($reportId4, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
		$this->VALID_REPORT_CONTENT, $VALID_REPORT_DATE4);

	$report->insert($this->getPDO());
	$report2->insert($this->getPDO());
	$report3->insert($this->getPDO());
	$report4->insert($this->getPDO());

	$report->getReportId($this->getPDO(),$report->getReportId());
//	check count of profile record in the db after the insert
	$numRowsAfter = $this->getConnection()->getRowCount("report");
	self::assertEquals($numRows + 4, $numRowsAfter, "checked record count");
	$reports = Report::getReportsByReportDate($this->getPDO(), $this->getMaxDate());
	$this->assertCount(2, $reports);


//$reports1 = array($report,$report2,$report3,$report4);
	for($i = 0; $i <$reports->count(); $i++) {

		$pdoReport = $reports[$i];

		self::assertGreaterThan($this->getMinDate(), $pdoReport->getReportDate());
    self::assertLessThan($this->getMaxDate(), $pdoReport->getReportDate());
}

}


private function getMinDate(): \DateTime{
return $this->getTestDate(-30);

}


private function getMaxDate(): \DateTime{

		return new \DateTime();
}



public function getTestDate($interval): \DateTime {
	//Calculating dates used for testing.
	$newInterval = "P" . abs($interval ). "D";


	$startDate = new \DateTime(); //initialize start date

	if($interval<0){
		$startDate->sub(new \DateInterval($newInterval));
	}

	else{
		$startDate->add(new \DateInterval($newInterval));

	}


	return $startDate;


}

private function getDateDiff($endDate): int {

		$endDate = $this->getTestDate(3);


}
public function testFunction(): void {

		$func = $this->getTestDate(-3);

	self::assertEquals(true,true);

}




}