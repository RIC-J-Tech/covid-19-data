<?php
<<<<<<< HEAD

=======
>>>>>>> 0b16a38... added correct business class
namespace RICJTech\Covid19Data;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");
use Ramsey\uuid\uuid;
<<<<<<< HEAD
use RangeException;
use SplFixedArray;
use TypeError;

class Business implements JsonSerializable {
	use ValidateDate;
=======
class Business implements \JsonSerializable {
>>>>>>> 0b16a38... added correct business class
	use ValidateUuid;
	private $businessId;
	private $businessLng;
	private $businessLat;
	private $businessName;
	private $businessUrl;
	private $businessYelpId;
	public function __construct($newBusinessId, string $newBusinessYelpId, $newBusinessLng, $newBusinessLat, string $newBusinessName, string $newBusinessUrl) {
		try {
			$this->setBusinessId($newBusinessId);
			$this->setBusinessYelpId($newBusinessYelpId);
			$this->setBusinessLng($newBusinessLng);
			$this->setBusinessLat($newBusinessLat);
			$this->setBusinessName($newBusinessName);
			$this->setBusinessUrl($newBusinessUrl);
		} catch(\InvalidArgumentException | \RangeException| \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	public function getBusinessId():Uuid {
		return $this->businessId;
	}
	public function setBusinessId($newBusinessId): void {
		try {
			$uuid = self::validateUuid($newBusinessId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->businessId = $uuid;
	}
	public function getBusinessLng() {
		return $this->businessLng;
	}
	public function setBusinessLng($newBusinessLng): void {
		try {
			$newBusinessLng = filter_var($newBusinessLng, FILTER_VALIDATE_FLOAT);
		} catch(\TypeError $exception) {
			throw(new \TypeError("Business longitude value is an invalid data type"));
		}
		$this->businessLng = $newBusinessLng;
	}
	public function getBusinessLat() {
		return $this->businessLat;
	}
	public function setBusinessLat($newBusinessLat)  {
		try {
			$newBusinessLat = filter_var($newBusinessLat, FILTER_VALIDATE_FLOAT);
		} catch(\TypeError $exception) {
			throw(new \TypeError("Business latitude value is an invalid data type"));
		}
		$this->businessLat = $newBusinessLat;
	}
	public function getBusinessName():string {
		return $this->businessName;
	}
	public function setBusinessName(string $newBusinessName) {
		$newBusinessName = filter_var($newBusinessName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newBusinessName) === true) {
			throw(new \InvalidArgumentException("Business name is empty or insecure"));
		}
		if(strlen($newBusinessName) > 128) {
			throw(new \RangeException("Business name is longer than 128 characters"));
		}
		$this->businessName = $newBusinessName;
	}
	public function getBusinessUrl():string {
		return $this->businessUrl;
	}
	public function setBusinessUrl(string $newBusinessUrl) {
		try {
			$newBusinessUrl = filter_var($newBusinessUrl, FILTER_VALIDATE_URL);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		if(strlen($newBusinessUrl) > 256) {
			throw(new \RangeException("Yelp url is longer than 255 characters"));
		}
		$this->businessUrl = $newBusinessUrl;
	}
	/**
	 * @return mixed
	 */
	public function getBusinessYelpId():string {
		return $this->businessYelpId;
	}
	public function setBusinessYelpId(string $newBusinessYelpId) {
		if(strlen($newBusinessYelpId) > 32) {
			throw(new \RangeException("Yelp Id is longer than 32 characters."));
		}
		$this->businessYelpId = $newBusinessYelpId;
	}
	public function insert(\PDO $pdo): void {
		$query = "INSERT INTO business(businessId,businessYelpId,businessLng,businessLat,businessName,
          businessUrl) VALUES(:businessId,:businessYelpId,:businessLng,:businessLat,:businessName,
          :businessUrl)";
		$statement = $pdo->prepare($query);
		$parameters = ["businessId" => $this->businessId->getBytes(), "businessYelpId" => $this->businessYelpId, "businessLng" => $this->businessLng,
			"businessLat" => $this->businessLat, "businessName" => $this->businessName, "businessUrl" =>
				$this->businessUrl];
		$statement->execute($parameters);
	}
	public function delete(\PDO $pdo): void {
		$query = "DELETE FROM business WHERE businessId = :businessId";
		$statement = $pdo->prepare($query);
		$parameters = ["businessId" => $this->businessId->getBytes()];
		$statement->execute($parameters);
	}
	public function update(\PDO $pdo): void {
		$query = "UPDATE business SET
            businessYelpId = :businessYelpId,
            businessLng = :businessLng,
            businessLat = :businessLat,
            businessName = :businessName,
            businessUrl = :businessUrl
            WHERE businessId = :businessId";
		$statement = $pdo->prepare($query);
		$parameter = ["businessId" => $this->businessId->getBytes(),
			"businessYelpId" => $this->businessYelpId,
			"businessLng" => $this->businessLng,
			"businessLat" => $this->businessLat,
			"businessName" => $this->businessName,
			"businessUrl" => $this->businessUrl];
		$statement->execute($parameter);
	}
	public static function getBusinessByBusinessId(\PDO $pdo, $businessId): ?Business {
		try {
			$businessId = self::validateUuid($businessId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		$query = "SELECT businessId, businessYelpId, businessLng, businessLat, businessName, businessUrl FROM business WHERE businessId = :businessId";
		$statement = $pdo->prepare($query);
		$parameters = ["businessId" => $businessId->getBytes()];
		$statement->execute($parameters);
		try {
			$business = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$business = new Business($row["businessId"], $row["businessYelpId"], $row["businessLng"], $row["businessLat"], $row["businessName"], $row["businessUrl"]);
			}
		} catch(Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($business);
	}
	public static function getBusinessByBusinessName(\PDO $pdo, string $newBusinessName) : \SplFixedArray {
		$newBusinessName = trim($newBusinessName);
		$businessName = filter_var($newBusinessName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($businessName) === true) {
			throw(new \PDOException("business name is not valid"));
		}
		$businessName = str_replace("_", "\\_", str_replace("%", "\\%", $businessName));
		// create query template
		$query = "SELECT businessId, businessYelpId, businessLng, businessLat, businessName, businessUrl FROM business WHERE businessName LIKE :businessName";
		$statement = $pdo->prepare($query);
		$businessName = "%$businessName%";
		$parameters = ["businessName" => $businessName];
		$statement->execute($parameters);
		$businesses = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$business = new business($row["businessId"], $row["businessYelpId"], $row["businessLng"], $row["businessLat"], $row["businessName"], $row["businessUrl"]);
				$businesses[$businesses->key()] = $business;
				$businesses->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($businesses);
	}
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["businessId"] = $this->businessId->toString();
		$fields["businessYelpId"] = round(floatval($this->businessYelpId->format("")) * 1000);
		$fields["businessLng"] = round(floatval($this->businessLng->format("")) * 1000);
		$fields["businessLat"] = round(floatval($this->businessLat->format("")) * 1000);
		$fields["businessName"] = $this->businessName->toString();
		$fields["businessUrl"] = $this->businessUrl->toString();
		return ($fields);
	}
}