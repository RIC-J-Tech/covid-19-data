
USE cap28_covid_test;

DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS behavior;
DROP TABLE IF EXISTS business;
DROP TABLE IF EXISTS profile;


CREATE TABLE profile(
	profileId BINARY(16) NOT NULL,
	profileCloudinaryId VARCHAR(32),
	profileActivationToken CHAR(32),
	profileAvatarUrl VARCHAR(256) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profilePhone VARCHAR(32),
	profileUsername VARCHAR(32) NOT NULL,
	UNIQUE(profilePhone),
	UNIQUE(profileEmail),
	UNIQUE(profileUsername),
	INDEX(profileUsername),
	PRIMARY KEY(profileId)
);


CREATE TABLE business(
   businessId BINARY(16) NOT NULL,
   businessYelpId VARCHAR(32) NOT NULL,
   businessLng DECIMAL(11,8),
   businessLat DECIMAL(11,8),
   businessName VARCHAR(128) NOT NULL,
   businessUrl VARCHAR(256) NOT NULL,
   INDEX(businessName),
   PRIMARY KEY(businessId)
);


CREATE TABLE behavior(
   behaviorId BINARY(16) NOT NULL,
	behaviorBusinessId BINARY(16) NOT NULL,
   behaviorProfileId BINARY(16) NOT NULL,
	behaviorContent VARCHAR(256) NOT NULL,
	behaviorDate DATETIME(6) NOT NULL,
	INDEX(behaviorBusinessId),
	INDEX(behaviorProfileId),
	FOREIGN KEY(behaviorBusinessId) REFERENCES business(businessId),
	FOREIGN KEY(behaviorProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(behaviorId)
);


CREATE TABLE `vote` (
	-- these are not auto_increment because they're still foreign keys
	voteBehaviorId BINARY(16) NOT NULL,
	voteProfileId BINARY(16) NOT NULL,
	voteDate DATETIME(6) NOT NULL,	-- index the foreign keys
	INDEX(voteProfileId),
	INDEX(voteBehaviorId),
	-- create the foreign key relations
	FOREIGN KEY(voteBehaviorId) REFERENCES behavior(behaviorId),
	FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
	-- finally, create a composite foreign key with the two foreign keys
	PRIMARY KEY(voteProfileId, voteBehaviorId)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE report(
   reportId BINARY(16) NOT NULL,
   reportBusinessId BINARY(16) NOT NULL,
   reportProfileId BINARY(16) NOT NULL,
	reportContent TEXT NOT NULL,
	reportDate DATETIME(6) NOT NULL,
	INDEX(reportBusinessId),
	INDEX(reportProfileId),
	FOREIGN KEY(reportBusinessId) REFERENCES business(businessId),
	FOREIGN KEY(reportProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(reportId)
);