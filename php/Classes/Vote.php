<?php

namespace RICJTech\Covid19Data;
require_once("autoload.php");

require_once(dirname(__DIR__) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * Cross Section of a Twitter Like
 *
 * This is a cross section of what probably occurs when a user likes a Tweet. It is an intersection table (weak
 * entity) from an m-to-n relationship between Profile and Tweet.
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 3.0.0
 **/
class Vote implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/**
	 * id of the Tweet being liked; this is a component of a composite primary key (and a foreign key)
	 * @var Uuid $voteBehaviorId
	 **/
	private $voteBehaviorId;
	/**
	 * id of the Profile who voted; this is a component of a composite primary key (and a foreign key)
	 * @var Uuid $voteProfileId
	 **/
	private $voteProfileId;
	/**
	 * date and time the behavior was voted
	 * @var \DateTime $voteDate
	 **/
	private $voteDate;

	/*
	 * vote result
	 * @var String $voteResult
	 */
private $voteResult;


	/**
	 * constructor for this Like
	 *
	 * @param string|Uuid $newVoteProfileId id of the parent Profile
	 * @param String|null $newVoteResult vote result
	 * @param string|Uuid $newVoteBehaviorId id of the parent Tweet
	 * @param \DateTime|null $newVoteDate date the tweet was liked (or null for current time)
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception is thrown
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */

	public function __construct( $newVoteProfileId,$newVoteBehaviorId,$newVoteResult, $newVoteDate = null) {
		// use the mutator methods to do the work for us!
		try {
			$this->setVoteProfileId($newVoteProfileId);
			$this->setVoteBehaviorId($newVoteBehaviorId);
			$this->setVoteResult($newVoteResult);
			$this->setVoteDate($newVoteDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

			// determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profile id
	 **/
	public function getVoteProfileId() : Uuid {
		return ($this->voteProfileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param string  $newVoteProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setVoteProfileId($newVoteProfileId) : void {
		try {
			$uuid = self::validateUuid($newVoteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->voteProfileId = $uuid;
	}

	/**
	 * accessor method for tweet id
	 *
	 * @return uuid value of tweet id
	 **/
	public function getVoteTweetId() : Uuid{
		return ($this->voteTweetId);
	}

	/**
	 * mutator method for behavior id
	 *
	 * @param string  $newVoteBehaviorId new value of behavior id
	 * @throws \RangeException if $newBehaviorId is not positive
	 * @throws \TypeError if $newVoteBehaviorId is not an integer
	 **/
	public function setVoteBehaviorId( $newVoteBehaviorId) : void {
		try {
			$uuid = self::validateUuid($newVoteBehaviorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->voteBehaviorId = $uuid;
	}

	/**
	 * accessor method for vote date
	 *
	 * @return \DateTime value of vote date
	 **/
	public function getVoteDate() : \DateTime {
		return ($this->voteDate);
	}

	/**
	 * mutator method for vote date
	 *
	 * @param \DateTime|string|null $newVoteDate vote date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newVoteDate is not a valid object or string
	 * @throws \RangeException if $newVoteDate is a date that does not exist
	 **/
	public function setVoteDate($newVoteDate): void {
		// base case: if the date is null, use the current date and time
		if($newVoteDate === null) {
			$this->voteDate = new \DateTime();
			return;
		}

		// store the vote date using the ValidateDate trait
		try {
			$newVoteDate = self::validateDateTime($newVoteDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->voteDate = $newVoteDate;
	}

	/**
	 * inserts this Like into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function insert(\PDO $pdo) : void {
		// create query template
		$query = "INSERT INTO `vote`(voteProfileId, voteBehaviorId, voteResult,voteDate) VALUES(:voteProfileId, :voteBehaviorId, :voteResult,:voteDate)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->voteDate->format("Y-m-d H:i:s.u");
		$parameters = ["voteProfileId" => $this->voteProfileId->getBytes(), "voteBehaviorId" => $this->voteBehaviorId->getBytes(),"voteResult"=>$this->voteResult,"voteDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Vote from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM `vote` WHERE voteProfileId = :voteProfileId AND voteBehaviorId = :voteBehaviorId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in the template
		$parameters = ["voteProfileId" => $this->voteProfileId->getBytes(), "voteBehaviorId" => $this->voteBehaviorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the Like by tweet id and profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $likeProfileId profile id to search for
	 * @param string $likeTweetId tweet id to search for
	 * @return Like|null Like found or null if not found
	 */
	public static function getLikeByLikeTweetIdAndLikeProfileId(\PDO $pdo, string $likeProfileId, string $likeTweetId) : ?Like {

		//
		try {
			$likeProfileId = self::validateUuid($likeProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		try {
			$likeTweetId = self::validateUuid($likeTweetId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT likeProfileId, likeTweetId, likeDate FROM `like` WHERE likeProfileId = :likeProfileId AND likeTweetId = :likeTweetId";
		$statement = $pdo->prepare($query);

		// bind the tweet id and profile id to the place holder in the template
		$parameters = ["likeProfileId" => $likeProfileId->getBytes(), "likeTweetId" => $likeTweetId->getBytes()];
		$statement->execute($parameters);

		// grab the like from mySQL
		try {
			$like = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$like = new Like($row["likeProfileId"], $row["likeTweetId"], $row["likeDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($like);
	}

	/**
	 * gets the Like by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $likeProfileId profile id to search for
	 * @return \SplFixedArray SplFixedArray of Likes found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getLikeByLikeProfileId(\PDO $pdo, string $likeProfileId) : \SPLFixedArray {
		try {
			$likeProfileId = self::validateUuid($likeProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT likeProfileId, likeTweetId, likeDate FROM `like` WHERE likeProfileId = :likeProfileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["likeProfileId" => $likeProfileId->getBytes()];
		$statement->execute($parameters);

		// build an array of likes
		$likes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$like = new Like($row["likeProfileId"], $row["likeTweetId"], $row["likeDate"]);
				$likes[$likes->key()] = $like;
				$likes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($likes);
	}

	/**
	 * gets the Like by tweet it id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $likeTweetId tweet id to search for
	 * @return \SplFixedArray array of Likes found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getLikeByLikeTweetId(\PDO $pdo, string $likeTweetId) : \SplFixedArray {
		try {
			$likeTweetId = self::validateUuid($likeTweetId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT likeProfileId, likeTweetId, likeDate FROM `like` WHERE likeTweetId = :likeTweetId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["likeTweetId" => $likeTweetId->getBytes()];
		$statement->execute($parameters);

		// build the array of likes
		$likes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$like = new Like($row["likeProfileId"], $row["likeTweetId"], $row["likeDate"]);
				$likes[$likes->key()] = $like;
				$likes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($likes);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);


		//format the date so that the front end can consume it
		$fields["likeProfileId"] = $this->likeProfileId;
		$fields["likeTweetId"] = $this->likeTweetId;
		$fields["likeDate"] = round(floatval($this->likeDate->format("U.u")) * 1000);

		return ($fields);
	}
}