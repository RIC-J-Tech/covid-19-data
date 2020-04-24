<?php
namespace OpeyemiJonah\ObjectOriented;
require_once ("autoload.php");

use DateTime;
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
			$this->setReport($newReportContent);
			$this->setReportDate($newReportDate);

	}
	catch(InvalidArgumentException | \RangeException| \Exception | \TypeError $exception) {
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
	 * @param $reportId
	 */

	public function setReportId(){

	}
	/**
	 * @param uuid $reportBusinessId
	 */
	public function setReportBusinessId(uuid $reportBusinessId): void {
		$this->reportBusinessId = $reportBusinessId;
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