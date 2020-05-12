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

	use setUpTest;

	/**
	 * Business, this is for foreign key relations
	 * @var  Business
	 **/
	protected $business;

	/**
	 * Profile that created the Behavior; this is for foreign key relations
	 * @var Profile
	 **/
	protected $profile;
/*
 * content of behavior
 * @var string $Valid_Behavior_Content
 */
	protected $Valid_Behavior_Content = "wore gloves";
	/**
	 * content of the updated Behavior
	 * @var string $Valid_Behavior_Content2
	 **/
	protected $Valid_Behavior_Content2 = "put on mask";
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

		$this->profile = self::createProfile();
		$this->business = self::createBusiness();

		$this->profile->insert($this->getPDO());
		$this->business->insert($this->getPDO());

		$this->Valid_Behavior_Date = $faker->dateTime;

	}

	public function testInsertValidBehavior() : void {
		//get count of behavior records in the database before we run the test.
		$numRows = $this->getConnection()->getRowCount("behavior");

		//insert a behavior record in the db
		$behaviorId = generateUuidV4()->toString();

		$behavior = new Behavior($behaviorId, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
			$this->Valid_Behavior_Content, $this->Valid_Behavior_Date);
		$behavior->insert($this->getPDO());

		// check count of behavior records in the db after the insert
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("behavior"));

