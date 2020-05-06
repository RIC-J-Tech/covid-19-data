<?php

namespace RICJTech\Covid19Data\Test;
use RICJTech\Covid19Data\{Profile, Business, Report};
use Ramsey\Uuid\Uuid;
use Faker;
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


trait setUpTest {


	private static function createProfile(): ?Profile {


		$faker = Faker\Factory::create();
		$password = $faker->password;

		$VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 45]);
		$VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
		$VALID_PROFILE_EMAIL = $faker->email;
		$VALID_PROFILE_PHONE = $faker->phoneNumber;
		$VALID_CLOUDINARY_ID = "astrongIdcloud";
		$VALID_AVATAR_URL = $faker->url;
		$VALID_PROFILE_USERNAME = $faker->userName;

		$profile = new Profile(
			generateUuidV4()->toString(), $VALID_CLOUDINARY_ID, $VALID_AVATAR_URL, $VALID_ACTIVATION_TOKEN,
			$VALID_PROFILE_EMAIL, $VALID_PROFILE_HASH, $VALID_PROFILE_PHONE,
			$VALID_PROFILE_USERNAME);

		return $profile;

	}


private static function createBusiness(): ?Business{
		$faker = Faker\Factory::create();

		$VALID_BUSINESS_YELP= $faker->phoneNumber;
$VALID_BUSINESS_LNG = $faker->longitude;
$VALID_BUSINESS_LAT = $faker->latitude;
$VALID_BUSINESS_NAME = $faker->name;
$VALID_BUSINESS_URL = $faker->url;
		$business = new Business(generateUuidV4()->toString(), $VALID_BUSINESS_YELP, $VALID_BUSINESS_LNG, $VALID_BUSINESS_LAT
,$VALID_BUSINESS_NAME, $VALID_BUSINESS_URL);

		return $business;
}


private static function createReport(): Report{
	$faker = Faker\Factory::create();

	$VALID_CLOUDINARY_ID = "astrongIdcloud";
$VALID_REPORT_DATE = null;
$VALID_REPORT_CONTENT = "some random report of nuisance";
$VALID_REPORT_CONTENT2 = $faker->text;

$reportId = generateUuidV4()->toString();
$VALID_REPORT_DATE = $faker->dateTime;
$VALID_REPORT_CONTENT = $faker->text;
$profile = self::createProfile();
$business = self::createBusiness();


$report = new Report($reportId, $business->getBusinessId()->toString(), $profile->getProfileId()->toString(),
$VALID_REPORT_CONTENT, $VALID_REPORT_DATE);

return $report;
}


}