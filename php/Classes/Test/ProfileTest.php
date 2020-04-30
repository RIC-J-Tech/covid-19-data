<?php

namespace RICJTech\Covid19Data\Test;

use RICJTech\Covid19Data\{Profile};
use Ramsey\Uuid\Uuid;
use RICJTech\Covid19Data\DataDesignTest;
use Faker;
require_once (dirname(__DIR__). "/Test/DataDesignTest.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


class ProfileTest extends DataDesignTest {
	private $VALID_ACTIVATION_TOKEN;
	private $VALID_CLOUDINARY_ID ="astrongIdcloud";
	private $VALID_AVATAR_URL;
	private $VALID_PROFILE_EMAIL;
	private $VALID_PROFILE_HASH;
	private $VALID_PROFILE_PHONE ;
	private $VALID_PROFILE_USERNAME;

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

	}

	public function testInsertValidateProfile(): void {

		//get count of profile records in db before we run the test
		$numRows = $this->getConnection()->getRowCount("profile");

		//insert a profile record in the db
		/** @var Uuid $profileId */

		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_CLOUDINARY_ID,$this->VALID_AVATAR_URL,
		$this->VALID_ACTIVATION_TOKEN,$this->VALID_PROFILE_EMAIL,$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE,
		$this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());


		//check count of Profile records in the database after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1,$numRowsAfterInsert);

		//get a copy of the record just inserted and validate the values
		//make sure the values that went into the record are the same ones that come out
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(),$profile->getProfileId()->getBytes());
		self::assertEquals($this->VALID_CLOUDINARY_ID,$pdoProfile->getProfileCloudinaryId());
		self::assertEquals($this->	VALID_AVATAR_URL,$pdoProfile->getProfileAvatarUrl());
		self::assertEquals($this->VALID_ACTIVATION_TOKEN, $pdoProfile->getProfileActivationToken());
		self::assertEquals($this->VALID_PROFILE_EMAIL, $pdoProfile->getProfileEmail());
		self::assertEquals($this->VALID_PROFILE_HASH,$pdoProfile->getProfileHash());
		self::assertEquals($this->VALID_PROFILE_PHONE, $pdoProfile->getProfilePhone());
		self::assertEquals($this->VALID_PROFILE_USERNAME,$pdoProfile->getProfileUsername());


	}

	//Update Testing
	public function testUpdateValidProfile():void{

		$faker = Faker\Factory::create();

		//get count of profile records in database before we run the test
		$numRows = $this->getConnection()->getRowCount("profile");


		//insert a profile record in the db
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_CLOUDINARY_ID,$this->VALID_AVATAR_URL,
			$this->VALID_ACTIVATION_TOKEN,$this->VALID_PROFILE_EMAIL,$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE,
			$this->VALID_PROFILE_USERNAME);

		$profile->insert($this->getPDO());

		//update a value on the record that was just inserted
		$changedProfileUsername = $faker->name;
		$profile->setProfileUsername($changedProfileUsername);
		$profile->update($this->getPDO());

		//check count of profile record in the db after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1,$numRowsAfterInsert,"update checked record count");

		//get a copy of the record just inserted and validate the values
		//make sure the values that went into the record are the same ones that come out
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(),$profile->getProfileId()->toString());
		self::assertEquals($this->VALID_CLOUDINARY_ID,$pdoProfile->getProfileCloudinaryId());
		self::assertEquals($this->	VALID_AVATAR_URL,$pdoProfile->getProfileAvatarUrl());
		self::assertEquals($this->VALID_ACTIVATION_TOKEN, $pdoProfile->getProfileActivationToken());
		self::assertEquals($this->VALID_PROFILE_EMAIL, $pdoProfile->getProfileEmail());
		self::assertEquals($this->VALID_PROFILE_HASH,$pdoProfile->getProfileHash());
		self::assertEquals($this->VALID_PROFILE_PHONE, $pdoProfile->getProfilePhone());

		//verify that the saved username is the same as the updated username
		self::assertEquals($changedProfileUsername,$pdoProfile->getProfileUsername());

	}