// grab the data from mySQL and enforce the fields match our expectations
		$pdoBehavior = Behavior::getBehaviorByBehaviorId($this->getPDO(), $behavior->getBehaviorId()->toString());
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

		// check count of behavior records in the db after the insert
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("behavior"));

		// edit the Behavior and update it in mySQL
		$behavior->setbehaviorContent($this->Valid_Behavior_Content2);
		$behavior->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoBehavior = Behavior::getBehaviorByBehaviorId($this->getPDO(), $behavior->getBehaviorId()->toString());
		$this->assertEquals($pdoBehavior->getBehaviorId(), $behaviorId);
		$this->assertEquals($pdoBehavior->getBehaviorBusinessId(), $this->business->getBusinessId());
		$this->assertEquals($pdoBehavior->getBehaviorProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoBehavior->getBehaviorContent(), $this->Valid_Behavior_Content2);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoBehavior->getBehaviorDate()->getTimestamp(), $this->Valid_Behavior_Date->getTimestamp());
	}

	/**
	 * test creating a Behavior and then deleting it
	 **/
	public function testDeleteValidBehavior() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("behavior");

		// create a new Behavior and insert to into mySQL
		$behaviorId = generateUuidV4()->toString();
		$behavior = new Behavior($behaviorId, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
			$this->Valid_Behavior_Content, $this->Valid_Behavior_Date);
		$behavior->insert($this->getPDO());

		// delete the Behavior from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("behavior"));
		$behavior->delete($this->getPDO());

		// grab the data from mySQL and enforce the Behavior does not exist
		$pdoBehavior = Behavior::getBehaviorByBehaviorId($this->getPDO(), $behavior->getBehaviorId()->toString());
		$this->assertNull($pdoBehavior);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("behavior"));
	}

	/**
	 * test grabbing a Behavior that does not exist
	 **/
	public function testGetInvalidBehaviorByBehaviorId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$behavior = Behavior::getBehaviorByBehaviorId($this->getPDO(), generateUuidV4()->toString());
		$this->assertNull($behavior);
	}

	/**
	 * test inserting a Behavior and regrabbing it from mySQL
	 *
	 *
	 **/
	public function testGetValidBehaviorByBehaviorBusinessId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("behavior");

		// create a new Behavior and insert to into mySQL
		$behaviorId = generateUuidV4()->toString();
		$behavior = new Behavior($behaviorId, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
			$this->Valid_Behavior_Content, $this->Valid_Behavior_Date);
		$behavior->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Behavior::getBehaviorByBehaviorBusinessId($this->getPDO(), $behavior->getBehaviorBusinessId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("behavior"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("RICJTech\\Covid19Data\\Behavior", $results);

		// grab the result from the array and validate it
		$pdoBehavior = $results[0];
		$this->assertEquals($pdoBehavior->getBehaviorId(), $behaviorId);
		$this->assertEquals($pdoBehavior->getBehaviorBusinessId(), $this->business->getBusinessId());
		$this->assertEquals($pdoBehavior->getBehaviorProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoBehavior->getBehaviorContent(), $this->Valid_Behavior_Content);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoBehavior->getBehaviorDate()->getTimestamp(), $this->Valid_Behavior_Date->getTimestamp());

	}


	/**
	 * test inserting a Behavior and regrabbing it from mySQL
	 *
	 *
	 **/
	public function testGetValidBehaviorByBehaviorProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("behavior");

		// create a new Behavior and insert to into mySQL
		$behaviorId = generateUuidV4()->toString();
		$behavior = new Behavior($behaviorId, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
			$this->Valid_Behavior_Content, $this->Valid_Behavior_Date);
		$behavior->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Behavior::getbehaviorByBehaviorProfileId($this->getPDO(), $behavior->getBehaviorProfileId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("behavior"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("RICJTech\\Covid19Data\\Behavior", $results);

		// grab the result from the array and validate it
		$pdoBehavior = $results[0];
		$this->assertEquals($pdoBehavior->getBehaviorId(), $behaviorId);
		$this->assertEquals($pdoBehavior->getBehaviorBusinessId(), $this->business->getBusinessId());
		$this->assertEquals($pdoBehavior->getBehaviorProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoBehavior->getBehaviorContent(), $this->Valid_Behavior_Content);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoBehavior->getBehaviorDate()->getTimestamp(), $this->Valid_Behavior_Date->getTimestamp());
	}

	/**
	 * test grabbing a Behavior that does not exist
	 **/
	public function testGetInvalidBehaviorByBehaviorBusinessId() : void {
		// grab a business id that exceeds the maximum allowable business id
		$behavior = Behavior::getBehaviorByBehaviorBusinessId($this->getPDO(), generateUuidV4()->toString());
		$this->assertCount(0, $behavior);
	}

	/**
	 * test grabbing a Behavior that does not exist
	 **/
	public function testGetInvalidBehaviorByBehaviorProfileId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$behavior = Behavior::getBehaviorByBehaviorProfileId($this->getPDO(), generateUuidV4()->toString());
		$this->assertCount(0, $behavior);
	}


	/**
	 * test grabbing a behavior by behavior content
	 **/
	public function testGetValidBehaviorByBehaviorContent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("behavior");

		// create a new Behavior and insert to into mySQL
		$behaviorId = generateUuidV4()->toString();
		$behavior = new Behavior($behaviorId, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
			$this->Valid_Behavior_Content, $this->Valid_Behavior_Date);
		$behavior->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Behavior::getBehaviorByBehaviorContent($this->getPDO(), $behavior->getBehaviorContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("behavior"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("RICJTech\\Covid19Data\\Behavior", $results);

		// grab the result from the array and validate it
		$pdoBehavior = $results[0];
		$this->assertEquals($pdoBehavior->getBehaviorId(), $behaviorId);
		$this->assertEquals($pdoBehavior->getBehaviorBusinessId(), $this->business->getBusinessId());
		$this->assertEquals($pdoBehavior->getBehaviorProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoBehavior->getBehaviorContent(), $this->Valid_Behavior_Content);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoBehavior->getBehaviorDate()->getTimestamp(), $this->Valid_Behavior_Date->getTimestamp());
	}

	/**
	 * test grabbing a behavior by content that does not exist
	 **/
	public function testGetInvalidBehaviorByBehaviorContent() : void {
		// grab a behavior by content that does not exist
		$behavior = Behavior::getBehaviorByBehaviorContent($this->getPDO(), "Respected social distancing 6ft apart rule");
		$this->assertCount(0, $behavior);
	}


	/**
	 * test grabbing all Behaviors
	 **/
	public function testGetAllValidBehaviors() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("behavior");

		// create a new Behavior and insert to into mySQL
		$behaviorId = generateUuidV4()->toString();
		$behavior = new Behavior($behaviorId, $this->business->getBusinessId()->toString(), $this->profile->getProfileId()->toString(),
			$this->Valid_Behavior_Content, $this->Valid_Behavior_Date);
		$behavior->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Behavior::getAllBehaviors($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("behavior"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("RICJTech\\Covid19Data\\Behavior", $results);

		// grab the result from the array and validate it
		$pdoBehavior = $results[0];
		$this->assertEquals($pdoBehavior->getBehaviorId(), $behaviorId);
		$this->assertEquals($pdoBehavior->getBehaviorBusinessId(), $this->business->getBusinessId());
		$this->assertEquals($pdoBehavior->getBehaviorProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoBehavior->getBehaviorContent(), $this->Valid_Behavior_Content);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoBehavior->getBehaviorDate()->getTimestamp(), $this->Valid_Behavior_Date->getTimestamp());
	}




}
