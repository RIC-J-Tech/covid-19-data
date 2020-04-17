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
	 * constructor for this Tweet
	 *
	 * @param $newProfileId
	 * @param $newProfileAvatarUrl
	 * @param $newProfileActivationToken
	 * @param $newProfileEmail
	 *  @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php

	 */

	public function __construct($newProfileId,$newProfileAvatarUrl,$newProfileActivationToken,$newProfileEmail,
										 $newProfielHash,$newProfilePhone,$newProfileUsername) {


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