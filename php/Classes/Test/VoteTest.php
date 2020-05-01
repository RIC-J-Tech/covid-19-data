<?php

namespace RICJTech\Covid19Data\Test;

use RICJTech\Covid19Data\{Profile,Behavior, Business, Vote};
use Ramsey\Uuid\Uuid;
use RICJTech\Covid19Data\DataDesignTest;

require_once(dirname(__DIR__) . "/Test/DataDesignTest.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

class VoteTest extends DataDesignTest {
	private $profile = null;
	private $behavior = null;
	private $business= null;
	private $VALID_ACTIVATION_TOKEN;
	private $VALID_CLOUDINARY_ID = "astrongIdcloud";
	private $VALID_AVATAR_URL = "byrneindia@gmail.com";
	private $VALID_PROFILE_EMAIL = "byrneindia@gmail.com";
	private $VALID_PROFILE_HASH = "byrneindia@gmail.com";
	private $VALID_PROFILE_PHONE = "5058321940";
	private $VALID_PROFILE_USERNAME = "Batman";
	private $VALID_VOTE_DATE = null;
	private $VALID_VOTE_RESULT =true;


	public function setUp(): void {
		parent::setUp();
		$faker = Faker\Factory::create();
		$this->VALID_VOTE_DATE = $faker->dateTime;

		// create and insert a Profile to own the report content
		$this->profile = new Profile(generateUuidV4(), $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
			$this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL,
			$this->VALID_PROFILE_HASH, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_USERNAME);
		$this->profile->insert($this->getPDO());


		$this->business = new Business(generateUuidV4(), null,"123.456456", "128.789609", "RICJTECH","https://ricjtech.com");
		$this->business->insert($this->getPDO());

		$this->behavior = new Behavior(generateUuidV4(), $this->business->getBusinessId(),$this->profile->getProfileId(),"india", new DateTime());
		$this->behavior->insert($this->getPDO());
	}
}

