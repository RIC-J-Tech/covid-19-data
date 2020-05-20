<?php
namespace RICJTech\Covid19Data;
require_once ("autoload.php");

use DateTime;
use InvalidArgumentException;
use PDO;
use Ramsey\uuid\uuid;
use RangeException;
use SPLFixedArray;
use TypeError;

/**
 * RIC-J Tech to the rescue
 * Team Awesome
 *
 * Covid-19 data project
 * This app is to rank the behavior multiple businesses exhibit following
 * the CDC guidelines or rules
 * Creating a profile class to store user profiles using the app
 *
 * @author  Opeyemi Jonah <gavrieljonah@gmail.com>
 * @version 1.0.0
 **/


class Profile implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id for this profileId; this is the primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;

	/**
	 * Profile Avatar Url
	 * @var string $profileAvatarUrl
	 **/
private $profileAvatarUrl;

	/**
	 * Profile Avatar Url
	 * @var string $profileAvatarUrl
	 **/
	private $profileActivationToken;

	/**
	 * The user's email address
	 * @var string $profileEmail
	 **/
	private $profileEmail;

	/**
	 * Profile's password
	 * @var string $profileHash
	 **/
	private $profileHash;

	/**
	 * Profile phone number
	 * @var string $profilePhone
	 **/
	private $profilePhone;

	/**
	 * Profile username
	 * @var string $profileUsername
	 **/
	private $profileUsername;


	/**
	 * Profile cloudinary Id
	 * @var string $profileCloudinaryId
	 */

	private $profileCloudinaryId;

	/**
	 * constructor for this Profile class
	 *
	 * @param uuid $newProfileId
	 * @param string $newProfileCloudinaryId
	 * @param string $newProfileAvatarUrl
	 * @param string $newProfileActivationToken
	 * @param string $newProfileEmail
	 * @param string $newProfileHash
	 * @param string $newProfilePhone
	 * @param string $newProfileUsername
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */

	public function __construct($newProfileId,$newProfileCloudinaryId,$newProfileAvatarUrl,$newProfileActivationToken,$newProfileEmail,
										 $newProfileHash,$newProfilePhone,$newProfileUsername) {
try{
			$this->setProfileId($newProfileId);
			$this->setProfileCloudinaryId($newProfileCloudinaryId);
			$this->setProfileAvatarUrl($newProfileAvatarUrl);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfilePhone($newProfilePhone);
			$this->setProfileUsername($newProfileUsername);

}
catch(InvalidArgumentException | RangeException| \Exception | TypeError $exception) {
	$exceptionType = get_class($exception);
	throw(new $exceptionType($exception->getMessage(), 0, $exception));
}


	}

	/*Accessor for cloudinary Id
	 * Profile Cloudinary Id
	 *
	 */
	public function getProfileCloudinaryId(): ?string {
		return  $this->profileCloudinaryId;

	}


	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profile id
	 **/

	public function getProfileId(): uuid{
		return ($this->profileId);
	}

	/**
	 * accessor method for Avatar url
	 *
	 * @return string
	 **/
	/**
	 * @return string
	 */
	public function getProfileAvatarUrl(): ?string {
		return $this->profileAvatarUrl;
	}

	/**
	 * accessor method for profile's activation token
	 *
	 * @return string
	 **/

	public function getProfileActivationToken(): ?string {
		return $this->profileActivationToken;
	}

	/**
	 * accessor method for profile email
	 *
	 * @return string value of email
	 **/

	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string value of profile hash
	 **/

	public function getProfileHash(): string {
		return $this->profileHash;
	}

	/**
	 * accessor method for profile phone number
	 *
	 * @return string value of profile phone number
	 **/
	/**
	 * @return string
	 */
	public function getProfilePhone(): string {
		return $this->profilePhone;
	}

	/**
	 * accessor method for profile username
	 *
	 * @return string value of profile username
	 **/
	/**
	 * @return string
	 */
	public function getProfileUsername(): string {
		return $this->profileUsername;
	}



	/**
	 * mutator method for tweet profile id
	 *
	 * @param string | Uuid $newProfileId new value of profile id
	 * @throws RangeException if $newProfileId is not positive
	 * @throws TypeError if $newProfileId is not a uuid or string
	 */

	public function setProfileId($newProfileId) : void {
		try{
			$uuid = self::validateUuid($newProfileId);
		} catch(InvalidArgumentException | RangeException| \Exception | TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->profileId = $uuid;
	}


	/**
	 * mutator method for tweet content
	 *
	 * @param string $newProfileAvatarUrl new value of Profile  Avatar Url
	 * @throws InvalidArgumentException if $newProfileAvatarUrl is not a string or insecure
	 * @throws RangeException if $newProfileAvatarUrl is > 255 characters
	 * @throws TypeError if $newProfileAvatarUrl is not a string
 */

	/**
	 * @param string $profileCloudinaryId
	 */
	public function setProfileCloudinaryId($newProfileCloudinaryId): void {
		try {
			// Making sure there are no whitespaces
			$newProfileCloudinaryId = trim($newProfileCloudinaryId);
			$newProfileCloudinaryId = filter_var($newProfileCloudinaryId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

			// verify the avatar URL will fit in the database
			if(strlen($newProfileCloudinaryId) > 256) {
				throw(new RangeException("image content too large"));
			}
		}

		catch(InvalidArgumentException | RangeException | \Exception | TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}


		$this->profileCloudinaryId = $newProfileCloudinaryId;
	}


	/**
	 * mutator method for tweet content
	 *
	 * @param string $newProfileAvatarUrl new value of Profile  Avatar Url
	 * @throws InvalidArgumentException if $newProfileAvatarUrl is not a string or insecure
	 * @throws RangeException if $newProfileAvatarUrl is > 255 characters
	 * @throws TypeError if $newProfileAvatarUrl is not a string
 */

	public function setProfileAvatarUrl(?string $newProfileAvatarUrl): void {
		try {
		// Making sure there are no whitespaces
		$newProfileAvatarUrl = trim($newProfileAvatarUrl);
		$newProfileAvatarUrl = filter_var($newProfileAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the avatar URL will fit in the database
		if(strlen($newProfileAvatarUrl) > 255) {
			throw(new RangeException("image content too large"));
		}
	} catch(InvalidArgumentException | RangeException | \Exception | TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}

		// store the image cloudinary content
		$this->profileAvatarUrl = $newProfileAvatarUrl;
	}

	/**
	 * mutator method for Activation Token
	 *
	 * * @throws TypeError if $newProfileActivation is not a string
	 * @throws InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws RangeException if $newTweetDate is a date that does not exist
	 **/

	/**
	 * @param string $newProfileActivationToken
	 */
	public function setProfileActivationToken(?string $newProfileActivationToken): void {

		try{
			if($newProfileActivationToken === null){
				$this->profileActivationToken = null;
				return;
			}

			//verifying field is not empty
			if(ctype_xdigit($newProfileActivationToken)===false){

				throw (new \InvalidArgumentException("Not taken"));
			}

			//Making sure the input matches the database character length
			if (strlen($newProfileActivationToken)!==32){
				throw (new RangeException("Must be of 32 characters"));
			}


		}
		catch(\InvalidArgumentException | RangeException | RangeException | \Exception | TypeError $exception){

			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));
		}

		//store object value based on new input from a user

		$this->profileActivationToken = $newProfileActivationToken;
	}



	/**
	 * mutator method for profile email
	 *@throws TypeError if $newProfileEmail is not a string
	 	 * @throws InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws RangeException if $newProfileEmail is a date that does not exist
	 **/

	/**
	 * @param string $newProfileEmail
	 */
	public function setProfileEmail(string $newProfileEmail): void {
		try{
				//verify the email is secure
			$newProfileEmail = trim($newProfileEmail);
			$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL,FILTER_FLAG_EMAIL_UNICODE);

			//CHECK TO SEE IF EMAIL IS EMPTY
			if (empty($newProfileEmail)===true){
				throw (new \InvalidArgumentException("Profile email is empty or insecure"));
			}

			//verify the email will fit the database
			if (strlen($newProfileEmail)>128){
				throw (new RangeException("Email is too long"));
			}

		}
catch(\InvalidArgumentException | RangeException | \Exception | TypeError $exception){
			$exceptionType =get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));

}
		//store object value based on new input from a user
		$this->profileEmail = $newProfileEmail;
	}


	/**
	 * mutator method for profile hash
	 *@throws TypeError if $newProfileHash is not a string
	 	 * @throws InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws RangeException if $newProfileHash is a date that does not exist
	 **/

	/**
	 * @param string $newProfileHash
	 */
	public function setProfileHash($newProfileHash): void {
		try{
			//enforce that the hash is properly formatted
			$newProfileHash = trim($newProfileHash);
			if(empty($newProfileHash)===true){
				throw (new \InvalidArgumentException("Not a valid hash"));
			}

			//enforce the hash is really an Argon hash
			$profileHashInfo = password_get_info($newProfileHash);
			if($profileHashInfo["algoName"]!=="argon2i"){
				throw (new \InvalidArgumentException("profile hash is not a valid hash"));
			}

			//enforce that hash is exactly 97 characters
			if(strlen($newProfileHash)>97){
				throw (new RangeException("Hash range is out of bound must be 97 characters"));
			}

		}
		catch(\InvalidArgumentException | RangeException | \Exception | TypeError $exception){
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));
		}

