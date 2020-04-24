<?php
namespace RICJTech\Covid19;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/*
 * This is the Author class
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
	 * constructor for this Tweet
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

	public function __construct($newBehaviorId, $newBehaviorBusinessId, $newBehaviorProfileId, string $newBehaviorContent, $newBehaviorDate = null) {
		try {
			$this->setBehaviorId($newBehaviorId);
			$this->setBehaviorBusinessId($newBehaviorBusinessId);
			$this->setBehaviorProfileId($newBehaviorProfileId);
			$this->setBehaviorContent($newBehaviorContent);
			$this->setBehaviorDate($newBehaviorDate);
		}
			//determine what exception type was thrown
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
	public function getBehaviorId() : Uuid {
		return($this->behaviorId);
	}

	/**
	 * mutator method for behavior id
	 *
	 * @param Uuid|string $newBehaviorId new value of behavior id
	 * @throws \RangeException if $newBehaviorId is not positive
	 * @throws \TypeError if $newBehaviorId is not a uuid or string
	 **/
	public function setBehaviorId( $newBehaviorId) : void {
		try {
			$uuid = self::validateUuid($newBehaviorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the tweet id
		$this->behaviorId = $uuid;
	}

	/**
	 * accessor method for behavior business id
	 *
	 * @return Uuid value of behavior business id
	 **/
	public function getBehaviorBusinessId() : Uuid{
		return($this->behaviorBusinessId);
	}

	/**
	 * mutator method for behavior business id
	 *
	 * @param string | Uuid $newBehaviorBusinessId new value of behavior business id
	 * @throws \RangeException if $newBusinessId is not positive
	 * @throws \TypeError if $newBehaviorBusinessId is not an integer
	 **/
	public function setBehaviorBusinessId( $newBehaviorBusinessId) : void {
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
	public function getBehaviorProfileId() : Uuid{
		return($this->behaviorProfileId);
	}

	/**
	 * mutator method for behavior profile id
	 *
	 * @param string | Uuid $newBehaviorProfileId new value of behavior profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newBehaviorProfileId is not an integer
	 **/
	public function setTweetProfileId( $newBehaviorProfileId) : void {
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
	public function getTweetContent() : string {
		return($this->behaviorContent);
	}

	/**
	 * mutator method for behavior content
	 *
	 * @param string $newBehaviorContent new value of behavior content
	 * @throws \InvalidArgumentException if $newBehaviorContent is not a string or insecure
	 * @throws \RangeException if $newBehaviorContent is > 140 characters
	 * @throws \TypeError if $newBehaviorContent is not a string
	 **/
	public function setBehaviorContent(string $newBehaviorContent) : void {
		// verify the tweet content is secure
		$newBehaviorContent = trim($newBehaviorContent);
		$newBehaviorContent = filter_var($newBehaviorContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newBehaviorContent) === true) {
			throw(new \InvalidArgumentException("behavior content is empty or insecure"));
		}

		// verify the behavior content will fit in the database
		if(strlen($newBehaviorContent) > 140) {
			throw(new \RangeException("behavior content too large"));
		}

		// store the tweet content
		$this->behaviorContent = $newBehaviorContent;
	}


	/**
	 * accessor method for behavior date
	 *
	 * @return \DateTime value of behavior date
	 **/
	public function getBehaviorDate() : \DateTime {
		return($this->behaviorDate);
	}

	/**
	 * mutator method for behavior date
	 *
	 * @param \DateTime|string|null $newBehaviorDate behavior date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newBehaviorDate is not a valid object or string
	 * @throws \RangeException if $newBehaviorDate is a date that does not exist
	 **/
	public function setBehaviorDate($newBehaviorDate = null) : void {
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
	public function insert(\PDO $pdo) : void {

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
	public function delete(\PDO $pdo) : void {

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
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE behavior SET behaviorBusinessId = :behaviorBusinessId, behaviorProfileId = :behaviorProfileId, behaviorContent = :behaviorContent, behaviorDate = :behaviorDate WHERE behaviorId = :behaviorId";
		$statement = $pdo->prepare($query);


		$formattedDate = $this->behaviorDate->format("Y-m-d H:i:s.u");
		$parameters = ["behaviorId" => $this->behaviorId->getBytes(), "behaviorBusinessId" => $this->behaviorBusinessId->getBytes(), "behaviorProfileId" => $this->behaviorProfileId->getBytes(), "behaviorContent" => $this->behaviorContent, "behaviorDate" => $formattedDate];
		$statement->execute($parameters);
	}




	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();
		$fields["authorActivationToken"] = $this->authorActivationToken->toString();
		$fields["authorAvatarUrl"] = $this->authorAvatarUrl->toString();
		$fields["authorEmail"] = $this->authorEmail->toString();
		$fields["authorHash"] = $this->authorHash->toString();
		$fields["authorUsername"] = $this->authorUserName->toString();

		return ($fields);
	}
}
