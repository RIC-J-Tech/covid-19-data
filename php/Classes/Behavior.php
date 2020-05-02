<?php
namespace RICJTech\Covid19Data;

require_once("autoload.php");
require_once(dirname(__DIR__,2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/*
 * This is the behavior class
 */
class Behavior implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;


	/*
	 * id for this primary key
 	* @var Uuid behaviorId
 	*/
	private $behaviorId;

	/*
	 * id for this foreign key
 	* @var Uuid behaviorBusinessId
 	*/
	private $behaviorBusinessId;

	/*
	 * id for this foreign key
 	* @var Uuid behaviorProfileId
 	*/
	private $behaviorProfileId;

	/*
	 * content for this behavior
	 */
	private $behaviorContent;

	/*
	 * Date and time this behavior was posted
	 */
	private $behaviorDate;

	/**
	 * constructor for this Behavior
	 *
	 * @param string|Uuid $newBehaviorId id of this behavior or null if a new Behavior
	 * @param string|Uuid $newBehaviorBusinessId id of the Business to whom this behavior is posted
	 * @param string|Uuid $newBehaviorProfileId id of the Profile that posted this behavior
	 * @param string $newBehaviorContent string containing actual behavior data
	 * @param \DateTime|string|null $newBehaviorDate date and time Behavior was posted or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct($newBehaviorId, $newBehaviorBusinessId, $newBehaviorProfileId, string $newBehaviorContent, \DateTime $newBehaviorDate) {
		try {
			$this->setBehaviorId($newBehaviorId);
			$this->setBehaviorBusinessId($newBehaviorBusinessId);
			$this->setBehaviorProfileId($newBehaviorProfileId);
			$this->setBehaviorContent($newBehaviorContent);
			$this->setBehaviorDate($newBehaviorDate);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for behavior id
	 *
	 * @return Uuid value of behavior id
	 **/
	public function getBehaviorId(): Uuid {
		return ($this->behaviorId);
	}

	/**
	 * mutator method for behavior id
	 *
	 * @param Uuid|string $newBehaviorId new value of behavior id
	 * @throws \RangeException if $newBehaviorId is not positive
	 * @throws \TypeError if $newBehaviorId is not a uuid or string
	 **/
	public function setBehaviorId($newBehaviorId): void {
		try {
			var_dump($newBehaviorId);
			$uuid = self::validateUuid($newBehaviorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the behavior id
		$this->behaviorId = $uuid;
	}

	/**
	 * accessor method for behavior business id
	 *
	 * @return Uuid value of behavior business id
	 **/
	public function getBehaviorBusinessId(): Uuid {
		return ($this->behaviorBusinessId);
	}

	/**
	 * mutator method for behavior business id
	 *
	 * @param string | Uuid $newBehaviorBusinessId new value of behavior business id
	 * @throws \RangeException if $newBusinessId is not positive
	 * @throws \TypeError if $newBehaviorBusinessId is not an integer
	 **/
	public function setBehaviorBusinessId($newBehaviorBusinessId): void {
		try {
			$uuid = self::validateUuid($newBehaviorBusinessId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the business id
		$this->behaviorBusinessId = $uuid;
	}


	/**
	 * accessor method for behavior profile id
	 *
	 * @return Uuid value of behavior profile id
	 **/
	public function getBehaviorProfileId(): Uuid {
		return ($this->behaviorProfileId);
	}

	/**
	 * mutator method for behavior profile id
	 *
	 * @param string | Uuid $newBehaviorProfileId new value of behavior profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newBehaviorProfileId is not an integer
	 **/
	public function setBehaviorProfileId($newBehaviorProfileId): void {
		try {
			$uuid = self::validateUuid($newBehaviorProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->behaviorProfileId = $uuid;
	}

	/**
	 * accessor method for behavior content
	 *
	 * @return string value of behavior content
	 **/
	public function getBehaviorContent(): string {
		return ($this->behaviorContent);
	}

	/**
	 * mutator method for behavior content
	 *
	 * @param string $newBehaviorContent new value of behavior content
	 * @throws \InvalidArgumentException if $newBehaviorContent is not a string or insecure
	 * @throws \RangeException if $newBehaviorContent is > 256 characters
	 * @throws \TypeError if $newBehaviorContent is not a string
	 **/
	public function setBehaviorContent(string $newBehaviorContent): void {
		// verify the behavior content is secure
		$newBehaviorContent = trim($newBehaviorContent);
		$newBehaviorContent = filter_var($newBehaviorContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newBehaviorContent) === true) {
			throw(new \InvalidArgumentException("behavior content is empty or insecure"));
		}

		// verify the tweet content will fit in the database
		if(strlen($newBehaviorContent) > 256) {
			throw(new \RangeException("tweet content too large"));
		}

		// store the behavior content
		$this->behaviorContent = $newBehaviorContent;
	}


	/**
	 * accessor method for behavior date
	 *
	 * @return \DateTime value of behavior date
	 **/
	public function getBehaviorDate(): \DateTime {
		return ($this->behaviorDate);
	}

	/**
	 * mutator method for behavior date
	 *
	 * @param \DateTime|string|null $newBehaviorDate behavior date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newBehaviorDate is not a valid object or string
	 * @throws \RangeException if $newBehaviorDate is a date that does not exist
	 **/
	public function setBehaviorDate($newBehaviorDate = null): void {
		// base case: if the date is null, use the current date and time
		if($newBehaviorDate === null) {
			$this->behaviorDate = new \DateTime();
			return;
		}

		// store the like date using the ValidateDate trait
		try {
			$newBehaviorDate = self::validateDateTime($newBehaviorDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->behaviorDate = $newBehaviorDate;
	}


	/**
	 * inserts this Behavior into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO behavior(behaviorId, behaviorBusinessId, behaviorProfileId, behaviorContent, behaviorDate) VALUES(:behaviorId, :behaviorBusinessId, :behaviorProfileId, :behaviorContent, :behaviorDate)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->behaviorDate->format("Y-m-d H:i:s.u");
		$parameters = ["behaviorId" => $this->behaviorId->getBytes(), "behaviorBusinessId" => $this->behaviorBusinessId->getBytes(), "behaviorProfileId" => $this->behaviorProfileId->getBytes(), "behaviorContent" => $this->behaviorContent, "behaviorDate" => $formattedDate];
		$statement->execute($parameters);
	}


	/**
	 * deletes this behavior from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM behavior WHERE behaviorId = :behaviorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["behaviorId" => $this->behaviorId->getBytes()];
		$statement->execute($parameters);
	}


	/**
	 * updates this Behavior in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {

		// create query template
		$query = "UPDATE behavior SET behaviorBusinessId = :behaviorBusinessId, behaviorProfileId = :behaviorProfileId, behaviorContent = :behaviorContent, behaviorDate = :behaviorDate WHERE behaviorId = :behaviorId";
		$statement = $pdo->prepare($query);


		$formattedDate = $this->behaviorDate->format("Y-m-d H:i:s.u");
		$parameters = ["behaviorId" => $this->behaviorId->getBytes(), "behaviorBusinessId" => $this->behaviorBusinessId->getBytes(), "behaviorProfileId" => $this->behaviorProfileId->getBytes(), "behaviorContent" => $this->behaviorContent, "behaviorDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * gets the behavior by behaviorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $behaviorId behavior id to search for
	 * @return Behavior|null Behavior found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getBehaviorByBehaviorId(\PDO $pdo, $behaviorId): ?Behavior {
		// sanitize the behaviorId before searching
		try {
			$behaviorId = self::validateUuid($behaviorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT behaviorId, behaviorBusinessId, behaviorProfileId, behaviorContent, behaviorDate FROM behavior WHERE behaviorId = :behaviorId";
		$statement = $pdo->prepare($query);

		// bind the behavior id to the place holder in the template
		$parameters = ["behaviorId" => $behaviorId->getBytes()];
		$statement->execute($parameters);

		// grab the behavior from mySQL
		try {
			$behavior = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$behavior = new Behavior($row["behaviorId"], $row["behaviorBusinessId"], $row["behaviorProfileId"], $row["behaviorContent"], $row["behaviorDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($behavior);
	}


	/**
	 * gets the Behavior by business id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $behaviorBusinessId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Behavior found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getBehaviorByBehaviorBusinessId(\PDO $pdo, $behaviorBusinessId): \SplFixedArray {

		try {
			$behaviorBusinessId = self::validateUuid($behaviorBusinessId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT behaviorId, behaviorBusinessId, behaviorProfileId, behaviorContent, behaviorDate FROM behavior WHERE behaviorBusinessId = :behaviorBusinessId";
		$statement = $pdo->prepare($query);
		// bind the behavior Business id to the place holder in the template
		$parameters = ["behaviorBusinessId" => $behaviorBusinessId->getBytes()];
		$statement->execute($parameters);
		// build an array of behaviors
		$behaviors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$behavior = new Behavior($row["behaviorId"], $row["behaviorBusinessId"], $row["behaviorProfileId"], $row["behaviorContent"], $row["behaviorDate"]);
				$behaviors[$behaviors->key()] = $behavior;
				$behavior->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($behaviors);
	}


	/**
	 * gets the Behavior by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $behaviorProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Behavior found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getBehaviorByBehaviorProfileId(\PDO $pdo, $behaviorProfileId): \SplFixedArray {

		try {
			$behaviorProfileId = self::validateUuid($behaviorProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT behaviorId, behaviorBusinessId, behaviorProfileId, behaviorContent, behaviorDate FROM behavior WHERE behaviorProfileId = :behaviorProfileId";
		$statement = $pdo->prepare($query);
		// bind the behavior profile id to the place holder in the template
		$parameters = ["behaviorProfileId" => $behaviorProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of tweets
		$behaviors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$behavior = new Behavior($row["behaviorId"], $row["behaviorBusinessId"], $row["behaviorProfileId"], $row["behaviorContent"], $row["behaviorDate"]);
				$behaviors[$behaviors->key()] = $behavior;
				$behavior->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($behaviors);
	}


	/**
	 * gets the behavior by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $tweetContent behavior content to search for
	 * @return \SplFixedArray SplFixedArray of behavior found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getBehaviorByBehaviorContent(\PDO $pdo, string $behaviorContent): \SplFixedArray {
		// sanitize the description before searching
		$behaviorContent = trim($behaviorContent);
		$behaviorContent = filter_var($behaviorContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($behaviorContent) === true) {
			throw(new \PDOException("behavior content is invalid"));
		}

		// escape any mySQL wild cards
		$behaviorContent = str_replace("_", "\\_", str_replace("%", "\\%", $behaviorContent));

		// create query template
		$query = "SELECT behaviorId, behaviorProfileId, behaviorContent, behaviorDate FROM behavior WHERE behaviorContent LIKE :behaviorContent";
		$statement = $pdo->prepare($query);

		// bind the behavior content to the place holder in the template
		$behaviorContent = "%$behaviorContent%";
		$parameters = ["behaviorContent" => $behaviorContent];
		$statement->execute($parameters);

		// build an array of behaviors
		$behaviors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$behavior = new behavior($row["behaviorId"], $row["behaviorBusinessId"], $row["behaviorProfileId"], $row["behaviorContent"], $row["behaviorDate"]);
				$behaviors[$behaviors->key()] = $behavior;
				$behaviors->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($behaviors);
	}

	/**
	 * gets all votes
	 *
	 * @param \PDO $pdo PDO connection object.
	 * @return \SplFixedArray SplFixedArray of votes found or null if not found.
	 * @throws \PDOException when mySQL related errors.
	 * @throws \TypeError when variables are not the correct data type.
	 **/
	public static function getAllBehaviors(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT behaviorBusinessId, behaviorProfileId, behaviorContent, behaviorDate FROM getAllBehavior";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of behaviors
		$getAllBehaviors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$getAllBehaviors = new getAllBehaviors($row["behaviorBusinessId"], $row["behaviorProfileId"], $row["behaviorContent"], $row["behaviorDate"]);
				$getAllBehaviors[$getAllBehaviors->key()] = $getAllBehaviors;
				$getAllBehaviors->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($getAllBehaviors);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["behaviorId"] = $this->behaviorId->toString();
		$fields["behaviorBusinessId"] = $this->behaviorBusinessId->toString();
		$fields["behaviorProfileId"] = $this->behaviorProfileId->toString();

		//format the date so that the front end can consume it
		$fields["behaviorDate"] = round(floatval($this->behaviorDate->format("U.u")) * 1000);
		return ($fields);
	}


}