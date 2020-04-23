<?php
namespace RICJTech\Covid19;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/*
 * This is the Author class
 */
class Behavior implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

//behaviorId BINARY(16) NOT NULL,
//behaviorBusinessId BINARY(16) NOT NULL,
//behaviorProfileId BINARY(16) NOT NULL,
//behaviors TEXT NOT NULL,
//behaviorDate DATETIME(6) NOT NULL,
//INDEX(behaviorBusinessId),
//INDEX(behaviorProfileId),
//FOREIGN KEY(behaviorBusinessId) REFERENCES business(businessId),
//FOREIGN KEY(behaviorProfileId) REFERENCES profile(profileId),
//PRIMARY KEY(behaviorId)

//authorId binary(16) not null,
//authorActivationToken char(32),
//authorAvatarUrl varchar(255),
//authorEmail varchar(128) not null,
//authorHash char(97) not null,
//authorUsername varchar(32) not null,

	/*
	 * id for this primary key
 	* @var Uuid behaviorId
 	*/
	private $behaviorId;

	/*
	 * id for this foreign key
 	* @var Uuid behaviorBusinessId
 	*/
	private $behaviorBusinessId;

	/*
	 * id for this foreign key
 	* @var Uuid behaviorProfileId
 	*/
	private $behaviorProfileId;

	/*
	 * content for this behavior
	 */
	private $behaviors;

	/*
	 * Date and time this behavior was posted
	 */
	private $behaviorDate;







	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();
		$fields["authorActivationToken"] = $this->authorActivationToken->toString();
		$fields["authorAvatarUrl"] = $this->authorAvatarUrl->toString();
		$fields["authorEmail"] = $this->authorEmail->toString();
		$fields["authorHash"] = $this->authorHash->toString();
		$fields["authorUsername"] = $this->authorUserName->toString();

		return ($fields);
	}
}
