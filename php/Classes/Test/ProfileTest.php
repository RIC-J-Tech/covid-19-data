<?php

namespace RICJ\Covid19;

use RICJTech\Covid19\DataDesignTest;
use Faker;
use RICJTech\Covid19\{Profile};


require_once (dirname(__DIR__)."/Test/DataDesignTest.php");


//grab the class scrutiny
require_once (dirname(__DIR__)."/autoload.php");

require_once (dirname(__DIR__,2)."/lib/uuid.php");

class ProfileTest extends DataDesignTest{
	private $VALID_ACTIVATION_TOKEN;
	private $VALID_CLOUDINARY_ID;
	private $VALID_AVATAR_URL;
	private $VALID_PROFILE_EMAIL;
	private $VALID_PROFILE_HASH;
	private $VALID_PROFILE_PHONE ;
	private $VALID_PROFILE_USERNAME;

	public function setUp(): void {
		parent::setUp();
		$faker = Faker\Factory::create();


		$password ="strong_password";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I,["time_cost"=>45]);
		$this->VALID_ACTIVATION_TOKEN= bin2hex(random_bytes(16));
		$this->VALID_PROFILE_EMAIL = $faker->email;
		$this->VALID_PROFILE_PHONE = $faker->phoneNumber;
		$this->VALID_CLOUDINARY_ID = $faker->url;
		$this->VALID_AVATAR_URL = $faker->url;
		$this->VALID_PROFILE_USERNAME = $faker->userName;
	}

	public function testInsertValidateProfile(): void {

		//get count of profile records in db before we run the test
		$numRows = $this->getConnection()->getRowCount("profile");

		//insert a profile record in the db
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_CLOUDINARY_ID,$this->VALID_AVATAR_URL,
		$this->VALID_ACTIVATION_TOKEN,$this->VALID_PROFILE_EMAIL,$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE,
		$this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());

		//check count of author records in the database after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1,$numRowsAfterInsert);

		//get a copy of the record just inserted and validate the values
		//make sure the values that went into the record are the same ones that come out
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(),$profile->getProfileId()->toString());
		self::assertEquals($this->VALID_CLOUDINARY_ID,$pdoProfile->getProfileCloudinaryId());
		self::assertEquals($this->	VALID_AVATAR_URL,$pdoProfile->getProfileAvatarUrl());
		self::assertEquals($this->VALID_ACTIVATION_TOKEN, $pdoProfile->getProfileActivationToken());
		self::assertEquals($this->VALID_PROFILE_EMAIL, $pdoProfile->getProfileEmail());
		self::assertEquals($this->VALID_PROFILE_HASH,$pdoProfile->getProfileHash());
		self::assertEquals($this->VALID_PROFILE_PHONE, $pdoProfile->getProfilePhone());
		self::assertEquals($this->VALID_PROFILE_USERNAME,$pdoProfile->getProfileUsername());


	}

	public function testUpdateValidProfile():void{

		//get count of profile records in database before we run the test
		$numRows = $this->getConnection()->getRowCount("profile");

		//insert a profile record in the db
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_CLOUDINARY_ID,$this->VALID_AVATAR_URL,
			$this->VALID_ACTIVATION_TOKEN,$this->VALID_PROFILE_EMAIL,$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE,
			$this->VALID_PROFILE_USERNAME);
		$profile->insert($this->getPDO());

		//update a value on the record that was just inserted
		$changedProfileUsername = $this->VALID_PROFILE_USERNAME."change";
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
		self::assertEquals($this->VALID_PROFILE_USERNAME,$pdoProfile->getProfileUsername());

		//verify that the saved username is the same as the updated username
		self::assertEquals($changedProfileUsername,$pdoProfile->getProfileUsername());

	}

}