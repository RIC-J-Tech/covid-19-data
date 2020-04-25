<?php
namespace OpeyemiJonah\ObjectOriented;
require_once ("autoload.php");

use DateTime;
use Exception;
use InvalidArgumentException;
use Ramsey\uuid\uuid;
use RangeException;
use TypeError;

/**
 * RIC-J Tech to the rescue
 * Team Awesome
 *
 * Covid-19 data project
 * This app is to rank the behavior multiple businesses exhibit following
 * the CDC guidelines or rules
 * Creating a profile class to store user profiles using the app
 * This class is for reporting Users going against the purpose of the app
 *
 * @author Opeyemi Jonah <gavrieljonah@gmail.com>
 * @version 1.0.0
 **/


class Report implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;

	/**
	 * @var uuid $reportId
	 */

private $reportId;

	/**
	 * @var uuid $reportBusinessId
	 */
private $reportBusinessId;

	/**
	 *Actual report made by users
	 * @var string $reportContent
	 */

private $reportContent;

	/**
	 * Date of report
	 * @var DateTime $reportDate
	 * returns date
	 */
private $reportDate;

	/**
	 * Report profile Id
	 * @var uuid $reportProfileId
	 */
private  $reportProfileId;


	/**
	 * constructor for this Profile class
	 *
	 * @param uuid $newReportId
	 * @param uuid $newReportBusinessId
	 * @param uuid $newReportProfileId
	 * @param string $newReportContent
	 * @param DateTime $newReportDate
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
public function __construct($newReportId,$newReportBusinessId,$newReportProfileId, string $newReportContent, DateTime $newReportDate) {
	try{
			$this->setReportId($newReportId);
			$this->setReportBusinessId($newReportBusinessId);
			$this->setReportProfileId($newReportProfileId);
			$this->setReportContent($newReportContent);
			$this->setReportDate($newReportDate);

	}
	catch(InvalidArgumentException | RangeException| Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}

}

	/**
	 * Accessor for report ID
	 * @return uuid
	 */
	public function getReportId(): Uuid{
		return $this->reportId;
	}


	/**
	 * Accessor for reportBusinessId
	 * @return uuid
	 */
public function getReportBusinessId(): Uuid{
	return $this->reportBusinessId;
}

	/**
	 * Accessor for reportProfileId
	 * @return string
	 */
	public function getReportContent(): string {
		return $this->reportContent;
	}

	/**
	 * Accessor for report date
	 * @return DateTime
	 */
public function getReportDate(): DateTime{
	return $this->reportDate;
}



	/**
	 * mutator method for report id
	 *
	 * @param Uuid|string $newReportId new value of report id
	 * @throws RangeException if $newReportId is not positive
	 * @throws \TypeError if $newReportId is not a uuid or string
	 **/
	public function setReportId($newReportId): void {
		try {
			$uuid = self::validateUuid($newReportId);
		} catch(InvalidArgumentException | RangeException | Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the report id
		$this->reportId = $uuid;
	}
	/**
	 * mutator method for report business id
	 *
	 * @param string | Uuid $newReportBusinessId new value of behavior business id
	 * @throws RangeException if $newReportId is not positive
	 * @throws \TypeError if $newReportBusinessId is not an integer
	 **/
	public function setReportBusinessId($newReportBusinessId): void {
		try {
			$uuid = self::validateUuid($newReportBusinessId);
		} catch(InvalidArgumentException | RangeException | Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the business id
		$this->reportBusinessId = $uuid;
	}
	/**
	 * mutator method for report profile id
	 *
	 * @param string | Uuid $newReportProfileId new value of behavior business id
	 * @throws RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newReportProfileId is not an integer
	 **/
	public function setReportProfileId($newReportProfileId): void {
		try {
			$uuid = self::validateUuid($newReportProfileId);
		} catch(InvalidArgumentException | RangeException | Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->reportProfileId = $uuid;
	}
	/**
	 * mutator method for report content
	 *
	 * @param string $newReportContent new value of report content
	 * @throws InvalidArgumentException if $newReportContent is not a string or insecure
	 * @throws \TypeError if $newReportContent is not a string
	 **/
	public function setReportContent(string $newReportContent): void {
		// verify the report content is secure
		$newReportContent = trim($newReportContent);
		$newReportContent = filter_var($newReportContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newReportContent) === true) {
			throw(new InvalidArgumentException("report content is empty or insecure"));
		}
		// store the report content
		$this->reportContent = $newReportContent;
	}
	/**
	 * mutator method for report date
	 *
	 * @param DateTime|string|null $newReportDate report date as a DateTime object or string (or null to load the current time)
	 * @throws InvalidArgumentException if $newReportDate is not a valid object or string
	 * @throws RangeException|Exception if $newReportDate is a date that does not exist
	 **/
	public function setReportDate($newReportDate = null): void {
		// base case: if the date is null, use the current date and time
		if($newReportDate === null) {
			$this->reportDate = new DateTime();
			return;
		}
		// store the like date using the ValidateDate trait
		try {
			$newReportDate = self::validateDateTime($newReportDate);
		} catch(InvalidArgumentException | RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->reportDate = $newReportDate;
	}
	/**
	 * inserts this report into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO report(reportId, reportBusinessId, reportProfileId, reportContent, reportDate) VALUES(:reportId, :reportBusinessId, :reportProfileId, :reportContent, :reportDate)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->reportDate->format("Y-m-d H:i:s.u");
		$parameters = ["reportId" => $this->reportId->getBytes(), "reportBusinessId" => $this->reportBusinessId->getBytes(), "reportProfileId" => $this->reportProfileId->getBytes(), "reportContent" => $this->reportContent, "reportDate" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * deletes this report from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM report WHERE reportId = :reportId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["reportId" => $this->reportId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this Report in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE report SET reportBusinessId = :reportBusinessId, reportProfileId = :reportProfileId, reportContent = :reportContent, reportDate = :reportDate WHERE reportId = :reportId";
		$statement = $pdo->prepare($query);
		$formattedDate = $this->reportDate->format("Y-m-d H:i:s.u");
		$parameters = ["reportId" => $this->reportId->getBytes(), "reportBusinessId" => $this->reportBusinessId->getBytes(), "reportProfileId" => $this->reportProfileId->getBytes(), "reportContent" => $this->reportContent, "reportDate" => $formattedDate];
		$statement->execute($parameters);
	}






	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["profileId"] = $this->reportId->toString();
		$fields["profileId"] = $this->reportBusinessId->toString();


	}
}
