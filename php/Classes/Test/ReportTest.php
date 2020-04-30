<?php
namespace RICJTech\Covid19Data;

use RICJTech\Covid19Data\{Profile};
use Ramsey\Uuid\Uuid;
use RICJTech\Covid19Data\DataDesignTest;
use Faker;
require_once (dirname(__DIR__). "/Test/DataDesignTest.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

class ReportTest extends DataDesignTest {
	private $VALID_ACTIVATION_TOKEN;
	private $VALID_AVATAR_URL;
	private $VALID_PROFILE_EMAIL;
	private $VALID_PROFILE_HASH;
	private $VALID_PROFILE_PHONE;
	private $VALID_PROFILE_USERNAME;






}