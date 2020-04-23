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
	 * @var string $report
	 */

private $report;

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