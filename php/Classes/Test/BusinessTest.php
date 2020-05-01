<?php

namespace RICJTech\Covid19Data\Test;

use Ramsey\Uuid\Uuid;
use RICJTech\Covid19Data\Business;
use RICJTech\Covid19Data\DataDesignTest;
use Faker;
require_once (dirname(__DIR__). "/Test/DataDesignTest.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


class BusinessTest extends DataDesignTest {
	private $VALIDATE_BUSINESS_ID;
	private $VALID_BUSINESSLNG;
	private $VALID_BUSINESSLAT;
	private $VALID_BUSINESSNAME;
	private $VALID_BUSINESSURL;
	private $VALID_BUSINESSYELPID;

	public function setUp(): void {
		parent::setUp();
		$faker = Faker\Factory::create();

		$lng = 35.0844;
		$this->VALID_BUSINESSLNG = floatval($lng);   //todo - need to go back and generate this through faker potentially.
		$lat = 106.6504;
		$this->VALID_BUSINESSLAT = floatval($lat);   //todo - how to generate a random float in php
		$this->VALID_BUSINESSNAME = "Covid Business";   //todo - potentially can pull from faker
		$this->VALID_BUSINESSURL = $faker->url;
		$this->VALID_BUSINESSYELPID = "1234567";   //todo - need to generate this somewhere

	}

	public function testInsertValidateBusinessId(): void {


		$numRows = $this->getConnection()->getRowCount("business");


		/** @var Uuid $businessId */

		$businessId = generateUuidV4()->toString();
		$business = new Business($businessId, $this->VALID_BUSINESSYELPID, $this->VALID_BUSINESSLNG,
			$this->VALID_BUSINESSLAT, $this->VALID_BUSINESSNAME, $this->VALID_BUSINESSURL);
		$business->insert($this->getPDO());


		$numRowsAfterInsert = $this->getConnection()->getRowCount("business");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);


		$pdoBusiness = Business::getBusinessbyBusinessId($this->getPDO(), $business->getBusinessId()->getBytes());
		self::assertEquals($this->VALID_BUSINESSYELPID, $pdoBusiness->getBusinessYelpId());
		self::assertEquals($this->VALID_BUSINESSLNG, $pdoBusiness->getBusinessLng());
		self::assertEquals($this->VALID_BUSINESSLAT, $pdoBusiness->getBusinessLat());
		self::assertEquals($this->VALID_BUSINESSNAME, $pdoBusiness->getBusinessName());
		self::assertEquals($this->VALID_BUSINESSURL, $pdoBusiness->getBusinessUrl());
		self::assertEquals($this->VALID_BUSINESSYELPID, $pdoBusiness->getBusinessYelpId());

	}


	public function testUpdateValidBusiness(): void {


		$numRows = $this->getConnection()->getRowCount("business");


		$businessId = generateUuidV4()->toString();
		$business = new Business($businessId, $this->VALID_BUSINESSYELPID, $this->VALID_BUSINESSLNG, $this->VALID_BUSINESSLAT, $this->VALID_BUSINESSNAME, $this->VALID_BUSINESSURL);

		$business->insert($this->getPDO());


		$changedBusinessName = $this->VALID_BUSINESSNAME . "change";
		$business->setBusinessName($changedBusinessName);
		$business->update($this->getPDO());


		$numRowsAfterInsert = $this->getConnection()->getRowCount("business");
		self::assertEquals($numRows + 1, $numRowsAfterInsert, "update checked record count");


		$pdoBusiness = Business::getBusinessByBusinessId($this->getPDO(), $business->getBusinessId()->toString());
		self::assertEquals($this->VALID_BUSINESSYELPID, $pdoBusiness->getBusinessYelpId());
		self::assertEquals($this->VALID_BUSINESSLNG, $pdoBusiness->getBusinessLng());
		self::assertEquals($this->VALID_BUSINESSLAT, $pdoBusiness->getBusinessLat());
		self::assertNotEquals($this->VALID_BUSINESSNAME, $pdoBusiness->getBusinessName());
		self::assertEquals($this->VALID_BUSINESSURL, $pdoBusiness->getBusinessUrl());

		self::assertEquals($changedBusinessName, $pdoBusiness->getBusinessName());

	}

	public function testDeleteValidBusiness(): void {


		$numRows = $this->getConnection()->getRowCount("business");

		$insertedRow = 3;

		for($i = 0; $i < $insertedRow; $i++) {

			$businessId = generateUuidV4()->toString();
			$business = new Business(
				$businessId, $this->VALID_BUSINESSYELPID, $this->VALID_BUSINESSLNG, $this->VALID_BUSINESSLAT,
				$this->VALID_BUSINESSNAME, $this->VALID_BUSINESSYELPID);

			$business->insert($this->getPDO());

		}

		$numRowsAfterInsert = $this->getConnection()->getRowCount("business");
		self::assertEquals($numRows + $insertedRow, $numRowsAfterInsert);

		$business->delete($this->getPDO());

		$pdoBusiness = Business::getBusinessbyBusinessId($this->getPDO(), $business->getBusinessId()->toString());

		$numRowsAfterDelete = $this->getConnection()->getRowCount("business");
		self::assertEquals($numRows + $insertedRow - 1, $numRowsAfterDelete);
	}

	public function testGetBusinessByBusinessName(): void {

		$numRows = $this->getConnection()->getRowCount("business");

		$insertedRow = 3;

		for($i = 65; $i < $insertedRow + 65; $i++) {

			$businessId = generateUuidV4()->toString();
			$businessName = $this->VALID_BUSINESSNAME . chr($i);
			$business = new Business(
				$businessId, $this->VALID_BUSINESSYELPID, $this->VALID_BUSINESSLNG, $this->VALID_BUSINESSLAT,
				$businessName, $this->VALID_BUSINESSYELPID);

			$business->insert($this->getPDO());

		}
		$numRowsAfterInsert = $this->getConnection()->getRowCount("business");
		self::assertEquals($numRows + $insertedRow, $numRowsAfterInsert);

		$pdoBusiness = Business::getBusinessByBusinessName($this->getPDO(), $this->VALID_BUSINESSNAME);
		self::assertEquals($numRows + $insertedRow, $pdoBusiness->count());
	}



}