//store object value based on new input from a user
		$this->profileHash = $newProfileHash;
	}

	/**
	 * mutator method for profile phone number
	 *@throws TypeError if $newProfilePhone is not a string
	 	 * @throws InvalidArgumentException if $newProfilePhone is not a valid object or string
	 * @throws RangeException if $newProfilePhone is a date that does not exist
	 **/
	/**
	 * @param string $newProfilePhone
	 */
	public function setProfilePhone(?string $newProfilePhone): void {
		try {
			//if $profilePhone is null return it right away
			if($newProfilePhone === null) {
				$this->profilePhone = null;
				return;
			}
			// verify the phone is secure
			$newProfilePhone = trim($newProfilePhone);
			$newProfilePhone = filter_var($newProfilePhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfilePhone) === true) {
				throw(new \InvalidArgumentException("profile phone is empty or insecure"));
			}
			// verify the phone will fit in the database
			if(strlen($newProfilePhone) > 32) {
				throw(new RangeException("profile phone is too large"));
			}

		}
		catch(\InvalidArgumentException | RangeException | \Exception | TypeError $exception){
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));
		}

		// store the phone
		$this->profilePhone = $newProfilePhone;
	}

	/**
	 * mutator method for tweet date
	 *
	 * @throws TypeError if $newProfileUsername is not a string
	 	 * @throws InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws RangeException if $newProfileUsername is a date that does not exist
	 **/

	/**
	 * @param string $newProfileUsername
	 */
	public function setProfileUsername(string $newProfileUsername) {
		try {


			// verify the at handle is secure
			$newProfileUsername = trim($newProfileUsername);
			$newProfileUsername = filter_var($newProfileUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfileUsername) === true) {
				throw(new \InvalidArgumentException("profile at handle is empty or insecure"));
			}
			// verify the at handle will fit in the database
			if(strlen($newProfileUsername) > 32) {
				throw(new RangeException("profile at handle is too large"));
			}
		}
		catch(\InvalidArgumentException | RangeException | \Exception | TypeError $exception){
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));
		}
		// store the at username
		$this->profileUsername = $newProfileUsername;
	}

	/**
	 * inserts profiles into database
	 * @param \PDO $pdo connection object
	 * @throws  \PDOException when mySQL related errors occur
	 * @throws TypeError if $pdo is not a PDO connection object
	 */

