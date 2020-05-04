<?php
namespace RICJTech\Covid19Data\Test;

use RICJTech\Covid19Data\{Behavior};
use RICJTech\Covid19Data\{Business};
use RICJTech\Covid19Data\{Profile};

use Faker;
////Hack!!! - added so this class could see DataDesignTest
require_once(dirname(__DIR__) . "/Test/DataDesignTest.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");


// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

class BehaviorTest extends DataDesignTest {

	/**
	 * Business, this is for foreign key relations
	 * @var  Business
	 **/
	protected $business = null;

	/**
	 * Profile that created the Behavior; this is for foreign key relations
	 * @var Profile
	 **/
	protected $profile = null;
/*
 * content of behavior
 * @var string $Valid_Behavior_Content
 */
	protected $Valid_Behavior_Content = "Put on masks";
	/*
	 * date and time of post of this behavior
	 * @var \Datetime $Valid_Behavior_Date
	 */
	protected $Valid_Behavior_Date = null;


	protected $VALID_PROFILE_HASH;
	protected $VALID_ACTIVATION_TOKEN;

	private $VALID_PROFILE_EMAIL;
	private $VALID_PROFILE_PHONE;
	private $VALID_AVATAR_URL;
	private $VALID_PROFILE_USERNAME;


	public final function setUp()  : void {
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

		$businessId = generateUuidV4()->toString();

		$profileId = generateUuidV4()->toString();
		$this->Valid_Behavior_Date = $faker->dateTime;
		// create and insert a Profile to own the test Tweet
		$this->business = new Business($businessId, "1122334455231245","123.456456", "128.789609", "RICJTECH","https://ricjtech.com");
		$this->business->insert($this->getPDO());

		// create and insert a Profile to own the test Behavior
		$this->profile = new Profile($profileId, "6464646464646464",$this->VALID_AVATAR_URL, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL,$this->VALID_PROFILE_HASH, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_USERNAME);
		$this->profile->insert($this->getPDO());

	}

	public function testInsertValidBehavior() : void {
		//get count of behavior records in the database before we run the test.
		$numRows = $this->getConnection()->getRowCount("behavior");

		//insert a behavior record in the db
		$behaviorId = generateUuidV4()->toString();

	//var_dump($behaviorId);
//		var_dump($this->business->getBusinessId());
//		var_dump($this->profile->getProfileId());

		$behavior = new Behavior($behaviorId, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
			$this->Valid_Behavior_Content, $this->Valid_Behavior_Date);
		$behavior->insert($this->getPDO());

		// check count of behavior records in the db after the insert
//			$numRowsAfterInsert = $this->getConnection()->getRowCount("behavior");
//			self::assertEquals($numRows + 1, $numRowsAfterInsert, "insert checked record count");
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("behavior"));

// grab the data from mySQL and enforce the fields match our expectations
		$pdoBehavior = Behavior::getBehaviorByBehaviorId($this->getPDO(), $behavior->getBehaviorId()->toString());
//		self::assertEquals($behaviorId, $pdoBehavior->getbehaviorId());
//		self::assertEquals($behaviorBusinessId, $pdoBehavior->getBehaviorBusinessId());
//		self::assertEquals($behaviorProfileId, $pdoBehavior->getBehaviorProfileId());
		$this->assertEquals($pdoBehavior->getBehaviorId(), $behaviorId);
		$this->assertEquals($pdoBehavior->getBehaviorBusinessId(), $this->business->getBusinessId());
		$this->assertEquals($pdoBehavior->getBehaviorProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoBehavior->getBehaviorContent(), $this->Valid_Behavior_Content);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoBehavior->getBehaviorDate()->getTimestamp(), $this->Valid_Behavior_Date->getTimestamp());

	}

	/**
	 * test inserting a Behavior, editing it, and then updating it
	 **/
	public function testUpdateValidBehavior() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("behavior");

		// create a new Behavior and insert it into mySQL
		$behaviorId = generateUuidV4()->toString();
		$behavior = new Behavior($behaviorId, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
			$this->Valid_Behavior_Content, $this->Valid_Behavior_Date);
		$behavior->insert($this->getPDO());

	// edit the Behavior and update it in mySQL
		$behavior->setbehaviorContent($this->Valid_Behavior_Content2);
		$behavior->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoBehavior = Behavior::getBehaviortByBehaviorId($this->getPDO(), $behavior->getBehaviorId());
		$this->assertEquals($pdoBehavior->getBehaviorId(), $behaviorId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("behavior"));
		$this->assertEquals($pdoBehavior->getBehaviorBusinessId(), $this->business->getBusinessId());
		$this->assertEquals($pdoBehavior->getBehaviorProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoBehavior->getBehaviorContent(), $this->Valid_Behavior_Content2);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoBehavior->getBehaviorDate()->getTimestamp(), $this->Valid_Behavior_Date->getTimestamp());
	}

//	/**
//	 * test creating a Behavior and then deleting it
//	 **/
//	public function testDeleteValidBehavior() : void {
//		// count the number of rows and save it for later
//		$numRows = $this->getConnection()->getRowCount("behavior");
//
//		// create a new Behavior and insert to into mySQL
//		$behaviorId = generateUuidV4();
//		$behavior = new Behavior($behaviorId, $this->business->getBusinessId(), $this->profile->getProfileId(), $this->Valid_Behavior_Content, $this->Valid_Behavior_Date);
//		$behavior->insert($this->getPDO());
//
//		// delete the Behavior from mySQL
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("behavior"));
//		$behavior->delete($this->getPDO());
//
//		// grab the data from mySQL and enforce the Behavior does not exist
//		$pdoBehavior = Behavior::getBehaviorByBehaviorId($this->getPDO(), $behavior->getBehaviorId());
//		$this->assertNull($pdoBehavior);
//		$this->assertEquals($numRows, $this->getConnection()->getRowCount("behavior"));
//	}
//
//
//
//
//



	}