public function testDeleteValidProfile() : void {
$faker = Faker\Factory::create();
//get count of Profile records in db before we run the test
	$numRows = $this->getConnection()->getRowCount("profile");

$insertedRow = 3;

for($i = 0; $i < $insertedRow; $i++){

$profileId=generateUuidV4()->toString();
$profile = new Profile(
$profileId, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,$this->VALID_ACTIVATION_TOKEN,
	$this->VALID_PROFILE_EMAIL=$faker->email,$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE=$faker->phoneNumber,
	$this->VALID_PROFILE_USERNAME=$faker->userName);

	$profile->insert($this->getPDO());

}
//get a copy of the record just updated and validate the values
	// make sure the values that went into the record are the same ones that come out
	$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
	self::assertEquals($numRows + $insertedRow, $numRowsAfterInsert);

	//now delete the last record we inserted
	$profile->delete($this->getPDO());

	//try to get the last record we inserted. it should not exist.
	$pdoProfile = Profile::getProfileByProfileId($this->getPDO(),$profile->getProfileId()->toString());
	//validate that only one record was deleted.
	$numRowsAfterDelete = $this->getConnection()->getRowCount("profile");
	self::assertEquals($numRows + $insertedRow - 1, $numRowsAfterDelete);


}

public function getProfileValidateByUsername(): void{
	$faker = Faker\Factory::create();
//get count of Profile records in db before we run the test
	$numRows = $this->getConnection()->getRowCount("profile");

		$profileId=generateUuidV4()->toString();
		$profile = new Profile(
			$profileId, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,$this->VALID_ACTIVATION_TOKEN,
			$this->VALID_PROFILE_EMAIL=$faker->email,$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE=$faker->phoneNumber,
			$this->VALID_PROFILE_USERNAME=$faker->userName);

		$profile->insert($this->getPDO());
	$profile->getProfileByUsername($this->getPDO(),$profile->getProfileUsername());
	}



	public function getProfileValidByEmail(): void {
		$faker = Faker\Factory::create();
//get count of Profile records in db before we run the test
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId=generateUuidV4()->toString();
		$profile = new Profile(
			$profileId, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,$this->VALID_ACTIVATION_TOKEN,
			$this->VALID_PROFILE_EMAIL=$faker->email,$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE=$faker->phoneNumber,
			$this->VALID_PROFILE_USERNAME=$faker->userName);

		$profile->insert($this->getPDO());

		$profile->getProfileByEmail($this->getPDO(),$profile->getProfileEmail());
		//check count of profile record in the db after the insert
		$numRowsAfter = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1, $numRowsAfter,"checked record count");

	}

	public function testGetValidProfileByProfileId(): void {

//get count of profile records in db before we run the test
		$numRows = $this->getConnection()->getRowCount("profile");
		//get an profile record in the db by Id
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_CLOUDINARY_ID,$this->VALID_AVATAR_URL,
			$this->VALID_ACTIVATION_TOKEN,$this->VALID_PROFILE_EMAIL,$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE,
			$this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());
		$profile->getProfileByProfileId($this->getPDO(),$profileId);
		//check count of profile record in the db after the insert
		$numRowsAfter = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1, $numRowsAfter,"checked record count");
	}



	public function testGetAllValidProfiles() : void {
		$faker = Faker\Factory::create();

		//how many records were in the db before we start?
		$numRows = $this->getConnection()->getRowCount("profile");
		$rowsInserted = 5;

		//now insert 5 rows of data
		for ($i=0; $i<$rowsInserted; $i++){

			$profileId = generateUuidV4()->toString();
			$profile = new Profile(
				$profileId, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,$this->VALID_ACTIVATION_TOKEN,
				$this->VALID_PROFILE_EMAIL=$faker->email,$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE=$faker->phoneNumber,
				$this->VALID_PROFILE_USERNAME=$faker->userName);

			$profile->insert($this->getPDO());
		}

		//validate new row count in the table - should be old row count + 1 if insert is successful
		self::assertEquals($numRows + $rowsInserted, $this->getConnection()->getRowCount("profile"));

		//validate number of rows coming back from our function.
		self::assertEquals($numRows + $rowsInserted, $profile->getAllprofiles($this->getPDO())->count());
	}

}