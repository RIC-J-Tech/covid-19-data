USE ctasama;

CREATE TABLE profile(
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileAvatarUrl VARCHAR(255) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(37) NOT NULL,
	profilePhone VARCHAR(32),
	profileUsername VARCHAR(32) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileUsername),
	INDEX(profileEmail),
	PRIMARY KEY(profileId)
);


CREATE TABLE business(
   businessId BINARY(16) NOT NULL,
   businessAddress VARCHAR(128) NOT NULL,
   businessLng DECIMAL(5,2),
   businessLat DECIMAL(5,2),
   businessName VARCHAR(64) NOT NULL,
   businessUrl VARCHAR(256) NOT NULL,
   UNIQUE(businessLng),
   UNIQUE(businessLat),
   INDEX(businessAddress),
   PRIMARY KEY(businessId)
);


CREATE TABLE behavior(
   behaviorId BINARY(16) NOT NULL,
   behaviorBuisnessId BINARY(16) NOT NULL,
   behaviorProfileId BINARY(16) NOT NULL,
	behaviorContent VARCHAR(200) NOT NULL,
	behaviorDate DATETIME(6) NOT NULL,
	behaviorType BOOLEAN NOT NULL,
	INDEX(behaviorBuisnessId),
	INDEX(behaviorProfileId),
	FOREIGN KEY(behaviorBuisnessId) REFERENCES business(businessId),
	FOREIGN KEY(behaviorProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(behaviorId)
);


CREATE TABLE vote(
	voteId BINARY(16)NOT NULL,
	voteProfileId BINARY(16) NOT NULL,
	voteBehaviorId BINARY(16) NOT NULL,
	voteDate DATETIME(6) NOT NULL,
	voteResult BOOLEAN NOT NULL,
	INDEX(voteProfileId),
	INDEX(voteBehaviorId),
	FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(voteBehaviorId) REFERENCES behavior(behaviorId)
);