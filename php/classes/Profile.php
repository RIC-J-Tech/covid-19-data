<?php
namespace OpeyemiJonah\ObjectOriented;
require_once ("autoload.php");
use Ramsey\uuid\uuid;

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
	public function getProfileAvatarUrl(): string {
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
	public function getProfileActivationToken(): string {
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
		} catch(\InvalidArgumentException | \RangeException| \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->profileId = $uuid;
	}

	/**
	 * mutator method for tweet content
	 *
	 * @param string $newProfileAvatarUrl new value of Profile  Avatar Url
	 * @throws \InvalidArgumentException if $newProfileAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newProfileAvatarUrl is > 255 characters
	 * @throws \TypeError if $newProfileAvatarUrl is not a string

	 */
	public function setProfileAvatarUrl(?string $newProfileAvatarUrl) {try {
		// Making sure there are no whitespaces
		$newProfileAvatarUrl = trim($newProfileAvatarUrl);
		$newProfileAvatarUrl = filter_var($newProfileAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the avatar URL will fit in the database
		if(strlen($newProfileAvatarUrl) > 255) {
			throw(new \RangeException("image content too large"));
		}
	} catch(\InvalidArgumentException | \RangeException | \Exception | TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}

		// store the image cloudinary content
		$this->profileAvatarUrl = $newProfileAvatarUrl;
	}

	/**
	 * mutator method for tweet date
	 *
	 * @param \DateTime|string|null $newTweetDate tweet date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws \RangeException if $newTweetDate is a date that does not exist
	 **/

	/**
	 * @param string $profileActivationToken
	 */
	public function setProfileActivationToken(string $profileActivationToken) {
		$this->profileActivationToken = $profileActivationToken;
	}

	/**
	 * mutator method for tweet date
	 *
	 * @param \DateTime|string|null $newTweetDate tweet date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws \RangeException if $newTweetDate is a date that does not exist
	 **/

	/**
	 * @param string $profileEmail
	 */
	public function setProfileEmail(string $profileEmail) {
		$this->profileEmail = $profileEmail;
	}

	/**
	 * mutator method for tweet date
	 *
	 * @param \DateTime|string|null $newTweetDate tweet date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws \RangeException if $newTweetDate is a date that does not exist
	 **/

	/**
	 * @param string $profileHash
	 */
	public function setProfileHash(string $profileHash) {
		$this->profileHash = $profileHash;
	}

	/**
	 * mutator method for tweet date
	 *
	 * @param \DateTime|string|null $newTweetDate tweet date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws \RangeException if $newTweetDate is a date that does not exist
	 **/
	/**
	 * @param string $profilePhone
	 */
	public function setProfilePhone(string $profilePhone) {
		$this->profilePhone = $profilePhone;
	}

	/**
	 * mutator method for tweet date
	 *
	 * @param \DateTime|string|null $newTweetDate tweet date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws \RangeException if $newTweetDate is a date that does not exist
	 **/

	/**
	 * @param string $profileUsername
	 */
	public function setProfileUsername(string $profileUsername) {
		$this->profileUsername = $profileUsername;
	}









	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["tweetId"] = $this->tweetId->toString();
		$fields["tweetProfileId"] = $this->tweetProfileId->toString();

		//format the date so that the front end can consume it
		$fields["tweetDate"] = round(floatval($this->tweetDate->format("U.u")) * 1000);
		return($fields);
	}
}