public function insert(\PDO $pdo): void{
	//create query template
	$query = "INSERT INTO profile(profileId,profileCloudinaryId,profileAvatarUrl,profileActivationToken,
					profileEmail, profileHash,profilePhone, profileUsername) VALUES(:profileId,:profileCloudinaryId,:profileAvatarUrl,:profileActivationToken,
					:profileEmail, :profileHash,:profilePhone, :profileUsername)";

	$statement = $pdo->prepare($query);

	//binding table attributes to the placeholders
	$parameters = ["profileId"=>$this->profileId->getBytes(),"profileCloudinaryId"=>$this->profileCloudinaryId,
						"profileAvatarUrl"=>$this->profileAvatarUrl,"profileActivationToken"=>$this->profileActivationToken,"profileEmail"=>$this->profileEmail,"profileHash"=>
	$this->profileHash, "profilePhone"=>$this->profilePhone,"profileUsername"=>$this->profileUsername];

	$statement->execute($parameters);
}


	/**
	 * deletes this attribute from mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws TypeErrorif $pdo is not a PDO connection object
	 */

public function delete(\PDO $pdo): void{
	//create a query
	$query = "DELETE FROM profile WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	//binding parameters to placeholders
	$parameters = ["profileId"=>$this->profileId->getBytes()];
	$statement->execute($parameters);

}
	/**
	 * updates attribute into mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws TypeError if $pdo is not a PDO connection object
	 */

	public function update(\PDO $pdo): void{
		//create query template
		$query =  "UPDATE profile SET
						profileCloudinaryId = :profileCloudinaryId,
						profileAvatarUrl = :profileAvatarUrl,
						profileActivationToken = :profileActivationToken,
						profileEmail = :profileEmail,
						profileHash = :profileHash,
						profilePhone = :profilePhone,
						profileUsername = :profileUsername
						
						WHERE profileId = :profileId";

		//prepare the query with PDO
		$statement = $pdo->prepare($query);

		//bind parameters to placeholders
		$parameter = ["profileId"=>$this->profileId->getBytes(),
							"profileCloudinaryId"=>$this->profileCloudinaryId,
							"profileAvatarUrl"=>$this->profileAvatarUrl,
							"profileActivationToken"=>$this->profileActivationToken,
							"profileEmail"=>$this->profileEmail,
							"profileHash"=>$this->profileHash,
							"profilePhone"=>$this->profilePhone,
							"profileUsername"=>$this->profileUsername];

							$statement->execute($parameter);
	}

	/**
	 * pulls username from profile
	 * @param string $profileUsername
	 * @param \PDO $pdo PDO connection object
	 * @return SplFixedArray SplFixedArray of profile found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws TypeError if $pdo is not a PDO connection object
	 *
	 */
