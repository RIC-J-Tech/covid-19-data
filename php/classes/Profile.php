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
 *
 * @author Opeyemi Jonah <gavrieljonah@gmail.com>
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
	 * constructor for this Profile class
	 *
	 * @param uuid $newProfileId
	 * @param string $newProfileAvatarUrl
	 * @param string $newProfileActivationToken
	 * @param string $newProfileEmail
	 * @param string $newProfielHash
	 * @param string $newProfilePhone
	 * @param string $newProfileUsername
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */

	public function __construct($newProfileId,$newProfileAvatarUrl,$newProfileActivationToken,$newProfileEmail,
										 $newProfielHash,$newProfilePhone,$newProfileUsername) {

										$this->setProfileId($newProfileId);
										$this->setProfileAvatarUrl($newProfileAvatarUrl);
										$this->setProfileActivationToken($newProfileActivationToken);
										$this->setProfileEmail($newProfileEmail);
										$this->setProfileHash($newProfielHash);
										$this->setProfilePhone($newProfilePhone);
										$this->setProfileUsername($newProfileUsername);

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

	/**
	 * @return string
	 */
	public function getProfileActivationToken(): ?string {
		return $this->profileActivationToken;
	}

	/**
	 * accessor method for profile email
	 *
	 * @return string value of email
	 **/
	/**
	 * @return string
	 */
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * accessor method for profile password
	 *
	 * @return string value of profile password
	 **/
	/**
	 * @return string
	 */
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
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not a uuid or string
	 */

	public function setProfileId($newProfileId) : void {
		try{
			$uuid = self::validateUuid($newProfileId);
		} catch(InvalidArgumentException | \RangeException| \Exception | \TypeError $exception) {
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
	 * @throws \RangeException if $newProfileAvatarUrl is > 255 characters
	 * @throws \TypeError if $newProfileAvatarUrl is not a string

	 */

	public function setProfileAvatarUrl(?string $newProfileAvatarUrl): void {
		try {
		// Making sure there are no whitespaces
		$newProfileAvatarUrl = trim($newProfileAvatarUrl);
		$newProfileAvatarUrl = filter_var($newProfileAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the avatar URL will fit in the database
		if(strlen($newProfileAvatarUrl) > 255) {
			throw(new \RangeException("image content too large"));
		}
	} catch(InvalidArgumentException | \RangeException | \Exception | TypeError $exception) {
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
	public function setProfileActivationToken(string $newProfileActivationToken): void {

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
				throw (new \RangeException("Must be of 32 characters"));
			}


		}
		catch(\InvalidArgumentException | \RangeException | \RangeException | \Exception | \TypeError $exception){

			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));
		}

		//store object value based on new input from a user

		$this->profileActivationToken = $newProfileActivationToken;
	}



	/**
	 * mutator method for profile email
	 *@throws \TypeError if $newProfileEmail is not a string
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
				throw (new \RangeException("Email is too long"));
			}

		}
catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType =get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));

}
		//store object value based on new input from a user
		$this->profileEmail = $newProfileEmail;
	}


	/**
	 * mutator method for profile hash
	 *@throws \TypeError if $newProfileHash is not a string
	 	 * @throws InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws \RangeException if $newProfileHash is a date that does not exist
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
				throw (new \RangeException("Hash range is out of bound must be 97 characters"));
			}

		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));
		}

//store object value based on new input from a user
		$this->profileHash = $newProfileHash;
	}

	/**
	 * mutator method for profile phone number
	 *@throws \TypeError if $newProfilePhone is not a string
	 	 * @throws InvalidArgumentException if $newProfilePhone is not a valid object or string
	 * @throws \RangeException if $newProfilePhone is a date that does not exist
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
				throw(new \RangeException("profile phone is too large"));
			}

		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));
		}

		// store the phone
		$this->profilePhone = $newProfilePhone;
	}

	/**
	 * mutator method for tweet date
	 *
	 * @throws \TypeError if $newProfileUsername is not a string
	 	 * @throws InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws \RangeException if $newProfileUsername is a date that does not exist
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
				throw(new \RangeException("profile at handle is too large"));
			}
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0,$exception));
		}
		// store the at username
		$this->profileUsername = $newProfileUsername;
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["profileId"] = $this->profileId->toString();


	}
}