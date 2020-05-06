<?php
namespace RICJTech\Covid19Data;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");
class Vote implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/*
	 * This is the vote class!
	 */

	/*
	 * id is a foreign key
	 * @var Uuid voteBehaviorId
	 */

	private $voteBehaviorId;


	/*
	 * id is a foreign key
	 * @var Uuid behaviorProfileId
	 */

	private $voteProfileId;


	/*
	 * Report date and time for vote.
	 * @var Uuid voteDate
	 */

	private $voteDate;


	/*
	 * Results of vote.
	 * @var Uuid voteRes
	 */

	private $voteResult;

	/**
	 *Construction for this Vote class.
	 *
	 * @param string|Uuid $voteBehaviorId id of this behavior or null if a new vote.
	 * @param string|Uuid $newVoteProfileId id of the business to whom this vote is posted.
	 * @param string|Uuid $newVoteResult results of the profile that behavior was voted on.
	 * @param \DateTime|string|null $newVoteDate date and time vote was posted or null if set to current date and time.
	 * @throws \InvalidArgumentException if data types are not valid.
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers).
	 * @throws \TypeError if data types violate type hints.
	 * @throws \Exception if some other exception occurs.
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct($newVoteBehaviorId, $newVoteProfileId, $newVoteDate, $newVoteResult = null) {
		try {
			$this->setVoteBehaviorId($newVoteBehaviorId);
			$this->setVoteProfileId($newVoteProfileId);
			$this->setnewVoteResult($newVoteResult) ;
			$this->setVoteDate($newVoteDate);
		} //determine what exception was thrown.

		catch
		(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){}
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}

	/**accessor method for voteBehaviorId
	 *
	 * @return Uuid value of voteBehaviorId
	 * */
	public function getVoteBehaviorId(): Uuid {
		return ($this->behaviorId);
	}

	/**mutator method for voteBehaviorId
	 * @param string |Uuid $newVoteBehaviorId new value.
	 * @throws \RangeException if $newVoteBehaviorId is not
	 * @throws \TypeError if $newVoteBehavior
	 **/
	public function setVoteBehaviorId($newVoteBehaviorId): void {
		try {
			$uuid = self::ValidateUuid($newVoteBehaviorId);
		}

		catch(\InvalidArgumentException| \RangeException| \Exception|\TypeError $exception) {
			$exceptionType = get_class(exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//store voteBehaviorId
		$this->VoteBehaviorId = $uuid;
	}

	/**
	 * accessor method for voteProfileId.
	 *
	 * @return  Uuid value of voteProfileId.
	 */
	public function getVoteProfileId() {
		return $this->voteProfileId;
	}
	/**
	 * mutator method for voteProfileId
	 *
	 * @param string | Uuid $newVoteProfileId new value.
	 * @throws \RangeException if $newVoteProfileId is not positive.
	 * @throws \TypeError if $newVoteProfileId is not an integer.
	 */
	public function setVoteProfileId($newVoteProfileId): void{

		try {
			$uuid = self::ValidateUuid($newVoteProfileId);
		}

		catch(\InvalidArgumentException| \RangeException |\Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception >getMessage(),0,));
		}

//convert and store the voteProfileId
		$this->voteProfileId= $uuid;
	}


	/*
	 * accessor method for voteDate.
	 *
	 * @return DateTime value of vote date.
	 */
	public function getVoteDate():\DateTime {
		return ($this->voteDate);
	}


	/*
	 * mutator method for voteDate.
	 *
	 *@param \DateTime|string|null $newVoteDate as DateTime object or string, or null to load current time/
	 *@throws \InvaildArgumentException if $newVote is not vaild object/string.
	 *@throws \RangeException if $newVoteDate is a date that doesn't exsist.
	 */
	public function setVoteDate($newVoteDate = null): void {
		//case: if the date is null, use current.
		if(newVoteDate === null) {
			$this->voteDate = new\DateTime();
			return;
		}

//store the like date using ValidateDate trait.
		try {
			$newVoteDate = self::ValidateDateTime($newVoteDate);
		} catch(\InvalidArgumentException|\RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->voteDate = $newVoteDate;
	}


	/**inserts this Vote into mySQL
	 *
	 * @param \PDO $pdo PDO connection object.
	 * @throws \PDOException when mySQL related errors.
	 * @throws \TypeError if $pdo is not a POD connection object.
	 **/
	public function insert(PDO $pdo): void {

//create query template
		$query = "INSERT INTO vote(voteProfileId, voteBehaviorId, voteDate, voteResult) VALUES(:voteProfileId, :voteBehaviorId, :voteDate, :voteResult)";
		$statement = $pdo->prepare($query);

//bind the member variables to place holders.

		$formattedDate = $this->voteDate->format("Y-m-d H:i:s.u");
		$parameters = ["voteProfileId" => $this->voteProfileIdId->getBytes(),
			"voteBehaviorId" => $this->voteBehaviorId->getBytes(),
			"voteResult" => $this->voteResult, "voteDate" => $formattedDate];
		$statement->execute($parameters);

	}

	/**
	 * updates this Vote in mySQL
	 *
	 * @param \PDO $pdo PDO connection object.
	 * @throws \PDOException mySQL related errors.
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 **/
	public function update(\PDO $pdo, $voteProfileId, $voteBehaviorId): void {


		// create query template"
		$query = "UPDATE vote SET  voteDate = :voteDate, voteResult = :voteResult WHERE voteProfileId = :voteProfileId and voteBehaviorId = :voteBehaviorId";
		$statement = $pdo->prepare($query);
		$formattedDate = $this->voteDate->format("Y-m-d H:i:s.u");
		$parameters = ["voteProfileId" => $this->voteProfileId->getBytes(),
			"voteBehaviorId" => $this->voteBehaviorId->getBytes(),
			"voteResult" => $this->voteResult, "voteDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * @param \PDO $pdo
	 * @param $voteProfileId
	 * @param $voteBehaviorId
	 */
	public function delete(\PDO $pdo, $voteProfileId, $voteBehaviorId): void {
		// create query template
		$query = "DELETE FROM vote WHERE voteProfileId = :voteProfileId and voteBehaviorId = :voteBehaviorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["voteProfileId" => $this->voteProfileId->getBytes(),
			"voteBehaviorId" => $this->voteBehaviorId->getBytes()];
		$statement->execute($parameters);
	}


	/**
	 * Retrieves vote database using the voteProfileId.
	 *
	 * @param \PDO $pdo PDO connection object.
	 * @param $voteProfileId
	 * @return SplFixedArray SplFixedArray of reports found.
	 *
	 */

	/**
	 * gets the votes by voteProfileId
	 *
	 * @param \PDO $pdo PDO connection object.
	 * @param Uuid|string $voteProfileId id to search by.
	 * @return \SplFixedArray SplFixedArray of votes found.
	 * @throws \PDOException when mySQL related errors.
	 * @throws \TypeError when variables are not the correct data type.
	 **/
	public static function getVotesByVoteProfileId(\PDO $pdo, $voteProfileId) : \SplFixedArray {

		try {
			$voteProfileId = self::ValidateUuid($voteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT voteProfileId, voteBehaviorId, voteDate, voteResult FROM vote WHERE voteProfileId = :voteProfileId";
		$statement = $pdo->prepare($query);

		// bind the vote profile id to the place holder in the template
		$parameters = ["voteProfileId" => $voteProfileId->getBytes()];
		$statement->execute($parameters);

		// build an array of votes
		$votes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$vote = new Vote ($row["voteProfileId"], $row["voteBehaviorId"], $row["voteDate"], $row["voteResult"]);
				$votes[$votes->key()] = $vote;
				$votes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($votes);
	}

	/**
	 * gets the votes by voteDate
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \DateTime|string $voteDate profile id to search by
	 * @return \SplFixedArray SplFixedArray of Behavior found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVotesByVoteDate(\PDO $pdo, $voteDate): \SplFixedArray {

		try {
			$voteDate = self::ValidateDate($voteDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create dates for midnight of the date and midnight of the next day.
		$startDateString = $voteDate->format('Y-m-d').'00:00:00';

		$startDate = new DateTime($startDateString);

		$endDate = new DateTime($startDateString);

		$endDate->add(new \DateInterval('P1D'));

		// create query template
		$query = "SELECT voteProfileId, voteBehaviorId, voteResult, voteDate FROM vote WHERE voteDate >= :startDate AND voteDate <= :endDate";
		$statement = $pdo->prepare($query);

		// bind the behavior Business id to the place holder in the template
		$parameters = ['startDate' => $startDate->format('Y-m-d H:i:s.u'),'endDate'=>$endDate->format('Y-m-d H:i:s.u')];
		$statement->execute($parameters);

		// build an array of behaviors
		$votes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$vote = new Vote ($row["voteProfileId"], $row["voteBehaviorId"], $row["voteDate"], $row["voteResult"]);
				$votes [$votes->key()] = $vote;
				$votes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($votes);
	}

//	/**
//	 * gets the vote by result
//	 * .
//	 *
//	 * @param \PDO $pdo PDO connection object.
//	 * @param $voteResult
//	 * @return \SplFixedArray SplFixedArray of behavior found.
//	 * @throws \PDOException when mySQL related errors.
//	 * @throws \TypeError when variables are not the correct data type.
//	 */
//	public static function getVoteByVoteResult (\PDO $pdo, $voteResult) : \SplFixedArray {
//
//		try {
//			$voteResult = self::ValidateUuid($voteResult);
//		}
//		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
//			throw(new \PDOException($exception->getMessage(), 0, $exception));
//		}
//
//		// create query template
//		$query = "SELECT voteProfileId, voteBehaviorId, voteResult, voteDate FROM vote WHERE voteId = :voteId";
//		$statement = $pdo->prepare($query);
//		// bind the tweet profile id to the place holder in the template
//		$parameters = ["voteResult" => $voteResult->getBytes()];
//		$statement->execute($parameters);
//		// build an array of tweets
//		$voteResult = new \SplFixedArray($statement->rowCount());
//		$statement->setFetchMode(\PDO::FETCH_ASSOC);
//		while(($row = $statement->fetch()) !== false) {
//			try {
//				$voteResult = new voteId\voteId($row["voteProfileId"], $row["voteBehaviorId"], $row["voteResult"], $row["voteDate"]);
//				$voteResult[$voteResult->key()] = $voteResult;
//				$voteResult->next();
//			} catch(\Exception $exception) {
//				// if the row couldn't be converted, rethrow it
//				throw(new \PDOException($exception->getMessage(), 0, $exception));
//			}
//		}
//		return($voteResult);
//	}
//
//
//	/**
//	 * gets all votes
//	 *
//	 * @param \PDO $pdo PDO connection object.
//	 * @return \SplFixedArray SplFixedArray of votes found or null if not found.
//	 * @throws \PDOException when mySQL related errors.
//	 * @throws \TypeError when variables are not the correct data type.
//	 **/
//	public static function getAllVotes(\PDO $pdo) : \SPLFixedArray {
//		// create query template
//		$query = "SELECT voteProfileId, voteBehaviorId, voteResult, voteDate FROM getAllVotes";
//		$statement = $pdo->prepare($query);
//		$statement->execute();
//
//		// build an array of votes
//		$getAllVotes = new \SplFixedArray($statement->rowCount());
//		$statement->setFetchMode(\PDO::FETCH_ASSOC);
//		while(($row = $statement->fetch()) !== false) {
//			try {
//				$getAllVotes = new getAllVotes($row["voteProfileId"], $row["voteBehaviorId"], $row["voteResult"], $row["voteDate"]);
//				$getAllVotes[$getAllVotes->key()] = $getAllVotes;
//				$getAllVotes->next();
//			} catch(\Exception $exception) {
//				// if the row couldn't be converted, rethrow it
//				throw(new \PDOException($exception->getMessage(), 0, $exception));
//			}
//		}
//		return ($getAllVotes);
//	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["voteBehaviorId"] = $this->voteBehaviorId->toString();
		$fields["voteProfileId"] = $this->voteProfileId->toString();
		$fields["voteDate"] = $this->voteDate->toString();
		$fields["voteResult"] = $this->voteResult->toString();

		//format the date so that the front end can consume it
		$fields["voteDate"] = round(floatval($this->voteDate->format("U.u")) * 1000);
		return ($fields);
	}
}