public static function getProfileByUsername(\PDO $pdo, string $profileUsername) : ?Profile{
	//create query

	$query = "SELECT profileId,profileCloudinaryId,profileAvatarUrl,
				profileActivationToken,profileEmail,
				profileHash, profilePhone,
				profileUsername
				FROM profile
				 WHERE profileUsername = :profileUsername";

	//prepare statement
	$statement=$pdo->prepare($query);


	// bind the parameters username to the placeholder in the template
	//$profileUsername = "%$profileUsername%"; //searches for any character similar either from the left or right

	$parameters = ["profileUsername"=>$profileUsername];
	$statement->execute($parameters);

	try {

		//build an array of profiles
//		$profile = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			//instantiate profile object and push data into it
			$profile = new Profile($row["profileId"],
				$row["profileCloudinaryId"],
				$row["profileAvatarUrl"],
				$row["profileActivationToken"],
				$row["profileEmail"],
				$row["profileHash"],
				$row["profilePhone"],
				$row["profileUsername"]);
		}
	}
		catch(\Exception $exception){
			throw (new \PDOException($exception->getMessage(),0,$exception));
		}

return ($profile);

}

	/**
	 * pulls single data from profile by Id
	 * @param uuid|string $profileId
	 * @param \PDO $pdo PDO connection object
	 * @return SplFixedArray SplFixedArray of profile found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws TypeError if $pdo is not a PDO connection object
	 *
	 */

	public static function getProfileByProfileId(\PDO $pdo, $profileId): ?Profile{
		//create query template
		$query = "SELECT profileId,
					profileCloudinaryId,
					profileAvatarUrl,
					profileActivationToken,
					profileEmail,
					profileHash,
					profilePhone,
					profileUsername
					FROM profile WHERE profileId = :profileId";

		//prepare query
		$statement = $pdo->prepare($query);

		try{
			$profileId = self::validateUuid($profileId);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			throw (new \PDOException($exception->getMessage(),0,$exception));
		}
		//bind parameters to placeholders in the table
		$parameter = [ "profileId"=>$profileId->getBytes()];
		$statement->execute($parameter);

		//grab profile from database

			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false){
				//instantiate profile object and push data into it
				$profile = new Profile($row["profileId"],
				$row["profileCloudinaryId"],
					$row["profileAvatarUrl"],
					$row["profileActivationToken"],
					$row["profileEmail"],
					$row["profileHash"],
					$row["profilePhone"],
					$row["profileUsername"]);
			}
			return ($profile);
	}

	/**
	 * gets profile by Email from mySQL
	 * @param PDO $pdo PDO connection object
	 * @param string $profileEmail
	 * @return Profile
	 */

	public static function getProfileByEmail(\PDO $pdo, string $profileEmail): Profile{
		//create query template
		$query = "SELECT profileId,
					profileCloudinaryId,
					profileAvatarUrl,
					profileActivationToken,
					profileEmail,
					profileHash,
					profilePhone,
					profileUsername FROM profile WHERE profileEmail = :profileEmail";
		//prepare query
		$statement = $pdo->prepare($query);

		//bind the object to their respective placeholders in the database
		$parameters=["profileEmail"=>$profileEmail];
		$statement->execute($parameters);

		//grab profile from database
		$profile = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if ($row !== false){
			//instantiate profile and push data into it
			$profile = new Profile($row["profileId"],
				$row["profileCloudinaryId"],
				$row["profileAvatarUrl"],
				$row["profileActivationToken"],
				$row["profileEmail"],
				$row["profileHash"],
				$row["profilePhone"],
				$row["profileUsername"]);
		}
		return ($profile);
		}

