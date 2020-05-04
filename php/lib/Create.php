<?php

namespace RICJTech\Covid19Data;
use RICJTech\Covid19Data\{Profile, Business, Report};
use Ramsey\Uuid\Uuid;
use Faker;

require_once (dirname(__DIR__, 2)."Classes/autoload.php");
require_once ("uuid.php");

$faker = Faker\Factory::create();

$password =$faker->password;

$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I,["time_cost"=>45]);
$this->VALID_ACTIVATION_TOKEN= bin2hex(random_bytes(16));
$this->VALID_PROFILE_EMAIL = $faker->email;
$this->VALID_PROFILE_PHONE = $faker->phoneNumber;
$this->VALID_CLOUDINARY_ID = "astrongIdcloud";
$this->VALID_AVATAR_URL = $faker->url;
$this->VALID_PROFILE_USERNAME = $faker->userName;

$this->VALID_BUSINESS_YELP = ($faker->uuid)->toString;
$this->VALID_BUSINESS_LNG =$faker->longitude;
$this->VALID_BUSINESS_LAT = $faker->latitude;
$this->VALID_BUSINESS_NAME = $faker->name;
$this->VALID_BUSINESS_URL= $faker->url;

$this->VALID_CLOUDINARY_ID ="astrongIdcloud";
$this->VALID_REPORT_DATE =null;
$this->VALID_REPORT_CONTENT="some random report of nuisance";
$this->VALID_REPORT_CONTENT2;

$reportId = generateUuidV4()->toString();
$this->VALID_REPORT_DATE=$faker->dateTime;
$this->VALID_REPORT_CONTENT = $faker->text;

$profile = new Profile(
	generateUuidV4()->toString(), $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,$this->VALID_ACTIVATION_TOKEN,
	$this->VALID_PROFILE_EMAIL=$faker->email,$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_PHONE=$faker->phoneNumber,
	$this->VALID_PROFILE_USERNAME=$faker->userName);

$business = new Business(generateUuidV4()->toString(),$this->VALID_BUSINESS_YELP,$this->VALID_BUSINESS_LNG,$this->VALID_BUSINESS_LAT
,$this->VALID_BUSINESS_NAME,$this->VALID_BUSINESS_URL);


$report = new Report($reportId,$this->business->getBusinessId()->toString(),$this->profile->getProfileId()->toString(),
	$this->VALID_REPORT_CONTENT, $this->VALID_REPORT_DATE);

