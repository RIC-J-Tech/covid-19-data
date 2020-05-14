<?php
namespace RICJTech\Covid19Data;
require_once ("autoload.php");

use DateTime;
use Exception;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use RangeException;
use SplFixedArray;
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
public function __construct($newReportId, $newReportBusinessId,$newReportProfileId, string $newReportContent, \DateTime $newReportDate) {
	try{
			$this->setReportId($newReportId);
			$this->setReportBusinessId($newReportBusinessId);
			$this->setReportProfileId($newReportProfileId);
			$this->setReportContent($newReportContent);
			$this->setReportDate($newReportDate);

	}
	catch(InvalidArgumentException | RangeException| Exception | TypeError $exception) {
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

	public function getReportProfileId(): Uuid{
		return $this->reportProfileId;
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
	 * @throws TypeError if $newReportId is not a uuid or string
	 **/
	public function setReportId($newReportId): void {
		try {
			$uuid = self::validateUuid($newReportId);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
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
	 * @throws TypeError if $newReportBusinessId is not an integer
	 **/
	public function setReportBusinessId($newReportBusinessId): void {
		try {
			$uuid = self::validateUuid($newReportBusinessId);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
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
	 * @throws TypeError if $newReportProfileId is not an integer
	 **/
	public function setReportProfileId($newReportProfileId): void {
		try {
			$uuid = self::validateUuid($newReportProfileId);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
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
	 * @throws TypeError if $newReportContent is not a string
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
	 * @throws TypeError if $pdo is not a PDO connection object
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
	 * @throws TypeError if $pdo is not a PDO connection object
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
	 * @throws TypeError if $pdo is not a PDO connection object
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
	 * Retrieves report from database using the profileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param $reportProfileId
	 * @return SplFixedArray SplFixedArray of reports found
	 *
	 */

public function getReportByProfileId(\PDO $pdo, $reportProfileId): SplFixedArray{

	//create query template
	$query = "SELECT * FROM report WHERE reportProfileId = :reportProfileId ";
	$statement = $pdo->prepare($query);

	try {
		$reportProfileId = self::validateUuid($reportProfileId);

	}
	catch(\InvalidArgumentException | \RangeException | \Exception | TypeError $exception){
		$exceptionType = get_class($exception);
		throw (new $exceptionType($exception->getMessage(),0,$exception));
	}

	//bind the object to their respective  placeholders in the table
	$parameters = ["reportProfileId"=>$reportProfileId->getBytes()];
	$statement->execute($parameters);

	//build an array of reports
	$reports = new SplFixedArray($statement->rowCount());

	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch())!== false){
		try {
			//instantiate report object and push data into it
			$report = new Report($row["reportId"],
				$row["reportBusinessId"],
				$row["reportProfileId"],
				$row["reportContent"],
				new \DateTime($row["reportDate"]));
			$reports[$reports->key()] = $report;
			$reports->next();

		}
		catch(\Exception $exception){
			throw (new \PDOException($exception->getMessage(),0,$exception));
		}


	}

return $reports;
}

	/**
	 * Retrieves report from database using the businessId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param $reportBusinessId
	 * @return SplFixedArray
	 */
public static function getReportByBusinessId(\PDO $pdo, $reportBusinessId): ?Report {

	try {
		$reportBusinessId = self::validateUuid($reportBusinessId);

	} catch(\InvalidArgumentException | \RangeException | \Exception | TypeError $exception) {
		$exceptionType = get_class($exception);
		throw (new $exceptionType($exception->getMessage(), 0, $exception));
	}

//create query template
	$query = "SELECT * FROM report WHERE reportBusinessId = :reportBusinessId ";
	$statement = $pdo->prepare($query);

	//bind the object to their respective  placeholders in the table
	$parameters = ["reportBusinessId" => $reportBusinessId->getBytes()];
	$statement->execute($parameters);

	try {
		//build an array of reports
		$reports = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			//instantiate profile object and push data into it
			$report = new Report($row["reportId"],
				$row["reportBusinessId"],
				$row["reportProfileId"],
				$row["reportContent"],
				new \DateTime($row["reportDate"]));
		}
		}
	catch(\InvalidArgumentException | \RangeException | \Exception | TypeError $exception){
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}

	return ($reports);
}

	/**
	 * Retrieves report from database using the businessId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param $reportId
	 * @return SplFixedArray
	 */

public static function getReportByReportId(\PDO $pdo, $reportId): ?Report{
	//sanitize the reportId before searching
	try {
		$reportId = self::validateUuid($reportId);
	}
	catch(\InvalidArgumentException | \RangeException | \Exception | TypeError $exception){
		throw (new \PDOException($exception->getMessage(),0,$exception));
	}
	//create query template
	$query = "SELECT * FROM report WHERE reportId= :reportId";
	$statement = $pdo->prepare($query);

	//bind objects to placeholders
	$parameters = ["reportId"=>$reportId->getBytes()];
	$statement->execute($parameters);

	//grab report from mySQL
	try {
		$report = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false){
				$report = new Report($row["reportId"],
											$row["reportBusinessId"],
											$row["reportProfileId"],
											$row["reportContent"],
											new \DateTime($row["reportDate"]));

		}

	}catch(\InvalidArgumentException | \RangeException | \Exception | TypeError $exception){
		throw (new \PDOException($exception->getMessage(),0,$exception));
	}
	return $report;

}

	/**
	 * Gets all reports posted on the calendar day of a given DateTime.
	 *
	 * @param \PDO $pdo The database connection object
	 * @param DateTime $reportDate The date on which to search for reports
	 * @return \SplFixedArray An array of report object that match the date.
	 * @throws \PDOException|Exception mySQL related errors being caught
	 */

	public static function getReportsByReportDate(\PDO $pdo, DateTime $reportDate): \SplFixedArray{

		//create dates for midnight of the date and midnight of the next day.
		//$startDateString = $reportDate->format('Y-m-d').'00:00:00';

		$endDate = $reportDate;
		$endDateString = $endDate->format('Y-m-d') . ' 00:00:00'; //get datepart only
		$startDate = new DateTime($endDateString); //initialize start date
		$startDate->sub(new \DateInterval('P30D')); //subtract 30 days.

		//create query template
		$query = "SELECT * FROM report WHERE reportDate >= :startDate AND reportDate <= :endDate";
		$statement = $pdo->prepare($query);

		//Bind the beginning and end dates to their placeholders in the template
		$parameters = [
			'startDate' => $startDate->format('Y-m-d H:i:s.u'),
			'endDate'=>$endDate->format('Y-m-d H:i:s.u')
		];

		$statement->execute($parameters);

		//Build an array of reports from the returned rows
		$reports = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row= $statement->fetch())!==false){
			try {
				//instantiate report object and push data into it
				$report = new Report($row["reportId"],
					$row["reportBusinessId"],
					$row["reportProfileId"],
					$row["reportContent"],
					new \DateTime($row["reportDate"]));
				$reports[$reports->key()] = $report;
				$reports->next();


			}
			catch(\InvalidArgumentException | \RangeException | \Exception | TypeError $exception){
				throw (new \PDOException($exception->getMessage(),0,$exception));
			}


		}
		return $reports;

	}





	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["reportId"] = $this->reportId->toString();
		$fields["reportBusinessId"] = $this->reportBusinessId->toString();
		$fields["reportProfileId"]= $this->reportProfileId->toString();

		return($fields);

	}
}