/*
 *
 *  gets profile by Activation Token from mySQL
	 * @param PDO $pdo PDO connection object
	 * @param string $profileActivationToken
	 * @return Profile
 *
 */
	public static function getProfileByActivationToken(\PDO $pdo, string $profileActivationToken): ?Profile{
		//make sure activation token is in the right format and that it is a string representation of a hexadecimal
		$profileActivationToken = trim($profileActivationToken);
		if(ctype_xdigit($profileActivationToken) === false) {
			throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}
		//create query template
		$query = "SELECT profileId,
					profileCloudinaryId,
					profileAvatarUrl,
					profileActivationToken,
					profileEmail,
					profileHash,
					profilePhone,
					profileUsername FROM profile WHERE profileActivationToken = :profileActivationToken";
		//prepare query
		$statement = $pdo->prepare($query);

		//bind the object to their respective placeholders in the database
		$parameters=["profileActivationToken"=>$profileActivationToken];
		$statement->execute($parameters);

try {
	//grab profile from database
	$profile = null;
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	$row = $statement->fetch();
	if($row !== false) {
		//instantiate profile and push data into it
		$profile = new Profile($row["profileId"],
			$row["profileCloudinaryId"],
			$row["profileAvatarUrl"],
			$row["profileActivationToken"],
			$row["profileEmail"],
			$row["profileHash"],
			$row["profilePhone"],
			$row["profileUsername"]);
	}
}
catch(\Exception $exception) {
	// if the row couldn't be converted, rethrow it
	throw(new \PDOException($exception->getMessage(), 0, $exception));
}
		return ($profile);
	}


public function getAllProfiles(\PDO $pdo): SplFixedArray{


	// create query template
	$query = "SELECT profileId, profileCloudinaryId,profileAvatarUrl, profileActivationToken, profileEmail, profileHash, profilePhone,profileUsername 
						FROM profile";
	$statement = $pdo->prepare($query);
	$statement->execute();

	$profiles = new SPLFixedArray($statement->rowCount());

	$statement->setFetchMode(\PDO::FETCH_ASSOC);

	while (($row = $statement->fetch()) !== false) {
		try {
			$profile = new Profile($row["profileId"],$row["profileCloudinaryId"] ,$row["profileAvatarUrl"],$row["profileActivationToken"] , $row["profileEmail"], $row["profileHash"],$row["profilePhone"], $row["profileUsername"]);
			$profiles[$profiles->key()] = $profile;
			$profiles->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($profiles);
}



	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		 var_dump($this);
		$fields = get_object_vars($this);

		$fields["profileId"] = $this->profileId->toString();
		unset($fields["profileActivationToken"]);
		unset($fields["profileHash"]);
		return ($fields);

	}
}
