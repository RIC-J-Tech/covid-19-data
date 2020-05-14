<?php
namespace RICJTech\Covid19Data\Test;
use RICJTech\Covid19Data\{Profile,Behavior, Vote};
use Ramsey\Uuid\Uuid;
//use RICJTech\Covid19Data\DataTest;
use Faker;
//require_once(dirname(__DIR__) . "/Test/DataDesignTest.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
class VoteTest extends DataDesignTest {

	use setUpTest;


	/**
	 * Profile that created the liked the Behavior; this is for foreign key relations
	 * @var  Profile $profile
	 **/
	protected $profile;

	/**
	 * Behavior that was liked; this is for foreign key relations
	 * @var Behavior $behavior
	 **/
	protected $behavior;

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * timestamp of the Vote; this starts as null and is assigned later
	 * @var \DateTime $VALID_VOTEDATE
	 **/
	protected $VALID_VOTEDATE;

	/**
	 * valid activationToken to create the profile object to own the test
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;




	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() : void {
		// run the default setUp() method first
		parent::setUp();
		$faker = Faker\Factory::create();

		// create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		// create and insert the mocked profile
		$this->profile = self::createProfile();
		$this->profile->insert($this->getPDO());

		// create the and insert the mocked behavior
		$this->behavior = self::createBehavior();
		$this->behavior->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_VOTEDATE = new \DateTime();
	}

	/**
	 * test inserting a valid Vote and verify that the actual mySQL data matches
	 **/
	public function testInsertValidVote() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->profile->getProfileId(), $this->behavior->getBehaviorId(), $this->VALID_VOTEDATE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVote = Vote::getVoteByVoteBehaviorIdAndVoteProfileId($this->getPDO(), $this->profile->getProfileId(), $this->behavior->getBehaviorId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoVote->getVoteBehaviorId(), $this->behavior->getBehaviorId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoVote->getVoteDate()->getTimeStamp(), $this->VALID_VOTEDATE->getTimestamp());
	}

	/**
	 * test creating a Vote and then deleting it
	 **/
	public function testDeleteValidVote() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->profile->getProfileId(), $this->behavior->getBehaviorId(), $this->VALID_VOTEDATE);
		$vote->insert($this->getPDO());

		// delete the Vote from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$vote->delete($this->getPDO());

		// grab the data from mySQL and enforce the Behavior does not exist
		$pdoVote = Vote::getVoteByVoteBehaviorIdAndVoteProfileId($this->getPDO(), $this->profile->getProfileId(), $this->behavior->getBehaviorId());
		$this->assertNull($pdoVote);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("vote"));
	}

	/**
	 * test inserting a Vote and regrabbing it from mySQL
	 **/
	public function testGetValidVoteByBehaviorIdAndProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->profile->getProfileId(), $this->behavior->getBehaviorId(), $this->VALID_VOTEDATE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVote = Vote::getVoteByVoteBehaviorIdAndVoteProfileId($this->getPDO(), $this->profile->getProfileId(), $this->behavior->getBehaviorId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoVote->getVoteBehaviorId(), $this->behavior->getBehaviorId());

		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoVote->getVoteDate()->getTimeStamp(), $this->VALID_VOTEDATE->getTimestamp());
	}

	/**
	 * test grabbing a Vote that does not exist
	 **/
	public function testGetInvalidVoteByBehaviorIdAndProfileId() {
		// grab a behavior id and profile id that exceeds the maximum allowable behavior id and profile id
		$vote = Vote::getVoteByVoteBehaviorIdAndVoteProfileId($this->getPDO(), generateUuidV4(), generateUuidV4());
		$this->assertNull($vote);
	}

	/**
	 * test grabbing a Vote by behavior id
	 **/
	public function testGetValidVoteByBehaviorId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->profile->getProfileId(), $this->behavior->getBehaviorId(), $this->VALID_VOTEDATE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Vote::getVoteByVoteBehaviorId($this->getPDO(), $this->behavior->getBehaviorId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Vote", $results);

		// grab the result from the array and validate it
		$pdoVote = $results[0];
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoVote->getVoteBehaviorId(), $this->behavior->getBehaviorId());

		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoVote->getVoteDate()->getTimeStamp(), $this->VALID_VOTEDATE->getTimestamp());
	}

	/**
	 * test grabbing a Vote by a behavior id that does not exist
	 **/
	public function testGetInvalidVoteByBehaviorId() : void {
		// grab a behavior id that exceeds the maximum allowable behavior id
		$vote = Vote::getVoteByVoteBehaviorId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $vote);
	}

	/**
	 * test grabbing a Vote by profile id
	 **/
	public function testGetValidVoteByProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->profile->getProfileId(), $this->behavior->getBehaviorId(), $this->VALID_VOTEDATE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Vote::getVoteByVoteProfileId($this->getPDO(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Vote", $results);

		// grab the result from the array and validate it
		$pdoVote = $results[0];
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoVote->getVoteBehaviorId(), $this->behavior->getBehaviorId());

		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoVote->getVoteDate()->getTimeStamp(), $this->VALID_VOTEDATE->getTimestamp());
	}

	/**
	 * test grabbing a Vote by a profile id that does not exist
	 **/
	public function testGetInvalidVoteByProfileId() : void {
		// grab a behavior id that exceeds the maximum allowable profile id
		$vote = Vote::getVoteByVoteProfileId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $vote);
	}

}